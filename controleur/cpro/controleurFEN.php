<?php
session_start();

// On demande les informations en table (modèle)
//Selection pour récupérer les infos personne (modèle)
include_once '../../modele/connexion_sql.php';
include_once('../../modele/cpro/get_personne.php');

// Tableau contenant les messages d'erreur lies a la validation de chaque
// champ du formulaire.
// On utilisera le nom du champ comme cle du tableau
$errsMDP = array();

//if (isset($_SESSION['user'])) $user=$_SESSION['user'];
//else $user='';

if (isset($_COOKIE['cookieUser']) && $_COOKIE['cookiecontroleurIndex'] != 'Administrateur') $user=$_COOKIE['cookieUser'];
else $user='';

if (isset($_COOKIE['cookieCandidat']) && $user == '') $user=$_COOKIE['cookieCandidat'];
//else $user='';

$_SESSION['user']=$user;

$personne=get_personne(); //Infos personne pour $user
$personnefe=get_formationsenvisagees(); //Infos formations envisagées pour $user
$alletatscandidat=get_alletatscandidat(); //Infos OK pour $user

//ARTS GRAPHIQUES / WEBDESIGN: AGW
$allAGW=get_all_IdFormations('AGW');

//DEVELOPPEMENT WEB: DW
$allDW=get_all_IdFormations('DW');

//BUREAUX D'ETUDES: BE
$allBE=get_all_IdFormations('BE');

//DEVELOPPEMENT DURABLE
$allDD=get_all_IdFormations('DD');


// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select Informations compte
//======================================================================================================
if (count($personne) != 0) {        
    foreach($personne as $cle => $champs) {
        $idpersonne=$champs['id'];           
        $titre=$champs['titre'];            
        $nom=$champs['nom'];
        $prenom=$champs['prenom'];
        $email=$champs['user'];
        $user=$champs['user'];
        $mdp1=$champs['mdp'];
        $mdp2=$champs['mdp'];        
    } //Fin foreach
    $_SESSION['user']=$user;
} //Fin if

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select formations envisagees code FEN
//======================================================================================================
if (count($alletatscandidat) != 0) {        
    foreach($alletatscandidat as $cle => $champs) {
        if ($champs['sequence'] == '1') $etat1=$champs['valeur']; //code séquence 1 = Dossier en attente de transmission
    }
}

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select formations envisagees code FEN
//======================================================================================================
if (count($personnefe) != 0) {        
    foreach($personnefe as $cle => $champs) {
        //$id=$champs['id'];
        $email=$champs['user'];
        $formationenvisagees=$champs['formationenvisagees'];        
    } //Fin foreach1
} else {
    $id='';           
    $email='';
    $formationenvisagees='';    
} //Fin else

$tabchoix=explode("-", $formationenvisagees);
$tabchoix2=array();
$nbchoix=substr_count($formationenvisagees,'-');            

foreach ($tabchoix as $value) {
    $tabchoix2[$value][0]=$value;
} //Fin foreach2

// On effectue du traitement sur les données (contrôleur)
//===============================================================================================
//Formation(s) envisagée(s)
//===============================================================================================
if (!empty($_POST["submitFE"]) > 0) {    
    $choix='';
    $nbchoix=0;

    //Infographiste Multimédia (BAC + 2) 
    if (!empty($_POST["l1choix1"])) {$choix.='l1choix1-'; $nbchoix++; }
    //CQP Concepteur réalisateur graphiste (BAC + 2) 
    if (!empty($_POST["l2choix1"])) {$choix.='l2choix1-';  $nbchoix++; }
    //Développeur logiciel (BAC + 2) 
    if (!empty($_POST["l3choix1"])) {$choix.='l3choix1-';  $nbchoix++; }
    //Concepteur développeur informatique (BAC + 3) 
    if (!empty($_POST["l4choix1"])) {$choix.='l4choix1-';  $nbchoix++; }
    //Technicien supérieur en conception industrielle de systèmes mécaniques (BAC + 2) 
    if (!empty($_POST["l5choix1"])) {$choix.='l5choix1-';  $nbchoix++; }
    //CQP Dessinateur Bureau d'étude (option mécanique/électricité ou bâtiment)(BAC + 2) 
    if (!empty($_POST["l6choix1"])) {$choix.='l6choix1-';  $nbchoix++; }
    //CQP Concepteur modélisateur numérique de produits ou de systèmes mécaniques (BAC + 3) 
    if (!empty($_POST["l7choix1"])) {$choix.='l7choix1-';  $nbchoix++; }
    //CQP Technicien de la qualité 
    if (!empty($_POST["l8choix1"])) {$choix.='l8choix1-';  $nbchoix++; }
    //Bachelor Animateur Qualité, Sécurité, Environnement (BAC + 3) 
    if (!empty($_POST["l9choix1"])) {$choix.='l9choix1-';  $nbchoix++; }  
    //Master Management Opérationnel du Développement Durable (BAC + 5) 
    if (!empty($_POST["l10choix1"])) {$choix.='l10choix1-'; $nbchoix++; }
    
    if (!empty($_POST["initial"])) $choix.='initial-';
    if (!empty($_POST["alternance"])) $choix.='alternance-';

    if ($nbchoix > 2) $errsMDP["choixko"][] = "Veuillez choisir au maximum deux formation(s)!";
    
    if (empty($_POST["initial"]) && empty($_POST["alternance"])) $errsMDP["nature"][] = "Veuillez renseigner initial et/ou alternance!";
    
    if ($choix == '') $errsMDP["l1choix1"][] = "Veuillez renseigner une ou deux formation(s) maximum!";
    elseif (count($errsMDP) != 0) {
    } else {        
        $parametres['FE']['user']=$user;
        
        $_SESSION['tab']=$parametres;
        $_SESSION['choix']=$choix;

        //*********************************************
        include_once('../../modele/connexion_mysqli.php');
        
        //Ajout formations envisagees     
        // On ajoute les informations en table (modèle)
        if (existe_enreg('personnefe', 'user', $user)) $coderetour=maj_formationenvisagee();
        else $coderetour=ajout_formationenvisagee();

        if ( $coderetour != "New record created successfully")  $errsCEC["ajoutko"][] = $coderetour;     
        else {            
            //Ajout etats dossiers          
            $parametres['FE']['user']=$user;
            $parametres['FE']['id']=$idpersonne;
$parametres['FE']['etatcandidature']='Dossier en attente de transmission'; //En création au aura toujours 'Dossier en attente de transmission'
            $parametres['FE']['etatECI']="OK";
            $parametres['FE']['etatFEN']="OK";
            $parametres['FE']['etatIPE']="KO";
            $parametres['FE']['etatIPR']="KO";
            $parametres['FE']['etatDIV']="KO";
            $parametres['FE']['etatFIC']="KO";

            $_SESSION['tab']=$parametres;
            $_SESSION['choix']=$choix;

            // On ajoute les informations en table (modèle) si elles n'existent pas
            if (!existe_enreg('etatscandidat', 'user', $user)) { $coderetour=ajout_etatsdossier(); }

            //Début Envoi mail            
            //Accès modele pour mail1 = Confirmation tréation espace candidat en table 'mail'.
         	$_SESSION['mail']='mail1';         	
         	$infosmail=get_mailx(); //Accès tb 'mail' avec mailxx stocké en $_SESSION
         	
     	  	if (count($infosmail) != 0) {        
                foreach($infosmail as $cle => $champs) {
                    $idmail=$champs['id'];           
                    $objet=$champs['objet'];           
                    $contenu=$champs['contenu'];                                
                    $libelle=$champs['libelle'];                                
                    $variables=$champs['variables'];                                
                } //Fin foreach1
                
                //Décomposer la chaine variables en tableau & compter nb variables
            	$tabvariables=explode('-',$variables);
            	
            	switch($idmail){
					case 'mail1':
						$varnomprenom=$tabvariables[0];	
						$varidentifiant=$tabvariables[1];	
						$varmdp=$tabvariables[2];	
								//echo "<br /> user pour mail1: ".$user;
								//die();				
						$parametres['mail']['user']=$user;
			            $parametres['mail']['message']=$contenu;
			            $parametres['mail']['id']=$idpersonne;
			            $parametres['mail']['sujet']=$objet;
			            $parametres['mail']['libelle']=$libelle;
			            $parametres['mail']['idmail']=$idmail;
			            $parametres['mail']['mdp']=$mdp1;			            
			            $parametres['mail']['varnomprenom']=$varnomprenom;
			            $parametres['mail']['varidentifiant']=$varidentifiant;
			            $parametres['mail']['varmdp']=$varmdp;			            
						break;
						
					case 'mail12':
						$varnomprenom=$tabvariables[0];	
						
						$parametres['mail']['user']=$user;
			            $parametres['mail']['message']=$contenu;
			            $parametres['mail']['id']=$idpersonne;
			            $parametres['mail']['sujet']=$objet;
			            $parametres['mail']['idmail']=$idmail;
			            $parametres['mail']['libelle']=$libelle;
			            $parametres['mail']['varnomprenom']=$varnomprenom;			            
						break;
					
					default:
						break;
				}				            
            } //Fin if (count($infosmail) != 0)
                
            $_SESSION['tab']=$parametres;
            
            include_once('../../controleur/cpro/controleurGmail.php');
            //Fin envoi email
            
            //Set cookie*********************************//
			$number_of_days = 10;
			$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days;
			$coderetour=setcookie("cookiecontroleurIndex", "Candidat ", $date_of_expiry, "/");
			$coderetour=setcookie("cookieUser", $user, $date_of_expiry, "/");
            
        }  //Fin else2  
    } //Fin else1
} //Fin de if (!empty($_POST["submitFE"]) > 0)

// On affiche la page (vue)
include_once('../../vue/cpro/instic_formationsenvisagees.php');