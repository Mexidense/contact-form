<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

// load .env
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

try {
    if (isset($_POST['name']) && isset($_POST[ 'email'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $service = '';
        $message = '';

        if (isset($_POST['service']) && isset($_POST['message'])) {
            $service = $_POST['service'];
            $message = $_POST['message'];
        }

        //Server settings
        $mail->SMTPDebug = 2;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = getenv('HOST_EMAIL');  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = getenv('USER_EMAIL');                     // SMTP username
        $mail->Password   = getenv('PASSWORD_EMAIL');                               // SMTP password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('to@example.com', 'Receiver name');     // Add a recipient


        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Contact from host.com about ' . empty($service) ?: 'general topic';
        $mail->Body    = $message;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    }  
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
