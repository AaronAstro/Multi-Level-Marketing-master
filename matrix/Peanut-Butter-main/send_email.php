<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'phpmailer/src/Exception.php';
require_once 'phpmailer/src/PHPMailer.php';
require_once 'phpmailer/src/SMTP.php'; // Adjust the path to where you include PHPMailer

if (isset($_POST['submit_contact'])) {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    $body = "You have received a new message from $name.\n\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";

    $result = sendEmail($email, $name, 'chris24ncele@gmail.com', $subject, $body);

    if ($result === true) {
        echo "<script>
                alert('Sent successfully');
                document.location.href = 'contact.php';
            </script>";
    } else {
        echo $result;
    }
} else {
    echo "No data received.";
}

function sendEmail($fromEmail, $fromName, $toEmail, $subject, $body)
{
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'chris24ncele@gmail.com'; // SMTP username
        $mail->Password = 'awgu ixqr wcvw gqte'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($toEmail); // Add a recipient

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
