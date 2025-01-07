@extends('admin.layouts.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800" style="pointer-events: none; user-select: none;">Consoler Details</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary pointer-events-none user-select-none">Consoler Details</h6>
        </div>
        <div class="card-body">
            @if ($consoler)
                <div class="row">
                    <div class="col-md-4" style="pointer-events: none; user-select: none;">
                        <p><strong>Console Name:</strong></p>
                        <p><strong>Contact Person:</strong></p>
                        <p><strong>Contact Phone Number:</strong></p>
                        <p><strong>ABN Number:</strong></p>
                        <p><strong>Operational Location:</strong></p>
                        <p><strong>Agreement Uploaded:</strong></p>
                        <p><strong>Billing Commencement Period:</strong></p>
                        <p><strong>Currency:</strong></p>
                        <p><strong>Establishment Fee:</strong></p>
                        <p><strong>Ongoing Monthly Subscription Fee:</strong></p>
                        <p><strong>Admin Fee for Buyers Connect:</strong></p>
                        <p><strong>Commission Charge for Buyers Connect:</strong></p>
                    </div>
                    <div class="col-md-4" >
                        <p>{{ $consoler->console_name }}</p>
                        <p>{{ $consoler->contact_person }}</p>
                        <p>{{ $consoler->contact_phone_number }}</p>
                        <p>{{ $consoler->abn_number }}</p>
                        <p>
                            {{ $consoler->building }},
                            {{ $consoler->city }},
                            {{ $consoler->state }},
                            {{ $consoler->country }},
                            {{ $consoler->post_code }}
                        </p>
                        <p>
                            @if ($consoler->your_agreement)
                                <a href="{{ asset('storage/' . $consoler->your_agreement)}}" target="_blank" class="btn btn-info btn-sm">View Agreement</a>
                            @else
                                No agreement uploaded
                            @endif
                        </p>
                        <p>{{ $consoler->billing_commencement_period }}</p>
                        <p>{{ $consoler->currency }}</p>
                        <p>{{ $consoler->establishment_fee }} (Last Changed: {{ $consoler->establishment_fee_date }})</p>
                        <p>{{ $consoler->monthly_subscription_fee }} (Last Changed: {{ $consoler->monthly_subscription_fee_date }})</p>
                        <p>{{ $consoler->admin_fee }} (Last Changed: {{ $consoler->admin_fee_date }})</p>
                        <p>{{ $consoler->comm_charge }} (Last Changed: {{ $consoler->comm_charge_date }})</p>
                    </div>
                </div>
            @else
                <p>No details available for this Consoler.</p>
            @endif
        </div>
        
        <a href="{{ route('consoler.list') }}" class="btn btn-secondary btn-sm form-label col-sm-1">Back</a>

    </div>

</div>
@endsection
