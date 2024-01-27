<?php
// Check if the user is already logged in, redirect to the admin page
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
    // Retrieve email and password from the POST data
    $email = $_POST["email"];
    $password = $_POST["password"];
    // Check if email and password are provided
    if (empty($email) || empty($password)) {
        $_SESSION["login_fail_message"] = "Email and password are required!";
        header('location: login.php');
        die();
    } else {
        // Query the database to fetch user data based on the provided email
        $query = $dbConnection->prepare('SELECT id, email, full_name, password FROM users WHERE email = :email');
        $query->execute(['email' => $email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        // Check if the user exists and the provided password is correct
        if ($user && password_verify($password, $user['password'])) {
            // Set user session and redirect to the admin page
            $_SESSION["user"] = $user;
            header("location: admin/list-movies.php");
            die();
        } else {
            // Display an error message for wrong email or password
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
    <style>
        #success-message {
            background-color: #4CAF50; /* Green background */
            color: white; /* White text color */
            padding: 15px; /* Some padding */
            position: fixed; /* Fixed position */
            bottom: 0; /* At the bottom */
            left: 0;
            width: 100%; /* Full width */
            text-align: center; /* Centered text */
            animation: slideIn 0.5s ease-out; /* Animation */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Subtle box shadow */
            opacity: 0.9; /* Slightly transparent */
        }

        #success-message:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        #success-message::before {
            content: "\2713"; /* Unicode checkmark symbol */
            font-size: 20px;
            margin-right: 8px;
        }

        @keyframes slideIn {
            from {
                transform: translateY(100%);
            }
            to {
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<main>
    <?php
    if (isset($_SESSION["registration_fail_message"])) {
        $errorMessage = $_SESSION["registration_fail_message"];
        unset($_SESSION["registration_fail_message"]);
    }

    // Display success message with animation if it exists
    if (isset($_SESSION["registration_success_message"])) {
        $successMessage = $_SESSION["registration_success_message"];
        unset($_SESSION["registration_success_message"]);
        echo "<div id='success-message'>$successMessage</div>";
    }
    ?>
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
        <p>
            <a href="forgetPassword.php">Forgot your password?</a>
        </p>
    </form>
</main>
</body>
</html>
