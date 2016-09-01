<?php
//https://openclassrooms.com/courses/programmez-en-oriente-objet-en-php/manipulation-de-donnees-stockees

//VAC passe à OUI si candidat clique le bouton "Valider ma candidature".
function get_VAC() {
    global $bdd;    
    
    $user= $_SESSION['user'];

    try {
        // Insertion du message à l'aide d'une requête préparée
        $req = $bdd->query("SELECT VAC FROM personne WHERE user ='$user';");      
        $req->execute();
    	$VAC_Info = $req->fetchAll();          
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout        
        $VAC_Info = "$user Erreur INSERT : ".$e->getMessage();
    }

    return $VAC_Info;
}

//VAC passe à OUI si candidat clique le bouton "Valider ma candidature".
function MaJ_VAC() {
    global $bdd;    
    
    $user= $_SESSION['user'];

    try {
        // Insertion du message à l'aide d'une requête préparée
        $req = $bdd->query("UPDATE personne SET VAC='OUI' WHERE user ='$user';");        
        $changerVAC = "$user record updated successfully";
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout        
        $changerVAC = "$user Erreur INSERT : ".$e->getMessage();
    }

    return $changerVAC;
}

//Accès table formation avec un id en paramètre ex: 'AGW'.
function get_all_IdFormations($Idformation) {
    global $bdd;
            
    $req = $bdd->query("SELECT * FROM formation WHERE id='$Idformation' ORDER BY clef;");
    $req->execute();
    $all_IdFormations = $req->fetchAll();
        
    return $all_IdFormations;
}


//Supprimer les doublon de la table formation
//http://sql.sh/138-methode-supprimer-doublons
function del_doublonsFormations(){
	global $bdd;
	
	$sql="DELETE t1 FROM formation AS t1, formation AS t2 WHERE t1.clef > t2.clef AND t1.id = t2.id AND t1.domaine = t2.domaine AND t1.formation = t2.formation";
				
    try {
        // deleted doublons
        $req = $bdd->prepare($sql);
        $req->execute();
        $coderetour="doublons supprimés!";
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $coderetour='Erreur selected infos candidat: '.$e->getMessage();
    }
    return $coderetour;
}


//Supprimer les doublon de la table param
//http://sql.sh/138-methode-supprimer-doublons
function del_doublonsEtats(){
	global $bdd;
	
	$sql="DELETE t1 FROM param AS t1, param AS t2 WHERE t1.clef > t2.clef AND t1.champ = t2.champ AND t1.valeur = t2.valeur AND t1.mail = t2.mail";
				
    try {
        // deleted doublons
        $req = $bdd->prepare($sql);
        $req->execute();
        $coderetour="doublons supprimés!";
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $coderetour='Erreur selected infos candidat: '.$e->getMessage();
    }
    return $coderetour;
}


//Accès table des mails
function get_mailx(){
    global $bdd;
        
    $mail= $_SESSION['mail'];

    $req = $bdd->query("SELECT * FROM mail WHERE id ='".$mail."' ORDER BY clef DESC LIMIT 1;");
    $req->execute();
    $mail = $req->fetchall();
        
    return $mail;
}


//Ajout en table formation
function get_infoscandidat($choix){
    global $bdd;

    //$user= $_SESSION['user'];
    $valeurtri = isset($_SESSION['valeurtri']) ? $_SESSION['valeurtri'] : "" ;
    
    $sql="SELECT A.*, B.formationenvisagees, C.etatcandidature, C.etatECI, C.etatFEN, C.etatIPE, C.etatIPR, C.etatDIV, C.etatFIC FROM personne A left join personnefe B on A.user = B.user left join etatscandidat C on A.user = C.user WHERE A.user not in (select CA.user from personnearchive CA) order by A.clef;";

    switch ($choix) {
         case 'likenom':
    $sql="SELECT A.*, B.formationenvisagees, C.etatcandidature, C.etatECI, C.etatFEN, C.etatIPE, C.etatIPR, C.etatDIV, C.etatFIC FROM personne A left join personnefe B on A.user = B.user left join etatscandidat C on A.user = C.user WHERE A.user not in (select CA.user from personnearchive CA) and A.id like '$valeurtri%' and B.user= A.user and C.user= A.user order by A.clef;";
            break;

           case 'dtc':
    $sql="SELECT A.*, B.formationenvisagees, C.etatcandidature, C.etatECI, C.etatFEN, C.etatIPE, C.etatIPR, C.etatDIV, C.etatFIC FROM personne A left join personnefe B on A.user = B.user left join etatscandidat C on A.user = C.user WHERE A.user not in (select CA.user from personnearchive CA) and A.datecreation = '$valeurtri' and B.user= A.user and C.user= A.user order by A.clef;";
            break;

           case 'nom':
           if ($valeurtri != 'tous'){
    $sql="SELECT A.*, B.formationenvisagees, C.etatcandidature, C.etatECI, C.etatFEN, C.etatIPE, C.etatIPR, C.etatDIV, C.etatFIC FROM personne A left join personnefe B on A.user = B.user left join etatscandidat C on A.user = C.user WHERE A.user not in (select CA.user from personnearchive CA) and A.user = '$valeurtri' and B.user= A.user and C.user= A.user order by A.clef;";
        }else{
      $sql="SELECT A.*, B.formationenvisagees, C.etatcandidature, C.etatECI, C.etatFEN, C.etatIPE, C.etatIPR, C.etatDIV, C.etatFIC FROM personne A left join personnefe B on A.user = B.user left join  etatscandidat C on A.user = C.user WHERE A.user not in (select CA.user from personnearchive CA) order by A.id;";
          }
        
        break;

        case 'etat':
    $sql="SELECT A.*, B.formationenvisagees, C.etatcandidature, C.etatECI, C.etatFEN, C.etatIPE, C.etatIPR, C.etatDIV, C.etatFIC FROM personne A left join personnefe B on A.user = B.user left join etatscandidat C on A.user = C.user WHERE C.etatcandidature = '$valeurtri' and B.user= A.user and C.user= A.user and A.user not in (select CA.user from personnearchive CA) order by A.clef;";
            break;

             case 'dte':
    $sql="SELECT A.*, B.formationenvisagees, C.etatcandidature, C.etatECI, C.etatFEN, C.etatIPE, C.etatIPR, C.etatDIV, C.etatFIC FROM personne A left join personnefe B on A.user = B.user left join etatscandidat C on A.user = C.user WHERE A.dateentretien = '$valeurtri' and B.user= A.user and C.user= A.user and A.user not in (select CA.user from personnearchive CA) order by A.clef;";
            break;

        case 'tridtc':
            $champtri="A.datecreation;";
    $sql="SELECT A.*, B.formationenvisagees, C.etatcandidature, C.etatECI, C.etatFEN, C.etatIPE, C.etatIPR, C.etatDIV, C.etatFIC FROM personne A left join personnefe B on A.user = B.user left join  etatscandidat C on A.user = C.user WHERE A.user not in (select CA.user from personnearchive CA) order by A.datecreation;";
            break;
        
        case 'trinom':
            $champtri="A.id;";
    $sql="SELECT A.*, B.formationenvisagees, C.etatcandidature, C.etatECI, C.etatFEN, C.etatIPE, C.etatIPR, C.etatDIV, C.etatFIC FROM personne A left join personnefe B on A.user = B.user left join  etatscandidat C on A.user = C.user WHERE A.user not in (select CA.user from personnearchive CA) order by A.id;";
            break;
        
        case 'trife':
            $champtri="B.formationenvisagees;";
    $sql="SELECT A.*, B.formationenvisagees, C.etatcandidature, C.etatECI, C.etatFEN, C.etatIPE, C.etatIPR, C.etatDIV, C.etatFIC FROM personne A left join personnefe B on A.user = B.user left join etatscandidat C on A.user = C.user WHERE A.user not in (select CA.user from personnearchive CA) order by B.formationenvisagees";
            break;
        
        case 'tristatut':
            $champtri="C.etatcandidature;";
    $sql="SELECT A.*, B.formationenvisagees, C.etatcandidature, C.etatECI, C.etatFEN, C.etatIPE, C.etatIPR, C.etatDIV, C.etatFIC FROM personne A left join personnefe B on A.user = B.user left join etatscandidat C on A.user = C.user WHERE A.user not in (select CA.user from personnearchive CA) order by C.etatcandidature";
            break;
        
        case 'tridte':
            $champtri="A.dateentretien;";
    $sql="SELECT * FROM personne A left join personnefe B on A.user = B.user left join  etatscandidat C on A.user = C.user WHERE A.user not in (select CA.user from personnearchive CA) order by A.dateentretien;";
            break;

    //Cas particulier, le filtre Formation ce fait dans la vue car on passe de 'l1choix-...' en tb personnefe à 'libellé de l1choix-...' en tb formation.
         case 'formation':
$sql="SELECT A.*, B.formationenvisagees, C.etatcandidature, C.etatECI, C.etatFEN, C.etatIPE, C.etatIPR, C.etatDIV, C.etatFIC FROM personne A left join personnefe B on A.user = B.user left join etatscandidat C on A.user = C.user WHERE A.user not in (select CA.user from personnearchive CA) and B.formationenvisagees like '%$valeurtri%' order by A.clef;";
            break;

        default:
            $champtri="A.clef;";
    $sql="SELECT A.*, B.formationenvisagees, C.etatcandidature, C.etatECI, C.etatFEN, C.etatIPE, C.etatIPR, C.etatDIV, C.etatFIC FROM personne A left join personnefe B on A.user = B.user left join etatscandidat C on A.user = C.user WHERE A.user not in (select CA.user from personnearchive CA) order by A.clef;";
            break;
    }
    
    //$sql="SELECT * FROM personne A left join personnefe B on A.user = B.user left join etatscandidat C on A.user = C.user ORDER BY " + $champtri;

    try {
        // Insertion du message à l'aide d'une requête préparée
        $req = $bdd->prepare($sql);
        $req->execute();
        $infos_candidat = $req->fetchall();     
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $infos_candidat='Erreur selected infos candidat: '.$e->getMessage();
    }
    return $infos_candidat;
}

//compteur max param 
function maxCpt_états(){
 global $bdd;
        
    try {
        // Insertion du message à l'aide d'une requête préparée
        //$req = $bdd->prepare("insert param set valeur='$statut', mail='$Mail', sequence='$sequence' WHERE champ='état' AND clef = '$clef';");
        $req = $bdd->prepare("SELECT count(*) as 'maxnb' FROM param");        
        $req->execute();
        $coderetour = $req->fetchall();     
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $coderetour=0;
    }

    //$_SESSION['user'] = $user;
    return $coderetour;
}

//Vérifiez que enreg n'a pas déjà été ajoité
function ajout_étatsPossible(){
    global $bdd;
        
    $tab=$_SESSION['tab'];

    $clef        = $tab['statuts']['clef'];
    $statut      = $tab['statuts']['statut'];
    $Mail        = (isset($tab['statuts']['Mail'])) ? $tab['statuts']['Mail'] : '';
    $sequence    = (isset($tab['statuts']['sequence'])) ? $tab['statuts']['sequence'] : '';
   
    try {
        // Insertion du message à l'aide d'une requête préparée
        //$req = $bdd->prepare("insert param set valeur='$statut', mail='$Mail', sequence='$sequence' WHERE champ='état' AND clef = '$clef';");
        $req = $bdd->prepare("SELECT * FROM param WHERE champ='état' AND valeur='$statut' AND mail='$Mail' AND sequence='$sequence';");
        $req->execute();
        $enregistrement = $req->fetchall();
    	
    	if (count($enregistrement) != 0) return true;
    	else return false;	
    }catch(Exception $e){
        // En cas d'erreur, c'est que rien n'a été trouvé ou peut onsérer
        return true;
    }

    //$_SESSION['user'] = $user;
    //echo "================== $coderetour ===================================";
    //die();
    //return $coderetour;
}

//Ajout en table param des nouveaux "états"
function ajout_états(){
 global $bdd;
    
    //$rc=del_doublonsEtats();
    
    $tab=$_SESSION['tab'];

    $clef        = $tab['statuts']['clef'];
    $statut      = $tab['statuts']['statut'];
    $Mail        = (isset($tab['statuts']['Mail'])) ? $tab['statuts']['Mail'] : '';
    $sequence    = (isset($tab['statuts']['sequence'])) ? $tab['statuts']['sequence'] : '';
   
    try {
        // Insertion du message à l'aide d'une requête préparée
        //$req = $bdd->prepare("insert param set valeur='$statut', mail='$Mail', sequence='$sequence' WHERE champ='état' AND clef = '$clef';");
        $req = $bdd->prepare('INSERT INTO param (champ, valeur, mail, sequence) VALUES (:c, :v, :m, :s)');
        $req->execute(array('c' => 'état', 'v' => $statut, 'm' => $Mail, 's' => $sequence));
        $req->execute();
        $coderetour = 'Record updated états!';
        $bdd->commit();
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $coderetour='Erreur états updated : '.$e->getMessage();
    }

    //$_SESSION['user'] = $user;
    return $coderetour;
}

//MàJ en table param "états"
function maj_états(){
 global $bdd;
    //$rc=del_doublonsEtats();
    $tab=$_SESSION['tab'];

    $clef        = $tab['statuts']['clef'];
    $statut      = $tab['statuts']['statut'];
    $Mail        = $tab['statuts']['Mail'];
    $sequence    = $tab['statuts']['sequence'];
   
    try {
        // Insertion du message à l'aide d'une requête préparée
        $req = $bdd->prepare("UPDATE param set valeur='$statut', mail='$Mail', sequence='$sequence' WHERE champ='état' AND clef = '$clef';");
        $req->execute();
        $coderetour = 'Record updated états!';
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $coderetour='Erreur états updated : '.$e->getMessage();
    }

    //$_SESSION['user'] = $user;
    return $coderetour;
}

//Vérifiez que enreg n'a pas déjà été ajoité
function ajout_formationsPossible(){
    global $bdd;

    $tab=$_SESSION['tab'];
	//$rc=del_doublonsFormations();
    $id          = $tab['FOR']['id'];
    $domaine     = $tab['FOR']['domaine'];
    $formation   = $tab['FOR']['formation'];
    $choix0      = $tab['FOR']['choix'];
    $choix       ='l'.$choix0.'choix1';    
    $identifiant = $tab['FOR']['identifiant'];
    $codeQCM     = $tab['FOR']['codeQCM'];
   
    try {
        // Insertion du message à l'aide d'une requête préparée
        //$req = $bdd->prepare("insert param set valeur='$statut', mail='$Mail', sequence='$sequence' WHERE champ='état' AND clef = '$clef';");
        $req = $bdd->prepare("SELECT * FROM formation WHERE id='".$id."' AND choix='".$choix."';");
        $req->execute();
		$enregistrement = $req->fetchall();
    	
    	if (count($enregistrement) != 0) return true;
    	else return false;	
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        return true;
    }

    //$_SESSION['user'] = $user;
    //echo "================== $coderetour ===================================";
    //return $coderetour;
}

//Ajout formation(s)
function ajout_formations(){
  global $bdd;
    $bdd->exec("SET NAMES utf8");

    $tab=$_SESSION['tab'];

    $id          = $tab['FOR']['id'];
    $domaine     = $tab['FOR']['domaine'];
    $formation   = $tab['FOR']['formation'];
    $choix0      = $tab['FOR']['choix'];
    $choix       ='l'.$choix0.'choix1';
    $identifiant = $tab['FOR']['identifiant'];
    $codeQCM     = $tab['FOR']['codeQCM'];
   
//INSERT INTO contacts (office_name, contact_no, digital_no, mobile_no) 
//VALUES ('$contactName','$contactNo','$digitalNo','$mobileNo')
//ON DUPLICATE KEY UPDATE office_name = office_name
    
    try {
        // Insertion du message à l'aide d'une requête préparée
        //$req = $bdd->prepare("insert param set valeur='$statut', mail='$Mail', sequence='$sequence' WHERE champ='état' AND clef = '$clef';");
        //$dbb->beginTransaction(); 
        $req = $bdd->prepare('INSERT INTO formation (id, domaine, formation, choix, identifiant, codeQCM) VALUES (:i, :d, :f, :c, :id, :cq)');
        $req->execute(array('i' => $id, 'd' => $domaine, 'f' => $formation, 'c' => $choix, 'id' => $identifiant, 'cq' => $codeQCM));
        $req->execute();
        $coderetour = 'Record inserted formation!';
        //$bdd->commit();
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $coderetour='Erreur états inserted formation : '.$e->getMessage();
    }

    //$_SESSION['user'] = $user;
    //echo $coderetour;
    //die();
    return $coderetour;
}

//MàJ en table formation
function maj_formations(){
    global $bdd;
    $bdd->exec("SET NAMES utf8");
	//$rc=del_doublonsFormations();
    $tab=$_SESSION['tab'];

	$clef        = $tab['FOR']['clef'];
    $id          = $tab['FOR']['id'];
    $domaine     = $tab['FOR']['domaine'];
    $formation   = $tab['FOR']['formation'];
    $choix0      = $tab['FOR']['choix'];
    $choix       ='l'+$choix0+'choix1';
    $identifiant = $tab['FOR']['identifiant'];
    $codeQCM     = $tab['FOR']['codeQCM'];

    try {
        // Insertion du message à l'aide d'une requête préparée
        $req = $bdd->prepare("UPDATE formation set id='$id', domaine='$domaine', formation='$formation', identifiant='$identifiant', codeQCM='$codeQCM' WHERE clef='$clef';");
        $req->execute();
        $coderetour = 'Record updated FOR!';
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $coderetour='Erreur FOR updated : '.$e->getMessage();
    }

    //$_SESSION['user'] = $user;
    return $coderetour;
}

//Ajout Renseignements COmplémentaires
function ajout_RCO(){
    global $bdd;
    $choix=$_SESSION['choix'];
    $tab=$_SESSION['tab'];

    $id=$tab['RCO']['id'];
    $user=$tab['RCO']['user'];
    $rqthlequel=$tab['RCO']['rqthlequel'];
  
    try {
     // Insertion du message à l'aide d'une requête préparée
     $req = $bdd->prepare('INSERT INTO personnerc (id, user, renseignementscomplementaires, rqthlequel, active) VALUES (:i, :u, :rc, :r, :a)');
     $req->execute(array('i' => $id, 'u' => $user, 'rc' => $choix, 'r' => $rqthlequel , 'a' => 'Oui'));
     $coderetour = 'Record created RCO!';
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $coderetour='Erreur RCO INSERT : '.$e->getMessage();
    }

    $_SESSION['user'] = $user;
    return $coderetour;
}


//MàJ Renseignements COmplémentaires
function maj_RCO(){
    global $bdd;
    
    $choix=$_SESSION['choix'];
    $tab=$_SESSION['tab'];

    $id = $tab['RCO']['id'];
    $user=$tab['RCO']['user'];
    $rqthlequel=$tab['RCO']['rqthlequel'];

    try {
        // Insertion du message à l'aide d'une requête préparée
        $req = $bdd->prepare("UPDATE personnerc set id='$id', user='$user', renseignementscomplementaires='$choix', rqthlequel='$rqthlequel', active='Oui' WHERE user='$user';");
        $req->execute();
        $coderetour = 'Record created RCO!';
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $coderetour='Erreur RCO INSERT : '.$e->getMessage();
    }

    $_SESSION['user'] = $user;
    return $coderetour;
}

//Accès table upfiles avec la clef user
function get_mfi(){
    global $bdd;
        
    $user= $_SESSION['user'];

    $req = $bdd->query("SELECT * FROM upfiles WHERE user like '".$user."%' ORDER BY clef DESC LIMIT 4;");
    $req->execute();
    $upfile = $req->fetchall();
        
    return $upfile;
}

//Ajout infos MFI CV en base
function maj_MFICV(){
    global $conn;
    
    $parametres=$_SESSION['tab'];

    $id=$parametres['MFI']['id'];
    $user=$parametres['MFI']['user'];
    $upfilename=$parametres['MFI']['upfilename'];
    $upfilesize=$parametres['MFI']['upfilesize'];
    $upfiletitle=$parametres['MFI']['upfiletitle'];
    $upfiledescription=$parametres['MFI']['upfiledescription'];
    $upfilefinalname=$parametres['MFI']['upfilefinalname'];
    $upfiledate=$parametres['MFI']['upfiledate'];

    $sql = "UPDATE upfiles set id='$id', user='$user', upfilename='$upfilename', upfilesize='$upfilesize', upfiletitle='$upfiletitle', upfiledescription='$upfiledescription', upfilefinalname='$upfilefinalname', upfiledate='$upfiledate' WHERE user='$user';";

    if ($conn->query($sql) === TRUE) {
        $coderetour = "New record updated successfully MFI";
    }else{
        $coderetour = "MFI CV updated Error: " . $sql . "<br>" . $conn->error;
    }

    return $coderetour;
}


//Ajout infos MFI en base
function ajout_MFICV(){
    global $conn;
    
    $parametres=$_SESSION['tab'];

    $id=$parametres['MFI']['id'];
    $user=$parametres['MFI']['user'];
    $upfilename=$parametres['MFI']['upfilename'];
    $upfilesize=$parametres['MFI']['upfilesize'];
    $upfiletitle=$parametres['MFI']['upfiletitle'];
    $upfiledescription=$parametres['MFI']['upfiledescription'];
    $upfilefinalname=$parametres['MFI']['upfilefinalname'];
    $upfiledate=$parametres['MFI']['upfiledate'];

    $sql = "INSERT INTO upfiles (id, user, upfilename, upfilesize, upfiletitle, upfiledescription, upfilefinalname, upfiledate) VALUES ('$id', '$user', '$upfilename', '$upfilesize', '$upfiletitle', '$upfiledescription', '$upfilefinalname', '$upfiledate')";

    if ($conn->query($sql) === TRUE) {
        $coderetour = "New record created successfully MFI";
    }else{
        $coderetour = "MFI Error: " . $sql . "<br>" . $conn->error;
    }

    return $coderetour;
}


//Ajout infos MFI CV en base
function maj_MFILDM(){
    global $conn;
    
    $parametres=$_SESSION['tab'];

    $id=$parametres['MFI']['id'];
    $user=$parametres['MFI']['user'];
    $upfilename=$parametres['MFI']['upfilename'];
    $upfilesize=$parametres['MFI']['upfilesize'];
    $upfiletitle=$parametres['MFI']['upfiletitle'];
    $upfiledescription=$parametres['MFI']['upfiledescription'];
    $upfilefinalname=$parametres['MFI']['upfilefinalname'];
    $upfiledate=$parametres['MFI']['upfiledate'];

    $sql = "UPDATE upfiles set id='$id', user='$user', upfilename='$upfilename', upfilesize='$upfilesize', upfiletitle='$upfiletitle', upfiledescription='$upfiledescription', upfilefinalname='$upfilefinalname', upfiledate='$upfiledate' WHERE user='$user';";

    if ($conn->query($sql) === TRUE) {
        $coderetour = "New record created successfully MFI";
    }else{
        $coderetour = "MFI Error: " . $sql . "<br>" . $conn->error;
    }

    return $coderetour;
}


//Ajout infos MFI en base
function ajout_MFILDM(){
    global $conn;
    
    $parametres=$_SESSION['tab'];

    $id=$parametres['MFI']['id'];
    $user=$parametres['MFI']['user'];
    $upfilename=$parametres['MFI']['upfilename'];
    $upfilesize=$parametres['MFI']['upfilesize'];
    $upfiletitle=$parametres['MFI']['upfiletitle'];
    $upfiledescription=$parametres['MFI']['upfiledescription'];
    $upfilefinalname=$parametres['MFI']['upfilefinalname'];
    $upfiledate=$parametres['MFI']['upfiledate'];

    $sql = "INSERT INTO upfiles (id, user, upfilename, upfilesize, upfiletitle, upfiledescription, upfilefinalname, upfiledate) VALUES ('$id', '$user', '$upfilename', '$upfilesize', '$upfiletitle', '$upfiledescription', '$upfilefinalname', '$upfiledate')";

    if ($conn->query($sql) === TRUE) {
        $coderetour = "New record created successfully MFI";
    }else{
        $coderetour = "MFI Error: " . $sql . "<br>" . $conn->error;
    }

    return $coderetour;
}


//Vérifie si laclef existe?
function existe_enreg($table, $champ, $valeur){
    global $bdd;

    //echo "<br/>"."SELECT * FROM $table WHERE $champ = '$valeur' ORDER BY clef DESC LIMIT 1;";
	//echo "SELECT * FROM $table WHERE $champ = '$valeur' ORDER BY clef DESC LIMIT 1;";
	try{
		$req = $bdd->query("SELECT * FROM $table WHERE $champ = '$valeur' ORDER BY clef DESC LIMIT 1;");
    	$req->execute();
    	$enregistrement = $req->fetchall();
    	//echo " - Nb enreg: ".count($enregistrement);
    	if (count($enregistrement) != 0) return true;
    	else return false;	
	}catch(Exception $e){
		return true;
	}
}

//Accès table RC
function get_renseignementscomplementaires() {
    global $bdd;
        
    $user= $_SESSION['user'];

    $req = $bdd->query("SELECT * FROM personnerc WHERE user = '$user' ORDER BY clef DESC LIMIT 1;");
    $req->execute();
    $renseignementscomplementaires = $req->fetchall();
        
    return $renseignementscomplementaires;
}

//Accès informations pédagogiques avec l'email
function get_infosprofessionnelles(){
    global $bdd;
        
    $user= $_SESSION['user'];

    $req = $bdd->query("SELECT * FROM personneipr WHERE user = '$user' AND active='Oui' ORDER BY clef DESC LIMIT 1;");
    //$reponseIPr = $bdd->query("SELECT * FROM personneipr WHERE user = '$user' AND active='Oui' ORDER BY clef DESC LIMIT 1;") or die('Erreur SELECT !');

    $req->execute();
    $infospedagogiques = $req->fetchAll();
        
    return $infospedagogiques;
}

//Accès informations pédagogiques avec l'email
function get_infospedagogiques(){
    global $bdd;
        
    $user= $_SESSION['user'];

    $req = $bdd->query("SELECT * FROM personneip WHERE user = '$user' ORDER BY clef DESC LIMIT 1;");
    $req->execute();
    $infospedagogiques = $req->fetchAll();
        
    return $infospedagogiques;
}

//Accès table formations avec le code choix (exemple: l1choix1 ou l9choix1, ...) pour récupérer le libellé.
function get_formationsenvisagees2() {
    global $bdd;
        
    $choix= $_SESSION['choix'];

    $req = $bdd->query("SELECT * FROM formation WHERE choix = '$choix' ORDER BY clef DESC LIMIT 1;");
    $req->execute();
    $formationsenvisagees2 = $req->fetchall();
        
    return $formationsenvisagees2;
}

//Accès table formations envisagees avec l'email.
function get_formationsenvisagees() {
    global $bdd;
        
    $user= $_SESSION['user'];
    //echo "<br/>Utilisateur: "+$user;

    if ($user != "") $sql="SELECT * FROM personnefe WHERE user = '$user' ORDER BY clef DESC LIMIT 1;";
    else $sql="SELECT * FROM personnefe ORDER BY formationenvisagees;";

    $req = $bdd->query($sql);
    $req->execute();
    $formationsenvisagees = $req->fetchAll();
        
    return $formationsenvisagees;
}


//Accès table etat perosnne avec l'email.
function get_etatscandidat() {
    global $bdd;
        
    $user= $_SESSION['user'];

    $req = $bdd->query("SELECT * FROM etatscandidat WHERE user = '$user' ORDER BY clef DESC LIMIT 1;");
    $req->execute();
    $etatscandidat = $req->fetchAll();
        
    return $etatscandidat;
}

//
function get_infosdivers(){
    global $bdd;

    $user= $_SESSION['user'];
            
    $req = $bdd->query("SELECT * FROM personnedi WHERE user='$user' ORDER BY clef;");
    $req->execute();
    $infosdivers = $req->fetchAll();
        
    return $infosdivers;
}

//Accès table param pour et recupération de tout les infos connu instic.
function get_allconnuinstic() {
    global $bdd;
            
    $req = $bdd->query("SELECT * FROM param WHERE champ='connuinstic' ORDER BY clef;");
    $req->execute();
    $allconnuinstic = $req->fetchAll();
        
    return $allconnuinstic;
}

//Accès table param pour et recupération de tout les états candidats.
function get_alletatscandidat_tri() {
    global $bdd;
            
    $req = $bdd->query("SELECT * FROM param WHERE champ='état' ORDER BY valeur;");
    $req->execute();
    $alletatscandidat_tri = $req->fetchAll();
        
    return $alletatscandidat_tri;
}

//Accès table param pour et recupération de tout les états candidats.
function get_alletatscandidat() {
    global $bdd;
            
    $req = $bdd->query("SELECT * FROM param WHERE champ like '%état%' ORDER BY clef;");
    $req->execute();
    $alletatscandidat = $req->fetchAll();
        
    return $alletatscandidat;
}

//
function get_allstatuts(){
    global $bdd;
            
    $req = $bdd->query("SELECT * FROM param  WHERE champ='état' ORDER BY clef;");
    $req->execute();
    $allstatuts = $req->fetchAll();
        
    return $allstatuts;    
}

//Accès table formation pour et recupération de tout le monde.
function get_allformations_tri() {
    global $bdd;
            
    $req = $bdd->query("SELECT * FROM formation ORDER BY formation;");
    $req->execute();
    $allformations_tri = $req->fetchAll();
        
    return $allformations_tri;
}

//Accès table formation avec le code identifiant.
function get_formation() {
    global $bdd;

    $valeurtri=$_SESSION['valeurtri'];

    $req = $bdd->query("SELECT * FROM formation WHERE identifiant='$valeurtri' ORDER BY clef;");
    $req->execute();
    $allformations = $req->fetchAll();
        
    return $allformations;
}

//Accès table formation pour et recupération de tout le monde.
function get_allformations() {
    global $bdd;
            
    $req = $bdd->query("SELECT * FROM formation ORDER BY clef;");
    $req->execute();
    $allformations = $req->fetchAll();
        
    return $allformations;
}

//Accès table personne pour et recupération de tout le monde.
function get_allpersonnesArchives() {
    global $bdd;
            
    $req = $bdd->query("SELECT * FROM personnearchive ORDER BY clef;");
    $req->execute();
    $allpersonnesarchives = $req->fetchAll();
        
    return $allpersonnesarchives;
}

//Accès table personne pour et recupération de tout les dates création uniques.
function get_allpersonnesdtcArchives() {
    global $bdd;
            
    $req = $bdd->query("SELECT DISTINCT datecreation FROM personne ORDER BY clef;");
    $req->execute();
    $allpersonnesdtc = $req->fetchAll();
        
    return $allpersonnesdtc;
}

//Accès table personne pour et recupération de tout les dates entretien uniques.
function get_allpersonnesdteArchives() {
    global $bdd;
            
    $req = $bdd->query("SELECT DISTINCT dateentretien FROM personne ORDER BY clef;");
    $req->execute();
    $allpersonnesdte = $req->fetchAll();
        
    return $allpersonnesdte;
}

//Accès table personne pour et recupération de tout le monde sans fetch.
function get_allpersonnes2Ai() {
    global $conn;
            
    //$req = $bdd->query("SELECT * FROM personnearchive ORDER BY clef;");
    
    $sql = "SELECT * FROM personnearchive ORDER BY clef;";

    if ($conn->query($sql) === TRUE) {
        $coderetour = $conn->query($sql);
    }else{
        $coderetour = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    return $coderetour;
}


//Accès table personne pour et recupération de tout le monde sans fetch.
function get_allpersonnes2A() {
    global $bdd;
            
    $req = $bdd->query("SELECT * FROM personnearchive ORDER BY clef;");
    $req->execute();
        
    return $req;
}


//Accès table perosnne avec l'email et trié sur le nom prénom = id.
function get_allpersonnes_tri() {
    global $bdd;
        
    $user= $_SESSION['user'];
    $champtri= $_SESSION['champtri'];
    
    $sql="SELECT * FROM personne ORDER BY clef;";
    if ($champtri == 'datecreation') $sql="SELECT * FROM personne ORDER BY datecreation;";
    if ($champtri == 'id') $sql="SELECT * FROM personne ORDER BY id;";
    if ($champtri == 'dateentretien') $sql="SELECT * FROM personne ORDER BY dateentretien;";


    $req = $bdd->query($sql);
    $req->execute();
    $get_allpersonnes_tri = $req->fetchAll();
        
    return $get_allpersonnes_tri;
}

//Accès table personne pour et recupération de tout le monde.
function get_allpersonnes() {
    global $bdd;
            
    $req = $bdd->query("SELECT * FROM personne ORDER BY clef;");
    $req->execute();
    $allpersonnes = $req->fetchAll();
        
    return $allpersonnes;
}

//Accès table personne pour et recupération de tout le monde sans fetch.
function get_allpersonnes2() {
    global $bdd;
            
    $req = $bdd->query("SELECT * FROM personne ORDER BY clef;");
    $req->execute();
        
    return $req;
}

//Accès table personne pour et recupération de tout les dates création uniques.
function get_allpersonnesdtc() {
    global $bdd;
            
    $req = $bdd->query("SELECT DISTINCT datecreation FROM personne ORDER BY clef;");
    $req->execute();
    $allpersonnesdtc = $req->fetchAll();
        
    return $allpersonnesdtc;
}

//Accès table personne pour et recupération de tout les dates entretien uniques.
function get_allpersonnesdte() {
    global $bdd;
            
    $req = $bdd->query("SELECT DISTINCT dateentretien FROM personne ORDER BY clef;");
    $req->execute();
    $allpersonnesdte = $req->fetchAll();
        
    return $allpersonnesdte;
}

//Accès table perosnne avec l'email.
function get_personne() {
    global $bdd;
        
	$user= $_SESSION['user'];
    //echo "user2";
    //echo $user;

    $req = $bdd->query("SELECT * FROM personne WHERE user = '$user' ORDER BY clef DESC LIMIT 1;");
    $req->execute();
    $personne = $req->fetchAll();
        
    return $personne;
}

//Accès table personne avec le nom.
function get_personne2() {
    global $bdd;
        
    $nom= $_SESSION['nom'];

    $req = $bdd->query("SELECT * FROM personne WHERE nom = '$nom' ORDER BY clef DESC LIMIT 1;");    
    $req->execute();
    $personne = $req->fetchAll();
        
    return $personne;
}

//Accès à la table Etat Civil avec l'email.
function get_etatcivil() {
    global $bdd;
        
	$user= $_SESSION['user'];

    $req = $bdd->query("SELECT * FROM etatcivil WHERE email = '$user' ORDER BY clef DESC LIMIT 1;");    
    $req->execute();
    $etatcivil = $req->fetchAll();
        
    return $etatcivil;
}


//Ajout d'une personne à la table personne en mode CEC.
function ajout_personneArchive() {
    global $conn;
    global $bdd;

    //$user=$_SESSION['user'];
    //echo "<br />==================dans modele========<br />";
    //echo $user;
    $user=$_SESSION['user'];
    //Select en table personne pour récupérer les infos
    $personne=get_personne();
    foreach($personne as $cle => $champs) {
        $id=$champs['id'];           
        $titre=$champs['titre'];            
        $nom=$champs['nom'];
        $prenom=$champs['prenom'];
        $user=$champs['user'];
        $mdp=$champs['mdp'];
    }        

$sql = "INSERT INTO  personnearchive (id, titre, nom, prenom,  user, mdp, datecreation, datemaj, dateentretien) VALUES ('$id', '$titre', '$nom', '$prenom', '$user', '$mdp', NOW(), NOW(), NOW())";

    if ($conn->query($sql) === TRUE) {
        $coderetour = "New record created successfully";
    }else{
        $coderetour = "Error: " . $sql . "<br>" . $conn->error;
    }

    //echo "=============RC===========<br />";
    //echo $coderetour;
    
    //Début Delete des tables personne, personnefe, personneip, ...
	//Ajout en tb personnearchive
//$query = "INSERT INTO  personnearchive (id, titre, nom, prenom,  user, mdp, datecreation, datemaj, dateentretien) VALUES ('$id', '$titre', '$nom', '$prenom', '$user', '$mdp', NOW(), NOW(), NOW())";
	//	$result = $bdd->prepare($query);		
	//	$res = $result->execute();
		
		//Delete en tb personne	et grâce aux foreign key, les autres tb seront MàJ, del des enreg $user en mode cascade
		$query = "DELETE FROM personne WHERE user='".$user."'";
		$result = $bdd->prepare($query);		
		$res = $result->execute();				
			
    //Fin Delete all

    return $coderetour;
}

//Ajout d'une personne à la table personne en mode CNC. KO remplacé par la classe PersonneManager.class.php
function ajout_personne() {
    global $conn;
        
    //Insertion
    $tab=$_SESSION['tab'];
    $titre=$tab['CNC']['titre'];
    $nom=$tab['CNC']['nom'];
    $prenom=$tab['CNC']['prenom'];
    $id = $nom.' '.$prenom;
    $user=$tab['CNC']['user'];
    $mdp=$tab['CNC']['mdp'];
    $datec=$tab['CNC']['datec'];
    //$daterelance=$tab['CNC']['daterelance'];
    //$datearchive=$tab['CNC']['datearchive'];

    $sql = "INSERT INTO  personne (id, titre, nom, prenom,  user, mdp, datecreation, datemaj, dateentretien, profil, dtrelance7, dtarchive, VAC, dtrelance14) VALUES ('$id', '$titre', '$nom', '$prenom', '$user', '$mdp', '$datec', '$datec', '9999-99-99', 'Candidat', DATE_ADD(NOW(), INTERVAL 7 DAY), DATE_ADD(NOW(), INTERVAL 21 DAY), 'NON',  DATE_ADD(NOW(), INTERVAL 14 DAY))";

    if ($conn->query($sql) === TRUE) {
        $coderetour = "New record created successfully";
    }else{
        $coderetour = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    echo '<br />Sql:'.$sql;
echo "<br />Rc: ".$coderetour;
die();
    return $coderetour;
}

//MàJ infos professionnelles
function maj_infosprofessionnelles(){
    global $conn;

    $choix=$_SESSION['choix'];
    $tab=$_SESSION['tab'];

    $id=$tab['IPr']['id'];
    $email=$tab['IPr']['email'];
    $numerode=$tab['IPr']['numerode'];
    $datede=$tab['IPr']['datede'];

    $stagiairenomentreprise=$tab['IPr']['stagiairenomentreprise'];
    $stagiaireduree=$tab['IPr']['stagiaireduree'];
    $stagiairenature=$tab['IPr']['stagiairenature'];

    $salarienomentreprise=$tab['IPr']['salarienomentreprise'];
    $salarienature=$tab['IPr']['salarienature'];

    $alternancenomentreprise=$tab['IPr']['alternancenomentreprise'];
    $alternanceduree=$tab['IPr']['alternanceduree'];
    $alternancetype=$tab['IPr']['alternancetype'];
    $alternanceformation=$tab['IPr']['alternanceformation'];

    $autresituationlib=$tab['IPr']['autresituationlib'];

    $sql = "UPDATE personneipr SET id='$id', user='$email', spa='$choix', numerode='$numerode', datede='$datede', active='Oui', salarienomentreprise='$salarienomentreprise', salarienature='$salarienature', stagiairenomentreprise='$stagiairenomentreprise', stagiaireduree='$stagiaireduree', stagiairenature='$stagiairenature', alternancenomentreprise='$alternancenomentreprise', alternanceduree='$alternanceduree', alternancetype='$alternancetype', alternanceformation='$alternanceformation', autresituationlib='$autresituationlib' WHERE user = '$email';";
    //echo "<br/>sql maj ipr= ".$sql;
    if ($conn->query($sql) === TRUE) {
        $coderetour = "Record updated successfully";
    } else {
        $coderetour = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    $_SESSION['user'] = $email;
    //echo "<br/>RC= ".$coderetour;
    return $coderetour;
}


//Ajout infos professionnelles
function ajout_infosprofessionnelles(){
    global $conn;

    $choix=$_SESSION['choix'];
    $tab=$_SESSION['tab'];

    $id=$tab['IPr']['id'];
    $email=$tab['IPr']['email'];
    $numerode=$tab['IPr']['numerode'];
    $datede=$tab['IPr']['datede'];

    $stagiairenomentreprise=$tab['IPr']['stagiairenomentreprise'];
    $stagiaireduree=$tab['IPr']['stagiaireduree'];
    $stagiairenature=$tab['IPr']['stagiairenature'];

    $salarienomentreprise=$tab['IPr']['salarienomentreprise'];
    $salarienature=$tab['IPr']['salarienature'];

    $alternancenomentreprise=$tab['IPr']['alternancenomentreprise'];
    $alternanceduree=$tab['IPr']['alternanceduree'];
    $alternancetype=$tab['IPr']['alternancetype'];
    $alternanceformation=$tab['IPr']['alternanceformation'];

    $autresituationlib=$tab['IPr']['autresituationlib'];

    $sql = "INSERT INTO personneipr (id, user, spa, numerode, datede, active, salarienomentreprise, salarienature, stagiairenomentreprise, stagiaireduree, stagiairenature, alternancenomentreprise, alternanceduree, alternancetype, alternanceformation, autresituationlib)
    VALUES ('$id', '$email', '$choix', '$numerode', '$datede', 'Oui', '$salarienomentreprise', '$salarienature', '$stagiairenomentreprise', '$stagiaireduree', '$stagiairenature', '$alternancenomentreprise', '$alternanceduree', '$alternancetype', '$alternanceformation' ,'$autresituationlib')";

    if ($conn->query($sql) === TRUE) {
        $coderetour = "New record created successfully";
    } else {
        $coderetour = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    $_SESSION['user'] = $email;
    return $coderetour;
}

//
//MàJ infos pédagogiques
function maj_infospedagogiques(){
    global $bdd;
    
    $parametres=$_SESSION['tab'];
    $choix=$_SESSION['choix'];

    $id=$parametres['IPE']['id'];
    $user=$parametres['IPE']['user'];
    $etudes=$parametres['IPE']['etudes'];
    $annee=$parametres['IPE']['annee'];
    $resultat=$parametres['IPE']['resultat'];
    $etablissement=$parametres['IPE']['etablissement'];
    $lv1libelle=$parametres['IPE']['lv1libelle'];
    $lv2libelle=$parametres['IPE']['lv2libelle'];

    try {
     // Insertion
     $req = $bdd->prepare("UPDATE personneip SET id='$id', user='$user', etudes='$etudes', annee='$annee', resultat='$resultat', etablissement='$etablissement', languesvivantes='$choix', active='Oui', lv1libelle='$lv1libelle', lv2libelle='$lv2libelle' WHERE user ='$user'");
     $req->execute();
     $coderetour='New record created successfully';
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $coderetour=('Erreur INSERT : '.$e->getMessage());
    }

    return $coderetour;
}


//Ajout infos pédagogiques
function ajout_infospedagogiques(){
    global $bdd;
    
    $parametres=$_SESSION['tab'];
    $choix=$_SESSION['choix'];

    $id=$parametres['IPE']['id'];
    $user=$parametres['IPE']['user'];
    $etudes=$parametres['IPE']['etudes'];
    $annee=$parametres['IPE']['annee'];
    $resultat=$parametres['IPE']['resultat'];
    $etablissement=$parametres['IPE']['etablissement'];
	$lv1libelle=$parametres['IPE']['lv1libelle'];
    $lv2libelle=$parametres['IPE']['lv2libelle'];
    try {
     // Insertion
     $req = $bdd->prepare('INSERT INTO personneip (id, user, etudes, annee, resultat, etablissement, languesvivantes, active, lv1libelle, lv2libelle) VALUES (:i, :u, :e, :an, :r, :et, :l, :a, :lv1, :lv2)');
     $req->execute(array('i' => $id, 'u' => $user, 'e' => $etudes, 'an' => $annee, 'r' => $resultat, 'et' => $etablissement, 'l' => $choix, 'a' => 'Oui', 'lv1' => $lv1libelle, 'lv2' => $lv2libelle));
     $coderetour='New record created successfully';
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $coderetour=('Erreur INSERT : '.$e->getMessage());
    }

    return $coderetour;
}

//MàJ formations envisagees.
function maj_formationenvisagee() {
    global $bdd;

    $choix=$_SESSION['choix'];
    $tab=$_SESSION['tab'];

    $user=$tab['FE']['user'];

    try {
        // Insertion du message à l'aide d'une requête préparée
        $req = $bdd->prepare("UPDATE personnefe set user='$user', formationenvisagees='$choix', active='Oui', dtmaj=NOW() WHERE user='$user'");
        $req->execute();
        $coderetour = "New record created successfully";
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout        
        $coderetour = 'Erreur INSERT : '.$e->getMessage();
    }

    return $coderetour;
}


//Ajout d'une personne à la table formations envisagees.
function ajout_formationenvisagee() {
    global $bdd;

    $choix=$_SESSION['choix'];
    $tab=$_SESSION['tab'];

    $user=$tab['FE']['user'];
	$ddj=date("Y-m-d");
    try {
        // Insertion du message à l'aide d'une requête préparée
        $req = $bdd->prepare('INSERT INTO personnefe (user, formationenvisagees, active, dtcreation) VALUES (:u, :f, :a, :dtc)');
        $req->execute(array('u' => $user, 'f' => $choix, 'a' => 'Oui', 'dtc' => $ddj));
        $coderetour = "New record created successfully";
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout        
        $coderetour = 'Erreur INSERT : '.$e->getMessage();
    }

    return $coderetour;
}

//MàJ etat candidat
function maj_etatdossierOK($user, $etat) {
    global $bdd;
    
    $sql = "UPDATE etatscandidat set ".$etat."='OK', dtmaj=NOW() WHERE user='$user'";

    try {
        // Insertion du message à l'aide d'une requête préparée
        $req = $bdd->query($sql);        
        $coderetour = "$user record updated successfully";
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout        
        $coderetour = "$user, Erreur INSERT : ".$e->getMessage();
    }    

    return $coderetour;
}


//MàJ etats candidat
function maj_etatsdossier() {
     global $conn;
        
    //Insertion
    $tab=$_SESSION['tab'];
    $id=$tab['FE']['id'];
    $user=$tab['FE']['user'];
    $etatcandidature=$tab['FE']['etatcandidature'];
    $etatECI=$tab['FE']['etatECI'];
    $etatFEN=$tab['FE']['etatFEN'];
    $etatIPE=$tab['FE']['etatIPE'];
    $etatIPR=$tab['FE']['etatIPR'];
    $etatDIV=$tab['FE']['etatDIV'];
    $etatFIC=$tab['FE']['etatFIC'];

    $sql = "UPDATE etatscandidat set id='$id', user='$user', etatcandidature='$etatcandidature', etatECI='$etatECI', etatFEN='$etatFEN', etatIPE='$etatIPE', etatIPR='$etatIPR', etatDIV='$etatDIV', etatFIC='$etatFIC' WHERE user='$user'";

    if ($conn->query($sql) === TRUE) {
        $etatscandidat = "New record created successfully";
    }else{
        $etatscandidat = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    return $etatscandidat;
}

//Ajout etats du dossier du candidat
function ajout_etatsdossier() {
     global $conn;
        
    //Insertion
    $tab=$_SESSION['tab'];
    $id=$tab['FE']['id'];
    $user=$tab['FE']['user'];
    //$etatcandidature=$tab['FE']['etatcandidature'];
    $etatcandidature='Dossier en attente de transmission';
    $etatECI=$tab['FE']['etatECI'];
    $etatFEN=$tab['FE']['etatFEN'];
    $etatIPE=$tab['FE']['etatIPE'];
    $etatIPR=$tab['FE']['etatIPR'];
    $etatDIV=$tab['FE']['etatDIV'];
    $etatFIC=$tab['FE']['etatFIC'];

    $sql = "INSERT INTO  etatscandidat (id, user, etatcandidature, etatECI, etatFEN, etatIPE, etatIPR, etatDIV, etatFIC) VALUES ('$id', '$user', '$etatcandidature', '$etatECI', '$etatFEN', '$etatIPE', '$etatIPR', '$etatDIV', '$etatFIC')";

    if ($conn->query($sql) === TRUE) {
        $etatscandidat = "New record created successfully";
    }else{
        $etatscandidat = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    return $etatscandidat;
}

//Remise à "achanger" du mot de passe.
function reinit_MDP() {
    global $bdd;
    $nouveaumdp='achanger';
    
    $user= $_SESSION['user'];

    try {
        // Insertion du message à l'aide d'une requête préparée
        $req = $bdd->query("UPDATE personne SET mdp='$nouveaumdp' WHERE user ='$user';");        
        $changerMDP = "New record updated successfully";
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout        
        $changerMDP = 'Erreur INSERT : '.$e->getMessage();
    }

    return $changerMDP;
}

//MàJ date entretin & statut.
function maj_ECIAdmin() {
    global $bdd;
                                
    $tab=$_SESSION['tab'];        
    $dte=$tab['Admin']['dateentretien'];
    $statut=$tab['Admin']['statut'];
    //$newDate = date("d-m-Y", strtotime($dte));
	//echo "Dt entretien: " . $dte;
	//die();
    $user= $_SESSION['user'];

    try {
        // Insertion du message à l'aide d'une requête préparée
        $req = $bdd->query("UPDATE personne SET dateentretien='$dte', datemaj=NOW() WHERE user ='$user';");        
        $changerECIAdmin = "$user tb personne updated successfully";
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout        
        $changerECIAdmin = "$user - Erreur INSERT : ".$e->getMessage();
    }

    try {
        // Insertion du message à l'aide d'une requête préparée
        $req = $bdd->query("UPDATE etatscandidat SET etatcandidature='$statut', dtmaj=NOW() WHERE user ='$user';");        
        $changerECIAdmin .= "$user tb étatscandidat updated successfully";
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout        
        $changerECIAdmin .= "$user Erreur INSERT : ".$e->getMessage();
    }

    return $changerECIAdmin;
}

//MàJ infos DIVerses
function ajout_DIV(){
    global $bdd;
    global $conn;

    $tab=$_SESSION['tab'];

    $id=$tab['DIV']['id'];
    $user=$tab['DIV']['user'];
    $connuinstic=$tab['DIV']['connuinstic'];
    $dejacandidat=$tab['DIV']['dejacandidat'];
    $autreetablissement=$tab['DIV']['autreetablissement'];
    $etablissementoui1=$tab['DIV']['etablissementoui1'];
    $etablissementoui2=$tab['DIV']['etablissementoui2'];
    $etablissementoui3=$tab['DIV']['etablissementoui3'];
    $etablissementoui4=$tab['DIV']['etablissementoui4'];
	$ddj=date("Y-m-d");
	
    try{
    // Insertion du message à l'aide d'une requête préparée
    $req = $bdd->prepare('INSERT INTO personnedi (id, user, connuinstic, dejacandidat, autreetablissement, etablissementoui1, etablissementoui2, etablissementoui3, etablissementoui4, dtmaj) VALUES (:i, :u, :c, :d, :a, :e1, :e2, :e3, :e4, :dtm)');
    $req->execute(array('i' => $id, 'u' => $user, 'c' => $connuinstic, 'd' => $dejacandidat, 'a' => $autreetablissement, 'e1' => $etablissementoui1, 'e2' => $etablissementoui2, 'e3' => $etablissementoui3, 'e4' => $etablissementoui4, 'dtm' => $ddj));
    $coderetour='New record created successfully';
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $coderetour='Erreur INSERT : '.$e->getMessage();
    }

    //echo "RC= ".$coderetour;
    return $coderetour;
}


//MàJ infos DIVerses
function maj_DIV(){
    global $bdd;
    global $conn;

    $tab=$_SESSION['tab'];

    $id=$tab['DIV']['id'];
    $user=$tab['DIV']['user'];
    $connuinstic=$tab['DIV']['connuinstic'];
    $dejacandidat=$tab['DIV']['dejacandidat'];
    $autreetablissement=$tab['DIV']['autreetablissement'];
    $etablissementoui1= (isset($tab['DIV']['etablissementoui1'])) ? $tab['DIV']['etablissementoui1'] : '';
    $etablissementoui2= (isset($tab['DIV']['etablissementoui3'])) ? $tab['DIV']['etablissementoui2'] : '';
    $etablissementoui3= (isset($tab['DIV']['etablissementoui3'])) ? $tab['DIV']['etablissementoui3'] : '';
    $etablissementoui4= (isset($tab['DIV']['etablissementoui4'])) ? $tab['DIV']['etablissementoui4'] : '';

    try{
     // Insertion du message à l'aide d'une requête préparée
     $req = $bdd->prepare("UPDATE personnedi SET id='$id', user='$user', connuinstic='$connuinstic', dejacandidat='$dejacandidat', autreetablissement='$autreetablissement', etablissementoui1='$etablissementoui1', etablissementoui2='$etablissementoui2', etablissementoui3='$etablissementoui3', etablissementoui4='$etablissementoui4', dtmaj=NOW() WHERE user='$user';");
     $req->execute();
     $coderetour= "$user Record updated successfully DIV";
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $coderetour='$user Erreur INSERT : '.$e->getMessage();
    }

    //echo "RC= ".$coderetour;
    return $coderetour;
}

//Ajout Etat CIvil
function ajout_ECI(){
    global $bdd;
    global $conn;

    $tab=$_SESSION['tab'];

    //======================================================================================================
    //Partie ICO = info COmpte
    //======================================================================================================
    $titre=$tab['IC']['titre'];
    $nom=$tab['IC']['nom'];
    $prenom=$tab['IC']['prenom'];
    $user=$tab['IC']['user'];
    $mdp=$tab['IC']['mdp'];
    $id = $nom.' '.$prenom;

    try{
     // Insertion du message à l'aide d'une requête préparée
     $req = $bdd->prepare("UPDATE personne SET id='$id', titre='$titre', nom='$nom', prenom='$prenom', mdp='$mdp' WHERE user='$user';");
     $req->execute();
     $coderetour = "Record updated successfully IC";
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $coderetour= 'Erreur INSERT : '.$e->getMessage();
    }

    //return $coderetour;

    //======================================================================================================
    //Partie ECI =Etat CIvil
    //======================================================================================================
    $nom=$tab['EC']['nom'];
    $prenom=$tab['EC']['prenom'];
    $id = $nom.' '.$prenom;
    $neele=$tab['EC']['neele'];
    $lieu=$tab['EC']['lieu'];
    $nationalite=$tab['EC']['nationalite'];
    $telephone=$tab['EC']['telephone'];
    $codepostal=$tab['EC']['codepostal'];
    $nsecuritesociale=$tab['EC']['nsecuritesociale'];
    $email=$tab['EC']['email'];
    $localite=$tab['EC']['localite'];
    //$localite=utf8_encode($localite);
    $adresse=$tab['EC']['adresse'];
    $codepostal=str_replace ( "-", "", $codepostal);
    $nsecuritesociale = str_replace ( "-", "", $nsecuritesociale); 
    $telephone = str_replace ( "-", "", $telephone); 

    // Modification du jeu de résultats en utf8 
    if (!$conn->set_charset("utf8")) {
        $coderetour = "Erreur lors du chargement du jeu de caractères utf8 : %s\n".$mysqli->error;
        exit();
    } else {
        $coderetour="Jeu de caractères courant : %s\n". $conn->character_set_name();
    }

    //Insertion
    $sql = "INSERT INTO etatcivil (id, neele, lieu, nationalite, telephone, codepostal, nsecuritesociale, email, localite, adresse, dtmaj)
    VALUES ('$id', '$neele', '$lieu', '$nationalite', '$telephone', '$codepostal', '$nsecuritesociale',  '$email', '$localite', '$adresse', NOW())";

    if ($conn->query($sql) === TRUE) {
        $coderetour = "New record created successfully EC";
    } else {
        $coderetour = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    $_SESSION['user'] = $email;
    return $coderetour;
}

//MàJ Etat CIvil
function maj_ECI(){
    global $bdd;
    global $conn;

    $tab=$_SESSION['tab'];

    //======================================================================================================
    //Partie ICO = info COmpte
    //======================================================================================================
    $titre=$tab['IC']['titre'];
    $nom=$tab['IC']['nom'];
    $prenom=$tab['IC']['prenom'];
    $user=$tab['IC']['user'];
    $mdp=$tab['IC']['mdp'];
    $id = $nom.' '.$prenom;

    try{
     // Insertion du message à l'aide d'une requête préparée
     $req = $bdd->prepare("UPDATE personne SET id='$id', titre='$titre', nom='$nom', prenom='$prenom', mdp='$mdp', datemaj=NOW() WHERE user='$user';");
     $req->execute();
     $coderetour = "Record updated successfully IC";
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $coderetour= 'Erreur INSERT : '.$e->getMessage();
    }

    //return $coderetour;

    //======================================================================================================
    //Partie ECI =Etat CIvil
    //======================================================================================================
    $nom=$tab['EC']['nom'];
    $prenom=$tab['EC']['prenom'];
    $id = $nom.' '.$prenom;
    $neele=$tab['EC']['neele'];
    $lieu=$tab['EC']['lieu'];
    $nationalite=$tab['EC']['nationalite'];
    $telephone=$tab['EC']['telephone'];
    $codepostal=$tab['EC']['codepostal'];
    $nsecuritesociale=$tab['EC']['nsecuritesociale'];
    $email=$tab['EC']['email'];
    $localite=$tab['EC']['localite'];
    //$localite=utf8_encode($localite);
    $adresse=$tab['EC']['adresse'];
    $codepostal=str_replace ( "-", "", $codepostal);
    $nsecuritesociale = str_replace ( "-", "", $nsecuritesociale); 
    $telephone = str_replace ( "-", "", $telephone); 

    // Modification du jeu de résultats en utf8 
    if (!$conn->set_charset("utf8")) {
        $coderetour = "Erreur lors du chargement du jeu de caractères utf8 : %s\n".$mysqli->error;
        exit();
    } else {
        $coderetour="Jeu de caractères courant : %s\n". $conn->character_set_name();
    }

    //Insertion
    $sql = "UPDATE etatcivil set id='$id', neele='$neele', lieu='$lieu', nationalite='$nationalite', telephone='$telephone', codepostal='$codepostal', nsecuritesociale='$nsecuritesociale', email='$email', localite='$localite', adresse='$adresse', dtmaj= NOW() WHERE email='$email';";
       
    if ($conn->query($sql) === TRUE) {
        $coderetour = "New record created successfully EC";
    } else {
        $coderetour = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    $_SESSION['user'] = $email;
    return $coderetour;
}

//Création nouveau candfidat
function ajout_CNC(){
    global $bdd;     

    $parametres= $_SESSION['tab'];

    $titre=$parametres['CNC']['titre']; // Création  de compte, pas de saisi du titre.
    $nom=$parametres['CNC']['nom'];
    $prenom=$parametres['CNC']['prenom'];
    $user=$parametres['CNC']['mail'];
    $mdp=$parametres['CNC']['mdp'];
    $id=$nom.' '.$prenom;

    try {
        // Insertion du message à l'aide d'une requête préparée
        $req = $bdd->prepare('INSERT INTO personne (id, titre, nom, prenom,  user, mdp) VALUES (:i, :t, :n, :p, :u, :m)');
        $req->execute(array('i' => $id, 't' => $titre, 'n' => $nom, 'p' => $prenom, 'u' => $user, 'm' => $mdp));
        $coderetour="New record created!";
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        $coderetour='Erreur INSERT : '.$e->getMessage();
    }

    $_SESSION['user'] = $user;

    return $coderetour;
}


//Remise à "achanger" du mot de passe.
function maj_etatfic() {
    global $bdd;
    $nouveauetatfic='OK';
    
    $user= $_SESSION['user'];

    try {
        // Insertion du message à l'aide d'une requête préparée
        $req = $bdd->query("UPDATE etatscandidat SET etatFIC='$nouveauetatfic' WHERE user ='$user';");        
        $changeretatfic = "Record tb etatscandidat updated successfully";
    }catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout        
        $changeretatfic = 'Erreur tb etatscandidat INSERT : '.$e->getMessage();
    }

    return $changeretatfic;
}