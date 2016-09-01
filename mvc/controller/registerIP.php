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

$nom=$tab['IP']['nom'];
$prenom=$tab['IP']['prenom'];
$email=$tab['IP']['email'];
$etudes=$tab['IP']['etudes'];
$annee=$tab['IP']['annee'];
$resultat=$tab['IP']['resultat'];
$etablissement=$tab['IP']['etablissement'];

$id = $nom.' '.$prenom;

echo $id."<br/>";
echo $email."<br/>";
echo "choix= ".$choix."<br/>";

try
{
 // Insertion du message à l'aide d'une requête préparée
 $req = $bdd->prepare('INSERT INTO personneip (id, user, etudes, annee, resultat, etablissement, languesvivantes, active) VALUES (:i, :u, :e, :an, :r, :et, :l, :a)');
 $req->execute(array('i' => $id, 'u' => $email, 'e' => $etudes, 'an' => $annee, 'r' => $resultat, 'et' => $etablissement, 'l' => $choix, 'a' => 'Oui'));
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
$reponse = $bdd->query('SELECT * FROM personneip') or  die('Erreur SELECT !');

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