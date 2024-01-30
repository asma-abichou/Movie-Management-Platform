<?php

if(isset($_GET['email']) && isset($_GET['token'])) {
    //check if user authorized
    function checkIfUserIsAuthorized($user, $token)
    {
        //if not redirect to forget password page
        if(!$user) {
            header("Location: forgetPassword.php");
            die();
        }
        //if also user token not equal to the valid token redirect to the page forget password page
        if($user["reset_link_token"] !== $token) {
            header("Location: forgetPassword.php");
            die();
        }
       // save the expiry date of the token
        $tokenExpiryDateTimeObject = new DateTime($user["expiry_date"]);
        // get the actual date
        $actualDateTimeObject = new DateTime();
        //verify the date time token if expired redirect to forget password page
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
        //check if the user is authorized
        checkIfUserIsAuthorized($user, $token);
        // if the user is authorized
        $_SESSION["user_is_authorized"] = true;
        //save the id user in the session
        $_SESSION["user_id"] = $user["id"];

        header("Location: reset-password.php");
        die();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
