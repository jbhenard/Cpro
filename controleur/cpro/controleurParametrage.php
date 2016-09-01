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
$allformations=get_allformations();

if (isset($_COOKIE['cookieUser'])) $user=$_COOKIE['cookieUser'];
else $user='';

$tabcookie=htmlentities($_COOKIE['cookiename'], 3, 'UTF-8');

$tabcookie2=explode(",", $tabcookie);

	$enreg=0;
	$tabclef = array();
	
	foreach ($allformations as $key => $value) {		
		$tabclef[$enreg]=$value['clef'];	
		$enreg++;
	}
	
	//for ($k=0; $k < count($tabclef) ; $k++){
	//echo "<br/>clef: " ;
	//echo $tabclef[$k];
	//}

if (isset($_GET['submitFOR1']) == 'submitFOR1') {
	$enreg   = 0;
	
	//=======================================
	//Trt des MàJ
	$cleffor = 'l'+$enreg+'choix1'; //l1choix1
	for ($j=0; $j < count($tabcookie2); $j++){
		if ($tabcookie2[$j] != 'id' && $tabcookie2[$j] != 'domaine' && $tabcookie2[$j] != 'formation' && $tabcookie2[$j] != 'identifiant' && $tabcookie2[$j] != 'codeQCM'){
		    $parametre['FOR']['clef']        = $tabclef[$enreg];
		    $parametre['FOR']['id']          = $tabcookie2[$j];
		    $parametre['FOR']['domaine']     = (isset($tabcookie2[$j+1])) ? $tabcookie2[$j+1] : "" ;;
		    $parametre['FOR']['formation']   = (isset($tabcookie2[$j+2])) ? $tabcookie2[$j+2] : "" ;;
		    $parametre['FOR']['identifiant'] = (isset($tabcookie2[$j+3])) ? $tabcookie2[$j+3] : "" ;;
		    $parametre['FOR']['codeQCM']     = (isset($tabcookie2[$j+4])) ? $tabcookie2[$j+4] : "" ;;

			if (($j%5) == 0) {			
				$parametre['FOR']['choix']=$cleffor;
				$_SESSION['tab'] = $parametre;
				$coderetour = maj_formations(); $enreg++;
				header("location: controleurParametrage.php"); // your current page
				$cleffor='l'+$enreg+'choix1';
			}
		}// fin du if $tabcookie2[$j] != 'statut' && $tabcookie2[$j] != 'Mail' && $tabcookie2[$j] != 'sequence'	
	} // fin du for


	//=======================================
	//Trt des ajout
	
	
//Caluler le nombre de ligne avant
	$nbenregAvant=0;
	foreach ($allformations as $key => $value) {
		++$nbenregAvant;
	}
	$valtab=(count($tabcookie2)/5)-1;

	//echo "<br />===========================$valtab=============================<br />";
	//echo "<br />===========================$nbenregAvant=============================<br />";

	if ($valtab > $nbenregAvant) {
		++$enreg;
		$delta=$valtab-$nbenregAvant;
		$j=($nbenregAvant+1)*5;
	
		$parametre['FOR']['id']          = $tabcookie2[$j];
	    $parametre['FOR']['domaine']     = (isset($tabcookie2[$j+1])) ? $tabcookie2[$j+1] : "" ;;
	    $parametre['FOR']['formation']   = (isset($tabcookie2[$j+2])) ? $tabcookie2[$j+2] : "" ;;
	    $parametre['FOR']['identifiant'] = (isset($tabcookie2[$j+3])) ? $tabcookie2[$j+3] : "" ;;
	    $parametre['FOR']['codeQCM']     = (isset($tabcookie2[$j+4])) ? $tabcookie2[$j+4] : "" ;;

		//$_SESSION['tab'] = $parametre;		
		//$coderetour = ajout_états(); $enreg++;
		$parametre['FOR']['choix']=$cleffor;
		$_SESSION['tab'] = $parametre;
		if (!existe_enreg('formation', 'choix', $cleffor)) $coderetour = ajout_formations();
		$enreg++;
		$cleffor='l'+$enreg+'choix1';
		header("location: controleurParametrage.php"); // your current page
		$j++;		

		}					

					
	//Fin trt ajout

} // fin de if submitFOR1 = page paramètre formation
//Fin cookie
//******************************************************************************************

$tableau3=var_export($_COOKIE['cookiename'],true);
eval('$somevar = '. $tableau3.';');

if (isset($_COOKIE['cookiename'])) {
	
	$tabcookie=$_COOKIE['cookiename'];
	
	$tabcookie2=explode(",", $tabcookie);
}

if (isset($_GET['tabjs'])) {
	$tabjs=$_GET['tabjs'];	
	
}else{ $tabjs='';}


if (isset($_GET['tabajax'])) {
	$tabjs=$_GET['tabajax'];	

}else{ $tabjs='';}

// On effectue du traitement sur les données (contrôleur)


// On affiche la page (vue)
include_once('../../vue/cpro/instic_espaceparametrage.php');