<?php
// On demande les informations en table (modèle)
// Connexion à la base
include_once('/modele/connexion_sql.php');

// get data and store in a json array
$query = "SELECT clef as 'Clef', champ as 'Champ', valeur as 'Valeur', mail as 'Mail', sequence as 'Sequence' FROM param";
//echo $query."<br/>";
if (isset($_GET['insert']))	{
	// INSERT COMMAND
	try {		
		$query = "INSERT INTO param (clef, champ, valeur, mail, sequence, dtmaj) VALUES (?,?,?,?,?, NOW())";
		$result = $bdd->prepare($query);
		$result->bindParam(1, $_GET['Clef']);
		$result->bindParam(2, $_GET['Champ']);
		$result->bindParam(3, $_GET['Valeur']);
		$result->bindParam(4, $_GET['Mail']);
		$result->bindParam(5, $_GET['Sequence']);
		$res = $result->execute();
		// printf ("New Record has id %d.\n", $bdd->insert_id);
		echo $res;
		} catch(Exception $e) { $rc='Erreur selected infos candidat: '.$e->getMessage(); } //Fin cath
	}
  else if (isset($_GET['update'])) {
	// UPDATE COMMAND
	try {		
		//echo "clef: ".$_GET['Clef'];
		$query = "UPDATE param SET champ=?, valeur=?, mail=?, sequence=?, dtmaj=DATE_ADD(NOW(), INTERVAL 7 DAY) WHERE clef=?";
		$result = $bdd->prepare($query);
		$result->bindParam(1, $_GET['Champ']);
		$result->bindParam(2, $_GET['Valeur']);
		$result->bindParam(3, $_GET['Mail']);
		$result->bindParam(4, $_GET['Sequence']);
		$result->bindParam(5, $_GET['Clef']);
		$res = $result->execute();
		// printf ("Updated Record has id %d.\n", $_GET['EmployeeID']);
		echo $res;
		} catch(Exception $e) { $rc='Erreur selected infos candidat: '.$e->getMessage(); } //Fin cath
	}
  else if (isset($_GET['delete'])) {
	// DELETE COMMAND
	try {
		echo "clef: ".$_GET['Clef'];
		die();
		$query = "DELETE FROM param WHERE clef=?";
		$result = $bdd->prepare($query);
		$result->bindParam(1, $_GET['Clef']);
		$res = $result->execute();
		// printf ("Deleted Record has id %d.\n", $_GET['EmployeeID']);
		echo $res;
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