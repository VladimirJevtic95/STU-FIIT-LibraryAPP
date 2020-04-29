<?php

session_start();

include "../backend_logic/logic.connection.php";

if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

if (($_SESSION["current_role"]) != 2) {
    session_unset();
    session_destroy();
    header('Location: ../person/person_login.php?');
}

$DATE = date("Y-m-d", strtotime('-18 years'));

?>

<html>

<head>
    <title>
        <?php
        echo $_SESSION["current_username"];
        ?>
    </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" href="../visuals/librarian/librarian_nav.css">
    <link rel="stylesheet" href="../visuals/librarian/add_new_author_style.css">
    <link rel="stylesheet" href="../visuals/magnific-popup.css">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../visuals_js/hamburger_nav.js"></script>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="../visuals_jq/jquery.magnific-popup.js"></script>
    <script src="../visuals_js/review_textarea_count.js"></script>

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
                    echo "<p class='welcomeUser'>" . $_SESSION["current_username"] . "</p>";
                    ?>
                </div>
                <ul>
                    <li>
                        <a href="profile.php">
                            <i class="fas fa-user-alt"></i>
                        </a>
                    </li>
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
                        <span class="icon"><i class="fas fa-users"></i></span>
                        <span class="title">Users</span>
                    </a></li>
                <li><a href="books.php">
                        <span class="icon"><i class="fas fa-book"></i></span>
                        <span class="title">All books</span>
                    </a></li>
                <li><a href="book_add.php">
                        <span class="icon"><i class="fas fa-folder-plus"></i></span>
                        <span class="title">New book</span>
                    </a></li>
                <li><a href="#"  class="active">
                        <span class="icon"><i class="fas fa-user-plus"></i></span>
                        <span class="title">New author</span>
                    </a></li>
            </ul>
        </div>

        <div class="main_container">


            <form method="POST" action="backend_logic/add_new_author.php" class='forma'>
                <div class='add_new_author'>
                    Author name:&nbsp;&nbsp;<input class='inputfield' required type="text" name="AuthorName" placeholder="Author Name" maxlength="40">
                    <br><br>
                    Author surname:&nbsp;&nbsp;<input class='inputfield' required type="text" name="AuthorSurname" placeholder="Author Surname" maxlength="40">
                    <br><br>
                    Author date of birth:&nbsp;&nbsp;<input class='inputfield' required type="date" name="DateOfBirth" placeholder="date of birth" value="<?php echo $DATE ?>" min="1400-01-01" max="<?php echo $DATE ?>">
                    <br><br>
                    <div class='button_submit'>
                        <button type="submit" class='but_anim' id="btn_add" name="btn_add_new_author">Add new author</button>
                    </div>

                </div>
            </form>

        </div>

    </div>

</body>


</html>