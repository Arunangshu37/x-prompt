<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
require_once __DIR__ . './PHPMailer.php';
require_once __DIR__ . './MailException.php';
require_once __DIR__ . './SMTP.php';

class EmailSender
{
    public function sendEmail($recepient, $subject, $body) : Int
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'arunangshu.biswas.x@gmail.com';                     //SMTP username
            $mail->Password   = 'ntaceidprthmgxmi';                               //SMTP password
            $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('arunangshu.biswas.x@gmail.com', 'x-prompt');
            $mail->addAddress($recepient, 'Arunangshu Biswas');     //Add a recipient
            // $mail->addAddress('arunangshu.biswas.x@gmail.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            // //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return 1;
        } catch (MailException $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return 0;
        }
    }
}
//Create an instance; passing `true` enables exceptions
?>
