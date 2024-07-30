<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Method: *");
    header("Access-Control-Allow-Headers: *");
    
    require "vendor/autoload.php";
    use Mynamespace\create_blog;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // $data = file_get_contents("php://input");
        // $request = json_decode($data);
        // $authorEmail = $request->authorEmail;
        // $noteTitle = $request->noteTitle;
        // $noteContent = $request->noteContent;
        // $image = $request->image;
        // $noteCategory = $request->noteCategory;


        // $insertContent = new create_blog();
        // $insertContent -> insertContent($authorEmail, $noteTitle, $noteContent, $image, $noteCategory);

        $authorEmail = $_POST['authorEmail'];
        $noteTitle = $_POST['noteTitle'];
        $noteContent = $_POST['noteContent'];
        $noteCategory = $_POST['category'];
        $image = $_FILES['image'];

        $insertContent = new create_blog();
        $insertContent -> insertContent($authorEmail, $noteTitle, $noteContent, $image, $noteCategory);

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
    <form action="/composer-sample/createBlog.php" method="POST" enctype="multipart/form-data">
        <label>Author's email:</label>
        <input type="text" name="authorEmail"><br>

        <label>Title:</label>
        <input type="text" name="noteTitle"><br>

        <label>Content:</label>
        <input type="text" name="noteContent"><br>

        <label>Image:</label>
        <input type="file" name="image"><br>

        <label>Category:</label>
        <input type="text" name="category"><br>

        <button>create</button>
    </form>
    
</body>
</html>