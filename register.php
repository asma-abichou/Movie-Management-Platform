<?php
// Check if user is already logged in, redirect to admin page
if(isset($_SESSION["user"]))
{
    header('location: admin/list-movies.php');
    die();
}
// Check if the registration form is submitted
if (isset($_POST['password'])) {
    include_once "DBConfig.php";
    $dbConnection = getDbConnection();
    // receive all input values from the form
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['password2'];

    $errors = [];

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

    // Check if the user already exists in the database
    $user_check_query = "SELECT * FROM users WHERE email = :userEmail";
    $stmt = $dbConnection->prepare($user_check_query);
    $stmt->execute(['userEmail' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

   // If user already exists, add an error
    if ($user) { // if user exists
        array_push($errors, "Email already exists!");
    }
    $role = 'user';
    // Register the user if there are no errors
    if (count($errors) == 0) {
        // Encrypt the password before saving in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // encrypt the password before saving in the database
        // Insert user data into the database
        $registerUserQuery = "INSERT INTO users (full_name, email, password, role) VALUES (:fullName, :email, :password, :role)";
        $stmt = $dbConnection->prepare($registerUserQuery);
        $stmt->execute(['fullName' => $fullName, 'email' => $email, 'password' => $hashedPassword, 'role' => 'ROLE_USER']);
        $registeredUserId = $dbConnection->lastInsertId();
        $_SESSION["registration_success_message"] = "Registration successful! You can now log in.";
        header('location: login.php');
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        #passwordError {
            color: red;
            margin-top: 5px;
            font-size: 14px;
        }
    </style>

</head>
<body>
<main>
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
            <input type="password" name="password2" id="password2"  onkeypress="validatePassword()">
        </div>

        <p id="passwordError" ></p>
        <button name="form-is-submitted" type="submit">Register</button>
        <footer>Already a member? <a href="login.php">Login here</a></footer>
    </form>

</main>
<script>
    $(document).ready(function() {

        // Function to validate password
        function validatePassword() {
            let password = $("#password").val();
            let confirmPassword = $("#password2").val();
            let passwordError = $("#passwordError");

            // Regular expressions for validation
            let uppercase = /[A-Z]/;
            let lowercase = /[a-z]/;
            let specialChar= /[!@#$%^&*(),.?":{}|<>]/;

            // Check if the password meets the criteria
            let isUppercase = uppercase.test(password);
            let isLowercase = lowercase.test(password);
            let isSpecialChar = specialChar.test(password);
            let isLengthValid = password.length >= 8;

            // Display error message if criteria are not met
            if (!(isUppercase && isLowercase && isSpecialChar && isLengthValid)) {
                passwordError.text("Password must have at least one uppercase letter, one lowercase letter, one special character, and be at least 8 characters long.");
            } else {
                passwordError.text("");
            }
            // Check if passwords match
            if (password !== confirmPassword) {
                passwordError.text("Passwords do not match.");
            }
        }
        // Call the validatePassword function on input change
        /*$("#password, #password2").on("input", validatePassword);*/
        $(document).ready(function() {
            $("#password").on('keyup', validatePassword)
        });
    });
</script>
</body>
</html>