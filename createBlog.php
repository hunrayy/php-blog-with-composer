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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form id="createBlogForm" method="POST">
        <label for="authorEmail">Title:</label>
        <input type="text"><br>
        <label for="authorEmail">Content:</label>
        <input type="text"><br>
        <label for="authorEmail">Title:</label>
        <input type="text"><br>
    </form>
    
</body>
</html>