<?php 
session_start();

//Set cookie délai
$number_of_days = 10;
$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days;

//Réinit SESSION
session_unset();
$_SESSION['FBID'] = NULL;
$_SESSION['FULLNAME'] = NULL;
$_SESSION['EMAIL'] =  NULL;
header("Location: http://cpro.jbh/controleur/cpro/controleurECI.php");        // you can enter home page here ( Eg : header("Location: " ."http://www.krizna.com"); 
$coderetour=setcookie("cookiecontroleurIndex", " ", $date_of_expiry, "/");
$coderetour=setcookie("cookieUser", $_SESSION['EMAIL'], $date_of_expiry, "/");        

?>
