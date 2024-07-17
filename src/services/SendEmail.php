<?php 

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class SendEmail{

    private $mailer;
    public function __construct() {
        $this->mailer = new PHPMailer(true);
        // Configuration for PHPMailer
    }

    public function sendMail($to, $subject, $body) {
        //$mail = new PHPMailer(true); // Passing true enables exceptions
        try {
            // SMTP configuration
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'majdbitar2003@gmail.com'; // Your Gmail email address
            $this->mailer->Password = 'ucny xhuw fgfy dvog'; // Your Gmail password
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = 587;
            
            // Debug output
            //$this->mailer->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
            //$this->mailer->Debugoutput = 'html';

            // Email content
            $this->mailer->setFrom('majdbitar2003@gmail.com', 'Majd'); // Your name and email address
            $this->mailer->addAddress($to); // Recipient email address
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            // Send email
            $this->mailer->send();
            return true; // Email sent successfully
        } catch (Exception $e) {
            return $e->getMessage(); // Return error message
        }
    }
}
?>