<?php

session_start();

include "../../backend_logic/logic.connection.php";

// Check user logged or not
if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

$Name = $_POST['Name'];
$Surname = $_POST['Surname'];
$Username = $_POST['Username'];
$Password = $_POST['Password'];
$Age = $_POST['Age'];
$RoleID = $_POST['RoleID'];


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($Name != "" && $Surname != "" && $Username != "" && $Password != "") {
    $sql = "INSERT INTO person (`person_id`, `person_name`, `person_surname`, `person_username`, `person_password`, `person_age`, `person_role_FK`)
     VALUES (NULL, '$Name', '$Surname', '$Username', '$Password', '$Age', '$RoleID');";
    if (isset($_POST['btn_add_new_librarian'])) {
        mysqli_query($conn, $sql);
        header('Location: ../new_librarian.php?NewLibrarianSuccessfulyAdded');
    }
} else {
    header('Location: ../new_librarian.php?ProblemAddingNewLibrarian');
}
