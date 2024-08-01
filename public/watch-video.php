<?php
    session_start();

    if (!isset($_GET['id']) || $_GET['id'] < 1) {
        $_GET['id'] = 1;
    };

    if (empty($_SESSION['userId'])) {
        header('location:login.php');
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
        <title>WatchMe | Watch Video</title>
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
        <main id="single_movie_main" class="movie_card">
            <!-- At first (or the response isn't fitting) -->
            <h1 id="movie_title">Sorry, we didn't find the movie</h1>
            <p id="movie_description">Usueally this means the page does not exisst</p>
            <?php 
                // Does the user have a wallet?
                if ($_SESSION['walletId'] === null) {
                    echo "
                        <a href='/WatchMe/public/create-wallet.php'>
                            <h2>Please create a wallet first</h2>
                        </a>
                    ";
                // Did the user logged into his wallet? 
                } else if (!isset($_SESSION['magicWord'])) {
                    echo "<a href='/WatchMe/public/log-in-wallet.php'>
                            <h2>Please log in to your wallet first</h2>
                        </a>"
                    ;
                }
                ?>
            <iframe 
                loading="lazy"
                class="non_clickable"
                id="big_video_tag" 
                src="google.com"
                title="WatchMe movie" 
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
            </iframe>
            <button id="watch_me_button">Buy & Watch!</button>
        </main>
    </body>
    <script src="/WatchMe/public/js/apiComunicationHandler.js"></script>
    <script src="/WatchMe/public/js/watchVideo.js" defer></script>
</html>