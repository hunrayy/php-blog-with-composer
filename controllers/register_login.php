<?php
    namespace Mynamespace;
    use Mynamespace\Configure;
    use Mynamespace\MailHandling;
    $session = session_start();

    class Register_login{
        //register function
        public function register($firstname, $lastname, $email, $password){
            $configuration = new Configure();
            $_conn = $configuration->config();

            
            mysqli_real_escape_string($_conn, trim($firstname));
            mysqli_real_escape_string($_conn, trim($lastname));
            mysqli_real_escape_string($_conn, trim($email));
            mysqli_real_escape_string($_conn, trim($password));
            
            if($firstname == "" && $lastname == "" && $email == "" && $password == ""){
                json_encode([
                    "message" => "invalid user info",
                    "error" => "firstname, lastname, email, and password required"
                ]);
                echo "invalid user info";
            }else{
                try{
                   /**fetch from the users' table
                    if there isn't any data there, insert the current data with a `role_id` of 1 
                    else insert the current data with a `role_id` of 2 */
                    // $query = "SELECT * FROM `users`";
                    // $feedback = mysqli_query($_conn, $query);
                    // echo json_encode($feedback);
                    // if ($feedback) {
                    //     $role_id = mysqli_num_rows($feedback) > 0 ? 2 : 1; 
                    //     $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    //     $query = "INSERT INTO `users` (`firstname`, `lastname`, `email`, `password`, `status`, `role_id`) VALUES (?, ?, ?, ?, ?, ?)";
                    //     $stmt = mysqli_prepare($_conn, $query);
                    //     $status = 0;
                    //     mysqli_stmt_bind_param($stmt, "ssssii", $firstname, $lastname, $email, $hashed_password, $status, $role_id);
                    //     $result = mysqli_stmt_execute($stmt);
    
                    //     if ($result) {
                            // send welcome mail to user's email
                            $mail = new MailHandling();
                            $registrationMail = $mail->registrationMail($firstname, $email);

                    //         $user_id = mysqli_insert_id($_conn);
                    //         $_SESSION['user_id'] = $user_id;
                    //         $_SESSION['user_email'] = $email;
                    //         $_SESSION['user_role'] = $role_id;
    
                    //         $message = $role_id == 1 ? "Super admin's account successfully created" : "Account successfully created";
                    //         echo $message;
                    //         return json_encode([
                    //             "code" => "success",
                    //             "message" => $message
                    //         ]);
                    //     }
                    // } else {
                    //     echo "Query failed: " . mysqli_error($_conn);
                    // }


                    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // $query = "INSERT INTO `users` (`firstname`, `lastname`, `email`, `password`, `status`, `role`id) VALUES (?, ?, ?, ?, ?, ?)";
                    // $stmt = mysqli_prepare($_conn, $query);
                    // mysqli_stmt_bind_param($stmt, "ssssii", $firstname, $lastname, $email, $hashed_password, 0, 0);
                    // $result = mysqli_execute($stmt);
                    // echo $result;
                    // if($result){
                    //     $user_id = mysqli_insert_id($_conn);
                    //     echo "Account successfully created, id is $user_id";
                    //     return json_encode([
                    //         "code" => "success",
                    //         "message" => "Account successfully created"
                    //     ]);
                    // };
                    
                }catch(Exception $e){
                    json_encode([
                        "code" => "error",
                        "message" => "Account could not be created",
                        "reason" => $e
                    ]);
                    echo "Account not created";
                };
    
            }
        }

        //login function
        public function login($email, $password){
            $configuration = new Configure();
            $_conn = $configuration->config();


            if(!$email || !$password){
                $message = "All fields required";
                echo $message;
                return json_encode([
                    "message" => $message,
                    "code" => "error"
                ]);
            }else{

                $email = mysqli_real_escape_string($_conn, trim($email));
                $password = mysqli_real_escape_string($_conn, trim($password));
                try{
                    

                    $query = "SELECT * FROM `users` WHERE `email` = ? LIMIT 1";
                    $result = mysqli_prepare($_conn, $query);
                    mysqli_stmt_bind_param($result, "s", $email);
                    mysqli_stmt_execute($result);
                    $stmt_result = mysqli_stmt_get_result($result);
                    


                    if(mysqli_num_rows($stmt_result) == 1){
                        $userdata = mysqli_fetch_assoc($stmt_result);
                        $stored_password = $userdata['password'];
                        if(!password_verify($password, $stored_password)){
                            //the user's account exists but the password does not match
                            $message = "Invalid credentials";
                            echo $message;
                            return json_encode([
                                "message" => $message,
                                "code" => "error"
                            ]);
                        }else{
                            //the user's account exists and the password match...proceed
                            // echo json_encode($userdata);
                            
                            
                            $id = $userdata['id'];  
                            $_SESSION['user_id'] = $id;
                            echo $id;

                            $message = $id == 1 ? "Super Admin Login Success" : "Login success";
                            
                            $feedback = array("message" => $message, "code" => "sucess");
                            echo json_encode($feedback);
                            return $feedback;

                        }

                    }else{
                        //the user's account does not exist
                        $message = "Invalid credentials";
                        echo $message;
                        return json_encode([
                            "message" => $message,
                            "code" => "error"
                        ]);
                    }
                      
                    
                }catch(Exception $e){
                    return json_encode([
                        "message" => "Login not successful, please retry",
                        "code" => "error",
                        "reason" => $e
                    ]);
                }
            }
        }
        // med-cime




    }






?>