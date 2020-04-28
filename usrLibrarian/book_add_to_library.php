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


$sql_book_id = "SELECT book_id FROM book ORDER BY book_id DESC LIMIT 1";
$result_book_id = mysqli_query($conn, $sql_book_id);
$row_book_id = $result_book_id->fetch_assoc();
$BOOK_ID = $row_book_id['book_id'];

$sql_book_name = "SELECT book_name FROM book WHERE book_id = $BOOK_ID";
$result_book_name = mysqli_query($conn, $sql_book_name);
$row_book_name = $result_book_name->fetch_assoc();
$BOOK_NAME = $row_book_name['book_name'];

//////////////////////////////////////////////
//////////////////////////////////////////////
//////////////////////////////////////////////

//define the number of results we want per page
$results_per_page = 10;

//find out the number of results stored in database
$sql = "SELECT * FROM library_data";
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

$columns = array('library_id', 'library_name', 'library_country');

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
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" href="../visuals/librarian/librarian_nav.css">
    <link rel="stylesheet" href="../visuals/librarian/table.css">
    <link rel="stylesheet" href="../visuals/librarian/add_new_book_style.css">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../visuals_js/hamburger_nav.js"></script>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

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

                    echo "<p class='welcomeUser' style='float:left'>Book info: " . $BOOK_NAME . ", " . $BOOK_ID . "&nbsp;&nbsp;</p>";

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

            $upit = 'SELECT library_data.library_id, library_data.library_name, library_data.library_country, library_data.library_city
            FROM library_data ORDER BY ' .  $column . ' ASC LIMIT ' . $offset . ',' . $results_per_page;

            if ($result = mysqli_query($conn, $upit)) {

                $up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
                // $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                //samo asc order
                $asc_or_desc = $sort_order == 'ASC' ? 'asc' : 'asc';


            ?>

                <div class="table books_table">
                    <table data-vertable="books_table">
                        <thead>
                            <tr class="row100 head">
                                <th class="column100"><a href="?ID=<?php echo $BOOK_ID ?>&column=library_id&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Id <i class="fas fa-sort<?php echo $column == 'library_id' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"><a href="?ID=<?php echo $BOOK_ID ?>&column=library_name&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Library name <i class="fas fa-sort<?php echo $column == 'library_name' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"><a href="?ID=<?php echo $BOOK_ID ?>&column=library_country&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Library country <i class="fas fa-sort<?php echo $column == 'library_country' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"></th>
                            </tr>
                        </thead>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tbody>
                                <tr class="row100">
                                    <td class="column100"><?php $column == 'library_id'; ?><?php echo $row['library_id']; ?></td>
                                    <td class="column100"><?php $column == 'library_name'; ?><?php echo $row['library_name']; ?></td>
                                    <td class="column100"><?php $column == 'library_country'; ?><?php echo $row['library_country']; ?> </td>
                                    <td class="column100">
                                        <a href='backend_logic/add_book_to_library.php?ID=<?php echo $row['library_id']; ?>
                    &BOOK=<?php echo $BOOK_ID ?>&COLUMN=<?php echo $column ?>&PAGE=<?php echo $page_number ?>'>
                                            <button class="btn_table">Add to library</button></a>
                                    </td>
                                </tr>
                            </tbody>
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
                            echo "href='?ID=$BOOK_ID&column=$column&page=$previous_page'";
                        } ?>>Previous</a>
                </li>

                <?php
                //10 predstavlja broj stranice koje zelimo da prikazmeo preko dugmadi
                if ($total_number_of_pages <= 10) {
                    for ($counter = 1; $counter <= $total_number_of_pages; $counter++) {
                        if ($counter == $page_number) {
                            echo "<li class='active li-pagination'><a>$counter</a></li>";
                        } else {
                            echo "<li class='li-pagination'><a href='?ID=$BOOK_ID&column=$column&page=$counter'>$counter</a></li>";
                        }
                    }
                } elseif ($total_number_of_pages > 10) {

                    if ($page_number <= 4) {
                        for ($counter = 1; $counter < 8; $counter++) {
                            if ($counter == $page_number) {
                                echo "<li class='active li-pagination'><a>$counter</a></li>";
                            } else {
                                echo "<li class='li-pagination'><a href='?ID=$BOOK_ID&column=$column&page=$counter'>$counter</a></li>";
                            }
                        }
                        echo "<li class='li-pagination'><a>...</a></li>";
                        echo "<li class='li-pagination'><a href='?ID=$BOOK_ID&column=$column&page=$second_last'>$second_last</a></li>";
                        echo "<li class='li-pagination'><a href='?ID=$BOOK_ID&column=$column&page=$total_number_of_pages'>$total_number_of_pages</a></li>";
                    } elseif ($page_number > 4 && $page_number < $total_number_of_pages - 4) {
                        echo "<li class='li-pagination'><a href='?ID=$BOOK_ID&column=$column&page=1'>1</a></li>";
                        echo "<li class='li-pagination'><a href='?ID=$BOOK_ID&column=$column&page=2'>2</a></li>";
                        echo "<li class='li-pagination'><a>...</a></li>";
                        for ($counter = $page_number - $adjacents; $counter <= $page_number + $adjacents; $counter++) {
                            if ($counter == $page_number) {
                                echo "<li class='active li-pagination'><a>$counter</a></li>";
                            } else {
                                echo "<li class='li-pagination'><a href='?ID=$BOOK_ID&column=$column&page=$counter'>$counter</a></li>";
                            }
                        }
                        echo "<li class='li-pagination'><a>...</a></li>";
                        echo "<li class='li-pagination'><a href='?ID=$BOOK_ID&column=$column&page=$second_last'>$second_last</a></li>";
                        echo "<li class='li-pagination'><a href='?ID=$BOOK_ID&column=$column&page=$total_number_of_pages'>$total_number_of_pages</a></li>";
                    } else {
                        echo "<li class='li-pagination'><a href='?ID=$BOOK_ID&column=$column&page=1'>1</a></li>";
                        echo "<li class='li-pagination'><a href='?ID=$BOOK_ID&column=$column&page=2'>2</a></li>";
                        echo "<li class='li-pagination'><a>...</a></li>";

                        for ($counter = $total_number_of_pages - 6; $counter <= $total_number_of_pages; $counter++) {
                            if ($counter == $page_number) {
                                echo "<li class='active li-pagination'><a>$counter</a></li>";
                            } else {
                                echo "<li class='li-pagination'><a href='?ID=$BOOK_ID&column=$column&page=$counter'>$counter</a></li>";
                            }
                        }
                    }
                }
                ?>

                <li class="li-pagination" <?php if ($page_number >= $total_number_of_pages) {
                                                echo "class='disabled'";
                                            } ?>>
                    <a <?php if ($page_number < $total_number_of_pages) {
                            echo "href='?ID=$BOOK_ID&column=$column&page=$next_page'";
                        } ?>>Next</a>
                </li>
                <?php if ($page_number < $total_number_of_pages) {
                    echo "<li class='li-pagination'><a href='?ID=$BOOK_ID&column=$column&page=$total_number_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                } ?>
            </ul>
            <!-- PAGINATION//////////////////////////////////////////////////////////////////////// -->

            <div style='padding: 10px 20px 20px 10px;'>
                <strong>Total number of results <?php echo $number_of_results ?></strong><br>
                <strong>Number of results per page <?php echo $results_per_page ?></strong><br>
                <strong>Page <?php echo $page_number . " of " . $total_number_of_pages; ?></strong>
            </div>



            <p><strong><?php echo $BOOK_NAME; ?></strong> is available in the selected libraries:</p>

            <?php
            $upit = "SELECT 
            book.book_id, book.book_name, library_data.library_id, library_data.library_name, library_data.library_country
            FROM book, library_data, book_located
            WHERE book.book_id = book_located.book_located_book_FK AND library_data.library_id = book_located.book_located_library_FK
            AND book.book_id = $BOOK_ID
            GROUP BY library_data.library_name
            ORDER BY library_data.library_id ASC";
            $result = mysqli_query($conn, $upit);
            echo "<ul class='ul-where'>";
            while ($row = mysqli_fetch_object($result)) {
                echo "<li class='li-where'><a href='library_info.php?ID={$row->library_id}' style='color:black;font-weight:600'><i class='fas fa-angle-double-right'></i>&nbsp;&nbsp;{$row->library_name}, {$row->library_country}</a></li>";
            }
            echo "</ul>";
            ?>

        </div>

    </div>

</body>


</html>