<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

?>

<!DOCTYPE html>
<html>
<head>
    <title>My website</title>
</head>
<body>
<br> <br>
<a href="logout.php">Logout</a>

<a href="login.php">login</a>

<a href="signup.php">signup</a>

<a href="connection.php">connection check</a>

<h1>This is the index page</h1>

<br>
Hello, <?php echo $user_data['user_name']; ?>
</body>
</html>
