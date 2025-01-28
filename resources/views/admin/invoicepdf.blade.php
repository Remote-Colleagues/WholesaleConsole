<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col">
            <h6 class="fw-bold">Invoice Number: {{ $invoice->invoice_number }}</h6>
        </div>
    </div>

    <!-- Invoice Issued By -->
    <div class="row mb-4">
        <div class="col">
            <h6 class="fw-bold">Invoice Issued by:</h6>
            <p class="mb-0"> {{ $accountHolder }}:{{$abn_number}}</p>
            <p>Issued on: {{ \Carbon\Carbon::parse($invoice->date_created)->format('d M, Y') }}</p>
        </div>
    </div>

    <!-- Invoice Issued To -->
    <div class="row mb-4">
        <div class="col">
            <h6 class="fw-bold">Invoice Issued to:</h6>
            <p class="mb-0">{{ $invoice->consoler_name }}</p>
            <p class="mb-0">{{ $contactEmail }}</p>
            <p>{{ $address ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Charges Section -->
    <div class="row mb-4">
        <div class="col">
            <h6 class="fw-bold">Charges</h6>
            @if ($totalAmount > $subscriptionFee)
                <div class="d-flex justify-content-between">
                    <span>Charge 1: Monthly Subscription Fee</span>
                    <span>${{ number_format($subscriptionFee, 2) }}</span>
                </div>
            <div class="d-flex justify-content-between">
                <span>Charge 2: Establishment Fee</span>
                <span>${{ number_format($establishmentFee, 2) }}</span>
            </div>

            @else
                <div class="d-flex justify-content-between">
                    <span>Charge: Monthly Subscription Fee</span>
                    <span>${{ number_format($subscriptionFee, 2) }}</span>
                </div>
            @endif
            <div class="d-flex justify-content-between border-top pt-2 mt-2">
                <span class="fw-bold">Total</span>
                <span class="fw-bold">${{ number_format($totalAmount, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="row mt-5">
        <div class="col">
            <h6 class="fw-bold">Contact & Payment Details</h6>
            <p class="mb-0">Email: {{ $email }}</p>
            <p class="mb-0">Phone: {{ $Phone }}</p>
            <p class="mb-0">BSB: {{ $bsb }}</p>
            <p class="mb-0">Account Number: {{ $accountNumber }}</p>
            <p>Account Holder: {{ $accountHolder }}</p>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
