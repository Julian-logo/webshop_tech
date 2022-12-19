<?php
session_start();
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "webshop";

$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if (isset($_POST['submit']) && isset($_FILES['my_image'])) {
    echo "<pre>";
    print_r($_FILES['my_image']);
    echo "<pre>";

    $img_name = $_FILES['my_image']['name'];
    $img_size = $_FILES['my_image']['size'];
    $tmp_name = $_FILES['my_image']['tmp_name'];
    $error = $_FILES['my_image']['error'];

    if ($error === 0) {
        if ($img_size > 250000) {
            $em = "Sorry, your file is too large.";
        }else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true). '.' .$img_ex_lc;
                $img_upload_path = 'uploads/'.$new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                $phone_id = $_SESSION['phone_id'];
                // Insert into Database
                $sql = "INSERT INTO images(phone_id, image_url) 
				        VALUES('$phone_id','$new_img_name')";
                mysqli_query($con, $sql);
                header("Location: homepage.php");

            }else {
                $em = "You can't upload files of this type";

            }
        }
    }else {
        $em = "unknown error occurred!";

    }

}else {
    echo("fehler");
}