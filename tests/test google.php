<?php

// include your composer dependencies
require_once '../vendor/autoload.php';

$client = new Google_Client();
$client->setApplicationName("Cpro.jbh");
$client->setDeveloperKey("513076305354-d2k2t35o5rdil5kto6l1kuqdp77n737s.apps.googleusercontent.com");

$service = new Google_Service_Books($client);
$optParams = array('filter' => 'free-ebooks');
$results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);

foreach ($results as $item) {
  echo $item['volumeInfo']['title'], "<br /> \n";
}

?>