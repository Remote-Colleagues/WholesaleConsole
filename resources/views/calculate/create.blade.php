@extends('admin.layouts.app')
@section('headerTitle', 'Add Transport Calculator')

@section('content')

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3  d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold" style="pointer-events: none; user-select: none; color: #5271FF;">Add New Transport Calculator</h6>
                <a href="{{ route('calculate.list') }}" class="btn " style="color: #5271FF;">Back to List</a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('calculate.store') }}">
                    @csrf
                    <div class="mb-3 d-flex">
                        <label for="per_km_charge" class="form-label col-sm-3">Per KM Charge</label>
                        <input type="number" class="form-control form-control-sm col-sm-3" id="per_km_charge" name="per_km_charge" required>
                    </div>

                    <div class="mb-3 d-flex">
                        <label for="same_state_charge" class="form-label col-sm-3">Same State Charge</label>
                        <input type="number" class="form-control form-control-sm col-sm-3" id="same_state_charge" name="same_state_charge" required>
                    </div>

                    <div class="mb-3 d-flex">
                        <label for="cross_state_charge" class="form-label col-sm-3">Cross State Charge</label>
                        <input type="number" class="form-control form-control-sm col-sm-3" id="cross_state_charge" name="cross_state_charge" required>
                    </div>

                    <div class="mb-3 d-flex">
                        <label for="additional_charges" class="form-label col-sm-3">Additional Charges</label>
                        <input type="number" class="form-control form-control-sm col-sm-3" id="additional_charges" name="additional_charges" required>
                    </div>

                    <div class="mb-3 d-flex">
                        <label for="additional_charge_for_size" class="form-label col-sm-3">Additional Charge for Size</label>
                        <input type="number" class="form-control form-control-sm col-sm-3" id="additional_charge_for_size" name="additional_charge_for_size" required>
                    </div>

                    <div class="mb-3 d-flex">
                        <label for="body_type" class="form-label col-sm-3">Body Type</label>
                        <select class="form-control form-control-sm col-sm-3" id="body_type" name="body_type" required>
                            @foreach($bodyTypes as $bodyType)
                                @if($bodyType != $currentBodyType)
                                <option value="{{ $bodyType }}" {{ old('body_type', $currentBodyType) == $bodyType ? 'selected' : '' }}>{{ $bodyType }}</option>
                                @endif
                            @endforeach
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="mb-3 d-flex">
                        <label for="categories" class="form-label col-sm-3">Categories</label>
                        <input type="number" class="form-control form-control-sm col-sm-3" id="categories" name="categories" placeholder="Input number" required>
                    </div>

                    <div class="mb-3 d-flex d-none" >
                        <label for="user_id" class="form-label col-sm-3">User</label>
                        <select class="form-control form-control-sm col-sm-3" id="user_id" name="user_id"  required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <a href="{{ route('calculate.list') }}" class="btn " style="color: #5271FF;">Cancel</a>
                    <button type="submit" class="btn border-2" style="color: #5271FF; border-color: #5271FF;">Save </button>
                </form>
            </div>
        </div>
    </div>

@endsection
