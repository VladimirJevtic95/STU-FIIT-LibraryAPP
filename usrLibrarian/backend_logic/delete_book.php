<?php

session_start();

include "../../backend_logic/logic.connection.php";

if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

$BOOK_ID = (int) $_REQUEST['ID'];
$COLUMN = $_REQUEST['COLUMN'];
$PAGE = $_REQUEST['PAGE'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$sql = "DELETE FROM book WHERE book_id = $BOOK_ID";

mysqli_query($conn, $sql);

header("Location: ../books.php?column={$COLUMN}&page={$PAGE}");