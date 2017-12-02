<?php
/**
 * This example shows making an SMTP connection with authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
//date_default_timezone_set('Etc/UTC');

require '../PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = "md-in-58.webhostbox.net";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 465;
//smtp sERVER
$mail->SMTPSecure = 'ssl';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = "no-reply@icrtes2017.gcoej.ac.in";
//Password to use for SMTP authentication
$mail->Password = "y3zwib9kR1%r";
//Set who the message is to be sent from
$mail->setFrom('no-reply@icrtes2017.gcoej.ac.in', 'ICRTES 2017');
//Set an alternative reply-to address
$mail->addReplyTo('icrtes2017@gcoej.ac.in', 'ICRTES 2017');
//Set who the message is to be sent to
$mail->addAddress('rizwansyed820@gmail.com', 'Rizwan Syed');

//Set the subject line
$mail->Subject = 'ICRTES 2017 SMTP Test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML("Congratulations!!!<br><p>You have successfully configured the SMTP Auto generated Mail.</p><b>Developed By Sofware Development Cell, Computer Department, GCoE, Jalgaon</b>");
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";

}
