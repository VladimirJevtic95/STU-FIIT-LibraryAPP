<?php

session_start();

include "../../backend_logic/logic.connection.php";

// Check user logged or not
if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

$RENTER_ID = $_SESSION["current_userID"];
$DATE = date("Y-m-d");
$TIME = date("H:i:s");

$BOOK_ID = $_POST['BookID'];
$Review = $_POST['Review'];
$Rating = $_POST['Rating'];

$COLUMN = $_REQUEST['COLUMN'];
$PAGE = $_REQUEST['PAGE'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($Review != "" && $Rating != "") {
    $sql = "INSERT INTO book_review (`review_id`, `review_text`, `review_rating`, `review_date`, `review_time`, `review_book_id_FK`, `review_person_id_FK`)
     VALUES (NULL, '$Review', '$Rating', '$DATE', '$TIME', '$BOOK_ID', '$RENTER_ID');";
    if (isset($_POST['btn_add_review'])) {
        mysqli_query($conn, $sql);
        header("Location: ../book_rent_history.php?column={$COLUMN}&page={$PAGE}&ReviewSuccessfulyAdded");
    }
} else {
    header("Location: ../book_rent_history.php?column={$COLUMN}&page={$PAGE}&ProblemAddingReview");
}
