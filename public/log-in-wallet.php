<?php
    session_start();

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
        <title>WatchMe | Get Your Wallet</title>
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
                <h1 class="text_align_ctr" >Log into your wallet <?php echo $_SESSION['username']?></h1>
                <p>Put your magic word and watch movies and videos&period;<br>
                  Streaming videos and TV serire never been easier&period;&NewLine;
                </p>
                <form id="get_wallet_form" class="text_align_ctr">
                    <label for="important_input"><p class="text_align_ltr">Password</p></label>
                    <input class="input_long_text" id="important_input" minlength="3" maxlength="255" type="password" placeholder="Wallet Password">
                    <button type="submit"><p>Open your Wallet</p></button>
                </form>
            </div>
        </main>
    </body>
    <script src="/WatchMe/public/js/apiComunicationHandler.js"></script>
    <script src="/WatchMe/public/js/getWalletById.js"></script>
    <script src="/WatchMe/public/js/checkVariableType.js"></script>
</html>