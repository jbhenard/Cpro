<?php
require_once __DIR__ . '/../vendor/autoload.php';

//Create the Facebook service
$fb = new Facebook\Facebook([
  'app_id' => '566253266895248', // Replace {app-id} with your app id
  'app_secret' => '7a11634af77c2bb3873be094b29c5fdd',
  'default_graph_version' => 'v2.7',
  ]);
  
$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (isset($accessToken)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;

  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
  header('Location: http://cpro.jbh/controleur/cpro/controleurECI.php');
  
} elseif ($helper->getError()) {
  // The user denied the request
  exit;
}
?>