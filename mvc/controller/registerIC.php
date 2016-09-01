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
$tab=$_SESSION['tab'];

// Exemple 1
//$pizza  = "piece1 piece2 piece3 piece4 piece5 piece6";
//$pieces = explode(" ", $pizza);
//echo $pieces[0]; // piece1
//echo $pieces[1]; // piece2

$titre=$tab['IC']['titre'];
$nom=$tab['IC']['nom'];
$prenom=$tab['IC']['prenom'];
$email=$tab['IC']['email'];
$mdp=$tab['IC']['mdp'];

$id = $nom.' '.$prenom;

echo $id."<br/>";
echo $email."<br/>";

try
{
 // Insertion du message à l'aide d'une requête préparée
//UPDATE `personne` SET `clef`=[value-1],`id`=[value-2],`titre`=[value-3],`nom`=[value-4],`prenom`=[value-5],`user`=[value-6],`mdp`=[value-7] WHERE 1
 $req = $bdd->prepare("UPDATE personne SET id='$id', titre='$titre', nom='$nom', prenom='$prenom', mdp='$mdp' WHERE user='$email';");
 $req->execute();
}
catch(Exception $e)
{
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur INSERT : '.$e->getMessage());
}

/*
 * execute sql query
 */
// On récupère tout le contenu de la table personne
$reponse = $bdd->query("SELECT * FROM personne WHERE user='$email';") or  die('Erreur SELECT MaJ Personne!');

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