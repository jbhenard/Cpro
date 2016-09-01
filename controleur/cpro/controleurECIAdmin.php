<?php
session_start(); 

// Tableau contenant les messages d'erreur lies a la validation de chaque
// champ du formulaire.
// On utilisera le nom du champ comme cle du tableau
$errs = array();

//Set cookie délai
$number_of_days = 10;
$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days;

//C'est le user du candidat que l'admin a sélectionné dans la liste de l'espace Administrateur...', ex: jbhenard@free.fr
if (isset($_GET['userAdmin'])) $user=$_GET['userAdmin'];
else $user='';

//C'est le user de l'admin ici... (ex: admin@free.fr)
if (isset($_COOKIE['cookieUser']) && $user =='') $userAdmin=$_COOKIE['cookieUser'];
else $userAdmin='';

if (isset($_COOKIE['cookieCandidat']) && $user == '') $user=$_COOKIE['cookieCandidat'];
//else $user='';

$_SESSION['user']=$user;
$coderetour=setcookie("cookieCandidat", $user, $date_of_expiry, "/");

// On demande les informations en table (modèle)
// Connexion à la base
include_once('../../modele/connexion_sql.php');
include_once('../../modele/connexion_mysqli.php');
include_once('../../modele/cpro/get_personne.php');
$personne=get_personne();
$etatcivil=get_etatcivil();
$etatscandidat=get_etatscandidat();
$alletatscandidat=get_alletatscandidat();


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
        $dateentretien=$champs['dateentretien']; 
    }        
}else{
    $titre='';            
    $nom='';
    $prenom='';
    $email='';
    $mdp1='';
    $mdp2='';    
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
//======================================================================================================
//======================================================================================================
//======================================================================================================
//======================================================================================================
// Submit Informations Admin pour candidat
//======================================================================================================
if (!empty($_POST["submitArcAdmin"]) > 0) {
    $_SESSION['user']=$user;
    //echo $user;
    $coderetour = ajout_personneArchive();
    header('location http://cpro.jbh/controleur/cpro/controleurAdmin.php');
    die();
}

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//======================================================================================================
//======================================================================================================
//======================================================================================================
// Submit Informations Admin pour candidat
//======================================================================================================
if (!empty($_POST["submitEnregAdmin"]) > 0) {
	//Gérer l'envoi des mails selon état MàJ par l'administrateur des dossier de candidature.
	
	//======================================================================================================
	//Dossier en cours d analyse ===> Mail6 : 3 variables [NOMPrenom]-[FORMATION1]-[FORMATION2]
	//======================================================================================================
	if($_POST['etats'] == 'Dossier en cours d analyse') {
		//echo("etat Admin a sélectionné: ".$_POST['etats']);
		//die();
		$_SESSION['mail']='mail6';
		//Début Envoi mail         
     	//Accès modele pour mail5 = Mail 5 : Dossier en attente de règlement.
     	//$_SESSION['mail']='mail5';         	
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
			
			$parametres['mail']['user']=$user;
            $parametres['mail']['message']=$contenu;
            $parametres['mail']['libelle']=$libelle;
            $parametres['mail']['id']=$idpersonne;
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
        //Fin Envoi mail 6 
	} //Fin if($_POST['etats'] == 'Dossier en cours d analyse') 
	//======================================================================================================
	
	//======================================================================================================
	//Dossier en attente de règlement ===> Mail7 : 3 variables [NOMPrenom]-[FORMATION1]-[FORMATION2]
	//======================================================================================================
	if($_POST['etats'] == 'Dossier en attente de règlement') {
		//echo("etat Admin a sélectionné: ".$_POST['etats']);
		//die();
		$_SESSION['mail']='mail7';
		//Début Envoi mail         
     	//Accès modele pour mail5 = Mail 5 : Dossier en attente de règlement.
     	//$_SESSION['mail']='mail5';         	
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
			
			$parametres['mail']['user']=$user;
            $parametres['mail']['message']=$contenu;
            $parametres['mail']['libelle']=$libelle;
            $parametres['mail']['id']=$idpersonne;
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
        //Fin Envoi mail 7
	} //Fin if($_POST['etats'] == 'Dossier en attente de règlement') 
	//======================================================================================================
	
	//======================================================================================================
	//Dossier en cours d analyse ===> Mail8 : 3 variables [NOMPrenom]-[FORMATION1]-[FORMATION2]
	//======================================================================================================
	if($_POST['etats'] == 'Dossier en cours d analyse') {
		//echo("etat Admin a sélectionné: ".$_POST['etats']);
		//die();
		$_SESSION['mail']='mail8';
		//Début Envoi mail         
     	//Accès modele pour mail5 = Mail 5 : Dossier en attente de règlement.
     	//$_SESSION['mail']='mail5';         	
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
			
			$parametres['mail']['user']=$user;
            $parametres['mail']['message']=$contenu;
            $parametres['mail']['libelle']=$libelle;
            $parametres['mail']['id']=$idpersonne;
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
        //Fin Envoi mail 8
	} //Fin if($_POST['etats'] == 'Dossier en cours d analyse') 
	//======================================================================================================
	
	//======================================================================================================
	//Convocation en entretien ===> Mail9 : 3 variables [NOMPrenom]-[FORMATION1]-[FORMATION2] gérées sur 4.
	//Il manque [DATE ENTRETIEN].
	//======================================================================================================
	if($_POST['etats'] == 'Convocation en entretien') {
		//echo("etat Admin a sélectionné: ".$_POST['etats']);
		//die();
		$_SESSION['mail']='mail9';
		//Début Envoi mail         
     	//Accès modele pour mail5 = Mail 5 : Dossier en attente de règlement.
     	//$_SESSION['mail']='mail5';         	
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
			$vardateentretien=$tabvariables[3];	
			
			$parametres['mail']['user']=$user;
            $parametres['mail']['message']=$contenu;
            $parametres['mail']['libelle']=$libelle;
            $parametres['mail']['id']=$idpersonne;
            $parametres['mail']['sujet']=$objet;
            $parametres['mail']['idmail']=$idmail;
            $parametres['mail']['dateentretien']=$dateentretien;
            
            //echo('Dt entretien:').$dateentretien;
            //die();
            
            $parametres['mail']['varnomprenom']=$varnomprenom;
            $parametres['mail']['varformation1']=$varformation1;
            $parametres['mail']['varformation2']=$varformation2;					
            $parametres['mail']['vardateentretien']=$vardateentretien;					
			
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
        //Fin Envoi mail 9
	} //Fin if($_POST['etats'] == 'Convocation en entretien') 
	//======================================================================================================
	
	//======================================================================================================
	//Candidature refusée ===> Mail10 : 1 variable [NOMPrenom]
	//======================================================================================================
	if($_POST['etats'] == 'Candidature refusée') {
		//echo("etat Admin a sélectionné: ".$_POST['etats']);
		//die();
		$_SESSION['mail']='mail10';
		//Début Envoi mail         
     	//Accès modele pour mail5 = Mail 5 : Dossier en attente de règlement.
     	//$_SESSION['mail']='mail5';         	
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
			
			$parametres['mail']['user']=$user;
            $parametres['mail']['message']=$contenu;
            $parametres['mail']['libelle']=$libelle;
            $parametres['mail']['id']=$idpersonne;
            $parametres['mail']['sujet']=$objet;
            $parametres['mail']['idmail']=$idmail;
            $parametres['mail']['varnomprenom']=$varnomprenom;            
			
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
        //Fin Envoi mail 10
	} //Fin if($_POST['etats'] == 'Candidature refusée') 
	//======================================================================================================
	
	//======================================================================================================
	//Candidature acceptée ===> Mail11 : 1 variable [NOMPrenom]
	//======================================================================================================
	if($_POST['etats'] == 'Candidature acceptée') {
		//echo("etat Admin a sélectionné: ".$_POST['etats']);
		//die();
		$_SESSION['mail']='mail11';
		//Début Envoi mail         
     	//Accès modele pour mail5 = Mail 5 : Dossier en attente de règlement.
     	//$_SESSION['mail']='mail5';         	
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
			
			$parametres['mail']['user']=$user;
            $parametres['mail']['message']=$contenu;
            $parametres['mail']['libelle']=$libelle;
            $parametres['mail']['id']=$idpersonne;
            $parametres['mail']['sujet']=$objet;
            $parametres['mail']['idmail']=$idmail;
            $parametres['mail']['varnomprenom']=$varnomprenom;            
			
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
        //Fin Envoi mail 11
	} //Fin if($_POST['etats'] == 'Candidature acceptée') 
	//======================================================================================================
	
	
    //Partie Admin
    if (empty($_POST["dateentretien"])) $err["dateentretien"][] = "Veuillez renseigner la date d'entretien!";        
    
    if (count($errs) == 0) {
        //Partie Admin
        $parametres['Admin']['dateentretien']=$_POST["dateentretien"];
        $etats=$_POST["etats"];
        //echo "etats= ".$etats;
        $parametres['Admin']['statut']=$etats;
                                
        $_SESSION['tab']=$parametres;        
        
        //Mode Admin MàJ table personne que date entretien & statut + mail en fonction du statut
        $coderetour=maj_ECIAdmin();
        //echo "RC: ".$coderetour;
        //die();
        //a près MàJ en base, faire un refresh de la page via header() ET $_GET car ?userAdmin=$user en paramètre!
        header ('location: ../../controleur/cpro/controleurECIAdmin.php?userAdmin='.$user);
        die();
    }
}


// On affiche la page (vue)
include_once('../../vue/cpro/instic_espacecandidatAdmin.php');