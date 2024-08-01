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
        <title>WatchMe | Create a Wallet</title>
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
                <h1 class="text_align_ctr" >Create wallet for <?php echo $_SESSION['username']?></h1>
                <p>To create a wallet so you can buy movies you should visit this page&period;<br>
                    <b>Please</b> use differnt passwords&period;&NewLine;
                </p>
                <p>More than 3 charecters&period; No space on the beginning or the back</p>
                <form id="create_wallet_form" class="text_align_ctr">
                    <label for="important_input"><p class="text_align_ltr">Password</p></label>
                    <input class="input_long_text" id="important_input" required minlength="3" maxlength="255" type="password" placeholder="Password or leave empty">

                    <label for="important_input2"><p class="text_align_ltr">Repeat Password</p></label>
                    <input class="input_long_text" id="important_input2" required minlength="3" maxlength="255" type="password" placeholder="Repeat Password or leave empty">

                    <button type="submit"><p>Create Wallet</p></button>
                </form>
            </div>
        </main>
    </body>
    <script src="/WatchMe/public/js/apiComunicationHandler.js"></script>
    <script src="/WatchMe/public/js/createWallet.js"></script>
    <script src="/WatchMe/public/js/checkVariableType.js"></script>
</html>