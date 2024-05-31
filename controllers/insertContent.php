<?php
    namespace Mynamespace;
    use Mynamespace\Configure;

    class InsertContent{
        public function insert($authorFirstName, $authorLastName, $authorEmail, $noteTitle, $noteContent){
            $configuration = new Configure();
            $_conn = $configuration->config();
    
            $getAdmin = "SELECT * FROM `admins` WHERE `firstname` = '$authorFirstName' AND `lastname` = '$authorLastName' AND `email` = '$authorEmail' AND `role_id` = 2";
            $result = mysqli_query($_conn, $getAdmin);
            if(mysqli_num_rows($result) == 1){
                $feedback = mysqli_fetch_assoc($result);
                // echo json_encode($feedback);
    
                //insert content into database
    
                $id = json_decode(json_encode($feedback)) -> id;
                $insert = "INSERT INTO `authors`(`title`, `content`, `admin_id`) VALUES ('$noteTitle', '$noteContent', '$id')";
                $result = mysqli_query($_conn, $insert);
                if($result){
                    echo "note successfully uploaded";
                    return json_encode([
                        "message" => "note successfully uploaded",
                        "code" => "success"
                    ]);
                }
            }else{
                echo "unauthorized admin making request";
                return json_encode([
                    "message" => "unauthorized admin making request",
                    "code" => "error"
                ]);
            }
    
        }
    }

?>