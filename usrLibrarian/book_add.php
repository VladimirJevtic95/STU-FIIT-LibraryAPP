<?php

session_start();

include "../backend_logic/logic.connection.php";

// Check user logged or not
if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}


//ovo radi treba da se svuda stavi
if (($_SESSION["current_role"]) != 2) {
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
    <link rel="stylesheet" href="../visuals/librarian/add_new_book_style.css">
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
                <li><a href="#" class="active">
                        <span class="icon"><i class="fas fa-folder-plus"></i></span>
                        <span class="title">New book</span>
                    </a></li>
                <li><a href="author_add.php">
                        <span class="icon"><i class="fas fa-user-plus"></i></span>
                        <span class="title">New author</span>
                    </a></li>
            </ul>
        </div>

        <div class="main_container">

        <br>

            <form method="POST" action="backend_logic/add_new_book.php" class='forma'>
                <div class='add_new_book'>
                    Book name:&nbsp;&nbsp;<input class='inputfield' required type="text" name="BookName" placeholder="Book name" maxlength="80">
                    <br><br>
                    Book published date:&nbsp;&nbsp;<input class='inputfield' required type="date" name="BookPublication">
                    <br><br>
                    <div class='ta_review'>
                        Book description:&nbsp;&nbsp;<textarea class='char-textarea' required id='BookDescription' maxlength='100' name='BookDescription' rows='10' placeholder='Short description goes here ...'></textarea>
                        <div id='the-count'>
                            <span class='char-count' id='current'>0</span>
                            <span id='maximum'>/ 100</span>
                        </div>
                    </div>
                    <br>
                    Book genre:&nbsp;&nbsp;<select class='inputfield' name="BookGenre" class="dropdown-select">
                        <?php
                        $sql = "SELECT genre_id, genre_name from book_genre ORDER BY genre_name";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value='" . $row['genre_id'] . "'>" . $row['genre_name'] . "</option>";
                        }
                        ?>
                    </select>
                    <br><br>
                    Book author:&nbsp;&nbsp;<select class='inputfield' name="BookAuthor" class="dropdown-select">
                        <?php
                        $sql = "SELECT author_id, author_name, author_surname from book_author ORDER BY author_name ASC";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<option value=' . $row['author_id'] . '>' . $row['author_name'] . " " . $row['author_surname'] . '</option>';
                        }
                        ?>
                    </select>
                    <br><br>
                    <div class='button_submit'>
                        <button type="submit" class='but_anim' id="btn_add" name="btn_add_new_book">Add new book</button>
                    </div>

                </div>
            </form>

        </div>

    </div>

</body>


</html>