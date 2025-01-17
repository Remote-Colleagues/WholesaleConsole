<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Consoler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

        // If validation fails, return back with error messages
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $agreementFullPath = null;
        if ($request->hasFile('your_agreement')) {
            $agreementPath = $request->file('your_agreement')->store('agreements', 'public');
            $agreementFullPath = url('storage/' . $agreementPath); // Generate full URL
        }

        // Store the user data first to get user_id
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'consoler', // Add a default user role for this type of user
        ]);

        // Store the Consoler data
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
            'currency' => 'AUD', // Default currency
            'establishment_fee' => $request->establishment_fee,
            'establishment_fee_date' => $request->establishment_fee_date,
            'monthly_subscription_fee' => $request->monthly_subscription_fee,
            'monthly_subscription_fee_date' => $request->monthly_subscription_fee_date,
            'admin_fee' => $request->admin_fee,
            'admin_fee_date' => $request->admin_fee_date,
            'comm_charge' => $request->comm_charge,
            'comm_charge_date' => $request->comm_charge_date,
        ]);

        // Redirect back with a success message
        return redirect()->route('consoler.list')->with('success', 'Consoler added successfully!');
    }

    public function index()
    {
        $consolers = Consoler::all();
        return view('admin.consolerlist', compact('consolers'));
    }

    // Display the details of a specific Consoler
    public function show($id)
    {
        $user = User::where('id', $id)
            // ->where('role', 'consoler')
            ->with('consoler')
            ->firstOrFail();

        return view('admin.consolerDetails', compact('user'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id); // Fetch user by ID
        $consoler = Consoler::where('user_id', $user->id)->firstOrFail(); // Fetch related consoler details
        return view('consoler.update', compact('user', 'consoler'));
    }


    public function update(Request $request, $id)
    {
        $consoler = Consoler::findOrFail($id);
        $user = User::findOrFail($consoler->user_id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
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

        // Update user details
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->save();

        // Update consoler details
        $consoler->console_name = $validatedData['console_name'];
        $consoler->contact_person = $validatedData['contact_person'];
        $consoler->contact_phone_number = $validatedData['contact_phone_number'];
        $consoler->abn_number = $validatedData['abn_number'];
        $consoler->building = $validatedData['building'];
        $consoler->city = $validatedData['city'];
        $consoler->state = $validatedData['state'];
        $consoler->country = $validatedData['country'];
        $consoler->post_code = $validatedData['post_code'];

        if ($request->hasFile('your_agreement')) {
            $agreementPath = $request->file('your_agreement')->store('agreements', 'public');
            $consoler->your_agreement = $agreementPath;
        }
        $consoler->billing_commencement_period = $validatedData['billing_commencement_period'];
        $consoler->establishment_fee = $validatedData['establishment_fee'];
        $consoler->establishment_fee_date = $validatedData['establishment_fee_date'];
        $consoler->monthly_subscription_fee = $validatedData['monthly_subscription_fee'];
        $consoler->monthly_subscription_fee_date = $validatedData['monthly_subscription_fee_date'];
        $consoler->admin_fee = $validatedData['admin_fee'];
        $consoler->admin_fee_date = $validatedData['admin_fee_date'];
        $consoler->comm_charge = $validatedData['comm_charge'];
        $consoler->comm_charge_date = $validatedData['comm_charge_date'];
        $consoler->save();
        return redirect()->route('consoler.list')->with('success', 'Consoler updated successfully!');
    }


}
