@extends('admin.layouts.app')
@section('headerTitle', 'Car at Auctions')
@section('title', 'Auctions List')

@section('content')
<!-- Include Bootstrap CSS and JS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
    /* Add this to your custom CSS file */
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
                <button type="button" class="btn-close ml-auto" data-dismiss="alert" aria-label="Close">
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
                <button type="button" class="btn-close ml-auto" data-dismiss="alert" aria-label="Close">
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
                <div class="tab-pane fade show active" id="active-auctions" role="tabpanel"
                    aria-labelledby="active-auctions-tab">
                    <h3 class="text-primary mt-3">Active Auctions</h3>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Make</th>
                                <th>Model</th>
                                <th>Deadline</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activeAuctions as $auction)
                            <tr data-bs-toggle="collapse" data-bs-target="#details-{{ $auction->id }}"
                                aria-expanded="false" aria-controls="details-{{ $auction->id }}">
                                <td>{{ $auction->name }}</td>
                                <td>{{ $auction->make }}</td>
                                <td>{{ $auction->model }}</td>
                                <td>{{ $auction->formatted_deadline }}</td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm">Expand</button>
                                </td>
                                <td>
                                    <a href="{{ route('auctions.edit', $auction->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                                
                            </tr>
                            <tr class="collapse details-row" id="details-{{ $auction->id }}">
                                <td colspan="5">
                                    <div class="details-container p-3 border rounded bg-light shadow-sm">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Build Date:</strong> <span class="text-muted">{{
                                                        $auction->build_date }}</span></p>
                                                <p><strong>Odometer:</strong> <span class="text-muted">{{
                                                        $auction->odometer }}</span></p>
                                                <p><strong>Body Type:</strong> <span class="text-muted">{{
                                                        $auction->body_type }}</span></p>
                                                <p><strong>Fuel:</strong> <span class="text-muted">{{ $auction->fuel
                                                        }}</span></p>
                                                <p><strong>Transmission:</strong> <span class="text-muted">{{
                                                        $auction->transmission }}</span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Seats:</strong> <span class="text-muted">{{ $auction->seats
                                                        }}</span></p>
                                                <p><strong>Auctioneer:</strong> <span class="text-muted">{{
                                                        $auction->auctioneer }}</span></p>
                                                <p><strong>State:</strong> <span class="text-muted">{{ $auction->state
                                                        }}</span></p>
                                                <p><strong>VIN:</strong> <span class="text-muted">{{ $auction->vin
                                                        }}</span></p>
                                                <p><strong>Link:</strong>
                                                    <a href="{{ $auction->link_to_auction }}" target="_blank"
                                                        class="text-primary text-decoration-underline">View Auction</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            @endforeach
                   
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $activeAuctions->appends(['tab' => 'active-auctions'])->links() }}
                    </div>
                </div>

                <div class="tab-pane fade" id="past-auctions" role="tabpanel" aria-labelledby="past-auctions-tab">
                    <h3 class="text-danger mt-3">Past Auctions</h3>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Make</th>
                                <th>Model</th>
                                <th>Deadline</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pastAuctions as $auction)
                            <tr data-bs-toggle="collapse" data-bs-target="#details-{{ $auction->id }}"
                                aria-expanded="false" aria-controls="details-{{ $auction->id }}">
                                <td>{{ $auction->name }}</td>
                                <td>{{ $auction->make }}</td>
                                <td>{{ $auction->model }}</td>
                                <td>{{ $auction->formatted_deadline }}</td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm">Expand</button>
                                </td>
                              
                                <td>
                                    <a href="{{ route('auctions.edit', $auction->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                            
                            <tr class="collapse details-row" id="details-{{ $auction->id }}">
                                <td colspan="5">
                                    <div class="details-container p-3 border rounded bg-light shadow-sm">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Build Date:</strong> <span class="text-muted">{{
                                                        $auction->build_date }}</span></p>
                                                <p><strong>Odometer:</strong> <span class="text-muted">{{
                                                        $auction->odometer }}</span></p>
                                                <p><strong>Body Type:</strong> <span class="text-muted">{{
                                                        $auction->body_type }}</span></p>
                                                <p><strong>Fuel:</strong> <span class="text-muted">{{ $auction->fuel
                                                        }}</span></p>
                                                <p><strong>Transmission:</strong> <span class="text-muted">{{
                                                        $auction->transmission }}</span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Seats:</strong> <span class="text-muted">{{ $auction->seats
                                                        }}</span></p>
                                                <p><strong>Auctioneer:</strong> <span class="text-muted">{{
                                                        $auction->auctioneer }}</span></p>
                                                <p><strong>State:</strong> <span class="text-muted">{{ $auction->state
                                                        }}</span></p>
                                                <p><strong>VIN:</strong> <span class="text-muted">{{ $auction->vin
                                                        }}</span></p>
                                                <p><strong>Link:</strong>
                                                    <a href="{{ $auction->link_to_auction }}" target="_blank"
                                                        class="text-primary text-decoration-underline">View Auction</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $pastAuctions->appends(['tab' => 'past-auctions'])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab') || 'active-auctions';

        const tabLink = document.querySelector(`#${activeTab}-tab`);
        if (tabLink) {
            new bootstrap.Tab(tabLink).show();
        }

        const rows = document.querySelectorAll('.main-row');
        rows.forEach(row => {
            row.addEventListener('click', function () {
                const auctionId = this.getAttribute('data-id');
                const detailsRow = document.getElementById(`details-${auctionId}`);
                detailsRow.classList.toggle('d-none');
            });
        });

        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000); 
    });
</script>
