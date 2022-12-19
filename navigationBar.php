<nav class="nav">
    <ul>
        <?php echo !empty($_SESSION['user_name']) ? "Username: " . $_SESSION['user_name'] : null; ?>
        <li><?php echo "Just for Debug UserID: ", $_SESSION['user_id'] ?></li>
        <li><?php echo "Just for Debug phoneID: ", $_SESSION['phone_id'] ?></li>
        <?php


        $links = array(
            "Search for Phones" => "searchPage.php",
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

