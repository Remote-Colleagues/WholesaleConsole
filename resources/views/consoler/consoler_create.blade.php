<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Consoler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Create Consoler</h1>

        <form method="POST" action="{{ url('/consolers') }}">
            @csrf
            <div class="mb-3">
                <label for="wc_consolers_name" class="form-label">WC Consolers Name</label>
                <input type="text" class="form-control" id="wc_consolers_name" name="wc_consolers_name" required>
            </div>
            <div class="mb-3">
                <label for="contact_person" class="form-label">Contact Person</label>
                <input type="text" class="form-control" id="contact_person" name="contact_person" required>
            </div>
            <div class="mb-3">
                <label for="contact_phone_number" class="form-label">Contact Phone Number</label>
                <input type="text" class="form-control" id="contact_phone_number" name="contact_phone_number" required>
            </div>
            <div class="mb-3">
                <label for="contact_email" class="form-label">Contact Email</label>
                <input type="email" class="form-control" id="contact_email" name="contact_email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="your_agreement" class="form-label">Your Agreement</label>
                <select class="form-control" id="your_agreement" name="your_agreement" required>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="abn_number" class="form-label">ABN Number</label>
                <input type="text" class="form-control" id="abn_number" name="abn_number" required>
            </div>
            <div class="mb-3">
                <label for="operational_location" class="form-label">Operational Location</label>
                <input type="text" class="form-control" id="operational_location" name="operational_location">
            </div>
            <div class="mb-3">
                <label for="comm_charge_for_buyers_connect" class="form-label">Comm Charge for Buyers Connect</label>
                <input type="number" class="form-control" id="comm_charge_for_buyers_connect" name="comm_charge_for_buyers_connect" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="billing_commencement_period" class="form-label">Billing Commencement Period</label>
                <input type="number" class="form-control" id="billing_commencement_period" name="billing_commencement_period" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="admin_fee_for_buyers_connect" class="form-label">Admin Fee for Buyers Connect</label>
                <input type="number" class="form-control" id="admin_fee_for_buyers_connect" name="admin_fee_for_buyers_connect" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="establishment_fee" class="form-label">Establishment Fee</label>
                <input type="number" class="form-control" id="establishment_fee" name="establishment_fee" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="ongoing_monthly_subs_fee" class="form-label">Ongoing Monthly Subs Fee</label>
                <input type="number" class="form-control" id="ongoing_monthly_subs_fee" name="ongoing_monthly_subs_fee" step="0.01" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
