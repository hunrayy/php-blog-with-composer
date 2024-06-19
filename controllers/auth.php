<?php
    namespace Mynamespace;
    use Mynamespace\Configure;
    $session = session_start();

    class Auth{
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
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    $query = "INSERT INTO `users` (`firstname`, `lastname`, `email`, `password`) VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_prepare($_conn, $query);
                    mysqli_stmt_bind_param($stmt, "ssss", $firstname, $lastname, $email, $hashed_password);
                    $result = mysqli_execute($stmt);
                    if($result){
                        json_encode([
                            "code" => "success",
                            "message" => "Account successfully created"
                        ]);
                        echo "Account successfully created";
                    };
                    
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
                            $message = "Login Success";
                            echo $message;
                            
                            return json_encode([
                                "message" => $message,
                                "code" => "sucess"
                            ]);

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
                    echo "error $e";
                }
                // return json_encode([
                //     "message" => "All fields required",
                //     "code" => "error"
                // ]);
            }
        }




    }






?>