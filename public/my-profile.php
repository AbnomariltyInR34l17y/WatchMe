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
        <title>WatchMe | My Profile</title>
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
                <section>
                    <h1 class="text_align_ctr" ><?php echo $_SESSION['username']?>'s Profile</h1>
                    <?php
                        $logWalletInString = '<a href="/WatchMe/public/log-in-wallet.php"><h2 class="text_align_ctr">Log in to your wallet</h2></a>';
                        // Does the user own a wallet?
                        if ($_SESSION['walletId'] === null) {
                            echo '<a href="/WatchMe/public/create-wallet.php"><h2 class="text_align_ctr">Create your wallet</h2></a>';
                        // Did the user logged into his wallet?
                        } else if (!isset($_SESSION['magicWord'])) {
                            echo $logWalletInString;
                        // All the $_SESSION variables related to login are set?  
                        } else if (isset($_SESSION['magicWord']) && isset($_SESSION['capital']) && isset($_SESSION['walletId'])) {
                            echo "<h2 class='text_align_ctr' >Wallet: {$_SESSION['capital']}$</h2>";

                            // Get the users transactions!
                            require('../api/WalletManagement.php');
                            $walletManagement = new WalletManagement();
                            $jsonTransactions = $walletManagement::getAllTransactions($_SESSION['walletId'], $_SESSION['magicWord']);
                            
                            $transactions = json_decode($jsonTransactions, true);
                            if ($transactions["status"]) {
                                echo '<ul class="text_align_ltr"><h2>Transactions</h2>';
                                foreach ($transactions["data"] as $transaction) {
                                    echo '<li><p>' . $transaction['movie_title'] . ' : ' . $transaction['movie_price'] . "$</p></li>";
                                }
                                echo '</ul>';
                            }
                        }
                    ?>
                </section>
                <section>
                    <h2 class="text_align_ctr">Change Account Username And/Or password</h2>
                    <form id="update_details" class="text_align_ctr">
                        <p>More than 3 charecters&period; No space on the beginning or the back</p>
                        <label for="username_input"><p class="text_align_ltr">Change Username</p></label>
                        <input class="input_long_text" id="username_input" required minlength="3" maxlength="255" type="text" placeholder="Username">
                    
                        <label for="important_input"><p class="text_align_ltr">Change Password</p></label>
                        <input class="input_long_text" id="important_input" required minlength="3" maxlength="255" type="password" placeholder="Password">

                        <button type="submit"><p>Change</p></button>
                    </form>
                </section>
                <hr></hr>
                <button id="logoutButton">Logout</button>
            </div>
        </main>
    </body>
    <script src="/WatchMe/public/js/apiComunicationHandler.js"></script>
    <script src="/WatchMe/public/js/myProfile.js"></script>
    <script src="/WatchMe/public/js/checkVariableType.js"></script>
</html>