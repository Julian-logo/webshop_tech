<?php

session_start();


if (isset($_POST["verify_email"]))
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "webshop";

    $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);


    echo("you can enter now the verification we send you per mail");
    $verification_code = $_POST["verification_code"];



    // mark email as verified
    // $query = "select * from users where user_name = '$user_name' limit 1";
    // $sql = "UPDATE users SET email_verified_at = NOW() WHERE email = $email  AND verification_code = $verification_code";
    $sql = "UPDATE users SET email_verified_at = NOW() WHERE verification_code = $verification_code";
    $result  = mysqli_query($con, $sql);

    if (mysqli_affected_rows($con) == 0)
    {
        die("Verification code failed.");
    }

    echo "<p>You can login now.</p>";
    header("Location: login.php");
    exit();
}



?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<form method="POST">
    <h2>Look into your mails and enter the verification code below:</h2>
    <input type="text" name="verification_code" placeholder="Enter verification code" required />

    <input type="submit" name="verify_email" value="Verify Email">
</form>

</body>
</html>