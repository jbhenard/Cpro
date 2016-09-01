<?php
class FormationManager {

  //C'est le fameux CRUD (Create, Read, Update, Delete)
  
  //Attribut(s) privé(s)
  private $_db; // Instance de PDO

  //Contructeur pour géré les rôles de la classFormation
  public function __construct($db) { $this->setDb($db); }

  public function add(Formation $perso) {    
$sql = "INSERT INTO  Formation (id, titre, nom, prenom,  user, mdp, datecreation, datemaj, dateentretien, profil, dtrelance, dtarchive) VALUES ('".$perso->getId()."','".$perso->getTitre()."','".$perso->getNom()."','".$perso->getPrenom()."','".$perso->getUser()."','".$perso->getMdp()."', NOW(), NOW(), '9999-99-99', 'Candidat', DATE_ADD(NOW(), INTERVAL 7 DAY), DATE_ADD(NOW(), INTERVAL 21 DAY))";
 	
 	try { 
	    $q = $this->_db->prepare($sql);    
	    $q->execute();
	    $coderetour = "Record inserted successfully tb Formation.";
    } catch(Exception $e) { $coderetour= 'Erreur INSERT tb Formation: '.$e->getMessage(); }
    
    return $coderetour;
  } //Fin function

  public function delete(Formation $perso) {
    $this->_db->exec('DELETE FROM Formation WHERE user = '.$perso->getUser());
  }

  public function get($id) {    
  	$id= trim($id);
  	//echo 'sql= '.'SELECT * FROM Formation WHERE choix like "%'.$id.'%";';
    $q = $this->_db->query('SELECT * FROM Formation WHERE choix like "%'.$id.'%";');
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    return new Formation($donnees); //retourne un tableau
  }

  public function getList() {
    $persos = [];

    $q = $this->_db->query('SELECT * FROM Formation ORDER BY id');

    while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) { $persos[] = new Formation($donnees); }

    return $persos;
  }

  public function update(Formation $perso) {
  	$sql="UPDATE Formation SET id='$perso->getId()', titre='$perso->getTitre', nom='$perso->getNom', prenom='$perso->getPrenom', mdp='$perso->getMdp' WHERE user='$perso->getUser()';";
    $q = $this->_db->prepare($sql);
    $q->execute();
  }

  public function setDb(PDO $db) { $this->_db = $db; }
  
} //Fin class FormationManager