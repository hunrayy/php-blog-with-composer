<?php
    namespace Mynamespace;
    use Mynamespace\Configure;
    use Mynamespace\Authorization;
    
    class TurnUserToAuthor{
        function userToAuthor($superAdminEmail, $userfname, $userlname, $useremail){
            $configuration = new Configure();
            $_conn = $configuration->config();

            $authorization = new Authorization();
            $feedback = $authorization->validate_user($useremail);
            
            echo json_encode($feedback);
            // data from $feedback would return either null or an array of privileges(array of numbers)
            if($feedback == null){
                //unauthorized user trying to make request
                http_response_code(401);
                $message = "Unauthorized user making request";
                $response = array("status" => "Fail", "message" => $message);
                echo json_encode($response);
                return $response;
            }else{
                //this is an admin making request but confirm if permitted
                // print_r($feedback);
                $in_array = in_array(4, $feedback); //4 is the id privilege for creating admin
                (int)$in_array;
                // echo (int)$in_array;

                if((int)$in_array == 0){
                    //id 4 is not in the privileges
                    http_response_code(401);
                    $message = "Unauthorized admin making request";
                    $response = array("status" => "Fail", "message" => $message);
                    echo json_encode( $response);
                    return $response;
                }
                //id 4 is among the privileges, proceed
                mysqli_real_escape_string($_conn, trim($superAdminEmail));
                mysqli_real_escape_string($_conn, trim($userfname));
                mysqli_real_escape_string($_conn, trim($userlname));
                mysqli_real_escape_string($_conn, trim($useremail));
                // echo $superAdminEmail, $userfname, $userlname, $useremail, $userpassword;

                if(empty($superAdminEmail) || empty($userfname) || empty($userlname) || empty($useremail)){
                    http_response_code(401);
                    $message = "Inavlid data";
                    $response = array("status" => "Fail", "message" => $message);
                    echo json_encode($response);
                    return $response;
                }else{
                    try{
                        //ensure the user being turned to an author exists
                        $getUser = "SELECT * FROM `users` WHERE `firstname` = ? AND `lastname` = ? AND `email` = ? ";
                        $query = mysqli_prepare($_conn, $getUser);
                        mysqli_stmt_bind_param($query, "sss", $userfname, $userlname, $useremail);
                        mysqli_execute($query);
                        $result = mysqli_stmt_get_result($query);
                        if($result){
                            //the user being turned to an author admin exists, proceed to change the role_id
                            $feedback = mysqli_fetch_assoc($result);
                            // echo json_encode($feedback);
                            if($feedback == null){
                                // Feedback does not exist
                                http_response_code(404);
                                $message = "User not found";
                                $response = array("status" => "Fail", "message" => $message);
                                echo json_encode($response);
                                return $response;
                            }else{
                                $role_id = $feedback['role_id'];
                                // echo $role_id;
                                // change role_id to 3. 3 is the role_id for an author
                                $get_user_id = $authorization->get_user_id($useremail);
                                $user_id = $get_user_id['id'];
                                $sql = "UPDATE `users` SET `role_id` = ? WHERE `id` = ?";
                                $query = mysqli_prepare($_conn, $sql);
                                $role_id = 3;
                                mysqli_stmt_bind_param($query, "ii", $role_id, $user_id);
                                mysqli_execute($query);
                                if(mysqli_stmt_affected_rows($query) == 1){
                                    http_response_code(200);
                                    $message = "user with the email $useremail was successfully made an author";
                                    $response = array("status" => "success", "message" => $message);
                                    echo json_encode($response);
                                    return $response;
                                }else {
                                    http_response_code(200);
                                    $message = "User already an author admin";
                                    $response = array("status" => "failure", "message" => $message);
                                    echo json_encode($response);
                                    return $response;
                                }
                            }
                        }
                    }catch(Exception $e){
                        $message = "Database error: " . $e->getMessage();
                        $response = array("status" => "error", "message" => $message);
                        echo $response;
                        return $response;
                    }
                        
                        
                };
                

            }
        }
    }

?>