<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Auctions;
use App\Models\Consoler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



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
        // $consolers = User::where('user_type', 'consoler')->get();
        // $consolers = Consoler::all();


        $users = User::select('id', 'name', 'email') // Select only specific fields
            ->with('consoler') // Load related consoler data
            ->get();

        return view('admin.consolerlist', compact('users'));
    }
    
    public function showAllAuctions(Request $request)
    {
        $selectedMake = $request->query('make');
        $selectedModel = $request->query('model');
        $selectedBodyType = $request->query('body_type');
        $selectedBuildDate = $request->query('build_date');
        $selectedAuctionName = $request->query('auction_name');
        $selectedLocation = $request->query('location');

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

        $activeAuctions = $query->whereRaw('DATE_ADD(updated_at, INTERVAL hours HOUR) > NOW()')
            ->selectRaw("*, DATE_FORMAT(DATE_ADD(updated_at, INTERVAL hours HOUR), '%Y/%m/%d %H:%i:%s') as formatted_deadline")
            ->orderBy('formatted_deadline')
            ->paginate(30);

        $pastAuctions = $query->whereRaw('DATE_ADD(updated_at, INTERVAL hours HOUR) <= NOW()')
            ->selectRaw("*, DATE_FORMAT(DATE_ADD(updated_at, INTERVAL hours HOUR), '%Y/%m/%d %H:%i:%s') as formatted_deadline")
            ->orderBy('formatted_deadline')
            ->paginate(30);

        $makes = Auctions::pluck('make')->unique();
        $models = Auctions::pluck('model')->unique();
        $bodyTypes = Auctions::pluck('body_type')->unique();
        $buildDates = Auctions::pluck('build_date')->unique();
        $auctionNames = Auctions::pluck('auctioneer')->unique();
        $locations = Auctions::pluck('state')->unique();

        $totalcount = Auctions::count();

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
            'selectedLocation'
        ));
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
    

}
