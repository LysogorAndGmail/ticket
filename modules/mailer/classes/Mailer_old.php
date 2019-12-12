<?
class Mailer {
    
    public static function send($to) {
        require 'PHPMailerAutoload.php';
        $mail = new PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'svitgo.com';  // Specify main and backup server
        $mail->SMTPAuth = false;                               // Enable SMTP authentication
        $mail->Username = 'noreply@svitgo.com';                            // SMTP username
        $mail->Password = 'Robot2012';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
        
        $mail->From = 'Lysogor@example.com';
        $mail->FromName = 'Mailer';
        $mail->addAddress($to);  // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        
        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mail->addAttachment('filename.pdf');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML
        
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        if(!$mail->send()) {
           echo 'Message could not be sent.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
           exit;
        }
        
        echo 'Message has been sent';
    }
}

