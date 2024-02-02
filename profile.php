<?php
include_once "DBConfig.php"; // Include your database configuration file
$dbConnection = getDbConnection();

// Check if the user is authorized
if (!isset($_SESSION['user'])) {
    header('location: login.php'); // Redirect to login page if not logged in
    exit();
}
/*var_dump($_SESSION['user']);
die();*/
$msg = "";

// Fetch user data from the database
$idUser = $_SESSION['user']['id'];
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $dbConnection->prepare($query);
$stmt->execute(['id' => $idUser]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
/*var_dump($user);
die();*/
if (!$user) {
    echo "User not found!";
    exit();
}


// Handle file upload
if (isset($_POST['update_profile'])) {
    /*var_dump($_GET['update_profile']);
    die();*/
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    /*var_dump($fullName);
    die();*/
    // Validation
    if (empty($fullName) || empty($email)) {
        echo "<h3>Full name and email are required!</h3>";
        exit();
    }
    if (!file_exists("profileImage")) {
        mkdir("profileImage");
    }

    // Update user information in the database
    $updateQuery = "UPDATE users SET full_name = :fullName, email = :email, profile_image = :profileImage WHERE id = :id";
    $updateStmt = $dbConnection->prepare($updateQuery);


    $updateStmt->bindParam(':fullName', $fullName);
    $updateStmt->bindParam(':email', $email);
    $updateStmt->bindParam(':profileImage', $fileName);  // Make sure $fileName is set
    $updateStmt->bindParam(':id', $idUser);

    $success = $updateStmt->execute();

    if ($success) {
        // Reload updated user data
        $stmt->execute(['id' => $idUser]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user'] = $user;  // Update the session with fresh user data
        $_SESSION['user']['profile_image'] = $fileName; // Update the session with fresh user data
        $_SESSION['editInfo_success_message'] = "Profile updated successfully!";
        header('location: admin/list-movies.php');
        exit();
    } else {
        $_SESSION['editInfo_fail_message'] = "Error updating profile. Please try again.";
        header('location: profile.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Titre de la page</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="script.js"></script>
</head>
<body>


<main>
    <div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="https://www.bootdey.com/snippets/view/bs5-edit-profile-account-details" target="__blank">Profile</a>
    </nav>
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <form action="uploadImage.php" method="post" enctype="multipart/form-data">
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img src=" profileImage/<?php echo  $_SESSION['user']['profile_image']; ?>" class="img-account-profile rounded-circle mb-2">                    <!--<img class="img-account-profile rounded-circle mb-2" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">-->
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                    <!-- Profile picture upload button-->
                    <input class="form-control" type="file" name="uploadFile" id="profileImg" accept=".jpg, .jpeg, .png">
                  <!--  <button type="file" class="btn btn-primary" >Upload new image</button>-->
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <div>
                        <?php if (!empty($errors)) : ?>
                            <ul style="color: red;">
                                <?php foreach ($errors as $error) : ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <form action="profile.php" method="post" enctype="multipart/form-data">
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Full Name</label>
                            <input class="form-control" id="inputFullName" type="text" name="fullName" placeholder="Enter your Full Name" value="<?php echo $_SESSION["user"]["full_name"]?>">
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">Email address</label>
                            <input class="form-control" id="inputEmailAddress" type="email" name="email" placeholder="Enter your email address" value="<?php echo $_SESSION["user"]["email"]?>">
                        </div>
                        <div>
                            <label class="small mb-1">Gender</label>
                                <div >
                                    <input type="radio" id="male" name="gender" value="Male" <?php if ($_SESSION["user"]["gender"] == "Male") echo "checked"; ?>>
                                    <label for="male">Male</label>

                                    <input type="radio" id="female" name="gender" value="Female" <?php if ($_SESSION["user"]["gender"] == "Female") echo "checked"; ?>>
                                    <label for="female">Female</label>
                                </div>

                            <input type="text" name="idUser" value="<?php echo $_SESSION["user"]["id"]?>" hidden="">
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary mt-4" type="submit" name="update_profile">Save changes</button>
                        <a class="btn btn-primary mt-4" type="submit" href="admin/list-movies.php">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</main>

</body>
</html>


