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

//define the number of results we want per page
$results_per_page = 10;

//find out the number of results stored in database
$sql = 'SELECT * FROM book_rented WHERE rent_person_FK = ' . $_SESSION["current_userID"];
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

$columns = array('book_id', 'book_name', 'genre_name', 'rent_date');

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
        <?php
        echo $_SESSION["current_username"];
        ?>
    </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="../visuals/user/user_nav.css">
    <link rel="stylesheet" href="../visuals/user/table.css">
    <link rel="stylesheet" href="../visuals/user/book_rent_history_style.css">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../visuals_js/hamburger_nav.js"></script>

    <link rel="stylesheet" href="../visuals/magnific-popup.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="../visuals_jq/jquery.magnific-popup.js"></script>
    <script src="../visuals_js/book_popup.js"></script>
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
                <li><a href="#" class="active">
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
            $upit = 'SELECT 
            person.person_name, person.person_surname, book.book_id, book.book_name, book_genre.genre_name, book_author.author_name, 
            book_author.author_surname, book_rented.rent_id, book_rented.rent_date,book_rented.rent_time
            FROM person, book, book_genre, book_author, book_rented WHERE 
            book.book_genre_FK = book_genre.genre_id AND book.book_author_FK = book_author.author_id AND
            book_rented.rent_book_FK = book.book_id AND 
            book_rented.rent_person_FK = ' . $_SESSION["current_userID"] . ' AND person.person_id = ' . $_SESSION["current_userID"] . '
            ORDER BY ' .  $column . ' ASC LIMIT ' . $offset . ',' . $results_per_page;

            if ($result = mysqli_query($conn, $upit)) {

                $up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
                $asc_or_desc = $sort_order == 'ASC' ? 'asc' : 'asc';

            ?>

                <div class="table books_table">
                    <table data-vertable="books_table">
                        <thead>
                            <tr class="row100 head">
                                <th class="column100"><a href="?column=book_id&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Id&nbsp;<i class="fas fa-sort<?php echo $column == 'book_id' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"><a href="?column=book_name&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Book name&nbsp;<i class="fas fa-sort<?php echo $column == 'book_name' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"><a href="?column=genre_name&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Book genre&nbsp;<i class="fas fa-sort<?php echo $column == 'genre_name' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"><a href="?column=rent_date&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Rent date & time&nbsp;<i class="fas fa-sort<?php echo $column == 'rent_date' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"></th>
                            </tr>
                        </thead>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tbody>
                                <tr class="row100">
                                    <td class="column100"><?php $column == 'book_id'; ?><?php echo $row['book_id']; ?></td>
                                    <td class="column100"><?php $column == 'book_name'; ?><?php echo $row['book_name']; ?></td>
                                    <td class="column100"><?php $column == 'genre_name'; ?><?php echo $row['genre_name']; ?> </td>
                                    <?php $newDateFormat = date("d.m.Y.", strtotime($row['rent_date'])); ?>
                                    <td class="column100"><?php $column == 'rent_date'; ?><?php echo $newDateFormat; ?><?php echo $row['rent_time']; ?></td>
                                    <td class="column100">
                                        <a class='open-popup-link' href='#<?php echo $row['book_id']; ?>'><button class='btn_table'>leave a review</button></a>
                                        <a class='open-popup-link' href='#<?php echo $row['book_id']; ?>del'><button class='btn_table'>remove</button></a>
                                    </td>
                                </tr>
                            </tbody>

                            <!-- // leave a review -->
                            <div id='<?php echo $row['book_id']; ?>' class='card mfp-hide'>
                                <form action='backend_logic/add_review.php?COLUMN=<?php echo $column ?>&PAGE=<?php echo $page_number ?>' method='POST' class='forma'>
                                    <nav>
                                        <h2><?php echo $row['book_name']; ?></h2>
                                    </nav>
                                    <div class='leaveReview'>
                                        <div class='input_review'>
                                            Rating: <input class='inputnumb' type='number' id='Rating' name='Rating' placeholder='0 - 100' maxlength='3' min='0' max='100' style='margin-bottom: 20px;'>
                                            <input type='hidden' value='<?php echo $row['book_id']; ?>' name='BookID' id='BookID'>
                                        </div>
                                        <div class='ta_review'>
                                            <textarea class='char-textarea' id='Review' maxlength='80' name='Review' rows='10' placeholder='Your review goes here ...'></textarea>
                                            <div id='the-count'>
                                                <span class='char-count' id='current'>0</span>
                                                <span id='maximum'>/ 80</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='button_submit'>
                                        <button type='submit' name='btn_add_review' id='btn_add_review' class='but_anim'>Post review</button>
                                    </div>
                                </form>
                            </div>

                            <!-- // delete -->
                            <div id='<?php echo $row['book_id']; ?>del' class='card mfp-hide'>
                                <form action='backend_logic/remove_rent.php?ID=<?php echo $row['rent_id']; ?>&COLUMN=<?php echo $column ?>&PAGE=<?php echo $page_number ?>' method='POST' class='forma'>
                                    <nav>
                                        <h2><?php echo $row['book_name']; ?> - <?php echo $row['rent_id']; ?></h2>
                                    </nav>
                                    <div class='leaveReview'>
                                        <p style='text-align:center'>You rented the book <strong><?php echo $row['book_name']; ?></strong> on <strong><?php echo $newDateFormat ?></strong>
                                            <br><br>Are you sure you want to remove it from your rent history?</p>
                                    </div>
                                    <div class='button_submit'>
                                        <button type='submit' name='bnt_remove_from_rent' id='bnt_remove_from_rent' class='but_anim'>remove from history</button>
                                    </div>
                                </form>
                            </div>

                        <?php endwhile; ?>
                    </table>
                </div>

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

    </div>

</body>


</html>