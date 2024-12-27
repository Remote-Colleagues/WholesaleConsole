<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@if (session('success'))
    <div class="message success">{{ session('success') }}</div>
@elseif (session('error'))
    <div class="message error">{{ session('error') }}</div>
@endif

<div class="login-container">
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <h2>Login</h2>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit">Login</button>
    </form>

    <!-- <p>Don't have an account? <a href="{{ route('register.form') }}">Register here</a></p> -->

</div>

</body>
</html>
