<?php

if(isset($_GET['email']) && isset($_GET['token'])) {
    function checkIfUserIsAuthorized($user, $token)
    {
        if(!$user) {
            header("Location: forgetPassword.php");
            die();
        }
        if($user["reset_link_token"] !== $token) {
            header("Location: forgetPassword.php");
            die();
        }
        $tokenExpiryDateTimeObject = new DateTime($user["expiry_date"]);
        $actualDateTimeObject = new DateTime();
        if($tokenExpiryDateTimeObject < $actualDateTimeObject) {
            header("Location: forgetPassword.php");
            die();
        }
    }
    include_once "DBConfig.php";
    $dbConnection = getDbConnection();
    $email = $_GET['email'];
    $token = $_GET['token'];

    try {
        $stmt = $dbConnection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        checkIfUserIsAuthorized($user, $token);
        //
        $_SESSION["user_is_authorized"] = true;
        header("Location: reset-password.php");
        die();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
