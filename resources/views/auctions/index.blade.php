@extends('admin.layouts.app')
@section('headerTitle', 'Car at Auctions')
@section('title', 'Auctions List')
@section('content')
    <div class="container mt-2">
        <h5>Cars at Auction</h5>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <button class="btn ">Reboot</button>
                    <button class="btn ">Add</button>
                    <button class="btn ">Remove</button>
                    <button class="btn ">Download</button>
                </div>
                <div>Total: <span>{{$totalcount}}</span></div>
            </div>

            <div class="card-body">
                <!-- Filter Buttons -->
                <div class="d-flex   card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex " style="gap: 5px;">
                        <button class="btn btn-outline-primary btn-sm">All Makes<span>&#9654;</span></button>
                        <button class="btn btn-outline-primary btn-sm">All Model<span>&#9654;</span></button>
                        <button class="btn btn-outline-primary btn-sm">All Body Type<span>&#9654;</span></button>
                        <button class="btn btn-outline-primary btn-sm">All Build Date<span>&#9654;</span></button>
                        <button class="btn btn-outline-primary btn-sm">Auction Name<span>&#9654;</span></button>
                        <button class="btn btn-outline-primary btn-sm">Location<span>&#9654;</span></button>
                    </div>
                    <div class="ms-auto d-flex">
                        <a class="">Active</a>
                        <a class="">Shortlisted</a>
                        <a class="">Past Lists</a>
                    </div>
                </div>

                <!-- Table -->
                <table class="table table-borderless">
                    <thead class="bg-warning">
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>KMs</th>
                            <th>Type</th>
                            <th>Transmission</th>
                            <th>Deadline</th>
                            <th>Auctioneer</th>
                            <th>Note_your_Bid</th>
                            <th>Shortlisted</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($auctions as $auction)
                            <tr>
                                <td><a href="#" class="text-danger">Hide</a>
                                    <a href="#" class="text-warning">Remove</a>
                                </td>
                                <td>{{ $auction->name }}</td>
                                <td>{{ $auction->odometer }}</td>
                                <td>{{ $auction->body_type }}</td>
                                <td>{{ $auction->transmission }}</td>
                                <td>{{ $auction->deadline }}</td>
                                <td>{{ $auction->auctioneer }}</td>
                                <td><a href="#" class="text-primary">Edit</a> </td>
                                <td><a href="#" class="text-success">Shortlist It</a> </td>
                               <td> <a href="#" class="text-info">Expand for Details</a></td>

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
@endsection
