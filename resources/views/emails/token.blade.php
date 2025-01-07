<!-- resources/views/emails/mfa/token.blade.php -->

<h3>Your MFA Code</h3>
<p>Hello,</p>
<p>Your Multi-Factor Authentication (MFA) code is: <strong>{{ $mfaToken }}</strong></p>
<p>This code is valid for 10 minutes.</p>
<p>If you did not request this code, please ignore this email.</p>
<p>Thank you!</p>
