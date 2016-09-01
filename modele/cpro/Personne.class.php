<?php
class Personne {
	
  //En POO, il y a une phrase tr�s importante qu'il faut que vous ayez constamment en t�te :
  // � Une classe, un r�le. � Maintenant, r�pondez clairement � cette question : � Quel est le r�le d'une classe comme Personn � ?
  
  //Attribut(s) priv�(s)
  //private $_clef;           //int auto_increment
  private $_id;             //varchar(200)
  private $_titre; 			//varchar(20)
  private $_nom;			//varchar(20)
  private $_prenom;			//varchar(20)
  private $_user;			//varchar(200)
  private $_mdp;			//varchar(255)
  private $_datecreation;	//date
  private $_datemaj;		//date
  private $_dateentretien;	//datetime
  private $_profil;			//varchar(200)
  private $_dtrelance;		//date
  private $_dtarchive;		//date
 
  //Contructeur pour la class Personne
  public function __construct($valeurs = array()) {
        if(!empty($valeurs)) $this->hydrate($valeurs);
  }
  
  // Un tableau de donn�es doit �tre pass� � la fonction (d'o� le pr�fixe � array �).
  //Quand on vous parle d'hydratation, c'est qu'on parle d'� objet � hydrater �. Hydrater un objet, c'est tout simplement lui apporter ce dont il a besoin pour fonctionner.
  // En d'autres termes plus pr�cis, hydrater un objet revient � lui fournir des donn�es correspondant � ses attributs pour qu'il assigne les valeurs souhait�es � ces derniers.
  // L'objet aura ainsi des attributs valides et sera en lui-m�me valide. On dit que l'objet a ainsi �t� hydrat�.
  public function hydrate(array $donnees) {
  	foreach ($donnees as $key => $value) { // On r�cup�re le nom du setter correspondant � l'attribut.
    	$method = 'set'.ucfirst($key);
        
    	// Si le setter correspondant existe.
    	if (method_exists($this, $method)) { // On appelle le setter.
      	$this->$method($value); } //Fin de if
  	} //Fin foreach
  } //Fin function
 
  //Les getters
  //public function getClef() { return $this->_clef; }
  public function getId() { return $this->_id; }
  public function getTitre() { return $this->_titre; }
  public function getNom() { return $this->_nom; }
  public function getPrenom() { return $this->_prenom; }
  public function getUser() { return $this->_user; }
  public function getMdp() { return $this->_mdp; }
  public function getDatecreation() { return $this->_datecreation; }
  public function getDatemaj() { return $this->_datemaj; }
  public function getDateentretien() { return $this->_dateentretien; }
  public function getProfil() { return $this->_profil; }
  public function getDtrelance() { return $this->_dtrelance; }
  public function getDtarchive() { return $this->_dtarchive; }


  //Les setters  
  //public function setClef($clef) { $this->_id = (int) $id; }  
  public function setId($id) { $this->_id = $id; }  
  public function setTitre($titre) { $this->_titre = $titre; }          
  public function setNom($nom) { $this->_nom = $nom; }  
  public function setPrenom($prenom)  { $this->_prenom = $prenom; }  
  public function setUser($user) { $this->_user = $user; }
  public function setMdp($mdp) { $this->_mdp = $mdp; }
  public function setDatecreation($datecreation) { $this->_datecreation = $datecreation; }
  public function setDatemaj($datemaj) { $this->_datemaj = $datemaj; }
  public function setDateentretien($dateentretien) { $this->_dateentretien = $dateentretien; }  
  public function setProfil($profil) { $this->_profil = $profil; }
  public function setDtrelance($dtrelance) { $this->_dtrelance = $dtrelance; }  
  public function setDtarchive($dtarchive) { $this->_dtarchive = $dtarchive; }
  
} //Fin class Personne