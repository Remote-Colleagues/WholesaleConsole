@extends('admin.layouts.app')

@section('content')
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
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h5 class="text-primary">Cars at Shortlisted Auctions</h5>

            <h3></h3>
            <div class="tab-content">
                <!-- Active Auctions Tab -->
                <div class="tab-pane fade show active" id="active-auctions" role="tabpanel">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Odometer (KM)</th>
                                <th>Fuel</th>
                                <th>Auctioneer</th>
                                <th>Type</th>
                                <th>Deadline</th>
                                <th>Action</th>
                                <th>Expand</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shortlistedAuctions as $index => $shortlisted)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <img src="{{ $shortlisted->auction->image ?? 'path/to/default/image.jpg' }}" alt="Auction Image" class="img-thumbnail" width="50">
                                    </td>
                                    <td>{{ $shortlisted->auction->name }}</td>
                                    <td>{{ $shortlisted->auction->odometer }}</td>
                                    <td>{{ $shortlisted->auction->fuel }}</td>
                                    <td>{{ $shortlisted->auction->auctioneer }}, {{$shortlisted->auction->state}}</td>
                                    <td>{{ $shortlisted->auction->type }}</td>
                                    <td>{{ \Carbon\Carbon::parse($shortlisted->auction->deadline)->format('Y/m/d H:i:s') }}</td>
                                    <td>
                                        @if (DB::table('shortlists')->where('auction_id', $shortlisted->auction->id)->exists())
                                            <!-- If auction is shortlisted, show unshortlist button -->
                                            <form action="{{ route('auctions.unshortlist', $shortlisted->auction->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unshortlist this auction?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Unshortlist</button>
                                            </form>
                                        @else
                                            <!-- If auction is not shortlisted, show shortlist button -->
                                            <form action="{{ route('auctions.shortlist', $shortlisted->auction->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to shortlist this auction?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Shortlist</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#details-{{ $shortlisted->auction->id }}">
                                            Expand
                                        </button>
                                    </td>
                                    <td>
                                        <a href="{{ route('auctions.edit', $shortlisted->auction->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                                <tr class="collapse details-row" id="details-{{ $shortlisted->auction->id }}">
                                    <td colspan="10">
                                        <div class="details-container">
                                            <div class="card border-light mb-3">
                                                <div class="card-header bg-primary text-white">
                                                    <h5 class="card-title">Auction Details</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><strong>Name:</strong> {{ $shortlisted->auction->name }}</p>
                                                            <p><strong>Make:</strong> {{ $shortlisted->auction->make }}</p>
                                                            <p><strong>Model:</strong> {{ $shortlisted->auction->model }}</p>
                                                            <p><strong>Build Date:</strong> {{ $shortlisted->auction->build_date }}</p>
                                                            <p><strong>Odometer (KM):</strong> {{ $shortlisted->auction->odometer }}</p>
                                                            <p><strong>Fuel:</strong> {{ $shortlisted->auction->fuel }}</p>
                                                            <p><strong>Transmission:</strong> {{ $shortlisted->auction->transmission }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>Body Type:</strong> {{ $shortlisted->auction->body_type }}</p>
                                                            <p><strong>Seats:</strong> {{ $shortlisted->auction->seats }}</p>
                                                            <p><strong>Auctioneer:</strong> {{ $shortlisted->auction->auctioneer }}</p>
                                                            <p><strong>State:</strong> {{ $shortlisted->auction->state }}</p>
                                                            <p><strong>VIN:</strong> {{ $shortlisted->auction->vin }}</p>
                                                            <p><strong>Hours:</strong> {{ $shortlisted->auction->hours }}</p>
                                                            <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($shortlisted->auction->deadline)->format('Y/m/d H:i:s') }}</p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <p><strong>Link to Auction:</strong> <a href="{{ $shortlisted->auction->link_to_auction }}" target="_blank" class="btn btn-link">{{ $shortlisted->auction->link_to_auction }}</a></p>
                                                            <p><strong>Other Specs:</strong> {{ $shortlisted->auction->other_specs }}</p>
                                                            <p><strong>Unique Identifier:</strong> {{ $shortlisted->auction->unique_identifier }}</p>
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

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $shortlistedAuctions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- Bootstrap JS (needs jQuery as well) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


