@extends('admin.layouts.app')
@section('headerTitle', 'Consoler Details')

@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background-color: #00E1A1; color: #fff;">
            <h6 class="m-0 font-weight-bold">Consoler Details</h6>
            <a href="{{ route('consoler.list') }}" class="btn btn-light btn-sm">Back to List</a>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Basic Information -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header text-white" style="background-color: #1D5B59;">
                            <h5><i class="fas fa-user"></i> Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
                                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Console Information -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header text-white" style="background-color: #1D5B59;">
                            <h5><i class="fas fa-laptop"></i> Console Details</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Console Name:</strong> {{ $user->consoler->console_name ?? 'N/A' }}</li>
                                <li class="list-group-item"><strong>Contact Person:</strong> {{ $user->consoler->contact_person ?? 'N/A' }}</li>
                                <li class="list-group-item"><strong>Contact Phone Number:</strong> {{ $user->consoler->contact_phone_number ?? 'N/A' }}</li>
                                <li class="list-group-item"><strong>ABN Number:</strong> {{ $user->consoler->abn_number ?? 'N/A' }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Address Information (Optional, kept in same row) -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header text-white" style="background-color: #1D5B59;">
                            <h5><i class="fas fa-map-marker-alt"></i> Address Details</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Building:</strong> {{ $user->consoler->building ?? 'N/A' }}</li>
                                <li class="list-group-item"><strong>City:</strong> {{ $user->consoler->city ?? 'N/A' }}</li>
                                <li class="list-group-item"><strong>State:</strong> {{ $user->consoler->state ?? 'N/A' }}</li>
                                <li class="list-group-item"><strong>Country:</strong> {{ $user->consoler->country ?? 'N/A' }}</li>
                                <li class="list-group-item"><strong>Post Code:</strong> {{ $user->consoler->post_code ?? 'N/A' }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Information (In a Single Column) -->
            <div class="card shadow-sm">
                <div class="card-header text-white" style="background-color: #1D5B59;">
                    <h5><i class="fas fa-credit-card"></i> Financial Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Your Agreement:</strong> 
                            @if($user->consoler && $user->consoler->your_agreement)
                                <a href="{{ Storage::url($user->consoler->your_agreement) }}" class="btn btn-success" target="_blank">
                                    <i class="fas fa-file-pdf"></i> View Agreement
                                </a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </li>
                        
                        <li class="list-group-item"><strong>Billing Commencement Period:</strong> {{ $user->consoler->billing_commencement_period ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Currency:</strong> {{ $user->consoler->currency ?? 'AUD' }}</li>
                        <li class="list-group-item"><strong>Establishment Fee:</strong> {{ $user->consoler->establishment_fee ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Establishment Fee Date:</strong> {{ $user->consoler->establishment_fee_date ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Monthly Subscription Fee:</strong> {{ $user->consoler->monthly_subscription_fee ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Monthly Subscription Fee Date:</strong> {{ $user->consoler->monthly_subscription_fee_date ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Admin Fee:</strong> {{ $user->consoler->admin_fee ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Admin Fee Date:</strong> {{ $user->consoler->admin_fee_date ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Commission Charge:</strong> {{ $user->consoler->comm_charge ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Commission Charge Date:</strong> {{ $user->consoler->comm_charge_date ?? 'N/A' }}</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
