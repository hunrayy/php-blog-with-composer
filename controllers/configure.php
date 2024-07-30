<?php
    namespace Mynamespace;

    use Dotenv\Dotenv; //file for environmetal variables
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Create an instance of Dotenv to load environment variables
    $dotenv->load(); // Load environment variables from .env file 


    class Configure{
        public function config(){
            $_host = 'localhost';
            $_user = 'root';
            $_password = '';
            $_db = 'test';
            
            try{
                $_conn = mysqli_connect($_host, $_user, $_password, $_db);
                if($_conn){
                    // echo "connected";
                    return $_conn;
                }else{
                    echo "unable to connect";
                }
            
            }catch(Exception $e){
                echo $e. "unable to connect to database";
            } 
            
        }
    }


?>