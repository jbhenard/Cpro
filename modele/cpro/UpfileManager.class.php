<?php
class UpfileManager {

  //C'est le fameux CRUD (Create, Read, Update, Delete)
  
  //Attribut(s) privé(s)
  private $_db; // Instance de PDO

  //Contructeur pour géré les rôles de la classPersonne
  public function __construct($db) { $this->setDb($db); }

  public function add(Personne $perso) {    
$sql = "INSERT INTO  personne (id, titre, nom, prenom,  user, mdp, datecreation, datemaj, dateentretien, profil, dtrelance, dtarchive) VALUES ('".$perso->getId()."','".$perso->getTitre()."','".$perso->getNom()."','".$perso->getPrenom()."','".$perso->getUser()."','".$perso->getMdp()."', NOW(), NOW(), '9999-99-99', 'Candidat', DATE_ADD(NOW(), INTERVAL 7 DAY), DATE_ADD(NOW(), INTERVAL 21 DAY))";
 	
 	try { 
	    $q = $this->_db->prepare($sql);    
	    $q->execute();
	    $coderetour = "Record inserted successfully tb personne.";
    } catch(Exception $e) { $coderetour= 'Erreur INSERT tb personne: '.$e->getMessage(); }
    
    return $coderetour;
  } //Fin function

  public function delete(Personne $perso) {
    $this->_db->exec('DELETE FROM personne WHERE user = '.$perso->getUser());
  }

  public function get($id) {    
    $q = $this->_db->query('SELECT * FROM upfiles WHERE clef = '.$id);
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    return new Upfile($donnees); //retourne un tableau
  }

  public function getList($id) {
    $persos = [];

    $q = $this->_db->query('SELECT * FROM upfiles WHERE user like "%'.$id.'%";');

    while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) { $persos[] = new Upfile($donnees); }

    return $persos;
  }

  public function update(Personne $perso) {
  	$sql="UPDATE personne SET id='$perso->getId()', titre='$perso->getTitre', nom='$perso->getNom', prenom='$perso->getPrenom', mdp='$perso->getMdp' WHERE user='$perso->getUser()';";
    $q = $this->_db->prepare($sql);
    $q->execute();
  }

  public function setDb(PDO $db) { $this->_db = $db; }
  
} //Fin class UpfileManager