<?php
session_start();

//Connexion à la base
include_once '../../modele/connexion_sql.php';

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

 $_SESSION['user']=$user;

$personnefe=get_formationsenvisagees();
$alletatscandidat=get_alletatscandidat();


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
        $id=$champs['id'];
        $email=$champs['user'];
        $formationenvisagees=$champs['formationenvisagees'];        
    }
}else{
    $id='';           
    $email='';
    $formationenvisagees='';    
}

$tabchoix=explode("-", $formationenvisagees);
$tabchoix2=array();
$nbchoix=substr_count($formationenvisagees,'-');            

foreach ($tabchoix as $value) {
    $tabchoix2[$value][0]=$value;
}


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

    if ($nbchoix > 2) $errsFE["choixko"][] = "Veuillez choisir au maximum deux formation(s)!";
    
    if (empty($_POST["initial"]) && empty($_POST["alternance"])) $errsFE["nature"][] = "Veuillez renseigner initial et/ou alternance!";
    
    if ($choix == '') $errsFE["l1choix1"][] = "Veuillez renseigner une ou deux formation(s) maximum!";
    else {        
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
            $id=$_SESSION['id'];
            
            //Ajout etats dossiers
            $parametres['FE']['user']=$user;
            $parametres['FE']['id']=$id;
            $parametres['FE']['etatcandidature']=$etat1;
            $parametres['FE']['etatECI']="OK";
            $parametres['FE']['etatFEN']="OK";
            $parametres['FE']['etatIPE']="KO";
            $parametres['FE']['etatIPR']="KO";
            $parametres['FE']['etatDIV']="KO";
            $parametres['FE']['etatFIC']="KO";

            $_SESSION['tab']=$parametres;
            $_SESSION['choix']=$choix;

            // On ajoute les informations en table (modèle)
            if (existe_enreg('etatscandidat', 'user', $user)) {

            }else{
                $coderetour=ajout_etatsdossier();
            }

            //Envoi mail            
            $parametres['mail']['user']=$user;
            $parametres['mail']['message']="Afin de poursuivre votre inscription, merci de valider votre mail en vous connectant sur votre espace candidat. En pièce jointe, les dossiers de vos formations envisagées.";
            $parametres['mail']['id']=$id;
            $parametres['mail']['sujet']='Mail 1';
                        
            $_SESSION['tab']=$parametres;    
            
            // On affiche la page (vue)
            header("Location: http://localhost/Racine_Site/controleur/cpro/instic_gmail.php");
            die();
        }    
    }
}


// On affiche la page (vue)
include_once('../../vue/cpro/instic_formationsenvisagees_espacecandidat.php');
