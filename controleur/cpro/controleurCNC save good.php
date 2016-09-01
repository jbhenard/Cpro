<?php
session_cache_limiter('none');
session_start();

// Tableau contenant les messages d'erreur lies a la validation de chaque
// champ du formulaire.
// On utilisera le nom du champ comme cle du tableau
$errsLOG = array();
$errsCNC   = array();

//Si première connection, on initialise la variable d'environnement
if (isset($_SESSION['user'])) $user=$_SESSION['user'];
else {
    $user='admin@free.fr';
    $_SESSION['user']='admin@free.fr';
}

// On demande les informations en table (modèle)
//Selection pour récupérer les infos personne (modèle)
include_once('../../modele/connexion_sql.php');
include_once('../../modele/cpro/get_personne.php');
    
// On effectue du traitement sur les données (contrôleur)
//===============================================================================================
//Vous souhaitez vous inscrire? code CNC = Création Espace Candidat
//===============================================================================================
if (!empty($_POST["submitCNC"]) > 0) {    
    if (empty($_POST["nom"])) $errsCNC["nom"][] = "Veuillez renseigner le Nom!";
    if (empty($_POST["prenom"])) $errsCNC["prenom"][] = "Veuillez renseigner le Prénom!";
    if (empty($_POST["mail"])) $errsCNC["mail"][] = "Veuillez renseigner l'Adresse de courriel!";
    if (empty($_POST["mdp1"])) $errsCNC["mdp1"][] = "Veuillez renseigner le mot de passe!";    

    $email=$_POST["mail"];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        //L'email n'est pas bonne.
        $errsCNC["verifmmail"][] = "Veuillez renseigner une Adresse de courriel valide!";
    }

    $mdp1=$_POST['mdp1'];
    
    if(existe_enreg('personne', 'user', $email)) $errsCNC["userdoubleko"][] = "Ce compte - ".$email." - existe déjà!";

    if (count($errsCNC) == 0) {        
        $parametres['CNC']['titre']='';        
        $parametres['CNC']['nom']=$_POST["nom"];
        $parametres['CNC']['prenom']=$_POST["prenom"];
        $parametres['CNC']['user']=$email;
        $parametres['CNC']['mdp']=$_POST["mdp1"];
        $parametres['CNC']['datec']=date("y-m-d");

        //$ddj7 = date("Y-m-d"); // date du jour
        //$ddj7 = strtotime(date("Y-m-d", strtotime($ddj7))."+7 day");
        //$parametres['CNC']['daterelance']=$ddj7;
        //echo "<br/>dt relance: " +  $ddj7;
        //die();

        //$ddj21 = date("Y-m-d"); // date du jour
        //$ddj21 = strtotime(date("Y-m-d", strtotime($ddj7))."+21 day");
        //$parametres['CNC']['datearchive']=$ddj21;

        $_SESSION['tab']=$parametres;                           
        $_SESSION['user'] = $email;        
        
        // Connexion à la base
        include_once('../../modele/connexion_mysqli.php');
        $coderetour=ajout_personne();

        if ( $coderetour != "New record created successfully")  $errsCNC["ajoutko"][] = $coderetour;     
        else {
            // On affiche la page (vue)
            header("Location: http://localhost/Racine_Site/controleur/cpro/controleurFEN.php");
            die();
        }          
    }
}


// On effectue du traitement sur les données (contrôleur)
//===============================================================================================
//Vous avez déjà un compte? code login = nom du bouton de type submit
//===============================================================================================
if (!empty($_POST["submitGoogle"]) > 0) {
    header("Location: http://localhost/Racine_Site/GoogleLogin/index.php");
    die();
}

// On effectue du traitement sur les données (contrôleur)
//===============================================================================================
//Vous avez déjà un compte? code login = nom du bouton de type submit
//===============================================================================================
if (!empty($_POST["submitLOG"]) > 0) {

    if (empty($_POST["mail_login"])) $errsLOG["mail"][] = "Veuillez renseigner l'Adresse de courriel!";
    if (empty($_POST["mdp_login"])) $errsLOG["mdp"][] = "Veuillez renseigner le mot de passe!";

    $user=$_POST['mail_login'];    
    $_SESSION['user'] = $user;
    
    if (!filter_var($user, FILTER_VALIDATE_EMAIL)) {
        //L'email n'est pas bonne.
        $errsLOG["verifmmail"][] = "Veuillez renseigner une Adresse de courriel valide!";
    }

    $mdp=$_POST['mdp_login'];
    
    $personne=get_personne();

    // On effectue du traitement sur les données (contrôleur)            
    if (count($personne) != 0) {        
        foreach($personne as $cle => $champs) {
            $mdpBDD=$champs['mdp'];
            $profil=$champs['profil'];            
        }        
    }else{
        $mdpBDD='';
    }
    
    if ($mdp == $mdpBDD) {    

        //Setr cookie*********************************//
        $number_of_days = 10;
        $date_of_expiry = time() + 60 * 60 * 24 * $number_of_days;
        //$coderetour=setcookie("cookiecontroleurIndex", "$profil", $date_of_expiry);

        //echo "<br/>RC= " + $coderetour + ($coderetour == 'TRUE') ? " Cookie set OK!<br />" : " Cookie set KO KO !<br />"; 
        //echo $_COOKIE['cookiecontroleurIndex'];

        if ($profil == 'Candidat'){
            header("Location: http://localhost/Racine_Site/controleur/cpro/controleurECI.php");
            $coderetour=setcookie("cookiecontroleurIndex", $profil, $date_of_expiry, "/");
            $coderetour=setcookie("cookieUser", $user, $date_of_expiry, "/");
            //echo "<br/>RC= " + $coderetour + ($coderetour == 'TRUE') ? " Cookie set OK!<br />" : " Cookie set KO KO !<br />"; 
            //echo $_COOKIE['cookiecontroleurIndex'];
            die();
        }else{
            header("Location: http://localhost/Racine_Site/controleur/cpro/controleurAdmin.php");
            $coderetour=setcookie("cookiecontroleurIndex", $profil, $date_of_expiry, "/");
            $coderetour2=setcookie("cookiename", $profil, $date_of_expiry, "/");
            $coderetour=setcookie("cookieUser", utf8_decode($user), $date_of_expiry, "/");
            //echo "<br/>RC= " + $coderetour + ($coderetour == 'TRUE') ? " Cookie set OK!<br />" : " Cookie set KO KO !<br />"; 
            //echo $_COOKIE['cookiecontroleurIndex'];
            die();
        }
    }else{
        $errsLOG["MdPko"][] = "Veuillez renseigner un Mot de Passe correct!";
    }    
}

// On affiche la page (vue)
include_once('../../vue/cpro/instic_accueilCNC.php');