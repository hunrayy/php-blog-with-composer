<?php
    namespace Mynamespace;
    
    session_start();

    class Authorization{
        public function validate_user($user_email){
            $configuration = new Configure();
            $_conn = $configuration->config();
            if(!isset($_SESSION["user_id"])){
                //no user is currently logged in
                http_response_code(401);
                $message = "user not logged in";
                $response = array("status" => "Fail", "message" => $message);
                echo json_encode($response);
                return json_encode($response);
            }else{
                //a user is currently logged in
                $id = $_SESSION['user_id'];
                $sql = "SELECT * FROM `users` WHERE `id` = ?";
                $query = mysqli_prepare($_conn, $sql);
                mysqli_stmt_bind_param($query, "i", $id);
                mysqli_execute($query);
                $result = mysqli_stmt_get_result($query);
                $result = mysqli_fetch_assoc($result);
                // echo json_encode($result);

                // get the role_id from data fetched
                $user_role_id = $result['role_id'];

                // use the role_id gotten to get the id on roles table
                $sql = "SELECT * FROM `role` WHERE `id` = ?";
                $query = mysqli_prepare($_conn, $sql);
                mysqli_stmt_bind_param($query, "i", $user_role_id);
                mysqli_execute($query);
                $result = mysqli_stmt_get_result($query);
                $result = mysqli_fetch_assoc($result);

                $privilege_id = $result['privilege_id'];
                return json_decode($privilege_id);
                // echo json_encode($privilege_id);
            }
        }

        public function get_user_id($email){
            $configuration = new Configure();
            $_conn = $configuration->config();
            
            $sql = "SELECT * FROM `users` WHERE `email` = ?";
            $query = mysqli_prepare($_conn, $sql);
            mysqli_stmt_bind_param($query, "s", $email);
            mysqli_execute($query);
            $result = mysqli_stmt_get_result($query);
            $result = mysqli_fetch_assoc($result);
            return $result;
        }
    }
    
    
?>