<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Method: *");
    header("Access-Control-Allow-Headers: *");

    require "vendor/autoload.php";
    use Mynamespace\turnUserToAuthor;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $data = file_get_contents("php://input");
        $request = json_decode($data);
        $superAdminEmail = $request->superAdminEmail; 
        $userfname = $request->userfname; 
        $userlname = $request->userlname; 
        $useremail = $request->useremail; 


        
        $turnUserToAuthor = new TurnUserToAuthor();
        $turnUserToAuthor -> userToAuthor($superAdminEmail, $userfname, $userlname, $useremail);

    }




    // arseeoctbcmtilcv
    // arseeoctbcmtilcv


?>