@extends('admin.layouts.app')
@section('headerTitle', 'Car at Auctions')
@php
    $secondaryHeader = [
        'All makes' => ('#'),
        'All models ' => ('#'),
        'All body types ' => ('#'),
        'All build dates ' => ('#'),
        'Auctions name ' => ('#'),
    ];
@endphp
@php
    $thirdHeader = [
        'Reboot' => ('#'),
        'Add ' => ('#'),
        'Remove ' => ('#'),
        'Download ' => ('#'),
    ];
@endphp
@php
    $itemCount = App\Models\Auctions::totalcount();
    $fourthHeader = [
        'Active lists' => ('#'),
        'Shortlisted ' => ('#'),
        'port list ' => ('#'),
        'total:' => $itemCount ,
    ];
@endphp
@section('title', 'Auctions List')

<link href="{{ asset('css/style.css') }}" rel="stylesheet">
@section('content')
    <div class="container mt-2">
        <h5 >Cars at Auction</h5>
        <div class="card-body table-responsive">
                <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                    <thead style="pointer-events: none; user-select: none; background-color:#FFDA4B;">
                        <tr>
                            <th>Name</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Build Date</th>
                            <th>Odometer</th>
                            <th>Body Type</th>
                            <th>Fuel</th>
                            <th>Transmission</th>
                            <th>Seats</th>
                            <th>Auctioneer</th>
                            <th>Deadline</th>
                            <th>Link to Auction</th>
                            <th>Link to Condition Report</th>
                            <th>Hours</th>
                            <th>State</th>
                            <th>Redbook Code</th>
                            <th>Redbook Average Wholesale</th>
                            <th>Current Market Retail</th>
                            <th>Auction Registration Link</th>
                            <th>VIN</th>
                            <th>Date Listed</th>
                            <th>Name of Auction</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($auctions as $auction)
                            <tr>
                                <td>{{ $auction->name }}</td>
                                <td>{{ $auction->make }}</td>
                                <td>{{ $auction->model }}</td>
                                <td>{{ $auction->build_date }}</td>
                                <td>{{ $auction->odometer }}</td>
                                <td>{{ $auction->body_type }}</td>
                                <td>{{ $auction->fuel }}</td>
                                <td>{{ $auction->transmission }}</td>
                                <td>{{ $auction->seats }}</td>
                                <td>{{ $auction->auctioneer }}</td>
                                <td>{{ $auction->deadline }}</td>
                                <td><a href="{{ $auction->link_to_auction }}" target="_blank">Auction Link</a></td>
                                <td><a href="{{ $auction->link_to_condition_report }}" target="_blank">Condition Report</a></td>
                                <td>{{ $auction->hours }}</td>
                                <td>{{ $auction->state }}</td>
                                <td>{{ $auction->redbook_code }}</td>
                                <td>{{ $auction->redbook_average_wholesale }}</td>
                                <td>{{ $auction->current_market_retail }}</td>
                                <td><a href="{{ $auction->auction_registration_link }}" target="_blank">Registration Link</a></td>
                                <td>{{ $auction->vin }}</td>
                                <td>{{ $auction->date_listed }}</td>
                                <td>{{ $auction->name_of_auction }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                <div class="pagination-container">
                    {{ $auctions->onEachSide(2)->links('pagination::bootstrap-5') }}
                </div>
            </div>

    </div>
@endsection
