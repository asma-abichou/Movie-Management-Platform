<!doctype html>
<html lang="en">
<head>
    <title>Reset Password Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <h2>Reset New Password Here</h2>
    <form>

    <?php
    if(isset($_GET['email']) && isset($_GET['token'])) {
        include_once "DBConfig.php";
        $dbConnection = getDbConnection();
        $email = $_GET['email'];
        $token = $_GET['token'];



        try {
            $stmt = $dbConnection->prepare("SELECT * FROM users WHERE reset_link_token = :token AND email = :email");

            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);


            if($row['expiry_date'] >= date("Y-m-d H:i:s") && $row['reset_link_token'] === $token)  {; ?>

                <form action="update-password.php" method="post">
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    <input type="hidden" name="reset_link_token" value="<?php echo $token; ?>">
                    <div class="form-group">
                        <label for="new-password">Password</label>
                        <input type="password" name="password" id="new-password">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm-password">
                    </div>
                    <input type="submit" name="submit" class="submit-btn">
                </form>
            <?php } else {
                echo "<p>This forget password link has been expired</p>";
                header("Location: invalid_link_password.php");
                exit();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    ?>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</body>
</html>