<?php
    namespace Mynamespace;
    class Configure{
        public function config(){
            $_host = "localhost";
            $_user = "root";
            $_password = "";
            $_db = "store_db";
            
            try{
                $_conn = mysqli_connect($_host, $_user, $_password, $_db);
                if($_conn){
                    echo "connected";
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