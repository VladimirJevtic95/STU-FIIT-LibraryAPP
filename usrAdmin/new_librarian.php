<?php

session_start();

include "../backend_logic/logic.connection.php";

// Check user logged or not
if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

//ovo radi treba da se svuda stavi
if (($_SESSION["current_role"]) != 3) {
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
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" href="../visuals/librarian/librarian_nav.css">
    <link rel="stylesheet" href="../visuals/librarian/table.css">
    <link rel="stylesheet" href="../visuals/librarian/add_new_book_style.css">

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
                    echo "<p class='welcomeUser'>" . $_SESSION["current_username"] . " -> add new librarian</p>";
                    ?>
                </div>
                <ul>
                    <li>
                        <a href="new_librarian.php">
                            <i class="fas fa-plus"></i>
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
                <li><a href="workers.php">
                        <span class="icon"><i class="fas fa-user-tie"></i></span>
                        <span class="title">Librarians</span>
                    </a></li>
                <li><a href="libraries.php">
                        <span class="icon"><i class="fas fa-landmark"></i></span>
                        <span class="title">Libraries</span>
                    </a></li>
            </ul>
        </div>

        <div class="main_container">

            <form method="POST" action="backend_logic/add_new_librarian.php" class='forma'>

                <div class='add_new_book'>
                    <br><br>
                    Name:&nbsp;&nbsp;<input type="text" name="Name" class='inputfield' required placeholder="Name" maxlength="30">
                    <br><br>
                    Surname:&nbsp;&nbsp;<input type="text" name="Surname" class='inputfield' required placeholder="Surname" maxlength="30">
                    <br><br>
                    Username:&nbsp;&nbsp;<input type="text" name="Username" class='inputfield' required placeholder="Username" maxlength="60">
                    <br><br>
                    Password:&nbsp;&nbsp;<input type="text" name="Password" class='inputfield' required placeholder="Password" maxlength="60">
                    <br><br>
                    Age:&nbsp;&nbsp;<input type="number" name="Age" required class='inputfield' placeholder="age" maxlength="2" min="18" max="65">
                    <br><br>
                    <input type="hidden" name="RoleID" value="2">
                    <div class='button_submit'>
                        <button type="submit" class='but_anim' id="btn_add" name="btn_add_new_librarian">Add new librarian</button>
                    </div>

                </div>
            </form>

        </div>
    </div>

</body>

</html>