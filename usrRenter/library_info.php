<?php

session_start();

include "../backend_logic/logic.connection.php";

if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

if (($_SESSION["current_role"]) != 1) {
    session_unset();
    session_destroy();
    header('Location: ../person/person_login.php?');
}

$LIBRARY_ID = (int) $_REQUEST['ID'];

$sql_library_name = "SELECT library_name FROM library_data WHERE library_id = $LIBRARY_ID";
$result_library_name = mysqli_query($conn, $sql_library_name);
$row_library_name = $result_library_name->fetch_assoc();
$library_name = $row_library_name['library_name'];
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
    <link rel="stylesheet" href="../visuals/user/library_info.css">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../visuals_js/hamburger_nav.js"></script>

    <link rel="stylesheet" type="text/css" href="../gallery_library/fancybox/jquery.fancybox.min.css">
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
                    echo "<p class='welcomeUser' style='float:left'>Library info: " . $library_name . "&nbsp;&nbsp;</p>";
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
                        <span class="icon"><i class="fas fa-home"></i></span>
                        <span class="title">Home</span></a></li>
                <li><a href="profile.php">
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

            <?php
            $upit = "SELECT 
            library_data.library_id, library_data.library_name, library_data.library_country, library_data.library_adress, library_data.library_email,
            library_data.library_website, library_data.library_phone, library_size.library_size_name, library_type.library_type_name
            FROM library_data, library_size, library_type WHERE 
            library_data.library_id = $LIBRARY_ID AND library_data.library_size_FK = library_size.library_size_id AND library_data.library_type_FK = library_type.library_type_id";
            $result = mysqli_query($conn, $upit);

            while ($row = mysqli_fetch_object($result)) {
                echo "<ul>";
                echo "<li style='padding:3px'><strong>Coutry:</strong> {$row->library_country}</li>";
                echo "<li style='padding:3px'><strong>Address:</strong> {$row->library_adress}</li>";
                echo "<li style='padding:3px'><strong>Library email address:</strong> {$row->library_email}</li>";
                echo "<li style='padding:3px'><strong>Library web apge:</strong> <a href='{$row->library_website}' target='_blank'>{$row->library_name} web</a></li>";
                echo "<li style='padding:3px'><strong>Library :</strong> {$row->library_phone}</li>";
                echo "<li style='padding:3px'><strong>Size:</strong> {$row->library_size_name}, <strong>type:</strong> {$row->library_type_name}</li>";
                echo "</ul>";
            }
            ?>

            <br> <br>

            <div class="galerija">
                <div class="image_gal">
                    <a href="../visuals/img/lib1.jpg" data-fancybox="gallery">
                        <img src="../visuals/img/lib1.jpg" alt="Image" class="img-fluid">
                    </a>
                </div>
                <div class="image_gal">
                    <!--slideshow-->
                    <a href="../visuals/img/lib2.jpg" data-fancybox="gallery">
                        <!--galerija noramlna-->
                        <img src="../visuals/img/lib2.jpg" alt="Image" class="img-fluid">
                    </a>
                </div>
                <div class="image_gal">
                    <a href="../visuals/img/lib3.jpg" data-fancybox="gallery">
                        <img src="../visuals/img/lib3.jpg" alt="Image" class="img-fluid">
                    </a>
                </div>
                <div class="image_gal">
                    <a href="../visuals/img/lib4.jpg" data-fancybox="gallery">
                        <img src="../visuals/img/lib4.jpg" alt="Image" class="img-fluid">
                    </a>
                </div>
                <div class="image_gal">
                    <!--slideshow-->
                    <a href="../visuals/img/lib5.jpg" data-fancybox="gallery">
                        <!--galerija noramlna-->
                        <img src="../visuals/img/lib5.jpg" alt="Image" class="img-fluid">
                    </a>
                </div>
                <div class="image_gal">
                    <a href="../visuals/img/lib6.png" data-fancybox="gallery">
                        <img src="../visuals/img/lib6.png" alt="Image" class="img-fluid">
                    </a>
                </div>
            </div>
        </div>

    </div>

    <script src="../gallery_library/jquery/jquery-3.4.1.min.js"></script>
    <script src="../gallery_library/fancybox/jquery.fancybox.min.js"></script>
    <script src="../gallery_library/fancybox/fancybox.js"></script>
</body>

</html>