<?php
include_once "DBConfig.php";
$dbConnection = getDbConnection();
var_dump('hello');

if (!isset($_SESSION["user_is_authorized"]) || $_SESSION["user_is_authorized"] === false) {
    header("Location: reset-password.php");
    exit();
}

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email']; // Change $_POST to $_GET
    $token = $_GET['token']; // Change $_POST to $_GET
    var_dump($token);
} else {
    header("Location: reset-password.php?error=email_or_token_not_set"); // Fix the error message
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
            <input type="hidden" name="email" value="<?php /*echo $email */?>">
            <input type="hidden" name="token" value="<?php /*echo $token */?>">
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

