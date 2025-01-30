@extends('consoler.layouts.app')
@section('headerTitle', 'Car at Auctions')
@section('title', 'Auctions List')
@section('content')

    <style>
        .small-filter {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            height: auto;
            border-width: 0.5px;
            font-weight: bold;
            color: #5271FF !important;
        }

        .small-filter option {
            color: #5271FF  !important;
            font-weight: bold !important;
        }

        .form-select-sm {
            padding: 0.25rem;
            border-width: 0.5px !important;
        }
    </style>
    <div class="container-fluid">
        <h5 style="color: #5271FF">Cars at Auction</h5>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                </div>
                <div style="color: #5271FF">Total: <span>{{$totalcount}}</span></div>
            </div>

            <div class="card-body">
                <!-- Filter Buttons -->
                <div class="d-flex card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex " style="gap: 5px;">
                        <!-- Make Filter -->
                        <select class="form-select form-select-sm small-filter  " style="width:100px;" aria-label="Make Filter">
                            <option value="">All Makes </option>
                            @foreach ($makes->sort() as $make)
                                <option value="{{ $make }}" {{ $selectedMake == $make ? 'selected' : '' }}>
                                    {{ $make }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Model Filter -->
                        <select class="form-select form-select-sm small-filter " style="width: 100px;" aria-label="Model Filter">
                            <option value="">All Models </option>
                            @foreach ($models->sort() as $model)
                                <option value="{{ $model }}" {{ $selectedModel == $model ? 'selected' : '' }}>
                                    {{ $model }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Body Type Filter -->
                        <select class="form-select form-select-sm small-filter" style="width: 120px;" aria-label="Body Type Filter">
                            <option value="">All Body Types</option>
                            @foreach ($bodyTypes->sort() as $bodyType)
                                <option value="{{ $bodyType }}" {{ $selectedBodyType == $bodyType ? 'selected' : '' }}>
                                    {{ $bodyType }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Build Date Filter -->
                        <select class="form-select form-select-sm small-filter " style="width: 120px;" aria-label="Build Date Filter">
                            <option value="">All Build Dates </option>
                            @foreach ($buildDates->sort() as $buildDate)
                                <option value="{{ $buildDate }}" {{ $selectedBuildDate == $buildDate ? 'selected' : '' }}>
                                    {{ $buildDate }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Auction Name Filter -->
                        <select class="form-select form-select-sm small-filter" style="width: 150px;" aria-label="Auction Name Filter">
                            <option value="">All Auction Names </option>
                            @foreach ($auctionNames->sort() as $auctionName)
                                <option value="{{ $auctionName }}" {{ $selectedAuctionName == $auctionName ? 'selected' : '' }}>
                                    {{ $auctionName }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Location Filter -->
                        <select class="form-select form-select-sm small-filter" style="width: 120px;" aria-label="Location Filter">
                            <option value="">All Locations </option>
                            @foreach ($locations->sort() as $location)
                                <option value="{{ $location }}" {{ $selectedLocation == $location ? 'selected' : '' }}>
                                    {{ $location }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="ms-auto d-flex gap-3">
                        <a class="" style="color: #5271FF ">Active</a>
                        <a class="" style="color: #5271FF ">Shortlisted</a>
                        <a class="" style="color: #5271FF ">Past Lists</a>
                    </div>
                </div>

                <!-- Table -->
                <table class="table table-borderless">
                    <thead class="shadow-sm " style="color: #5271FF">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>KMs</th>
                        <th>Type</th>
                        <th>Transmission</th>
                        <th>Deadline</th>
                        <th>Auctioneer</th>
                        <th>Bid_Note</th>
                        <th>Shortlisted</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($auctions as $auction)
                        <tr>
                            <td>
                                <a href="#" class="text-danger" >Hide</a>
                                <a href="#" class="text-danger">Remove</a>
                            </td>
                            <td>{{ $auction->name }}</td>
                            <td>{{ $auction->odometer }}</td>
                            <td>{{ $auction->body_type }}</td>
                            <td>{{ $auction->transmission }}</td>
                            <td>{{ $auction->deadline }}</td>
                            <td>{{ $auction->auctioneer }}</td>
                            <td><a href="#" style="color:#5271FF" >Edit</a></td>
                            <td><a href="#" style="color:#5271FF" >Shortlist It</a></td>
                            <td>
                                <a href="#" class=" toggle-details" style="color:#5271FF" data-auction-id="{{ $auction->id }}">Expand for Details</a>
                                <a href="#" class=" toggle-details d-none" style="color:#5271FF" data-auction-id="{{ $auction->id }}">Revert Expansion</a>
                            </td>
                        </tr>
                        <tr class="details-row d-none" id="details-{{ $auction->id }}">
                            <td colspan="10">
                                <div class="details-container row">
                                    <div class="col-md-4">
                                        <p><strong>Year:</strong> {{ $auction->build_date }}</p>
                                        <p><strong>Make:</strong> {{ $auction->make }}</p>
                                        <p><strong>Model:</strong> {{ $auction->model }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>Fuel:</strong> {{ $auction->fuel }}</p>
                                        <p><strong>Seats:</strong> {{ $auction->seats }}</p>
                                        <p><strong>Transmission:</strong> {{ $auction->transmission }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>VIN:</strong> {{ $auction->vin }}</p>
                                        <p><strong>State:</strong> {{ $auction->state }}</p>
                                        <p><strong>Redbook Code:</strong> {{ $auction->redbook_code }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>Average Wholesale:</strong> {{ $auction->redbook_average_wholesale }}</p>
                                        <p><strong>Market Retail:</strong> {{ $auction->current_market_retail }}</p>
                                        <p><strong>Listed Date:</strong> {{ $auction->date_listed }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>Condition Report:</strong> <a href="{{ $auction->link_to_condition_report }}" target="_blank">Condition Report</a></p>
                                        <p><strong>Auction Link:</strong> <a href="{{ $auction->link_to_auction }}" target="_blank">Auction Link</a></p>
                                        <p><strong>Registration Link:</strong> <a href="{{ $auction->auction_registration_link }}" target="_blank">Registration link</a></p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            <div class="pagination-container">
                {{ $auctions->onEachSide(2)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <script src="{{ asset('js/action.js') }}"></script>

@endsection
