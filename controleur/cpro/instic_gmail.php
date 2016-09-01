<?php

session_start();

$parametres=$_SESSION['tab'];

$user=$parametres['mail']['user'];
$message=$parametres['mail']['message'];
$id=$parametres['mail']['id'];            
$sujet= $parametres['mail']['sujet'];

 /**
  * This example shows settings to use when sending via Google's Gmail servers.
  */

 //SMTP needs accurate times, and the PHP time zone MUST be set
 //This should be done in your php.ini, but this is how to do it if you don't have access to that
 date_default_timezone_set('Etc/UTC');

 require '../../phpmailer/PHPMailerAutoload.php';

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
 $mail->Host = 'smtp.gmail.com';
 // use
 // $mail->Host = gethostbyname('smtp.gmail.com');
 // if your network does not support SMTP over IPv6

 //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
 $mail->Port = 587;

 //Set the encryption system to use - ssl (deprecated) or tls
 $mail->SMTPSecure = 'tls';

 //Whether to use SMTP authentication
 $mail->SMTPAuth = true;

 //Username to use for SMTP authentication - use full email address for gmail
 $mail->Username = "jb.henard14@gmail.com";

 //Password to use for SMTP authentication
 $mail->Password = "jb14081971";

 //Set who the message is to be sent from
 $mail->setFrom('jb.henard14@gmail.com', 'Emmeteur CTI');

 //Set an alternative reply-to address
 $mail->addReplyTo('jb.henard14@gmail.com', 'Emmeteur CTI bis');

 //Set who the message is to be sent to
 //$mail->addAddress('jbhenard@free.fr', 'JohnB HENARD');
 
 //echo '<br/> le destinataire est '.$destinataire;
 $mail->addAddress($user, $id);

 //Set the subject line
 $mail->Subject = $sujet;

 //Read an HTML message body from an external file, convert referenced images to embedded,
 //convert HTML into a basic plain-text alternative body
 //$mail->msgHTML(file_get_contents('essai.html'), dirname(__FILE__));
 
 $mail->Body = $message;
 //Replace the plain text body with one created manually
 $mail->AltBody = 'Test 2 JB HENARD';

 //Attach an image file
 $mail->addAttachment('jbh.pdf');

 //send the message, check for errors
 if (!$mail->send()) {
         $errsMDP = "Mailer Error: " . $mail->ErrorInfo;
         die();
 } else {
        $errsMDP = "Message sent!";        
        header("Location: http://localhost/Racine_Site/vue/cpro/controleurMDP.php");
        die();
 }