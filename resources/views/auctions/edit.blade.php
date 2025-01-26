@extends('admin.layouts.app')

@section('headerTitle', 'Edit Auction')
@section('title', 'Edit Auction')

@section('content')
<div class="container mt-5">
    <h5 class="text-primary">Edit Auction</h5>
    <form action="{{ route('auctions.update', $auction->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $auction->name }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="make" class="form-label">Make</label>
                <input type="text" class="form-control" id="make" name="make" value="{{ $auction->make }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model" value="{{ $auction->model }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="build_date" class="form-label">Build Date</label>
                <input type="date" class="form-control" id="build_date" name="build_date" value="{{ $auction->build_date ? $auction->build_date->format('Y-m-d') : '' }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="odometer" class="form-label">Odometer</label>
                <input type="number" class="form-control" id="odometer" name="odometer" value="{{ $auction->odometer }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="body_type" class="form-label">Body Type</label>
                <input type="text" class="form-control" id="body_type" name="body_type" value="{{ $auction->body_type }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="fuel" class="form-label">Fuel</label>
                <input type="text" class="form-control" id="fuel" name="fuel" value="{{ $auction->fuel }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="transmission" class="form-label">Transmission</label>
                <input type="text" class="form-control" id="transmission" name="transmission" value="{{ $auction->transmission }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="seats" class="form-label">Seats</label>
                <input type="number" class="form-control" id="seats" name="seats" value="{{ $auction->seats }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="auctioneer" class="form-label">Auctioneer</label>
                <input type="text" class="form-control" id="auctioneer" name="auctioneer" value="{{ $auction->auctioneer }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="link_to_auction" class="form-label">Link to Auction</label>
                <input type="url" class="form-control" id="link_to_auction" name="link_to_auction" value="{{ $auction->link_to_auction }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="other_specs" class="form-label">Other Specs</label>
                <textarea class="form-control" id="other_specs" name="other_specs" rows="3">{{ $auction->other_specs }}</textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label for="unique_identifier" class="form-label">Unique Identifier</label>
                <input type="text" class="form-control" id="unique_identifier" name="unique_identifier" value="{{ $auction->unique_identifier }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="state" class="form-label">State</label>
                <input type="text" class="form-control" id="state" name="state" value="{{ $auction->state }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="vin" class="form-label">VIN</label>
                <input type="text" class="form-control" id="vin" name="vin" value="{{ $auction->vin }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="hours" class="form-label">Hours</label>
                <input type="number" class="form-control" id="hours" name="hours" value="{{ $auction->hours }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="datetime-local" class="form-control" id="deadline" name="deadline" value="{{ $auction->deadline ? \Carbon\Carbon::parse($auction->deadline)->format('Y-m-d\TH:i') : '' }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="{{ route('auctions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
