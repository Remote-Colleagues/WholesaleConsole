@extends('admin.layouts.app')
@section('headerTitle', 'Transport Calculator Details')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header" style="color: #5271FF;">
                        <h5><i class="fas fa-truck"></i> Transport Information</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Per KM Charge:</strong> {{ $transportCalculator->per_km_charge }}
                            </li>
                            <li class="list-group-item">
                                <strong>Same State Charge:</strong> {{ $transportCalculator->same_state_charge }}
                            </li>
                            <li class="list-group-item">
                                <strong>Cross State Charge:</strong> {{ $transportCalculator->cross_state_charge }}
                            </li>
                            <li class="list-group-item">
                                <strong>Additional Charges:</strong> {{ $transportCalculator->additional_charges }}
                            </li>
                            <li class="list-group-item">
                                <strong>Body Type:</strong> {{ $transportCalculator->body_type }}
                            </li>
                            <li class="list-group-item">
                                <strong>Categories:</strong> {{ $transportCalculator->categories }}
                            </li>
                            <li class="list-group-item">
                                <strong>User:</strong> {{ $transportCalculator->user->name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <a href="{{ route('calculate.list') }}" class="btn " style="color: #5271FF;">Back to List</a>
        <a href="{{ route('calculate.edit', $transportCalculator->id) }}" class="btn border-2" style="color: #5271FF; border-color: #5271FF;">Edit</a>

    </div>

@endsection
