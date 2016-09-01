<?php
include_once('../../controleur/cpro/fonctions.php');

$parametres=$_SESSION['tab'];

$user    		=$parametres['mail']['user'];
$message 		=$parametres['mail']['message'];
$id      		=$parametres['mail']['id'];            
$sujet   		=$parametres['mail']['sujet'];
$idmail  		=$parametres['mail']['idmail'];
$libelle 		=$parametres['mail']['libelle'];

$mdp  	 		=isset($parametres['mail']['mdp']) ? $parametres['mail']['mdp'] : '';
$varmdp			=isset($parametres['mail']['varmdp']) ? $parametres['mail']['varmdp'] : '';

$varnomprenom 	=$parametres['mail']['varnomprenom'];
$varidentifiant	=isset($parametres['mail']['varidentifiant']) ? $parametres['mail']['varidentifiant'] : '' ;

$varformation1	=isset($parametres['mail']['varformation1']) ? $parametres['mail']['varformation1'] : '';
$varformation2	=isset($parametres['mail']['varformation2']) ? $parametres['mail']['varformation2'] : '';
$vardateentretien= isset($parametres['mail']['vardateentretien']) ? $parametres['mail']['vardateentretien'] : '';

$formation1= isset($parametres['mail']['formation1']) ? $parametres['mail']['formation1'] : '';
$formation2= isset($parametres['mail']['formation2']) ? $parametres['mail']['formation2'] : '';
$dateentretien= isset($parametres['mail']['dateentretien']) ? $parametres['mail']['dateentretien'] : '';
 
//echo('Dt entretien dans Gmail:').$dateentretien;
//die();
 
//echo("Utilisateur recu: ") .$user;
//echo(" - Id Utilisateur: ") .$id;
//die();
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
 $mail->addReplyTo('messages@instic.fr', utf8_decode('Boîte courriels CTI'));

 //Set who the message is to be sent to
 //$mail->addAddress('jbhenard@free.fr', 'JohnB HENARD');
 
 //echo '<br/> le destinataire est '.$destinataire;
 $mail->addAddress($user, utf8_decode($id));

 //Set the subject line
 $mail->Subject = utf8_decode($sujet);

//Appel fonction qui Màj les variables "[nom variable]" du fichier html de type mail (voir tbmail)
$nomficmodele='../../vue/cpro/'.$idmail.'.html';
$coderetourhtml1=majhmtl_Mail($nomficmodele); //pour [NOMPrenom], pour tous les mails

if ($idmail == 'mail1') {
	$coderetourhtml2=majhmtl_Mail1a('../../vue/cpro/mail12a.html'); //pour [IDENTIFIANT], pour mail 1
	$coderetourhtml3=majhmtl_Mail1b('../../vue/cpro/mail12b.html'); //pour [MDP], pour mail 1	
}

if ($idmail == 'mail5' || $idmail == 'mail6' || $idmail == 'mail7' || $idmail == 'mail8' || $idmail == 'mail9') {
	$coderetourhtml3=majhmtl_Mail5a('../../vue/cpro/mail12a.html'); //pour [FORMATION1], pour mail 5, 6, ...
	$coderetourhtml3=majhmtl_Mail5b('../../vue/cpro/mail12b.html'); //pour [FORMATION2], pour mail 5, 6, ...
}

if ($idmail == 'mail9') {
	$coderetourhtml3=majhmtl_Mail9b2('../../vue/cpro/mail12c.html'); //pour [DATE ENTRETIEN] que pour mail 9.
}

 //Read an HTML message body from an external file, convert referenced images to embedded,
 //convert HTML into a basic plain-text alternative body
 //$mail->msgHTML(file_get_contents('../../vue/cpro/mail12.html'), dirname(__FILE__));
 //$cheminmail='../../vue/cpro/'.$idmail.'.html';
 
 //C'est un fichier constante dont la dernière lettre est liée à la dernière variable ici 2 appels (a et b) pour MàJ de 2 variables!
 if ($idmail != 'mail1' && $idmail != 'mail5' && $idmail != 'mail6' && $idmail != 'mail7' && $idmail != 'mail8' && $idmail != 'mail9') {
 	 $cheminmail='../../vue/cpro/mail12a.html';  //Si un paramètre
 } else $cheminmail='../../vue/cpro/mail12c.html'; //Si 3 paramètres
 
 if ($idmail == 'mail9') {
 	$cheminmail='../../vue/cpro/mail12c2.html'; //Si 4 paramètres
 }
 
 $mail->msgHTML(file_get_contents($cheminmail), dirname(__FILE__));
 //$mail->msgHTML(file_get_contents('../../vue/cpro/mail12.html'), dirname(__FILE__));
 
 //champ variable NOM_Prénom
 $message1=str_replace("[NOM_Prénom]",$id,$message);
 
 //$mail->Body = utf8_decode($message1);
 //Replace the plain text body with one created manually
 $mail->AltBody = 'Site Cpro.jbh by JB HENARD';

 //Attach an image file
 $mail->addAttachment('../../documents/jbh.pdf');

 //send the message, check for errors
 if (!$mail->send()) {
	$errsMDP['RCGmail'][] = $libelle." - Mailer Error: " . $mail->ErrorInfo;
  
 } else {
    $errsMDP['RCGmail'][] = $libelle." - bien envoyé";
  
 }