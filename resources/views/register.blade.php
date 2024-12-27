<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
@if (session('success'))
    <div class="message success">{{ session('success') }}</div>
@elseif (session('error'))
    <div class="message error">{{ session('error') }}</div>
@endif
<body>
    <div class="login-container">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <h2>Register</h2>

            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required><br><br>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required><br><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>

            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required><br><br>

            <label for="user_type">User Type:</label>
            <select name="user_type" id="user_type" required>
                <option value="partner">Partner</option>
                <option value="consoler">Consoler</option>
            </select><br><br>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
