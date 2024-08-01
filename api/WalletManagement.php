<?php
    session_start();

    class WalletManagement {
        private static $db;

        // Create your connection to the DB using hard coded credentials.
        public function __construct() {
            require ".credentials.php";
            self::$db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            self::$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }


        // -- Create wallet
        static function createNewWallet(string $magicWord, int $userId, string $payingUser = "no") {
            $query = "INSERT INTO `wallets` (`id`, `magic_word`, `user_id`, `paying_user`) VALUES (:id, :magicWord, :userId, :payingUser)";
            $cursor = self::$db->prepare($query);
            
            $walletUuid = self::get_guid();
            try {
                $cursor->bindParam(":id", $walletUuid);
                $cursor->bindParam(":magicWord", $magicWord);
                $cursor->bindParam(":userId", $userId);
                $cursor->bindParam(":payingUser", $payingUser);
                
                $result = $cursor->execute();

                // When worked, get the last inserted line (new wallet line)
                if ($result) {
                    // Get the user's wallet by its userId
                    $query = "SELECT `id`, `magic_word`, `capital` FROM `wallets` WHERE `user_id` = :userId";
                    $cursor = self::$db->prepare($query);
                    $cursor->bindParam(":userId", $userId);
                    $cursor->execute();
                    $row = $cursor->fetch(PDO::FETCH_ASSOC);
                    return json_encode(["status" => true, "status_code" => 200, "data" => $row]);
                }  else {
                    return json_encode(["status" => false, "status_code" => 500, "message" => "Failed to create wallet"]);
                }
            } catch (PDOException $e) {
                return json_encode(["status" => false, "status_code" => 409, "message" => "Only one wallet a person"]);
            }
        }
        

        // To get information about user's wallet
        static function getMyWalletById(string $walletId, string $magicWord) {

            $query = "SELECT `id`, `magic_word`, `capital`, `paying_user` FROM `wallets` WHERE `magic_word`=:magicWord AND `id`=:id;";
            
            $cursor = self::$db->prepare($query);
            try {

                $cursor->bindParam(":id", $walletId);
                $cursor->bindParam(":magicWord", $magicWord);
                
                $result = $cursor->execute();
                $data = $cursor->fetch(PDO::FETCH_ASSOC);
                
                if ($result) {
                    return json_encode(["status" => true, "status_code" => 200, "data" => $data]);
                } else {
                    return json_encode(["status" => false, "status_code" => 500, "message" => "Failed to create wallet"]);
                }
            } catch (e) {
                return json_encode(["status" => false, "status_code" => 500, "message" => "Have to log into your wallet first"]);
            }             
        }


        // Get ALL of the transactions a user made
        static function getAllTransactions(string $walletId, string $magicWord) {
            // Ask for movies related to the transactions that relate to user
            $query = "
                SELECT ut.movie_id, mov.movie_title, mov.movie_price
                FROM user_transactions ut
                JOIN movies mov ON ut.movie_id = mov.id
                JOIN wallets w ON ut.wallet_id = w.id       
                WHERE w.id = :id
                AND w.magic_word = :magicWord;
            ";
            $cursor = self::$db->prepare($query);
            $cursor->bindParam(":id", $walletId);
            $cursor->bindParam(":magicWord", $magicWord);
            $cursor->execute();
            $rows = $cursor->fetchAll(PDO::FETCH_ASSOC);

            // Had transactions / Had no transactions / Error
            if ($rows) {
                return json_encode(["status" => true, "status_code" => 200, "data" => $rows]);
            } elseif (empty($rows["data"])) {
                return json_encode(["status" => false, "status_code" => 401, "message" => "Wrong password or You bought nothing"]);
            } else {
                return json_encode(["status" => false, "status_code" => 500, "message" => "OMG. How did that happend?"]);
            }
        }

            
        // Update paying status
        public static function changePayingUser() {
            return json_encode(["status"=> true,"status_code"=> 404]);
        }

        // Translate movie_id into information about the movie
        
        // Get an RFC-4122 compliant globaly unique identifier
        private static function get_guid() {
            $data = PHP_MAJOR_VERSION < 7 ? openssl_random_pseudo_bytes(16) : random_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // Set version to 0100
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // Set bits 6-7 to 10
            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        }
        
        
    }