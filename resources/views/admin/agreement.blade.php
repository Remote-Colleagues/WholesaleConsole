<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $agreementTitle }} - WConsole</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
        }
        h1, h2 {
            color: #5271FF;
            margin-bottom: 20px;
        }
        .details {
            margin-bottom: 20px;
        }
        .details strong {
            display: inline-block;
            width: 200px;
        }
        .footer {
            margin-top: 40px;
            font-size: 0.9rem;
            color: #555;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>{{ $agreementTitle }}</h1>
    <p>Welcome to <strong>WConsole</strong>. This document serves as your agreement to the {{ $agreementTitle }}.</p>

    <div class="details">
        <h2>Consoler Details</h2>
        <p><strong>Username:</strong> {{ ucwords($user->name) }}</p>
        <p><strong>Email Address:</strong> {{ $user->email }}</p>
        <p><strong>Consoler Name:</strong> {{ ucwords($user->consoler->console_name) }}</p>
        <p><strong>ABN Number:</strong> {{ $user->consoler->abn_number ?? 'N/A' }}</p>
        <p><strong>Address:</strong> {{ $user->consoler->state ?? 'N/A' }}</p>
    </div>

    <div class="details">
        <h2>Billing Information</h2>
        <p><strong>Billing Commencement Period:</strong> {{ $user->consoler->billing_commencement_period ?? 'N/A' }}</p>
        <p><strong>Currency:</strong> {{ $user->consoler->currency ?? 'N/A' }}</p>
        <p><strong>Establishment Fee:</strong> {{ $user->consoler->establishment_fee ?? 'N/A' }}</p>
        <p><strong>Monthly Subscription Fee:</strong> {{ $user->consoler->monthly_subscription_fee ?? 'N/A' }}</p>
        <p><strong>Admin Fee:</strong> {{ $user->consoler->admin_fee ?? 'N/A' }}</p>
        <p><strong>Commission Charge:</strong> {{ $user->consoler->comm_charge ?? 'N/A' }}</p>
    </div>

    <p>By proceeding, you acknowledge and agree to abide by the terms outlined in this document and the associated agreements provided by WConsole.</p>

    <div class="footer">
        <p>Agreed on {{ \Carbon\Carbon::parse($user->email_verified_at)->format('Y-m-d') }} by {{ucwords($user->consoler->console_name)}}</p>
    </div>
</div>

</body>
</html>
