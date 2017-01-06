<?php
header('Access-Control-Allow-Headers: x-requested-with');
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html;charset=UTF-8');

// Define some constants
define("RECIPIENT_NAME", "Gale Press");
define("EMAIL_SUBJECT", "Gale Press Iletisim Formu");

// Read the form values
$success = false;
//$xhr          = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
$xhr = isset($_POST['ajax'])
        ? true
        : false;
$senderName = isset($_POST['senderName'])
        ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", '', $_POST['senderName'])
        : '';
$senderEmail = isset($_POST['senderEmail'])
        ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", '', $_POST['senderEmail'])
        : '';
$subject = isset($_POST['subject'])
        ? preg_replace("/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", '', $_POST['subject'])
        : EMAIL_SUBJECT;
$comment = isset($_POST['comment'])
        ? preg_replace("/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", '', $_POST['comment'])
        : '';

// If all values exist, send the email
if ($senderName && $senderEmail && $comment) {
    $recipient = RECIPIENT_NAME . " <" . (string)__('maillang.contanct_email') . ">";
    $headers = "From: " . $senderName . " <" . $senderEmail . ">";
    try {
        Bundle::start('messages');
        $toEmail = (string)__('maillang.contanct_email');
        $toName = RECIPIENT_NAME;
        if (Message::send(function ($m) use ($toEmail, $toName, $senderEmail, $senderName, $subject, $comment) {
            /** @var  $m \Swiftmailer\Drivers\SMTP */
            $m->from($senderEmail, $senderName);
            //$m->to($toEmail);
            $m->to($toEmail, $toName);
            $m->subject($subject);
            $m->body($comment);
        })
        ) {
            $success = 'success';
        } else {
            $success = 'error: incomplete data';
        }
    } catch (Exception $e) {
        $success = $e->getMessage();
    }
} else {
    $success = 'error: incomplete data';
}

// Return an appropriate response to the browser
if ( $xhr ) : // AJAX Request
    echo $success;

else : // HTTP Request ?>
        <!doctype html>
<html>
<head>
    <title>Thanks!</title>
</head>
<body>
<?php if ( $success == 'success') : ?>
<p>Thanks for sending your message! We'll get back to you shortly.</p>
<?php else: ?>
<p>There was a problem sending your message. Please try again.</p>
<?php endif; ?>
<p>Click your browser's Back button to return to the page.</p>
</body>
</html>
<?php endif; ?>