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


$BOOK_ID = (int) $_REQUEST['ID'];
$USER_ID = (int) $_SESSION["current_userID"];

$sql_book_name = "SELECT book_name FROM book WHERE book_id = $BOOK_ID";
$result_book_name = mysqli_query($conn, $sql_book_name);
$row_book_name = $result_book_name->fetch_assoc();
$book_name = $row_book_name['book_name'];

?>

<html>

<head>
    <title>
        <?php
        echo $_SESSION["current_username"];
        ?>
    </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" href="../visuals/librarian/librarian_nav.css">
    <link rel="stylesheet" href="../visuals/librarian/table.css">
    <link rel="stylesheet" href="../visuals/librarian/stars.css">
    <link rel="stylesheet" href="../visuals/librarian/book_info_style.css">

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
                    $sql = "SELECT AVG(review_rating) AS review_rating FROM book_review WHERE review_book_id_FK = $BOOK_ID";
                    $result = mysqli_query($conn, $sql);
                    $row = $result->fetch_assoc();
                    $rating_value = (int) $row['review_rating'];

                    echo "<p class='welcomeUser' style='float:left'>Book info: " . $book_name . "&nbsp;&nbsp;</p>";
                    echo "<div class='star-rating' style='float:right'>";
                    echo "<div class='back-stars'>";
                    echo "<i class='far fa-star star' aria-hidden='true'></i>";
                    echo "<i class='far fa-star star' aria-hidden='true'></i>";
                    echo "<i class='far fa-star star' aria-hidden='true'></i>";
                    echo "<i class='far fa-star star' aria-hidden='true'></i>";
                    echo "<i class='far fa-star star' aria-hidden='true'></i>";
                    echo "<div class='front-stars' style='width:{$rating_value}%'>";
                    echo "<i class='fa fa-star star' aria-hidden='true'></i>";
                    echo "<i class='fa fa-star star' aria-hidden='true'></i>";
                    echo "<i class='fa fa-star star' aria-hidden='true'></i>";
                    echo "<i class='fa fa-star star' aria-hidden='true'></i>";
                    echo "<i class='fa fa-star star' aria-hidden='true'></i>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
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
                <li><a href="author_add.php">
                        <span class="icon"><i class="fas fa-user-plus"></i></span>
                        <span class="title">New author</span>
                    </a></li>
            </ul>
        </div>

        <div class="main_container">

            <?php
            $upit = "SELECT 
            book.book_id, book.book_name, book.book_publication_date, book_author.author_name, book_author.author_surname, person.person_name, person.person_surname, 
            book_review.review_text, book_review.review_rating, book_review.review_date, book_review.review_time, book_genre.genre_name
            FROM book, book_author, person, book_review, book_genre 
            WHERE book.book_id = $BOOK_ID AND book_review.review_book_id_FK = $BOOK_ID 
            AND book_author.author_id = book.book_author_FK AND book_review.review_person_id_FK = person.person_id 
            AND book.book_genre_FK = book_genre.genre_id";
            $result = mysqli_query($conn, $upit);

            while ($row = mysqli_fetch_object($result)) {
                echo "<section class='card_review row'>";
                echo "<div class='card'>";
                echo "<div class='card-content'>";
                echo "<div class='card-top'>";
                echo "<h4 class='card-title'>{$row->person_name} {$row->person_surname}</h4>";
                echo "<p class='card-rating-percent'><i class='fas fa-star-half' aria-hidden='true'></i>Rating: {$row->review_rating}%</p>";
                echo "<p class='card-review'>{$row->review_text}</p>";
                echo "</div>";
                echo "<div class='card-book-info'>";
                $pubDate = date("d.m.Y.", strtotime($row->book_publication_date));
                echo "<p>{$row->author_name} {$row->author_surname} -  {$row->book_name} ({$row->genre_name}), published on {$pubDate}</p>";
                echo "</div>";
                echo "<div class='card-bottom'>";
                echo "<div class='options'>";
                $newDateFormat = date("d.m.Y.", strtotime($row->review_date));
                echo "<span class='date'><i class='fa fa-calendar' aria-hidden='true'></i>&nbsp;&nbsp;Review posted on {$newDateFormat} at {$row->review_time}</span>";
                echo "</div>";
                echo "<div class='card-rating'>";
                echo "<div class='star-rating'>";
                echo "<div class='back-stars'>";
                echo "<i class='far fa-star star' aria-hidden='true'></i>";
                echo "<i class='far fa-star star' aria-hidden='true'></i>";
                echo "<i class='far fa-star star' aria-hidden='true'></i>";
                echo "<i class='far fa-star star' aria-hidden='true'></i>";
                echo "<i class='far fa-star star' aria-hidden='true'></i>";
                echo "<div class='front-stars' style='width:{$row->review_rating}%'>";
                echo "<i class='fa fa-star star' aria-hidden='true'></i>";
                echo "<i class='fa fa-star star' aria-hidden='true'></i>";
                echo "<i class='fa fa-star star' aria-hidden='true'></i>";
                echo "<i class='fa fa-star star' aria-hidden='true'></i>";
                echo "<i class='fa fa-star star' aria-hidden='true'></i>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</section>";
            }
            ?>

            <br />
            <p><strong><?php echo $book_name; ?></strong> is available in the selected libraries:&nbsp;&nbsp;&nbsp;
                <a href="book_info_add_to_library.php?ID=<?php echo $BOOK_ID ?>" style="font-weight:700;color:black;text-decoration:underline">Add to more libraries ??</a></p>

            <?php
            $upit = "SELECT 
            book.book_id, book.book_name, library_data.library_id, library_data.library_name
            FROM book, library_data, book_located
            WHERE book.book_id = book_located.book_located_book_FK AND library_data.library_id = book_located.book_located_library_FK
            AND book.book_id = $BOOK_ID
            GROUP BY library_data.library_name
            ORDER BY library_data.library_name ASC";
            $result = mysqli_query($conn, $upit);
            echo "<ul class='ul-where'>";
            while ($row = mysqli_fetch_object($result)) {
                echo "<li class='li-where'><a href='library_info.php?ID={$row->library_id}'><i class='fas fa-angle-double-right'></i>&nbsp;&nbsp;{$row->library_name}</a></li>";
            }
            echo "</ul>";
            ?>


        </div>

    </div>

</body>


</html>