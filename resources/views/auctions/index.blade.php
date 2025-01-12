@extends('admin.layouts.app')
@section('headerTitle', 'Car at Auctions')
@section('title', 'Auctions List')
@section('content')
    <div class="container-fluid mt-2">
        <h5>Cars at Auction</h5>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <button class="btn">Reboot</button>
                    <button class="btn">Add</button>
                    <button class="btn">Remove</button>
                    <button class="btn">Download</button>
                </div>
                <div>Total: <span>{{$totalcount}}</span></div>
            </div>

            <div class="card-body">
                <!-- Filter Buttons -->
                <div class="d-flex card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex" style="gap: 5px;">
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
                            <td>
                                <a href="#" class="text-danger">Hide</a>
                                <a href="#" class="text-warning">Remove</a>
                            </td>
                            <td>{{ $auction->name }}</td>
                            <td>{{ $auction->odometer }}</td>
                            <td>{{ $auction->body_type }}</td>
                            <td>{{ $auction->transmission }}</td>
                            <td>{{ $auction->deadline }}</td>
                            <td>{{ $auction->auctioneer }}</td>
                            <td><a href="#" class="text-primary">Edit</a></td>
                            <td><a href="#" class="text-success">Shortlist It</a></td>
                            <td>
                                <a href="#" class="text-info toggle-details" data-auction-id="{{ $auction->id }}">Expand for Details</a>
                                <a href="#" class="text-danger toggle-details d-none" data-auction-id="{{ $auction->id }}">Revert Expansion</a>
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
        });
    </script>

@endsection
