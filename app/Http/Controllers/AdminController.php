<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AdminController extends Controller
{
    public function create()
    {
        return view('admin.reg');
    }    
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'contact_person' => 'nullable|numeric',
        'contact_phone_number' => 'nullable|numeric',
        'contact_email' => 'required|email|unique:admins,contact_email',
        'change_password' => 'required|string|min:6',
        'terms_conditions_wc_partners' => 'nullable|string',
        'terms_conditions_wc_consolers' => 'nullable|string',
        'privacy_policy_for_all' => 'required|string',
        'abn_number' => 'nullable|numeric',
        'banking_detail' => 'nullable|string',
    ]);

    $validated['change_password'] = Hash::make($validated['change_password']);

    $admin = Admin::create($validated);

    session(['admin' => $admin]);

    return redirect()->route('admin.dashboard')->with('success', 'Admin registered and logged in successfully!');
}

   

    public function dashboard()
    {
        if (session()->has('admin')) {
            return view('admin.dashboard');
        }

        return redirect()->route('login.form')->with('error', 'You must be logged in to access the dashboard');
    }


    public function consolerList()
    {
        // Fetch all consoler users
        $consolers = User::where('user_type', 'consoler')->get();

        // Pass consoler users to the view
        return view('admin.consolerlist', compact('consolers'));
    }
}
