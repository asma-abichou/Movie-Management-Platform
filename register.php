<?php
if(isset($_SESSION["user"]))
{
    header('location: admin/list-movies.php');
    die();
}
// REGISTER USER
if (isset($_POST['password'])) {
    include_once "DBConfig.php";
    $dbConnection = getDbConnection();
    // receive all input values from the form
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['password2'];


    $errors = [];
    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($fullName)) {
        $_SESSION["registration_fail_message"] = "Full name is required!";
        header('location: register.php');
        die();
    }
    if (empty($email)) {
        $_SESSION["registration_fail_message"] = "Email is required!";
        header('location: register.php');
        die();
    }
    if (empty($password)) {
        $_SESSION["registration_fail_message"] = "Password is required!";
        header('location: register.php');
    }
    if ($password != $confirmPassword) {
        $_SESSION["registration_fail_message"] = "The two passwords do not match";
        header('location: register.php');
        die();
    }

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE email = :userEmail";
    $stmt = $dbConnection->prepare($user_check_query);
    $stmt->execute(['userEmail' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
   /* var_dump($user);
    die();*/

    if ($user) { // if user exists
        array_push($errors, "Email already exists!");
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // encrypt the password before saving in the database
        $registerUserQuery = "INSERT INTO users (full_name, email, password) VALUES (:fullName, :email, :password)";
        $stmt = $dbConnection->prepare($registerUserQuery);
        $stmt->execute(['fullName' => $fullName, 'email' => $email, 'password' => $hashedPassword]);
        $registeredUserId = $dbConnection->lastInsertId();
        header('location: login.php'); // Change this to the appropriate redirect page
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
    <title>Register</title>
</head>
<body>
<main>
    <?php
    if(isset($_SESSION["registration_fail_message"]))
    {
        $errorMessage = $_SESSION["registration_fail_message"]; // msg: full name is required!
        unset($_SESSION["registration_fail_message"]);
    }
    ?>
    <form action="register.php" method="post">
        <h1>Sign Up</h1>
        <?php
        if(isset($errorMessage))
        {
            echo "<div style='color: red'>$errorMessage</div>";

        }
        ?>
        <div>
            <label for="username">Full Name:</label>
            <input type="text" name="fullName" id="fullName">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <label for="password2">Confirm Password:</label>
            <input type="password" name="password2" id="password2">
        </div>
        <button name="form-is-submitted" type="submit">Register</button>
        <footer>Already a member? <a href="login.php">Login here</a></footer>
    </form>
</main>
</body>
</html>