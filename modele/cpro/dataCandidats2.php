<?php

// On demande les informations en table (modèle)
// Connexion à la base
include_once('../../modele/connexion_sql.php');
include_once('../../modele/cpro/get_personne.php');

if (isset($_GET['archive']))	{
	// INSERT Archive & DELETE perosnne
	
	$tab=$_GET['tab'];
	//echo "Tb User: " . $tab;
	$tab2=explode(",", $tab);
	//die();
	if(strlen($tab2[0]) !=0){
		foreach ($tab2 as $key => $user) {
			$_SESSION['user']=$user;
			//echo "User Trt EC: " . $user;
		    
		    //Select en table personne pour récupérer les infos
		    $personne=get_personne();
		    foreach($personne as $cle => $champs) {
		        $id=$champs['id'];           
		        $titre=$champs['titre'];            
		        $nom=$champs['nom'];
			    $prenom=$champs['prenom'];
		        $user=$champs['user'];
		        $mdp=$champs['mdp'];
		    }        
	    	//echo('Nom: ') . $nom;
			try {						
	    		//Ajout en tb personnearchive
				$query = "INSERT INTO  personnearchive (id, titre, nom, prenom,  user, mdp, datecreation, datemaj, dateentretien) VALUES ('$id', '$titre', '$nom', '$prenom', '$user', '$mdp', NOW(), NOW(), NOW())";
				$result = $bdd->prepare($query);		
				$res = $result->execute();
				
				//Delete en tb personne	et grâce aux foreign key, les autres tb seront MàJ, del des enreg $user en mode cascade				
				$query = "DELETE FROM personne WHERE user='".$user."'";
				$result = $bdd->prepare($query);		
				$res = $result->execute();				
				
				
				
				// printf ("New Record has id %d.\n", $bdd->insert_id);
				//echo $res;
				//header('http://cpro.jbh/controleur/cpro/controleurParametrage2.php');
				//die();
				header('location: http://cpro.jbh/controleur/cpro/controleurAdmin.php');
				die();
			} catch(Exception $e) { $rc='Erreur selected infos candidat: '.$e->getMessage(); } //Fin cath
		}//Pour chq user 'checkboxé'
	} //Fin if(strlen($tab2[0]) !=0)
} else {
	$sql="SELECT A.clef as 'Clef', A.datecreation as 'Dtc', A.id as 'Id', A.dateentretien as 'Dte', B.formationenvisagees as 'Formation', COALESCE(C.etatcandidature,'Vide') as 'Etat', A.user as 'User', A.dtrelance7 as 'Dtr7', A.dtarchive as 'Dta', A.dtrelance14 as 'Dtr14' FROM personne A left join personnefe B on A.user = B.user left join etatscandidat C on A.user = C.user WHERE A.user not in (select CA.user from personnearchive CA) order by A.clef;";
	    
	try {        
	$persos = [];
	    $req = $bdd->query($sql);
	                    
	     while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {      
	     	//Remplacer les l1choix, ... par le libellé formation
	     	$formationenvisagees=$donnees['Formation'];       //l1choix1-l2choix1-l3choix1-alternance- 
			$tabchoix=explode("-", $formationenvisagees); // Array de l1choix1-l2choix1-l3choix1-alternance-
			$formationenvisagees='';
			foreach ($tabchoix as $value) {  //pour chaque case du Array: l1choix1-l2choix1-l3choix1-alternance-				
				$_SESSION['choix']=$value;
				$formations0=get_formationsenvisagees2();
				
				foreach($formations0 as $cle => $champs) { //Pour chaque champ l1choix1 (exemple) on récupère le libellé
				    $formationenvisagees.=$champs['formation']."-";        
				} //Fin foreach2
	     	}//Fin foreach1     	
	     	$donnees['Formation']=$formationenvisagees;
	     	$persos[] = $donnees; 
	        $rc="Selected OK!";
	    } //Fin du while
	    echo json_encode($persos);
	} catch(Exception $e) { $rc='Erreur selected infos candidat: '.$e->getMessage(); } //Fin cath
} //Fin else    
?>