<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Method: *");
    header("Access-Control-Allow-Headers: *");

    require "vendor/autoload.php";
    use Mynamespace\getCategories;


    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $data = file_get_contents("php://input");
        $feedback = new getCategories();
        $feedback -> getCategories();
    }

?>