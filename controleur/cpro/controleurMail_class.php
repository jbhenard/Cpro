<?php
session_start();

$errsMFI = array();

//Connexion à la base
include_once '../../modele/connexion_sql.php';
include_once '../../modele/connexion_mysqli.php';

// On demande les informations en table (modèle)
//Selection pour récupérer les infos personne (modèle)
include_once('../../modele/cpro/get_personne.php');

//Appel librairie des fonctions
include_once '../../controleur/cpro/fonctions.php';

if (isset($_SESSION['user'])) $user=$_SESSION['user'];
else $user='';

if (isset($_COOKIE['cookieUser']) && $user =='') $user=$_COOKIE['cookieUser'];
//else $user='';

$_SESSION['user']=$user;

//Accès à la class Personne & à la class d'accès au SGBD pour cette class personne, son'PersonneManager'
include_once('../../modele/cpro/Mail.class.php');
include_once('../../modele/cpro/MailManager.class.php');

//Début mode POO kiste Personne        	
	$manager = new MailManager($bdd);			    
	$fichiers=$manager->getList();
//Fin mode POO

$personneMFI=get_personne();
if (count($personneMFI) != 0) {        
    foreach($personneMFI as $cle => $rowMFI) {
        $id=$rowMFI['id'];
        $user=$rowMFI['user'];
    }
}

//echo "<br />*******************************<br />";
//$username=shell_exec("echo %username%" );
//    echo ("username : $username" );

//echo "<br />**********logon windows*********************<br />";
//echo $_POST['windows_logon_user'];
if (isset($_POST['windows_logon_user'])) {
  $_SESSION['windows_logon_user'] = $_POST['windows_logon_user'];
  echo "<br />**********logon windows*********************<br />";
  echo $_POST['windows_logon_user'];
}

// On effectue du traitement sur les données (contrôleur)
if (isset($_GET['submitMFIAdmin'])) {$MFIAdmin=$_GET['submitMFIAdmin']; $tab=$_GET['tab'];
}else{$MFIAdmin=''; $tab='';}
//echo "<br />==============================================================<br />";
//var_dump($_GET);

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
// Traitement des fichiers : Décharger
//======================================================================================================
if (!empty($MFIAdmin == 'submitMFIAdmin') > 0) {

    $tab2=explode(",", $tab);

    if(strlen($tab2[0]) !=0){
    	$CVacharger=''; $LDMacharger=''; $RDNacharger=''; $DIPLOMESacharger='';
        foreach ($tab2 as $key => $choix) {
            switch ($choix) {
                case 'choixCV':
                    $CVacharger='Oui';
                    break;
                case 'choixLDM':
                    $LDMacharger='Oui';
                    break;
                case 'choixRDN':
                    $RDNacharger='Oui';
                    break;
                case 'choixDIPLOMES':
                    $DIPLOMESacharger='Oui';
                    break;
                default:
                    $CVacharger='Non'; $LDMacharger='Non'; $RDNacharger='Non';  $DIPLOMESacharger='Non';
                    break;
            } //fin switch
        } //fin de foreach
    } //fin de if

    //CV
    if ($CVacharger == 'Oui'){
        //echo "=======================";
        //echo $user;
        $chemin="http://cpro.jbh/uploads/$user/cv.pdf";
        //echo "<br />=======================<br />";
        //echo $chemin;
        //echo getenv("HOMEDRIVE") . getenv("HOMEPATH");
		
        //Récupérer le contneu du fichier host
        $remotefilecontents = file_get_contents($chemin);

        //Chemin & nom du du fichier local
        $localfilepath = "C:\cv.pdf"; 
        //$localfilepath = "C:\Users\jean-baptiste\Downloads\cv.pdf"; 
        //C:\Users\jean-baptiste\Downloads

        //Sauvegarder le contneu du fichier host
        if (!file_exists($localfilepath)) {
            file_put_contents($localfilepath, $remotefilecontents); 
            $errsMFI['Filepresentcv'][] ="Le CV a été téléchargé!";
        }else $errsMFI['Filepresentcv'][] ="Le CV a déjà été téléchargé! Veuillez d'abord supprimer cette version!";
    
    	//Début test header
			headpdf($chemin);			
		//Fin test header()
		    
    } //Fin if CV


    //LDM
    if ($LDMacharger == 'Oui'){
        //echo "=======================";

        //echo $user;
        $chemin="http://cpro.jbh/uploads/$user/ldm.pdf";
        //echo "<br />=======================<br />";
        //echo $chemin;

        //Récupérer le contneu du fichier host
        $remotefilecontents = file_get_contents($chemin);

        //Chemin & nom du du fichier local
        $localfilepath = "C:\ldm.pdf"; 

        //Sauvegarder le contneu du fichier host
        if (!file_exists($localfilepath)) {
        	file_put_contents($localfilepath, $remotefilecontents); 
        	$errsMFI['Filepresentldm'][] ="La lettre de motivation a été téléchargé!";
        	}
        else $errsMFI['Filepresentldm'][] ="La lettre demotivation a déjà été téléchargé! Veuillez d'abord supprimer cette version!";
    }


    //RDN
    if ($RDNacharger == 'Oui'){
        //echo "=======================";
        //echo $user;
        $chemin="http://cpro.jbh/uploads/$user/rdn.pdf";
        //echo "<br />=======================<br />";
        //echo $chemin;
        //echo getenv("HOMEDRIVE"). getenv("HOMEPATH");

        //Récupérer le contneu du fichier host
        $remotefilecontents = file_get_contents($chemin);

        //Chemin & nom du du fichier local
        $localfilepath = "C:\lrdn.pdf"; 

        //Sauvegarder le contneu du fichier host
        if (!file_exists($localfilepath)) {
        	file_put_contents($localfilepath, $remotefilecontents); 
        	$errsMFI['Filepresentrdn'][] ="Le relevé de notes a été téléchargé!";
        	}
        else $errsMFI['Filepresentrdn'][] ="Le relelvé de notes a déjà été téléchargé! Veuillez d'abord supprimer cette version!";
    }


    //DIPLOMES
    if($DIPLOMESacharger == 'Oui'){
        //echo "=======================";
        //echo $user;
        $chemin="http://cpro.jbh/uploads/$user/diplomes.pdf";
        //echo "<br />=======================<br />";
        //echo $chemin;

        //Récupérer le contneu du fichier host
        $remotefilecontents = file_get_contents($chemin);

        //Chemin & nom du du fichier local
        $localfilepath = "C:\diplomes.pdf"; 

        //Sauvegarder le contneu du fichier host
        if (!file_exists($localfilepath)) {
        	file_put_contents($localfilepath, $remotefilecontents); 
        	$errsMFI['Filepresentdiplomes'][] ="Les diplômes ont été téléchargés!";
        } else $errsMFI['Filepresentdiplomes'][] ="Les diplômes ont été déjà téléchargé! Veuillez d'abord supprimer cette version!";
    } //fin si diplomes
} //fin si submitMFIAdmin


// On affiche la page (vue)
include_once('../../vue/cpro/instic_mesMailT_class.php');