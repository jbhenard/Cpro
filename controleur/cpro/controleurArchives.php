<?php
session_start(); 

// Tableau contenant les messages d'erreur lies a la validation de chaque
// champ du formulaire.
// On utilisera le nom du champ comme cle du tableau
$errs = array();

// On demande les informations en table (modèle)
// Connexion à la base
include_once('../../modele/connexion_sql.php');
include_once('../../modele/cpro/get_personne.php');
$allpersonnesarchives=get_allpersonnesArchives();
$allpersonnesdtc=get_allpersonnesdtcArchives();
$allpersonnesdte=get_allpersonnesdteArchives();
$alletatscandidat=get_alletatscandidat();
$allformations=get_allformations();

if (isset($_COOKIE['cookieUser'])) $user=$_COOKIE['cookieUser'];
else $user='';

// On effectue du traitement sur les données (contrôleur)
if (isset($_GET['submitEEXA'])) {
	$excel=$_GET['submitEEXA']; 
	$tab=$_GET['tab'];
	$_SESSION['tab']=$tab;
}else{
	$excel='';
}

if (isset($_GET['submitVAR'])) {$var=$_GET['submitVAR']; 
}else{$var='';}

//Voir les candidats archivés
if (!empty($_POST["submitVAR"]) > 0) {
	header("Location: http://cpro.jbh/controleur/cpro/controleurArchives.php");
	//echo "Excel: Vexport CSV terminé!";
	die();
}

//Archiver les candidats sélectionnés
if (!empty($_POST["submitASE"]) > 0) {
	echo "Archiver";
	die();
}

//Exporter la liste sous Excel
if ($excel == 'Excel') {
	//header("Location: http://cpro.jbh/controleur/cpro/controleurEEXA.php");
	//header("Location: http://cpro.jbh/DataExportCandidatsA.html");
	//header("Location: http://cpro.jbh/controleur/cpro/DataExportCandidatsA.html");
	header("Location: http://cpro.jbh/vue/cpro/instic_espacearchiveEEX.php");
}

if (isset($_GET['name'])) {$varjstophp=$_GET['name']; 
}else{$varjstophp='';}

if (isset($_POST['variable'])) echo "var js vers php2= ".$_POST['variable'];

// On effectue du traitement sur les données (contrôleur)


// On affiche la page (vue)
include_once('../../vue/cpro/instic_espacearchive.php');