<?php
    namespace Mynamespace;
    use Mynamespace\Configure;
    use Mynamespace\Authorization;

    class Create_blog{
        
        public function insertContent($authorEmail, $noteTitle, $noteContent, $noteCategory){
            $configuration = new Configure();
            $_conn = $configuration->config();

            $authorEmail = mysqli_real_escape_string($_conn, trim($authorEmail));
            $noteTitle = mysqli_real_escape_string($_conn, trim($noteTitle));
            $noteContent = mysqli_real_escape_string($_conn, trim($noteContent));
            $noteCategory = mysqli_real_escape_string($_conn, trim($noteCategory));


            $authorization = new Authorization();
            $feedback = $authorization->validate_user($authorEmail);
            // data from $feedback would return either null or an array of privileges(array of numbers)
            // echo json_encode($feedback);
            $in_array = in_array(1, $feedback); //1 is the id privilege for creating article
            ;
            if($feedback == null){ 
                //unauthorized user trying to make request
                http_response_code(401);
                $message = "Unauthorized user making request";
                $response = array("status" => "Fail", "message" => $message);
                echo json_encode($response);
                return $response;
            }else if((int)$in_array == 0){ 
                //user is an admin but unauthorized to create article
                http_response_code(401);
                $message = "Unauthorized admin making request";
                $response = array("status" => "Fail", "message" => $message);
                echo json_encode($response);
                return $response;
            }else{
                try{
                    // fetch data from category table to get the id of the category picked
                    $sql = "SELECT * FROM `category` WHERE `category` = ?";
                    $query = mysqli_prepare($_conn, $sql);
                    mysqli_stmt_bind_param($query, "s", $noteCategory);
                    mysqli_execute($query);
                    $feedback = mysqli_stmt_get_result($query);
                    $feedback = mysqli_fetch_assoc($feedback);
                    $category_id = $feedback['id'];

                    //id of catgeory gotten...proceed to store article in the database
                    $user_id = $_SESSION['user_id'];
                    $sql = "INSERT INTO `articles`(`title`, `content`, `category_id`, `user_id(author)`) VALUES (?, ?, ?, ?)";
                    $query = mysqli_prepare($_conn, $sql);
                    mysqli_stmt_bind_param($query, "ssss", $noteTitle, $noteContent, $category_id, $user_id);
                    $feedback = mysqli_execute($query);
                    if(mysqli_stmt_affected_rows($query)){
                        http_response_code(401);
                        $message = "content successsfully uploaded";
                        $response = array("status" => "success", "message" => $message);
                        echo json_encode($response);
                        return $response;
                    }
                }catch(Exception $e){
                    $message = "Database error: " . $e->getMessage();
                    $response = array("status" => "error", "message" => $message);
                    echo json_encode($response);
                }
            }
        }
    }

?>