<?php
session_start();
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "webshop";

$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if($_SERVER['REQUEST_METHOD'] == "POST") {
    // something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    // important test comment for github


    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // get data from the user
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];

        if (!empty($user_name) && !empty($password)) {

            //read from database
            $query = "select * from users where user_name = '$user_name' limit 1";
            $result = mysqli_query($con, $query);

            if ($result) {
                if ($result && mysqli_num_rows($result) > 0) {

                    $user_data = mysqli_fetch_assoc($result);

                    if ($user_data['password'] === $password) {

                        $_SESSION['user_id'] = $user_data['user_id'];

                    } else {
                        die("Password not correct");
                    }
                    if ($user_data['email_verified_at'] == null)  {
                        header("Location: email-verification.php");
                    } else {
                        header("Location: index.php");
                    }
                } else {
                    echo("wrong credentials, maybe create a new account?");
                }
            } else {
                echo("smth wrong");
            }

        } else {
            echo("wrong data");
        }
    }

}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>

<div id="box">
    <form method="post">
        <div id="login">Login</div>
        <p>Enter your name</p>
        <input id="text" type="text" name="user_name">
        <p>Enter your password</p>
        <input id="text" type="password" name="password">
        <input id="button" type="submit" value="Login">
        <a href="signup.php">Click to Signup</a>
    </form>

</div>
</body>
</html>