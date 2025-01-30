@extends('admin.layouts.app')
@section('headerTitle', 'Admin Profile')

@section('content')

    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center" style="color: #5271FF;">
                <h6 class="m-0 font-weight-bold">Admin Profile</h6>
                <div class="d-flex justify-content-end">
                    <a href="{{route('admin.dashboard')}}" class="btn btn-light btn-sm me-2 " style="color: #5271FF;">Back</a>
                    <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-light btn-sm" style="color: #5271FF;">Edit</a>
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
                                        'Name' => 'name',
                                        'Contact Person' => 'contact_person',
                                        'Contact Phone Number' => 'contact_phone_number',
                                        'Email' => 'user.email',
                                    ] as $label => $field)
                                        <li class="list-group-item"><strong>{{ $label }}:</strong> {{ data_get($admin, $field, 'N/A') }}</li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    </div>

                    <!-- Agreements and Policies -->
                    <div class="col-lg-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header" style="color:#5271FF;">
                                <h5><i class="fas fa-file-contract"></i> Agreements and Policies</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @foreach ([
                                        'Master Agreement for WConsoler' => 'master_agreement_for_wconsoler',
                                        'Master Agreement for Partners' => 'master_agreement_for_partners',
                                        'Privacy Policy' => 'privacy_policy_for_all',
                                        'Terms for WC Partners' => 'terms_conditions_wc_partners',
                                        'Terms for WC Consolers' => 'terms_conditions_wc_consolers',
                                    ] as $label => $field)
                                        <li class="list-group-item">
                                            <strong>{{ $label }}:</strong>
                                            @if($admin->$field)
                                                <a href="{{ Storage::url($admin->$field) }}" class="btn" style="color: #5271FF;" target="_blank">
                                                    <i class="fas fa-file-pdf"></i> View {{ explode(' ', $label)[0] }}

                                                </a>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    </div>

                    <!-- Financial Information -->
                    <div class="col-lg-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header" style="color:#5271FF;">
                                <h5><i class="fas fa-wallet"></i> Financial Information</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @foreach ([
                                        'ABN Number' => 'abn_number',
                                        'Banking Detail' => 'banking_detail',
                                        'BSB Number' => 'bsb_number',
                                    ] as $label => $field)
                                        <li class="list-group-item"><strong>{{ $label }}:</strong> {{ $admin->$field ?? 'N/A' }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header" style="color:#5271FF;">
                        <h5><i class="fas fa-info-circle"></i> Additional Details</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">No additional details available for this admin.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.model')
@endsection
