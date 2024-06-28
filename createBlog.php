<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Method: *");
    header("Access-Control-Allow-Headers: *");
    
    require "vendor/autoload.php";
    use Mynamespace\create_blog;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $data = file_get_contents("php://input");
        $request = json_decode($data);
        $authorEmail = $request->authorEmail;
        $noteTitle = $request->noteTitle;
        $noteContent = $request->noteContent;
        $noteCategory = $request->noteCategory;


        $insertContent = new create_blog();
        $insertContent -> insertContent($authorEmail, $noteTitle, $noteContent, $noteCategory);

    }

?>