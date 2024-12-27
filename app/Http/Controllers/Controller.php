<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->user_type == 'admin') {
                session(['is_admin' => true]);
                session(['is_consoler' => false]);
                session(['is_partner' => false]);
                return redirect()->route('admin.dashboard')->with('success', 'Welcome to the admin dashboard!');
            } elseif ($user->user_type == 'consoler') {
                session(['is_admin' => false]);
                session(['is_consoler' => true]);
                session(['is_partner' => false]);
                return redirect()->route('consoler.dashboard')->with('success', 'Welcome to the consoler dashboard!');
            } else {
                session(['is_admin' => false]);
                session(['is_consoler' => false]);
                session(['is_partner' => true]);
                return redirect()->route('partner.dashboard')->with('success', 'Welcome to the partner dashboard!');
            }
        }

        return back()->with('error', 'Invalid login credentials.');
    }


    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|in:partner,consoler',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Registration successful. Please log in.');
    }

    /**
     * Handle the logout request.
     */
    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('login.form')->with('success', 'Logged out successfully!');
    }
    
}
