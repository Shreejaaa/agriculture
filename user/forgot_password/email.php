<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="email.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend><h2>Reset Password</h2></legend>
            <label>Email</label>
            <input type="email" name="email" placeholder="Enter your email" required><br><br>
            <input type="submit" value="Submit" name="submit">
        </fieldset>
    </form>

<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function send_mail($email, $token)
{
    require '../PHPMailer/PHPMailer.php';
    require '../PHPMailer/Exception.php';
    require '../PHPMailer/SMTP.php';

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'koko.mitsuu@gmail.com';
        $mail->Password = 'oiov bjhy xxcl tcbp';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('koko.mitsuu@gmail.com', 'Irrigation');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset, Irrigation';
        $mail->Body = "Thank you for registration. Your OTP code is: $token";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $token = rand(10000, 99999);

   include("../../admin_and_user/connection.php");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($email);
    $qry = "SELECT email FROM USERS WHERE email = '$email'";
    $result = $conn->query($qry);

    if ($result->num_rows > 0) {
        $sql_update_token = "UPDATE USERS SET token = '$token' WHERE email = '$email'";
        if ($conn->query($sql_update_token) === TRUE) {
            $_SESSION['reset_email'] = $email;

            if (send_mail($email, $token)) {
                header("Location: enter_token.php");
                exit();
            } else {
                echo "Failed to send email.";
            }
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Email does not exist.";
    }

    $conn->close();
}
?>
</body>
</html>
