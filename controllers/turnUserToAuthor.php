<?php
    namespace Mynamespace;
    use Mynamespace\Configure;
    
    class TurnUserToAuthor{
        function userToAuthor($superAdminEmail, $userfname, $userlname, $useremail){
            $configuration = new Configure();
            $_conn = $configuration->config();


            trim($superAdminEmail);
            trim($userfname);
            trim($userlname);
            trim($useremail);
            mysqli_real_escape_string($_conn, trim($userfname));
            mysqli_real_escape_string($_conn, trim($userlname));
            // echo $superAdminEmail, $userfname, $userlname, $useremail, $userpassword;
            if(empty($superAdminEmail) || empty($userfname) || empty($userlname) || empty($useremail)){
                echo "invalid data";
                return json_encode([
                    "message" => "invaid data",
                    "error" => "invalid data"
                ]);
            }else{
                
                $checkIfSuperAdmin = "SELECT * FROM `admins` WHERE `id` = 1";
                $result = mysqli_query($_conn, $checkIfSuperAdmin);
                if($result){
                    $feedback = mysqli_fetch_assoc($result);
                    $verifiedSuperAdminEmail = json_decode(json_encode($feedback))->email;
                    // echo $superAdminEmail;
                    if($verifiedSuperAdminEmail == $superAdminEmail){
                        echo "working";
                        //yes...the verified super admin is the trying to make this function
                        //get the user details form the `users` table
            
                        $getUser = "SELECT * FROM `users` WHERE `firstname` = '$userfname'AND `lastname` = '$userlname' AND `email` = '$useremail'";
                        $result = mysqli_query($_conn, $getUser);
                        if($result){
                            $feedback = mysqli_fetch_assoc($result);
                            // echo json_encode($feedback);
                            if($feedback == null){
                                echo "User not found";
                            }else{
                                $firstname = json_decode(json_encode($feedback)) ->firstname;
                                $lastname = json_decode(json_encode($feedback)) ->lastname;
                                $email = json_decode(json_encode($feedback)) ->email;               
                                $password = json_decode(json_encode($feedback)) ->password;               
                                $insertIntoAdmins = "INSERT INTO `admins`(`firstname`, `lastname`, `email`, `password`, `role_id`, `status`) VALUES ('$firstname', '$lastname', '$email', '$password', 2, 0)";
                                $result = mysqli_query($_conn, $insertIntoAdmins);
                                if($result){
                                    //user has successfully been made an admin(author), next...delete the user from the `users` table
                                    $getUser = "DELETE FROM `users` WHERE `firstname` = '$firstname' AND `lastname` = '$lastname' AND `email` = '$email'";
                                    $result = mysqli_query($_conn, $getUser);
                                    if($result){
                                        echo "user table with firstname: $firstname, lastname: $lastname, and email: $email has successfully been made an Author admin";
                                        return json_encode([
                                            "messsage" => "user successfully made an admin(author)",
                                            "code" => "success"
                                        ]); 
                                    };
        
                                };
                            }
    
                        };
    
                    }else if($verifiedSuperAdminEmail !== $superAdminEmail){
                        //the super admin isn't the one making this request
                        echo "Unauthorized admin making request";
                        return json_encode([
                            "message" => "Unauthorized admin making request",
                            "error" => "unauthorized admin"
                        ]);
                    };
                    
                    
                };
            }
            
        }
    }
?>