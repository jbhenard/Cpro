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
$allstatuts=get_allstatuts();

//Caluler le nombre d eligne avant
$nbenregAvant=0;
$enreg=0;
$tabclef = array();

foreach ($allstatuts as $key => $value) {
	++$nbenregAvant;
	$tabclef[$enreg]=$value['clef'];	
	$enreg++;
}

//for ($k=0; $k < count($tabclef) ; $k++){
//	echo "<br/>clef: " ;
//	echo $tabclef[$k];
//}

if (isset($_COOKIE['cookieUser'])) $user=$_COOKIE['cookieUser'];
else $user='';

$tabcookie=htmlentities($_COOKIE['cookiename'], 3, 'UTF-8');

//echo $tabcookie;

$tabcookie2=explode(",", $tabcookie);

//echo "<br/>=========================nb tab param=====================================<br/>";
//echo "Avant submitFOR! ";

//$submitFOR = isset($_GET['submitFOR']) ? $_GET['submitFOR'] : '';

if (isset($_GET['submitFOR']) == 'submitFOR') {
	$enreg=0; // === $tabclef[0] === clef en tb param pour champ='état'
	
	//echo "<br/>=========================nb tab param=====================================<br/>";
	//echo "Dans submitFOR! ";
	//Trt des MàJ
	for ($j=0; $j < count($tabcookie2); $j++){
		if ($tabcookie2[$j] != 'statut' && $tabcookie2[$j] != 'Mail' && $tabcookie2[$j] != 'sequence'){
			//echo "<br/>==================For de tabcookie2============================================<br/>";
	//		echo "<br/>==================$j============================================<br/>";
	//		echo $tabcookie2[$j];
		
			$parametre['statuts']['clef']     = $tabclef[$enreg];
			$parametre['statuts']['statut']   = $tabcookie2[$j];
			$parametre['statuts']['Mail']     = (isset($tabcookie2[$j+1])) ? $tabcookie2[$j+1] : "" ;
			$parametre['statuts']['sequence'] = (isset($tabcookie2[$j+2])) ? $tabcookie2[$j+2] : "" ;

			$_SESSION['tab'] = $parametre;
			if (($j%3) == 0) {
				$coderetour = maj_états(); $enreg++;				
				header("location: controleurParametrage2.php"); // your current page
			}
		}// fin du if $tabcookie2[$j] != 'statut' && $tabcookie2[$j] != 'Mail' && $tabcookie2[$j] != 'sequence'	
	} // fin du for1

	$valtab=(count($tabcookie2)/3)-1;
	//echo "<br/>=========================nb tab param=====================================<br/>";
	//echo count($tabcookie2);
	
	//echo "<br/>====================nb en table========================================<br/>";
	//echo $nbenregAvant;

	//echo "<br/>===================compteur enregistrement=========================================<br/>";
	//echo $enreg;

	$enregMax=maxCpt_états();
	foreach ($enregMax as $key => $champ) {
		$enreg=$champ['maxnb'];
	}
	//echo "<br/>===================compteur 1 =========================================<br/>";
	//echo $valtab;

	//echo "<br/>===================compteur 2 =========================================<br/>";
	//echo $nbenregAvant;

	//die();

		//Trt des ajout
		
	if ($valtab > $nbenregAvant) {
		++$enreg;
		$delta=$valtab-$nbenregAvant;
		$j=($nbenregAvant+1)*3;
	
 		$parametre['statuts']['clef']     = $enreg;
		$parametre['statuts']['statut']   = $tabcookie2[$j];
		$parametre['statuts']['Mail']     = (isset($tabcookie2[$j+1])) ? $tabcookie2[$j+1] : "" ;
		$parametre['statuts']['sequence'] = (isset($tabcookie2[$j+2])) ? $tabcookie2[$j+2] : "" ;

		$_SESSION['tab'] = $parametre;
		if (!existe_enreg('param', 'valeur', $tbstatut)) $coderetour = ajout_états(); 
		$enreg++;
		header("location: controleurParametrage2.php"); // your current page
		$j++;		

		}					

} // fin if submitFOR = page paramètre états

//$enregMax=maxCpt_états();
	//foreach ($enregMax as $key => $champ) {
	//	$enreg=$champ['maxnb'];
	//}
//$valtab=(count($tabcookie2)/3)-1;

//test ici ajout états!!!!!!!!!!!!!

$tableau3=var_export($_COOKIE['cookiename'],true);
//eval('$somevar = '. $tableau3.';');
//echo "<br/>==================Ajax============================================";
//echo (isset($_POST['varx'])) ? "<br/>JS to PHP via Ajax OK!" : "<br/>JS to PHP via Ajax KO!" ;
//echo (isset($_POST['ligne5'])) ? "<br/>JS to PHP via Ajax ligne5 OK!" : "<br/>JS to PHP via Ajax ligne5 KO!" ;
//echo "<br/>==================Autre============================================";
if (isset($_COOKIE['cookiename'])) {
	
	$tabcookie=$_COOKIE['cookiename'];
	
	$tabcookie2=explode(",", $tabcookie);
	
//	echo "<br/>dans passage parametre cookie2 to PHP! ";

}

if (isset($_GET['tabjs'])) {
	$tabjs=$_GET['tabjs'];
//	echo "<br/>dans passage parametre js to PHP! " + $tabjs;
	
}else{ $tabjs='';}


if (isset($_GET['tabjs2'])) {
	$json=$_GET['tabjs2'];
	$parse_json = json_decode($json);

	//echo "valeur GET de tab: "+$parse_json;

//	echo "<br/>dans passage parametre js2 to PHP! ";
}else{ $tabjs='';}



if (isset($_GET['tabajax'])) {
	$tabjs=$_GET['tabajax'];
//	echo "<br/>dans passage parametre ajax to PHP! ";
//	echo "<br/>===================="+$tabjs;


}else{ $tabjs='';}

// On effectue du traitement sur les données (contrôleur)


// On affiche la page (vue)
include_once('../../vue/cpro/instic_espaceparametrage2.php');