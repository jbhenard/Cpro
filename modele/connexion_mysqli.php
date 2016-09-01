<?php
//Infos connection
#Include the connect.php file
//include ('modele/connect.php');
$hostname = "localhost";	// le chemin vers le serveur
$database = "instic";		// le nom de votre base de données
$username = "root";			// nom d'utilisateur pour se connecter
$password = "";				// mot de passe de l'utilisateur pour se connecter

//Create connection
$conn = new mysqli($hostname, $username, $password, $database);

//Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Modification du jeu de résultats en utf8 
if (!$conn->set_charset("utf8")) {
    printf("Erreur lors du chargement du jeu de caractères utf8 : %s\n", $mysqli->error);
    exit();
} else {
    //printf("Jeu de caractères courant : %s\n", $conn->character_set_name());
}