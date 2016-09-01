<?php
session_start();

//Connexion à la base
include_once '../model/connexion_sql.php';

$tab=$_SESSION['tab'];


//======================================================================================================
//Partie IC
//======================================================================================================
$titre=$tab['IC']['titre'];
$nom=$tab['IC']['nom'];
$prenom=$tab['IC']['prenom'];
$user=$tab['IC']['user'];
$mdp=$tab['IC']['mdp'];
$id = $nom.' '.$prenom;

try{
 // Insertion du message à l'aide d'une requête préparée
 $req = $bdd->prepare("UPDATE personne SET id='$id', titre='$titre', nom='$nom', prenom='$prenom', mdp='$mdp' WHERE user='$user';");
 $req->execute();
}catch(Exception $e){
	// En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur INSERT : '.$e->getMessage());
}

echo "New record created successfully IC";

//======================================================================================================
//Partie EC
//======================================================================================================
$nom=$tab['EC']['nom'];
$prenom=$tab['EC']['prenom'];
$id = $nom.' '.$prenom;
$neele=$tab['EC']['neele'];
$lieu=$tab['EC']['lieu'];
$nationalite=$tab['EC']['nationalite'];
$telephone=$tab['EC']['telephone'];
$codepostal=$tab['EC']['codepostal'];
$nsecuritesociale=$tab['EC']['nsecuritesociale'];
$email=$tab['EC']['email'];
$localite=$tab['EC']['localite'];
//$localite=utf8_encode($localite);
$adresse=$tab['EC']['adresse'];
$codepostal=str_replace ( "-", "", $codepostal);
$nsecuritesociale = str_replace ( "-", "", $nsecuritesociale); 
$telephone = str_replace ( "-", "", $telephone); 

//Infos connexion
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "instic";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
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
$sql = "INSERT INTO etatcivil (id, neele, lieu, nationalite, telephone, codepostal, nsecuritesociale, email, localite, adresse)
VALUES ('$id', '$neele', '$lieu', '$nationalite', '$telephone', '$codepostal', '$nsecuritesociale',  '$email', '$localite', '$adresse')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully EC";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

$_SESSION['user'] = $email;
header("Location: ../view/instic_espacecandidat.php");
die();

?>