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

$RENTER_ID = (int) $_REQUEST['ID'];
//find out the number of results stored in database
$sql = "SELECT person.person_username FROM person WHERE person.person_id = $RENTER_ID";
$result = mysqli_query($conn, $sql);
$RENTER_USERNAME = mysqli_fetch_object($result);
$RENTER_USERNAME = $RENTER_USERNAME->person_username;

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
    <link rel="stylesheet" href="../visuals/librarian/book_info_style.css">
    <link rel="stylesheet" href="../visuals/librarian/table.css">

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
                    echo "<p class='welcomeUser'>Info for user : " . $RENTER_USERNAME . "</p>";
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
            person.person_name, person.person_surname, book.book_name, book_author.author_name, book_author.author_surname, 
            book_review.review_text, book_review.review_rating, book_review.review_date, book_review.review_time, book_review.review_id
            FROM person, book, book_review, book_author WHERE 
            book_review.review_book_id_FK = book.book_id AND book_review.review_person_id_FK = $RENTER_ID AND
            book.book_author_FK = book_author.author_id AND person.person_id = $RENTER_ID
            ORDER BY book_review.review_date ASC, book_review.review_time ASC;";
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
                echo "<p>{$row->author_name} {$row->author_surname} -  {$row->book_name}</p>";
                echo "</div>";
                echo "<div class='card-bottom'>";
                echo "<div class='options'>";
                $newDateFormat = date("d.m.Y.", strtotime($row->review_date));
                echo "<span class='date'><i class='fa fa-calendar' aria-hidden='true'></i>&nbsp;&nbsp;Review posted on {$newDateFormat} at {$row->review_time}</span>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</section>";
            }
            ?>

            <br />

            <div class="table books_table">
                <table data-vertable="books_table">
                    <thead>
                        <tr class="row100 head">
                            <th class="column100">Name and surname</th>
                            <th class="column100">Book name</th>
                            <th class="column100">Author name</th>
                            <th class="column100">Book genre</th>
                            <th class="column100">Date and time of renting</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $upit = "SELECT 
            person.person_name, person.person_surname, book.book_name, book_genre.genre_name, book_author.author_name, book_author.author_surname, 
            book_rented.rent_date,book_rented.rent_time
            FROM person, book, book_genre, book_author, book_rented WHERE 
            book.book_genre_FK = book_genre.genre_id AND book.book_author_FK = book_author.author_id AND
            book_rented.rent_book_FK = book.book_id AND 
            book_rented.rent_person_FK = $RENTER_ID AND person.person_id = $RENTER_ID
            ORDER BY book_rented.rent_date ASC;";
                        $result = mysqli_query($conn, $upit);

                        while ($row = mysqli_fetch_object($result)) {
                            echo "<tr class='row100'>";
                            echo "<td class='column100'>{$row->person_name} {$row->person_surname}</td>";
                            echo "<td class='column100'>{$row->book_name}</td>";
                            echo "<td class='column100'>{$row->author_name} {$row->author_surname}</td>";
                            echo "<td class='column100'>{$row->genre_name}</td>";
                            $newDateFormat = date("d.m.Y.", strtotime($row->rent_date));
                            echo "<td class='column100'>{$newDateFormat} / {$row->rent_time}</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <br>


        </div>
    </div>
</body>

</html>