<?php
//D�but Envoi mail

//Acc�s au modele    
include_once '../../modele/connexion_sql.php';
include_once('../../modele/cpro/get_personne.php');

if ($_GET["dtr7"] ==  Date("Y-m-d")) $_SESSION['mail']='mail2';
if ($_GET["dtr14"] ==  Date("Y-m-d")) $_SESSION['mail']='mail3';
if ($_GET["dta"] ==  Date("Y-m-d")) $_SESSION['mail']='mail4';
      
//Acc�s modele pour mail1 = Confirmation tr�ation espace candidat en table 'mail'.
//$_SESSION['mail']='mail1';         	
$infosmail=get_mailx(); //Acc�s tb 'mail' avec mailxx stock� en $_SESSION
 	
 //Traitement des donn�es par le controleur
if (count($infosmail) != 0) {
    foreach($infosmail as $cle => $champs) {
        $idmail=$champs['id'];           
        $objet=$champs['objet'];           
        $contenu=$champs['contenu'];                                
        $libelle=$champs['libelle'];                                
        $variables=$champs['variables'];                                
    } //Fin foreach1
        
    //D�composer la chaine variables en tableau & compter nb variables
	$tabvariables=explode('-',$variables);
	$varnomprenom=$tabvariables[0];	
	
	$parametres['mail']['user']=$_GET["user"];
    $parametres['mail']['message']=$contenu;
    $parametres['mail']['id']=$_GET["id"];
    $parametres['mail']['sujet']=$objet;
    $parametres['mail']['idmail']=$idmail;
    $parametres['mail']['libelle']=$libelle;
    $parametres['mail']['varnomprenom']=$varnomprenom;								
        
	$_SESSION['tab']=$parametres;
	include_once('../../controleur/cpro/controleurGmail.php');
} //Fin if (count($infosmail) != 0)
//Fin envoi email

//Retour � la vue
header('location: http://cpro.jbh/controleur/cpro/controleurAdmin.php');
die();

?>