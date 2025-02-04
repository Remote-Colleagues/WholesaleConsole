@extends('admin.layouts.app')
@section('headerTitle', 'Car at Auctions')
@section('title', 'Auctions List')

@section('content')
<!-- Include Bootstrap 5 CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
    .alert {
        font-size: 1.1rem;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .alert .close {
        font-size: 1.5rem;
    }

    .small-filter {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        height: auto;
        border-width: 0.5px;
        font-weight: bold;
        color: #5271FF !important;
    }

    .small-filter option {
        color: #5271FF !important;
        font-weight: bold !important;
    }

    .form-select-sm {
        padding: 0.25rem;
        border-width: 0.5px !important;
    }

    .details-row {
        background-color: #f9f9f9;
    }

    .details-container p {
        margin: 0.25rem 0;
    }

    .card-header {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .btn-custom {
        color: #5271FF;
        font-weight: bold;
    }

    .table th,
    .table td {
        text-align: center;
    }

    .table th {
        background-color: #f1f1f1;
        color: #5271FF;
    }

    .tab-content {
        padding-top: 20px;
    }

    .pagination {
        justify-content: center;
    }
</style>

<div class="container-fluid">
    <h5 class="text-primary">Cars at Auction</h5>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <button class="btn btn-custom">Reboot</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadCSVModal">Add</button>
                <button class="btn btn-custom">Remove</button>
                <button class="btn btn-custom">Download</button>
            </div>
            <div class="text-primary">Total: <span>{{ $totalcount }}</span></div>
        </div>

        @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle mr-3" style="font-size: 1.5rem; color: green;"></i>
                <div>
                    <strong>Success!</strong> {{ session('message') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle mr-3" style="font-size: 1.5rem; color: darkred;"></i>
                <div>
                    <strong>Error!</strong> {{ session('error') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif

        <!-- Modal for CSV Upload -->
        <div class="modal fade" id="uploadCSVModal" tabindex="-1" aria-labelledby="uploadCSVModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('auctions.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadCSVModalLabel">Upload CSV</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="csvFile" class="form-label">Choose CSV File</label>
                                <input type="file" class="form-control" id="csvFile" name="csvFile" accept=".csv"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <div class="card-body">
            <ul class="nav nav-tabs" id="auctionTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="active-auctions-tab" data-bs-toggle="tab" href="#active-auctions"
                        role="tab" aria-controls="active-auctions" aria-selected="true">Active Auctions</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="past-auctions-tab" data-bs-toggle="tab" href="#past-auctions" role="tab"
                        aria-controls="past-auctions" aria-selected="false">Past Auctions</a>
                </li>
            </ul>

            <div class="tab-content" id="auctionTabsContent">
                <!-- Active Auctions Tab -->
                <div class="tab-pane fade show {{ $activeTab == 'active-auctions' ? 'active' : '' }}" id="active-auctions"
                role="tabpanel" aria-labelledby="active-auctions-tab">

                    <h3 class="text-primary mt-3">Active Auctions</h3>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Odometer(KM)</th>
                                <th>Fuel</th>
                                <th>Auctioneer</th>
                                <th>Auction Type</th>
                                <th>Deadline</th>
                                <th>Shortlist</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activeAuctions as $index => $auction)
                            <tr >
                                <td>{{ $index + 1 }}</td>
                                <td><img src="{{ $auction->image ?? 'path/to/default/image.jpg' }}" alt="Auction Image" class="img-thumbnail" width="50"></td>
                                <td>{{ $auction->name }}</td>
                                <td>{{ $auction->odometer }}</td>
                                <td>{{ $auction->fuel }}</td>
                                <td>{{ $auction->auctioneer }}, {{$auction->state}}</td>
                                <td>{{ $auction->type }}</td>
                                <td>{{ $auction->formatted_deadline }}</td>
                                <td>
                                    @if (DB::table('shortlists')->where('auction_id', $auction->id)->exists())
                                        <!-- If auction is shortlisted, show unshortlist button -->
                                        <form action="{{ route('auctions.unshortlist', $auction->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unshortlist this auction?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Unshortlist</button>
                                        </form>
                                    @else
                                        <!-- If auction is not shortlisted, show shortlist button -->
                                        <form action="{{ route('auctions.shortlist', $auction->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to shortlist this auction?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Shortlist</button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#details-{{ $auction->id }}">
                                        Expand
                                    </button>
                                </td>
                                <td>
                                    <a href="{{ route('auctions.edit', $auction->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>

                            <tr class="collapse details-row" id="details-{{ $auction->id }}">
                                <td colspan="10">
                                    <div class="details-container">
                                        <div class="card border-light mb-3">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="card-title">Auction Details</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p><strong>Name:</strong> {{ $auction->name }}</p>
                                                        <p><strong>Make:</strong> {{ $auction->make }}</p>
                                                        <p><strong>Model:</strong> {{ $auction->model }}</p>
                                                        <p><strong>Build Date:</strong> {{ $auction->build_date }}</p>
                                                        <p><strong>Odometer (KM):</strong> {{ $auction->odometer }}</p>
                                                        <p><strong>Fuel:</strong> {{ $auction->fuel }}</p>
                                                        <p><strong>Transmission:</strong> {{ $auction->transmission }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><strong>Body Type:</strong> {{ $auction->body_type }}</p>
                                                        <p><strong>Seats:</strong> {{ $auction->seats }}</p>
                                                        <p><strong>Auctioneer:</strong> {{ $auction->auctioneer }}</p>
                                                        <p><strong>State:</strong> {{ $auction->state }}</p>
                                                        <p><strong>VIN:</strong> {{ $auction->vin }}</p>
                                                        <p><strong>Hours:</strong> {{ $auction->hours }}</p>
                                                        <p><strong>Deadline:</strong> {{ $auction->formatted_deadline }}</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p><strong>Link to Auction:</strong> <a href="{{ $auction->link_to_auction }}" target="_blank" class="btn btn-link">{{ $auction->link_to_auction }}</a></p>
                                                        <p><strong>Other Specs:</strong> {{ $auction->other_specs }}</p>
                                                        <p><strong>Unique Identifier:</strong> {{ $auction->unique_identifier }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $activeAuctions->appends(['tab' => 'active-auctions'])->links() }}


                </div>

                <!-- Past Auctions Tab -->
                <div class="tab-pane fade show {{ $activeTab == 'past-auctions' ? 'active' : '' }}" id="past-auctions" role="tabpanel" aria-labelledby="past-auctions-tab">

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Odometer(KM)</th>
                                <th>Fuel</th>
                                <th>Auctioneer</th>
                                <th>Auction Type</th>
                                <th>Deadline</th>
                                <th>Shortlist</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pastAuctions as $index => $auction)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><img src="{{ $auction->image }}" alt="Auction Image" class="img-thumbnail" width="50"></td>
                                <td>{{ $auction->name }}</td>
                                <td>{{ $auction->odometer }}</td>
                                <td>{{ $auction->fuel }}</td>
                                <td>{{ $auction->auctioneer }}</td>
                                <td>{{ $auction->type }}</td>
                                <td>{{ $auction->formatted_deadline }}</td>
                                <td>
                                    @if (DB::table('shortlists')->where('auction_id', $auction->id)->exists())
                                        <!-- If auction is shortlisted, show unshortlist button -->
                                        <form action="{{ route('auctions.unshortlist', $auction->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unshortlist this auction?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Unshortlist</button>
                                        </form>
                                    @else
                                        <!-- If auction is not shortlisted, show shortlist button -->
                                        <form action="{{ route('auctions.shortlist', $auction->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to shortlist this auction?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Shortlist</button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#details-{{ $auction->id }}">
                                        Expand
                                    </button>
                                </td>
                            </tr>
                            <tr class="collapse details-row" id="details-{{ $auction->id }}">
                                <td colspan="9">
                                    <div class="details-container">
                                        <div class="card border-light mb-3">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="card-title">Auction Details</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p><strong>Name:</strong> {{ $auction->name }}</p>
                                                        <p><strong>Make:</strong> {{ $auction->make }}</p>
                                                        <p><strong>Model:</strong> {{ $auction->model }}</p>
                                                        <p><strong>Build Date:</strong> {{ $auction->build_date }}</p>
                                                        <p><strong>Odometer (KM):</strong> {{ $auction->odometer }}</p>
                                                        <p><strong>Fuel:</strong> {{ $auction->fuel }}</p>
                                                        <p><strong>Transmission:</strong> {{ $auction->transmission }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><strong>Body Type:</strong> {{ $auction->body_type }}</p>
                                                        <p><strong>Seats:</strong> {{ $auction->seats }}</p>
                                                        <p><strong>Auctioneer:</strong> {{ $auction->auctioneer }}</p>
                                                        <p><strong>State:</strong> {{ $auction->state }}</p>
                                                        <p><strong>VIN:</strong> {{ $auction->vin }}</p>
                                                        <p><strong>Hours:</strong> {{ $auction->hours }}</p>
                                                        <p><strong>Deadline:</strong> {{ $auction->formatted_deadline }}</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p><strong>Link to Auction:</strong> <a href="{{ $auction->link_to_auction }}" target="_blank" class="btn btn-link">{{ $auction->link_to_auction }}</a></p>
                                                        <p><strong>Other Specs:</strong> {{ $auction->other_specs }}</p>
                                                        <p><strong>Unique Identifier:</strong> {{ $auction->unique_identifier }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    {{ $pastAuctions->appends(['tab' => 'past-auctions'])->links() }}

                </div>

        </div>
    </div>
</div>

@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab') || 'active-auctions';

        const tab = document.querySelector(`#${activeTab}-tab`);
        if (tab) {
            new bootstrap.Tab(tab).show();
        }
    });
</script>
