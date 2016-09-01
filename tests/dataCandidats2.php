<?php
// On demande les informations en table (modèle)
// Connexion à la base
include_once('/modele/connexion_sql.php');
include_once('/modele/cpro/get_personne.php');
	
$sql="SELECT A.datecreation as 'Dtc', A.id as 'Id', A.dateentretien as 'Dte', B.formationenvisagees as 'Formation', COALESCE(C.etatcandidature,'Vide') as 'Etat' FROM personne A left join personnefe B on A.user = B.user left join etatscandidat C on A.user = C.user WHERE A.user not in (select CA.user from personnearchive CA) order by A.clef;";
    
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
} catch(Exception $e) { $rc='Erreur selected infos candidat: '.$e->getMessage(); } //Fin cath
    
echo json_encode($persos);
    
?>