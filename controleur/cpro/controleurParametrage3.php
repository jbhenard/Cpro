<?php
session_start(); 

if (isset($_SESSION['user'])) $user=$_SESSION['user'];
else $user='';

if (isset($_COOKIE['cookieUser']) && $user =='') $user=$_COOKIE['cookieUser'];
//else $user='';

$_SESSION['user']=$user;

$idmail = $_GET['idmail'];

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//======================================================================================================
//======================================================================================================
//======================================================================================================
// Submit MàJ Mail choisi
//======================================================================================================
if (!empty($_POST["Ecrire"]) > 0) {
	
	$contenu = stripslashes($_POST["commentaire"]);
 
	$filename = '../../vue/cpro/'.$idmail.'.html';
	$ht = $_SERVER["HTTP_REFERER"];
	 
	if (is_writable($filename)) { // Le fichier est il inscriptible
	 
		if (!$handle = fopen($filename, 'w+')) { // Je vous conseil de lire la fonction fopen($filename, 'a')
			echo "Impossible d'ouvrir le fichier ($filename)";
			exit;
		}
	 
		if (fwrite($handle, $contenu) === FALSE) { // On écrit dans le fichier en testant les droits
			echo "Le fichier $filename n'est pas inscriptible";
			exit;
		}
	 
		echo "L'écriture dans le fichier ($filename) a réussi";
		fclose($handle); // on ferme le fichier aprés avoir écrit dedans
	 
	} else {echo "Le fichier $filename n'est pas accessible en écriture.";}
 
 
	//Et la tu rediriges vers ta page pour rafraichir la liste
	header("Location:".$ht."" );
	exit;
	
}

//Ouverture du fichier en lecture seul
$fichier_a_ouvrir = fopen("../../vue/cpro/".$idmail.".html", "r");
// On boucle et tant que l'on n'est pas la fin du fichier ,on continue de le lire. 
$contenu_du_fichier='';

while(!feof($fichier_a_ouvrir)) { $contenu_du_fichier .= fgets($fichier_a_ouvrir, 1024); }

//Fermeture du fichier
fclose ($fichier_a_ouvrir);

// On affiche la page (vue)
include_once('../../vue/cpro/instic_espaceparametrage3.php');