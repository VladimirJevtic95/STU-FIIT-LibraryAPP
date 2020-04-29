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

?>

<html>

<head>
    <title>
        Home - <?php echo $_SESSION["current_username"]; ?>
    </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" href="../visuals/user/user_nav.css">
    <link rel="stylesheet" href="../visuals/user/index.css">

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
                <li><a href="#" class="active">
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

            <div class="indexPreview">
                <?php
                $upit = 'SELECT book.book_id, book.book_name, book.book_publication_date,book.book_short_description, 
                book_genre.genre_name, book_author.author_name, book_author.author_surname
                FROM book, book_genre, book_author
                WHERE book.book_genre_FK = book_genre.genre_id AND book.book_author_FK = book_author.author_id
                ORDER BY RAND() DESC LIMIT 10';

                if ($result = mysqli_query($conn, $upit)) {

                    while ($row = $result->fetch_assoc()) :

                        $BOOK_ID = $row['book_id'];

                        $sql1 = "SELECT AVG(review_rating) AS review_rating FROM book_review WHERE review_book_id_FK = $BOOK_ID";
                        $result1 = mysqli_query($conn, $sql1);
                        $row1 = $result1->fetch_assoc();
                        $rating_value = (int) $row1['review_rating'];

                        $sql2 = "SELECT COUNT(review_book_id_FK) AS total_num FROM book_review WHERE review_book_id_FK = $BOOK_ID";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = $result2->fetch_assoc();
                        $total_num = $row2['total_num'];

                        $rating_value = (int) $row1['review_rating'];
                        $total_num = $row2['total_num'];
                ?>

                        <div class="card">
                            <nav>
                                <div class='star-rating'>
                                    <div class='back-stars'>
                                        <i class='far fa-star star' aria-hidden='true'></i>
                                        <i class='far fa-star star' aria-hidden='true'></i>
                                        <i class='far fa-star star' aria-hidden='true'></i>
                                        <i class='far fa-star star' aria-hidden='true'></i>
                                        <i class='far fa-star star' aria-hidden='true'></i>
                                        <?php
                                        echo "<div class='front-stars' style='width:$rating_value%'>";
                                        ?>
                                        <i class='fa fa-star star' aria-hidden='true'></i>
                                        <i class='fa fa-star star' aria-hidden='true'></i>
                                        <i class='fa fa-star star' aria-hidden='true'></i>
                                        <i class='fa fa-star star' aria-hidden='true'></i>
                                        <i class='fa fa-star star' aria-hidden='true'></i>
                                    </div>
                                </div>
                                <p class="star-rating-total-num">&nbsp;(<?php echo $total_num; ?>)</p>
                            </nav>
                            <div class="photo">
                                <img src="../visuals/img/book_cover.jpg">
                                <h3><?php echo $row['genre_name']; ?></h3>
                            </div>
                            <div class="description">
                                <h2><?php echo $row['book_name']; ?></h2>
                                <h3><?php echo $row['author_name']; ?> <?php echo $row['author_surname']; ?></h3>
                                <p><?php echo $row['book_short_description']; ?></p>
                                <a href='backend_logic/rent_new_book.php?ID=<?php echo $row['book_id']; ?>'><button>rent</button></a>
                                <a href='book_info.php?ID=<?php echo $row['book_id']; ?>'><button>more INFO</button></a>
                            </div>
                        </div>

                <?php
                    endwhile;
                    $result->free();
                }
                ?>
            </div>
            <a href="books_all.php" class="more_books">See more books here >></a>
            <br><br>
            <br><br>
        </div>

    </div>

</body>


</html>