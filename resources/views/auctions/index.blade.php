
@extends('admin.layouts.app')
@section('headerTitle', 'Car at Auctions')
@section('title', 'Auctions List')
@section('content')

    <style>
        /* Custom small size for the filters */
        .small-filter {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            height: auto;
            border-width: 0.5px;
            font-weight: bold;
            color: #5271FF !important;
        }

        /* Ensuring the text color is blue for the options */
        .small-filter option {
            color: #5271FF !important;
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
                    <button class="btn" style="color:#5271FF;font-weight: bold;">Reboot</button>
                    <button class="btn" style="color:#5271FF; font-weight: bold;">Add</button>
                    <button class="btn" style="color:#5271FF; font-weight: bold;">Remove</button>
                    <button class="btn" style="color:#5271FF; font-weight: bold;">Download</button>
                </div>
                <div style="color: #5271FF">Total: <span>{{ $totalcount }}</span></div>
            </div>

            <div class="card-body">
                <!-- Filter Buttons -->
                <div class="d-flex card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex" style="gap: 5px;">
                        <!-- Make Filter -->
                        <div class="btn-group">
                            <select class="form-select form-select-sm small-filter" aria-label="Make Filter">
                                <option value="">All Makes</option>
                                @foreach($makes as $make)
                                    <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>{{ $make }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Model Filter -->
                        <div class="btn-group">
                            <select class="form-select form-select-sm small-filter" aria-label="Model Filter">
                                <option value="">All Models</option>
                                @foreach($models as $model)
                                    <option value="{{ $model }}" {{ request('model') == $model ? 'selected' : '' }}>{{ $model }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Body Type Filter -->
                        <div class="btn-group">
                            <select class="form-select form-select-sm small-filter" aria-label="Body Type Filter">
                                <option value="">All Body Types</option>
                                @foreach($bodyTypes as $bodyType)
                                    <option value="{{ $bodyType }}" {{ request('body_type') == $bodyType ? 'selected' : '' }}>{{ $bodyType }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Build Date Filter -->
                        <div class="btn-group">
                            <select class="form-select form-select-sm small-filter" aria-label="Build Date Filter">
                                <option value="">All Build Dates</option>
                                @foreach($buildDates as $buildDate)
                                    <option value="{{ $buildDate }}" {{ request('build_date') == $buildDate ? 'selected' : '' }}>{{ $buildDate }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Auction Name Filter -->
                        <div class="btn-group">
                            <select class="form-select form-select-sm small-filter" aria-label="Auction Name Filter">
                                <option value="">All Auction Names</option>
                                @foreach($auctionNames as $auctionName)
                                    <option value="{{ $auctionName }}" {{ request('auction_name') == $auctionName ? 'selected' : '' }}>{{ $auctionName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Location Filter -->
                        <div class="btn-group">
                            <select class="form-select form-select-sm small-filter" aria-label="Location Filter">
                                <option value="">All Locations</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>{{ $location }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="ms-auto d-flex gap-3">
                        <a class="" style="color: #5271FF">Active</a>
                        <a class="" style="color: #5271FF">Shortlisted</a>
                        <a class="" style="color: #5271FF">Past Lists</a>
                    </div>
                </div>

                <!-- Table -->
                <table class="table table-borderless">
                    <thead class="text-white" style="background-color: #5271FF">
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
                                <p href="#" class="text-danger">Hide</p>
                                <a href="#" class="text-danger">Remove</a>
                            </td>
                            <td>{{ $auction->name }}</td>
                            <td>{{ $auction->odometer }}</td>
                            <td>{{ $auction->body_type }}</td>
                            <td>{{ $auction->transmission }}</td>
                            <td>{{ $auction->deadline }}</td>
                            <td>{{ $auction->auctioneer }}</td>
                            <td><a href="#" style="color:#5271FF">Edit</a></td>
                            <td><a href="#" style="color:#5271FF">Shortlist It</a></td>
                            <td>
                                <a href="#" class="toggle-details" style="color:#5271FF" data-auction-id="{{ $auction->id }}">Expand for Details</a>
                                <a href="#" class="toggle-details d-none" style="color:#5271FF" data-auction-id="{{ $auction->id }}">Revert Expansion</a>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let expandedRow = null;

            document.querySelectorAll('.toggle-details').forEach(function (button) {
                button.addEventListener('click', function (e) {
                    e.preventDefault();

                    const auctionId = this.getAttribute('data-auction-id');
                    const detailsRow = document.getElementById(`details-${auctionId}`);
                    const expandButton = this.parentElement.querySelector('.text-info');
                    const revertButton = this.parentElement.querySelector('.text-danger');

                    // Close previously expanded row if it exists and is not the same row
                    if (expandedRow && expandedRow !== detailsRow) {
                        expandedRow.classList.add('d-none');
                        const prevExpandButton = expandedRow.previousElementSibling.querySelector('.text-info');
                        const prevRevertButton = expandedRow.previousElementSibling.querySelector('.text-danger');
                        if (prevExpandButton && prevRevertButton) {
                            prevExpandButton.classList.remove('d-none');
                            prevRevertButton.classList.add('d-none');
                        }
                    }

                    // Toggle the current row (expand/collapse)
                    detailsRow.classList.toggle('d-none');
                    expandButton.classList.toggle('d-none');
                    revertButton.classList.toggle('d-none');

                    // Update the reference to the expanded row
                    expandedRow = detailsRow.classList.contains('d-none') ? null : detailsRow;
                });
            });

            // Event listener for filter changes
            document.querySelectorAll('.small-filter').forEach(function (filter) {
                filter.addEventListener('change', function () {
                    // Build URL with selected filter values
                    const filters = {};
                    document.querySelectorAll('.small-filter').forEach(function (select) {
                        const name = select.getAttribute('aria-label').replace(' Filter', '').toLowerCase();
                        const value = select.value;
                        if (value) {
                            filters[name] = value;
                        }
                    });

                    // Reload the page with the new URL
                    let url = window.location.pathname + '?';
                    for (let key in filters) {
                        if (filters.hasOwnProperty(key)) {
                            url += `${key}=${filters[key]}&`;
                        }
                    }
                    window.location.href = url.slice(0, -1); // Remove the trailing '&'
                });
            });
        });
    </script>

@endsection
