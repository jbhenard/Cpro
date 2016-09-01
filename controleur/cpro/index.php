<?php
session_cache_limiter('none');
session_start();

// Tableau contenant les messages d'erreur lies a la validation de chaque
// champ du formulaire.
// On utilisera le nom du champ comme cle du tableau
$errsLOG = array();
$errsCNC   = array();

//Set cookie délai
$number_of_days = 10;
$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days;

//Si première connection, on initialise la variable d'environnement
if (isset($_SESSION['user'])) $user=$_SESSION['user'];
else { $user=''; }

if (isset($_COOKIE['cookieUser']) && $user =='') $user=$_COOKIE['cookieUser'];
//else $user='';

$_SESSION['user']=$user;

// On demande les informations en table (modèle)
//Selection pour récupérer les infos personne (modèle)
include_once('modele/cpro/get_personne.php');
   
// On effectue du traitement sur les données (contrôleur)
//===============================================================================================
//Vous avez déjà un compte? code login = nom du bouton de type submit
//===============================================================================================
if (!empty($_POST["submitLOG"]) > 0) {

    if (empty($_POST["mail_login"])) $errsLOG["mail"][] = "Veuillez renseigner l'Adresse de courriel!";
    if (empty($_POST["mdp_login"])) $errsLOG["mdp"][] = "Veuillez renseigner le mot de passe!";

    $user=$_POST['mail_login'];    
    $_SESSION['user'] = $user;
    
    //L'email n'est pas bonne.
    if (!filter_var($user, FILTER_VALIDATE_EMAIL)) { $errsLOG["verifmmail"][] = "Veuillez renseigner une Adresse de courriel valide!"; }

    $mdp=$_POST['mdp_login'];
    
    $personne=get_personne();

    // On effectue du traitement sur les données (contrôleur)            
    if (count($personne) != 0) {        
        foreach($personne as $cle => $champs) {
            $mdpBDD=$champs['mdp'];
            $profil=$champs['profil'];            
        }        
    }else{ $mdpBDD='MdP Non trouvé'; }
    
    if ($mdp == $mdpBDD) {    
        if ($profil == 'Candidat'){
            header("Location: http://cpro.jbh/controleur/cpro/controleurECI.php");
            $coderetour=setcookie("cookiecontroleurIndex", $profil, $date_of_expiry, "/");
            $coderetour=setcookie("cookieUser", $user, $date_of_expiry, "/");            
            die();
        }else{
            header("Location: http://cpro.jbh/controleur/cpro/controleurAdmin.php");
            $coderetour=setcookie("cookiecontroleurIndex", $profil, $date_of_expiry, "/");
            $coderetour2=setcookie("cookiename", $profil, $date_of_expiry, "/");
            $coderetour=setcookie("cookieUser", utf8_decode($user), $date_of_expiry, "/");
            $coderetour=setcookie("cookieCandidat", " ", $date_of_expiry, "/");
            die();
        }
    }else{ $errsLOG["MdPko"][] = "Veuillez renseigner un Mot de Passe correct!"; }    
} //Fin if (!empty($_POST["submitLOG"]) > 0)

// On affiche la page (vue)
include_once('vue/cpro/instic_accueil.php');