<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Invoice;
use setasign\Fpdi\Fpdi;
use App\Models\Auctions;
use App\Models\Consoler;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ConsolerController extends Controller
{
    public function create()
    {
        if (session('is_admin')) {
            return view('consoler.consoler_create');
        }
        return redirect()->route('login.form')->with('error', 'You must be logged in as an admin to access this page.');
    }
    public function agreement($id)
    {
        $consoler = Consoler::where('user_id', $id)->firstOrFail();
        $user = User::findOrFail($consoler->user_id);
        $admin = Admin::first();
        if ($user->status !== 'active') {
            Auth::logout();
            session()->flush();
            return redirect('/')->withErrors(['error' => 'Your account is inactive. Please contact the admin.']);
        }
        if ($user->email_verified_at !== null) {
            return redirect()->route('consoler.dashboard');
        }
        return view('consoler.agreement', compact('consoler', 'user','admin'));
    }
    public function submit(Request $request , $id)
    {
        $user = User::findOrFail($id);
        $user->email_verified_at =Carbon:: now();
        $user->save();
        return redirect()->route('consoler.dashboard')->with('status', 'Agreement accepted successfully!');
    }

    public function Dashboard()
    {
        if (session()->has('is_consoler') && session('is_consoler')) {
            $user = session('user');
            return view('consoler.dashboard', compact('user'));
        }

        return redirect()->route('login.form')->with('error', 'You must be logged in as a consoler to access the dashboard.');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'console_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_phone_number' => 'required|string|max:20',
            'abn_number' => 'required|string|max:11',
            'building' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'post_code' => 'nullable|string|max:10',
            'your_agreement' => 'required|file|mimes:pdf|max:10240', // Max 10 MB
            'billing_commencement_period' => 'nullable|date',
            'establishment_fee' => 'nullable|numeric',
            'monthly_subscription_fee' => 'nullable|numeric',
            'admin_fee' => 'nullable|numeric',
            'comm_charge' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $agreementFullPath = null;
        if ($request->hasFile('your_agreement')) {
            $agreementPath = $request->file('your_agreement')->store('agreements', 'public');
            $agreementFullPath = url('storage/' . $agreementPath); // Generate full URL
        }
        $address = "{$request->building}, {$request->city}, {$request->state}, {$request->country}, {$request->post_code}";
        $apiKey = env('LOCATIONIQ_API_KEY');
        $response = Http::get("https://us1.locationiq.com/v1/search.php", [
            'key' => $apiKey,
            'q' => $address,
            'format' => 'json'
        ]);

        $data = $response->json();
        $latitude = $data[0]['lat'] ?? null;
        $longitude = $data[0]['lon'] ?? null;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'consoler',
            'user_type' => 'consoler',
        ]);
        Consoler::create([
            'user_id' => $user->id,
            'console_name' => $request->console_name,
            'contact_person' => $request->contact_person,
            'contact_phone_number' => $request->contact_phone_number,
            'abn_number' => $request->abn_number,
            'building' => $request->building,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'post_code' => $request->post_code,
            'your_agreement' => $agreementFullPath,
            'billing_commencement_period' => $request->billing_commencement_period,
            'currency' => 'AUD',
            'establishment_fee' => $request->establishment_fee,
            'establishment_fee_date' => $request->establishment_fee_date,
            'monthly_subscription_fee' => $request->monthly_subscription_fee,
            'monthly_subscription_fee_date' => $request->monthly_subscription_fee_date,
            'admin_fee' => $request->admin_fee,
            'admin_fee_date' => $request->admin_fee_date,
            'comm_charge' => $request->comm_charge,
            'comm_charge_date' => $request->comm_charge_date,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
        return redirect()->route('consoler.list')->with('success', 'Consoler added successfully!');
    }

    public function index()
    {
        $consolers = Consoler::all();
        return view('admin.consolerlist', compact('consolers'));
    }

    public function show($id)
    {
        $admin = Admin::first();
        $user = User::where('id', $id)
            ->with('consoler')
            ->firstOrFail();
        return view('admin.consolerDetails', compact('user','admin'));
    }

    public function viewAgreementPdf($id, $agreement)
    {
        $user = User::findOrFail($id);
        $agreementTitle = ['master' => 'Master Agreement', 'term' => 'Terms and Conditions', 'services' => 'Service Schedule Agreement'][$agreement] ?? 'Agreement';
        $admin = Admin::first();
        $serviceSchedule = $user->consoler->your_agreement ?? null;
        $master = $admin->master_agreement_for_wconsoler ?? null;
        $term = $admin->terms_conditions_wc_consolers ?? null;
        $agreementsData = [
            'master' => $master ? storage_path('app/public/term/' . basename($master)) : null,
            'term' => $term ? storage_path('app/public/term/' . basename($term)) : null,
            'services' => $serviceSchedule ? storage_path('app/public/agreements/' . basename($serviceSchedule)) : null,
        ];
        if (!array_key_exists($agreement, $agreementsData) || !$agreementsData[$agreement]) {
            abort(404, 'Agreement not found');
        }
        $firstPage = PDF::loadView('admin.agreement', compact('user', 'agreementTitle', 'agreementsData'));
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


    public function showdetail($id)
    {
        $admin = Admin::first();
        $user = User::where('id', $id)
            ->with('consoler')
            ->firstOrFail();
        return view('consoler.consolerDetails', compact('user','admin'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $consoler = Consoler::where('user_id', $user->id)->firstOrFail();
        return view('consoler.update', compact('user', 'consoler' ));
    }


    public function update(Request $request, $id)
    {
        $consoler = Consoler::findOrFail($id);
        $user = User::findOrFail($consoler->user_id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'status' => 'required|in:active,inactive',
            'console_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_phone_number' => 'required|string|max:20',
            'abn_number' => 'required|string|max:11',
            'building' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'post_code' => 'required|string|max:10',
            'your_agreement' => 'nullable|file|mimes:pdf',
            'billing_commencement_period' => 'nullable|date',
            'establishment_fee' => 'nullable|numeric|min:0',
            'establishment_fee_date' => 'nullable|date',
            'monthly_subscription_fee' => 'nullable|numeric|min:0',
            'monthly_subscription_fee_date' => 'nullable|date',
            'admin_fee' => 'nullable|numeric|min:0',
            'admin_fee_date' => 'nullable|date',
            'comm_charge' => 'nullable|numeric|min:0',
            'comm_charge_date' => 'nullable|date',
        ]);

        // Get the full address
        $address = "{$request->building}, {$request->city}, {$request->state}, {$request->country}, {$request->post_code}";
        $apiKey = env('LOCATIONIQ_API_KEY');

        // Make a request to LocationIQ to get latitude and longitude
        $response = Http::get("https://us1.locationiq.com/v1/search.php", [
            'key' => $apiKey,
            'q' => $address,
            'format' => 'json'
        ]);

        $data = $response->json();
        $latitude = $data[0]['lat'] ?? null;
        $longitude = $data[0]['lon'] ?? null;

        $user->email_verified_at = null;

        try {
            // Update user details
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'status' => $validatedData['status'],
            ]);

            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
                $user->save();
            }

            // Prepare consoler data for update
            $consolerData = [
                'console_name' => $validatedData['console_name'],
                'contact_person' => $validatedData['contact_person'],
                'contact_phone_number' => $validatedData['contact_phone_number'],
                'abn_number' => $validatedData['abn_number'],
                'building' => $validatedData['building'],
                'city' => $validatedData['city'],
                'state' => $validatedData['state'],
                'country' => $validatedData['country'],
                'post_code' => $validatedData['post_code'],
                'latitude' => $latitude, // Update latitude
                'longitude' => $longitude, // Update longitude
                'billing_commencement_period' => $validatedData['billing_commencement_period'],
                'establishment_fee' => $validatedData['establishment_fee'],
                'establishment_fee_date' => $validatedData['establishment_fee_date'],
                'monthly_subscription_fee' => $validatedData['monthly_subscription_fee'],
                'monthly_subscription_fee_date' => $validatedData['monthly_subscription_fee_date'],
                'admin_fee' => $validatedData['admin_fee'],
                'admin_fee_date' => $validatedData['admin_fee_date'],
                'comm_charge' => $validatedData['comm_charge'],
                'comm_charge_date' => $validatedData['comm_charge_date'],
            ];

            // Check if the 'your_agreement' file is provided and store it
            if ($request->hasFile('your_agreement')) {
                $agreementPath = $request->file('your_agreement')->store('agreements', 'public');
                $consolerData['your_agreement'] = $agreementPath;
            }

            // Update the consoler details
            $consoler->update($consolerData);

            return redirect()->route('consoler.list')->with('success', 'Consoler updated successfully!');
        } catch (\Exception $e) {
            // Log the error and return an error message
            Log::error('Consoler Update Failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to update consoler. Please try again.']);
        }
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
        return view('consoler.auctioncar', [
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
        $consolerInvoices = Invoice::where('user_id', $id)
            ->where('status', '!=', 'hide')
            ->paginate(6);
        return view('consoler.invoice', compact('consolerInvoices'));
    }

}
