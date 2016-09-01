<?php
/**
 * Created by PhpStorm.
 * User: henard435
 * Date: 19/07/2016
 * Time: 15:33
 */

/*
 * establish database connection
 */
try
{
    // On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=instic;charset=utf8', 'root', '');
}
catch(Exception $e)
{
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
}

?>