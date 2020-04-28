<?php

session_start();

include "../backend_logic/logic.connection.php";

// Check user logged or not
if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

//ovo radi treba da se svuda stavi
if (($_SESSION["current_role"]) != 1) {
    session_unset();
    session_destroy();
    header('Location: ../person/person_login.php?');
}

?>

<html>

<head>
    <title>
        <?php
        echo $_SESSION["current_username"];
        ?>
    </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="../visuals/user/user_nav.css">
    <link rel="stylesheet" href="../visuals/user/profile.css">
    <link rel="stylesheet" href="../visuals/submit_button.css">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../visuals_js/hamburger_nav.js"></script>
</head>

<body>
    <div class="wrapper collapse">
        <div class="top_navbar">
            <div class="hamburger">
                <div class="one"></div>
                <div class="two"></div>
                <div class="three"></div>
            </div>
            <div class="top_menu">
                <div class="logo">
                    <?php
                    echo "<p class='welcomeUser'>Hello: " . $_SESSION["current_username"] . "</p>";
                    ?>
                </div>
                <ul>
                    <li>
                        <form method="POST" action="../backend_logic/logic.logout.php">
                            <button type="submit" id="btn_logout" name="btn_logout"><i class="fas fa-sign-out-alt" style="font-size:18px;"></i></button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="sidebar">
            <ul>
                <li><a href="index.php">
                        <span class="icon"><i class="fas fa-home"></i></span>
                        <span class="title">Home</span></a></li>
                <li><a href="#" class="active">
                        <span class="icon"><i class="fas fa-user-alt"></i></span>
                        <span class="title">Profile</span>
                    </a></li>
                <li><a href="books_all.php">
                        <span class="icon"><i class="fas fa-book"></i></span>
                        <span class="title">All books</span>
                    </a></li>
                <li><a href="book_rent_history.php">
                        <span class="icon"><i class="fas fa-history"></i></span>
                        <span class="title">Rent history</span>
                    </a></li>
                <li><a href="book_review_history.php">
                        <span class="icon"><i class="fas fa-comment-dots"></i></span>
                        <span class="title">Review history</span>
                    </a></li>
            </ul>
        </div>

        <div class="main_container">


            <div class="profileFull">
                <div class="profilePic">
                    <img src="../visuals/img/profile_pic.png" height="50%">
                </div>

                <div class="profileDesc">

                    <?php
                    $upit = "SELECT person_id, person_name, person_surname, person_age, person_username, person_password FROM person WHERE person_id = " . $_SESSION["current_userID"];
                    $result = mysqli_query($conn, $upit);

                    if ($result = mysqli_query($conn, $upit)) {

                        while ($row = $result->fetch_assoc()) : ?>
                            <form action="backend_logic/update_profile.php" method="POST" class="forma">

                                <div class="outer">

                                    <div class="input_profile">
                                        <input class="animacija" type="hidden" id="txtID" name="txtID" value="<?php echo $row['person_id']; ?>" required>
                                        <span class="focus-border"></span>
                                    </div>

                                    <div class="input_profile">
                                        <input class="animacija" type="text" id="txt_name" name="txt_name" placeholder="Name" value="<?php echo $row['person_name']; ?>" required>
                                        <span class="focus-border"></span>
                                    </div>

                                    <div class="input_profile">
                                        <input class="animacija" type="text" id="txt_surname" name="txt_surname" placeholder="Surname" value="<?php echo $row['person_surname']; ?>" required>
                                        <span class="focus-border"></span>
                                    </div>

                                    <div class="input_reister_age">
                                        <input class="animacija" type="number" id="txt_age" name="txt_age" placeholder="Age" value="<?php echo $row['person_age']; ?>" maxlength="3" min="18" max="100">
                                        <span class="focus-border"></span>
                                    </div>

                                    <div class="input_profile">
                                        <input class="animacija" type="text" id="txt_username" name="txt_username" placeholder="Username" value="<?php echo $row['person_username']; ?>" required>
                                        <span class="focus-border"></span>
                                    </div>

                                    <div class="input_profile">
                                        <input class="animacija" type="text" id="txt_password" name="txt_password" placeholder="Password" value="<?php echo $row['person_password']; ?>" required>
                                        <span class="focus-border"></span>
                                    </div>

                                </div>

                                <div class="button_submit">
                                    <button class="but_anim" type="submit" name="btn_update" id="btn_update">
                                        Update your profile
                                    </button>

                                    <p style="margin-top: 10px;font-size:12px">In order for changes to fully take place you will be logged out</p>
                                </div>
                            </form>

                    <?php endwhile;

                        $result->free();
                    } ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>