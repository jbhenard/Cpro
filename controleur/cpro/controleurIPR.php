<?php
session_start();

$errsIPr = array();

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

//$personneip=get_infospedagogiques();
$personneIPr=get_infosprofessionnelles();
$personne=get_personne();

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select Informations professionnelles
//======================================================================================================
if (count($personneIPr) != 0) {        
    foreach($personneIPr as $cle => $rowIPr) {
        $id=$rowIPr['id'];
        $spa=$rowIPr['spa'];
        $active=$rowIPr['active'];
        
        $numerode=$rowIPr['numerode'];
        $datede=$rowIPr['datede'];
        
        $salarienomentreprise=$rowIPr['salarienomentreprise'];
        $salarienature=$rowIPr['salarienature'];

        $stagiairenomentreprise=$rowIPr['stagiairenomentreprise'];
        $stagiaireduree=$rowIPr['stagiaireduree'];
        $stagiairenature=$rowIPr['stagiairenature'];
        
        $alternancenomentreprise=$rowIPr['alternancenomentreprise'];
        $alternanceduree=$rowIPr['alternanceduree'];
        $alternancetype=$rowIPr['alternancetype'];
        $alternanceformation=$rowIPr['alternanceformation'];

        $autresituationlib=$rowIPr['autresituationlib'];            
    } //Fin foreach1
    
    $tabchoixIPr=explode("-", $spa);
    $tabchoix2IPr=array();
    $nbchoixIPr=substr_count($spa,'-');            

    foreach ($tabchoixIPr as $value) {
        $tabchoix2IPr[$value][0]=$value;                
    } //Fin foreach2
}else{
	$id='';
    $spa='';            
    $active='';
    $numerode='';
    $datede='';          
    
    $salarienomentreprise='';            
    $salarienature='';  

    $stagiairenomentreprise='';
    $stagiaireduree='';
    $stagiairenature='';
    
    $alternancenomentreprise='';
    $alternanceduree='';
    $alternancetype='';
    $alternanceformation='';
    
    $autresituationlib='';
}


// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
// Submit Informations professionnelles
//======================================================================================================
if (!empty($_POST["submitIPr"]) > 0) {
    $choix='';
    if (!empty($_POST["etudiant"])) $choix.='etudiant-';
    if (!empty($_POST["contratdepro"])) $choix.='contratdepro-';
    if (!empty($_POST["contratdapprentissage"])) $choix.='contratdapprentissage-';
    if (!empty($_POST["salarie"])) $choix.='salarie-';
    if (!empty($_POST["demandeurdemploi"])) $choix.='demandeurdemploi-';
    if (!empty($_POST["stagiaire"])) $choix.='stagiaire-';
    if (!empty($_POST["salarietpsplein"])) {
        $choix.='salarietpsplein-';
        if (!empty($_POST["salarienomentreprise"])) $parametres['IPr']['salarienomentreprise']=$_POST["salarienomentreprise"];        
        if (!empty($_POST["salarienature"])) $parametres['IPr']['salarienature']=$_POST["salarienature"];
    }
    if (!empty($_POST["salarietpspartiel"])) {
        $choix.='salarietpspartiel-';
        if (!empty($_POST["salarienomentreprise"])) $parametres['IPr']['salarienomentreprise']=$_POST["salarienomentreprise"];        
        if (!empty($_POST["salarienature"])) $parametres['IPr']['salarienature']=$_POST["salarienature"];    
    }
    if (!empty($_POST["alternance"])) $choix.='alternance-';
    if (!empty($_POST["autresituation"])) $choix.='autresituation-';

    if (empty($_POST["numerode"]) && !empty($_POST["demandeurdemploi"])) $errsIPr["numerode"][] = "Veuillez renseigner le numéro pôle emploi!";    
    if (empty($_POST["datede"]) && !empty($_POST["demandeurdemploi"])) $errsIPr["datede"][] = "Veuillez renseigner la Date pôle emploi!";    
    if (empty($_POST["stagiairenomentreprise"]) && !empty($_POST["stagiaire"])) $errsIPr["stagiaire"][] = "Veuillez renseigner le Nom de votre etreprise! ";        
    if (empty($_POST["stagiaireduree"]) && !empty($_POST["stagiaire"])) $errsIPr["stagiaire2"][] = "Veuillez renseigner la Durée! ";        
    if (empty($_POST["stagiairenature"]) && !empty($_POST["stagiaire"])) $errsIPr["stagiaire3"][] = "Veuillez renseigner la Nature du stage! ";        
    
    if (empty($_POST["salarienomentreprise"]) && !empty($_POST["salarietpsplein"])) $errsIPr["salarietpsplein"][] = "Veuillez renseigner le Nom de votre etreprise! ";        
    if (empty($_POST["salarienature"]) && !empty($_POST["salarietpsplein"])) $errsIPr["salarietpsplein2"][] = "Veuillez renseigner la Nature de l'emploi!";     

    if (empty($_POST["salarienomentreprise"]) && !empty($_POST["salarietpspartiel"])) $errsIPr["salarietpspartiel"][] = "Veuillez renseigner le Nom de votre etreprise!";        
    if (empty($_POST["salarienature"]) && !empty($_POST["salarietpspartiel"])) $errsIPr["salarietpspartiel2"][] = "Veuillez renseigner la Nature de l'emploi!";     

    if (empty($_POST["alternancenomentreprise"]) && !empty($_POST["alternance"])) $errsIPr["alternance"][] = "Veuillez renseigner le Nom de votre entreprise!";    
    if (empty($_POST["alternanceduree"]) && !empty($_POST["alternance"])) $errsIPr["alternance2"][] = "Veuillez renseigner la Durée!";    
    if (empty($_POST["alternancetype"]) && !empty($_POST["alternance"])) $errsIPr["alternance3"][] = "Veuillez renseigner le Type de contrat!";    
    if (empty($_POST["alternanceformation"]) && !empty($_POST["alternance"])) $errsIPr["alternance4"][] = "Veuillez renseigner la Formation suivie!";    
    
    if (empty($_POST["autresituationlib"]) && !empty($_POST["autresituation"])) $errsIPr["autresituation"][] = "Veuillez renseigner votre Autre situation!";    

    if ($choix == '') $errsIPr["etudiant"][] = "Veuillez renseigner les cases à cochées!";
    else {
    	    	
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
		
        $parametres['IPr']['id']=$id;
        $parametres['IPr']['email']=$user;        

        if (!empty($_POST["numerode"]) && !empty($_POST["demandeurdemploi"])) $parametres['IPr']['numerode']=$_POST["numerode"];
        else $parametres['IPr']['numerode']='';

        if (!empty($_POST["datede"]) && !empty($_POST["demandeurdemploi"])) $parametres['IPr']['datede']=$_POST["datede"];
        else  $parametres['IPr']['datede']='';

        if (!empty($_POST["stagiairenomentreprise"]) && !empty($_POST["stagiaire"])) $parametres['IPr']['stagiairenomentreprise']=$_POST["stagiairenomentreprise"];
        else $parametres['IPr']['stagiairenomentreprise']='';
        
        if (!empty($_POST["stagiaireduree"]) && !empty($_POST["stagiaireduree"])) $parametres['IPr']['stagiaireduree']=$_POST["stagiaireduree"];
        else $parametres['IPr']['stagiaireduree']='';        
        
        if (!empty($_POST["stagiairenature"]) && !empty($_POST["stagiaire"])) $parametres['IPr']['stagiairenature']=$_POST["stagiairenature"];
        else $parametres['IPr']['stagiairenature']='';        
                         
        if (!empty($_POST["alternancenomentreprise"]) && !empty($_POST["alternance"])) $parametres['IPr']['alternancenomentreprise']=$_POST["alternancenomentreprise"];
        else $parametres['IPr']['alternancenomentreprise']='';        
        
        if (!empty($_POST["alternanceduree"]) && !empty($_POST["alternance"])) $parametres['IPr']['alternanceduree']=$_POST["alternanceduree"];
        else $parametres['IPr']['alternanceduree']='';        
        
        if (!empty($_POST["alternancetype"]) && !empty($_POST["alternance"])) $parametres['IPr']['alternancetype']=$_POST["alternancetype"];
        else $parametres['IPr']['alternancetype']='';        
        
        if (!empty($_POST["alternanceformation"]) && !empty($_POST["alternance"])) $parametres['IPr']['alternanceformation']=$_POST["alternanceformation"];
        else $parametres['IPr']['alternanceformation']='';        

        if (!empty($_POST["autresituationlib"]) && !empty($_POST["autresituation"])) $parametres['IPr']['autresituationlib']=$_POST["autresituationlib"];
        else $parametres['IPr']['autresituationlib']='';        

        $_SESSION['tab']=$parametres;
        $_SESSION['choix']=$choix;
        
        // On ajoute les informations en table (modèle)
         if (existe_enreg('personneipr', 'user', $user)) {
         	$coderetour=maj_infosprofessionnelles(); 
         	//MàJ code Etat tb etatscandidat
			//include_once '../../modele/connexion_mysqli.php';
			$rc = maj_etatdossierOK($user, 'etatIPR');
			//echo "RC= " . $rc;
         } else { $coderetour=ajout_infosprofessionnelles(); }
		
        header("location: controleurIPR.php"); // your current page
    };
}


// On affiche la page (vue)
include_once('../../vue/cpro/instic_infosprofessionnelles.php');