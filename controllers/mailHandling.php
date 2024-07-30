<?php
    namespace Mynamespace;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    use Dotenv\Dotenv; //file for environmetal variables
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Create an instance of Dotenv to load environment variables
    $dotenv->load(); // Load environment variables from .env file 

    class MailHandling {
        public function registrationMail($firstname, $email){
            require 'vendor/autoload.php';

            $mail = new PHPMailer(true); // Passing `true` enables exceptions
            // die(getenv('SMTP_PASSWORD'));

            try {
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $_ENV['SMTP_USERNAME'];               // SMTP username
                $mail->Password   = $_ENV['SMTP_PASSWORD'];                        // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
                $mail->Port       = 587;

                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                // Sender and recipient settings
                $mail->setFrom('henryokiyi8@gmail.com', 'henry');
                $mail->addAddress("$email", "$firstname");

                // Sending plain text email
                $mail->isHTML(false); // Set email format to plain text
                $mail->Subject = 'Greetings';
                $mail->Body    = "hi $firstname, welcome to Naijaoversabi";

                // Send the email
                $mail->send();
                if(!$mail->send()){
                    echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                } else {
                    echo 'Message has been sent';
                }
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        }
    }
    



?>