<?php


// Check if the user is authorized
if (!isset($_SESSION["user_is_authorized"]) || $_SESSION["user_is_authorized"] === false) {
    header("Location: forgetPassword.php");
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
    <title>Reset Password Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <h2>Reset New Password Here</h2>
    <form action="update-password.php" method="post">
        <div class="form-group">

            <label for="new-password">New Password</label>
            <input type="password" name="password" id="new-password">
        </div>
        <div class="form-group">
            <label for="confirm-password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm-password">
        </div>
        <input type="submit" name="submit" class="submit-btn">
    </form>
</div>
</body>
</html>

