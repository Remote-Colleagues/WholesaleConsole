<?php

namespace App\Http\Controllers;

use App\Models\Auctions;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Consoler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
        // Validate the incoming data
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
        $user = User::where('id', $id)
//             ->where('user_type', 'consoler')
            ->with('consoler')
            ->firstOrFail();
        return view('admin.consolerDetails', compact('user'));
    }

    public function showdetail($id)
    {
        $user = User::where('id', $id)
            ->with('consoler')
            ->firstOrFail();

        // Return the consoler details view with the user data
        return view('consoler.consolerDetails', compact('user'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $consoler = Consoler::where('user_id', $user->id)->firstOrFail();

        return view('consoler.update', compact('user', 'consoler'));
    }


    public function update(Request $request, $id)
    {
        // Find the consoler and associated user
        $consoler = Consoler::findOrFail($id);
        $user = User::findOrFail($consoler->user_id);

        // Validate incoming data
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

            // Update consoler details
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

            if ($request->hasFile('your_agreement')) {
                $agreementPath = $request->file('your_agreement')->store('agreements', 'public');
                $consolerData['your_agreement'] = $agreementPath;
            }

            $consoler->update($consolerData);

            return redirect()->route('consoler.list')->with('success', 'Consoler updated successfully!');
        } catch (\Exception $e) {
            // Log the error and redirect with an error message
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
