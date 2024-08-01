<?php
    session_start();

    // Prevent a user to reach this page if already logged in 
    if (isset($_SESSION["userId"])) {
        header("Location:my-profile.php");  
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta
            name="WatchMe"
            content="Stream / Watch movies, online, for free!"
        />
        <title>WatchMe | Login</title>
        <link href="/WatchMe/public/css/index.css" rel="stylesheet">
    </head>
    <body id="page-top">    
        <nav>
            <a href="#" onclick="history.back(); return false;">
                <div id="back_arrow"></div>
            </a>
            <a class="no_effect_a" href="/WatchMe/public/explore-videos.php">
                <header id="logo_h1_title">WatchMe</header>
            </a>
            <a href="/WatchMe/public/my-profile.php">
                <img id="profile_button" src="/WatchMe/public/img/profileButton.png" alt="WatchMe user login" />
            </a>
        </nav>

        <main>
            <div class="main_single_container">
                <h1>Login!</h1>
                <h2>Member area. Watch movies like royalty</h2>
                <p>
                    In case you don&apos;t have an acount, press <a href="/WatchMe/public/register.php">HERE to register</a>&NewLine;
                    Moviews, Television, videos, TV series. Everything, just two steps away. 
                </p>
                <form id="login_form" class="text_align_ctr">
                    <p>More than 3 charecters&period; No space on the beginning or the back</p>
                    <label for="username_input"><p class="text_align_ltr">Username</p></label>
                    <input class="input_long_text" id="username_input" required minlength="3" maxlength="255" type="text" placeholder="Username">

                    <label for="important_input"><p class="text_align_ltr">Password</p></label>
                    <input class="input_long_text" id="important_input" required minlength="3" maxlength="255" type="password" placeholder="Password">

                    <button type="submit"><p>Login</p></button>
                </form>
            </div>
        </main>
        <noscript>Your browser does not support JavaScript!</noscript>
        <script src="/WatchMe/public/js/login.js"></script>
        <script src="/WatchMe/public/js/apiComunicationHandler.js"></script>
        <script src="/WatchMe/public/js/checkVariableType.js"></script>
    </body>
</html>