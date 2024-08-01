<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta
            name="WatchMe"
            content="Stream / Watch movies, online, for free!"
        />
        <title>WatchMe | Offers</title>
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
            <div id="movies_container" class="main_single_container">
           </div>
        </main>
        <noscript>Your browser does not support JavaScript!</noscript>
        <script src="/WatchMe/public/js/apiComunicationHandler.js"></script>
        <script src="/WatchMe/public/js/exploreVidoes.js"></script>
    </body>
</html>