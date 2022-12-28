<nav class="nav">
    <ul>
        <?php // echo !empty($_SESSION['user_name']) ? "Username: " . $_SESSION['user_name'] : null; ?>
        <li><?php // echo !empty($_SESSION['user_id']) ? "Just for Debug UserID: " . $_SESSION['user_id'] : null ?></li>
        <li><?php function checkForPhoneID3() {
                include "connection.php";
                !empty($_SESSION['user_id']) ? $user_id = $_SESSION['user_id'] : null;

                // $getPhoneFromUser = "select * from phone where user_id = '$user_id' limit 1";
                // $resultUser = mysqli_query($con, $getPhoneFromUser);
                //$resultID = $resultUser['user_id'];

                if(!empty($_SESSION['user_id'])) {
                    $query = "SELECT * FROM phone WHERE user_id = '$user_id' ";
                    $result = mysqli_query($con, $query);
                    if($result) {
                        $row = mysqli_fetch_assoc($result);
                        return $row['phone_id'];
                    } else {
                        return random_num(20);
                    }
                }

            } //echo "Just for Debug phoneID: ", checkForPhoneID3() ?></li>
        <?php


        $links = array(
            "Search for Phones" => "searchPage.php",
            "My Page" => "homepage.php",
            "Sign up" => "signup.php",
            "Login" => "login.php",
            "Logout" => "logout.php",

        );

        foreach ($links as $link => $url) {
            echo "<li><a href='$url'>$link</a></li>";
        }
        ?>

    </ul>
</nav>

