<?php

session_start();

include "../../backend_logic/logic.connection.php";

// Check user logged or not
if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

$USER_ID = $_SESSION["current_userID"];
$Name = $_POST['txt_name'];
$Surname = $_POST['txt_surname'];
$Age = $_POST['txt_age'];
$Username = $_POST['txt_username'];
$Password = $_POST['txt_password'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$sql = "UPDATE person SET person_name = '$Name', person_surname = '$Surname', person_username = '$Username', person_password ='$Password', person_age = '$Age' 
    WHERE person_id = $USER_ID";

if (isset($_POST['btn_update'])) {
    mysqli_query($conn, $sql);
    // header('Location: ../profile.php?SUCCESS');
    session_unset();
    session_destroy();
    header('Location:../../person/person_login.php');
} else {
    header('Location: ../profile.php?ERROR');
}
