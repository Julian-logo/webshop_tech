<?php
session_start();
// these lines check if user logged in
include("connection.php");
include("functions.php");

// setting up phpMailer for verification of the mail
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
include ('Mailin.php');

require_once('vendor/autoload.php');
$config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');
$apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
    new GuzzleHttp\Client(),
    $config
);

if($_SERVER['REQUEST_METHOD'] == "POST") {

    // Informations from the new user
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail();
    $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

    $sendSmtpEmail['subject'] = 'Email verification';
    $sendSmtpEmail['htmlContent'] = '<html><body><h1>This is a transactional email </h1> <p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p></body></html>';
    $sendSmtpEmail['sender'] = array('name' => 'Smartphone Webshop', 'email' => 'julian1997hardekopf@gmail.com');
    $sendSmtpEmail['to'] = array(
        array('email' => $email, 'name' => $user_name)
    );
    $getUsers = "select * from users where user_name = '$user_name' limit 1";
    $resultUsers = mysqli_query($con, $getUsers);

    $user_data = mysqli_fetch_assoc($resultUsers);

    if(!empty($user_name && $password && $email) && $user_data['user_name'] != $user_name) {
        // save to the database
        $user_id = random_num(20);

        $query = "insert into users (user_id,user_name,password, email, verification_code, email_verified_at)
                  values ('$user_id','$user_name','$password', '$email', $verification_code, NULL)";
        mysqli_query($con, $query);


        // send email
        try {
            $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
            print_r($result);
            header("Location: email-verification.php");
        } catch (Exception $e) {
            echo 'Exception when calling TransactionalEmailsApi->sendTransacEmail: ', $e->getMessage(), PHP_EOL;
        }
    } else {

        echo("Either one field is emtpy or the username is already occupied");
    }

}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>

<div id="box">
    <form method="post">
        <div id="login">Signup</div>
        <p>enter name:</p>
        <input id="text" type="text" name="user_name">
        <p>enter password:</p>
        <input id="text" type="password" name="password">
        <p>enter email:</p>
        <input id="text" type="text" name="email">

        <input id="button" type="submit" value="Signup">
        <a href="login.php">Click to Login</a>
    </form>

</div>
</body>
</html>

