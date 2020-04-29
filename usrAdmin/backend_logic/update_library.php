<?php

session_start();

include "../../backend_logic/logic.connection.php";

if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

$LIBRARY_ID = (int) $_REQUEST['LIBID'];
$COLUMN = $_REQUEST['COLUMN'];
$PAGE = $_REQUEST['PAGE'];

$LibraryCountry = $_POST['LibraryCountry'];
$LibraryCity =  $_POST['LibraryCity'];
$LibraryAddress =  $_POST['LibraryAddress'];
$LibraryType = (int) $_POST['LibraryType'];
$LibrarySize = (int) $_POST['LibrarySize'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$sql = "UPDATE library_data SET library_country = '$LibraryCountry', library_city = '$LibraryCity', library_adress = '$LibraryAddress', library_size_FK = '$LibrarySize' , library_type_FK = '$LibraryType' 
WHERE library_id = $LIBRARY_ID";

if (isset($_POST['btn_update'])) {
    mysqli_query($conn, $sql);
    header("Location:../libraries.php?column={$COLUMN}&page={$PAGE}&SUCCESS");
} else {
    header("Location: ../libraries.php?column={$COLUMN}&page={$PAGE}&ERROR");
}
