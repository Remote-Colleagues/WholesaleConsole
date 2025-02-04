<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Auctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Shortlist;
use Illuminate\Support\Facades\Auth;



class AdminController extends Controller
{
    public function show()
    {
        $admin = Admin::with('user')->where('user_id', auth()->id())->firstOrFail();
        return view('admin.profile', ['admin' => $admin, 'user' => $admin->user]);
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $user = User::findOrFail($admin->user_id);

        return view('admin.edit', compact('admin', 'user'));
    }

    public function update(Request $request, $id)
    {
        // Find the admin record and the associated user
        $admin = Admin::findOrFail($id);
        $user = $admin->user;

        // Validation for updating the admin profile and user email
            $validatedData=$request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone_number' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'abn_number' => 'nullable|string|max:50',
            'banking_detail' => 'nullable|string|max:255',
            'bsb_number' => 'nullable|string|max:20',
            'terms_conditions_wc_partners' => 'nullable|file|mimes:pdf|max:10240',
            'terms_conditions_wc_consolers' => 'nullable|file|mimes:pdf|max:10240',
            'privacy_policy_for_all' => 'nullable|file|mimes:pdf|max:10240',
            'master_agreement_for_wconsoler' => 'nullable|file|mimes:pdf|max:10240',
            'master_agreement_for_partners' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Update admin details
        $admin->update([
            'name' => $validatedData['name'],
            'contact_person' => $validatedData['contact_person'] ?? $admin->contact_person,
            'contact_phone_number' => $validatedData['contact_phone_number'] ?? $admin->contact_phone_number,
            'abn_number' => $validatedData['abn_number'] ?? $admin->abn_number,
            'banking_detail' => $validatedData['banking_detail'] ?? $admin->banking_detail,
            'bsb_number' => $validatedData['bsb_number'] ?? $admin->bsb_number,
        ]);

        // Update user details (email)
        $user->update(['email' => $request->email]);

        // Handle file uploads
        if ($request->hasFile('terms_conditions_wc_partners')) {
            $admin->terms_conditions_wc_partners = $request->file('terms_conditions_wc_partners')->store('term', 'public');
        }

        if ($request->hasFile('terms_conditions_wc_consolers')) {
            $admin->terms_conditions_wc_consolers = $request->file('terms_conditions_wc_consolers')->store('term', 'public');
        }

        if ($request->hasFile('privacy_policy_for_all')) {
            $admin->privacy_policy_for_all = $request->file('privacy_policy_for_all')->store('term', 'public');
        }

        if ($request->hasFile('master_agreement_for_wconsoler')) {
            $admin->master_agreement_for_wconsoler = $request->file('master_agreement_for_wconsoler')->store('term', 'public');
        }

        if ($request->hasFile('master_agreement_for_partners')) {
            $admin->master_agreement_for_partners = $request->file('master_agreement_for_partners')->store('term', 'public');
        }

        // Save the admin record after updating
        $admin->save();

        // Redirect back with success message
        return redirect()->route('admin.profile', $admin->id)->with('success', 'Profile updated successfully.');
    }

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
        if (session()->has('is_admin') && session('is_admin')) {

            $auctionData = Auctions::select('state', DB::raw('COUNT(*) as count'))
                ->groupBy('state')
                ->get();
            $mapData = $auctionData->map(function ($item) {
                return [
                    'hc-key' => $this->getRegionKeyByLocation($item->state),
                    'value' => $item->count,
                    'name' => $item->state
                ];
            });
            $user = User::find(auth()->user()->id);

            return view('admin.dashboard',compact('auctionData','mapData','user'));
        }
        return redirect()->route('login.form')->with('error', 'You must be logged in to access the dashboard');
    }

    private function getRegionKeyByLocation($state)
    {
        $locationMap = [
            'NSW' => 'au-nsw',  // New South Wales
            'VIC' => 'au-vic',  // Victoria
            'WA' => 'au-wa',    // Western Australia (add more if necessary)
            'NT' => 'au-nt',    // Northern Territory
            'SA' => 'au-sa',    // South Australia
            'QLD' => 'au-qld',  // Queensland
            'TAS' => 'au-tas'   // Tasmania
        ];

        return $locationMap[$state] ?? null;  // Return null if no match
    }

    public function consolerList()
    {
        $users = User::select('id', 'name', 'email' ,'status')
            ->where('user_type', 'consoler')
            ->with('consoler')
            ->paginate(10);


        return view('admin.consolerlist', compact('users'));
    }
    public function import(Request $request)
    {
        $request->validate([
            'csvFile' => 'required|mimes:csv,txt|max:2048',
        ]);

        $duplicateIdentifiers = [];
        $newIdentifiers = [];

        try {
            $file = $request->file('csvFile');
            $data = array_map('str_getcsv', file($file->getRealPath()));

            $headers = array_map('trim', $data[0]);
            unset($data[0]);

            foreach ($data as $row) {
                $row = array_combine($headers, $row);

                $uniqueIdentifier = $row['unique_identifier'] ?? null;
                $existingRecord = Auctions::where('unique_identifier', $uniqueIdentifier)->first();

                $hours = isset($row['hours']) && is_numeric($row['hours']) ? (float)$row['hours'] : 0;
                $deadline = $hours > 0 ? now()->addHours($hours) : now();

                if ($existingRecord) {
                    // Update the existing record
                    $existingRecord->update([
                        'name' => $row['name'] ?? null,
                        'make' => $row['make'] ?? null,
                        'model' => $row['model'] ?? null,
                        'build_date' => isset($row['build_date']) ? \Carbon\Carbon::parse($row['build_date']) : null,
                        'odometer' => $row['odometer'] ?? null,
                        'body_type' => $row['body_type'] ?? null,
                        'fuel' => $row['fuel'] ?? null,
                        'transmission' => $row['transmission'] ?? null,
                        'seats' => $row['seats'] ?? null,
                        'auctioneer' => $row['auctioneer'] ?? null,
                        'hours' => $hours,
                        'deadline' => $deadline,
                        'state' => $row['state'] ?? null,
                        'link_to_auction' => $row['link_to_auction'] ?? null,
                        'other_specs' => $row['other_specs'] ?? null,
                        'vin' => $row['vin'] ?? null,
                        'auction_registration_link' => $row['auction_registration_link'] ?? null,
                        'current_market_retail' => $row['current_market_retail'] ?? null,
                    ]);

                    $duplicateIdentifiers[] = $uniqueIdentifier;
                } else {
                    // Insert new record
                    Auctions::create([
                        'unique_identifier' => $uniqueIdentifier,
                        'name' => $row['name'] ?? null,
                        'make' => $row['make'] ?? null,
                        'model' => $row['model'] ?? null,
                        'build_date' => isset($row['build_date']) ? \Carbon\Carbon::parse($row['build_date']) : null,
                        'odometer' => $row['odometer'] ?? null,
                        'body_type' => $row['body_type'] ?? null,
                        'fuel' => $row['fuel'] ?? null,
                        'transmission' => $row['transmission'] ?? null,
                        'seats' => $row['seats'] ?? null,
                        'auctioneer' => $row['auctioneer'] ?? null,
                        'hours' => $hours,
                        'deadline' => $deadline,
                        'state' => $row['state'] ?? null,
                        'link_to_auction' => $row['link_to_auction'] ?? null,
                        'other_specs' => $row['other_specs'] ?? null,
                        'vin' => $row['vin'] ?? null,
                        'auction_registration_link' => $row['auction_registration_link'] ?? null,
                        'current_market_retail' => $row['current_market_retail'] ?? null,
                    ]);

                    $newIdentifiers[] = $uniqueIdentifier;
                }
            }

            // Flash message for updated and inserted records
            $message = '';
            if (count($duplicateIdentifiers) > 0) {
                $message .= 'Updated Auctions: ' . implode(', ', $duplicateIdentifiers) . '. ';
            }
            if (count($newIdentifiers) > 0) {
                $message .= 'New Auctions: ' . implode(', ', $newIdentifiers) . '.';
            }

            return redirect()->route('auctions.index')->with('message', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Error uploading CSV file');
        }
    }

    public function editAuction($id)
{
    $auction = Auctions::findOrFail($id);
    $makes = Auctions::pluck('make')->unique();
    $models = Auctions::pluck('model')->unique();
    $bodyTypes = Auctions::pluck('body_type')->unique();
    $buildDates = Auctions::pluck('build_date')->unique();
    $locations = Auctions::pluck('state')->unique();
    $auctionNames = Auctions::pluck('auctioneer')->unique();

    return view('auctions.edit', compact('auction', 'makes', 'models', 'bodyTypes', 'buildDates', 'locations', 'auctionNames'));
}

public function updateAuction(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'make' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'build_date' => 'nullable|date',
        'odometer' => 'nullable|integer',
        'body_type' => 'nullable|string|max:255',
        'fuel' => 'nullable|string|max:255',
        'transmission' => 'nullable|string|max:255',
        'seats' => 'nullable|integer',
        'auctioneer' => 'nullable|string|max:255',
        'hours' => 'nullable|numeric|min:0',
        'state' => 'nullable|string|max:255',
        'link_to_auction' => 'nullable|url',
        'vin' => 'nullable|string|max:255',
        'auction_registration_link' => 'nullable|url',
        'current_market_retail' => 'nullable|numeric',
    ]);

    $auction = Auctions::findOrFail($id);

    $hours = $request->input('hours', '0');
    $numericHours = is_numeric($hours) ? (float) $hours : 0;
    $deadline = $numericHours > 0 ? now()->addHours($numericHours) : now();

    $auction->update([
        'name' => $request->input('name'),
        'make' => $request->input('make'),
        'model' => $request->input('model'),
        'build_date' => $request->input('build_date') ? \Carbon\Carbon::parse($request->input('build_date')) : null,
        'odometer' => $request->input('odometer'),
        'body_type' => $request->input('body_type'),
        'fuel' => $request->input('fuel'),
        'transmission' => $request->input('transmission'),
        'seats' => $request->input('seats'),
        'auctioneer' => $request->input('auctioneer'),
        'hours' => $hours,
        'deadline' => $deadline,
        'state' => $request->input('state'),
        'link_to_auction' => $request->input('link_to_auction'),
        'vin' => $request->input('vin'),
        'auction_registration_link' => $request->input('auction_registration_link'),
        'current_market_retail' => $request->input('current_market_retail'),
    ]);
    return redirect()->route('auctions.index')->with('success', 'Auction updated successfully!');


}
    public function showAllAuctions(Request $request)
{
    $selectedMake = $request->query('make');
    $selectedModel = $request->query('model');
    $selectedBodyType = $request->query('body_type');
    $selectedBuildDate = $request->query('build_date');
    $selectedAuctionName = $request->query('auction_name');
    $selectedLocation = $request->query('location');

    // Build the base query with applied filters
    $query = Auctions::query();

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

    // Fetch makes, models, body types, etc. for the dropdowns
    $makes = Auctions::pluck('make')->unique();
    $models = Auctions::pluck('model')->unique();
    $bodyTypes = Auctions::pluck('body_type')->unique();
    $buildDates = Auctions::pluck('build_date')->unique();
    $auctionNames = Auctions::pluck('auctioneer')->unique();
    $locations = Auctions::pluck('state')->unique();

    $totalcount = Auctions::count();

    $activeTab = $request->query('tab', 'active-auctions');

    // Active auctions query
    $activeAuctions = Auctions::where(function ($query) use ($selectedMake, $selectedModel, $selectedBodyType, $selectedBuildDate, $selectedAuctionName, $selectedLocation) {
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
    })
    ->whereRaw('DATE_ADD(updated_at, INTERVAL hours HOUR) > NOW()')
->selectRaw("*, DATE_FORMAT(DATE_ADD(updated_at, INTERVAL hours HOUR), '%Y/%m/%d %H:%i:%s') as formatted_deadline")
->orderBy('formatted_deadline')
->paginate(30)
->appends(array_merge(request()->query(), ['tab' => 'active-auctions']));

    // Past auctions query
    $pastAuctions = Auctions::where(function ($query) use ($selectedMake, $selectedModel, $selectedBodyType, $selectedBuildDate, $selectedAuctionName, $selectedLocation) {
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
    })
    ->whereRaw('DATE_ADD(updated_at, INTERVAL hours HOUR) <= NOW()')
->selectRaw("*, DATE_FORMAT(DATE_ADD(updated_at, INTERVAL hours HOUR), '%Y/%m/%d %H:%i:%s') as formatted_deadline")
->orderBy('formatted_deadline', 'desc')
->paginate(30)
->appends(array_merge(request()->query(), ['tab' => 'past-auctions']));  // Ensure the tab is active

    return view('auctions.index', compact(
        'activeAuctions',
        'pastAuctions',
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
        'selectedLocation',
        'activeTab'
    ));
}


public function shortlistAuction(Request $request, $id)
{
    if (!Auth::check()) {
        return response()->json(['success' => false, 'message' => 'User is not authenticated.'], 401);
    }

    $userId = Auth::id(); // Get logged-in user ID

    // Find the auction based on the given ID
    $auction = Auctions::findOrFail($id);

    // Check if already shortlisted to prevent duplicates
    if (Shortlist::where('auction_id', $id)->where('user_id', $userId)->exists()) {
        return response()->json(['success' => false, 'message' => 'This auction is already shortlisted.']);
    }

    // Use a transaction to ensure both operations succeed or fail together
    DB::beginTransaction();

    try {
        // Create a new shortlist entry
        $shortlist = new Shortlist([
            'user_id' => $userId,
            'auction_id' => $auction->id,
            'name' => $auction->name,
            'make' => $auction->make,
            'model' => $auction->model,
            'build_date' => $auction->build_date,
            'odometer' => $auction->odometer,
            'body_type' => $auction->body_type,
            'fuel' => $auction->fuel,
            'transmission' => $auction->transmission,
            'seats' => $auction->seats,
            'auctioneer' => $auction->auctioneer,
            'link_to_auction' => $auction->link_to_auction,
            'other_specs' => $auction->other_specs,
            'unique_identifier' => $auction->unique_identifier,
            'state' => $auction->state,
            'vin' => $auction->vin,
            'hours' => $auction->hours,
            'deadline' => $auction->deadline,
        ]);

        $shortlist->save(); // Save shortlist




        // Commit the transaction
        DB::commit();


        return redirect()->route('auctions.index')->with('success', 'Auction successfully shortlisted and removed from the auctions.');

    } catch (\Exception $e) {
        // Rollback transaction if there is an error
        DB::rollBack();

        return redirect()->route('auctions.index')->with('error', 'Something went wrong. Please try again.');
    }
}



public function unshortlistAuction($id)
{
    if (!Auth::check()) {
        return response()->json(['success' => false, 'message' => 'User is not authenticated.'], 401);
    }

    $user = Auth::id(); // Get logged-in user ID

    // Find the shortlist record for the auction
    $shortlist = Shortlist::where('auction_id', $id)
                          ->where('user_id', $user)
                          ->firstOrFail();

    // Get auction details from the shortlist
    $auction = new Auctions([
        'name' => $shortlist->name,
        'make' => $shortlist->make,
        'model' => $shortlist->model,
        'build_date' => $shortlist->build_date,
        'odometer' => $shortlist->odometer,
        'body_type' => $shortlist->body_type,
        'fuel' => $shortlist->fuel,
        'transmission' => $shortlist->transmission,
        'seats' => $shortlist->seats,
        'auctioneer' => $shortlist->auctioneer,
        'link_to_auction' => $shortlist->link_to_auction,
        'other_specs' => $shortlist->other_specs,
        'unique_identifier' => $shortlist->unique_identifier,
        'state' => $shortlist->state,
        'vin' => $shortlist->vin,
        'hours' => $shortlist->hours,
        'deadline' => $shortlist->deadline,
    ]);

    // Save auction back to Auctions table
    $auction->save();

    // Remove from Shortlist table
    $shortlist->delete();

    return back()->with('success', 'Auction removed from shortlist and restored to auctions.');
}


public function showShortlistedAuctions()
{
    if (!Auth::check()) {
        return response()->json(['success' => false, 'message' => 'User is not authenticated.'], 401);
    }
    $user = Auth::id(); // Get logged-in user ID

// Get shortlisted auctions for the logged-in user
$shortlistedAuctions = Shortlist::where('user_id', $user)
->with('auction', 'user')
->paginate(10);

    return view('auctions.shortlisted', compact('shortlistedAuctions'));
}
}
