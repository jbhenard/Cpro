<?php
//session_start();
include_once("src/Google_Client.php");
include_once("src/contrib/Google_Oauth2Service.php");
######### edit details ##########
$clientId = '513076305354-d2k2t35o5rdil5kto6l1kuqdp77n737s.apps.googleusercontent.com'; //Google CLIENT ID
//			'699131445082-3mo6iikv7qabnhml91jqe3c3ba1e0m5c.apps.googleusercontent.com' //api google v2
$clientSecret = 'dHPf7Q92NYvRWSnCZUcYaXWs'; //Google CLIENT SECRET 
// v2 Mk4R3jZVbd3ycpu-vXw1D88_
$redirectUrl = 'http://localhost/Racine_Site/controleur/cpro/controleurECI.php';  //return url (url to script)
$homeUrl = 'http://localhost/Racine_site/cpro.php';  //return to home

##################################

$gClient = new Google_Client();
$gClient->setApplicationName('Login to Cpro.com');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectUrl);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>