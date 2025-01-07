<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
</head>
<body>
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('admin.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>

        <label for="contact_person">Contact Person:</label>
        <input type="text" name="contact_person" id="contact_person"><br><br>

        <label for="contact_phone_number">Contact Phone Number:</label>
        <input type="text" name="contact_phone_number" id="contact_phone_number" required><br><br>

        <label for="contact_email">Contact Email:</label>
        <input type="email" name="contact_email" id="contact_email" required><br><br>

        <label for="change_password">Change Password:</label>
        <input type="password" name="change_password" id="change_password" required><br><br>

        <label for="terms_conditions_wc_partners">Terms and Conditions for WC Partners:</label>
        <textarea name="terms_conditions_wc_partners" id="terms_conditions_wc_partners" ></textarea><br><br>

        <label for="terms_conditions_wc_consolers">Terms and Conditions for WC Consolers:</label>
        <textarea name="terms_conditions_wc_consolers" id="terms_conditions_wc_consolers"></textarea><br><br>

        <label for="privacy_policy_for_all">Privacy Policy for All:</label>
        <textarea name="privacy_policy_for_all" id="privacy_policy_for_all" required></textarea><br><br>

        <label for="abn_number">ABN Number:</label>
        <input type="text" name="abn_number" id="abn_number" required><br><br>

        <label for="banking_detail">Banking Detail:</label>
        <input type="text" name="banking_detail" id="banking_detail" required><br><br>

        <button type="submit">Register</button>
    </form>

     <!-- Login button -->
     <br><br>
     <p> I have an account
    <a href="{{ route('admin.login') }}">
       <button>Login</button>
    </a></p>
</body>
</html>
