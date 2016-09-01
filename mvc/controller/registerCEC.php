<?php
session_start();

//Connexion à la base
include_once '../model/connexion_sql.php';

$tab=$_SESSION['tab'];

$titre=$tab['CEC']['titre'];
$nom=$tab['CEC']['nom'];
$prenom=$tab['CEC']['prenom'];
$id = $nom.' '.$prenom;
$user=$tab['CEC']['user'];
$mdp=$tab['CEC']['mdp'];

//Infos connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "instic";

//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Modification du jeu de résultats en utf8 
if (!$conn->set_charset("utf8")) {
    printf("Erreur lors du chargement du jeu de caractères utf8 : %s\n", $mysqli->error);
    exit();
} else {
    printf("Jeu de caractères courant : %s\n", $conn->character_set_name());
}

//Insertion
$sql = "INSERT INTO  personne (id, titre, nom, prenom,  user, mdp) VALUES ('$id', '$titre', '$nom', '$prenom', '$user', '$mdp')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

$_SESSION['user'] = $user;
header("Location: ../view/instic_inscription.php");
die();

?>