<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Auctions;
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
        $consolers = User::where('user_type', 'consoler')->get();

        return view('admin.consolerlist', compact('consolers'));
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
        return view('auctions.index', [
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
}
