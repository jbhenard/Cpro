<?php
session_cache_limiter('none');
session_start();

// Tableau contenant les messages d'erreur lies a la validation de chaque
// champ du formulaire.
// On utilisera le nom du champ comme cle du tableau
$errs = array();

// On demande les informations en table (modèle)
// Connexion à la base
include_once('../../modele/connexion_sql.php');
include_once('../../modele/cpro/get_personne.php');

if (isset($_COOKIE['cookieUser'])) $user=$_COOKIE['cookieUser'];
else $user='';

//Gestion des relances A faire

//Infos pour select box
$allpersonnesdtc=get_allpersonnesdtc();
//Infos pour select box & infos pour la liste
$allpersonnes=get_infoscandidat("tous");
$allformations=get_allformations();
$alletatscandidat=get_alletatscandidat();
$allpersonnesdte=get_allpersonnesdte();

if (isset($_GET['submitPAR'])) {$parametrage=$_GET['submitPAR']; 
}else{$parametrage='';}

// On effectue du traitement sur les données (contrôleur)
if (isset($_GET['submitASE'])) {$ase=$_GET['submitASE']; $tab=$_GET['tab'];
}else{$ase=''; $tab='';}

if (isset($_GET['submitEEX'])) {$excel=$_GET['submitEEX']; 
}else{$excel='';}

if (isset($_GET['submitVAR'])) {$var=$_GET['submitVAR']; 
}else{$var=''; }

//Paramétrage
if ($parametrage == 'submitPAR') {
	header("Location: http://cpro.jbh/controleur/cpro/controleurParametrage.php");
}

//Voir les candidats archivés
if ($var == 'submitVAR') {
	header("Location: http://cpro.jbh/controleur/cpro/controleurArchives.php");
}

//Archiver les candidats sélectionnés
if ($ase == 'submitASE') {
	$_SESSION['tab']=$tab;
	header("Location: http://cpro.jbh/controleur/cpro/controleurASE.php");
}

//Exporter la liste sous Excel
if ($excel == 'Excel') {
	//header("Location: http://cpro.jbh/controleur/cpro/controleurEEX.php");
	//header("Location: http://cpro.jbh/DataExportCandidats.html");
	//header("Location: http://cpro.jbh/controleur/cpro/DataExportCandidats.html");
	header("Location: http://cpro.jbh/vue/cpro/instic_espaceadminEEX.php");
}

$typefiltre='tous';

if (isset($_GET['likenom'])) {$likenomjstophp=$_GET['likenom']; $typefiltre='likenom';
	$valeurtri=$likenomjstophp;
	$_SESSION['valeurtri']=$valeurtri;
	$allpersonnes=get_infoscandidat("likenom");
}else{$likenomjstophp='';}

if (isset($_GET['dtc'])) {$dtcjstophp=$_GET['dtc']; $typefiltre='dtc'; 
	$valeurtri=$dtcjstophp;
    $_SESSION['valeurtri']=$valeurtri;
    $allpersonnes=get_infoscandidat("dtc");
}else{$dtcjstophp=''; $typefiltre='tous';}

if (isset($_GET['name'])) {
	$varjstophp=$_GET['name']; $typefiltre='nom';
	$valeurtri=$varjstophp;
	$_SESSION['valeurtri']=$valeurtri;
	$allpersonnes=get_infoscandidat("nom");
}else{$varjstophp=''; $typefiltre='tous';}

if (isset($_GET['formation'])) {$formationjstophp=$_GET['formation']; $typefiltre='formation';
	$valeurtri=$formationjstophp;

	//Formation inverse de 'DESWEB000' en 'l10choix1'
	$_SESSION['valeurtri']=$valeurtri;
	$formationfiltre=get_formation();

	foreach ($formationfiltre as $key => $champs) {
		$valeurtri=$champs['choix'];
	}

	//echo "<br /=============================================><br />";
	//echo $valeurtri;
	$_SESSION['valeurtri']=$valeurtri;

	$allpersonnes=get_infoscandidat("formation");
}else{$formationjstophp=''; $typefiltre='tous';}

if (isset($_GET['etat'])) {$etatjstophp=$_GET['etat']; $typefiltre='etat';
	$valeurtri=$etatjstophp;
	$_SESSION['valeurtri']=$valeurtri;
	$allpersonnes=get_infoscandidat("etat");
}else{$etatjstophp=''; $typefiltre='tous';}

if (isset($_GET['dte'])) {$dtejstophp=$_GET['dte']; $typefiltre='dte';
	$valeurtri=$dtejstophp;
	$_SESSION['valeurtri']=$valeurtri;
	$allpersonnes=get_infoscandidat("dte");
}else{$dtejstophp=''; $typefiltre='tous';}

if (isset($_GET['choixtri'])) {
	$tri=$_GET['choixtri'];
	   //via un switch
        switch ($tri) {
            case 'tridtc':
    			//$typefiltre='tridtc';         
				$allpersonnes=get_infoscandidat("tridtc");
				break;
            case 'trinom':
            	//echo "<br/> tri valeur Nom: ";
    			//$typefiltre='trinom';                
				$allpersonnes=get_infoscandidat("trinom");                 
                break;
			case 'trife':
    			//$typefiltre='triformation';
				$allpersonnes=get_infoscandidat("trife");              
                break;
			case 'tristatut':
    			//$typefiltre='tristatut';
				$allpersonnes=get_infoscandidat("tristatut");                 
                break;
			case 'tridte':
    			//$typefiltre='tridte';
				$allpersonnes=get_infoscandidat("tridte");                 
                break;
            default:
                //$typefiltre='tous';
                $allpersonnes=get_infoscandidat("tous");    
                break;
    	} //fin de switch
} //Fin de if isset($_GET['choixtri'])


//$allpersonnes=get_allpersonnes();


if ($varjstophp == 'tous'){$typefiltre='tous';}

//if (isset($_POST['variable'])) echo "var js vers php2= ".$_POST['variable'];


// On affiche la page (vue)
include_once('../../vue/cpro/instic_espaceadmin.php');