<?php

session_start();

include "../../backend_logic/logic.connection.php";

if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

$USER_ID = (int) $_REQUEST['ID'];
$PAGE_NUMBER = (int) $_REQUEST['PAGE'];
$COLUMN_NAME = $_REQUEST['COLUMN'];
$COLUMN_ORDER = $_REQUEST['ORDER'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$sql = "DELETE FROM person WHERE person_id = $USER_ID";

mysqli_query($conn, $sql);

header('Location: ../index.php?column=' . $COLUMN_NAME . '&order=' . $COLUMN_ORDER . '&page=' . $PAGE_NUMBER);
