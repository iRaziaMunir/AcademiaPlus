<!DOCTYPE html>
<html>
<head>
    <title>Set Your Password</title>
</head>
<body>
    <h1>Hello, {{ $name }}</h1>
    <p>You have been invited to set up your password. Please click the link below:</p>
    <p>
        <a href="{{ $url }}">Set Your Password</a>
    </p>
    <p>This link will expire in 24 hours.</p>
    <p>Thank you!</p>
</body>
</html>
