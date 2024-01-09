
<?php

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( isset($_POST['email'])) {
    include_once "DBConfig.php";
    $dbConnection = getDbConnection();

    if(empty($_POST["username"]) || empty($_POST["password"]))
    {
        $message = '<label>All fields are required</label>';
    }else{
        $query = $dbConnection->prepare('SELECT id, password FROM users WHERE email = :email AND password = :password');
            $statement = $dbConnection->prepare($query);
            $statement->execute(
                array(
                    'email'     =>     $_POST["email"],
                    'password'     =>     $_POST["password"]
                )
            );
            $count = $statement->rowCount();
            if($count > 0)
            {
                $_SESSION["username"] = $_POST["username"];
                header("location:list-movie.php");
            }
            else
            {
                $message = '<label>Wrong Data</label>';
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
    <div class="header">
        <h2>Login</h2>
    </div>
    <form method="post" action="login.php">

        <div class="input-group">
            <label>Email</label>
            <input type="text" name="email" >
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
