<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Method: *");
    header("Access-Control-Allow-Headers: *");

    require "vendor/autoload.php";
    use Mynamespace\register_login;


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // $data = file_get_contents("php://input");
        // $email = json_decode($data)->email;
        // $password = json_decode($data)->password;


        $email = $_POST['email'];
        $password = $_POST['password'];
        $auth = new register_login();
        $auth -> login($email, $password);
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
    <form action="/composer-sample/login.php" method="POST" enctype="multipart/form-data">
        <h3>Login</h3>
        <label>email:</label>
        <input type="email" name="email"><br>

        <label>password:</label>
        <input type="password" name="password"><br>

        <button>Login</button>
    </form>
    
</body>
</html>