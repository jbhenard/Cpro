<?php
class Upfile {
	
  //En POO, il y a une phrase tr�s importante qu'il faut que vous ayez constamment en t�te :
  // � Une classe, un r�le. � Maintenant, r�pondez clairement � cette question : � Quel est le r�le d'une classe comme Personn � ?
  
  //Attribut(s) priv�(s)
  private $_clef;           //int auto_increment
  private $_id;             //varchar(200)
  private $_user;			//varchar(200)
  private $_upfilename; 			//varchar(20)
  private $_upfilesize;			//varchar(20)
  private $_upfiletitle;			//varchar(20)
  private $_upfiledescription;			//varchar(255)
  private $_upfilefinalname;	//date
  private $_upfiledate;	//date
  private $_upfilemid;		//date
  
  //Contructeur pour la class Upfile
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
  public function getUser() { return $this->_user; }
  public function getUpfilename() { return $this->_upfilename; }
  public function getUpfilesize() { return $this->upfilesize; }
  public function getUpfiletitle() { return $this->_upfiletitle; }
  public function getUpfiledescription() { return $this->_upfiledescription; }
  public function getUpfilefinalname() { return $this->_upfilefinalname; }
  public function getUpfiledate() { return $this->_upfiledate; }
  public function getUpfilemid() { return $this->_upfilemid; }
  
  //Les setters  
  public function setClef($clef) { $this->_clef = (int) $clef; }  
  public function setId($id) { $this->_id = $id; }  
  public function setUser($user) { $this->_user = $user; }
  public function setUpfilename($Upfilename) { $this->_upfilename = $Upfilename; }          
  public function setUpfilesize($Upfilesize) { $this->_upfilesize = $Upfilesize; }  
  public function setUpfiletitle($Upfiletitle)  { $this->_upfiletitle = $Upfiletitle; }  
  public function setUpfiledescription($Upfiledescription) { $this->_upfiledescription = $Upfiledescription; }
  public function setUpfilefinalname($Upfilefinalname) { $this->_upfilefinalname = $Upfilefinalname; }
  public function setUpfiledate($Upfiledate) { $this->_upfiledate = $Upfiledate; }
  public function setUpfilemid($Upfilemid) { $this->_upfilemid = $Upfilemid; }  
  
} //Fin class Upfile