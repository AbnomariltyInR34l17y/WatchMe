<?php
    session_start();

    class UserManagement {
        private static $db;

        // Create your connection to the DB using hard coded credentials.
        public function __construct() {
            require ".credentials.php";
            self::$db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            self::$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }
    

        // LOGIN USER 
        public static function loginUser(string $username, string $password) {
            // $query = "SELECT e.id, e.username, w.user_id, w.id AS wallet_id FROM end_users e LEFT JOIN wallets w ON e.id = w.user_id WHERE e.username = :username AND e.password = :password";
            $query = "
                SELECT e.id, e.username, w.id AS wallet_id 
                FROM end_users e 
                LEFT JOIN wallets w ON e.id = w.user_id 
                WHERE e.username = :username AND e.password= :password
            ";
            $cursor = self::$db->prepare($query);
            $cursor->bindParam(":username", $username, PDO::PARAM_STR);
            $cursor->bindParam(":password", $password, PDO::PARAM_STR);
            $cursor->execute();
            $fetchedData = $cursor->fetch(PDO::FETCH_ASSOC);
            if ($fetchedData) {
                return $fetchedData;
            } else {
                // User not found or invalid credentials
                echo json_encode(["status" => false, "status_code" => 401, "message" => "Invalid username or password"]);
            }
            exit(0);
        }
        

        // REGISTER NEW USER 
        public static function registerUser(string $username, string $password) {
            // Check that the username and password are long enough
            if (strlen($username) <= 2 || strlen($password) <= 2) {
                echo json_encode (["status" => false, "status_code" => 409, "message" => "Username and password should be atleast 3 letters long"]);
                exit(0);
            }
            
            // Check if someone have the same username
            $doesUserExissts = self::checkUserNameExsissts($username);

            if(empty($doesUserExissts)){
                $query = "INSERT INTO `end_users`(`username`, `password`) VALUES (:username, :password)";
                $cursor = self::$db->prepare($query);
                $cursor->bindParam(":username", $username, PDO::PARAM_STR);
                $cursor->bindParam(":password", $password, PDO::PARAM_STR);
                $cursor->execute();
                
                $userId = self::$db->lastInsertId();
                echo json_encode(["status" => true, "status_code" => 200, "data" => (int) $userId]);
            } else {
                echo json_encode (["status" => false, "status_code" => 409, "message" => "Sorry. Username already exists"]);
            }
            exit(0);
        }


        public static function updateEndUser(int $userId, string $username, string $password) {
            // Want to change user 
            if ($username !== $_SESSION['username']) { 
                $doesUserExissts = self::checkUserNameExsissts($username);
                if ($doesUserExissts) {
                    return json_encode (["status" => false, "status_code" => 409, "message" => "Sorry. Username already exists"]);
                } 
            } 
            
            $query = "UPDATE `end_users` SET `username`=:username, `password`=:password WHERE id=:id";
            $cursor = self::$db->prepare($query);
            $cursor->bindParam(":username", $username, PDO::PARAM_STR);
            $cursor->bindParam(":password", $password, PDO::PARAM_STR);
            $cursor->bindParam(":id", $userId, PDO::PARAM_INT);
            $haveUpdate = $cursor->execute();

            if($haveUpdate){
                $query = "SELECT `username` FROM `end_users` WHERE id=:id";
                $cursor = self::$db->prepare($query);
                $cursor->bindParam(":id", $userId, PDO::PARAM_INT);
                $cursor->execute();

                $result = $cursor->fetch(PDO::FETCH_ASSOC);
                return json_encode(["status"=>true,"status_code" => 200, "data"=>$result]);
            } else {
                return json_encode(["status"=>false,"status_code" => 401,"message"=>"Mmmm. That didn't worked"]);
            }
        }            
        

        // Search the DB for the username. Return true or false
        private static function checkUserNameExsissts(string $username) {
            $initialQuery = "SELECT * FROM end_users WHERE username=:username";
            $initialCursor = self::$db->prepare($initialQuery);
            $initialCursor->bindParam(":username", $username, PDO::PARAM_STR);
            $initialCursor->execute();
            $result = $initialCursor->fetchAll(PDO::FETCH_ASSOC);
            return count($result) > 0;
        }
    }
