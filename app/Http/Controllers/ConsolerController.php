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
        dd($consolers);
        return view('admin.consolerlist', compact('consolers'));
    }

    public function show($id)
    {
        $user = User::where('id', $id)
            ->with('consoler') 
            ->firstOrFail();
    
        return view('admin.consolerDetails', compact('user'));
    }
    


    public function viewConsolerDetails($id)
    {
        $consoler = Consoler::find($id);
        $consoler = Consoler::where('user_id', $id)->first();

        return view('admin.consolerDetails', compact('consoler'));
    }
}
