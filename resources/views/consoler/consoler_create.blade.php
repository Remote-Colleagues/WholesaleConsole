@extends('admin.layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="middle-section">
    <div class="container mt-5">
        <h1>Add Consoler</h1>

        <form method="POST" action="{{ route('consolers.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div class="mb-3 d-flex">
                <label for="name" class="form-label col-sm-3">UserName <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="name" name="name" required>
            </div>

            <!-- Email -->
            <div class="mb-3 d-flex">
                <label for="email" class="form-label col-sm-3">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-sm col-sm-3" id="email" name="email" required>
            </div>

            <!-- Password -->
            <div class="mb-3 d-flex">
                <label for="password" class="form-label col-sm-3">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control form-control-sm col-sm-3" id="password" name="password" required>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3 d-flex">
                <label for="password_confirmation" class="form-label col-sm-3">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control form-control-sm col-sm-3" id="password_confirmation" name="password_confirmation" required>
            </div>

            <!-- User Type -->
            <input type="hidden" name="user_type" value="consoler">

             <!-- Status -->
            <input type="hidden" name="status" value="active">

            <!-- Consoler Fields -->
            <h3>Consoler Details</h3>

            <!-- Console Name -->
            <div class="mb-3 d-flex">
                <label for="console_name" class="form-label col-sm-3">Console Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="console_name" name="console_name" required>
            </div>

            <!-- Contact Person -->
            <div class="mb-3 d-flex">
                <label for="contact_person" class="form-label col-sm-3">Contact Person <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="contact_person" name="contact_person" required>
            </div>

            <!-- Contact Phone Number -->
            <div class="mb-3 d-flex">
                <label for="contact_phone_number" class="form-label col-sm-3">Contact Phone Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="contact_phone_number" name="contact_phone_number" required>
            </div>

            <!-- ABN Number -->
            <div class="mb-3 d-flex">
                <label for="abn_number" class="form-label col-sm-3">ABN Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="abn_number" name="abn_number" required>
            </div>

            <!-- Operation Location -->
            <div class="mb-3 row">
                <label for="operation_location" class="col-sm-2 col-form-label">Operation Location <span class="text-danger">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control form-control-sm mb-2" id="building" name="building" placeholder="Building, Apt, Unit" required>
                    <input type="text" class="form-control form-control-sm mb-2" id="city" name="city" placeholder="City" required>
                    <input type="text" class="form-control form-control-sm mb-2" id="state" name="state" placeholder="State" required>
                    <input type="text" class="form-control form-control-sm mb-2" id="country" name="country" placeholder="Country" required>
                    <input type="text" class="form-control form-control-sm" id="post_code" name="post_code" placeholder="Post Code" required>
                </div>
            </div>

            <!-- Your Agreement -->
            <div class="mb-3">
                <label for="your_agreement" class="form-label">Your Agreement <span class="text-danger">*</span></label>
                <input type="file" class="form-control form-control-sm col-sm-3" id="your_agreement" name="your_agreement" accept="application/pdf" required>
            </div>

            <!-- Billing Commencement Period -->
            <div class="mb-3 d-flex">
                <label for="billing_commencement_period" class="form-label col-sm-3">Billing Commencement Period <span class="text-danger">*</span></label>
                <input type="date" class="form-control form-control-sm col-sm-3" id="billing_commencement_period" name="billing_commencement_period" required>
            </div>

            <!-- Currency -->
            <div class="mb-3 d-flex">
                <label for="currency" class="form-label col-sm-3">Currency <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="currency" name="currency" value="AUD" readonly required>
            </div>

            <!-- Fees and Charges -->
            <div class="mb-3 d-flex">
                <label for="establishment_fee" class="form-label col-sm-3">Establishment Fee <span class="text-danger">*</span></label>
                <input type="number" class="form-control form-control-sm col-sm-3" id="establishment_fee" name="establishment_fee" step="0.01" required>
                <input type="date" class="form-control form-control-sm col-sm-3" id="establishment_fee_date" name="establishment_fee_date" required>
            </div>

            <div class="mb-3 d-flex">
                <label for="monthly_subscription_fee" class="form-label col-sm-3">Monthly Subscription Fee <span class="text-danger">*</span></label>
                <input type="number" class="form-control form-control-sm col-sm-3" id="monthly_subscription_fee" name="monthly_subscription_fee" step="0.01" required>
                <input type="date" class="form-control form-control-sm col-sm-3" id="monthly_subscription_fee_date" name="monthly_subscription_fee_date" required>
            </div>
            <div class="mb-3 d-flex">
                <label for="admin_fee" class="form-label col-sm-3">Admin Fee for BC <span class="text-danger">*</span></label>
                <input type="number" class="form-control form-control-sm col-sm-3" id="admin_fee" name="admin_fee" step="0.01" required>
                <input type="date" class="form-control form-control-sm col-sm-3" id="admin_fee_date" name="admin_fee_date" required>
            </div>

            <div class="mb-3 d-flex">
                <label for="comm_charge" class="form-label col-sm-3">Comm Charge for BC <span class="text-danger">*</span></label>
                <input type="number" class="form-control form-control-sm col-sm-3" id="comm_charge" name="comm_charge" step="0.01" required>
                <input type="date" class="form-control form-control-sm col-sm-3" id="comm_charge_date" name="comm_charge_date" required>
            </div>

            <!-- Buttons -->
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('consoler.list') }}" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
@endsection
</html>
