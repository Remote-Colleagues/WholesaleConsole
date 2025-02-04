@extends('admin.layouts.app')
@section('headerTitle', 'Edit Transport Calculator')

@section('content')

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3  d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold" style="pointer-events: none; user-select: none; color: #5271FF;">Edit Transport Calculator</h6>
                <a href="{{ route('calculate.list') }}" class="btn " style="color: #5271FF;">Back to List</a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('calculate.update', $transportCalculator->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 d-flex">
                        <label for="per_km_charge" class="form-label col-sm-3">Per KM Charge</label>
                        <input type="number" class="form-control form-control-sm col-sm-3" id="per_km_charge" name="per_km_charge" value="{{ $transportCalculator->per_km_charge }}" required>
                    </div>

                    <div class="mb-3 d-flex">
                        <label for="same_state_charge" class="form-label col-sm-3">Same State Charge</label>
                        <input type="number" class="form-control form-control-sm col-sm-3" id="same_state_charge" name="same_state_charge" value="{{ $transportCalculator->same_state_charge }}" required>
                    </div>

                    <div class="mb-3 d-flex">
                        <label for="cross_state_charge" class="form-label col-sm-3">Cross State Charge</label>
                        <input type="number" class="form-control form-control-sm col-sm-3" id="cross_state_charge" name="cross_state_charge" value="{{ $transportCalculator->cross_state_charge }}" required>
                    </div>

                    <div class="mb-3 d-flex">
                        <label for="additional_charges" class="form-label col-sm-3">Additional Charges</label>
                        <input type="number" class="form-control form-control-sm col-sm-3" id="additional_charges" name="additional_charges" value="{{ $transportCalculator->additional_charges }}" required>
                    </div>

                    <div class="mb-3 d-flex">
                        <label for="additional_charge_for_size" class="form-label col-sm-3">Additional Charge for Size</label>
                        <input type="number" class="form-control form-control-sm col-sm-3" id="additional_charge_for_size" name="additional_charge_for_size" value="{{ $transportCalculator->additional_charge_for_size }}" required>
                    </div>

                    <div class="mb-3 d-flex">
                        <label for="body_type" class="form-label col-sm-3">Body Type</label>
                        <select class="form-control form-control-sm col-sm-3" id="body_type" name="body_type" required onchange="toggleOtherInput(this)">
                            @foreach($bodyTypes as $bodyType)
                                <!-- Show all body types, but don't exclude the selected one -->
                                <option value="{{ $bodyType }}" {{ $transportCalculator->body_type == $bodyType ? 'selected' : '' }}>
                                    {{ $bodyType }}
                                </option>
                            @endforeach
                            <option value="other" {{ $transportCalculator->body_type == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="mb-3 d-flex">
                        <label for="categories" class="form-label col-sm-3">Categories</label>
                        <input type="number" class="form-control form-control-sm col-sm-3" id="categories" name="categories" value="{{ $transportCalculator->categories }}" required>
                    </div>

                    <div class="mb-3 d-flex">
                        <label for="user_id" class="form-label col-sm-3">User</label>
                        <select class="form-control form-control-sm col-sm-3" id="user_id" name="user_id" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id == $transportCalculator->user_id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <a href="{{ route('calculate.list') }}" class="btn " style="color: #5271FF;">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

@endsection
