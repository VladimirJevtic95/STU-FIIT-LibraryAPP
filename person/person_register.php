<html>

<head>
    <title>
        BookStore Register
    </title>
    <link rel="stylesheet" href="../visuals/register_page/register_page.css">
    <link rel="stylesheet" href="../visuals/glitch_text.css">
    <link rel="stylesheet" href="../visuals/submit_button.css">
</head>

<body>

    <div class="grid">

        <div class="register">

            <div class="glitch-text-class" contenteditable="true">Register</div>


            <form action="backend_logic/register_new_user.php" method="POST" class="forma">

                <div class="outer">

                    <div class="input_reister_personal">
                        <input class="animacija" type="text" id="txt_name" name="txt_name" placeholder="Name" required>
                        <span class="focus-border"></span>
                    </div>

                    <div class="input_reister_personal">
                        <input class="animacija" type="text" id="txt_surname" name="txt_surname" placeholder="Surname" required>
                        <span class="focus-border"></span>
                    </div>

                    <div class="input_reister_age">
                        <input class="animacija" type="number" id="txt_age" name="txt_age" placeholder="Age" maxlength="3" min="18" max="100">
                        <span class="focus-border"></span>
                    </div>

                </div>
                <div class="outer">

                    <div class="input_reister" style="margin-right: 4%">
                        <input class="animacija" type="text" id="txt_username" name="txt_username" placeholder="Username" required>
                        <span class="focus-border"></span>
                    </div>

                    <div class="input_reister">
                        <input class="animacija" type="password" id="txt_password" name="txt_password" placeholder="Password" required>
                        <span class="focus-border"></span>
                    </div>

                </div>

                <div class="button_submit">
                    <button class="but_anim" type="submit" name="btn_submit" id="btn_submit">
                        Register
                    </button>
                </div>

                <p>Already have an account? <a href="person_login.php">Sign in here</a></p>
            </form>

        </div> <!-- end register -->

    </div>

</body>

</html>