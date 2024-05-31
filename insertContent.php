<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Method: *");
    header("Access-Control-Allow-Headers: *");
    
    require "vendor/autoload.php";
    use Mynamespace\insertContent;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $data = file_get_contents("php://input");
        $request = json_decode($data);
        $authorFirstName = $request->authorFirstName;
        $authorLastName = $request->authorLastName;
        $authorEmail = $request->authorEmail;
        $noteTitle = $request->noteTitle;
        $noteContent = $request->noteContent;


        $insertContent = new insertContent();
        $insertContent -> insert($authorFirstName, $authorLastName, $authorEmail, $noteTitle, $noteContent);

    }

?>