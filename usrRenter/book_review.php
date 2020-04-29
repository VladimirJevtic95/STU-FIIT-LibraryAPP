<?php

session_start();

include "../backend_logic/logic.connection.php";

if (!isset($_SESSION["current_userID"]) && !isset($_SESSION["current_username"])) {
    header('Location: ../person/person_login.php');
}

if (($_SESSION["current_role"]) != 1) {
    session_unset();
    session_destroy();
    header('Location: ../person/person_login.php?');
}

$_SESSION["bookID"] = (int) $_REQUEST['ID'];;

?>

<html>

<head>
    <title>
        <?php
        echo $_SESSION["current_username"];
        ?>
    </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="../visuals/table_style.css">

</head>

<body>

    <p>renter</p>
    <?php
    echo "<p>USERNAME:" . $_SESSION["current_username"] . "<br/> ID:" . $_SESSION["current_userID"] . "<br/> ROLA:" . $_SESSION["current_role"] . "</p>";
    echo "<p>Book:" . $_SESSION["bookID"] . "</p><br>";
    ?>

    <form method="POST" action="../backend_logic/logic.logout.php">
        <button type="submit" id="btn_logout" name="btn_logout">logout</button>
    </form>

    <form method="POST" action="backend_logic/add_review.php">
        <textarea id="Review" name="Review" rows="6" cols="70"></textarea>
        <br><br>
        <input type="number" name="Rating" placeholder="0 - 100" maxlength="3" min="0" max="100">
        <br><br>
        <button type="submit" id="btn_add" name="btn_add">Add review</button>
    </form>

</body>

</html>