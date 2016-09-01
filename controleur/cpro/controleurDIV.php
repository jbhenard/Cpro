<?php
session_start();

$errsDIV = array();

//Connexion à la base
include_once '../../modele/connexion_sql.php';
include_once '../../modele/connexion_mysqli.php';

// On demande les informations en table (modèle)
//Selection pour récupérer les infos personne (modèle)
include_once('../../modele/cpro/get_personne.php');

// Tableau contenant les messages d'erreur lies a la validation de chaque
// champ du formulaire.
// On utilisera le nom du champ comme cle du tableau
$errsFE   = array();

if (isset($_SESSION['user'])) $user=$_SESSION['user'];
else $user='';

if (isset($_COOKIE['cookieUser']) && $user == '' ) $user=$_COOKIE['cookieUser'];
//else $user='';

if (isset($_COOKIE['cookieCandidat'])) $user=$_COOKIE['cookieCandidat'];
else $user='';

$_SESSION['user']=$user;

//$personneip=get_infospedagogiques();
$personneDIV=get_infosdivers();
$allconnuinstic=get_allconnuinstic();
$personne=get_personne();

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select Informations professionnelles
//======================================================================================================

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select Informations professionnelles
//======================================================================================================
if (count($personneDIV) != 0) {        
    foreach($personneDIV as $cle => $rowDIV) {
        $id=$rowDIV['id'];
        $user=$rowDIV['user'];
        $connuinstic=$rowDIV['connuinstic'];
        $dejacandidat=$rowDIV['dejacandidat'];
        $autreetablissement=$rowDIV['autreetablissement'];
        $etablissementoui1=$rowDIV['etablissementoui1'];
        $etablissementoui2=$rowDIV['etablissementoui2'];
        $etablissementoui3=$rowDIV['etablissementoui3'];
        $etablissementoui4=$rowDIV['etablissementoui4'];
    }
    
}else{
    $id='';
    $user='';
    $connuinstic='';
    $dejacandidat='';
    $autreetablissement='';
    $etablissementoui1='';
    $etablissementoui2='';
    $etablissementoui3='';
    $etablissementoui4='';
}


// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
// Submit Informations diverses
//======================================================================================================
if (!empty($_POST["submitDIV"]) > 0) {
    $user=$_COOKIE['cookieUser'];
    
    //Recup id de personne
    if (count($personne) != 0) {        
	    foreach($personne as $cle => $champs) {
	        $id=$champs['id'];           
	        $titre=$champs['titre'];            
	        $nom=$champs['nom'];
	        $prenom=$champs['prenom'];
	        $email=$champs['user'];
	        $user=$champs['user'];
	        $mdp1=$champs['mdp'];
	        $mdp2=$champs['mdp'];        
	    }        
	}else{
	    $titre='';            
	    $nom='';
	    $prenom='';
	    $email='';
	    $mdp1='';
	    $mdp2='';    
	}
    //echo "Utilisateur: ".$id;
    //die();
    $parametres['DIV']['id']=$id;
    $parametres['DIV']['user']=$user;
    $parametres['DIV']['connuinstic']=$_POST['allconnuinstic'];
    
    if (isset($_POST['dejacandidatoui'])) $parametres['DIV']['dejacandidat']='Oui';
    else $parametres['DIV']['dejacandidat']='Non';

    if (isset($_POST['autreetablissementoui'])) $parametres['DIV']['autreetablissement']='Oui';
    else $parametres['DIV']['autreetablissement']='Non';

    $parametres['DIV']['etablissementoui1']=$_POST['etablissementoui1'];
    $parametres['DIV']['etablissementoui2']=$_POST['etablissementoui2'];
    $parametres['DIV']['etablissementoui3']=$_POST['etablissementoui3'];
    $parametres['DIV']['etablissementoui4']=$_POST['etablissementoui4'];

    $_SESSION['tab']=$parametres;
	$rc2=existe_enreg('personnedi', 'user', $user);
	//echo " - RC2: ".$rc2;
    if ($rc2) {
    	//echo "en MAJ";
		//die();
    	$coderetour=maj_DIV();
    	echo "RC MàJ: ".$rc;
    	//MàJ code Etat tb etatscandidat
		$rc = maj_etatdossierOK($user, 'etatDIV');
	} else $coderetour=ajout_DIV();

    header("location: controleurDIV.php"); // your current page
}


// On affiche la page (vue)
include_once('../../vue/cpro/instic_divers.php');