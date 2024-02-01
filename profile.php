<?php
include_once "DBConfig.php"; // Include your database configuration file
$dbConnection = getDbConnection();

// Check if the user is authorized
if (!isset($_SESSION['user'])) {
    header('location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Handle file upload
if (isset($_POST['upload']) && isset($_FILES['uploadFile']) && isset($_POST['update_profile'])) {
    $fileName = $_FILES["uploadFile"]["name"];
    $tempName = $_FILES["uploadFile"]["tmp_name"];
    $folder = "./image/" . $fileName;

    // Validate file type
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($fileType, ['jpg', 'jpeg', 'png'])) {
        echo "<h3> Only JPG, JPEG, and PNG files are allowed!</h3>";
        exit();
    }

    // Move the uploaded image into the folder: image
    if (move_uploaded_file($tempName, $folder)) {
        echo "<h3>  Image uploaded successfully!</h3>";
    } else {
        echo "<h3>  Failed to upload image!</h3>";
    }
}

    $idUser = $_SESSION['user']['id'];

    // Fetch user data from the database
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $dbConnection->prepare($query);
    $stmt->execute(['id' => $idUser]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found!";
        exit();
    }

    $errors = [];
    if (isset($_POST['update_profile'])) {
        // Receive input values from the form
        $fullName = $_POST['fullName'];
        $email = $_POST['email'];

        // Validation
        if (empty($fullName)) {
            $errors[] = "Full name is required!";
        }
        if (empty($email)) {
            $errors[] = "Email is required!";
        }

    if (empty($errors)) {
        // Update user information in the database
        $updateQuery = "UPDATE users SET full_name = :fullName, email = :email,  profile_image = :profileImage WHERE id = :id";
        $updateStmt = $dbConnection->prepare($updateQuery);

        $success = $updateStmt->execute(['fullName' => $fullName, 'email' => $email, 'id' => $idUser]);

        if ($success) {
            // Reload updated user data
            $stmt->execute(['id' => $idUser]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user'] = $user;  // Update the session with fresh user data

            $_SESSION['editInfo_success_message'] = "Profile updated successfully!";
            header('location: admin/list-movies.php');
            exit();
        } else {
            $_SESSION['editInfo_fail_message'] = "Error updating profile. Please try again.";
            header('location: profile.php');
            exit();
        }
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
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->

                    <img src="/images/<?php echo $user['profile_image']; ?>"  class="img-account-profile rounded-circle mb-2">
                    <!--<img class="img-account-profile rounded-circle mb-2" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">-->
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
                            <input type="text" name="idUser" value="<?php echo $_SESSION["user"]["id"]?>" hidden="">
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="submit" name="update_profile">Save changes</button>
                        <a class="btn btn-primary" type="submit" href="admin/list-movies.php">Back</a>
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


