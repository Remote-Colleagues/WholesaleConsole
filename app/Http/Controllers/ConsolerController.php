<?php
namespace App\Http\Controllers;

use App\Models\Consoler;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ConsolerController extends Controller
{
    public function create()
    {
        if (session('is_admin')) {
            return view('consoler.consoler_create');
        }
        return redirect()->route('login.form')->with('error', 'You must be logged in as an admin to access this page.');    }

        public function store(Request $request)
        {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'user_type' => 'required|string',
                'status' => 'required|in:active,deactive',
                'console_name' => 'required_if:user_type,consoler|string|max:255',
                'contact_person' => 'required_if:user_type,consoler|string|max:255',
                'contact_phone_number' => 'required_if:user_type,consoler|string|max:20',
                'abn_number' => 'required_if:user_type,consoler|string|max:20',
                'building' => 'required_if:user_type,consoler|string|max:255',
                'city' => 'required_if:user_type,consoler|string|max:255',
                'state' => 'required_if:user_type,consoler|string|max:255',
                'country' => 'required_if:user_type,consoler|string|max:255',
                'post_code' => 'required_if:user_type,consoler|string|max:10',
                'your_agreement' => 'required_if:user_type,consoler|file|mimes:pdf|max:10240',
                'billing_commencement_period' => 'required_if:user_type,consoler|string|max:255',
                'currency' => 'required_if:user_type,consoler|string|max:255',
                'establishment_fee' => 'required_if:user_type,consoler|numeric',
                'establishment_fee_date' => 'required_if:user_type,consoler|date',
                'monthly_subscription_fee' => 'required_if:user_type,consoler|numeric',
                'monthly_subscription_fee_date' => 'required_if:user_type,consoler|date',
                'admin_fee' => 'required_if:user_type,consoler|numeric',
                'admin_fee_date' => 'required_if:user_type,consoler|date',
                'comm_charge' => 'required_if:user_type,consoler|numeric',
                'comm_charge_date' => 'required_if:user_type,consoler|date',
            ]);
        
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'user_type' => $validated['user_type'],
                'status' => $validated['status'],

            ]);
        
            if ($user->user_type === 'consoler') {
                $agreementPath = null;
                if ($request->hasFile('your_agreement')) {
                    $agreementPath = $request->file('your_agreement')->store('agreements', 'public');
                }
        
                Consoler::create([
                    'user_id' => $user->id,
                    'console_name' => $validated['console_name'],
                    'contact_person' => $validated['contact_person'],
                    'contact_phone_number' => $validated['contact_phone_number'],
                    'abn_number' => $validated['abn_number'],
                    'building' => $validated['building'],
                    'city' => $validated['city'],
                    'state' => $validated['state'],
                    'country' => $validated['country'],
                    'post_code' => $validated['post_code'],
                    'your_agreement' => $agreementPath, 
                    'billing_commencement_period' => $validated['billing_commencement_period'],
                    'currency' => $validated['currency'],
                    'establishment_fee' => $validated['establishment_fee'],
                    'establishment_fee_date' => $validated['establishment_fee_date'],
                    'monthly_subscription_fee' => $validated['monthly_subscription_fee'],
                    'monthly_subscription_fee_date' => $validated['monthly_subscription_fee_date'],
                    'admin_fee' => $validated['admin_fee'],
                    'admin_fee_date' => $validated['admin_fee_date'],
                    'comm_charge' => $validated['comm_charge'],
                    'comm_charge_date' => $validated['comm_charge_date'],
                ]);
            }
        
            return redirect()->route('consoler.list')->with('success', 'User details saved successfully!');
        }
        
        

    
    public function viewConsolerDetails($id)
{
    $consoler = Consoler::find($id);
    $consoler = Consoler::where('user_id', $id)->first();

    return view('admin.consolerDetails', compact('consoler'));
}
}

