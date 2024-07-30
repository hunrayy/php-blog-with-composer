<?php
    // namespace Mynamespace;
    // use Mynamespace\Configure;
    // use Mynamespace\Authorization;

    // use Cloudinary\Cloudinary;
    // use Cloudinary\Configuration\Configuration;

    // use Dotenv\Dotenv; //file for environmetal variables
    // $dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Create an instance of Dotenv to load environment variables
    // $dotenv->load(); // Load environment variables from .env file 

    // class Create_blog{

    //     private $cloudinary;

    //     public function __construct() {
    //         // Initialize Cloudinary with environment variables
    //         Configuration::instance([
    //             'cloud' => [
    //                 'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'],
    //                 'api_key'    => $_ENV['CLOUDINARY_API_KEY'],
    //                 'api_secret' => $_ENV['CLOUDINARY_API_SECRET'],
    //             ],
    //             'url' => [
    //                 'secure' => true // Ensure the URL is secure (https)
    //             ]
    //         ]);
    //         $this->cloudinary = new Cloudinary();
    //     }

    //     public function uploadImageToCloudinary($img_tmp_name) {
    //         // Upload the image to Cloudinary
    //         $response = $this->cloudinary->uploadApi()->upload($img_tmp_name);
    //         return $response['secure_url']; // Returns the URL of the uploaded image
    //     }

    //     // public function directory($img_name, $img_tmp_name){
    //     //     if(is_dir("images")){
    //     //         move_uploaded_file($img_tmp_name, "images/.$img_name");
    //     //     }else{
    //     //         mkdir("images");
    //     //         move_uploaded_file($img_tmp_name, "images/");
    //     //     }
    //     // }
        
    //     public function insertContent($authorEmail, $noteTitle, $noteContent, $image, $noteCategory){
    //         // echo "After loading environment variables"; // Debug statement
    //         die($_ENV['CLOUDINARY_CLOUD_NAME']);
    //         $configuration = new Configure();
    //         $_conn = $configuration->config();

    //         $authorEmail = mysqli_real_escape_string($_conn, trim($authorEmail));
    //         $noteTitle = mysqli_real_escape_string($_conn, trim($noteTitle));
    //         $noteContent = mysqli_real_escape_string($_conn, trim($noteContent));
    //         $noteCategory = mysqli_real_escape_string($_conn, trim($noteCategory));
    //         $img_name = $_FILES['image']['name'];
    //         $img_tmp_name = $_FILES['image']['tmp_name'];
    //         $img_extention = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

    //         $extentions_array = array("jpg", "jpeg", "png", "gif");
    //         if(!in_array($img_extention, $extentions_array)){
    //             echo "invalid image extention";
    //         };

    //         // Call the method to upload the image to Cloudinary
    //         $img_url = $this->uploadImageToCloudinary($img_tmp_name);



    //         // call on the directory function
    //         // $this->directory($img_name, $img_tmp_name);

    //         $authorization = new Authorization();
    //         $feedback = $authorization->validate_user($authorEmail);
    //         // data from $feedback would return either null or an array of privileges(array of numbers)
    //         // echo json_encode($feedback);
    //         $in_array = in_array(1, $feedback); //1 is the id privilege for creating article
    //         if($feedback == null){ 
    //             //unauthorized user trying to make request
    //             http_response_code(401);
    //             $message = "Unauthorized user making request";
    //             $response = array("status" => "Fail", "message" => $message);
    //             echo json_encode($response);
    //             return $response;
    //         }else if((int)$in_array == 0){ 
    //             //user is an admin but unauthorized to create article
    //             http_response_code(401);
    //             $message = "Unauthorized admin making request";
    //             $response = array("status" => "Fail", "message" => $message);
    //             echo json_encode($response);
    //             return $response;
    //         }else{
    //             try{
    //                 // fetch data from category table to get the id of the category picked
    //                 $sql = "SELECT * FROM `category` WHERE `category` = ?";
    //                 $query = mysqli_prepare($_conn, $sql);
    //                 mysqli_stmt_bind_param($query, "s", $noteCategory);
    //                 mysqli_execute($query);
    //                 $result = mysqli_stmt_get_result($query);
    //                 $feedback = mysqli_fetch_assoc($result);
    //                 if(!$feedback){
    //                     // user inputed a category that does not exist
    //                     $message = "Category does not exist";
    //                     $response = array("status" => "Fail", "message" => $message);
    //                     echo json_encode($response);
    //                     return $response;
    //                 }
    //                 $category_id = $feedback['id'];

    //                 //id of catgeory gotten...proceed to store article in the database
    //                 $user_id = $_SESSION['user_id'];
    //                 $sql = "INSERT INTO `articles`(`title`, `content`, `image`, `category_id`, `user_id(author)`) VALUES (?, ?, ?, ?, ?)";
    //                 $query = mysqli_prepare($_conn, $sql);
    //                 mysqli_stmt_bind_param($query, "sssii", $noteTitle, $noteContent, $img_url, $category_id, $user_id);
    //                 $feedback = mysqli_execute($query);
    //                 if(mysqli_stmt_affected_rows($query)){
    //                     http_response_code(401);
    //                     $message = "content successsfully uploaded";
    //                     $response = array("status" => "success", "message" => $message);
    //                     echo json_encode($response);
    //                     return $response;
    //                 }
    //             }catch(Exception $e){
    //                 $message = "Database error: " . $e->getMessage();
    //                 $response = array("status" => "error", "message" => $message);
    //                 echo json_encode($response);
    //             }
    //         }
        


    //     }
    // }











































    
    namespace Mynamespace;
    
    use Mynamespace\Configure;
    use Mynamespace\Authorization;
    use Cloudinary\Cloudinary;
    use Cloudinary\Configuration\Configuration;
    use Dotenv\Dotenv; // for environment variables
    
    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    // Debugging statement to verify the script's directory
    $currentDir = __DIR__;
    echo "Current directory: " . $currentDir . "<br>";
    
    // Calculate the path to the .env file
    $envFilePath = realpath($currentDir . '/../.env');
    echo "Looking for .env file at: " . $envFilePath . "<br>";
    
    if ($envFilePath === false || !file_exists($envFilePath)) {
        die(".env file not found at expected path.");
    }
    
    // Load environment variables
    try {
        $dotenv = Dotenv::createImmutable(dirname($envFilePath));
        $dotenv->load();
        echo "Environment variables loaded successfully.<br>";
    } catch (Exception $e) {
        die("Failed to load environment variables: " . $e->getMessage());
    }
    
    // Debugging statement to verify if .env file is loaded
    echo "Before loading environment variables<br>";
    echo "Cloudinary Cloud Name: " . ($_ENV['CLOUDINARY_CLOUD_NAME'] ?? 'Not Set') . "<br>";
    echo "Cloudinary API Key: " . ($_ENV['CLOUDINARY_API_KEY'] ?? 'Not Set') . "<br>";
    echo "Cloudinary API Secret: " . ($_ENV['CLOUDINARY_API_SECRET'] ?? 'Not Set') . "<br>";
    
    if (empty($_ENV['CLOUDINARY_CLOUD_NAME']) || empty($_ENV['CLOUDINARY_API_KEY']) || empty($_ENV['CLOUDINARY_API_SECRET'])) {
        die("Failed to load environment variables.");
    }
    
    class Create_blog {
    
        private $cloudinary;
    
        public function __construct() {
            // Initialize Cloudinary with environment variables
            try {
                $config = Configuration::instance([
                    'cloud' => [
                        'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'],
                        'api_key'    => $_ENV['CLOUDINARY_API_KEY'],
                        'api_secret' => $_ENV['CLOUDINARY_API_SECRET'],
                    ],
                    'url' => [
                        'secure' => true // Ensure the URL is secure (https)
                    ]
                ]);
                echo "Cloudinary configuration instance created.<br>";
                $config->validate();
                echo "Cloudinary configuration validated successfully.<br>";
    
                $this->cloudinary = new Cloudinary($config);
                echo "Cloudinary instance created successfully.<br>";
            } catch (Exception $e) {
                die("Cloudinary configuration failed: " . $e->getMessage());
            }
        }
    
        public function uploadImageToCloudinary($img_tmp_name) {
            // Upload the image to Cloudinary
            try {
                $response = $this->cloudinary->uploadApi()->upload($img_tmp_name);
                return $response['secure_url']; // Returns the URL of the uploaded image
            } catch (Exception $e) {
                die("Failed to upload image: " . $e->getMessage());
            }
        }
    
        public function insertContent($authorEmail, $noteTitle, $noteContent, $image, $noteCategory) {
            // Debugging statement to check environment variables during method execution
            echo "In insertContent method: " . $_ENV['CLOUDINARY_CLOUD_NAME'] . "<br>";
    
            $configuration = new Configure();
            $_conn = $configuration->config();
    
            $authorEmail = mysqli_real_escape_string($_conn, trim($authorEmail));
            $noteTitle = mysqli_real_escape_string($_conn, trim($noteTitle));
            $noteContent = mysqli_real_escape_string($_conn, trim($noteContent));
            $noteCategory = mysqli_real_escape_string($_conn, trim($noteCategory));
            $img_name = $_FILES['image']['name'];
            $img_tmp_name = $_FILES['image']['tmp_name'];
            $img_extention = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
    
            $extentions_array = array("jpg", "jpeg", "png", "gif");
            if (!in_array($img_extention, $extentions_array)) {
                echo "invalid image extention";
            }
    
            // Call the method to upload the image to Cloudinary
            $img_url = $this->uploadImageToCloudinary($img_tmp_name);
    
            $authorization = new Authorization();
            $feedback = $authorization->validate_user($authorEmail);
            $in_array = in_array(1, $feedback); // 1 is the id privilege for creating article
            if ($feedback == null) {
                // Unauthorized user trying to make request
                http_response_code(401);
                $message = "Unauthorized user making request";
                $response = array("status" => "Fail", "message" => $message);
                echo json_encode($response);
                return $response;
            } else if ((int)$in_array == 0) {
                // User is an admin but unauthorized to create article
                http_response_code(401);
                $message = "Unauthorized admin making request";
                $response = array("status" => "Fail", "message" => $message);
                echo json_encode($response);
                return $response;
            } else {
                try {
                    // Fetch data from category table to get the id of the category picked
                    $sql = "SELECT * FROM `category` WHERE `category` = ?";
                    $query = mysqli_prepare($_conn, $sql);
                    mysqli_stmt_bind_param($query, "s", $noteCategory);
                    mysqli_execute($query);
                    $result = mysqli_stmt_get_result($query);
                    $feedback = mysqli_fetch_assoc($result);
                    if (!$feedback) {
                        // User inputted a category that does not exist
                        $message = "Category does not exist";
                        $response = array("status" => "Fail", "message" => $message);
                        echo json_encode($response);
                        return $response;
                    }
                    $category_id = $feedback['id'];
    
                    // Id of category gotten...proceed to store article in the database
                    $user_id = $_SESSION['user_id'];
                    $sql = "INSERT INTO `articles`(`title`, `content`, `image`, `category_id`, `user_id(author)`) VALUES (?, ?, ?, ?, ?)";
                    $query = mysqli_prepare($_conn, $sql);
                    mysqli_stmt_bind_param($query, "sssii", $noteTitle, $noteContent, $img_url, $category_id, $user_id);
                    $feedback = mysqli_execute($query);
                    if (mysqli_stmt_affected_rows($query)) {
                        http_response_code(200);
                        $message = "Content successfully uploaded";
                        $response = array("status" => "success", "message" => $message);
                        echo json_encode($response);
                        return $response;
                    }
                } catch (Exception $e) {
                    $message = "Database error: " . $e->getMessage();
                    $response = array("status" => "error", "message" => $message);
                    echo json_encode($response);
                }
            }
        }
    }
    
    

    
?>