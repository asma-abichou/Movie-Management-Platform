<?php
// check if form submited the password and confim password
if(isset($_POST['submit']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    include_once "DBConfig.php";
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $idUser = $_SESSION["user_id"];

    // Validation checks for password and confirm_password
    if(empty($password) || empty($confirmPassword)) {
        // Set an error message and redirect back to the reset password form
        $_SESSION['update_password_error_flash_message'] = "Password and confirm password are required.";
        header("Location: reset-password.php");
        exit();
    }
    if($password !== $confirmPassword) {
        // Set an error message and redirect back to the reset password form
        $_SESSION['update_password_error_flash_message'] = "Passwords do not match.";
        header("Location: reset-password.php");
        exit();
    }

    try {
        $dbConnection = getDbConnection();
        // Verify the reset link
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updateStmt = $dbConnection->prepare("UPDATE users SET password = :password, reset_link_token = NULL, expiry_date = NULL WHERE id = :userId");
        $updateStmt->bindParam(':password', $hashedPassword);
        $updateStmt->bindParam(':userId', $idUser);
        $updateStmt->execute();
        $_SESSION['password_reset_success'] = true;
        $_SESSION['id'] = $idUser;
        header("Location: login.php");
        exit();

    } catch (PDOException $e) {
        // Set an error message and redirect back to the reset password form
        $_SESSION['flash_message'] = "Error: " . $e->getMessage();
        header("Location: reset-password.php?id={$idUser}");
        exit();
    }
}