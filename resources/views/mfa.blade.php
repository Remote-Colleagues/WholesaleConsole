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
<div>
<h2 style="pointer-events: none; user-select: none;" >WConsole Login</h2>
<div class="login-container">
<h2>Enter MFA Token</h2>
    <form action="{{ route('mfa.verify') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="mfa_token">MFA Token</label>
            <input type="text" name="mfa_token" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Verify</button>
    </form>
</div>
<p style="pointer-events: none; user-select: none;">
    By signing into our portal - You agree to our
    <a href="{{ route('policy.form') }}" style="pointer-events: auto; text-decoration: underline;">privacy policy</a>
</p>
</div>
</body>
</html>
