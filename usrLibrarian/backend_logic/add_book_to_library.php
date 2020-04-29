<?php

session_start();

include "../../backend_logic/logic.connection.php";

if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

$LIBRARY_ID = (int) $_REQUEST['ID'];
$BOOK_ID = (int) $_REQUEST['BOOK'];
$COLUMN = $_REQUEST['COLUMN'];
$PAGE = $_REQUEST['PAGE'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$sql = "INSERT INTO book_located (`book_located_id`, `book_located_book_FK`, `book_located_library_FK`) 
VALUES (NULL, '$BOOK_ID', '$LIBRARY_ID');";

mysqli_query($conn, $sql);

header("Location: ../book_add_to_library.php?ID={$BOOK_ID}&column={$COLUMN}&page={$PAGE}");
