<?php
//Init cookies
//Set cookie*********************************//
$number_of_days = 10;
$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days;
$coderetour     = setcookie("cookiecontroleurIndex", " ", $date_of_expiry, "/");
$coderetour2    = setcookie("cookiename", " ", $date_of_expiry, "/");
$coderetour		= setcookie("cookieUser", " ", $date_of_expiry, "/");

//Ajouter le chargeur automatique de Composer au début de votre script.
require_once __DIR__ . '/vendor/autoload.php';
//echo __DIR__ . '/vendor/autoload.php';
//die();

// Connexion à la base
include_once('modele/connexion_sql.php');

if (!isset($_GET['section']) OR $_GET['section'] == 'index')
{
    include_once('controleur/cpro/index.php');
}