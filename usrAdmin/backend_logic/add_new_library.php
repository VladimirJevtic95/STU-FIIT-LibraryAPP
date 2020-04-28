<?php

session_start();

include "../../backend_logic/logic.connection.php";

// Check user logged or not
if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

$Name = $_POST['Name'];
$Country = $_POST['Country'];
$City = $_POST['City'];
$Address = $_POST['Address'];
$Phone = $_POST['Phone'];
$Email = $_POST['Email'];
$Website = $_POST['Website'];
$Size = $_POST['Size'];
$Type = $_POST['Type'];


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($Name != "" && $Country != "" && $Address != "" ) {
    $sql = "INSERT INTO library_data (`library_id`, `library_name`, `library_country`, `library_city`, `library_adress`, `library_size_FK`, `library_type_FK`,
     `library_phone`, `library_email`, `library_website`)
     VALUES (NULL, '$Name', '$Country', '$City', '$Address', '$Size', '$Type', '$Phone', '$Email', '$Website');";
    if (isset($_POST['btn_add_new_library'])) {
        mysqli_query($conn, $sql);
        header('Location: ../new_library.php?NewLibrarySuccessfulyAdded');
    }
} else {
    header('Location: ../new_library.php?ProblemAddingNewLibrary');
}
