@extends('admin.layouts.app')
@section('headerTitle', isset($_GET['type']) && $_GET['type'] == 'calculate' ? 'Calculate' : 'Transport Calculators')
@section('content')
    <style>
        .button {
            border-color: #5271FF;
            border: 2px solid #5271FF;
            color: #5271FF;
        }
    </style>
    <style>
        .btn-calculate {
            background-color: #5271FF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn-clear {
            background-color: #5271FF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            margin-left: 10px;
        }

        .result-field {
            display: none;
            margin-top: 20px;
            font-size: 18px;
            color: #5271FF;
            /*font-weight: bold;*/
        }
    </style>
    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <div class="container-fluid">
        <div class="mb-3">
            <a href="?type=value" class="btn {{ (!isset($_GET['type']) || $_GET['type'] != 'calculate') ? 'btn-primary' : 'button border-2' }}">Value</a>
            <a href="?type=calculate" class="btn {{ (isset($_GET['type']) && $_GET['type'] == 'calculate') ? 'btn-primary' : 'button border-2' }}">Calculate</a>
        </div>

        @if (!isset($_GET['type']) || $_GET['type'] != 'calculate')
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold" style="pointer-events: none; user-select: none; color: #5271FF;">List of Transport Calculators</h6>
                    <a href="{{ route('calculate.create') }}" class="btn border-3" style="color:#5271FF; border-color: #5271FF;">Add Transport Calculator</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                            <thead style="pointer-events: none; user-select: none; color:#5271FF">
                            <tr>
                                <th>Per KM Charge</th>
                                <th>Same State Charge</th>
                                <th>Cross State Charge</th>
                                <th>Additional Charges</th>
                                <th>Body Type</th>
                                <th>Categories</th>
                                <th>Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transportCalculators as $calculator)
                                <tr>
                                    <td>{{ $calculator->per_km_charge }}</td>
                                    <td>{{ $calculator->same_state_charge }}</td>
                                    <td>{{ $calculator->cross_state_charge }}</td>
                                    <td>{{ $calculator->additional_charges }}</td>
                                    <td>{{ ucwords(strtolower($calculator->body_type ?? 'N/A')) }}</td>
                                    <td>{{ $calculator->categories }}</td>
                                    <td>
                                        <a href="{{ route('calculate.details', $calculator->id) }}" class="btn border-2" style="color:#5271FF; border-color: #5271FF">View Details</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('calculate.destroy', $calculator->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn border-2 btn-sm" style="border-color: red; color: red;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold" style="color: #5271FF;">Transport Cost Calculator</h6>
                    </div>
                    <div class="card-body">
                        <form id="calculate-form">
                            <div class="mb-3 d-flex">
                                <label for="car-select" class="form-label col-sm-3">Choose your Car:</label>
                                <select id="car-select" class="form-control form-control-sm col-sm-3" required>
                                    <option value="">Year, Make, Model, Odo, Auction</option>
                                    @foreach($auctions as $auction)
                                        <option value="{{ $auction->unique_identifier }}">
                                            {{ $auction->name }}, {{ $auction->make }}, {{ $auction->model }}, {{ $auction->odometer }}, {{ $auction->auctioneer }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3 d-flex">
                                <label for="from-field" class="form-label col-sm-3">From:</label>
                                <select id="from-field" class="form-control form-control-sm col-sm-3" required>
                                    <option value="">Choose an Address</option>
                                    @foreach($partners as $partner)
                                        @php
                                            $addresses = explode(';', $partner->operation_location);
                                            $latitudes = explode(';', $partner->latitude);
                                            $longitudes = explode(';', $partner->longitude);
                                        @endphp
                                        @foreach($addresses as $index => $address)
                                            <option value="{{ $partner->id . '-' . $index }}"
                                                    data-partner-id="{{ $partner->id }}"
                                                    data-location="{{ $address }}"
                                                    data-lat1="{{ $latitudes[$index] }}"
                                                    data-lng1="{{ $longitudes[$index] }}">
                                                {{ $address }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 d-flex">
                                <label for="to-field" class="form-label col-sm-3">To:</label>
                                <select id="to-field" class="form-control form-control-sm col-sm-3" required>
                                    <option value="">Choose an Address</option>
                                    @foreach($consolers as $consoler)
                                        <option value="{{ $consoler->id }}"
                                                data-lat="{{ $consoler->latitude }}"
                                                data-lng="{{ $consoler->longitude }}">
                                            {{ $consoler->building }}, {{ $consoler->city }}, {{ $consoler->state }}, {{ $consoler->country }}, {{ $consoler->post_code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="button" class="btn-calculate" id="calculate-button">Calculate</button>
                            <button type="button" class="btn-clear" id="clear-button">Clear</button>
                        </form>

                        <div id="result" class="result-field">Result: $0.00</div>
                        <div id="totalkm" class="result-field">Total Km: 0 km</div>

                    </div>
                </div>
            </div>

        @endif
    </div>
@endsection

@section('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const urlParams = new URLSearchParams(window.location.search);
            const type = urlParams.get('type') || 'value';

            document.querySelectorAll(".btn").forEach(button => {
                button.addEventListener("click", () => {
                    window.location.href = button.getAttribute("href");
                });
            });
            document.getElementById('clear-button').addEventListener('click', function() {
                window.location.reload();
            });
        });
        $(document).ready(function() {
            $('#car-select').select2({
                width: '25%'
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const calculateButton = document.getElementById("calculate-button");
            const resultField = document.getElementById("result");
            const totalkmField = document.getElementById("totalkm");

            calculateButton.addEventListener("click", async () => {
                const carSelect = document.getElementById("car-select");
                const fromSelect = document.getElementById("from-field");
                const toSelect = document.getElementById("to-field");

                const car = carSelect.value;
                const fromOption = fromSelect.options[fromSelect.selectedIndex];
                const toOption = toSelect.options[toSelect.selectedIndex];

                if (car && fromOption.value && toOption.value) {
                    const fromLat = parseFloat(fromOption.getAttribute('data-lat1'));
                    const fromLng = parseFloat(fromOption.getAttribute('data-lng1'));
                    const toLat = parseFloat(toOption.getAttribute('data-lat'));
                    const toLng = parseFloat(toOption.getAttribute('data-lng'));

                    if (isNaN(fromLat) || isNaN(fromLng) || isNaN(toLat) || isNaN(toLng)) {
                        resultField.textContent = "Invalid latitude or longitude values.";
                        resultField.style.display = "block";
                        return;
                    }
                    const fromAddress = fromOption.getAttribute('data-location');
                    const fromState = fromAddress.split(',')[2]?.trim() || '';

                    const toState = toOption.textContent.split(',')[2]?.trim() || '';
                    let stateChargeType = "same_state_charge";
                    if (fromState !== toState) {
                        stateChargeType = "cross_state_charge";
                    }
                    const transportCost = await fetchTransportCost(car, stateChargeType);
                    const distance = calculateDistance(fromLat, fromLng, toLat, toLng);
                    const perKmCharge = parseFloat(transportCost.per_km_charge);
                    const stateCharge = parseFloat(transportCost.state_charge);
                    const sizeCharge = parseFloat(transportCost.size_charge) || 0;
                    const additionalCharge = parseFloat(transportCost.additional_charges) || 0;
                    const totalCost = ((distance * perKmCharge) + stateCharge + sizeCharge + additionalCharge).toFixed(2);
                    resultField.textContent = `Total Cost: $${totalCost} AUD`;
                    resultField.style.display = "block";

                    totalkmField.textContent = `Total Km: ${distance.toFixed(2)} km`;
                    totalkmField.style.display = "block";
                } else {
                    alert("Please select a car and both 'From' and 'To' addresses to calculate.");
                    totalkmField.style.display = "none";
                }
            });
        });

        function calculateDistance(lat1, lng1, lat2, lng2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLng = (lng2 - lng1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        async function fetchTransportCost(carId, stateChargeType) {
            try {
                const response = await fetch(`/get-transport-cost/${carId}?stateChargeType=${stateChargeType}`);
                const data = await response.json();
                return {
                    per_km_charge: data.per_km_charge,
                    state_charge: data.state_charge,
                    size_charge: data.size_charge,
                    additional_charges: data.additional_charges
                };
            } catch (error) {
                console.error("Error fetching transport cost:", error);
                return { per_km_charge: 1, state_charge: 0, size_charge: 0, additional_charges: 0 }; // Default values in case of error
            }
        }
    </script>
@endsection
