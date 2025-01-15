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
        // Retrieve the filter values from the query string
        $selectedMake = $request->query('make');
        $selectedModel = $request->query('model');
        $selectedBodyType = $request->query('body_type');
        $selectedBuildDate = $request->query('build_date');
        $selectedAuctionName = $request->query('auction_name');
        $selectedLocation = $request->query('location');

        // Start the query
        $query = Auctions::query();

        // Apply filters if they are present
        if ($selectedMake) {
            $query->where('make', $selectedMake);
        }
        if ($selectedModel) {
            $query->where('model', $selectedModel);
        }
        if ($selectedBodyType) {
            $query->where('body_type', $selectedBodyType);
        }
        if ($selectedBuildDate) {
            $query->where('build_date', $selectedBuildDate);
        }
        if ($selectedAuctionName) {
            $query->where('auctioneer', $selectedAuctionName);
        }
        if ($selectedLocation) {
            $query->where('state', $selectedLocation);
        }

        // Paginate the filtered results
        $auctions = $query->paginate(30);

        // Get unique makes, models, body types, build dates, etc.
        $makes = Auctions::pluck('make')->unique();
        $models = Auctions::pluck('model')->unique();
        $bodyTypes = Auctions::pluck('body_type')->unique();
        $buildDates = Auctions::pluck('build_date')->unique();
        $auctionNames = Auctions::pluck('auctioneer')->unique();
        $locations = Auctions::pluck('state')->unique();

        // Total count of auctions
        $totalcount = Auctions::count();

        // Pass the data to the view
        return view('auctions.index', compact(
            'auctions',
            'totalcount',
            'models',
            'makes',
            'bodyTypes',
            'buildDates',
            'auctionNames',
            'locations',
            'selectedMake',
            'selectedModel',
            'selectedBodyType',
            'selectedBuildDate',
            'selectedAuctionName',
            'selectedLocation'
        ));
    }


    


}
