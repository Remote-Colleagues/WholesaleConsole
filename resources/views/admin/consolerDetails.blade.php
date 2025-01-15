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
                <div class="col-md-6 mb-4">
                    <h4 class="text-primary mb-3">Basic Information</h4>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Name:</strong> {{ $user->name }}
                        </li>
                        <li class="list-group-item">
                            <strong>Email:</strong> {{ $user->email }}
                        </li>
                    </ul>
                </div>

                <!-- Console Information -->
                <div class="col-md-6 mb-4">
                    <h4 class="text-primary mb-3">Console Information</h4>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Console Name:</strong> {{ $user->consoler->console_name ?? 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Contact Person:</strong> {{ $user->consoler->contact_person ?? 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Contact Phone Number:</strong> {{ $user->consoler->contact_phone_number ?? 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            <strong>ABN Number:</strong> {{ $user->consoler->abn_number ?? 'N/A' }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <!-- Address Information -->
                <div class="col-md-6 mb-4">
                    <h4 class="text-primary mb-3">Address Details</h4>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Building:</strong> {{ $user->consoler->building ?? 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            <strong>City:</strong> {{ $user->consoler->city ?? 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            <strong>State:</strong> {{ $user->consoler->state ?? 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Country:</strong> {{ $user->consoler->country ?? 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Post Code:</strong> {{ $user->consoler->post_code ?? 'N/A' }}
                        </li>
                    </ul>
                </div>

                <!-- Financial Information -->
                <div class="col-md-6 mb-4">
                    <h4 class="text-primary mb-3">Financial Information</h4>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Billing Commencement Period:</strong> {{ $user->consoler->billing_commencement_period ?? 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Establishment Fee:</strong> {{ $user->consoler->establishment_fee ?? 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Monthly Subscription Fee:</strong> {{ $user->consoler->monthly_subscription_fee ?? 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Admin Fee:</strong> {{ $user->consoler->admin_fee ?? 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Commission Charge:</strong> {{ $user->consoler->comm_charge ?? 'N/A' }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
