<?php
session_start();

// On demande les informations en table (modèle)
// Connexion à la base
include_once('../../modele/connexion_sql.php');
include_once('../../modele/cpro/get_personne.php');

// Tableau contenant les messages d'erreur lies a la validation de chaque
// champ du formulaire.
// On utilisera le nom du champ comme cle du tableau
$errsMDP = array();

//if(isset($_GET['errsMDP']) && !empty($_GET['errsMDP'])) $errsMDP['RCGmail'][] = $_GET['errsMDP'];

// S'il s'agit du premier affichage, le bouton submit n'a pas ete presse
// il n'y a pas de validation a effectuer. Sinon $_POST["submit"] n'est pas
// vide (et contient la valeur "Enregistrer")
if (!empty($_POST["submitMDP"]) > 0) {
	
    if (empty($_POST["nom"]) && empty($_POST["mail"])) $errsMDP["nom"][] = "Veuillez renseigner le Nom et/ou l'Adresse de courriel!";
    //if (empty($_POST["mail"])) $errsMDP["nom"][] = "Veuillez renseigner le Nom et/ou l'Adresse de courriel!";

    if (!empty($_POST["nom"])) $nom=$_POST["nom"];
    else $nom='';

    $_SESSION['nom']=$nom;

    if (!empty($_POST["mail"])) $email=$_POST["mail"];
    else $email='';

    $findme   = '@';
    $pos = strpos($email, $findme);

    $_SESSION['user']=$email;    

    // Notez notre utilisation de ===.  == ne fonctionnerait pas comme attendu
    // car la position de 'a' est la 0-ième (premier) caractère.
    if ($pos === false && !empty($_POST["nom"])) {
        //Si la saisie est un Nom
            
            // On demande les informations en table (modèle) à partir du nom saisi dans instic_nouveaumdp.php
            $personne=get_personne2();
            
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
                }        
            }else{
                $titre='';            
                $nom='';
                $prenom='';
                $email='';
                $mdp1='';
                $mdp2='';
                $errsMDP["nomko"][] = "Veuillez renseigner un Nom existant!";
            }
    }else{        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //L'email n'est pas bonne.
            $errsMDP["verifmmail"][] = "Veuillez renseigner une Adresse de courriel valide!";
        }else{
            //Si la saisie est une Adresse de courriel
            if (!empty($_POST["mail"])) {
                
                // On demande les informations en table (modèle)
                $personne=get_personne();
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
                    $errsMDP["emailko"][] = "Veuillez renseigner une Adresse de courriel existante!";
                }             
            }
        }
    }

    if (count($errsMDP) == 0) {
        // Les données du formulaires ont été validée (pas d'erreur trouvée)
        // faire ce qui doit être fait (envoi de mail, enregstrement en base) et rediriger vers la page suivante
        
        //MàJ de l'ancien MdP avec le nouveau                
        $coderetour=reinit_MDP();

        if ( $coderetour != "New record updated successfully")  $errsMDP["màjmdpko"][] = $coderetour;     
        else {        
         //Début Envoi mail        
         
         	//Accès modele pour mail12 = Nouveau MDP en table 'mail'.
         	$_SESSION['mail']='mail12';         	
         	$infosmail=get_mailx(); //accès tb 'mail' avec mailxx stocké en $_SESSION
         	
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
						
						$parametres['mail']['user']=$email;
			            $parametres['mail']['message']=$contenu;
			            $parametres['mail']['libelle']=$libelle;
			            $parametres['mail']['id']=$id;
			            $parametres['mail']['sujet']=$objet;
			            $parametres['mail']['idmail']=$idmail;
			            $parametres['mail']['varnomprenom']=$varnomprenom;
			            $parametres['mail']['varidentifiant']=$varidentifiant;
			            $parametres['mail']['varmdp']=$varmdp;			            
						break;
						
					case 'mail12':
						$varnomprenom=$tabvariables[0];	
						
						$parametres['mail']['user']=$email;
			            $parametres['mail']['message']=$contenu;
			            $parametres['mail']['libelle']=$libelle;
			            $parametres['mail']['id']=$id;
			            $parametres['mail']['sujet']=$objet;
			            $parametres['mail']['idmail']=$idmail;
			            $parametres['mail']['varnomprenom']=$varnomprenom;			            
						break;
					
					default:
						break;
				}				            
            } //Fin if (count($infosmail) != 0)
                
            $_SESSION['tab']=$parametres;            
            
            include_once('../../controleur/cpro/controleurGmail.php');            
        } //Fin de else
        //Fin Envoi mail   
    } //Fin  if (count($errsMDP) == 0)
} //Fin if (!empty($_POST["submitMDP"]) > 0)


// On affiche la page (vue)
include_once('../../vue/cpro/instic_nouveaumdp.php');