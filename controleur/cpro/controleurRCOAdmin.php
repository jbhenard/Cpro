<?php
session_start();

// Tableau contenant les messages d'erreur lies a la validation de chaque
// champ du formulaire.
// On utilisera le nom du champ comme cle du tableau
$errsRCO = array();

//Connexion à la base
include_once '../../modele/connexion_sql.php';
include_once '../../modele/connexion_mysqli.php';

// On demande les informations en table (modèle)
//Selection pour récupérer les infos personne (modèle)
include_once('../../modele/cpro/get_personne.php');

if (isset($_SESSION['user'])) $user=$_SESSION['user'];
else $user='';

if (isset($_COOKIE['cookieUser']) && $user =='') $user=$_COOKIE['cookieUser'];
//else $user='';

$_SESSION['user']=$user;

$personne=get_personne();
$personneRCO=get_renseignementscomplementaires();
$tabchoixRCO=array();


// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select Informations personne
//======================================================================================================
if (count($personne) != 0) {        
    foreach($personne as $cle => $row) {
        $id=$row['id'];
        $user=$row['user'];
        $titre=$row['titre'];
        $nom=$row['nom'];
        $prenom=$row['prenom'];
    }
}


/// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select Informations Renseignement COmplémentaires
//======================================================================================================
if (count($personneRCO) != 0) {        
    foreach($personneRCO as $cle => $rowRCO) {
        $id=$rowRCO['id'];
        $user=$rowRCO['user'];
        $renseignementscomplementaires=$rowRCO['renseignementscomplementaires'];
        //$renseignementscomplementaires=$rowRCO['renseignementscomplementaires']; 
        $rqthlequel=$rowRCO['rqthlequel'];
    }

    $tabchoixRCO=explode("-", $renseignementscomplementaires);
    $tabchoix2RCO=array();
    $nbchoixRCO=substr_count($renseignementscomplementaires,'-');            

    foreach ($tabchoixRCO as $value) {
        $tabchoix2RCO[$value][0]=$value;
    }
} else {
    $renseignementscomplementaires='';            
    $active='';
    $rqthlequel='';
}


//======================================================================================================
// Submit Renseignements complémentaires
//======================================================================================================
if (!empty($_POST["submitRCO"]) > 0) {
    $choix='';
    if (!empty($_POST["celibataire"])) $choix.='celibataire-';
    if (!empty($_POST["mariee"])) $choix.='mariee-';

    if (!empty($_POST["enfantsacharge"])) $choix.='enfantsacharge-';
    if (!empty($_POST["permisoui"])) $choix.='permisoui-';

    if (!empty($_POST["permisnon"])) $choix.='permisnon-';
    if (!empty($_POST["permisencours"])) $choix.='permisencours-';

    if (!empty($_POST["rhone"])) $choix.='rhone-';
    if (!empty($_POST["isere"])) $choix.='isere-';

    if (!empty($_POST["ain"])) $choix.='ain-';
    if (!empty($_POST["loire"])) $choix.='loire-';

    if (!empty($_POST["hauteloire"])) $choix.='hauteloire-';
    if (!empty($_POST["drome"])) $choix.='drome-';

    if (!empty($_POST["ardeche"])) $choix.='ardeche-';
    if (!empty($_POST["savoie"])) $choix.='savoie-';
    
    if (!empty($_POST["autre"])) $choix.='autre-';
    if (!empty($_POST["rqthoui"])) $choix.='rqthoui-';
    if (!empty($_POST["rqthnon"])) $choix.='rqthnon-';

    if (!empty($_POST["rqthamespeoui"])) $choix.='rqthamespeoui-';
    if (!empty($_POST["rqthamespenon"])) $choix.='rqthamespenon-';

    if (empty($_POST["rqthlequel"]) && !empty($_POST["rqthamespeoui"])) $errsRCO["rqthlequel"][] = "Veuillez renseigner quel aménagement spécifique!";    

    if ($choix == '') $errsRCO["celibataire"][] = "Veuillez renseigner les cases à cochées!";
    else {
        $parametres['RCO']['id']=$id;
        $parametres['RCO']['user']=$user;

        if (!empty($_POST["rqthlequel"]) && !empty($_POST["rqthamespeoui"])) $parametres['RCO']['rqthlequel']=$_POST["rqthlequel"];
        else $parametres['RCO']['rqthlequel']='';
        
        $_SESSION['tab']=$parametres;
        $_SESSION['choix']=$choix;

        // On ajoute les informations en table (modèle)
        if (existe_enreg('personnerc', 'user', $user)) $coderetour=maj_RCO();
        else $coderetour=ajout_RCO();
    }
}


// On affiche la page (vue)
include_once('../../vue/cpro/instic_renseignementscomplementairesAdmin.php');