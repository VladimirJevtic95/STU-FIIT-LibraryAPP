<?php

session_start();

include "../../backend_logic/logic.connection.php";

// Check user logged or not
if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

$BOOK_ID = (int) $_REQUEST['ID'];
$RENTER_ID = $_SESSION["current_userID"];
$DATE = date("Y-m-d");
$TIME = date("H:i:s");


$COLUMN = $_REQUEST['COLUMN'];
$PAGE = $_REQUEST['PAGE'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// $upit = "delete from post where postid_pk=$ID";
$sql = "INSERT INTO book_rented (`rent_id`, `rent_person_FK`, `rent_book_FK`, `rent_date`, `rent_time`) VALUES (NULL, '$RENTER_ID', '$BOOK_ID', '$DATE', '$TIME');";

mysqli_query($conn, $sql);

header("Location: ../books_all.php?column={$COLUMN}&page={$PAGE}&BOOK_SUCCESSFULY_RENTED");
