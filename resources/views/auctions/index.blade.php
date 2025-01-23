@extends('admin.layouts.app')
@section('headerTitle', 'Car at Auctions')
@section('title', 'Auctions List')

@section('content')
<!-- Include Bootstrap CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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

    .table th, .table td {
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

        <!-- Modal for CSV Upload -->
        <div class="modal fade" id="uploadCSVModal" tabindex="-1" aria-labelledby="uploadCSVModalLabel" aria-hidden="true">
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
                                <input type="file" class="form-control" id="csvFile" name="csvFile" accept=".csv" required>
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
            <!-- Tabs for Active and Past Auctions -->
            <ul class="nav nav-tabs" id="auctionTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="active-auctions-tab" data-bs-toggle="tab" href="#active-auctions" role="tab" aria-controls="active-auctions" aria-selected="true">Active Auctions</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="past-auctions-tab" data-bs-toggle="tab" href="#past-auctions" role="tab" aria-controls="past-auctions" aria-selected="false">Past Auctions</a>
                </li>
            </ul>

            <div class="tab-content" id="auctionTabsContent">
                <!-- Active Auctions Tab -->
                <div class="tab-pane fade show active" id="active-auctions" role="tabpanel" aria-labelledby="active-auctions-tab">
                    <h3 class="text-primary mt-3">Active Auctions</h3>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Make</th>
                                <th>Model</th>
                                <th>Deadline</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activeAuctions as $auction)
    <tr>
        <td>{{ $auction->name }}</td>
        <td>{{ $auction->make }}</td>
        <td>{{ $auction->model }}</td>
        <td>{{ $auction->formatted_deadline }}</td>
    </tr>
@endforeach

                        </tbody>
                    </table>
            
                    <!-- Pagination for Active Auctions -->
                    <div class="d-flex justify-content-center">
                        {{ $activeAuctions->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            
                <!-- Past Auctions Tab -->
                <div class="tab-pane fade" id="past-auctions" role="tabpanel" aria-labelledby="past-auctions-tab">
                    <h3 class="text-danger mt-3">Past Auctions</h3>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Make</th>
                                <th>Model</th>
                                <th>Deadline</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pastAuctions as $auction)
    <tr>
        <td>{{ $auction->name }}</td>
        <td>{{ $auction->make }}</td>
        <td>{{ $auction->model }}</td>
        <td>{{ $auction->formatted_deadline }}</td>
    </tr>
@endforeach

                        
                        </tbody>
                    </table>
            
                    <!-- Pagination for Past Auctions -->
                    <div class="d-flex justify-content-center">
                        {{ $pastAuctions->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
