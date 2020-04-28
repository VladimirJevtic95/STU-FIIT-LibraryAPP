<?php

session_start();

include "../../backend_logic/logic.connection.php";

// Check user logged or not
if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

$AuthorName = $_POST['AuthorName'];
$AuthorSurname = $_POST['AuthorSurname'];
$DateOfBirth = $_POST['DateOfBirth'];


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($AuthorName != "" && $AuthorSurname != "" && $DateOfBirth != "") {
    $sql = "INSERT INTO book_author (`author_id`, `author_name`, `author_surname`, `author_date_of_birth`)
     VALUES (NULL, '$AuthorName', '$AuthorSurname', '$DateOfBirth');";
    if (isset($_POST['btn_add_new_author'])) {
        mysqli_query($conn, $sql);
        header('Location: ../author_add.php?NewAuthorSuccessfulyAdded');
    }
} else {
    header('Location: ../author_add.php?ProblemAddingNewAuthor');
}
