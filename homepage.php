<?php
session_start();
include("connection.php");
include("functions.php");
include "navigationBar.php";
include "upload.php";

if(!isset($_SESSION['user_id'])) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Login</title>
        <link href="styles.css" rel="stylesheet">
    </head>
    <body>

    <div class="login-message">
        <h1>Please log in to view this page</h1>
        <p>To access this page, you must be logged in to your Account. If you don't have an account, you can <a href="signup.php">sign up</a> for one now.</p>
        <a href="login.php" class="button">Log in</a>
    </div>

    </body>
    </html>
    <?php
} else {

$user_id = $_SESSION['user_id'];

$getPhoneFromUser = "select * from phone where user_id = '$user_id' limit 1";

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "webshop";

$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

$deleteExecuted = false;

function getData($data) {
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "webshop";

    $con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

    $currentUser = $_SESSION['user_id'];
    $query = "select * from phone where user_id = '$currentUser' limit 1";


    $result = mysqli_query($con, $query);
    $phone_data = mysqli_fetch_assoc($result);
    if (!$result || empty($phone_data)) {
        // Query failed
        return "";
    } else {

        return $phone_data[$data];
    }

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
    $row = mysqli_fetch_assoc($result);
    if($result || !$row) {

        return !empty($row) ? $row['phone_id'] : null;
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

}

if(isset($_POST['deletePhoneData'])) {

    $deleteData = "DELETE p, i FROM phone p
    JOIN images i ON p.phone_id = i.phone_id
    WHERE p.user_id = '$user_id'";

    $res4 = mysqli_query($con, $deleteData);

}

if(isset($_POST['updatePhoneData'])) {
    $brand = $_POST['brandView'];
    $model = $_POST['modelView'];
    $screenSize = $_POST['screenSizeView'];
    $ramSize = $_POST['ramSizeView'];
    $storageSize = $_POST['storageSizeView'];
    $color = $_POST['colorView'];
    $price = $_POST['priceView'];

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

}


// still doesnt work properly, only all pictures are getting deleted
function deletePic() {
    global $deleteExecuted;
    include "connection.php";
    if($deleteExecuted) {
        $currentPhoneID = checkForPhoneID5();
        $sqlPhonePictureMatches = "SELECT * FROM images WHERE phone_id = '$currentPhoneID' limit 1";
        $res3 = mysqli_query($con, $sqlPhonePictureMatches);
        $images = mysqli_fetch_assoc($res3);

            if (isset($_POST['deletePic'])) {
                $imagePhoneId = $images['phone_id'];
                $imagePath = $images['image_url'];
                // Delete the file from the "uploads" directory
                unlink("uploads/$imagePath");
                // Delete the record from the database
                $sql = "DELETE FROM images WHERE phone_id = '$imagePhoneId' limit 1";
                $result = mysqli_query($con, $sql);

            }
    }
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

<h1 class="h1">This is your Page</h1>
<h2 class="h2">Upload new phone:</h2>


<button class="button" style="display: inline-block; margin: auto;" onclick="submitForm()">Open uploadPhone Form</button>

<script>
    function submitForm() {
        document.getElementById('uploadPhone').style.display='block';
        document.getElementById('uploadPicture').style.display='none';
        document.getElementById('viewPhone').style.display='none';

    }

</script>

<button id="showPhoneData" style="display: inline-block; margin: auto;" onclick="document.getElementById('uploadPhone').style.display='none',
    document.getElementById('uploadPicture').style.display='none';
    document.getElementById('viewPhone').style.display='block';">View or Update Phone Data</button>

<button id="showPhoneData" style="display: inline-block; margin: auto;" onclick="document.getElementById('uploadPhone').style.display='none',
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
        <input class="phoneName" type="text" name="brandView" placeholder="Enter brand of phone" value="<?php echo(getData('brand'));?>"> - Enter the brand of the phone, such as "Apple," "Samsung," or "Google."
        <input class="phoneName" type="text" name="modelView" placeholder="Enter model of phone" value="<?php echo(getData('model'));?>"> - Enter the model of the phone, such as "iPhone 12," "Galaxy S21," or "Pixel 5."
        <input class="phoneName" type="text" name="screenSizeView" placeholder="Enter screen size of the phone" value="<?php echo(getData('screenSize'));?>"> - Enter the screen size of the phone in inches, such as "6.1" or "6.7."
        <input class="phoneName" type="text" name="ramSizeView" placeholder="Enter ram size of the phone" value="<?php echo(getData('ramSize'));?>"> - Enter the RAM size of the phone in gigabytes, such as "4" or "8."
        <input class="phoneName" type="text" name="storageSizeView" placeholder="Enter storage size of the phone" value="<?php echo(getData('storageSize'));?>"> - Enter the storage size of the phone in gigabytes, such as "64" or "256."

        <input class="phoneName" type="text" name="colorView" placeholder="Enter the color of the phone" value="<?php echo(getData('color'));?>"> - Enter the color of the phone, such as "black," "white," or "red."

        <input class="phoneName" type="text" name="priceView" placeholder="Enter the price of the phone" value="<?php echo(getData('price'));?>"> - Enter the price of the phone in US dollars, such as "799" or "999."



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
            $deleteExecuted = true;
            while($images = mysqli_fetch_assoc($res3)) {
                       ?>
                <div id="alb" style="display: flex; width: 50%;">
                    <img id="alb-img" src="uploads/<?=$images['image_url']?>" style="width: 100%; margin-bottom: 20px; display: inline-block; float: left">
                    <input id="deletePicture" type="submit" name="deletePic" value="delete Picture" <?php deletePic(); $deleteExecuted = false;  ?>>
                </div>

            <?php }
            $deleteExecuted = false;
        }?>

        <input id="button" class="center" type="submit" name="updatePhoneData" value="update Data" style="margin-top: 20px">
        <input id="button" class="center" type="submit" name="deletePhoneData" value="delete all phone data" style="margin-top: 20px">

    </div>
</form>

<form action="upload.php"
      method="post"
      enctype="multipart/form-data" id="uploadPicture" style="display: none">

    <input type="file"
           name="my_image">

    <input type="submit"
           name="submit"
           value="Upload" id="button">

</form>


</div>

</div>
</body>
</html>


<?php } ?>