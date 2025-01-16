
@extends('admin.layouts.app')
@section('headerTitle', 'Car at Auctions')
@section('title', 'Auctions List')
@section('content')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle (includes Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Include Bootstrap CSS in your layout -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Include Bootstrap JS and dependencies (jQuery and Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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
        /* Blue text for options */
        font-weight: bold !important;
        /* Bold text for options */
    }

    /* Ensuring the border size for select fields */
    .form-select-sm {
        padding: 0.25rem;
        /* Further reduces the padding for smaller height */
        border-width: 0.5px !important;
        /* Adjusts border width to be small */
    }
</style>
<div class="container-fluid">
    <h5 style="color: #5271FF">Cars at Auction</h5>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <button class="btn" style="color:#5271FF;font-weight: bold;">Reboot</button>
                <!-- Button to Trigger Modal -->
                <button class="btn btn-primary" style="color: #fff; font-weight: bold;" data-bs-toggle="modal"
                    data-bs-target="#uploadCSVModal">
                    Add
                </button>

                <!-- Modal for CSV Upload -->
                <div class="modal fade" id="uploadCSVModal" tabindex="-1" aria-labelledby="uploadCSVModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('auctions.import') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadCSVModalLabel">Upload CSV</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="csvFile" class="form-label">Choose CSV File</label>
                                        <input class="form-control" type="file" id="csvFile" name="csvFile"
                                            accept=".csv" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>



                <button class="btn" style="color:#5271FF; font-weight: bold;">Remove</button>
                <button class="btn" style="color:#5271FF; font-weight: bold;">Download</button>
            </div>
            <div style="color: #5271FF">Total: <span>{{$totalcount}}</span></div>
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
                            <option value="{{ $make }}">{{ $make }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Model Filter -->
                    <div class="btn-group">
                        <select class="form-select form-select-sm small-filter" aria-label="Model Filter">
                            <option value="">All Models</option>
                            @foreach($models as $model)
                            <option value="{{ $model }}">{{ $model }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Body Type Filter -->
                    <div class="btn-group">
                        <select class="form-select form-select-sm small-filter" aria-label="Body Type Filter">
                            <option value="">All Body Types</option>
                            @foreach($bodyTypes as $bodyType)
                            <option value="{{ $bodyType }}">{{ $bodyType }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Build Date Filter -->
                    <div class="btn-group">
                        <select class="form-select form-select-sm small-filter" aria-label="Build Date Filter">
                            <option value="">All Build Dates</option>
                            @foreach($buildDates as $buildDate)
                            <option value="{{ $buildDate }}">{{ $buildDate }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Auction Name Filter -->
                    <div class="btn-group">
                        <select class="form-select form-select-sm small-filter" aria-label="Auction Name Filter">
                            <option value="">All Auction Names</option>
                            @foreach($auctionNames as $auctionName)
                            <option value="{{ $auctionName }}">{{ $auctionName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Location Filter -->
                    <div class="btn-group">
                        <select class="form-select form-select-sm small-filter" aria-label="Location Filter">
                            <option value="">All Locations</option>
                            @foreach($locations as $location)
                            <option value="{{ $location }}">{{ $location }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="ms-auto d-flex gap-3">
                    <a class="" style="color: #5271FF ">Active</a>
                    <a class="" style="color: #5271FF ">Shortlisted</a>
                    <a class="" style="color: #5271FF ">Past Lists</a>
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
                            <a href="#" class=" toggle-details" style="color:#5271FF"
                                data-auction-id="{{ $auction->id }}">Expand for Details</a>
                            <a href="#" class=" toggle-details d-none" style="color:#5271FF"
                                data-auction-id="{{ $auction->id }}">Revert Expansion</a>
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
                                    <p><strong>Condition Report:</strong> <a
                                            href="{{ $auction->link_to_condition_report }}" target="_blank">Condition
                                            Report</a></p>
                                    <p><strong>Auction Link:</strong> <a href="{{ $auction->link_to_auction }}"
                                            target="_blank">Auction Link</a></p>
                                    <p><strong>Registration Link:</strong> <a
                                            href="{{ $auction->auction_registration_link }}"
                                            target="_blank">Registration link</a></p>
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
<!-- Modal for showing duplicate unique identifiers -->
@if(session('duplicates') && count(session('duplicates')) > 0)
    <div class="modal fade" id="duplicateModal" tabindex="-1" aria-labelledby="duplicateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="duplicateModalLabel">Duplicate Unique Identifiers Found</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>The following unique identifiers already exist in the database:</p>
                    <ul>
                        @foreach(session('duplicates') as $duplicate)
                            <li>{{ $duplicate }}</li>
                        @endforeach
                    </ul>
                    <p>Please check and ensure the values are correct before re-uploading.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Ensure the modal is shown when there are duplicate identifiers
        window.onload = function() {
            if (document.getElementById('duplicateModal')) {
                const duplicateModal = new bootstrap.Modal(document.getElementById('duplicateModal'));
                duplicateModal.show();
            }
        };
    </script>
@endif


<script>
    document.addEventListener('DOMContentLoaded', function () {
            let expandedRow = null;

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