<?php
require_once __DIR__ . '/../vendor/autoload.php';

//Create the Facebook service
$fb = new Facebook\Facebook([
  'app_id' => '566253266895248', // Replace {app-id} with your app id
  'app_secret' => '7a11634af77c2bb3873be094b29c5fdd',
  'default_graph_version' => 'v2.7',
  ]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes']; // optional

$loginUrl = $helper->getLoginUrl('http://cpro.jbh/FacebookLogin/fb-callback.php', $permissions);

//echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';

?>