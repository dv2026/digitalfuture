<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email   = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone   = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $company = htmlspecialchars(trim($_POST['company'] ?? ''));
    $service = htmlspecialchars(trim($_POST['service'] ?? ''));
    $budget  = htmlspecialchars(trim($_POST['budget'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    if (!$name || !$email || !$phone || !$message) {
        echo json_encode(["status" => "error", "message" => "Please fill all required fields."]);
        exit;
    }

    $admin_email = "info@digitallyfuture.com";

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@digitallyfuture.com';
        $mail->Password   = 'Digitallyfuture@2025';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('info@digitallyfuture.com', 'Digitally Future Website');
        $mail->addAddress($admin_email);
        $mail->addReplyTo($email, $name);
        $mail->isHTML(true);
        $mail->Subject = "📩 New Contact Form Submission from {$name}";
        $mail->Body = "
            <h2>New Contact Form Submission</h2>
            <table border='1' cellpadding='6' cellspacing='0' style='border-collapse:collapse'>
                <tr><td><strong>Name:</strong></td><td>{$name}</td></tr>
                <tr><td><strong>Email:</strong></td><td>{$email}</td></tr>
                <tr><td><strong>Phone:</strong></td><td>{$phone}</td></tr>
                <tr><td><strong>Company:</strong></td><td>{$company}</td></tr>
                <tr><td><strong>Service:</strong></td><td>{$service}</td></tr>
                <tr><td><strong>Budget:</strong></td><td>{$budget}</td></tr>
                <tr><td><strong>Message:</strong></td><td>".nl2br($message)."</td></tr>
            </table>
        ";

        $mail->send();

        echo json_encode([
            "status" => "success",
            "message" => "🎉 Thank you, {$name}! Your message has been sent successfully. We'll contact you soon."
        ]);

    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => "⚠️ Mailer Error: " . $e->getMessage()
        ]);
    }
}
?>
