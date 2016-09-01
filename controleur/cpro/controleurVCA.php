<?php
session_start();

// Tableau contenant les messages d'erreur lies a la validation de chaque
// champ du formulaire.
// On utilisera le nom du champ comme cle du tableau
$errsMDP = array();

//Connexion à la base
include_once '../../modele/connexion_sql.php';
include_once '../../modele/connexion_mysqli.php';

// On demande les informations en table (modèle)
//Selection pour récupérer les infos personne (modèle)
include_once('../../modele/cpro/get_personne.php');

if (isset($_SESSION['user'])) $user=$_SESSION['user'];
else $user='';

if (isset($_COOKIE['cookieUser'])) $user=$_COOKIE['cookieUser'];
else $user='';

$_SESSION['user']=$user;

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
	}//Fin foreach     
} //Fin if (count($personne) != 0)
                
if (isset($_GET['submitparCB'])) {$choix=$_GET['submitparCB']; 
}else{$choix=''; }

if (isset($_GET['submitparVIR'])) {$choix2=$_GET['submitparVIR']; 
}else{$choix2=''; }

if (isset($_GET['submitparCHQ'])) {$choix3=$_GET['submitparCHQ']; 
}else{$choix3=''; }

//Si CB
if ($choix == 'submitparCB') {
	header("Location: http://cpro.jbh/CMCIC_Paiement_3_0i/Phase1Aller.php");
	die();
} //Fin if ($choix == 'submitparCB')

//Si Virement ou //Si Chèque on force $_GET['submitparCHQ'] reçoit 'submitparVIR'
if ($choix2 == 'submitparVIR') {	
	//echo 'mail 5 à gérer suite à submitparVIR <br />';
	 //Début Envoi mail         
         	//Accès modele pour mail5 = Mail 5 : Dossier en attente de règlement.
         	$_SESSION['mail']='mail5';         	
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
            	
				$varnomprenom=$tabvariables[0];	
				$varformation1=$tabvariables[1];	
				$varformation2=$tabvariables[2];	
				
				$parametres['mail']['user']=$email;
	            $parametres['mail']['message']=$contenu;
	            $parametres['mail']['libelle']=$libelle;
	            $parametres['mail']['id']=$id;
	            $parametres['mail']['sujet']=$objet;
	            $parametres['mail']['idmail']=$idmail;
	            $parametres['mail']['varnomprenom']=$varnomprenom;
	            $parametres['mail']['varformation1']=$varformation1;
	            $parametres['mail']['varformation2']=$varformation2;					
				
            } //Fin if (count($infosmail) != 0)
             
            //Formations envisagées:
            $personnefe=get_formationsenvisagees(); //Infos formations envisagées pour $user
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
			    
			    $tabchoix=explode("-", $formationenvisagees);
				$tabchoix2=array();
				$nbchoix=substr_count($formationenvisagees,'-');            

				//Début POO
				//Accès à la class Personne & à la class d'accès au SGBD pour cette class personne, son'PersonneManager'
				include_once('../../modele/cpro/Formation.class.php');
				include_once('../../modele/cpro/FormationManager.class.php');

				//Formation $value        	
					$manager = new FormationManager($bdd);					
				//Fin mode POO				
				$parametres['mail']['formation1']='';
				$parametres['mail']['formation2']='';
				$fe1='';
				foreach ($tabchoix as $value) {
				    $tabchoix2[$value][0]=$value;
				    
				    //if( strstr($chaine1, $chaine2)) { 
					//Code à exécuter si la sous-chaine chaine2 est trouvée dans chaine1 
					
					
				    if (strstr($value, "choix1")) {
						$formationchoisie=$manager->get($value);				    	
				    	//echo "<br />valeur fe: ".$value." - libelle= ".$formationchoisie->getFormation();
						if ($fe1 !='KO') {
							 $libformation1=$formationchoisie->getFormation() ;
							 $fe1='KO';
						}
						if ($fe1 == 'KO') $libformation2=$formationchoisie->getFormation() ;
					} //Fin 
				} //Fin foreach2
			} //Fin if (count($personnefe) != 0)
                    
            //echo "<br /> fe1= ".$libformation1."<br />";
            //echo "fe2= ".$libformation2;    
            $parametres['mail']['formation1']=$libformation1;
			$parametres['mail']['formation2']=$libformation2;
            
            $_SESSION['tab']=$parametres;            
            
            include_once('../../controleur/cpro/controleurGmail.php');                   
        //Fin Envoi mail  
} //Fin if ($choix2 == 'submitparVIR')


// On affiche la page (vue)
include_once('../../vue/cpro/instic_validermacandidature.php');