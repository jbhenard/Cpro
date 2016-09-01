<?php
session_start();
// added in v4.0.0
require_once 'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
// init app with app id and secret
FacebookSession::setDefaultApplication( '566253266895248','7a11634af77c2bb3873be094b29c5fdd' );
// login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper('http://cpro.jbh/FacebookLogin/fbconfig.php');
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me?fields=id,name,email' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject();
     	$fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 	    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
	    $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
	/* ---- Session Variables -----*/
	    $_SESSION['FBID'] = $fbid;           
        $_SESSION['FULLNAME'] = $fbfullname;
	    $_SESSION['EMAIL'] =  $femail;
    /* ---- header location after session ----*/
	header("Location: http://cpro.jbh/controleur/cpro/controleurECI.php");
  	//Set cookie délai
	$number_of_days = 10;
	$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days;
	$coderetour=setcookie("cookiecontroleurIndex", " ", $date_of_expiry, "/");
	$coderetour=setcookie("cookieUser", $_SESSION['EMAIL'], $date_of_expiry, "/");        

} else {
 	$loginUrl = $helper->getLoginUrl();
 	header("Location: ".$loginUrl);
 	//Set cookie délai
	$number_of_days = 10;
	$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days;
	$coderetour=setcookie("cookiecontroleurIndex", " ", $date_of_expiry, "/");
	$coderetour=setcookie("cookieUser", $_SESSION['EMAIL'], $date_of_expiry, "/");   
}
?>