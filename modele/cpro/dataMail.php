<?php
// On demande les informations en table (modèle)
// Connexion à la base
include_once('../connexion_sql.php');

// get data and store in a json array
$query = "SELECT clef as 'Clef', id as 'Id', objet as 'Objet', libelle as 'Libelle', contenu as 'Contenu', variables as 'Variables' FROM mail";
//echo $query."<br/>";
if (isset($_GET['insert']))	{
	// INSERT COMMAND
	try {		
		$query = "INSERT INTO mail (id, objet, libelle, contenu, variables, dtmaj) VALUES ('A renseigner','A renseigner','A renseigner','A renseigner', 'A renseigner', NOW())";
		$result = $bdd->prepare($query);		
		$res = $result->execute();
		// printf ("New Record has id %d.\n", $bdd->insert_id);
		echo $res;
		header('location: http://cpro.jbh/vue/cpro/instic_espaceparametrageMails.php');
		die();
		} catch(Exception $e) { $rc='Erreur selected infos candidat: '.$e->getMessage(); } //Fin cath
	}
  else if (isset($_GET['update'])) {
	// UPDATE COMMAND
	try {		
		//echo "clef: ".$_GET['Clef'];
	$query = "UPDATE mail SET id=?, objet=?, libelle=?, contenu=?, variables=?, dtmaj=DATE_ADD(NOW(), INTERVAL 7 DAY) WHERE clef=?";
		$result = $bdd->prepare($query);
		$result->bindParam(1, $_GET['Id']);
		$result->bindParam(2, $_GET['Objet']);
		$result->bindParam(3, $_GET['Libelle']);
		$result->bindParam(4, $_GET['Contenu']);
		$result->bindParam(5, $_GET['Variables']);
		$result->bindParam(6, $_GET['Clef']);
		$res = $result->execute();
		// printf ("Updated Record has id %d.\n", $_GET['EmployeeID']);
		echo $res;
		} catch(Exception $e) { $rc='Erreur selected infos candidat: '.$e->getMessage(); } //Fin cath
	}
  else if (isset($_GET['delete'])) {
	// DELETE COMMAND
	try {		
		$query = "DELETE FROM mail WHERE clef=".$_GET['Clef'];
		$result = $bdd->prepare($query);		
		$res = $result->execute();
		// printf ("Deleted Record has id %d.\n", $_GET['EmployeeID']);
		echo $res;
		header('location: http://cpro.jbh/vue/cpro/instic_espaceparametrageMails.php');
		die();
		} catch(Exception $e) { $rc='Erreur selected infos candidat: '.$e->getMessage(); } //Fin cath
	}  else {	
		// SELECT COMMAND
	 	try {        
			$persos = [];
		    $req = $bdd->query($query);
		                    
		     while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) { $persos[] = $donnees; } //Fin du while
		    $rc="Selected OK!";
		    echo json_encode($persos);
			} catch(Exception $e) { $rc='Erreur selected infos candidat: '.$e->getMessage(); } //Fin cath
		}

?>