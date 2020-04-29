<?php

session_start();

include "../../backend_logic/logic.connection.php";

if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

$RENT_ID = (int) $_REQUEST['ID'];

$COLUMN = $_REQUEST['COLUMN'];
$PAGE = $_REQUEST['PAGE'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


$sql = "DELETE FROM book_rented WHERE rent_id = $RENT_ID";

if (isset($_POST['bnt_remove_from_rent'])) {
    mysqli_query($conn, $sql);
    header("Location: ../book_rent_history.php?column={$COLUMN}&page={$PAGE}&BookRemoved");
} else {
    header("Location: ../book_rent_history.php?column={$COLUMN}&page={$PAGE}&BookNOTRemoved");
}
