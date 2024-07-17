<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true); // Passing true enables exceptions

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'majdbitar2003@gmail.com'; // Your Gmail email address
        $mail->Password = 'ucny xhuw fgfy dvog'; // Your Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Debug output
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
        $mail->Debugoutput = 'html';

        // Email content
        $mail->setFrom('majdbitar2003@gmail.com', 'Majd'); // Your name and email address
        $mail->addAddress($to); // Recipient email address
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Send email
        $mail->send();
        return true; // Email sent successfully
    } catch (Exception $e) {
        return $e->getMessage(); // Return error message
    }
}

?>