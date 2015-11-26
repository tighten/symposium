<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Contact from your public profile page on Symposium</h2>

<div>
    Email: {{ $email }}<br>
    Name: {{ $name }}<br>
    Message: <br>
    <div style="padding: 1em; border: 1px solid #aaa;">
    {{ str_replace("\n", "<br>", htmlentities($userMessage)) }}
    </div>
</div>
</body>
</html>
