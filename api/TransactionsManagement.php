<?php
    class TransactionManagement {
        private static $db;


        // Create your connection to the DB using hard coded credentials.
        public function __construct() {
            require ".credentials.php";
            self::$db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            self::$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }


        // Get the users wallet to check how much money he have
        private static function getUserWallet(string $incomeWalletId, string $magicWord = "none") {
            $query = "SELECT (`capital`) FROM `wallets` WHERE `id` = :id AND `magic_word` = :magicWord";
            $cursor = self::$db->prepare($query);
            $cursor->bindParam(":id", $incomeWalletId, PDO::PARAM_STR);
            $cursor->bindParam(":magicWord", $magicWord , PDO::PARAM_STR);
            $cursor->execute();
            $result = $cursor->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            } else return null;
        }


        // Save a new transaction
        private static function insertNewTransaction(string $walletId, int $movieId) {
            $query = "INSERT INTO `user_transactions`(`wallet_id`, `movie_id`) VALUES (:walletId, :movieId)";
            $cursor = self::$db->prepare($query);
            $cursor->bindParam(":walletId", $walletId, PDO::PARAM_STR);
            $cursor->bindParam(":movieId", $movieId, PDO::PARAM_INT);
            $result = $cursor->execute();
            if ($result) {
                $lastInsertId = self::$db->lastInsertId();
                return $lastInsertId;
            } else return false;
            
        }


        // Update the users Wallet
        private static function updateWalletCapital(float $totalAfterBuy, string $incomeWalletId, string $magicWord = "none") {
            $query = "UPDATE `wallets` SET `capital`= :totalAfterBuy WHERE `id` = :id AND `magic_word` = :magicWord";
            $cursor = self::$db->prepare($query);
            $cursor->bindParam(":id", $incomeWalletId, PDO::PARAM_STR);
            $cursor->bindParam(":magicWord", $magicWord , PDO::PARAM_STR);
            $cursor->bindParam(":totalAfterBuy", $totalAfterBuy);
            $result = $cursor->execute();
            if ($cursor->rowCount() > 0 && $result) {
                return "Worked Fine";
            } else return "Nope";
            
        }


        // MAIN: Get the users input to make new transaction
        static function createTransaction(string $incomeWalletId, string $incomeUserPassword, int $incomeMovieId, float $incomeMoviePrice = 1.2) { //TODO: change price
            $wallet = self::getUserWallet($incomeWalletId, $incomeUserPassword);
            // Validatation that wallet information loaded 
            if ($wallet !== null) {
                $sumTotal = $wallet["capital"] - $incomeMoviePrice;

                // Check the user got enough money
                if ($sumTotal > 0) { 
                    $didWalletUpdated = self::updateWalletCapital($sumTotal, $incomeWalletId, $incomeUserPassword);
                    // Check the wallet's capital updated
                    if ($didWalletUpdated === "Worked Fine") {
                        $_SESSION['capital'] = $sumTotal;

                        $transactionId = self::insertNewTransaction($incomeWalletId, $incomeMovieId);
                        // Check that the transaction saved properly in DB
                        if ($transactionId !== null) {
                            // Get this transaction info
                            $query = "SELECT * FROM `user_transactions` WHERE `id` = :id";
                            $cursor = self::$db->prepare($query);
                            $cursor->bindParam(":id", $transactionId, PDO::PARAM_INT);
                            $cursor->execute();
                            $row = $cursor->fetch(PDO::FETCH_ASSOC);
                            echo json_encode(["status" => true, "status_code" => 200, "message"=>"Everything worked perfectly! Enjoy the film", "data" => $row]);                    
                        } else { // Failed to create a new row in user_transactions in the DB 
                            echo json_encode(["status"=>false,"status_code" => 500, "message"=>"Transaction Failed. No charges applied"]);
                        }
                    } else { // Failed to update wallet capital
                        echo json_encode(["status"=>false,"status_code" => 412,"message"=>"Couldn't update your wallet"]);
                    }
                } else { // Capital related
                    echo json_encode(["status"=>false,"status_code" => 403,"message"=>"Not enough paplitos."]);
                }
            } else { // No wallet returned
                echo json_encode(["status"=>false,"status_code" => 401,"message"=>"Couldn't verify / find your wallet"]);
            }
            exit(0);
        }
    }