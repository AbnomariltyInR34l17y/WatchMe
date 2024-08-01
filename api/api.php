<?php
    session_start();

    // Follow the amount of request each user sends to the API
    if (empty($_SESSION['user_requests'])) {
        $_SESSION['user_requests'] = 1;
    } else {
        $_SESSION['user_requests']++;
    }

    // Parse the JSON payload into a PHP associative array
    $requestPayload = file_get_contents('php://input');
    $incomeData = json_decode($requestPayload, true);
    header('Content-Type:application/json');

    // Imports
    require "UserManagement.php";
    require "WalletManagement.php";
    require "MovieHandler.php";

    // Constants
    $userManagement = new UserManagement();
    $walletManagement = new WalletManagement();
    $movieHandler = new MovieHandler();

    // Variables to check if input have white space
    $untrimmedIncomeUserName = isset($_POST['username']) ? $_POST['username'] : $incomeData['username'];
    $untrimmedIncomeUserPassword = isset($_POST['password']) ? $_POST['password'] : $incomeData['password'];

    // Exit and return error when user uses space before or after the username or password
    $incomeUserName= trim($untrimmedIncomeUserName);
    $incomeUserPassword = trim($untrimmedIncomeUserPassword);
    if (strlen($incomeUserName) !== strlen($untrimmedIncomeUserName) || strlen($incomeUserPassword) !== strlen($untrimmedIncomeUserPassword) ) {
        echo json_encode (["status" => false, "status_code" => 409, "message" => "Using spaces before /after the username or password is not allowed"]);
        exit(0);
    }

    // Handle income data types Which invove numbers and predetermined strings
    $action = isset($_POST['action']) ? $_POST['action'] : $incomeData['action'];
    $incomeUserId = isset($_POST['userId']) ? $_POST['userId'] : $incomeData['userId'];
    $incomeWalletId = isset($_POST['walletId']) ? $_POST['walletId'] : $incomeData['walletId'];
    $incomeMovieId = isset($_POST['movieId']) ? $_POST['movieId'] : $incomeData['movieId'];

    
    // This switch case is handling $_SESSION
    // ACTION TIME!!!
    switch($action){
        // USER RELATED
        case "logMeIn":
                $result = $userManagement->loginUser($incomeUserName ,$incomeUserPassword);
                if (!empty($result['id'])) {
                    $_SESSION['userId'] = $result['id'];
                    $_SESSION['username'] = $result['username'];
                    $_SESSION['walletId'] = $result['wallet_id'];
                    echo json_encode (["status" => true]);
                } else {
                    echo json_encode(["status"=> false]);
                }
            break;
        
        case "signMeUp":
            $result = $userManagement->registerUser($incomeUserName ,$incomeUserPassword);
            if($result['status']){
                echo json_encode(["status"=> $result['status'], "message"=>"Regestration worked properly!"]);
            } else echo json_encode(["status"=> $result['status'], "message"=>"Registration Failed!"]);
            break;

        case "updateUserInformation":
            if (!isset($_SESSION['userId'])) {
                echo json_encode(["status" => false, "status_code" => 500, "message" => "Login to your wallet first"]);
                sleep(2);
                exit(0);
            }
            $jsonResult = $userManagement->updateEndUser($_SESSION['userId'], $incomeUserName ,$incomeUserPassword);
            $result = json_decode($jsonResult, true);
            $_SESSION['username'] = $result['data']['username'];
            if($result['status']){
                echo json_encode(["status"=> $result['status'], "message"=>"Profile updated!"]);
            } else echo json_encode(["status"=> $result['status'], "message"=>"Registration Failed!"]);
            break;
        // END USER RELATED


        // WALLET RELATED
        case "createNewWallet":
            if (!isset($_SESSION['userId'])) {
                echo json_encode(["status" => false, "status_code" => 500, "message" => "Login to your wallet first"]);
                sleep(2.2);
                exit(0);
            }
            $isPayingUser = "no";
            $jsonedResult = $walletManagement->createNewWallet($incomeUserPassword, $_SESSION['userId'], $isPayingUser);
            $result = json_decode($jsonedResult, true);
            if ($result["status_code"] === 200) {
                $_SESSION['magicWord'] = $result['data']['magic_word'];
                $_SESSION['walletId'] = $result['data']['id'];
                $_SESSION['capital'] = $result['data']['capital'];
                echo json_encode (["status" => true, "message" => "Congratulations! You have new wallet!"]);
            } else echo json_encode(["status"=> false, "message" => $result['message']]);
            break;   
        
        case "getMyWallet":
            if (!isset($_SESSION['walletId'])) {
                echo json_encode(["status" => false, "status_code" => 500, "message" => "Login / create to your wallet first"]);
                sleep(2);
                exit(0);
            }
            $jsonResult = $walletManagement-> getMyWalletById($_SESSION['walletId'], $incomeUserPassword);
            $result = json_decode($jsonResult, true);

            if ($result) {
                // Handling $_SESSION in the api.php causes a bug. Error: 20001
                $_SESSION['magicWord'] = $result['data']['magic_word'];
                $_SESSION['walletId'] = $result['data']['id'];
                $_SESSION['capital'] = $result['data']['capital'];
                echo json_encode (["status" => $result['status'], "message" => "Wow! We got you wallet"]);
            } else echo json_encode(["status"=> $result["status"], "message" => "MMM... That didn't worked. Please conntect us"]);
            break;   
        
        // Get all the transactions from the wallet since walletID is the main variable in thie query
        case "getMyTransactions":
            if (!isset($_SESSION['walletId']) || !isset($_SESSION['magicWord'])) {
                echo json_encode(["status" => false, "status_code" => 500, "message" => "Login to your wallet first"]);
                sleep(1);
                exit(0);
            }
            $jsonResult = $walletManagement-> getAllTransactions($_SESSION['walletId'], $_SESSION['magicWord']);
            $result = json_decode($jsonResult, true);
            if ($result) echo json_encode (["status" => $result['status'], "data" => $result["data"]]);
            else echo json_encode(["status"=> $result["status"], "message" => "MMM... That didn't worked. Did zou had transactions?"]);
            break;  
        // END WALLET RELATED
        

        // MOVIES RELATED
        case "getAllMovies":
            $result = $movieHandler-> getAllMovies();
            if ($result) echo json_encode (["status" => $result['status'], "data" => $result["data"]]);
            else echo json_encode(["status"=> $result["status"], "message" => $result["message"]]);
            break;  

        case "getOneMovie":
            $resultJson = $movieHandler->getOneMovie($incomeMovieId);
            $result = json_decode($resultJson, true);

            if ($result) echo json_encode (["status" => $result['status'], "data" => $result["data"]]);
            else echo json_encode(["status"=> $result["status"], "message" => $result["message"]]);
            break;  
        // END MOVIES RELATED


        // TRANSACTIONS RELATED
        case "iWantThis":
                // Get the information about the movie
                $movieInfo = $movieHandler-> getOneMovie($incomeMovieId);
                $invoiceInfo = buyThisMovie($movieInfo);
                echo json_encode(["status"=> $result["status"], "message" => $invoiceInfo]);
            break; 
        // END TRANSACTIONS RELATED

        
        default:
            echo json_encode(["status"=>false,"message"=>"Sorry, no matching action has been found!"]);
            break;

    }

    // To leave the "IWantThis" case small, this function been seperated
    // Validate there is enough information and create a new transaction
    function buyThisMovie($movieInfoJson) {
        if (!isset($_SESSION['walletId']) || !isset($_SESSION['magicWord'])) {
            echo json_encode(["status" => false, "status_code" => 500, "message" => "Login to your wallet first"]);
            sleep(1);
            exit(0);
        }

        $movieInfo = json_decode($movieInfoJson, true);

        require "TransactionsManagement.php";
        $transaction = new TransactionManagement();

        $result = $transaction->createTransaction($_SESSION['walletId'], $_SESSION['magicWord'], $movieInfo['data']['id'], $movieInfo['data']['movie_price']);
        if ($result) {
            return json_encode(["status"=> $result["status"], "status_code" => $result["status_code"], "message" => $result["message"], "data" => $result["data"]]);
        } elseif (empty($result)) {
            return json_encode(["status"=> $result["status"], "status_code" => $result["status_code"], "message" =>"Are you sure there is a movie like this?"]);
        } else {
            return json_encode(["status"=> $result["status"], "status_code" => $result["status_code"], "message" => $result["message"]]);
        }
    }
