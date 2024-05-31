<?php
    namespace Mynamespace;
    use Mynamespace\Configure;

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
                    $query = "INSERT INTO `users` (`firstname`, `lastname`, `email`, `password`) VALUES ('$firstname', '$lastname', '$email', SHA('$password'))";
                    $result = mysqli_query($_conn, $query);
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




    }






?>