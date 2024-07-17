<?php
    namespace Mynamespace;
    use Mynamespace\Configure;

    class GetUsers{
        
        public function getUsers(){
            $configuration = new Configure();
            $_conn = $configuration->config();

            $sql = "SELECT * FROM `users`";
            $query = mysqli_query($_conn, $sql);
            $categories = mysqli_fetch_all($query, MYSQLI_ASSOC);
            if(!$query){
                http_response_code(500);
                $message =  "Something went wrong, try again";
                $response = array("status" => "Fail", "message" => $message);
                echo json_encode($response);
                return $response; 
            }
            if(count($categories) < 1){
                http_response_code(404);
                $message =  "No categories yet";
                $response = array("status" => "Fail", "message" => $message);
                echo json_encode($response);
                return $response;
            }
            http_response_code(200);
            $response = array("status" => "Success", "data" => $categories);
            echo json_encode($response);
            return $response;

        }
    }

?>