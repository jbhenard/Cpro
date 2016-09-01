<?php
session_start();

include_once('../../modele/connexion_sql.php');
include_once('../../modele/connexion_mysqli.php');
include_once('../../modele/cpro/get_personne.php');

//["lea@free.fr", "theo@free.fr", "jules@free.fr"]
//echo "<br/>==================Var dump de SESSION============================================";
//var_dump($_SESSION);
// On effectue du traitement sur les données (contrôleur)
$tab=$_SESSION['tab'];
$tab2=explode(",", $tab);

if(strlen($tab2[0]) !=0){
	foreach ($tab2 as $key => $user) {
		$_SESSION['user']=$user;
		$coderetour = ajout_personneArchive();
	}
}

// On effectue du traitement sur les données (contrôleur)
header("Location: http://cpro.jbh/controleur/cpro/controleurAdmin.php");
die();