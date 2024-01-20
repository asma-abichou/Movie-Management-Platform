<?php
    include_once "DBConfig.php";
    $dbConnection = getDbConnection();

    if (isset($_SESSION['user']) || $_SESSION['current_password_verified'] !== true) {
        header('location: currentPassword.php');
        die();
    }

// Assuming the stored password is hashed
    $correctCurrentPasswordHash = $_SESSION["user"]["password"];

    if (isset($_POST['confirm_change_password']))  {
        $newPassword = $_POST["newPassword"];
        $confirmPassword = $_POST["confirmPassword"];

        // Validate the form data
        $errors = [];

        if (empty($newPassword)) {
            $errors[] = "New Password is required!";
        }

        if (empty($confirmPassword)) {
            $errors[] = "Confirm Password is required!";
        }

        if ($newPassword !== $confirmPassword) {
            $errors[] = "New Password and Confirm Password do not match!";
        }

            if (empty($errors)) {
                // All validations passed, update the password in the database
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                // Sample code (replace it with your database update logic)
                $userId = $_SESSION["user"]["id"];
                $updateQuery = "UPDATE users SET password = ? WHERE id = ?";
                $stmt = $dbConnection->prepare($updateQuery);
                $stmt->execute([$newPasswordHash, $userId]);

                // Display a success message
                $_SESSION["change_password_success_message"] = "Password changed successfully!";
                header("Location: admin/list-movies.php");
                exit();
            } else {
                // Display validation errors
                $_SESSION["change_password_error_messages"] = $errors;
                header("Location: changePassword.php");
                exit();
            }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Change Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<main>
    <?php
    if (isset($_SESSION["change_password_error_messages"])) {
        $errorConfirmPassword = $_SESSION["change_password_error_messages"];
        unset($_SESSION["change_password_error_messages"]);
    }
    ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Change Password</h3>
                </div>
                <div class="card-body">
                    <?php
                    // Display validation errors, if any
                    if (!empty($errorConfirmPassword)) {
                        echo "<div class='alert alert-danger'>";
                        echo "<ul>";
                        foreach ($errorConfirmPassword as $error) {
                            echo "<li>$error</li>";
                        }
                        echo "</ul>";
                        echo "</div>";
                    }

                    // Display flash message for success, if any
                    if (isset($_SESSION["change_password_success_message"])) {
                        echo "<div class='alert alert-success'>{$_SESSION['change_password_success_message']}</div>";
                        unset($_SESSION["change_password_success_message"]);
                    }
                    ?>
                    <form action="changePassword.php" method="post">
                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" name="confirm_change_password">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</main>
</body>
</html>