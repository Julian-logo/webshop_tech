<?php
session_start();

foreach ($_SESSION as $key => $value) {
    unset($_SESSION[$key]);
}

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: login.php");
exit;