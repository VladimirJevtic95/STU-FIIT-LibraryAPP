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
// ---------------------------------------------------------------------------------------------------------------------
// http://localhost/stu_fiit_database_systems/usrRenter/index.php
// ---------------------------------------------------------------------------------------------------------------------

//define the number of results we want per page
$results_per_page = 20;

//find out the number of results stored in database
$sql = "SELECT * FROM book";
$result = mysqli_query($conn, $sql);
$number_of_results = mysqli_num_rows($result);

//determine number od total pages available
$total_number_of_pages = ceil($number_of_results / $results_per_page);

//determine witch page number visitor is currently on
if (!isset($_GET['page'])) {
    $page_number = 1;
} else {
    $page_number = $_GET['page'];
}

//determine the sql limit starting number for the results on the dispalying page
$offset = ($page_number - 1) * $results_per_page;
$previous_page = $page_number - 1;
$next_page = $page_number + 1;
$adjacents = "2";
$second_last = $total_number_of_pages - 1; // total pages minus 1


// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// sorting

$columns = array('book_name', 'book_publication_date', 'author_name', 'genre_name');

// Only get the column if it exists in the above columns array, if it doesn't exist the database table will be sorted by the first item in the columns array.
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];

// Get the sort order for the column, ascending or descending, default is ascending.
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

//     // ---------------------------------------------------------------------------------------------------------------------
//     // ---------------------------------------------------------------------------------------------------------------------

?>

<html>

<head>
    <title>
        Home - <?php echo $_SESSION["current_username"]; ?>
    </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" href="../visuals/user/user_nav.css">
    <link rel="stylesheet" href="../visuals/user/table.css">
    <link rel="stylesheet" href="../visuals/user/book_popup.css">
    <link rel="stylesheet" href="../visuals/user/all_books.css">
    <link rel="stylesheet" href="../visuals/magnific-popup.css">


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="../visuals_js/hamburger_nav.js"></script>
    <script src="../visuals_jq/jquery.magnific-popup.js"></script>
    <script src="../visuals_js/book_popup.js"></script>
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
                    ?> </div>
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
                <li><a href="#" class="active">
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
            // Get the result...

            $upit = 'SELECT 
    book.book_id, book.book_name, book.book_short_description, book.book_publication_date, book_genre.genre_name, book_author.author_name, book_author.author_surname
    FROM book, book_genre, book_author
    WHERE book.book_genre_FK = book_genre.genre_id AND book.book_author_FK = book_author.author_id 
    ORDER BY ' .  $column . ' ASC LIMIT ' . $offset . ',' . $results_per_page;

            if ($result = mysqli_query($conn, $upit)) {

                $up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
                // $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                //samo asc order
                $asc_or_desc = $sort_order == 'ASC' ? 'asc' : 'asc';


            ?>
                <ul class="lista-books">
                    <li class="lista-books-li"><a href="books_all.php?column=book_name&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Book name <i class="fas fa-sort<?php echo $column == 'book_name' ? '-' . $up_or_down : ''; ?>"></i></a></li>
                    <li class="lista-books-li"><a href="books_all.php?column=book_publication_date&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Publication date <i class="fas fa-sort<?php echo $column == 'book_publication_date' ? '-' . $up_or_down : ''; ?>"></i></a></li>
                    <li class="lista-books-li"><a href="books_all.php?column=genre_name&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Genre <i class="fas fa-sort<?php echo $column == 'genre_name' ? '-' . $up_or_down : ''; ?>"></i></a></li>
                    <li class="lista-books-li"><a href="books_all.php?column=author_name&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Author <i class="fas fa-sort<?php echo $column == 'author_name' ? '-' . $up_or_down : ''; ?>"></i></a></li>
                </ul>

                <?php while ($row = $result->fetch_assoc()) : ?>

                    <?php $newDateFormat = date("d.m.Y.", strtotime($row['book_publication_date'])); ?>

                    <article class="kartica kartica--1">
                        <div class="kartica_info">
                            <div class="extra-options">
                                <span class="kartica_category"><?php $column == 'genre_name'; ?><?php echo $row['genre_name']; ?></span>
                                <a href="#<?php echo $row['book_id']; ?>" class="open-popup-link">
                                    <span class="icon-option-1"><i class="fas fa-info-circle"></i></span>
                                </a>
                                <a href="backend_logic/rent_new_book.php?ID=<?php echo $row['book_id']; ?>&COLUMN=<?php echo $column ?>&PAGE=<?php echo $page_number ?>">
                                    <span class="icon-option-2"><i class="fas fa-arrow-circle-down"></i></span>
                                </a>
                            </div>
                            <h3 class="kartica_title"><?php $column == 'book_name'; ?><?php echo $row['book_name']; ?></h3>
                            <span class="kartica_by">by <a href="#" class="kartica_author" title="author">
                                    <?php $column == 'author_name'; ?><?php echo $row['author_name']; ?> <?php echo $row['author_surname']; ?></a>
                                on <?php $column == 'book_publication_date'; ?><?php echo $newDateFormat ?></span>
                        </div>
                    </article>

                    <!-- //////////////////////////////////////////////////////////////////////// -->
                    <!-- //////////////////////////////////////////////////////////////////////// -->
                    <!-- //////////////////////////////////////////////////////////////////////// -->
                    <?php
                    $BOOKID = $row['book_id'];
                    $sql1 = "SELECT AVG(review_rating) AS review_rating FROM book_review WHERE review_book_id_FK = $BOOKID";
                    $result1 = mysqli_query($conn, $sql1);
                    $row1 = $result1->fetch_assoc();
                    $rating_value = (int) $row1['review_rating'];

                    $sql2 = "SELECT COUNT(review_book_id_FK) AS total_num FROM book_review WHERE review_book_id_FK = $BOOKID";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = $result2->fetch_assoc();
                    $total_num = $row2['total_num']; ?>

                    <div id="<?php echo $row['book_id']; ?>" class="card mfp-hide">
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

                    <!-- //////////////////////////////////////////////////////////////////////// -->
                    <!-- //////////////////////////////////////////////////////////////////////// -->
                    <!-- //////////////////////////////////////////////////////////////////////// -->
                <?php endwhile; ?>

            <?php
                $result->free();
            }
            ?>

            <!-- PAGINATION//////////////////////////////////////////////////////////////////////// -->
            <ul class="ul-pagination">

                <li class="li-pagination" <?php if ($page_number <= 1) {
                                                echo "class='disabled'";
                                            } ?>>
                    <a <?php if ($page_number > 1) {
                            echo "href='?column=$column&page=$previous_page'";
                        } ?>>Previous</a>
                </li>

                <?php
                //10 predstavlja broj stranice koje zelimo da prikazmeo preko dugmadi
                if ($total_number_of_pages <= 10) {
                    for ($counter = 1; $counter <= $total_number_of_pages; $counter++) {
                        if ($counter == $page_number) {
                            echo "<li class='active li-pagination'><a>$counter</a></li>";
                        } else {
                            echo "<li class='li-pagination'><a href='?column=$column&page=$counter'>$counter</a></li>";
                        }
                    }
                } elseif ($total_number_of_pages > 10) {

                    if ($page_number <= 4) {
                        for ($counter = 1; $counter < 8; $counter++) {
                            if ($counter == $page_number) {
                                echo "<li class='active li-pagination'><a>$counter</a></li>";
                            } else {
                                echo "<li class='li-pagination'><a href='?column=$column&page=$counter'>$counter</a></li>";
                            }
                        }
                        echo "<li class='li-pagination'><a>...</a></li>";
                        echo "<li class='li-pagination'><a href='?column=$column&page=$second_last'>$second_last</a></li>";
                        echo "<li class='li-pagination'><a href='?column=$column&page=$total_number_of_pages'>$total_number_of_pages</a></li>";
                    } elseif ($page_number > 4 && $page_number < $total_number_of_pages - 4) {
                        echo "<li class='li-pagination'><a href='?column=$column&page=1'>1</a></li>";
                        echo "<li class='li-pagination'><a href='?column=$column&page=2'>2</a></li>";
                        echo "<li class='li-pagination'><a>...</a></li>";
                        for ($counter = $page_number - $adjacents; $counter <= $page_number + $adjacents; $counter++) {
                            if ($counter == $page_number) {
                                echo "<li class='active li-pagination'><a>$counter</a></li>";
                            } else {
                                echo "<li class='li-pagination'><a href='?column=$column&page=$counter'>$counter</a></li>";
                            }
                        }
                        echo "<li class='li-pagination'><a>...</a></li>";
                        echo "<li class='li-pagination'><a href='?column=$column&page=$second_last'>$second_last</a></li>";
                        echo "<li class='li-pagination'><a href='?column=$column&page=$total_number_of_pages'>$total_number_of_pages</a></li>";
                    } else {
                        echo "<li class='li-pagination'><a href='?column=$column&page=1'>1</a></li>";
                        echo "<li class='li-pagination'><a href='?column=$column&page=2'>2</a></li>";
                        echo "<li class='li-pagination'><a>...</a></li>";

                        for ($counter = $total_number_of_pages - 6; $counter <= $total_number_of_pages; $counter++) {
                            if ($counter == $page_number) {
                                echo "<li class='active li-pagination'><a>$counter</a></li>";
                            } else {
                                echo "<li class='li-pagination'><a href='?column=$column&page=$counter'>$counter</a></li>";
                            }
                        }
                    }
                }
                ?>

                <li class="li-pagination" <?php if ($page_number >= $total_number_of_pages) {
                                                echo "class='disabled'";
                                            } ?>>
                    <a <?php if ($page_number < $total_number_of_pages) {
                            echo "href='?column=$column&page=$next_page'";
                        } ?>>Next</a>
                </li>
                <?php if ($page_number < $total_number_of_pages) {
                    echo "<li class='li-pagination'><a href='?column=$column&page=$total_number_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                } ?>
            </ul>
            <!-- PAGINATION//////////////////////////////////////////////////////////////////////// -->

            <div style='padding: 10px 20px 0px;'>
                <strong>Total number of results <?php echo $number_of_results ?></strong><br>
                <strong>Number of results per page <?php echo $results_per_page ?></strong><br>
                <strong>Page <?php echo $page_number . " of " . $total_number_of_pages; ?></strong>
            </div>

        </div>

</body>

</html>