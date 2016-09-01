<?php
	
if (isset($_SESSION['user'])) $user=$_SESSION['user'];
else $user='';

if (isset($_COOKIE['cookieUser'])) $user=$_COOKIE['cookieUser'];
else $user='';

$_SESSION['user']=$user;

	// Put the unique user id in a variable - the script know what record to pull from the database because of this variable, which comes to the script as a GET variable in this case. You could/should use a fancier, securer, less user-editable way of transmitting ids, like using a unique md5 hash for the id... again, this is just a simple example
	$id = $_GET['id'];

//Connexion à la base
include_once '../../modele/connexion_sql.php';
include_once '../../modele/connexion_mysqli.php';
	
//Accès à la class Personne & à la class d'accès au SGBD pour cette class personne, son'PersonneManager'
include_once('../../modele/cpro/Mail.class.php');
include_once('../../modele/cpro/MailManager.class.php');

        //Début mode POO ajout Personne        	            
			$manager = new MailManager($bdd);			    
			$fichier =$manager->get($id);
        //Fin mode POO
        //$chemin="http://cpro.jbh/".$fichier->getUpfilefinalname();
	
	if (strlen($fichier->getLibelle()) > 0) {
		//echo "mail à traiter: ".$fichier->getLibelle();		
		header("location: ../../controleur/cpro/controleurParametrage3.php?idmail=".$fichier->getId());
		die();		
		
	} //Fin if (strlen($fichier->getUser()) > 0)
?> 