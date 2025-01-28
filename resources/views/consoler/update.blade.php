@extends('admin.layouts.app')
@section('headerTitle', 'Update Consoler')
@section('title','Update Consoler')
@section('content')
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Consoler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-message {
            color: red;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
<div class="middle-section">
    <div class="container mt-1">
        <h2 style="pointer-events: none; user-select: none;">Update Consoler</h2>
        <form method="POST" action="{{ route('consoler.update', $consoler->id) }}" enctype="multipart/form-data" id="consolerForm">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-3 d-flex">
                <label for="name" class="form-label col-sm-3">UserName <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <!-- Email -->
            <div class="mb-3 d-flex">
                <label for="email" class="form-label col-sm-3">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-sm col-sm-3" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

{{--            <!-- Password -->--}}
            <div class="mb-3 d-flex">
                <label for="password" class="form-label col-sm-3">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control form-control-sm col-sm-3" id="password" name="password"  oninput="validatePassword()">
            </div>

            <!-- Confirm Password -->
            <div class="mb-3 d-flex">
                <label for="password_confirmation" class="form-label col-sm-3">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control form-control-sm col-sm-3" id="password_confirmation" name="password_confirmation" oninput="validatePassword()">
            </div>
            <div id="passwordError" class="error-message"></div>

            <!-- User Type -->
            <input type="hidden" name="user_type" value="consoler">
            <!-- Status -->
            <div class="mb-3 d-flex">
                <label for="status" class="form-label col-sm-3">Status <span class="text-danger">*</span></label>
                <select class="form-select form-select-sm col-sm-3" name="status" id="status" required>
                    <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Console Name -->
            <div class="mb-3 d-flex">
                <label for="console_name" class="form-label col-sm-3">Consoler Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="console_name" name="console_name" value="{{ old('console_name', $consoler->console_name) }}" required>
            </div>

            <!-- Contact Person -->
            <div class="mb-3 d-flex">
                <label for="contact_person" class="form-label col-sm-3">Contact Person <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="contact_person" name="contact_person" value="{{ old('contact_person', $consoler->contact_person) }}" required>
            </div>

            <!-- Contact Phone Number -->
            <div class="mb-3 d-flex">
                <label for="contact_phone_number" class="form-label col-sm-3">Contact Phone Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="contact_phone_number" name="contact_phone_number" value="{{ old('contact_phone_number', $consoler->contact_phone_number) }}" required>
            </div>

            <!-- ABN Number -->
            <div class="mb-3 d-flex">
                <label for="abn_number" class="form-label col-sm-3">ABN <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="abn_number" name="abn_number" value="{{ old('abn_number', $consoler->abn_number) }}" maxlength="11" required>
            </div>

            <!-- Operation Location -->
            <div class="mb-3 d-flex row">
                <label for="operation_location" class="form-label col-sm-3 ">Operation Location <span class="text-danger">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control form-control-sm mb-2" id="building" name="building" value="{{ old('building', $consoler->building) }}" placeholder="Building, Apt, Unit" required>
                    <input type="text" class="form-control form-control-sm mb-2" id="city" name="city" value="{{ old('city', $consoler->city) }}" placeholder="City" required>
                    <input type="text" class="form-control form-control-sm mb-2" id="state" name="state" value="{{ old('state', $consoler->state) }}" placeholder="State" required>
                    <input type="text" class="form-control form-control-sm mb-2" id="country" name="country" value="{{ old('country', $consoler->country) }}" placeholder="Country" required>
                    <input type="text" class="form-control form-control-sm" id="post_code" name="post_code" value="{{ old('post_code', $consoler->post_code) }}" placeholder="Post Code" required>
                </div>
            </div>

            <!-- Your Agreement (display old file) -->
            <div class="mb-3 d-flex">
                <label for="your_agreement" class="form-label col-sm-3">Your Agreement <span class="text-danger">*</span></label>
                <input type="file" class="form-control form-control-sm col-sm-3" id="your_agreement" name="your_agreement" accept="application/pdf">
                @if($consoler->your_agreement)
                    <a href="{{ asset('storage/' . $consoler->your_agreement) }}" class="btn  btn-sm border-2" style="color: #5271FF; border-color: #5271FF " target="_blank">View Old Agreement</a>
                @endif
            </div>

            <!-- Billing Commencement Period -->
            <div class="mb-3 d-flex">
                <label for="billing_commencement_period" class="form-label col-sm-3">Billing Commencement Period </label>
                <input type="date" class="form-control form-control-sm col-sm-3" id="billing_commencement_period" name="billing_commencement_period" value="{{ old('billing_commencement_period', $consoler->billing_commencement_period) }}">
            </div>

            <!-- Currency -->
            <div class="mb-3 d-flex">
                <label for="currency" class="form-label col-sm-3">Currency </label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="currency" name="currency" value="AUD" readonly required>
            </div>

            <!-- Fees and Charges -->
            <div class="mb-3 d-flex">
                <label for="establishment_fee" class="form-label col-sm-3">Establishment Fee </label>
                <input type="number" class="form-control form-control-sm col-sm-3" id="establishment_fee" name="establishment_fee" value="{{ old('establishment_fee', $consoler->establishment_fee) }}" step="0.01">
                <input type="date" class="form-control form-control-sm col-sm-3" id="establishment_fee_date" name="establishment_fee_date" value="{{ old('establishment_fee_date', $consoler->establishment_fee_date) }}">
            </div>

            <div class="mb-3 d-flex">
                <label for="monthly_subscription_fee" class="form-label col-sm-3">Monthly Subscription Fee </label>
                <input type="number" class="form-control form-control-sm col-sm-3" id="monthly_subscription_fee" name="monthly_subscription_fee" value="{{ old('monthly_subscription_fee', $consoler->monthly_subscription_fee) }}" step="0.01">
                <input type="date" class="form-control form-control-sm col-sm-3" id="monthly_subscription_fee_date" name="monthly_subscription_fee_date" value="{{ old('monthly_subscription_fee_date', $consoler->monthly_subscription_fee_date) }}">
            </div>

            <div class="mb-3 d-flex">
                <label for="admin_fee" class="form-label col-sm-3">Admin Fee for BC </label>
                <input type="number" class="form-control form-control-sm col-sm-3" id="admin_fee" name="admin_fee" value="{{ old('admin_fee', $consoler->admin_fee) }}" step="0.01">
                <input type="date" class="form-control form-control-sm col-sm-3" id="admin_fee_date" name="admin_fee_date" value="{{ old('admin_fee_date', $consoler->admin_fee_date) }}">
            </div>

            <div class="mb-3 d-flex">
                <label for="comm_charge" class="form-label col-sm-3">Comm Charge for BC </label>
                <input type="number" class="form-control form-control-sm col-sm-3" id="comm_charge" name="comm_charge" value="{{ old('comm_charge', $consoler->comm_charge) }}" step="0.01">
                <input type="date" class="form-control form-control-sm col-sm-3" id="comm_charge_date" name="comm_charge_date" value="{{ old('comm_charge_date', $consoler->comm_charge_date) }}">
            </div>

            <!-- Buttons -->
            <button type="submit" class="btn btn-success" id="submitBtn" disabled>Update</button>
            <a href="{{ route('consoler.list') }}" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function validatePassword() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        const errorMessage = document.getElementById('passwordError');
        const submitButton = document.getElementById('submitBtn');

        if (password !== confirmPassword) {
            errorMessage.textContent = "Passwords do not match!";
            submitButton.disabled = true;
        } else {
            errorMessage.textContent = "";
            submitButton.disabled = false;
        }
    }

    document.getElementById('password').addEventListener('input', validatePassword);
    document.getElementById('password_confirmation').addEventListener('input', validatePassword);
</script>

<script>
    window.onload = () => {
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0]; // Format as YYYY-MM-DD
        document.querySelectorAll('input[type="date"]').forEach(input => {
            if (input.id !== 'billing_commencement_period') {
                input.value = formattedDate;
            }
        });
    };
</script>
</body>
@endsection
</html>
