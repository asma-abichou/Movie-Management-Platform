<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333333;
        }

        p {
            color: #777777;
        }

        a {
            color: #4285f4;
            text-decoration: none;
        }

        .retry-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #4285f4;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .retry-button:hover {
            background-color: #3c77e0;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Password Reset Error</h2>
    <p>The password reset link is invalid or has expired.</p>
    <p>Please make sure you are using the correct link, or you can request a new password reset link.</p>
    <a href="forgot-password.php">Request a New Password Reset Link</a>
    <button class="retry-button" onclick="history.back()">Retry</button>
</div>
</body>
</html>
