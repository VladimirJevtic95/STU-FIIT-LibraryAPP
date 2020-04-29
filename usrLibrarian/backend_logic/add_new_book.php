<?php

session_start();

include "../../backend_logic/logic.connection.php";

if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

$BookName = $_POST['BookName'];
$BookDescription = $_POST['BookDescription'];
$BookPublication = $_POST['BookPublication'];
$BookGenre = $_POST['BookGenre'];
$BookAuthor = $_POST['BookAuthor'];


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($BookName != "") {
    $sql = "INSERT INTO book (`book_id`, `book_name`,`book_short_description`, `book_publication_date`, `book_genre_FK`, `book_author_FK`)
     VALUES (NULL, '$BookName', '$BookDescription', '$BookPublication', '$BookGenre', '$BookAuthor');";
    if (isset($_POST['btn_add_new_book'])) {
        mysqli_query($conn, $sql);
        header('Location: ../book_add_to_library.php');
    }
} else {
    header('Location: ../book_add.php?ProblemAddingNewBook');
}
