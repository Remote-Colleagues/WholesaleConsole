
@extends('admin.layouts.app')
@section('headerTitle', 'Partnerr Details')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center" style="color: #5271FF;">
                <h6 class="m-0 font-weight-bold">Partnerr Details</h6>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('partner.list') }}" class="btn btn-light btn-sm me-2" style="color: #5271FF;">Back to List</a>
                    <a href="{{route('partner.edit',$user->id)}}" class="btn btn-light btn-sm" style="color: #5271FF;">Edit</a>
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
                                            <strong>{{ $label }}:</strong> {{ $field === 'name' ? ucwords(strtolower($user->$field)) : $user->$field }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Partner Information -->
                    <div class="col-lg-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header" style="color: #5271FF;">
                                <h5><i class="fas fa-laptop"></i> Partner Details</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @foreach ([
                                        'partner_name' => 'Partner Name',
                                        'contact_person' => 'Contact Person',
                                        'contact_phone_number' => 'Contact Phone Number',
                                        'abn_number' => 'ABN Number'
                                    ] as $field => $label)
                                        <li class="list-group-item">
                                            <strong>{{ $label }}:</strong> {{ $user->partner->$field ?? 'N/A' }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="col-lg-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header" style="color: #5271FF;">
                                <h5><i class="fas fa-map-marker-alt"></i> Address Details</h5>
                            </div>
                            <div class="card-body">

                                <ul class="list-group list-group-flush">
                                    @if (!empty($operation_locations) && count($operation_locations) > 0)
                                        @foreach ($operation_locations as $index => $location)
                                            <li class="list-group-item">
                                                <strong>Location {{ $index + 1 }}:</strong> {{ trim($location) }}
                                            </li>
                                        @endforeach
                                    @else
                                        <li class="list-group-item">
                                            <strong>Operation Location:</strong> Not Provided
                                        </li>
                                    @endif
                                </ul>


                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial and Agreement Information -->
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header" style="color: #5271FF;">
                                <h5><i class="fas fa-credit-card"></i> Financial Information in AUD</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <strong>Your Agreement:</strong>
                                        @if($user->partner && $user->partner->your_agreement)
                                            <a href="{{ Storage::url($user->partner->your_agreement) }}" class="btn" style="color: #5271FF" target="_blank">
                                                <i class="fas fa-file-pdf"></i> View Agreement
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </li>
                                    <li class="list-group-item">
                                       <strong>Currency:</strong> AUD
                                    </li>
                                    @foreach ([
                                        'billing_commencement_date' => 'Billing Commencement Period',
                                        'establishment_fee' => 'Establishment Fee',
                                        'premium_charged'=>'Premium Charged',
                                        'monthly_subscription_fee' => 'Monthly Subscription Fee',
                                        'csvusernumber' => 'CSV Number'
                                    ] as $field => $label)
                                        <li class="list-group-item">
                                            <strong>{{ $label }}:</strong> {{ $user->partner->$field ?? 'N/A' }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header" style="color: #5271FF;">
                                <h5><i class="fas fa-file-contract"></i> Agreement Information</h5>
                            </div>
                            <div class="card-body">
                                @if($user->email_verified_at)
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <strong>Master Agreement with WPartner:</strong>
                                            <a href="{{ route('view.partneragreement.pdf', ['userId' => $user->id, 'agreement' => 'master']) }}" target="_blank" class="hover:underline" style="color: #5271FF;">
                                                View Agreement
                                            </a>
                                        </li>

                                        <li class="list-group-item">
                                            <strong>Terms of services with WPartner:</strong>
                                            <a href="{{ route('view.partneragreement.pdf', ['userId' => $user->id, 'agreement' => 'term']) }}" target="_blank" class="hover:underline" style="color: #5271FF;">
                                                View Agreement
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Services schedule with WPartner:</strong>
                                            <a href="{{ route('view.partneragreement.pdf', ['userId' => $user->id, 'agreement' => 'services']) }}" target="_blank" class="hover:underline" style="color: #5271FF;">
                                                View Agreement
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Agreement Date:</strong> {{ \Carbon\Carbon::parse($user->email_verified_at)->format('Y-m-d') }}

                                        </li>
                                    </ul>
                                @else
                                    <p class="text-muted">Email not verified. Agreement details unavailable.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('layouts.model')
@endsection

