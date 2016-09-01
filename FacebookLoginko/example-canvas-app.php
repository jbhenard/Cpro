<?php
# example-canvas-app.php
require_once __DIR__ . '/../vendor/autoload.php';

//Create the Facebook service
$fb = new Facebook\Facebook([
  'app_id' => '480078518856815', // Replace {app-id} with your app id
  'app_secret' => '3a4eabf652e568edb4fc206241fa67a6',
  'default_graph_version' => 'v2.7',
  ]);
  
$helper = $fb->getCanvasHelper();
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
  // Logged in.
  header('Location: http://cpro.jbh/controleur/cpro/controleurECI.php');
}

?>