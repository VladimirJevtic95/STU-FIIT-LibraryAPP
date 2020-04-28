<?php

session_start();

include "../../backend_logic/logic.connection.php";

// Check user logged or not
if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

$BOOK_ID = (int) $_REQUEST['ID'];
$COLUMN = $_REQUEST['COLUMN'];
$PAGE = $_REQUEST['PAGE'];

$BookDate = $_POST['BookDate'];
$BookAuthor = (int) $_POST['BookAuthor'];
$BookGenre = (int) $_POST['BookGenre'];
$BookDescription = $_POST['BookDescription'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$sql = "UPDATE book SET book_short_description = '$BookDescription', book_publication_date = '$BookDate', book_author_FK = '$BookAuthor', book_genre_FK = '$BookGenre' 
WHERE book_id = $BOOK_ID";

if (isset($_POST['btn_update'])) {
    mysqli_query($conn, $sql);
    header("Location:../books.php?column={$COLUMN}&page={$PAGE}&SUCCESS");
} else {
    header("Location: ../books.php?column={$COLUMN}&page={$PAGE}&ERROR");
}
