<?php
session_start(); 

// Tableau contenant les messages d'erreur lies a la validation de chaque
// champ du formulaire.
// On utilisera le nom du champ comme cle du tableau
$errs = array();

if (isset($_SESSION['user'])) $user=$_SESSION['user'];
else $user='';

if (isset($_COOKIE['cookieUser']) && $user == '' ) $user=$_COOKIE['cookieUser'];
//else $user='';

if (isset($_COOKIE['cookieCandidat']) && $user == '') $user=$_COOKIE['cookieCandidat'];
//else $user='';

$_SESSION['user']=$user;
// On demande les informations en table (modèle)
// Connexion à la base
include_once('../../modele/connexion_sql.php');
include_once('../../modele/connexion_mysqli.php');
include_once('../../modele/cpro/get_personne.php');
$personne=get_personne();
$etatcivil=get_etatcivil();
$etatscandidat=get_etatscandidat();

//Etats des fichiers
$upfiletitle='';
$upfileuser=get_mfi();
if (count($upfileuser) != 0) {        
    foreach($upfileuser as $cle => $champs) {
        $id=$champs['id'];           
        $userfile=$champs['user'];            
        $upfiletitle.=$champs['upfiletitle']    .'-';
    }  //Fin foreach      
} else {
    $id='';
    $userfile='vide';
    $upfiletitle='vide';
}

$pos=strpos($userfile, '-');
$ext = substr($userfile, 0, $pos);

$tabpjs=explode('-', $upfiletitle);
$tabpjs2=array();        

foreach ($tabpjs as $value) { $tabpjs2[$value][0]=$value; }

if(isset($tabpjs2['CV'][0])) $cv='OK'; else $cv='KO';
if(isset($tabpjs2['LDM'][0])) $ldm='OK'; else $ldm='KO';
if(isset($tabpjs2['RDN'][0])) $rdn='OK'; else $rdn='KO';
if(isset($tabpjs2['DIPLOMES'][0])) $diplomes='OK'; else $diplomes='KO';

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select etats dossier candidat
//======================================================================================================
if (count($etatscandidat) != 0) {        
    foreach($etatscandidat as $cle => $champs) {
        $id=$champs['id'];           
        $email=$champs['user'];
        $etatcandidature=$champs['etatcandidature'];
        $etatECI=$champs['etatECI'];
        $etatFEN=$champs['etatFEN'];
        $etatIPE=$champs['etatIPE'];
        $etatIPR=$champs['etatIPR'];
        $etatDIV=$champs['etatDIV'];
        $etatFIC=$champs['etatFIC'];            
    }        
}else{
    $id='';           
    $email='';
    $etatcandidature='';
    $etatECI='';
    $etatFEN='';
    $etatIPE='';
    $etatIPR='';
    $etatDIV='';
    $etatFIC='';
}

$imageok="url('http://cpro.jbh/images/ok2.jpg');";
$imageko="url('http://cpro.jbh/images/ko2.jpg');";
$actif='false';
$inactif='true';

//Si les 4 PJs sont là alors màj de la variable "etatFIC"
if ($cv == 'OK' && $ldm='OK' && $rdn == 'OK' && $diplomes == 'OK') { 
    $etatFIC = 'OK';
    $coderetour=maj_etatfic();
}else $etatFIC='KO';


// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select Informations compte
//======================================================================================================
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
        $VAC=$champs['VAC'];        
    }        
}else{
    $titre='';            
    $nom='';
    $prenom='';
    $email='';
    $mdp1='';
    $mdp2='';    
    $VAC='';    
}


// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select Etat civil
//======================================================================================================
if (count($etatcivil) != 0) {        
    foreach($etatcivil as $cle => $champs) {
        $id=$champs['id'];            
        $neele=$champs['neele'];            
        $lieu=$champs['lieu'];
        $nationalite=$champs['nationalite'];
        $localite=$champs['localite'];
        $codepostal=$champs['codepostal'];
        $telephone=$champs['telephone'];
        $nsecuritesociale=$champs['nsecuritesociale'];
        $adresse=$champs['adresse'];
        $email=$champs['email'];
    }
}else{
    $id='';
    $neele='';            
    $lieu='';
    $nationalite='';
    $localite='';
    $codepostal='';
    $telephone='';
    $nsecuritesociale='';
    $adresse='';
    $email='';
}


// On effectue du traitement sur les données (contrôleur)
if (isset($_GET['submitVCA'])) {$submitVCA=$_GET['submitVCA'];
}else{$submitVCA='';}


// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//======================================================================================================
//======================================================================================================
//======================================================================================================
// Submit Valider ma candidature
//======================================================================================================
if ($submitVCA == 'submitVCA') {
	
    // MàJ du top VAC pour ne plus permettre au candidat de mettre à jour sa page espace candidat
    $RcVAC=MaJ_VAC();
    
    //Aller page paiement
    header("Location: http://cpro.jbh/controleur/cpro/controleurVCA.php");
    die();
}


// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//======================================================================================================
//======================================================================================================
//======================================================================================================
// Submit Informations compte
//======================================================================================================
if (!empty($_POST["submitECI"]) > 0) {

    //Contrôles partie Infos compte : IC
    if (empty($_POST["nom"])) $err["nom"][] = "Veuillez renseigner votre Nom!";        
    if (empty($_POST["prenom"])) $errs["prenom"][] = "Veuillez renseigner votre Prénom!";
    if (empty($_POST["titre"])) $errs["titre"][] = "Veuillez renseigner votre Titre!";
    if (empty($_POST["mdp1"])) $errs["mdp1"][] = "Veuillez renseigner votre Mot de Passe!";
    if (empty($_POST["mdp2"])) $errs["mdp2"][] = "Veuillez renseigner votre Mot de Passe de confirmation!";

    if ($_POST["mdp1"] != $_POST["mdp2"]) $errsIC["mdpko"][] = "Veuillez renseigner des Mot de passe identiques!";
        
    //Contrôles partie Etat Civil = EC
    if (empty($_POST["neele"])) $errs["neele"][] = "Veuillez renseigner la Date de naissance!";     
    if (empty($_POST["lieu"])) $errs["lieu"][] = "Veuillez renseigner le Lieu de naissance!";
    if (empty($_POST["nationalite"])) $errs["nationalite"][] = "Veuillez renseigner la Nationalité!";
    if (empty($_POST["localite"])) $errs["localite"][] = "Veuillez renseigner la Localité!";
    if (empty($_POST["codepostal"])) $errs["codepostal"][] = "Veuillez renseigner le Code postal!";
    if (empty($_POST["telephone"])) $errs["telephone"][] = "Veuillez renseigner le Téléphone!";
    if (empty($_POST["nsecuritesociale"])) $errs["nsecuritesociale"][] = "Veuillez renseigner le N° de Sécurité sociale!";
    if (empty($_POST["adresse"])) $errs["adresse"][] = "Veuillez renseigner l'Adresse";

    if (count($errs) == 0) {
        //Partie IC
        $parametres['IC']['titre']=$_POST["titre"];
        $parametres['IC']['nom']=$_POST["nom"];
        $parametres['IC']['prenom']=$_POST["prenom"];
        $parametres['IC']['user']=$user;
        $parametres['IC']['mdp']=$_POST["mdp1"];
        
        //Partie EC
        $parametres['EC']['nom']=$_POST["nom"];
        $parametres['EC']['prenom']=$_POST["prenom"];
        $parametres['EC']['email']=$user;
        $parametres['EC']['neele']=$_POST['neele'];
        $parametres['EC']['lieu']=$_POST['lieu'];
        $parametres['EC']['nationalite']=$_POST['nationalite'];
        $parametres['EC']['localite']=$_POST['localite'];
        $parametres['EC']['codepostal']=$_POST['codepostal'];
        $parametres['EC']['telephone']=$_POST['telephone'];
        $parametres['EC']['nsecuritesociale']=$_POST['nsecuritesociale'];
        $parametres['EC']['adresse']=$_POST['adresse'];
                                
        $_SESSION['tab']=$parametres;        
        
        //MàJ table personne & table etatcivil
        // On ajoute les informations en table (modèle)
        if (existe_enreg('etatcivil', 'email', $user)) {
        	//echo "MAJ ECI: ".$user;
        	//die();
        	$coderetour = maj_ECI();
        	//MàJ code Etat tb etatscandidat
			$rc = maj_etatdossierOK($user, 'etatECI');
        } else $coderetour = ajout_ECI();;
                
        //MàJ code Etat tb etatscandidat
		//$rc = maj_etatdossierOK($user, 'etatECI	');
        
        header("location: controleurECI.php"); // your current page
    }
}

$_SESSION['user']=$user;

// On affiche la page (vue)
include_once('../../vue/cpro/instic_espacecandidat.php');