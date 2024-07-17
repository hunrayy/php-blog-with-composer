<?php
    namespace Mynamespace;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    use Dotenv\Dotenv; //file for environmetal variables
    $dotenv = Dotenv::createImmutable(__DIR__); // Create an instance of Dotenv to load environment variables
    $dotenv->load(); // Load environment variables from .env file 

    class MailHandling {
        public function registrationMail($firstname, $email){
            require 'vendor/autoload.php';

            // Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);
        
            try {
                //Server settings
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $_ENV['SMPT_USERNAME'];               // SMTP username
                $mail->Password   = $_ENV['SMPT_PASSWORD'];                        // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        
                // $mail->SMTPOptions = array(
                //     'ssl' => array(
                //         'verify_peer' => true,
                //         'verify_peer_name' => true,
                //         // 'allow_self_signed' => true
                //     )
                // );
                //Recipients
                $mail->setFrom('henryokiyi8@gmail.com', 'Naijaoversabi');
                $mail->addAddress("$email");     // Add a recipient
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Greetings';
                $mail->Body    = "<p>Hi $firstname, welcome to the Naijaoversabi</p>";
        
                $mail->send();
                echo 'Email has been sent successfully';
            } catch (Exception $e) {
                echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
    








?>