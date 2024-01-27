<?php
include_once "DBConfig.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

$dbConnection = getDbConnection();
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Host = '127.0.0.1';
$mail->Port = 1025;
$mail->Username  = '';
$mail->Password = '';

$mail->setFrom('asma.ab.dev@gmail.com', 'MMS Team');
$mail->addReplyTo('reply-to-email@gmail.com', 'MMS Team');

if (isset($_POST['confirm_reset_password']) && isset($_POST['email'])) {

    $email = $_POST['email'];
    $stmt = $dbConnection->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {

        $token = md5($email);
        $expiry_time = mktime(date("H", time() + 3600), date("i"), date("s"), date("m"), date("d"), date("Y"));
        //var_dump($expiry_time);
        $expiry_date = date("Y-m-d H:i:s", $expiry_time);

        $stmt = $dbConnection->prepare("UPDATE users SET reset_link_token = :token, expiry_date = :expiry_date WHERE email = :email");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expiry_date', $expiry_date);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        //var_dump($stmt);
        $link = "http://localhost:4000/reset-password.php?email={$email}&token={$token}";

        echo "Click the link below to reset your password:<br>";
        echo "<a href='{$link}'>Click To Reset Password</a>";

        // Email send code
        $to_email = $email;
        $mail_subject = "Reset Password";
        $mail_content = "<a href='{$link}'>Click To Reset Password</a>";
        //var_dump($link);
        // Email send code
        $to_email = $email;
        //var_dump($to_email);

        $mail_subject = "Reset Password";
        $mail_content = $link;

        // Always set content-type when sending HTML email


        // Send email
        try {
            $mail->addAddress($to_email);
            $mail->Subject = $mail_subject;
            $mail->isHTML(true);
            $mail->Body = $mail_content;
            $mail->send();
            echo "Check your email and click on the link to reset the password.";
        } catch (Exception $e) {
            echo "Something went wrong while sending an email. Please try again. Error: {$mail->ErrorInfo}";
        }

    } else {
        echo "Invalid Email Address. Go back";
    }
}
?>
