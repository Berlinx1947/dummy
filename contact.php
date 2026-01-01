<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$receiving_email_address = 'info@docbillsolutions.com';

$first_name = ($_POST['first_name']);
$last_name = ($_POST['last_name']);
$email = ($_POST['email']);
$message = ($_POST['message']);

if ($first_name && $last_name && $email && $message) {
    $phpmailer = new PHPMailer(true);

    try {
        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = '74be516d125733';
        $phpmailer->Password = '246f783456d5bb';

        $phpmailer->setFrom($email, $first_name . ' ' . $last_name);
        $phpmailer->addAddress($receiving_email_address);
        $phpmailer->addReplyTo($email, $first_name . ' ' . $last_name);

        $phpmailer->isHTML(true);
        $phpmailer->Subject = 'New Inquiry from DocBillSolutions Website';
        $phpmailer->Body = "
        <html>
        <head>
          <style>
            body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
            h3 { color: #0056b3; }
            p { margin: 8px 0; }
            .label { font-weight: bold; }
            .message { margin-top: 10px; padding: 10px; background-color: #f9f9f9; border-left: 3px solid #0056b3; }
          </style>
        </head>
        <body>
          <h3>New Message Received from DocBillSolutions Website</h3>
          <p><span class='label'>Name:</span> {$first_name} {$last_name}</p>
          <p><span class='label'>Email:</span> {$email}</p>
          <p><span class='label'>Message:</span></p>
          <div class='message'>" . nl2br(htmlspecialchars($message)) . "</div>
        </body>
        </html>
        ";

        $phpmailer->send();
        echo json_encode(['status' => 'success', 'message' => 'Your message has been sent. Thank you!']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => "Message could not be sent. Mailer Error: {$phpmailer->ErrorInfo}"]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
}
?>
