<?php
namespace App\Http\Controllers;

use App\Models\Consoler;
use Illuminate\Http\Request;

class ConsolerController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'wc_consolers_name' => 'required|string',
            'contact_person' => 'required|string',
            'contact_phone_number' => 'required|numeric',
            'contact_email' => 'required|email',
            'password' => 'required|string',
            'your_agreement' => 'required|boolean',
            'abn_number' => 'required|string',
            'operational_location' => 'nullable|string',
            'comm_charge_for_buyers_connect' => 'required|numeric',
            'billing_commencement_period' => 'required|numeric',
            'admin_fee_for_buyers_connect' => 'required|numeric',
            'establishment_fee' => 'required|numeric',
            'ongoing_monthly_subs_fee' => 'required|numeric',
        ]);

        $consoler = Consoler::create([
            'wc_consolers_name' => $validatedData['wc_consolers_name'],
            'contact_person' => $validatedData['contact_person'],
            'contact_phone_number' => $validatedData['contact_phone_number'],
            'contact_email' => $validatedData['contact_email'],
            'password' => bcrypt($validatedData['password']),
            'your_agreement' => $validatedData['your_agreement'],
            'abn_number' => $validatedData['abn_number'],
            'operational_location' => $validatedData['operational_location'],
            'comm_charge_for_buyers_connect' => $validatedData['comm_charge_for_buyers_connect'],
            'billing_commencement_period' => $validatedData['billing_commencement_period'],
            'admin_fee_for_buyers_connect' => $validatedData['admin_fee_for_buyers_connect'],
            'establishment_fee' => $validatedData['establishment_fee'],
            'ongoing_monthly_subs_fee' => $validatedData['ongoing_monthly_subs_fee'],
        ]);

        return response()->json(['message' => 'Consoler added successfully', 'consoler' => $consoler], 201);
    }

    public function create()
{
    if (session()->has('admin')) {
        return view('consoler.consoler_create');
    }
    return redirect()->route('admin.login.form')->with('error', 'You must be logged in to access create consolers');
}
}

