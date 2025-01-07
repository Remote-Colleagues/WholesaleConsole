<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family: 'Josefin Sans', sans-serif !important;
        }
    </style>
</head>
<body>
@if (session('success'))
    <div class="message success">{{ session('success') }}</div>
@elseif (session('error'))
    <div class="message error">{{ session('error') }}</div>
@endif
<div>
<h2 style="pointer-events: none; user-select: none;" >WConsole Login</h2>
<div class="login-container" style="background-color: #5271FF;">
    <form action="{{ route('login') }}" method="POST">
        @csrf

        <label for="email" style="color: white;">Email:</label>
        <input type="email" name="email" id="email"  required><br><br>

        <label for="password"  style="color: white;">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <div class="button-container">
        <button type="submit" style="background-color: #FFDA4B; color:#5271FF">Login</button>
    </div>
    </form>
</div>
<br>
<p style="pointer-events: none; user-select: none;">
    By signing into our portal - You agree to our
    <a href="{{ route('policy.form') }}" style="pointer-events: auto; text-decoration: underline;">privacy policy</a>
</p>
</div>
</body>
</html>
