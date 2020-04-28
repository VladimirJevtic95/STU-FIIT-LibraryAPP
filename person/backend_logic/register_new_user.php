<?php

session_start();

include "../../backend_logic/logic.connection.php";

$Name = $_POST['txt_name'];
$Surname = $_POST['txt_surname'];
$Username = $_POST['txt_username'];
$Password = $_POST['txt_password'];
$Age = $_POST['txt_age'];
$RoleID = 1;


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($Name != "" && $Surname != "" && $Username != "" && $Password != "") {
    $sql = "INSERT INTO person (`person_id`, `person_name`, `person_surname`, `person_username`, `person_password`, `person_age`, `person_role_FK`)
     VALUES (NULL, '$Name', '$Surname', '$Username', '$Password', '$Age', '$RoleID');";
    if (isset($_POST['btn_submit'])) {
        mysqli_query($conn, $sql);
        header('Location: ../person_login.php?NewUserSuccessfulyAdded');
    }
} else {
    header('Location: ../person_login.php?ProblemAddingNewUser');
}
