<?php
session_start();
include("connection.php");
include("functions.php");
include("navigationBar.php");

$resultsPerPage = 4; // Number of results to display per page
$pageNumber = 1; // Default page number

// Check if the search form has been submitted
if(isset($_POST['go'])) {
    $searchInput = $_POST['search'];

    // Check if a page number has been specified in the URL
    if (isset($_GET['page'])) {
        $pageNumber = (int)$_GET['page'];
    }

    // Calculate the offset based on the page number
    $offset = ($pageNumber - 1) * $resultsPerPage;

    // Fetch the search results from the database
    $sql2 = "SELECT phone.*, images.image_url FROM phone INNER JOIN images ON phone.phone_id = images.phone_id WHERE phone.brand = '$searchInput' 
             OR phone.model = '$searchInput' OR phone.screenSize = '$searchInput' OR phone.ramSize = '$searchInput' OR phone.storageSize = '$searchInput'
             OR phone.color = '$searchInput' OR phone.price = '$searchInput' OR (phone.price < 300 AND '$searchInput' = 'cheap') 
             OR (phone.screenSize > 1 AND '$searchInput' = 'gaming')";
    $res2 = mysqli_query($con, $sql2);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<form id="searchbar" method="post">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search" style="css styles go here" placeholder="enter brand or model or gaming or cheap or size ... of the phone you are searching for">
    <button type="submit" name="go" style="">Go</button>
    <button type="submit" id="resetButton" name="reset" onclick="document.getElementById('search').value = ''" >Reset Input</button>
</form>

<?php if (isset($_POST['go'])) { ?>
<form id="phoneGrid">
    <div id="phoneGrid" style="display: flex; flex-wrap: wrap;">
        <?php
        // Iterate over the search results and pair the corresponding image and phone data
        while($data = mysqli_fetch_assoc($res2)) {
            ?>
            <div class="phone-item">
                <img src="uploads/<?=$data['image_url']?>" alt="<?=$data['model']?>">
                <p>Brand of the Phone: <?=$data['brand']?></p>
                <p>Model: <?=$data['model']?></p>
                <p>Screen Size: <?=$data['screenSize']?></p>
                <p>RAM: <?=$data['ramSize']?></p>
                <p>Storage: <?=$data['storageSize']?></p>
                <p>Color: <?=$data['color']?></p>
                <span class="price">$<?=$data['price']?></span>
            </div>
        <?php } ?>
    </div>
</form>


    <?php


    // Calculate the total number of pages
    $totalResults = mysqli_num_rows($res2);
    $totalPages = ceil($totalResults / $resultsPerPage);


    if ($totalPages > 1) {
        // Display the pagination links
        ?>
        <div class="pagination">
            <?php if ($pageNumber > 1) { ?>
                <a href="?search=<?=urlencode($searchInput)?>&page=<?=$pageNumber - 1?>">&laquo;</a>
            <?php } ?>
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <a href="?search=<?=urlencode($searchInput)?>&page=<?=$i?>" <?php if ($i == $pageNumber) { echo 'class="active"'; } ?>><?=$i?></a>
            <?php } ?>
            <?php if ($pageNumber < $totalPages) { ?>
                <a href="?search=<?=urlencode($searchInput)?>&page=<?=$pageNumber + 1?>">&raquo;</a>
            <?php } ?>
        </div>
        <?php
    }
    ?>
<?php } ?>

<?php if(!isset($_POST['go']) || isset($_POST['reset'])) { ?>


    <form id="phoneGrid">
        <?php
        // Fetch all phone and image records where the phone_id is not the current phone_id
        !empty($_SESSION['phone_id']) ? $currentPhoneID = $_SESSION['phone_id'] : $currentPhoneID = "";
        $sql = "SELECT phone.*, images.image_url FROM phone INNER JOIN images ON phone.phone_id = images.phone_id WHERE phone.phone_id <> '$currentPhoneID'";
        $res = mysqli_query($con, $sql);
        ?>
        <div id="phoneGrid" style="display: flex; flex-wrap: wrap;">
            <?php
            // Iterate over both results and pair the corresponding image and phone data
            while($data = mysqli_fetch_assoc($res)) {
                ?>
                <div class="phone-item">
                    <img src="uploads/<?=$data['image_url']?>" alt="<?=$data['model']?>">
                    <p>Brand of the Phone: <?=$data['brand']?></p>
                    <p>Model: <?=$data['model']?></p>
                    <p>Screen Size: <?=$data['screenSize']?></p>
                    <p>RAM: <?=$data['ramSize']?></p>
                    <p>Storage: <?=$data['storageSize']?></p>
                    <p>Color: <?=$data['color']?></p>
                    <span class="price">$<?=$data['price']?></span>
                </div>
            <?php } ?>

        </div>
    </form>
<?php } ?>

</body>
</html>



