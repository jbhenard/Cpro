<?php
class Formation {
	
  //En POO, il y a une phrase tr�s importante qu'il faut que vous ayez constamment en t�te :
  // � Une classe, un r�le. � Maintenant, r�pondez clairement � cette question : � Quel est le r�le d'une classe comme Personn � ?
  
  //Attribut(s) priv�(s)
  private $_clef;           //int auto_increment
  private $_id;             //varchar(200)
  private $_domaine; 		//varchar(20)
  private $_formation;		//varchar(20)
  private $_choix;			//varchar(20)
  private $_identifiant;	//varchar(200)
  private $_codeQCM;		//varchar(255)
  
  //Contructeur pour la class Formation
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
  public function getClef() { return $this->_clef; }
  public function getId() { return $this->_id; }
  public function getDomaine() { return $this->_domaine; }
  public function getFormation() { return $this->_formation; }
  public function getChoix() { return $this->_choix; }
  public function getIdentifiant() { return $this->_identifiant; }
  public function getCodeQCM() { return $this->_codeQCM; }
  
  //Les setters  
  public function setClef($clef) { $this->_clef = (int) $clef; }
  public function setId($id) { $this->_id = $id; }
  public function setDomaine($domaine) { $this->_domaine = $domaine; }
  public function setFormation($formation) { $this->_formation = $formation; }  
  public function setChoix($choix) { $this->_choix = $choix; }  
  public function setIdentifiant($identifiant) { $this->_identifiant = $identifiant; }
  public function setCodeQCM($codeQCM) { $this->_codeQCM = $codeQCM; }
    
} //Fin class Formation