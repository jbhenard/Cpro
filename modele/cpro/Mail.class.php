<?php
class Mail {
	
  //En POO, il y a une phrase tr�s importante qu'il faut que vous ayez constamment en t�te :
  // � Une classe, un r�le. � Maintenant, r�pondez clairement � cette question : � Quel est le r�le d'une classe comme Personn � ?
  
  //Attribut(s) priv�(s)
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