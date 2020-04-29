<?php
session_start();

include "../backend_logic/logic.connection.php";


if (isset($_POST['btn_submit'])) {

    $username = mysqli_real_escape_string($conn, trim($_POST['txt_username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['txp_password']));

    if ($username != "" && $password != "") {

        $sql_qurey = "SELECT COUNT(*) AS cntUser FROM person WHERE person_username='" . $username . "'AND person_password='" . $password . "'";
        $result = mysqli_query($conn, $sql_qurey);
        $row = mysqli_fetch_array($result);
        $count = $row['cntUser'];

        if ($count > 0) {

            $sql_query_rola = "SELECT person_role_FK FROM person WHERE person_username='" . $username . "'AND person_password='" . $password . "'";
            $result_rola = mysqli_query($conn, $sql_query_rola);
            $row_rola = mysqli_fetch_array($result_rola);
            $rolaID = $row_rola['person_role_FK'];

            $sql_query_ID = "SELECT person_id FROM person WHERE person_username='" . $username . "' and person_password='" . $password . "'";
            $result_ID = mysqli_query($conn, $sql_query_ID);
            $row_ID = mysqli_fetch_array($result_ID);
            $userID = $row_ID['person_id'];

            $_SESSION["current_username"] = $username;
            $_SESSION["current_userID"] = $userID;
            $_SESSION["current_role"] = $rolaID;
            if ($rolaID == 1) {
                header('Location: ../usrRenter/index.php');
            } else if ($rolaID == 2) {
                header('Location: ../usrLibrarian/index.php');
            } else {
                header('Location: ../usrAdmin/index.php');
            }
        } else {
            header("Location: ?Invalid_username_or_password");
        }
    }
}
?>
<html>

<head>
    <title>
        BookStore Sign in
    </title>
    <link rel="stylesheet" href="../visuals/login_page/login_page.css">
    <link rel="stylesheet" href="../visuals/glitch_text.css">
    <link rel="stylesheet" href="../visuals/submit_button.css">
</head>

<body>

    <div class="grid">

        <div class="login">

            <div class="glitch-text-class" contenteditable="true">Sign In</div>


            <form action="#" method="POST" class="forma">

                <div class="input_login">
                    <input class="animacija" type="text" id="txt_username" name="txt_username" placeholder="Username" required>
                    <span class="focus-border"></span>
                </div>

                <div class="input_login">
                    <input class="animacija" type="password" id="txp_password" name="txp_password" placeholder="Password" required>
                    <span class="focus-border"></span>
                </div>

                <div class="button_submit">
                    <button class="but_anim" type="submit" name="btn_submit" id="btn_submit">
                        Sign in
                    </button>
                </div>

                <p>Don't have an account? <a href="person_register.php">Register here</a></p>
            </form>

        </div>

    </div>

</body>

</html>