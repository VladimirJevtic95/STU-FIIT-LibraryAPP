<?php

session_start();

include "../backend_logic/logic.connection.php";

// Check user logged or not
if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

//ovo radi treba da se svuda stavi
if (($_SESSION["current_role"]) != 3) {
    session_unset();
    session_destroy();
    header('Location: ../person/person_login.php?');
}

// ---------------------------------------------------------------------------------------------------------------------
// http://localhost/stu_fiit_database_systems/usrRenter/index.php
// ---------------------------------------------------------------------------------------------------------------------

//define the number of results we want per page
$results_per_page = 12;

//find out the number of results stored in database
$sql = "SELECT person_id FROM person WHERE person_role_FK = 1";
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

$columns = array('person_id', 'person_name', 'person_username', 'person_age', 'role_name');

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
                    echo "<p class='welcomeUser'>" . $_SESSION["current_username"] . " -> all users</p>";
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
                <li><a href="#" class="active">
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

            <?php
            // Get the result...

            $upit = 'SELECT 
    person.person_id, person.person_name, person.person_surname, person.person_username, person.person_age, roles.role_name
    FROM person, roles WHERE person.person_role_FK = roles.role_id AND person.person_role_FK = 1
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
                                <th class="column100"><a href="?column=person_id&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Id&nbsp;<i class="fas fa-sort<?php echo $column == 'person_id' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"><a href="?column=person_name&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Name and surname&nbsp;<i class="fas fa-sort<?php echo $column == 'person_name' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"><a href="?column=person_username&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Username&nbsp;<i class="fas fa-sort<?php echo $column == 'person_username' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"><a href="?column=person_age&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Age&nbsp;<i class="fas fa-sort<?php echo $column == 'person_age' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"><a href="?column=role_name&order=<?php echo $asc_or_desc; ?>&page=<?php echo $page_number; ?>">Role&nbsp;<i class="fas fa-sort<?php echo $column == 'role_name' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="column100"></th>
                            </tr>
                        </thead>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tbody>
                                <tr class="row100">
                                    <td class="column100"><?php $column == 'person_id'; ?><?php echo $row['person_id']; ?></td>
                                    <td class="column100"><?php $column == 'person_name'; ?><?php echo $row['person_name']; ?> <?php echo $row['person_surname']; ?></td>
                                    <td class="column100"><?php $column == 'person_username'; ?><?php echo $row['person_username']; ?></td>
                                    <td class="column100"><?php $column == 'person_age'; ?><?php echo $row['person_age']; ?> </td>
                                    <td class="column100"><?php $column == 'role_name'; ?><?php echo $row['role_name']; ?></td>
                                    <td class="column100">
                                        <a href='backend_logic/delete_user.php?ID=<?php echo $row['person_id']; ?>&PAGE=<?php echo $page_number ?>
                        &COLUMN=<?php echo $column ?>&ORDER=<?php echo $asc_or_desc ?>'><button class="btn_table">DELETE USER</button></a>
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