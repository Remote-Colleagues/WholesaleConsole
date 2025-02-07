<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Auctions;
use App\Models\Invoice;
use App\Models\Partner;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use setasign\Fpdi\Fpdi;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (session('is_admin')) {
            return view('partner.partner_create');
        }
        return redirect()->route('login.form')->with('error', 'You must be logged in as an admin to access this page.');
    }
    public function partnerList()
    {
        $users = User::select('id', 'name', 'email' ,'status')
            ->where('user_type', 'partner')
            ->with('partner')
            ->get();

        return view('partner.partnerlist', compact('users'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'partner_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_phone_number' => 'required|string|max:20',
            'abn_number' => 'required|string|max:11',
            'operation_location' => 'required|array',
            'operation_location.*.building' => 'required|string|max:255',
            'operation_location.*.city' => 'required|string|max:255',
            'operation_location.*.state' => 'required|string|max:255',
            'operation_location.*.country' => 'required|string|max:255',
            'operation_location.*.post_code' => 'required|string|max:10',
            'premium_charged'=>'nullable|string|max:100',
            'your_agreement' => 'required|file|mimes:pdf|max:10240',
            'billing_commencement_date' => 'nullable|date',
            'establishment_fee' => 'nullable|numeric',
            'monthly_subscription_fee' => 'nullable|numeric',
            'csvusernumber' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle agreement file upload
        $agreementFullPath = null;
        if ($request->hasFile('your_agreement')) {
            $agreementPath = $request->file('your_agreement')->store('agreements', 'public');
            $agreementFullPath = asset('storage/' . $agreementPath);
        }

        // Create user record
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'partner',
            'status' => 'active',
        ]);

        // Process operation locations and coordinates
        $operationLocations = [];
        $latitudes = [];
        $longitudes = [];

        foreach ($request->operation_location as $location) {
            $address = "{$location['building']}, {$location['city']}, {$location['state']}, {$location['country']}, {$location['post_code']}";

            // Fetch latitude and longitude from LocationIQ API
            $apiKey = env('LOCATIONIQ_API_KEY');
            $response = Http::get("https://us1.locationiq.com/v1/search.php", [
                'key' => $apiKey,
                'q' => $address,
                'format' => 'json'
            ]);

            $data = $response->json();
            $latitude = $data[0]['lat'] ?? null;
            $longitude = $data[0]['lon'] ?? null;

            // Only add valid latitude and longitude pairs
            if ($latitude && $longitude) {
                $latitudes[] = $latitude;
                $longitudes[] = $longitude;
            }

            // Store the operation location address (as string)
            $operationLocations[] = "{$location['building']}, {$location['city']}, {$location['state']}, {$location['country']}, {$location['post_code']}";
        }

        // Store latitudes and longitudes as comma-separated values in respective fields
        $latitudeString = implode(';', $latitudes);
        $longitudeString = implode(';', $longitudes);

        // Create partner record with multiple latitudes and longitudes
        Partner::create([
            'partner_name' => $request->partner_name,
            'contact_person' => $request->contact_person,
            'contact_phone_number' => $request->contact_phone_number,
            'abn_number' => $request->abn_number,
            'operation_location' => implode('; ', $operationLocations),
            'latitude' => $latitudeString, // Store multiple latitudes as comma-separated
            'longitude' => $longitudeString, // Store multiple longitudes as comma-separated
            'your_agreement' => $agreementFullPath,
            'billing_commencement_date' => $request->billing_commencement_date,
            'premium_charged'=>$request->premium_charged,
            'establishment_fee' => $request->establishment_fee,
            'monthly_subscription_fee' => $request->monthly_subscription_fee,
            'csvusernumber' => $request->csvusernumber,
            'user_id' => $user->id,
        ]);

        return redirect()->route('partner.list')->with('success', 'Partner added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = Admin::first();
        $user = User::where('id', $id)
            ->with('partner')
            ->firstOrFail();
        $operation_locations = $user->partner->operation_location ?? null;
        if (!is_array($operation_locations)) {
            $operation_locations = explode(';', $operation_locations);
        }
        return view('admin.partnerDetails', compact('user','admin','operation_locations'));
    }
    public function agreement($id)
    {
        $partner = Partner::where('user_id', $id)->firstOrFail();
        $user = User::findOrFail($partner->user_id);
        $admin = Admin::first();
        if ($user->status !== 'active') {
            Auth::logout();
            session()->flush();
            return redirect('/')->withErrors(['error' => 'Your account is inactive. Please contact the admin.']);
        }
        if ($user->email_verified_at !== null) {
            return redirect()->route('partner.dashboard');
        }
        return view('partner.agreement', compact('partner', 'user','admin'));
    }
    public function submit(Request $request , $id)
    {
        $user = User::findOrFail($id);
        $user->email_verified_at =Carbon:: now();
        $user->save();
        return redirect()->route('partner.dashboard')->with('status', 'Agreement accepted successfully!');
    }

    public function Dashboard()
    {
        if (session()->has('is_partner') && session('is_partner')) {
            $user = session('user');
            return view('partner.dashboard', compact('user'));
        }

        return redirect()->route('login.form')->with('error', 'You must be logged in as a partner to access the dashboard.');
    }
    public function showdetail($id)
    {
        $admin = Admin::first();
        $user = User::where('id', $id)
            ->with('partner')
            ->firstOrFail();
        $operation_locations = $user->partner->operation_location ?? null;
        if (!is_array($operation_locations)) {
            $operation_locations = explode(';', $operation_locations);
        }
        return view('partner.partnerDetails', compact('user','admin','operation_locations'));
    }
    public function viewAgreementPdf($id, $agreement)
    {
        $user = User::findOrFail($id);
        $agreementTitle = ['master' => 'Master Agreement', 'term' => 'Terms and Conditions', 'services' => 'Service Schedule Agreement'][$agreement] ?? 'Agreement';
        $admin = Admin::first();
        $serviceSchedule = $user->partner->your_agreement ?? null;
        $master = $admin->master_agreement_for_partners ?? null;
        $term = $admin->terms_conditions_wc_partners ?? null;
        $agreementsData = [
            'master' => $master ? storage_path('app/public/term/' . basename($master)) : null,
            'term' => $term ? storage_path('app/public/term/' . basename($term)) : null,
            'services' => $serviceSchedule ? storage_path('app/public/agreements/' . basename($serviceSchedule)) : null,
        ];
        if (!array_key_exists($agreement, $agreementsData) || !$agreementsData[$agreement]) {
            abort(404, 'Agreement not found');
        }
        $firstPage = PDF::loadView('admin.partneragreement', compact('user', 'agreementTitle', 'agreementsData'));
        $firstPagePath = storage_path('app/public/temp_first_page.pdf');
        $firstPage->save($firstPagePath);
        $pdf = new Fpdi();
        $pdf->AddPage();
        $pdf->setSourceFile($firstPagePath);
        $templateId = $pdf->importPage(1);
        $pdf->useTemplate($templateId);
        $agreementPdfPath = $agreementsData[$agreement];
        $pageCount = $pdf->setSourceFile($agreementPdfPath);
        for ($i = 1; $i <= $pageCount; $i++) {
            $templateId = $pdf->importPage($i);
            $pdf->AddPage();
            $pdf->useTemplate($templateId);
        }
        return response($pdf->Output(), 200)
            ->header('Content-Type', 'application/pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $partner = Partner::where('user_id', $user->id)->firstOrFail();
        $operation_locations = $partner->operation_location ? explode('; ', $partner->operation_location) : [];
        return view('partner.edit', compact('user', 'partner' ,'operation_locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);
        $user = User::findOrFail($partner->user_id);

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, // Exclude the current email
            'password' => 'nullable|string|min:8|confirmed',
            'partner_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_phone_number' => 'required|string|max:20',
            'abn_number' => 'required|string|max:11',
            'operation_location' => 'required|array',
            'operation_location.*.building' => 'nullable|string|max:255',
            'operation_location.*.city' => 'nullable|string|max:255',
            'operation_location.*.state' => 'nullable|string|max:255',
            'operation_location.*.country' => 'nullable|string|max:255',
            'operation_location.*.post_code' => 'nullable|string|max:10',
            'your_agreement' => 'nullable|file|mimes:pdf|max:10240', // Max 10 MB
            'billing_commencement_date' => 'nullable|date',
            'premium_charged'=>'nullable|string|max:1000',
            'establishment_fee' => 'nullable|numeric',
            'monthly_subscription_fee' => 'nullable|numeric',
            'csvusernumber' => 'nullable|string|max:255', // CSV User Number
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email_verified_at = null;
        $user->status = $request->status ?? $user->status;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Handle agreement file upload, if provided
        $agreementFullPath = $partner->your_agreement; // Keep existing agreement path if not updated
        if ($request->hasFile('your_agreement')) {
            $agreementPath = $request->file('your_agreement')->store('agreements', 'public');
            $agreementFullPath = url('storage/' . $agreementPath); // Generate full URL
        }

        // Process operation locations and update latitudes and longitudes
        $operation_locations = [];
        $latitudes = [];
        $longitudes = [];

        if ($request->has('operation_location')) {
            foreach ($request->input('operation_location') as $location) {
                // Generate the operation location string (address)
                $operation_location = implode(', ', array_filter([
                    $location['building'],
                    $location['city'],
                    $location['state'],
                    $location['country'],
                    $location['post_code']
                ]));
                $operation_locations[] = $operation_location ?: 'Not Provided';

                // Fetch latitude and longitude from LocationIQ API
                $address = $operation_location; // Use the generated address for geocoding
                $apiKey = env('LOCATIONIQ_API_KEY');
                $response = Http::get("https://us1.locationiq.com/v1/search.php", [
                    'key' => $apiKey,
                    'q' => $address,
                    'format' => 'json'
                ]);

                $data = $response->json();
                $latitude = $data[0]['lat'] ?? null;
                $longitude = $data[0]['lon'] ?? null;

                // Store the valid latitude and longitude
                if ($latitude && $longitude) {
                    $latitudes[] = $latitude;
                    $longitudes[] = $longitude;
                }
            }
        }

        // Combine latitudes and longitudes as strings
        $latitudeString = implode(';', $latitudes);
        $longitudeString = implode(';', $longitudes);

        // Update partner details with new latitudes, longitudes, and other information
        $partner->partner_name = $request->partner_name;
        $partner->contact_person = $request->contact_person;
        $partner->contact_phone_number = $request->contact_phone_number;
        $partner->abn_number = $request->abn_number;
        $partner->operation_location = implode('; ', $operation_locations); // Store locations as semicolon-separated list
        $partner->latitude = $latitudeString; // Store latitudes as a semicolon-separated string
        $partner->longitude = $longitudeString; // Store longitudes as a semicolon-separated string
        $partner->your_agreement = $agreementFullPath;
        $partner->billing_commencement_date = $request->billing_commencement_date;
        $partner->premium_charged = $request->premium_charged;
        $partner->establishment_fee = $request->establishment_fee;
        $partner->monthly_subscription_fee = $request->monthly_subscription_fee;
        $partner->csvusernumber = $request->csvusernumber;

        // Save partner updates
        $partner->save();

        // Redirect to the partner list with a success message
        return redirect()->route('partner.list')->with('success', 'Partner updated successfully!');
    }


    public function showAllAuctions(Request $request)
    {
        $filters = $request->only(['make', 'model', 'body_type', 'build_date', 'auction_name', 'location']);
        $filters['state'] = $filters['location'] ?? null;
        unset($filters['location']);
        $filterFields = ['make', 'model', 'body_type', 'build_date', 'auctioneer', 'state'];
        $filterOptions = [];
        foreach ($filterFields as $field) {
            $filterOptions[$field] = Auctions::when($filters, function ($q) use ($filters, $field) {
                foreach ($filters as $key => $value) {
                    if ($key !== $field && $value) {
                        $q->where($key, $value);
                    }
                }
            })->pluck($field)->unique();
        }
        $query = Auctions::query();
        foreach ($filters as $key => $value) {
            if ($value) $query->where($key, $value);
        }
        $totalcount = $query->count();
        $auctions = $query->paginate(30)->appends($request->query());
        return view('partner.auctioncar', [
            'auctions' => $auctions,
            'totalcount' => $totalcount,
            'makes' => $filterOptions['make'],
            'models' => $filterOptions['model'],
            'bodyTypes' => $filterOptions['body_type'],
            'buildDates' => $filterOptions['build_date'],
            'auctionNames' => $filterOptions['auctioneer'],
            'locations' => $filterOptions['state'],
            'selectedMake' => $filters['make'] ?? null,
            'selectedModel' => $filters['model'] ?? null,
            'selectedBodyType' => $filters['body_type'] ?? null,
            'selectedBuildDate' => $filters['build_date'] ?? null,
            'selectedAuctionName' => $filters['auction_name'] ?? null,
            'selectedLocation' => $filters['state'] ?? null,
        ]);
    }
    public function showInvoices()
    {
        $id = auth()->id();
        $partnerInvoices = Invoice::where('user_id', $id)
            ->where('status', '!=', 'hide')
            ->paginate(6);
        return view('partner.invoice', compact('partnerInvoices'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}
