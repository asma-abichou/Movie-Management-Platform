<?php
if(isset($_SESSION["user"]))
{
    header('location: admin/list-movies.php');
    die();
}
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (isset($_POST['email'])) {
    // Assuming 'login_user' is the name of the submit button
    include_once "DBConfig.php";
    $dbConnection = getDbConnection();

    $email = $_POST["email"]; // Retrieve email from POST data
    $password = $_POST["password"]; // Retrieve password from POST data

    if (empty($email) || empty($password)) {
        $_SESSION["login_fail_message"] = "Email and password are required!";
        header('location: login.php');
        die();
    } else {
        $query = $dbConnection->prepare('SELECT id, email, full_name, password FROM users WHERE email = :email');
        $query->execute(['email' => $email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {

            $_SESSION["user"] = $user;
            header("location: admin/list-movies.php");
            die();
        } else {
            $_SESSION["login_fail_message"] = "Wrong email or password!";
            header('location: login.php');
            die();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
</head>
<body>
<main>
    <?php

    if (isset($_SESSION["login_fail_message"])) {
        $errorMessages = $_SESSION["login_fail_message"];
        unset($_SESSION["login_fail_message"]);
    }
    ?>
    <div class="header">
        <h2>Login</h2>
    </div>
    <form method="post" action="login.php">

        <?php
        if (isset($errorMessages))
        {
            echo "<div style='color: red'>$errorMessages</div>";
        }
        ?>
        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" >
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <button type="submit" class="btn mt-3 mb-3" name="login_user">Login</button>
        </div>

        <p>
            Not yet a member? <a href="register.php">Sign up</a>
        </p>
    </form>
</main>

</body>
</html>
