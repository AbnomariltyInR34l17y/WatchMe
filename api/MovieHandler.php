<?php
    class MovieHandler {
        private static $db;

        // Create your connection to the DB using hard coded credentials.
        public function __construct() {
            require ".credentials.php";
            self::$db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            self::$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }


        // View all movies GET
        static function getAllMovies(int $limit = 10, int $offset = 0) {
            $query = "SELECT * FROM `movies` ORDER BY id LIMIT :limit OFFSET :offset";
            $cursor = self::$db->prepare($query);
            $cursor->bindValue(":limit", $limit, PDO::PARAM_INT);
            $cursor->bindValue(":offset", $offset, PDO::PARAM_INT);
            $cursor->execute();
            $rows = $cursor->fetchAll(PDO::FETCH_ASSOC);
            if($rows){
                echo json_encode(["status"=>true,"status_code" => 200, "data"=>$rows]);
            } else {
                echo json_encode(["status"=>false,"status_code" => 401,"message"=>"No movies found"]);
            }
            exit(0);
        }


        // Watch one movie GET
        static function getOneMovie(int $movieId) {
            $query = "SELECT * FROM `movies` WHERE `id`=:id";
            $cursor = self::$db->prepare($query);
            $cursor->bindParam(":id", $movieId, PDO::PARAM_INT);
            $cursor->execute();
            $rows = $cursor->fetch(PDO::FETCH_ASSOC);
            if($rows){
                return json_encode(["status"=>true,"status_code" => 200, "data"=>$rows]);
            } else {
                return json_encode(["status"=>false,"status_code" => 401,"message"=>"Are you sure the film exisst?"]);
            }
        }
    }
?>