<?php

session_start();

include "logic.connection.php";

if(isset($_POST['btn_logout'])){
    session_unset();
    session_destroy();
    header('Location:../person/person_login.php');
}