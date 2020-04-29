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

//define the number of results we want per page
$results_per_page = 12;

//find out the number of results stored in database
$sql = "SELECT library_id FROM library_data";
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

$columns = array('library_id', 'library_name', 'library_country', 'library_city', 'library_adress', 'library_size_FK', 'library_type_FK');

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
    <link rel="stylesheet" href="../visuals/librarian/edit_book_style.css">

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
                    echo "<p class='welcomeUser'>" . $_SESSION["current_username"] . " -> all libraries</p>";
                    ?>
                </div>
                <ul>
                    <li>
                        <a href="new_library.php">
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
                <li><a href="#" class="active">
                        <span class="icon"><i class="fas fa-landmark"></i></span>
                        <span class="title">Libraries</span>
                    </a></li>
            </ul>
        </div>

        <div class="main_container">

            <?php
            $upit = 'SELECT 
           library_data.library_id, library_data.library_name, library_data.library_country, library_data.library_city, library_data.library_type_FK, library_data.library_size_FK,
           library_data.library_adress, library_data.library_email, library_data.library_website, library_data.library_phone, library_size.library_size_name, 
           library_size.library_size_id, library_type.library_type_name, library_type.library_type_id
           FROM library_data, library_size, library_type WHERE 
           library_data.library_size_FK = library_size.library_size_id AND library_data.library_type_FK = library_type.library_type_id
        ORDER BY ' .  $column . ' ASC LIMIT ' . $offset . ',' . $results_per_page;

            if ($result = mysqli_query($conn, $upit)) {

                // Some variables we need for the table.
                $up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
                // $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                $asc_or_desc = $sort_order == 'ASC' ? 'asc' : 'asc';
            ?>
                <div class="table books_table">
                    <table data-vertable="books_table">
                        <thead>
                            <tr class="row100 head">
                                <th class="column100"><a href="?column=library_id&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Id&nbsp;<i class="fas fa-sort<?php echo $column == 'library_id' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"><a href="?column=library_name&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">name&nbsp;<i class="fas fa-sort<?php echo $column == 'library_name' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"><a href="?column=library_country&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">country&nbsp;<i class="fas fa-sort<?php echo $column == 'library_country' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"><a href="?column=library_city&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">city&nbsp;<i class="fas fa-sort<?php echo $column == 'library_city' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"><a href="?column=library_adress&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Address&nbsp;<i class="fas fa-sort<?php echo $column == 'library_adress' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"><a href="?column=library_size_FK&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">size&nbsp;<i class="fas fa-sort<?php echo $column == 'library_size_FK' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"><a href="?column=library_type_FK&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">type&nbsp;<i class="fas fa-sort<?php echo $column == 'library_type_FK' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"></th>
                            </tr>
                        </thead>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tbody>
                                <tr class="row100">
                                    <td class="column100"><?php $column == 'library_id'; ?><?php echo $row['library_id']; ?></td>
                                    <td class="column100"><?php $column == 'library_name'; ?><?php echo $row['library_name']; ?></td>
                                    <td class="column100"><?php $column == 'library_country'; ?><?php echo $row['library_country']; ?></td>
                                    <td class="column100"><?php $column == 'library_city'; ?><?php echo $row['library_city']; ?></td>
                                    <td class="column100"><?php $column == 'library_adress'; ?><?php echo $row['library_adress']; ?></td>
                                    <td class="column100"><?php $column == 'library_size_FK'; ?><?php echo $row['library_size_name']; ?></td>
                                    <td class="column100"><?php $column == 'library_type_FK'; ?><?php echo $row['library_type_name']; ?></td>

                                    <td class="column100">
                                        <a href='backend_logic/delete_library.php?ID=<?php echo $row['library_id']; ?>&PAGE=<?php echo $page_number ?>
                        &COLUMN=<?php echo $column ?>&ORDER=<?php echo $asc_or_desc ?>'><button class="btn_table">DELETE</button></a>
                                        <a class='open-popup-link' href='#<?php echo $row['library_id']; ?>'><button class="btn_table">edit</button></a>
                                        <a href='library_info.php?ID=<?php echo $row['library_id']; ?>'><button class="btn_table">info</button></a>
                                    </td>
                                </tr>
                            </tbody>

                            <div id='<?php echo $row['library_id']; ?>' class='card mfp-hide'>
                                <form action='backend_logic/update_library.php?LIBID=<?php echo $row['library_id']; ?>&COLUMN=<?php echo $column ?>&PAGE=<?php echo $page_number ?>' method='POST' class='forma'>
                                    <nav>
                                        <h2><?php echo $row['library_name']; ?></h2>
                                    </nav>
                                    <div class='edit-book'>
                                        <div class='top-part'>
                                            <div class='input_edit'>
                                                Country: &nbsp;<input class='editfield' type='text' name='LibraryCountry' value='<?php echo $row['library_country']; ?>'>
                                            </div>
                                            <div class='input_edit'>
                                                City: &nbsp;<input class='editfield' type='text' name='LibraryCity' value='<?php echo $row['library_city']; ?>'>
                                            </div>
                                            <div class='input_edit'>
                                                Address: &nbsp;<input class='editfield' type='text' name='LibraryAddress' value='<?php echo $row['library_adress']; ?>'>
                                            </div>
                                        </div>
                                        <div class='bottom-part'>
                                            <div class='input_edit'>
                                                Type: &nbsp;<select class='editfield' name="LibraryType" class="dropdown-select">
                                                    <?php
                                                    $sqlType = "SELECT library_type_id , library_type_name FROM library_type ORDER BY library_type_name";
                                                    $resultType = mysqli_query($conn, $sqlType);
                                                    while ($rowType = mysqli_fetch_array($resultType)) {
                                                        echo "<option value='" . $rowType['library_type_id'] . "'>" . $rowType['library_type_name'] . "</option>";
                                                    }
                                                    ?>
                                                    <option value='<?php echo $row['library_type_id']; ?>' selected><?php echo $row['library_type_name']; ?></option>";
                                                </select>
                                            </div>
                                            <div class='input_edit'>
                                                Size: &nbsp;<select class='editfield' name="LibrarySize" class="dropdown-select">
                                                    <?php
                                                    $sqlSize = "SELECT library_size_id , library_size_name FROM library_size ORDER BY library_size_name";
                                                    $resultSize = mysqli_query($conn, $sqlSize);
                                                    while ($rowSize = mysqli_fetch_array($resultSize)) {
                                                        echo "<option value='" . $rowSize['library_size_id'] . "'>" . $rowSize['library_size_name']  . "</option>";
                                                    }
                                                    ?>
                                                    <option value='<?php echo $row['library_size_id']; ?>' selected><?php echo $row['library_size_name']; ?> </option>";
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='button_submit'>
                                        <button type='submit' name='btn_update' id='btn_update' class='but_anim'>Make an update</button>
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