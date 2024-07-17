<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Method: *");
    header("Access-Control-Allow-Headers: *");

    require "vendor/autoload.php";
    use Mynamespace\register_login;


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $data = file_get_contents("php://input");
        $request = json_decode($data);
        $firstname = $request -> firstname;
        $lastname = $request -> lastname;
        $email = $request -> email;
        $password = $request -> password;

        $auth = new register_login();
        $auth -> register($firstname, $lastname, $email, $password);
        
    }










?>