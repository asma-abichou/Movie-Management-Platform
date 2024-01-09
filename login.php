

<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
</head>
<body>
<main>
    <div class="header">
        <h2>Login</h2>
    </div>

    <form method="post" action="login.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" >
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