<?php
session_start();

$errs = array();

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

if (isset($_COOKIE['cookieUser']) && $user == '') $user=$_COOKIE['cookieUser'];
//else $user='';

if (isset($_COOKIE['cookieCandidat'])) $user=$_COOKIE['cookieCandidat'];
else $user='';

$_SESSION['user']=$user;

//echo "<br /> ========================================== <br />";
//echo $user;
//die();

$personneIP=get_infospedagogiques();
$personne=get_personne();

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select Informations pédagogiques
//======================================================================================================
if (count($personneIP) != 0) {        
    foreach($personneIP as $cle => $rowIP) {
        $id=$rowIP['id'];
        $user=$rowIP['user'];
        $languesvivantes=$rowIP['languesvivantes'];            
        $active=$rowIP['active'];
        $etudes=$rowIP['etudes'];
        $annee=$rowIP['annee'];
        $resultat=$rowIP['resultat'];
        $etablissement=$rowIP['etablissement'];
        $lv1libelle =$rowIP['lv1libelle'];
        $lv2libelle =$rowIP['lv2libelle'];
        
    }
    $tabchoixIP=explode("-", $languesvivantes);
    $tabchoix2IP=array();
    $nbchoixIP=substr_count($languesvivantes,'-');            

    foreach ($tabchoixIP as $value) {
        $tabchoix2IP[$value][0]=$value;                
    }        
}else {
    $id='';
    $user='';
    $languesvivantes='';
    $active='';
    $etudes='';
    $annee='';
    $resultat='';
    $etablissement='';
    $lv1libelle ='';
    $lv2libelle ='';
}


// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
// Submit Informations pédagogiques
//======================================================================================================
if (!empty($_POST["submitIPE"]) > 0) {
    $choix='';
    if (!empty($_POST["lv1choix1"])) $choix.='lv1choix1-';
    if (!empty($_POST["lv1choix2"])) $choix.='lv1choix2-';

    if (!empty($_POST["lv1choix3"])) $choix.='lv1choix3-';
    if (!empty($_POST["lv1choix4"])) $choix.='lv1choix4-';

    if (!empty($_POST["lv2choix1"])) $choix.='lv2choix1-';
    if (!empty($_POST["lv2choix2"])) $choix.='lv2choix2-';

    if (!empty($_POST["lv2choix3"])) $choix.='lv2choix3-';
    if (!empty($_POST["lv2choix4"])) $choix.='lv2choix4-';
    
    if (empty($_POST["etudes"])) $errsIP["etudes"][] = "Veuillez renseigner le Diplôme!";    
    if (empty($_POST["annee"])) $errsIP["annee"][] = "Veuillez renseigner l'Année!";    
    if (empty($_POST["resultat"])) $errsIP["resultat"][] = "Veuillez renseigner le Résultat";    
    if (empty($_POST["etablissement"])) $errsIP["etablissement"][] = "Veuillez renseigner l'Etablissement";    
    if (empty($_POST["lv1libelle"])) $errsIP["lv1libelle"][] = "Veuillez renseigner la LV1";    
    if (empty($_POST["lv2libelle"])) $errsIP["lv2libelle"][] = "Veuillez renseigner la LV2";    
    

    if ($choix == '') $errsRC["lv1choix1"][] = "Veuillez renseigner les cases à cochées!";
    else {
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
        
        
        $parametres['IPE']['id']=$id;
        $parametres['IPE']['user']=$user;
        $parametres['IPE']['etudes']=$_POST["etudes"];
        $parametres['IPE']['annee']=$_POST["annee"];
        $parametres['IPE']['resultat']=$_POST["resultat"];
        $parametres['IPE']['etablissement']=$_POST["etablissement"];
        $parametres['IPE']['lv1libelle']=$_POST["lv1libelle"];
        $parametres['IPE']['lv2libelle']=$_POST["lv2libelle"];
        
        $_SESSION['tab']=$parametres;
        $_SESSION['choix']=$choix;
 

        // On ajoute les informations en table (modèle)
        if (existe_enreg('personneip', 'user', $user)) {
        	$coderetour=maj_infospedagogiques();
        	//MàJ code Etat tb etatscandidat
			$rc = maj_etatdossierOK($user, 'etatIPE');
        } else $coderetour=ajout_infospedagogiques();
					
        header("location: controleurIPE.php"); // your current page
    }
}


// On affiche la page (vue)
include_once('../../vue/cpro/instic_infospedagogiques.php');