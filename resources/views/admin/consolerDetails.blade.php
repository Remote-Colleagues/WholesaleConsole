@extends('admin.layouts.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Consoler Details</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Consoler Details</h6>
        </div>
        <div class="card-body">
            @if ($consoler)
                <ul>
                    <li><strong>Console Name:</strong> {{ $consoler->console_name }}</li>
                    <li><strong>Contact Person:</strong> {{ $consoler->contact_person }}</li>
                    <li><strong>Contact Phone Number:</strong> {{ $consoler->contact_phone_number }}</li>
                    <li><strong>ABN Number:</strong> {{ $consoler->abn_number }}</li>
                    <li><strong>Operational Location:</strong> 
                        {{ $consoler->building }},
                        {{ $consoler->city }},
                        {{ $consoler->state }},
                        {{ $consoler->country }},
                        {{ $consoler->post_code }}
                    </li>
                    <li><strong>Agreement Uploaded:</strong> 
                        @if ($consoler->your_agreement)
                            <a href="{{ asset('storage/' . $consoler->your_agreement)}}" target="_blank" class="btn btn-info btn-sm">View Agreement</a>
                        @else
                            No agreement uploaded
                        @endif
                    </li>
                    <li><strong>Billing Commencement Period:</strong> {{ $consoler->billing_commencement_period }}</li>
                    <li><strong>Currency:</strong> {{ $consoler->currency }}</li>
                    <li><strong>Establishment Fee:</strong> {{ $consoler->establishment_fee }} (Last Changed: {{ $consoler->establishment_fee_date }})</li>
                    <li><strong>Ongoing Monthly Subscription Fee:</strong> {{ $consoler->monthly_subscription_fee }} (Last Changed: {{ $consoler->monthly_subscription_fee_date }})</li>
                    <li><strong>Admin Fee for Buyers Connect:</strong> {{ $consoler->admin_fee }} (Last Changed: {{ $consoler->admin_fee_date }})</li>
                    <li><strong>Commission Charge for Buyers Connect:</strong> {{ $consoler->comm_charge }} (Last Changed: {{ $consoler->comm_charge_date }})</li>
                </ul>
            @else
                <p>No details available for this Consoler.</p>
            @endif
        </div>
        
    <a href="{{ route('consoler.list') }}" class="btn btn-secondary btn-sm form-label col-sm-1">Back</a>

    </div>

</div>
@endsection
