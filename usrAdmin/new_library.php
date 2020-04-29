<?php

session_start();

include "../backend_logic/logic.connection.php";

if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

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
                    echo "<p class='welcomeUser'>" . $_SESSION["current_username"] . " -> add new library</p>";
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

            <br><Br>

            <form method="POST" action="backend_logic/add_new_library.php" class='forma'>

                <div class='add_new_book'>
                    <div class="redjedan">
                        Name:&nbsp;&nbsp;<input type="text" name="Name" class='inputfield1' required placeholder="Name" maxlength="50">
                        <br><br>
                        Country:&nbsp;&nbsp;<input type="text" name="Country" class='inputfield1' required placeholder="Country" maxlength="30">
                    </div>
                    <div class="redjedan">
                        City:&nbsp;&nbsp;<input type="text" name="City" class='inputfield1' required placeholder="City" maxlength="30">
                        <br><br>
                        Address:&nbsp;&nbsp;<input type="text" name="Address" class='inputfield1' required placeholder="Address" maxlength="100">
                    </div>
                    <br><Br>
                    <div class="redjedan">
                        Phone:&nbsp;&nbsp;<input type="text" name="Phone" class='inputfield1' placeholder="Phone" maxlength="50">
                        <br><br>
                        Email:&nbsp;&nbsp;<input type="text" name="Email" class='inputfield1' placeholder="Email" maxlength="50">
                        <br><br>
                        Website:&nbsp;&nbsp;<input type="text" name="Website" class='inputfield1' placeholder="Website" maxlength="50">
                    </div>
                    <div class="redjedan">
                        Size:&nbsp;&nbsp;<select name="Size" class="inputfield1 dropdown-select">
                            <?php
                            $sql = "SELECT library_size_id , library_size_name FROM library_size ORDER BY library_size_id ASC";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<option value=' . $row['library_size_id'] . '>' . $row['library_size_name'] . '</option>';
                            }
                            ?>
                        </select>
                        <br><br>
                        Type:&nbsp;&nbsp;<select name="Type" class="inputfield1 dropdown-select">
                            <?php
                            $sql = "SELECT library_type_id, library_type_name FROM library_type ORDER BY library_type_name ASC";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<option value=' . $row['library_type_id'] . '>' . $row['library_type_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <br><br>
                    <div class='button_submit1'>
                        <button type="submit" class='but_anim' id="btn_add" name="btn_add_new_library">Add new library</button>
                    </div>

                </div>
            </form>

        </div>
    </div>

</body>

</html>