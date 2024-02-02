<?php
include_once "DBConfig.php"; // Include your database configuration file
$dbConnection = getDbConnection();

$msg = ""; // Initialize a variable to store messages

try {
    if (!empty($_FILES['uploadFile']['name']) && isset($_POST['update_profile'])) {
        $fileName = $_FILES["uploadFile"]["name"];
        $tempName = $_FILES["uploadFile"]["tmp_name"];
        $folder = "profileImage/" . $fileName;

        // Validate file type
        $allowedFileTypes = ['jpg', 'jpeg', 'png'];
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileType, $allowedFileTypes)) {
            $msg = "Only JPG, JPEG, and PNG files are allowed!";
        } else {
            // Move the uploaded image to the folder
            if (move_uploaded_file($tempName, $folder)) {
                $msg = "Image uploaded successfully";

                // Database update request for profile picture only
                $idUser = $_SESSION['user']['id'];

                // Update user profile image in the database
                $updateQuery = "UPDATE users SET profile_image = :profileImage WHERE id = :id";
                $updateStmt = $dbConnection->prepare($updateQuery);

                $updateStmt->bindParam(':profileImage', $fileName);
                $updateStmt->bindParam(':id', $idUser);

                $success = $updateStmt->execute();

                if ($success) {
                    // Reload updated user data
                    $query = "SELECT * FROM users WHERE id = :id";
                    $stmt = $dbConnection->prepare($query);
                    $stmt->execute(['id' => $idUser]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$user) {
                        throw new Exception("User not found!");
                    }

                    $_SESSION['user']['profile_image'] = $fileName; // Update the session with fresh user data
                    $_SESSION['editInfo_success_message'] = "Profile picture updated successfully!";
                    header('location: admin/list-movies.php');
                    exit();
                } else {
                    throw new Exception("Error updating profile picture. Please try again.");
                }
            } else {
                $msg = "Failed to upload image";
            }
        }
    } else {
        $msg = "No file uploaded or invalid file name.";
    }

    // Output the message to the user (you can use this message in your HTML)
    echo "<h3>$msg</h3>";

} catch (Exception $e) {
    // Handle any exceptions thrown during file upload or database operations
    echo "<h3>Error: " . $e->getMessage() . "</h3>";
}
?>