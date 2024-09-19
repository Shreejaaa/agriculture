<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="enter_token.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend><h2>Enter Token</h2></legend>
            <label>Token</label>
            <input type="text" name="token" placeholder="Enter token" required><br><br>
            <input type="submit" value="Submit" name="submit">
        </fieldset>
    </form>

    <?php 
    session_start();
    if(isset($_POST['submit'])){
        if(isset($_SESSION['reset_email'])){
            $email = $_SESSION['reset_email'];
            $token = $_POST['token'];
        
            include("../../admin_and_user/connection.php");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $email = $conn->real_escape_string($email);
            $token = $conn->real_escape_string($token);

            $qry = "UPDATE USERS SET token = '$token' WHERE email = '$email'";
            if ($conn->query($qry) === TRUE) {
                header("Location: reset_password.php");
                exit();
            } else {
                echo "Failed to update token: " . $conn->error;
            }

            $conn->close();
        }
    }
    ?>
</body>
</html>
