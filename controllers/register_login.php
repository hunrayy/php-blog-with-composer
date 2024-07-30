<?php
    namespace Mynamespace;
    use Mynamespace\Configure;
    use Mynamespace\MailHandling;
    
    session_start();

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

        // login function
        public function login($email, $password) {
            $configuration = new Configure();
            $_conn = $configuration->config();
    
            if (empty($email) || empty($password)) {
                $message = "All fields required";
                echo json_encode([
                    "message" => $message,
                    "code" => "error"
                ]);
                return;
            } else {
                $email = mysqli_real_escape_string($_conn, trim($email));
                $password = mysqli_real_escape_string($_conn, trim($password));
    
                try {
                    $query = "SELECT * FROM `users` WHERE `email` = ? LIMIT 1";
                    $stmt = mysqli_prepare($_conn, $query);
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
    
                    if (mysqli_num_rows($result) == 1) {
                        $userdata = mysqli_fetch_assoc($result);
                        $stored_password = $userdata['password'];
    
                        if (!password_verify($password, $stored_password)) {
                            $message = "Invalid credentials";
                            echo json_encode([
                                "message" => $message,
                                "code" => "error"
                            ]);
                            return;
                        } else {
                            $id = $userdata['id'];
                            $_SESSION['user_id'] = $id;
                            $_SESSION['user_email'] = $email;
                            $_SESSION['user_role'] = $userdata['role_id'];
    
                            $message = $id == 1 ? "Super Admin Login Success" : "Login success";
                            setcookie(session_name(), session_id(), time() + 3600, "/");
    
                            echo json_encode([
                                "message" => $message,
                                "code" => "success"
                            ]);
                            return;
                        }
                    } else {
                        $message = "Invalid credentials";
                        echo json_encode([
                            "message" => $message,
                            "code" => "error"
                        ]);
                        return;
                    }
                } catch (Exception $e) {
                    echo json_encode([
                        "message" => "Login not successful, please retry",
                        "code" => "error",
                        "reason" => $e->getMessage()
                    ]);
                    return;
                }
            }
        }





    }






?>