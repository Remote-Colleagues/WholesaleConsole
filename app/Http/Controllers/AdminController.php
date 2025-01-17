<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Auctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



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
        $users = User::select('id', 'name', 'email','status') // Select only specific fields
        ->with('consoler')
            ->where('user_type', 'consoler') // Filter by user_type
            ->get();
        return view('admin.consolerlist', compact('users'));
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
    public function import(Request $request)
    {
        $request->validate([
            'csvFile' => 'required|mimes:csv,txt|max:2048',
        ]);

        $duplicateIdentifiers = [];

        try {
            $file = $request->file('csvFile');
            $data = array_map('str_getcsv', file($file->getRealPath()));

            $headers = array_map('trim', $data[0]);
            unset($data[0]);

            foreach ($data as $row) {
                $row = array_combine($headers, $row);

                $uniqueIdentifier = $row['unique_identifier'] ?? null;
                // Check if the unique_identifier exists in the database
                $existingRecord = Auctions::where('unique_identifier', $uniqueIdentifier)->first();

                if ($existingRecord) {
                    // If the record exists, update it
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
                        'hours' => $row['hours'] ?? null,
                        'state' => $row['state'] ?? null,
                        'link_to_auction' => $row['link_to_auction'] ?? null,
                        'other_specs' => $row['other_specs'] ?? null,
                        'vin' => $row['vin'] ?? null,
                        'auction_registration_link' => $row['auction_registration_link'] ?? null,
                        'current_market_retail' => $row['current_market_retail'] ?? null,
                    ]);

                    // Calculate and update the deadline
                    $hours = $existingRecord->hours ?? 0; // Default to 0 if no hours are set
                    $updatedAt = \Carbon\Carbon::parse($existingRecord->updated_at);
                    $deadline = $updatedAt->addHours($hours)->toDateTimeString(); // Add hours to updated_at
                    $existingRecord->update(['deadline' => $deadline]);

                    // Explicitly update the 'updated_at' column using touch()
                    $existingRecord->touch();  // This will update 'updated_at'

                    // Add the duplicate identifier to the list
                    $duplicateIdentifiers[] = $uniqueIdentifier;
                } else {
                    // If no record is found, create a new record
                    $newRecord = Auctions::create([
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
                        'hours' => $row['hours'] ?? null,
                        'state' => $row['state'] ?? null,
                        'link_to_auction' => $row['link_to_auction'] ?? null,
                        'other_specs' => $row['other_specs'] ?? null,
                        'vin' => $row['vin'] ?? null,
                        'auction_registration_link' => $row['auction_registration_link'] ?? null,
                        'current_market_retail' => $row['current_market_retail'] ?? null,
                    ]);

                    // Calculate and set the deadline for new records
                    $hours = $newRecord->hours ?? 0; // Default to 0 if no hours are set
                    $updatedAt = \Carbon\Carbon::parse($newRecord->updated_at);
                    $deadline = $updatedAt->addHours($hours)->toDateTimeString(); // Add hours to updated_at
                    $newRecord->update(['deadline' => $deadline]);
                }
            }

            // Redirect with the list of duplicates so we can show a modal or notification
            return redirect()->route('auctions.index')->with('duplicates', $duplicateIdentifiers);

        } catch (\Exception $e) {
            return back()->with('error', 'Error uploading CSV file');
        }
    }



}
