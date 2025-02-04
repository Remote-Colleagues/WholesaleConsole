{{--@extends('consoler.layouts.app')--}}
{{--@section('headerTitle', 'your Details')--}}

{{--@section('content')--}}

{{--<div class="container-fluid">--}}
{{--    <div class="card shadow mb-4">--}}
{{--        <div class="card-header py-3 d-flex justify-content-between align-items-center" style="color: #5271FF;">--}}
{{--            <h6 class="m-0 font-weight-bold">your Details</h6>--}}

{{--        </div>--}}

{{--        <div class="card-body">--}}
{{--            <div class="row">--}}
{{--                <!-- Basic Information -->--}}
{{--                <div class="col-lg-4 mb-4">--}}
{{--                    <div class="card shadow-sm">--}}
{{--                        <div class="card-header " style="color: #5271FF;">--}}
{{--                            <h5><i class="fas fa-user"></i> Basic Information</h5>--}}
{{--                        </div>--}}
{{--                        <div class="card-body">--}}
{{--                            <ul class="list-group list-group-flush">--}}
{{--                                <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>--}}
{{--                                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>--}}
{{--                                <li class="list-group-item"><strong>Status:</strong> {{ $user->status }}</li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <!-- Console Information -->--}}
{{--                <div class="col-lg-4 mb-4">--}}
{{--                    <div class="card shadow-sm">--}}
{{--                        <div class="card-header" style="color:#5271FF;">--}}
{{--                            <h5><i class="fas fa-laptop"></i> Console Details</h5>--}}
{{--                        </div>--}}
{{--                        <div class="card-body">--}}
{{--                            <ul class="list-group list-group-flush">--}}
{{--                                <li class="list-group-item"><strong>Console Name:</strong> {{ $user->consoler->console_name ?? 'N/A' }}</li>--}}
{{--                                <li class="list-group-item"><strong>Contact Person:</strong> {{ $user->consoler->contact_person ?? 'N/A' }}</li>--}}
{{--                                <li class="list-group-item"><strong>Contact Phone Number:</strong> {{ $user->consoler->contact_phone_number ?? 'N/A' }}</li>--}}
{{--                                <li class="list-group-item"><strong>ABN Number:</strong> {{ $user->consoler->abn_number ?? 'N/A' }}</li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <!-- Address Information (Optional, kept in same row) -->--}}
{{--                <div class="col-lg-4 mb-4">--}}
{{--                    <div class="card shadow-sm">--}}
{{--                        <div class="card-header " style="color:#5271FF;">--}}
{{--                            <h5><i class="fas fa-map-marker-alt"></i> Address Details</h5>--}}
{{--                        </div>--}}
{{--                        <div class="card-body">--}}
{{--                            <ul class="list-group list-group-flush">--}}
{{--                                <li class="list-group-item"><strong>Building:</strong> {{ $user->consoler->building ?? 'N/A' }}</li>--}}
{{--                                <li class="list-group-item"><strong>City:</strong> {{ $user->consoler->city ?? 'N/A' }}</li>--}}
{{--                                <li class="list-group-item"><strong>State:</strong> {{ $user->consoler->state ?? 'N/A' }}</li>--}}
{{--                                <li class="list-group-item"><strong>Country:</strong> {{ $user->consoler->country ?? 'N/A' }}</li>--}}
{{--                                <li class="list-group-item"><strong>Post Code:</strong> {{ $user->consoler->post_code ?? 'N/A' }}</li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- Financial Information (In a Single Column) -->--}}
{{--            <div class="card shadow-sm">--}}
{{--                <div class="card-header " style="color:#5271FF;">--}}
{{--                    <h5><i class="fas fa-credit-card"></i> Financial Information</h5>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <ul class="list-group list-group-flush">--}}
{{--                        <li class="list-group-item">--}}
{{--                            <strong>Your Agreement:</strong>--}}
{{--                            @if($user->consoler && $user->consoler->your_agreement)--}}
{{--                                <a href="{{ Storage::url($user->consoler->your_agreement) }}" class="btn " style="color: #5271FF" target="_blank">--}}
{{--                                    <i class="fas fa-file-pdf"></i> View Agreement--}}
{{--                                </a>--}}
{{--                            @else--}}
{{--                                <span class="text-muted">N/A</span>--}}
{{--                            @endif--}}
{{--                        </li>--}}

{{--                        <li class="list-group-item"><strong>Billing Commencement Period:</strong> {{ $user->consoler->billing_commencement_period ?? 'N/A' }}</li>--}}
{{--                        <li class="list-group-item"><strong>Currency:</strong> {{ $user->consoler->currency ?? 'AUD' }}</li>--}}
{{--                        <li class="list-group-item"><strong>Establishment Fee:</strong> {{ $user->consoler->establishment_fee ?? 'N/A' }}</li>--}}
{{--                        <li class="list-group-item"><strong>Establishment Fee Date:</strong> {{ $user->consoler->establishment_fee_date ?? 'N/A' }}</li>--}}
{{--                        <li class="list-group-item"><strong>Monthly Subscription Fee:</strong> {{ $user->consoler->monthly_subscription_fee ?? 'N/A' }}</li>--}}
{{--                        <li class="list-group-item"><strong>Monthly Subscription Fee Date:</strong> {{ $user->consoler->monthly_subscription_fee_date ?? 'N/A' }}</li>--}}
{{--                        <li class="list-group-item"><strong>Admin Fee:</strong> {{ $user->consoler->admin_fee ?? 'N/A' }}</li>--}}
{{--                        <li class="list-group-item"><strong>Admin Fee Date:</strong> {{ $user->consoler->admin_fee_date ?? 'N/A' }}</li>--}}
{{--                        <li class="list-group-item"><strong>Commission Charge:</strong> {{ $user->consoler->comm_charge ?? 'N/A' }}</li>--}}
{{--                        <li class="list-group-item"><strong>Commission Charge Date:</strong> {{ $user->consoler->comm_charge_date ?? 'N/A' }}</li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- Financial and Agreement Information -->--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-6 mb-4">--}}
{{--                    <div class="card shadow-sm">--}}
{{--                        <div class="card-header" style="color: #5271FF;">--}}
{{--                            <h5><i class="fas fa-credit-card"></i> Financial Information</h5>--}}
{{--                        </div>--}}
{{--                        <div class="card-body">--}}
{{--                            <ul class="list-group list-group-flush">--}}
{{--                                <li class="list-group-item">--}}
{{--                                    <strong>Your Agreement:</strong>--}}
{{--                                    @if($user->consoler && $user->consoler->your_agreement)--}}
{{--                                        <a href="{{ Storage::url($user->consoler->your_agreement) }}" class="btn" style="color: #5271FF" target="_blank">--}}
{{--                                            <i class="fas fa-file-pdf"></i> View Agreement--}}
{{--                                        </a>--}}
{{--                                    @else--}}
{{--                                        <span class="text-muted">N/A</span>--}}
{{--                                    @endif--}}
{{--                                </li>--}}
{{--                                @foreach ([--}}
{{--                                    'billing_commencement_period' => 'Billing Commencement Period',--}}
{{--                                    'currency' => 'Currency',--}}
{{--                                    'establishment_fee' => 'Establishment Fee',--}}
{{--                                    'establishment_fee_date' => 'Establishment Fee Date',--}}
{{--                                    'monthly_subscription_fee' => 'Monthly Subscription Fee',--}}
{{--                                    'monthly_subscription_fee_date' => 'Monthly Subscription Fee Date',--}}
{{--                                    'admin_fee' => 'Admin Fee',--}}
{{--                                    'admin_fee_date' => 'Admin Fee Date',--}}
{{--                                    'comm_charge' => 'Commission Charge',--}}
{{--                                    'comm_charge_date' => 'Commission Charge Date'--}}
{{--                                ] as $field => $label)--}}
{{--                                    <li class="list-group-item">--}}
{{--                                        <strong>{{ $label }}:</strong> {{ $user->consoler->$field ?? 'N/A' }}--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="col-lg-6 mb-4">--}}
{{--                    <div class="card shadow-sm">--}}
{{--                        <div class="card-header" style="color: #5271FF;">--}}
{{--                            <h5><i class="fas fa-file-contract"></i> Agreement Information</h5>--}}
{{--                        </div>--}}
{{--                        <div class="card-body">--}}
{{--                            @if($user->email_verified_at)--}}
{{--                                <ul class="list-group list-group-flush">--}}
{{--                                    <li class="list-group-item">--}}
{{--                                        <strong>Master Agreement with WConsole:</strong>--}}
{{--                                        <a href="{{ asset('storage/' . $admin->master_agreement_for_wconsoler) }}" target="_blank" class="hover:underline" style="color: #5271FF;">--}}
{{--                                            View Agreement--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="list-group-item">--}}
{{--                                        <strong>Terms of Service with WConsole:</strong>--}}
{{--                                        <a href="{{ asset('storage/' . $admin->terms_conditions_wc_consolers) }}" target="_blank" class="hover:underline" style="color: #5271FF;">--}}
{{--                                            Terms of Service--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="list-group-item">--}}
{{--                                        <strong>Service Schedule with WConsole:</strong>--}}
{{--                                        <a href="{{ asset('storage/agreements/' . basename($user->consoler->your_agreement)) }}" target="_blank" class="hover:underline" style="color: #5271FF;">--}}
{{--                                            Service Schedule--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="list-group-item">--}}
{{--                                        --}}{{--                                        <strong>Agreement Date:</strong> {{$user->email_verified_at}}--}}
{{--                                        <strong>Agreement Date:</strong> {{ \Carbon\Carbon::parse($user->email_verified_at)->format('Y-m-d') }}--}}

{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            @else--}}
{{--                                <p class="text-muted">Email not verified. Agreement details unavailable.</p>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--@include('layouts.model')--}}
{{--@endsection--}}


@extends('consoler.layouts.app')
@section('headerTitle', 'your Details')

@section('content')

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center" style="color: #5271FF;">
                <h6 class="m-0 font-weight-bold">your Details</h6>

            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Basic Information -->
                    <div class="col-lg-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header " style="color: #5271FF;">
                                <h5><i class="fas fa-user"></i> Basic Information</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
                                    <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                                    <li class="list-group-item"><strong>Status:</strong> {{ $user->status }}</li>
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
                            <div class="card-header " style="color:#5271FF;">
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

                {{--            <!-- Financial Information (In a Single Column) -->--}}
                {{--            <div class="card shadow-sm">--}}
                {{--                <div class="card-header " style="color:#5271FF;">--}}
                {{--                    <h5><i class="fas fa-credit-card"></i> Financial Information</h5>--}}
                {{--                </div>--}}
                {{--                <div class="card-body">--}}
                {{--                    <ul class="list-group list-group-flush">--}}
                {{--                        <li class="list-group-item">--}}
                {{--                            <strong>Your Agreement:</strong>--}}
                {{--                            @if($user->consoler && $user->consoler->your_agreement)--}}
                {{--                                <a href="{{ Storage::url($user->consoler->your_agreement) }}" class="btn " style="color: #5271FF" target="_blank">--}}
                {{--                                    <i class="fas fa-file-pdf"></i> View Agreement--}}
                {{--                                </a>--}}
                {{--                            @else--}}
                {{--                                <span class="text-muted">N/A</span>--}}
                {{--                            @endif--}}
                {{--                        </li>--}}

                {{--                        <li class="list-group-item"><strong>Billing Commencement Period:</strong> {{ $user->consoler->billing_commencement_period ?? 'N/A' }}</li>--}}
                {{--                        <li class="list-group-item"><strong>Currency:</strong> {{ $user->consoler->currency ?? 'AUD' }}</li>--}}
                {{--                        <li class="list-group-item"><strong>Establishment Fee:</strong> {{ $user->consoler->establishment_fee ?? 'N/A' }}</li>--}}
                {{--                        <li class="list-group-item"><strong>Establishment Fee Date:</strong> {{ $user->consoler->establishment_fee_date ?? 'N/A' }}</li>--}}
                {{--                        <li class="list-group-item"><strong>Monthly Subscription Fee:</strong> {{ $user->consoler->monthly_subscription_fee ?? 'N/A' }}</li>--}}
                {{--                        <li class="list-group-item"><strong>Monthly Subscription Fee Date:</strong> {{ $user->consoler->monthly_subscription_fee_date ?? 'N/A' }}</li>--}}
                {{--                        <li class="list-group-item"><strong>Admin Fee:</strong> {{ $user->consoler->admin_fee ?? 'N/A' }}</li>--}}
                {{--                        <li class="list-group-item"><strong>Admin Fee Date:</strong> {{ $user->consoler->admin_fee_date ?? 'N/A' }}</li>--}}
                {{--                        <li class="list-group-item"><strong>Commission Charge:</strong> {{ $user->consoler->comm_charge ?? 'N/A' }}</li>--}}
                {{--                        <li class="list-group-item"><strong>Commission Charge Date:</strong> {{ $user->consoler->comm_charge_date ?? 'N/A' }}</li>--}}
                {{--                    </ul>--}}
                {{--                </div>--}}
                {{--            </div>--}}

                <!-- Financial and Agreement Information -->
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header" style="color: #5271FF;">
                                <h5><i class="fas fa-credit-card"></i> Financial Information</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <strong>Your Agreement:</strong>
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
                                        <li class="list-group-item">
                                            <strong>{{ $label }}:</strong> {{ $user->consoler->$field ?? 'N/A' }}
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
                                            <strong>Master Agreement with WConsole:</strong>
                                            <a href="{{ route('view.agreement.pdf', ['userId' => $user->id, 'agreement' => 'master']) }}" target="_blank" class="hover:underline" style="color: #5271FF;">
                                                View Agreement
                                            </a>
                                        </li>

                                        <li class="list-group-item">
                                            <strong>Terms of services with WConsole:</strong>
                                            <a href="{{ route('view.agreement.pdf', ['userId' => $user->id, 'agreement' => 'term']) }}" target="_blank" class="hover:underline" style="color: #5271FF;">
                                                View Agreement
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Services schedule with WConsole:</strong>
                                            <a href="{{ route('view.agreement.pdf', ['userId' => $user->id, 'agreement' => 'services']) }}" target="_blank" class="hover:underline" style="color: #5271FF;">
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
