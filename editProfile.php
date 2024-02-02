<?php
include_once "DBConfig.php"; // Include your database configuration file
$dbConnection = getDbConnection();

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
    $updateQuery = "UPDATE users SET full_name = :fullName, email = :email WHERE id = :id";
    $updateStmt = $dbConnection->prepare($updateQuery);


    $updateStmt->bindParam(':fullName', $fullName);
    $updateStmt->bindParam(':email', $email);
    $updateStmt->bindParam(':id', $idUser);

    $success = $updateStmt->execute();

    if ($success) {
        // Reload updated user data
        $stmt->execute(['id' => $idUser]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['editInfo_success_message'] = "Profile updated successfully!";
        header('location: admin/list-movies.php');
        exit();
    } else {
        $_SESSION['editInfo_fail_message'] = "Error updating profile. Please try again.";
        header('location: profile.php');
        exit();
    }
}