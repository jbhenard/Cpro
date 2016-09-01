<?php
session_start();
/**
 * Created by PhpStorm.
 * User: henard435
 * Date: 19/07/2016
 * Time: 15:32
 */

include_once 'pdo.php';

/*
 * execute sql query
 */
$choix=$_SESSION['choix'];
$tab=$_SESSION['tab'];

// Exemple 1
//$pizza  = "piece1 piece2 piece3 piece4 piece5 piece6";
//$pieces = explode(" ", $pizza);
//echo $pieces[0]; // piece1
//echo $pieces[1]; // piece2

$nom=$tab['IPr']['nom'];
$prenom=$tab['IPr']['prenom'];
$email=$tab['IPr']['email'];
$numerode=$tab['IPr']['numerode'];
$datede=$tab['IPr']['datede'];

$stagiairenomentreprise=$tab['IPr']['stagiairenomentreprise'];
$stagiaireduree=$tab['IPr']['stagiaireduree'];
$stagiairenature=$tab['IPr']['stagiairenature'];

$salarienomentreprise=$tab['IPr']['salarienomentreprise'];
$salarienature=$tab['IPr']['salarienature'];

$alternancenomentreprise=$tab['IPr']['alternancenomentreprise'];
$alternanceduree=$tab['IPr']['alternanceduree'];
$alternancetype=$tab['IPr']['alternancetype'];
$alternanceformation=$tab['IPr']['alternanceformation'];

$autresituationlib=$tab['IPr']['autresituationlib'];


$id = $nom.' '.$prenom;

echo $id."<br/>";
echo $email."<br/>";
echo "choix= ".$choix."<br/>";
echo "choix= ".$numerode."<br/>";
echo "choix= ".$datede."<br/>";

//MVC début
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

$sql = "INSERT INTO personneipr (id, user, spa, numerode, datede, active, salarienomentreprise, salarienature, stagiairenomentreprise, stagiaireduree, stagiairenature, alternancenomentreprise, alternanceduree, alternancetype, alternanceformation, autresituationlib)
VALUES ('$id', '$email', '$choix', '$numerode', '$datede', 'Oui', '$salarienomentreprise', '$salarienature', '$stagiairenomentreprise', '$stagiaireduree', '$stagiairenature', '$alternancenomentreprise', '$alternanceduree', '$alternancetype', '$alternanceformation' ,'$autresituationlib')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

//MVC fin

/*
 * execute sql query
 */
// On récupère tout le contenu de la table personne
$reponse = $bdd->query('SELECT * FROM personneipr') or  die('Erreur SELECT !');

while($row = $reponse->fetch(PDO::FETCH_ASSOC)) {
	foreach ($row as $value) {
		echo utf8_decode($value)." ";  //etc...
	}
    
    echo "<br/>";
}

$_SESSION['user'] = $email;
header("Location: http://localhost/cpro_dev/instic_creationcompte.php");
die();

?>