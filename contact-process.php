<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Enable error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 🛡️ Honeypot check (anti-spam)
    if (!empty($_POST['honeypot'])) {
        exit;
    }

    // 🧹 Sanitize form data
    $name     = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email    = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone    = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $website  = htmlspecialchars(trim($_POST['website'] ?? ''));
    $package  = htmlspecialchars(trim($_POST['package'] ?? ''));
    $message  = htmlspecialchars(trim($_POST['message'] ?? ''));

    // ✅ Replace with your business email
    $admin_email = "info@digitallyfuture.com";

    try {
        // ===========================
        // 1️⃣ SEND EMAIL TO ADMIN
        // ===========================
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@digitallyfuture.com';
        $mail->Password   = 'Digitallyfuture@2025';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SSL (recommended)
        $mail->Port       = 465;

        $mail->setFrom('info@digitallyfuture.com', 'Digitally Future Website');
        $mail->addAddress($admin_email);
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);
        $mail->Subject = "📩 New YouTube Ads Strategy Request from {$name}";
        $mail->Body = "
            <h2>🎯 New YouTube Ads Strategy Request</h2>
            <table border='1' cellpadding='6' cellspacing='0' style='border-collapse:collapse;'>
                <tr><td><strong>Name:</strong></td><td>{$name}</td></tr>
                <tr><td><strong>Email:</strong></td><td>{$email}</td></tr>
                <tr><td><strong>Phone:</strong></td><td>{$phone}</td></tr>
                <tr><td><strong>Website:</strong></td><td>{$website}</td></tr>
                <tr><td><strong>Selected Package:</strong></td><td>{$package}</td></tr>
                <tr><td><strong>Message:</strong></td><td>".nl2br($message)."</td></tr>
            </table>
            <p style='font-size:14px;color:#555;'>Submitted from: <strong>Digitally Future Website</strong></p>
        ";

        $mail->send(); // Send admin email

        // ===========================
        // 2️⃣ SEND CONFIRMATION TO USER
        // ===========================
        $confirm = new PHPMailer(true);
        $confirm->isSMTP();
        $confirm->Host       = 'smtp.hostinger.com';
        $confirm->SMTPAuth   = true;
        $confirm->Username   = 'info@digitallyfuture.com';
        $confirm->Password   = 'Digitallyfuture@2025';
        $confirm->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $confirm->Port       = 465;

        $confirm->setFrom('info@digitallyfuture.com', 'Digitally Future');
        $confirm->addAddress($email);
        $confirm->isHTML(true);
        $confirm->Subject = "✅ We’ve received your YouTube Ads Strategy Request";
        $confirm->Body = "
            <p>Hi <strong>{$name}</strong>,</p>
            <p>Thank you for requesting your <strong>Free YouTube Ads Strategy</strong> with <strong>Digitally Future</strong>!</p>
            <p>Our digital marketing experts will review your website (<a href='{$website}'>{$website}</a>) and business goals soon.</p>
            <p>We’ll contact you shortly to discuss the best plan for your growth.</p>
            <br>
            <p>Best Regards,<br>
            <strong>Digitally Future Team</strong><br>
            📞 +91 8800209359<br>
            🌐 <a href='https://digitallyfuture.com'>digitallyfuture.com</a></p>
        ";

        $confirm->send();

        // 🟢 Success message
        echo "🎉 Thank you, {$name}! Your YouTube Ads Strategy request has been sent successfully. Our team will contact you soon.";

    } catch (Exception $e) {
        error_log("Mailer Error: " . $e->getMessage());
        echo "⚠️ Sorry, something went wrong. Please try again later.";
    }
}
?>
