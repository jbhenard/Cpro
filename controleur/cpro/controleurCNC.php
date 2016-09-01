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
else { $user=''; }

if (isset($_COOKIE['cookieUser']) && $user == '' ) $user=$_COOKIE['cookieUser'];
//else $user='';

$_SESSION['user']=$user;

// On demande les informations en table (modèle)
//Selection pour récupérer les infos personne (modèle)
include_once('../../modele/connexion_sql.php');
include_once('../../modele/cpro/get_personne.php');

//Accès à la class Personne & à la class d'accès au SGBD pour cette class personne, son'PersonneManager'
include_once('../../modele/cpro/Personne.class.php');
include_once('../../modele/cpro/PersonneManager.class.php');
    
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
        //Début mode POO ajout Personne
        	//Il n'est pas obligatoire de renseigner les attributs de type date (gérés au moment de l'insert').		
			$données=[
			  'Id' => $_POST['nom'].' '.$_POST['prenom'],
			  'Titre' => 'A renseigner',
			  'Nom' => $_POST['nom'],
			  'Prenom' => $_POST['prenom'],
			  'User' => $email,
			  'Mdp' => $_POST["mdp1"],  
			  'Profil' => 'Candidat'
			];

			$Objpersonne = new Personne($données);			
			$manager = new PersonneManager($bdd);
			    
			$coderetour=$manager->add($Objpersonne);
        //Fin mode POO

        if ( $coderetour != "Record inserted successfully tb personne.")  $errsCNC["ajoutko"][] = $coderetour;     
        else {
        	//Set cookie*********************************//
        	$number_of_days = 10;
        	$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days;
        	        	
            // On affiche la page (vue)
            header("Location: http://cpro.jbh/controleur/cpro/controleurFEN.php");
            $profil='Candidat';
            $coderetour=setcookie("cookiecontroleurIndex", $profil, $date_of_expiry, "/");
            $coderetour=setcookie("cookieUser", $email, $date_of_expiry, "/");        
            die();
        } //Fin if3         
    } //Fin if2
} //Fin if1 (!empty($_POST["submitCNC"]) > 0)

// On affiche la page (vue)
include_once('../../vue/cpro/instic_accueilCNC.php');