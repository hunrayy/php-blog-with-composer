<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Method: *");
    header("Access-Control-Allow-Headers: *");

    require "vendor/autoload.php";
    use Mynamespace\register_login;


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $data = file_get_contents("php://input");
        $email = json_decode($data)->email;
        $password = json_decode($data)->password;
        $auth = new register_login();
        $auth -> login($email, $password);
    }



?>