<?
class Mailer {
    
    public static function send($from,$from_name,$to,$conf,$files_array,$sub,$mes) {
        require 'PHPMailerAutoload.php';
        $mail = new PHPMailer;
        //$mail->setLanguage('ru', 'language/');
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $conf['host'];  // Specify main and backup server
        $mail->SMTPAuth = $conf['auth'];                               // Enable SMTP authentication
        $mail->Username =  $conf['username'];                             // SMTP username
        $mail->Password =  $conf['pass'];                           // SMTP password
        $mail->SMTPSecure =  $conf['secure']; 
        //$mail->SMTPPort = 25;                            // Enable encryption, 'ssl' also accepted
        $mail->From = $from;
        $mail->FromName = $from_name;
        $mail->addAddress($to);  // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        $mail->WordWrap = 50;  
        //foreach($files_array as $t){
        //    $mail->addAttachment('pdf_tikets/'.$t.'.pdf'); //$mail->addAttachment('pdf_tikets/'.$t.'.pdf');
        //} 
                                  // Set word wrap to 50 characters
        // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $sub;
        $mail->Body    = $mes;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        if(!$mail->send()) {
           echo 'Message could not be sent.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
           exit;
           return false;
        }else{
            return true;
        }
        //echo 'Message has been sent';
    }
    
     public static function send_simple($from,$to,$conf,$sub,$mes) {
        require 'PHPMailerAutoload.php';
        
        
        $mail = new PHPMailer;
        //$mail->setLanguage('ru', 'language/');
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $conf['host'];  // Specify main and backup server
        $mail->SMTPAuth = $conf['auth'];                               // Enable SMTP authentication
        $mail->Username =  $conf['username'];                             // SMTP username
        $mail->Password =  $conf['pass'];                           // SMTP password
        $mail->SMTPSecure =  $conf['secure']; 
        //$mail->SMTPPort = 25;                            // Enable encryption, 'ssl' also accepted
        $mail->From = $from;
        $mail->FromName = $from;
        $mail->addAddress($to);  // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        $mail->WordWrap = 50;   
        // print_r($tik_array);
        //die;                         // Set word wrap to 50 characters
        // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $sub;
        $mail->Body    = $mes;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        if(!$mail->send()) {
           echo 'Message could not be sent.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
           exit;
           return false;
        }else{
            return true;
        }
        //echo 'Message has been sent';
    }
}

