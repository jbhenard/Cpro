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

$nom=$tab['RC']['nom'];
$prenom=$tab['RC']['prenom'];
$email=$tab['RC']['email'];
$rqthlequel=$tab['RC']['rqthlequel'];

$id = $nom.' '.$prenom;

echo $id."<br/>";
echo $email."<br/>";
echo "choix= ".$choix."<br/>";

try
{
 // Insertion du message à l'aide d'une requête préparée
 $req = $bdd->prepare('INSERT INTO personnerc (id, user, renseignementscomplementaires, rqthlequel, active) VALUES (:i, :u, :rc, :r, :a)');
 $req->execute(array('i' => $id, 'u' => $email, 'rc' => $choix, 'r' => $rqthlequel , 'a' => 'Oui'));
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
$reponse = $bdd->query('SELECT * FROM personnerc') or  die('Erreur SELECT !');

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