<?php
session_start();

//Connexion à la base
include_once '../model/connexion_sql.php';

/*
 * execute sql query
 */
$choix=$_SESSION['choix'];
$tab=$_SESSION['tab'];

$user=$tab['FE']['user'];

try
{
 // Insertion du message à l'aide d'une requête préparée
 $req = $bdd->prepare('INSERT INTO personnefe (user, formationenvisagees, active) VALUES (:u, :f, :a)');
 $req->execute(array('u' => $user, 'f' => $choix, 'a' => 'Oui'));
}
catch(Exception $e)
{
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur INSERT : '.$e->getMessage());
}

//Envoi mail
$_SESSION['user'] = $user;
$parammail="Afin de poursuivre votre inscription, merci de valider votre mail en cliquant sur le lien qui vous a été envoyé";
$id=$user;

header("Location: ../view/instic_gmail.php?user=$id&id=$id&parammail=$parammail");
die();

//$_SESSION['user'] = $user;
//header("Location: ../view/instic_espacecandidat.php");
die();

?>