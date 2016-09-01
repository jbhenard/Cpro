<?php
//Infos connection
#Include the connect.php file
//include ('modele/connect.php');
$hostname = "localhost";	// le chemin vers le serveur
$database = "instic";		// le nom de votre base de données
$username = "root";			// nom d'utilisateur pour se connecter
$password = "";				// mot de passe de l'utilisateur pour se connecter

try{
    // On se connecte à MySQL
    //$bdd = new PDO('mysql:host=localhost;dbname=instic;charset=utf8', 'root', '');
    $bdd = new PDO('mysql:host='.$hostname.';dbname='.$database, $username, $password);
    $bdd->exec("SET NAMES utf8");
}catch(Exception $e){
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
}