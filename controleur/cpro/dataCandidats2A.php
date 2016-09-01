<?php
// On demande les informations en table (modèle)
// Connexion à la base
include_once('../../modele/connexion_sql.php');
include_once('../../modele/cpro/get_personne.php');
	
$sql="SELECT clef as 'Clef', id as 'Id', titre as 'Titre', nom as 'Nom', prenom as 'Prénom', user as 'User', mdp as 'Mdp', datecreation as 'Dtc', datemaj as 'Dtm', dateentretien as 'Dte' from personnearchive;";
    
 try {        
$persos = [];
    $req = $bdd->query($sql);
                    
     while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) { $persos[] = $donnees; } //Fin du while
} catch(Exception $e) { $rc='Erreur selected infos candidat: '.$e->getMessage(); } //Fin cath
    
echo json_encode($persos);
    
?>