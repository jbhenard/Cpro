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

if (isset($_COOKIE['cookieUser']) && $user == '') $user=$_COOKIE['cookieUser'];
//else $user='';

$_SESSION['user']=$user;

$personneMFI=get_personne();
if (count($personneMFI) != 0) {        
    foreach($personneMFI as $cle => $rowMFI) {
        $id=$rowMFI['id'];
        $user=$rowMFI['user'];
    }
}


// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
// Traitement des fichiers
//======================================================================================================
if (!empty($_POST["submitMFI"]) > 0) {

    //Création du dossier si il n'existe pas
    if(!file_exists($_SERVER['DOCUMENT_ROOT']."/uploads/$user/")){
        mkdir($_SERVER['DOCUMENT_ROOT']."/uploads/$user/", 0777, true);
    }

    //Contrôle CV
    if (isset($_FILES['cv'])){

    if (strlen($_FILES['cv']['name']) == 0) $errsMFI["uploadcv"][]= "Pas de CV sélectionné à uploader!";
    else{

    $uploadcv=upload('cv', $_SERVER['DOCUMENT_ROOT']."/uploads/$user/cv.pdf", 5242880, array('pdf', 'doc', 'txt', 'odt'));
    //$chemin="http://cpro.jbh/uploads/$user/cv.pdf";
        if ($uploadcv) $errsMFI["uploadcv"][]= "Upload du CV réussi!";
        else $errsMFI["uploadcv"][]= "Erreur de chargement CV!";
    
        //Enregistrer les infos du fichier uploadé dans la base
        if ($errsMFI["uploadcv"][0] == "Upload du CV réussi!" ) {
            $parametres['MFI']['id']=$id;
            $parametres['MFI']['user']=$user.'-CV';
            $parametres['MFI']['upfilename']=$_FILES['cv']['name'];
            $parametres['MFI']['upfilesize']=$_FILES['cv']['size'];
            $parametres['MFI']['upfiletitle']='CV';
            $parametres['MFI']['upfiledescription']='Curriculum Vitae';
            $parametres['MFI']['upfilefinalname']="uploads/$user/cv.pdf";
            $parametres['MFI']['upfiledate']=date("Y-m-d H:i:s");

            $_SESSION['tab']=$parametres;
            if (existe_enreg('upfiles', 'user', $user.'-CV')) {
                $coderetour=maj_MFICV();
                //$errsMFI["uploadcv"][]=$coderetour.'-CV';
            }else {
                $coderetour=ajout_MFICV();
                $errsMFI["uploadcv"][]=$coderetour.'-CV';
            }
        }
        }
        //MàJ code Etat tb etatscandidat
		$rc = maj_etatdossierOK($user, 'etatFIC');
    }  

    //Contrôle LDM
    if (isset($_FILES['ldm'])){

        if (strlen($_FILES['ldm']['name']) == 0) $errsMFI["uploadldm"][]= "Pas de Lettre De Motivation sélectionnée à uploader!";
    else{

    $uploadldm=upload('ldm', $_SERVER['DOCUMENT_ROOT']."/uploads/$user/ldm.pdf", 5242880, array('pdf', 'doc', 'txt', 'odt'));
        if ($uploadldm) $errsMFI["uploadldm"][]=  "Upload de la lettre de motivation réussie!";
        else $errsMFI["uploadldm"][]= "Erreur de chargement lettre de motivation!";
        
        //Enregistrer les infos du fichier uploadé dans la base
        if ($errsMFI["uploadldm"][0] == "Upload de la lettre de motivation réussie!" ) {
            $parametres['MFI']['id']=$id;
            $parametres['MFI']['user']=$user.'-LDM';
            $parametres['MFI']['upfilename']=$_FILES['ldm']['name'];
            $parametres['MFI']['upfilesize']=$_FILES['ldm']['size'];
            $parametres['MFI']['upfiletitle']='LDM';
            $parametres['MFI']['upfiledescription']='Lettre de Motivation';
            $parametres['MFI']['upfilefinalname']="uploads/$user/ldm.pdf";
            $parametres['MFI']['upfiledate']=date("Y-m-d H:i:s");

            $_SESSION['tab']=$parametres;
            if (existe_enreg('upfiles', 'user', $user.'-LDM')) {
                $coderetour=maj_MFILDM(); //ajout d'une fonction
                //$errsMFI["uploadldm"][]=$coderetour.'-LDM';
            }else {
                $coderetour=ajout_MFILDM();
                $errsMFI["uploadldm"][]=$coderetour.'-LDM';
            }
        }
        }
        //MàJ code Etat tb etatscandidat
		$rc = maj_etatdossierOK($user, 'etatFIC');
    }

    //Contrôle RDN
    if (isset($_FILES['rdn'])){

        if (strlen($_FILES['rdn']['name']) == 0) $errsMFI["uploadrdn"][]= "Pas de Relevé De Notes sélectionné à uploader!";
    else{

    $uploadrdn=upload('rdn', $_SERVER['DOCUMENT_ROOT']."/uploads/$user/rdn.pdf", 5242880, array('pdf', 'doc', 'txt', 'odt'));
        if ($uploadrdn) $errsMFI["uploadrdn"][]= "Upload du relevé de notes réussi!";
        else $errsMFI["uploadrdn"][]= "Erreur de chargement relevé de notes!";

        //Enregistrer les infos du fichier uploadé dans la base
        if ($errsMFI["uploadrdn"][0] == "Upload du relevé de notes réussi!" ) {
            $parametres['MFI']['id']=$id;
            $parametres['MFI']['user']=$user.'-RDN';
            $parametres['MFI']['upfilename']=$_FILES['rdn']['name'];
            $parametres['MFI']['upfilesize']=$_FILES['rdn']['size'];
            $parametres['MFI']['upfiletitle']='RDN';
            //$parametres['MFI']['upfilesize']=$_FILES['cv']['size'];
            $parametres['MFI']['upfiledescription']='Relevé de notes';
            $parametres['MFI']['upfilefinalname']="uploads/$user/rdn.pdf";
            $parametres['MFI']['upfiledate']=date("Y-m-d H:i:s");

            $_SESSION['tab']=$parametres;
            if (existe_enreg('upfiles', 'user', $user.'-RDN')) {
                $coderetour=maj_MFICV(); //On garde la fonction de départ car la clef seule change
                //$errsMFI["uploadrdn"][]=$coderetour.'-RDN';
            }else {
                $coderetour=ajout_MFICV();
                $errsMFI["uploadrdn"][]=$coderetour.'-RDN';
                //die("code retour= ".$coderetour);
            }
        }
        }
    	//MàJ code Etat tb etatscandidat
		$rc = maj_etatdossierOK($user, 'etatFIC');
    }

    //Contrôle diplômes
    if (isset($_FILES['diplomes'])){

        if (strlen($_FILES['diplomes']['name']) == 0) $errsMFI["uploaddiplomes"][]= "Pas de Diplômes sélectionnés à uploader!";
    else{

    $uploaddiplomes=upload('diplomes', $_SERVER['DOCUMENT_ROOT']."/uploads/$user/diplomes.pdf", 5242880, array('pdf', 'doc', 'txt', 'odt'));
        if ($uploaddiplomes) $errsMFI["uploaddiplomes"][]= "Upload des diplômes réussis!";
        else $errsMFI["uploaddiplomes"][]= "Erreur de chargement diplômes!";

        //Enregistrer les infos du fichier uploadé dans la base
        if ($errsMFI["uploaddiplomes"][0] == "Upload des diplômes réussis!" ) {
            $parametres['MFI']['id']=$id;
            $parametres['MFI']['user']=$user.'-DIPLOMES';
            $parametres['MFI']['upfilename']=$_FILES['diplomes']['name'];
            $parametres['MFI']['upfilesize']=$_FILES['diplomes']['size'];
            $parametres['MFI']['upfiletitle']='DIPLOMES';
            //$parametres['MFI']['upfilesize']=$_FILES['cv']['size'];
            $parametres['MFI']['upfiledescription']='Diplômes';
            $parametres['MFI']['upfilefinalname']="uploads/$user/diplomes.pdf";
            $parametres['MFI']['upfiledate']=date("Y-m-d H:i:s");

            $_SESSION['tab']=$parametres;
            if (existe_enreg('upfiles', 'user', $user.'-DIPLOMES')) {
                $coderetour=maj_MFICV();
                //$errsMFI["uploaddiplomes"][]=$coderetour.'-DIPLOMES';
            }else {
                $coderetour=ajout_MFICV();
                $errsMFI["uploaddiplomes"][]=$coderetour.'-DIPLOMES';
            }
        }
    	}
    	//MàJ code Etat tb etatscandidat
		$rc = maj_etatdossierOK($user, 'etatFIC');
    }
    
} //Fin if (!empty($_POST["submitMFI"]) > 0)


// On affiche la page (vue)
include_once('../../vue/cpro/instic_mesfichiers.php');