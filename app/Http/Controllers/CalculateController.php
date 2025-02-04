<?php

namespace App\Http\Controllers;

use App\Models\Auctions;
use App\Models\Consoler;
use App\Models\Partner;
use App\Models\TransportCalculator;
use App\Models\User;
use Illuminate\Http\Request;

class CalculateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bodyTypes = \DB::table('auctions')->pluck('body_type')->unique();
        $currentBodyType = TransportCalculator::first()->body_type;
        $users = User::all();
        return view('calculate.create', compact('users', 'bodyTypes', 'currentBodyType'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'per_km_charge' => 'required|numeric',
            'same_state_charge' => 'required|numeric',
            'cross_state_charge' => 'required|numeric',
            'additional_charges' => 'required|numeric',
            'additional_charge_for_size' => 'required|numeric',
            'body_type' => 'required|string|unique:transport_calculator,body_type',
            'categories' => 'required|integer',
            'user_id' => 'required|exists:users,id',
        ]);
        TransportCalculator::create($request->all());
        return redirect()->route('calculate.list')->with('success', 'Transport Calculator added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transportCalculator = TransportCalculator::with('user')->findOrFail($id);
        return view('calculate.show', compact('transportCalculator'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bodyTypes = \DB::table('auctions')->pluck('body_type')->unique();
        $users = User::all();
        $currentBodyType = TransportCalculator::pluck('body_type')->toArray();  // This will give you an array of body types
        $transportCalculator = TransportCalculator::findOrFail($id);
        return view('calculate.edit', compact('transportCalculator', 'users', 'bodyTypes', 'currentBodyType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'per_km_charge' => 'required|numeric',
            'same_state_charge' => 'required|numeric',
            'cross_state_charge' => 'required|numeric',
            'additional_charges' => 'required|numeric',
            'additional_charge_for_size' => 'required|numeric',
            'body_type' => 'required|string',
            'categories' => 'required|integer',
            'user_id' => 'required|exists:users,id',
        ]);

        $transportCalculator = TransportCalculator::findOrFail($id);
        $transportCalculator->update($request->all());

        return redirect()->route('calculate.list')->with('success', 'Transport Calculator updated successfully!');

    }
    public function calculatelist(){
        $auctions=Auctions::all();
        $consolers=Consoler::all();
        $partners = Partner::all();
        $transportCalculators = TransportCalculator::with('user')->get();
        return view('calculate.index', compact('transportCalculators', 'auctions','consolers','partners'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $calculator = TransportCalculator::findOrFail($id);
        $calculator->delete();
        return redirect()->route('calculate.list')->with('success', 'Transport Calculator deleted successfully.');
    }
    public function getTransportCost($carId, Request $request)
    {
        $auction = Auctions::where('unique_identifier', $carId)->first();
        if (!$auction) {
            return response()->json(['error' => 'Car not found'], 404);
        }

        $transportCost = TransportCalculator::where('body_type', $auction->body_type)->first();
        if (!$transportCost) {
            // Default to "other" if body type not found
            $transportCost = TransportCalculator::where('body_type', 'other')->first();
        }

        $stateChargeType = $request->get('stateChargeType', 'same_state_charge');

        // Check if body type of auction and transport cost match
        if ($auction->body_type !== $transportCost->body_type) {
            $transportCost = TransportCalculator::where('body_type', 'other')->first(); // Default to "other"
        }

        if (!$transportCost) {
            return response()->json(['error' => 'Transport cost for the selected body type not found'], 404);
        }

        $catcost = $transportCost->categories;
        $addcharge = $transportCost->additional_charge_for_size;
        $cost = $catcost * $addcharge;

        return response()->json([
            'per_km_charge' => $transportCost->per_km_charge,
            'state_charge' => $transportCost->$stateChargeType,
            'size_charge' => $transportCost->$cost,
            'additional_charges' => $transportCost->additional_charges
        ]);
    }



}
