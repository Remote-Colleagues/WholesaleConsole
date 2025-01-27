@extends('admin.layouts.app')
@section('headerTitle', 'Consoler Details')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center" style="color: #5271FF;">
                <h6 class="m-0 font-weight-bold">Consoler Details</h6>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('consoler.list') }}" class="btn btn-light btn-sm me-2 " style="color: #5271FF;">Back to List</a>
                    <a href="{{ route('consoler.edit', $user->id) }}" class="btn btn-light btn-sm" style="color: #5271FF;">Edit</a>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Basic Information -->
                    <div class="col-lg-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header" style="color: #5271FF;">
                                <h5><i class="fas fa-user"></i> Basic Information</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @foreach ([
                                        'name' => 'Name',
                                        'email' => 'Email',
                                        'status' => 'Status'
                                    ] as $field => $label)
                                        <li class="list-group-item">
                                            <strong>{{ $label }}:</strong>
                                            @if($field == 'name')
                                                {{ ucwords(strtolower($user->$field)) }}
                                            @elseif($field == 'status')
                                                {{ ucwords($user->$field) }}
                                            @else
                                                {{ $user->$field }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    </div>

                    <!-- Console Information -->
                    <div class="col-lg-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header" style="color:#5271FF;">
                                <h5><i class="fas fa-laptop"></i> Console Details</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @foreach ([
                                        'console_name' => 'Console Name',
                                        'contact_person' => 'Contact Person',
                                        'contact_phone_number' => 'Contact Phone Number',
                                        'abn_number' => 'ABN Number'
                                    ] as $field => $label)
                                        <li class="list-group-item">
                                            <strong>{{ $label }}:</strong>
                                            @if($field == 'console_name' || $field == 'contact_person')
                                                {{ ucwords(strtolower($user->consoler->$field ?? 'N/A')) }}
                                            @else
                                                {{ $user->consoler->$field ?? 'N/A' }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="col-lg-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header" style="color:#5271FF;">
                                <h5><i class="fas fa-map-marker-alt"></i> Address Details</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @foreach ([
                                        'building' => 'Building',
                                        'city' => 'City',
                                        'state' => 'State',
                                        'country' => 'Country',
                                        'post_code' => 'Post Code'
                                    ] as $field => $label)
                                        <li class="list-group-item"><strong>{{ $label }}:</strong> {{ $user->consoler->$field ?? 'N/A' }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Information -->
                <div class="card shadow-sm">
                    <div class="card-header" style="color:#5271FF;">
                        <h5><i class="fas fa-credit-card"></i> Financial Information</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Your Agreement:</strong>
                                @if($user->consoler && $user->consoler->your_agreement)
                                    <a href="{{ Storage::url($user->consoler->your_agreement) }}" class="btn" style="color: #5271FF" target="_blank">
                                        <i class="fas fa-file-pdf"></i> View Agreement
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </li>
                            @foreach ([
                                'billing_commencement_period' => 'Billing Commencement Period',
                                'currency' => 'Currency',
                                'establishment_fee' => 'Establishment Fee',
                                'establishment_fee_date' => 'Establishment Fee Date',
                                'monthly_subscription_fee' => 'Monthly Subscription Fee',
                                'monthly_subscription_fee_date' => 'Monthly Subscription Fee Date',
                                'admin_fee' => 'Admin Fee',
                                'admin_fee_date' => 'Admin Fee Date',
                                'comm_charge' => 'Commission Charge',
                                'comm_charge_date' => 'Commission Charge Date'
                            ] as $field => $label)
                                <li class="list-group-item"><strong>{{ $label }}:</strong> {{ $user->consoler->$field ?? 'N/A' }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.model')
@endsection
