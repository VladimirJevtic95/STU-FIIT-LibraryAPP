<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database_systems_stu_fiit";

$conn = mysqli_connect($servername, $username, $password, $dbname);
mysqli_query($conn,"SET CHARACTER SET 'utf8'");
mysqli_query($conn,"SET SESSION collation_connection ='utf8_unicode_ci'");
// mysqli_set_charset($conn,"utf8");