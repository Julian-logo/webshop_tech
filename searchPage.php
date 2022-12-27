<?php
session_start();
include("connection.php");
include("functions.php");
include("navigationBar.php");


$currentUser = $_SESSION['user_id'];
$query = "select * from phone where user_id = '$currentUser' limit 1";
$result = mysqli_query($con, $query);



?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>

<form id="searchbar" style="css styles go here">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search" style="css styles go here">
    <button type="submit" style="">Go</button>
    <button type="reset" onclick="document.getElementById('search').value = ''" style="width: 40%">Reset</button>
</form>

<form id="phoneGrid">
    <?php

        $currentPhoneID = $_SESSION['phone_id'];
        $sqlPhonePictureMatches = "SELECT * FROM images WHERE phone_id <> '$currentPhoneID'";
        $res3 = mysqli_query($con, $sqlPhonePictureMatches);
        $phoneData = "SELECT * FROM phone WHERE phone_id <> '$currentPhoneID'";
        $res4 = mysqli_query($con, $phoneData)

        ?>
        <div id="phoneGrid" style="display: flex; flex-wrap: wrap;">
            <?php
        while($images = mysqli_fetch_assoc($res3)) {
            while ($data = mysqli_fetch_assoc($res4)) {
            ?>
            <div style="width: 50%; margin-top: 50px">
                <span name="phoneIDfromPhone"><?php echo "phoneID from phoneDB:", $data['phone_id']?></span>
                <img src="uploads/<?=$images['image_url']?>" style="width: 100%; margin-bottom: 50px;">
                <span name="phoneID"><?php echo "Phone ID from pictureDB:", $images['phone_id']?></span>
            </div>

        <?php }

        }
    ?>

</form>
</div>
</body>
</html>
