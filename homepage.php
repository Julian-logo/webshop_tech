<?php
session_start();
include("connection.php");
include("functions.php");
include "navigationBar.php";
include "upload.php";

$user_id = $_SESSION['user_id'];

$getPhoneFromUser = "select * from phone where user_id = '$user_id' limit 1";

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "webshop";

$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

function getData($data) {
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "webshop";

    $con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

    $currentUser = $_SESSION['user_id'];
    $query = "select * from phone where user_id = '$currentUser' limit 1";


    $result = mysqli_query($con, $query);

    if (!$result) {
        // Query failed
        echo "Error: " . mysqli_error($con);
        return "";
    }
    $phone_data = mysqli_fetch_assoc($result);
    return $phone_data[$data];
}



if(!empty($getPhoneFromUser)) {
    $resultUsers = mysqli_query($con, $getPhoneFromUser);

    $user_dataPhones = mysqli_fetch_assoc($resultUsers);
}


        // checks if submit is clicked and uploads the phone data

function checkForPhoneID5() {

    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "webshop";

    $con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

    $user_id = $_SESSION['user_id'];


    $query = "SELECT * FROM phone WHERE user_id = '$user_id' ";
    $result = mysqli_query($con, $query);
    if($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['phone_id'];
    } else {
        return random_num(20);
    }
}
function checkForPhoneID() {
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "webshop";

    $con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

    // Generate a new, unique phone_id value
    $phone_id = random_num(20);

    // Check if a phone record with this phone_id already exists in the table
    $query = "SELECT * FROM phone WHERE phone_id = '$phone_id' ";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        // A phone record with this phone_id already exists, so generate a new phone_id value and try again
        return checkForPhoneID();
    } else {
        // No phone record with this phone_id exists, so return the new phone_id value
        return $phone_id;
    }
}

if (isset($_POST['uploadPhoneData'])) {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $screenSize = $_POST['screenSize'];
    $ramSize = $_POST['ramSize'];
    $storageSize = $_POST['storageSize'];
    $color = $_POST['color'];
    $price = $_POST['price'];

    $phone_id = checkForPhoneID();

    $_SESSION['phone_id'] = $phone_id;
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO phone (phone_id,user_id, brand, model, screenSize, ramSize, storageSize, color, price) 
    VALUES ('$phone_id', '$user_id', '$brand', '$model', '$screenSize', '$ramSize', '$storageSize', '$color', '$price')
    ON DUPLICATE KEY UPDATE brand = '$brand', model = '$model', screenSize = '$screenSize', ramSize = '$ramSize', storageSize = '$storageSize', color = '$color', price = '$price'";

    $resultInsert = mysqli_query($con, $query);

    if (mysqli_errno($con) > 0) {
        // query failed, display error message
        echo "Error: " . mysqli_error($con);
    } else {
        // query was successful, do something here
        echo "<script>alert('Added record successfully')</script>";
        header("Location: homepage.php");
    }

} else {
    echo "alert('All fields are required!');";
}

if(isset($_POST['deletePhoneData'])) {
    $queryDeleteData = "DELETE FROM phone WHERE user_id = '$user_id'";
    $phone_id2 = checkForPhoneID();
    $queryDeletePicture = "DELETE FROM images WHERE phone_id = '$phone_id2'";
    $res4 = mysqli_query($con, $queryDeleteData);
    $res5 = mysqli_query($con, $queryDeletePicture);
}

?>


<script>
    // Javascript from validator that checks if everything is put in
    function checkForm() {
        // Get all input fields
        var inputs = document.querySelectorAll('#phoneForm input');

        // Iterate over input fields
        for (var i = 0; i < inputs.length; i++) {
            // Check if the field is empty
            if (inputs[i].value === '') {
                alert('Please fill in all fields');
                return false;
            }
        }

        // If all fields are filled, submit the form
        alert('Added record successfully')
        return true;
    }


</script>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>

<h1>This is your Page</h1>
<h2>Upload new phone:</h2>


<button onclick="submitForm()">Open uploadPhone Form</button>

<script>
    function submitForm() {
        document.getElementById('uploadPhone').style.display='block';
        document.getElementById('uploadPicture').style.display='none';
        document.getElementById('viewPhone').style.display='none';

    }

</script>

<button id="showPhoneData" onclick="document.getElementById('uploadPhone').style.display='none',
    document.getElementById('uploadPicture').style.display='none';
    document.getElementById('viewPhone').style.display='block';">Open Phone Form</button>

<button id="showPhoneData" onclick="document.getElementById('uploadPhone').style.display='none',
    document.getElementById('viewPhone').style.display='none';
    document.getElementById('uploadPicture').style.display='block';">Upload Pictures</button>

<form name="uploadPhone" id="uploadPhone" method="post" onsubmit="return checkForm()" style="display: none" enctype="multipart/form-data">
    <div id="phoneForm">
        <form>
        <h2>Enter your phone data below:</h2>

            <input class="phoneName" type="text" name="brand" placeholder="Enter brand of phone" style="color: black; font-size: 16px; font-weight: bold;">
            <input class="phoneName" type="text" name="model" placeholder="Enter model of phone" style="color: black; font-size: 16px; font-weight: bold;">
            <input class="phoneName" type="text" name="screenSize" placeholder="Enter screen size of the phone" style="color: black; font-size: 16px; font-weight: bold;">
            <input class="phoneName" type="text" name="ramSize" placeholder="Enter ram size of the phone" style="color: black; font-size: 16px; font-weight: bold;">
            <input class="phoneName" type="text" name="storageSize" placeholder="Enter storage size of the phone" style="color: black; font-size: 16px; font-weight: bold;">
            <input class="phoneName" type="text" name="color" placeholder="Enter the color of the phone" style="color: black; font-size: 16px; font-weight: bold;">
            <input class="phoneName" type="text" name="price" placeholder="Enter the price of the phone" style="color: black; font-size: 16px; font-weight: bold;">
        </form>
        <p>Attention: If you have already provided data for your Phone, Inserting new Data will override your old phone Data</p>
        <input id="button" type="submit" name="uploadPhoneData" value="uploadPhone">
    </div>
</form>


<form name="viewPhone" id="viewPhone" method="post" style="display: none; width: 75%">
    <div id="loadPhone">
        <h2>These are the phone data you put down: </h2>
        <input class="phoneName" type="text" name="brand" placeholder="Enter brand of phone" value="<?php echo(getData('brand'));?>">
        <input class="phoneName" type="text" name="model" placeholder="Enter model of phone" value="<?php echo(getData('model'));?>">
        <input class="phoneName" type="text" name="screenSize" placeholder="Enter screen size of the phone" value="<?php echo(getData('screenSize'));?>">
        <input class="phoneName" type="text" name="ramSize" placeholder="Enter ram size of the phone" value="<?php echo(getData('ramSize'));?>">
        <input class="phoneName" type="text" name="storageSize" placeholder="Enter storage size of the phone" value="<?php echo(getData('storageSize'));?>">
        <input class="phoneName" type="text" name="color" placeholder="Enter the color of the phone" value="<?php echo(getData('color'));?>">
        <input class="phoneName" type="text" name="price" placeholder="Enter the price of the phone" value="<?php echo(getData('price'));?>">

        <?php
        $sql = "SELECT * FROM images ORDER BY id DESC";
        $res = mysqli_query($con,  $sql);
        $sqlphone = "SELECT * FROM phone";
        $res2 = mysqli_query($con, $sqlphone);

        // stopped here have to check if the user with his phone_id has records in the pictures table
        $currentUser = $_SESSION['user_id'];
        $query = "select * from phone where user_id = '$currentUser' limit 1";
        $result = mysqli_query($con, $query);

        // stopped here


        while($ids = mysqli_fetch_assoc($res2)) {
            $currentPhoneID = checkForPhoneID5();
            $sqlPhonePictureMatches = "SELECT * FROM images WHERE phone_id = '$currentPhoneID'";
            $res3 = mysqli_query($con, $sqlPhonePictureMatches);
        }
        if (mysqli_num_rows($res) > 0) {
            while($images = mysqli_fetch_assoc($res3)) {
                       ?>
                <div id="alb" style="display: flex; width: 50%;">
                    <img src="uploads/<?=$images['image_url']?>" style="width: 100%; margin-bottom: 20px; display: inline-block; float: left">
                </div>

            <?php }
        }?>

        <input id="button" type="submit" name="updatePhoneData" value="update Data" style="margin-top: 20px">
        <input id="button" type="submit" name="deletePhoneData" value="delete all phone data" style="margin-top: 20px">

    </div>
</form>

<form action="upload.php"
      method="post"
      enctype="multipart/form-data" id="uploadPicture" style="display: none">

    <input type="file"
           name="my_image">

    <input type="submit"
           name="submit"
           value="Upload">

</form>


</div>

</div>
</body>
</html>