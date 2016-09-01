<?php
class Mail {
	
  //En POO, il y a une phrase très importante qu'il faut que vous ayez constamment en tête :
  // « Une classe, un rôle. » Maintenant, répondez clairement à cette question : « Quel est le rôle d'une classe comme Personn » ?
  
  //Attribut(s) privé(s)
  private $_clef;           //int auto_increment
  private $_id;             //varchar(200)
  private $_objet; 		//varchar(20)
  private $_libelle;		//varchar(20)
  private $_contenu;			//varchar(20)
  private $_variables;	//varchar(200)
  
  //Contructeur pour la class Mail
  public function __construct($valeurs = array()) {
        if(!empty($valeurs)) $this->hydrate($valeurs);
  }
  
  // Un tableau de données doit être passé à la fonction (d'où le préfixe « array »).
  //Quand on vous parle d'hydratation, c'est qu'on parle d'« objet à hydrater ». Hydrater un objet, c'est tout simplement lui apporter ce dont il a besoin pour fonctionner.
  // En d'autres termes plus précis, hydrater un objet revient à lui fournir des données correspondant à ses attributs pour qu'il assigne les valeurs souhaitées à ces derniers.
  // L'objet aura ainsi des attributs valides et sera en lui-même valide. On dit que l'objet a ainsi été hydraté.
  public function hydrate(array $donnees) {
  	foreach ($donnees as $key => $value) { // On récupère le nom du setter correspondant à l'attribut.
    	$method = 'set'.ucfirst($key);
        
    	// Si le setter correspondant existe.
    	if (method_exists($this, $method)) { // On appelle le setter.
      	$this->$method($value); } //Fin de if
  	} //Fin foreach
  } //Fin function
 
  //Les getters
  public function getClef() { return $this->_clef; }
  public function getId() { return $this->_id; }
  public function getObjet() { return $this->_objet; }
  public function getLibelle() { return $this->_libelle; }
  public function getContenu() { return $this->_contenu; }
  public function getVariables() { return $this->_variables; }
  
  //Les setters  
  public function setClef($clef) { $this->_clef = (int) $clef; }
  public function setId($id) { $this->_id = $id; }
  public function setObjet($objet) { $this->_objet = $objet; }
  public function setLibelle($libelle) { $this->_libelle = $libelle; }  
  public function setContenu($contenu) { $this->_contenu = $contenu; }
  public function setVariables($variables) { $this->_variables = $variables; }  
    
} //Fin class Mail