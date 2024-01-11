<?php
if (isset($_POST['userprofileupdate'])) {
    include_once "DBConfig.php";
    $dbConnection = getDbConnection();
    // receive all input values from the form
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['password2'];
    $firstname = mysqli_real_escape_string($conn, $_POST['name_1']);
    $lastname = mysqli_real_escape_string($conn, $_POST['name_2']);
    $email = mysqli_real_escape_string($conn, $_POST['email_1']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    // Check if Email exists
    $stmt = $pdo->prepare('SELECT * FROM `users` WHERE `email` = :email ');
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();

    $Count = $stmt->rowCount();

    // Check if username exists
    $stmt = $pdo->prepare('SELECT * FROM `users` WHERE `username` = :username ');
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->execute();

    $Count1 = $stmt->rowCount();

    if ($Count < 1) {
        if ($Count1 < 1) {
            $query = "UPDATE users SET username=?, firstname=?, lastname=?, email=? WHERE id=?";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam('ssssi', $username, $firstname, $lastname, $email, $id);
            $stmt->execute();

            unset($_SESSION['username']);
            unset($_SESSION['firstname']);
            unset($_SESSION['lastname']);
            unset($_SESSION['role']);
            unset($_SESSION['email']);
            unset($_SESSION['password']);
            session_destroy();

            header('Location: /panel/login?profile_changed');
        } else {
            header('Location: /panel/profile?username_taken');
        }
    } else {
        header('Location: /panel/profile?email_taken');
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Titre de la page</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="script.js"></script>
</head>
<body>
<div class="container-xl px-4 mt-4">
    <form>
        <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="https://www.bootdey.com/snippets/view/bs5-edit-profile-account-details" target="__blank">Profile</a>
    </nav>
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img class="img-account-profile rounded-circle mb-2" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                    <!-- Profile picture upload button-->
                    <button class="btn btn-primary" type="button">Upload new image</button>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <form>
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Full Name (how your name will appear to other users on the site)</label>
                            <input class="form-control" id="inputFullName" type="text" placeholder="Enter your Full Name" value="<?php echo $_SESSION["user"]["full_name"]?>">
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">Email address</label>
                            <input class="form-control" id="inputEmailAddress" type="email" placeholder="Enter your email address" value="<?php echo $_SESSION["user"]["email"]?>">
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="button">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>


