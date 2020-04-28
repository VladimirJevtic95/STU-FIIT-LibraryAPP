<?php

session_start();

include "../../backend_logic/logic.connection.php";

// Check user logged or not
if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

$REVIEW_ID = (int) $_REQUEST['ID'];

$COLUMN = $_REQUEST['COLUMN'];
$PAGE = $_REQUEST['PAGE'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$sql = "DELETE FROM book_review WHERE review_id = $REVIEW_ID";

mysqli_query($conn, $sql);

header("Location: ../book_review_history.php?column={$COLUMN}&page={$PAGE}&ReviewRemoved");
