<?php
include_once "DBConfig.php";

// Assuming the stored password is hashed
    $correctCurrentPasswordHash = $_SESSION["user"]["password"];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredPassword = $_POST["currentPassword"];

    // Use password_verify to compare the entered password with the hashed stored password
    if (password_verify($enteredPassword, $correctCurrentPasswordHash)) {
    // Password is correct, redirect to the form to set a new password
    header("Location: changePassword.php");
    exit();
    } else {
    // Incorrect password, show an error message
    $_SESSION["password_verification_fail_message"] = "Incorrect current password!";
    header("Location: currentPassword.php");
    exit();
    }
    } else {
    // Redirect to the current password form if accessed directly without submitting the form
    header("Location: currentPassword.php");
    exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Verify Current Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Verify Current Password</h3>
                </div>
                <div class="card-body">
                    <form action="currentPassword.php" method="post">
                        <!-- Current Password -->
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Verify Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>