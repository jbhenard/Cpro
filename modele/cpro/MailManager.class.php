<?php
class MailManager {

  //C'est le fameux CRUD (Create, Read, Update, Delete)
  
  //Attribut(s) privé(s)
  private $_db; // Instance de PDO

  //Contructeur pour géré les rôles de la classMail
  public function __construct($db) { $this->setDb($db); }

  public function add(Mail $perso) {    
$sql = "INSERT INTO  mail (id, titre, nom, prenom,  user, mdp, datecreation, datemaj, dateentretien, profil, dtrelance, dtarchive) VALUES ('".$perso->getId()."','".$perso->getTitre()."','".$perso->getNom()."','".$perso->getPrenom()."','".$perso->getUser()."','".$perso->getMdp()."', NOW(), NOW(), '9999-99-99', 'Candidat', DATE_ADD(NOW(), INTERVAL 7 DAY), DATE_ADD(NOW(), INTERVAL 21 DAY))";
 	
 	try { 
	    $q = $this->_db->prepare($sql);    
	    $q->execute();
	    $coderetour = "Record inserted successfully tb Mail.";
    } catch(Exception $e) { $coderetour= 'Erreur INSERT tb Mail: '.$e->getMessage(); }
    
    return $coderetour;
  } //Fin function

  public function delete(Mail $perso) {
    $this->_db->exec('DELETE FROM mail WHERE user = '.$perso->getUser());
  }

  public function get($id) {    
    $q = $this->_db->query('SELECT * FROM mail WHERE clef ='.$id);
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    return new Mail($donnees); //retourne un tableau
  }

  public function getList() {
    $persos = [];

    $q = $this->_db->query('SELECT * FROM mail ORDER BY clef');

    while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) { $persos[] = new Mail($donnees); }

    return $persos;
  }

  public function update(Mail $perso) {
  	$sql="UPDATE mail SET id='$perso->getId()', titre='$perso->getTitre', nom='$perso->getNom', prenom='$perso->getPrenom', mdp='$perso->getMdp' WHERE user='$perso->getUser()';";
    $q = $this->_db->prepare($sql);
    $q->execute();
  }

  public function setDb(PDO $db) { $this->_db = $db; }
  
} //Fin class MailManager