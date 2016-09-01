<?php
session_start();

// Tableau contenant les messages d'erreur lies a la validation de chaque
// champ du formulaire.
// On utilisera le nom du champ comme cle du tableau
$errsVCA = array();

//Connexion à la base
include_once '../../modele/connexion_sql.php';
include_once '../../modele/connexion_mysqli.php';
include_once '../../controleur/cpro/fonctions.php';

// On demande les informations en table (modèle)
//Selection pour récupérer les infos personne (modèle)
include_once('../../modele/cpro/get_personne.php');

if (isset($_SESSION['user'])) $user=$_SESSION['user'];
else $user='';

if (isset($_COOKIE['cookieUser']) && $user =='') $user=$_COOKIE['cookieUser'];
//else $user='';

$_SESSION['user']=$user;

$personne=get_personne();
$personneFEN=get_formationsenvisagees();
$personneECI=get_etatcivil();
$personneRCO=get_renseignementscomplementaires();
$personneDIV=get_infosdivers();
$personneIPE=get_infospedagogiques();
$personneIPR=get_infosprofessionnelles();
$allconnuinstic=get_allconnuinstic();

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select Informations personne
//======================================================================================================
if (count($personne) != 0) {        
    foreach($personne as $cle => $row) {
        $id=$row['id'];
        $user=$row['user'];
        $titre=$row['titre']; //Monsieur, Madame, ...
        $nom=$row['nom'];
        $prenom=$row['prenom'];
    }
}

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select Informations Formations ENvisagées
//======================================================================================================
if (count($personneFEN) != 0) {        
    foreach($personneFEN as $cle => $rowFEN) {
    	$id=$rowFEN['id'];
        $user=$rowFEN['user'];
        $formationenvisagees=$rowFEN['formationenvisagees'];
    } //Fin foreach1
    
    $tabchoix=explode("-", $formationenvisagees);
	$tabchoix2=array();
	$nbchoix=substr_count($formationenvisagees,'-');            

	$Alternance=''; $Initial='';
	$FormAGW1=''; $FormAGW2='';
	$FormDW1=''; $FormDW2='';
	$FormBE1=''; $FormBE2=''; $FormBE3='';
	$FormDD1=''; $FormDD2=''; $FormDD3='';
	
	foreach ($tabchoix as $value) {
		$tabchoix2[$value][0]=$value;
		
		switch($value){
			case 'initial':
				$Initial='Oui';	
				break;
		
			case 'alternance':
				$Alternance='Oui';
				break;
				
			case 'l1choix1':
				$FormAGW1='Oui';
				break;
				
			case 'l2choix1':
				$FormAGW2='Oui';	
				break;
		
			case 'l3choix1':
				$FormDW1='Oui';
				break;
				
			case 'l4choix1':
				$FormDW2='Oui';
				break;
				
			case 'l5choix1':
				$FormBE1='Oui';	
				break;
		
			case 'l6choix1':
				$FormBE2='Oui';
				break;
				
			case 'l7choix1':
				$FormBE3='Oui';
				break;
				
			case 'l8choix1':
				$FormDD1='Oui';	
				break;
		
			case 'l9choix1':
				$FormDD2='Oui';
				break;
				
			case 'l10choix1':
				$FormDD3='Oui';
				break;
				
			case 'autre':
				$Autre='On';	
				break;
		
			case 'ardeche':
				$Ardeche='On';
				break;
				
			case 'savoie':
				$Savoie='On';
				break;
			
			case 'rqthoui':
				$RQTH_Oui_2='On';
				break;
				
			case 'rqthnon':
				$RQTH_Non_2='On';
				break;
				
			case 'rqthamespeoui':
				$RQTH_Oui_3='On';
				break;
				
			case 'rqthamespenon':
				$RQTH_Non_3='On';
				break;

			default:
				break;
		} //Fin switch
		
	} //Fin foreach2

    
} //Fin if

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select Informations Etat CIvil
//======================================================================================================
if (count($personneECI) != 0) {        
    foreach($personneECI as $cle => $rowECI) {
        $id=$rowECI['id'];
        $user=$rowECI['email']; //Attention dans la table "etatcivil", user s'appelle email...
        $neele=$rowECI['neele'];
        $lieu=$rowECI['lieu'];
        $nationalite=$rowECI['nationalite'];
        $telephone=$rowECI['telephone'];
        $codepostal=$rowECI['codepostal'];
        $email=$rowECI['email'];
     	$localite=$rowECI['localite'];
        $adresse=$rowECI['adresse'];   
        $nsecuritesociale=$rowECI['nsecuritesociale'];   
        	
    }
}

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select Informations Renseignement COmplémentaires
//======================================================================================================
if (count($personneRCO) != 0) {        
    foreach($personneRCO as $cle => $rowRCO) {
        $id=$rowRCO['id'];
        $user=$rowRCO['user'];
        $renseignementscomplementaires=$rowRCO['renseignementscomplementaires'];
        $rqthlequel=$rowRCO['rqthlequel'];
    } //Fin foreach1
    
    $tabchoixRCO=explode("-", $renseignementscomplementaires);
    $tabchoix2RCO=array();
    $nbchoixRCO=substr_count($renseignementscomplementaires,'-');            

	$Celibataire='';
	$Mariee='';
	$Enfantsacharge='';
	$Permis_Oui='';
	$Permis_Non='';
	$Permis_En_cours='';
	$Rhone='';
	$Isere='';
	$Ain='';
	$Loire='';
	$Haute_Loire='';
	$Drome='';
	$Autre='';
	$Ardeche='';
	$Savoie='';
	$RQTH_Oui_2='';
	$RQTH_Non_2='';
	$RQTH_Oui_3='';
	$RQTH_Non_3='';
	
    foreach ($tabchoixRCO as $value) {
        $tabchoix2RCO[$value][0]=$value;
        
        switch($value){
			case 'celibataire':
				$Celibataire='On';	
				break;
		
			case 'mariee':
				$Mariee='On';
				break;
				
			case 'enfantsacharge':
				$Enfantsacharge='On';
				break;
				
			case 'permisoui':
				$Permis_Oui='On';	
				break;
		
			case 'permisnon':
				$Permis_Non='On';
				break;
				
			case 'permisencours':
				$Permis_En_cours='On';
				break;
				
			case 'rhone':
				$Rhone='On';	
				break;
		
			case 'isere':
				$Isere='On';
				break;
				
			case 'ain':
				$Ain='On';
				break;
				
			case 'loire':
				$Loire='On';	
				break;
		
			case 'hauteloire':
				$Haute_Loire='On';
				break;
				
			case 'drome':
				$Drome='On';
				break;
				
			case 'autre':
				$Autre='On';	
				break;
		
			case 'ardeche':
				$Ardeche='On';
				break;
				
			case 'savoie':
				$Savoie='On';
				break;
			
			case 'rqthoui':
				$RQTH_Oui_2='On';
				break;
				
			case 'rqthnon':
				$RQTH_Non_2='On';
				break;
				
			case 'rqthamespeoui':
				$RQTH_Oui_3='On';
				break;
				
			case 'rqthamespenon':
				$RQTH_Non_3='On';
				break;

			default:
				break;
		} //Fin switch        
    } //Fin foreach2            
} //Fin if

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select Informations DIVerses
//======================================================================================================
if (count($personneDIV) != 0) {        
    foreach($personneDIV as $cle => $rowDIV) {
        $id=$rowDIV['id'];
        $user=$rowDIV['user'];
        $connuinstic=$rowDIV['connuinstic'];
        $dejacandidat=$rowDIV['dejacandidat'];
        $autreetablissement=$rowDIV['autreetablissement'];
        $etablissementoui1=$rowDIV['etablissementoui1'];
        $etablissementoui2=$rowDIV['etablissementoui2'];
        $etablissementoui3=$rowDIV['etablissementoui3'];
        $etablissementoui4=$rowDIV['etablissementoui4'];
    }
}

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select Informations PEdagogiques
//======================================================================================================
if (count($personneIPE) != 0) {        
    foreach($personneIPE as $cle => $rowIPE) {
        $id=$rowIPE['id'];
        $user=$rowIPE['user'];
        $etudes=$rowIPE['etudes'];
        $annee=$rowIPE['annee'];
        $resultat=$rowIPE['resultat'];
        $etablissement=$rowIPE['etablissement'];
        $languesvivantes=$rowIPE['languesvivantes'];
       	$lv1libelle=$rowIPE['lv1libelle'];
        $lv2libelle=$rowIPE['lv2libelle'];
    } //Fin for1
    
    $tabchoixIP=explode("-", $languesvivantes);
    $tabchoix2IP=array();
    $nbchoixIP=substr_count($languesvivantes,'-');            

    foreach ($tabchoixIP as $value) {
        $tabchoix2IP[$value][0]=$value;
	} //Fin for2
	
	//Traitement du tableau
	$LV1_Tres_bon='';
	$LV1_Bon='';
	$LV1_Moyen='';
	$LV1_Notions='';
	
	$LV2_Tres_bon_2='';
	$LV2_Bon_2='';
	$LV2_Moyen_2='';
	$LV2_Notions_2='';
	
	if(!empty($tabchoix2IP['lv1choix1'][0])) { $LV1_Tres_bon='On'; } 
	if(!empty($tabchoix2IP['lv1choix2'][0])) { $LV1_Bon='On'; } 
	if(!empty($tabchoix2IP['lv1choix3'][0])) { $LV1_Moyen='On'; } 
	if(!empty($tabchoix2IP['lv1choix4'][0])) { $LV1_Notions='On'; } 
	
	if(!empty($tabchoix2IP['lv2choix1'][0])) { $LV2_Tres_bon_2='On'; } 
	if(!empty($tabchoix2IP['lv2choix2'][0])) { $LV2_Bon_2='On'; } 
	if(!empty($tabchoix2IP['lv2choix3'][0])) { $LV2_Moyen_2='On'; } 
	if(!empty($tabchoix2IP['lv2choix4'][0])) { $LV2_Notions_2='On'; } 
}
// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
//Select Informations PRofessionnelles
//======================================================================================================
if (count($personneIPR) != 0) {        
    foreach($personneIPR as $cle => $rowIPR) {
        $id=$rowIPR['id'];
        $user=$rowIPR['user'];
        $spa=$rowIPR['spa'];
        $numerode=$rowIPR['numerode'];
        $datede=$rowIPR['datede'];
        $salarienomentreprise=$rowIPR['salarienomentreprise'];
        $salarienature=$rowIPR['salarienature'];
        $stagiairenomentreprise=$rowIPR['stagiairenomentreprise'];
        $stagiaireduree=$rowIPR['stagiaireduree'];
        $stagiairenature=$rowIPR['stagiairenature'];
        $alternancenomentreprise=$rowIPR['alternancenomentreprise'];
        $alternanceduree=$rowIPR['alternanceduree'];
        $alternancetype=$rowIPR['alternancetype'];
        $alternanceformation=$rowIPR['alternanceformation'];
        $autresituationlib=$rowIPR['autresituationlib'];
    } //Fin foreach1
    
    $tabchoixIPr=explode("-", $spa);
    $tabchoix2IPr=array();
    $nbchoixIPr=substr_count($spa,'-');            

	$Etudiant=''; $Contratdepro=''; $Contratdapprentissage=''; $Salarie=''; $Demandeurdemploi='';
	$Stagiaire=''; $Salarietpsplein=''; $Salarietpspartiel=''; $AlternanceIPR=''; $Autresituation='';
	
    foreach ($tabchoixIPr as $value) {
        $tabchoix2IPr[$value][0]=$value;
        
        switch($value){
			case 'etudiant':
				$Etudiant='On';	
				break;
		
			case 'contratdepro':
				$Contratdepro='On';
				break;
				
			case 'contratdapprentissage':
				$Contratdapprentissage='On';
				break;
				
			case 'salarie':
				$Salarie='On';	
				break;
		
			case 'demandeurdemploi':
				$Demandeurdemploi='On';
				break;
				
			case 'stagiaire':
				$Stagiaire='On';
				break;
				
			case 'salarietpsplein':
				$Salarietpsplein='On';	
				break;
		
			case 'salarietpspartiel':
				$Salarietpspartiel='On';
				break;
				
			case 'alternance':
				$AlternanceIPR='On';
				break;
				
			case 'autresituation':
				$Autresituation='On';	
				break;
		
			case 'hauteloire':
				$Haute_Loire='On';
				break;
				
			case 'drome':
				$Drome='On';
				break;
				
			case 'autre':
				$Autre='On';	
				break;
		
			case 'ardeche':
				$Ardeche='On';
				break;
				
			case 'savoie':
				$Savoie='On';
				break;
			
			case 'rqthoui':
				$RQTH_Oui_2='On';
				break;
				
			case 'rqthnon':
				$RQTH_Non_2='On';
				break;
				
			case 'rqthamespeoui':
				$RQTH_Oui_3='On';
				break;
				
			case 'rqthamespenon':
				$RQTH_Non_3='On';
				break;

			default:
				break;
		} //Fin switch
        
    } //Fin foreach2
}

// On effectue du traitement sur les données (contrôleur)
//======================================================================================================
// PDF file
//======================================================================================================
//Personne
$Monsieur = '';
$Madame = '';
if(strstr($titre,'Monsieur')){	$Monsieur = 'On'; //pour activer une case à cocher	
}elseif(strstr($titre,'Madame')){ $Madame = 'On'; //pour activer une case à cocher	
} //Sinon on coche rien car les variables Mr ou Mme ont été initiatlisées à blanc.

//$Madame = 'On';
//$Nom = strtoupperFr('Hénard');
$Nom = strtoupperFr($nom);
//$Prenom = 'Jean-Baptiste';
$Prenom = $prenom;

//Formations ENvisagées
//$FormDD3='Oui'; //case à cocher soit 'On' soit 'Oui' selon les cas...

//Etat CIvil
//$Nee_le = '14/08/1971';
$Nee_le =$neele;
//$accent='Saïgon';
//$Lieu = strtoupperFr($accent);
$Lieu =$lieu;
//$Nationalite = strtoupperFr('Française');
$Nationalite =$nationalite;
//$Adresse = strtoupperFr('Route du col de la Luère');
$Adresse = strtoupperFr($adresse);
//$Localite = strtoupperFr('Grézieu la Varenne');
$Localite = strtoupperFr($localite);
//$Code_postal='69290';
$Code_postal=$codepostal;
//$Telephone='04-78-57-98-26';
$Telephone=$telephone;
//$Portable='06-67-31-90-06';
$Portable=$telephone;
//$N_Securite_Sociale='1111';
$N_Securite_Sociale=$nsecuritesociale;
//$Email='jbhenard@free.fr';
$Email=$email;

//Renseignements Complémentaires
//$Mariee='On';
//$Permis = 'oui';
//$Permis_Oui='On';
//$Rhone='On';
//$RQTH_Oui_2='On';
//$RQTH_Non_3='On';
$RQTH_Si_oui_lequel  = ($rqthlequel) ? $rqthlequel : "";

//Informations PEdagogiques
//$Etudes1Row1='DESS Gestion de Projets';
$Etudes1Row1=$etudes;
//$AnneeRow1='1995';
$AnneeRow1=$annee;
//$ResultatRow1='Obtention';
$ResultatRow1=$resultat;
//$EtablissementRow1='IAE LILLE';
$EtablissementRow1=$etablissement;
//$LV1='Anglais';
$LV1=$lv1libelle;
//$LV2='Espagnol';
$LV2=$lv2libelle;
//$LV1_Bon='On';
//$LV2_Moyen_2='On';

//DIVers

//$Comment_connu_INSTIC='Recherche WEB';
$Comment_connu_INSTIC=$connuinstic;
$Deja_CTI_Oui_4= ($dejacandidat == 'Oui') ? 'On' : '';
$Deja_CTI_Non_4= ($dejacandidat != 'Oui') ? 'On' : '';
$Autre_centre_Oui_5=($autreetablissement == 'Oui') ? 'On' : '';
$Autre_centre_Non_5=($autreetablissement !='Oui') ? 'On' : '';

$Si_oui_lesquels_1=(strlen($etablissementoui1) > 0) ? $etablissementoui1 : '';
$Si_oui_lesquels_2=(strlen($etablissementoui2) > 0) ? $etablissementoui2 : '';
$Si_oui_lesquels_3=(strlen($etablissementoui3) > 0) ? $etablissementoui3 : '';
$Si_oui_lesquels_4=(strlen($etablissementoui4) > 0) ? $etablissementoui4 : '';

//Information Professionnelles
$N_pole_emploi=(strlen($numerode) > 0) ? $numerode : '';
$Date_pole_emploi=(strlen($datede	) > 0) ? $datede : '';
//$Salarie='On';
//$Stagiaire='On';
$Demandeur_demploi=($Demandeurdemploi == 'On') ? 'On' : '';

//$stagiairenomentreprise=$rowIPR['stagiairenomentreprise'];
//$stagiaireduree=$rowIPR['stagiaireduree'];
//$stagiairenature=$rowIPR['stagiairenature'];
//Stagiaire
$Entreprise		=(strlen($stagiairenomentreprise) > 0) ? $stagiairenomentreprise : '';
$Duree			=(strlen($stagiaireduree) > 0) ? $stagiaireduree : '';
$Nature_du_stage=(strlen($stagiairenature) > 0) ? $stagiairenature : '';

//Salarié
$Nom_de_lentreprise_2=(strlen($salarienomentreprise) > 0) ? $salarienomentreprise : '';
$A_temps_plein=($Salarietpsplein == 'On') ? 'On' : '';
$A_temps_partiel=($Salarietpspartiel == 'On') ? 'On' : '';
$Nature_de_l_emploi=(strlen($salarienature) > 0) ? $salarienature : '';

//$salarienomentreprise=$rowIPR['salarienomentreprise'];
//$salarienature=$rowIPR['salarienature'];

//Alternance
//$alternancenomentreprise=$rowIPR['alternancenomentreprise'];
//$alternanceduree=$rowIPR['alternanceduree'];
//$alternancetype=$rowIPR['alternancetype'];
//$alternanceformation=$rowIPR['alternanceformation'];
$En_formation_en_alternance=($AlternanceIPR =='On') ? 'On' : '';
$Nom_de_l_entreprise_3=(strlen($alternancenomentreprise) > 0) ? $alternancenomentreprise : '';
$Duree_2=(strlen($alternanceduree) > 0) ? $alternanceduree : '';
$Type_de_contrat=(strlen($alternancetype) > 0) ? $alternancetype : '';
$Formation_suivie=(strlen($alternanceformation) > 0) ? $alternanceformation : '';

$Case_Autre_situation_1=($Autresituation == 'On') ? 'On' : '';
$Autre_situation=(strlen($autresituationlib) > 0) ? $autresituationlib : '';

//Format FDF
$fdf = '%FDF-1.2
1 0 obj<</FDF<< /Fields[
	<</T(Initial)/V('.$Initial.')>>
	<</T(Alternance)/V('.$Alternance.')>>
	<</T(Madame)/V('.$Madame.')>>
	<</T(Monsieur)/V('.$Monsieur.')>>
	<</T(Nee_le)/V('.$Nee_le.')>>
	<</T(Lieu)/V('.$Lieu.')>>
	<</T(Nationalite)/V('.$Nationalite.')>>
	<</T(Nom)/V('.$Nom.')>>
	<</T(Prenom)/V('.$Prenom.')>>
	<</T(Adresse)/V('.$Adresse.')>>
	<</T(Localite)/V('.$Localite.')>>
	<</T(Code_postal)/V('.$Code_postal.')>>
	<</T(Email)/V('.$Email.')>>
	<</T(Telephone)/V('.$Telephone.')>>
	<</T(Portable)/V('.$Portable.')>>
	<</T(N_Securite_Sociale)/V('.$N_Securite_Sociale.')>>
	<</T(Nom_de_l_entreprise)/V('.$Entreprise.')>>
	<</T(Permis_Oui)/V('.$Permis_Oui.')>>
	<</T(Permis_Non)/V('.$Permis_Non.')>>
	<</T(Permis_En_cours)/V('.$Permis_En_cours.')>>
	<</T(Celibataire)/V('.$Celibataire.')>>
	<</T(Mariee)/V('.$Mariee.')>>
	<</T(Enfants_a_charge)/V('.$Enfantsacharge.')>>
	<</T(N_pole_emploi)/V('.$N_pole_emploi.')>>
	<</T(Date_pole_emploi)/V('.$Date_pole_emploi.')>>
	<</T(FormAGW1)/V('.$FormAGW1.')>>
	<</T(FormAGW2)/V('.$FormAGW2.')>>
	<</T(FormDW1)/V('.$FormDW1.')>>
	<</T(FormDW2)/V('.$FormDW2.')>>
	<</T(FormBE1)/V('.$FormBE1.')>>
	<</T(FormBE2)/V('.$FormBE2.')>>
	<</T(FormBE3)/V('.$FormBE3.')>>
	<</T(FormDD1)/V('.$FormDD1.')>>
	<</T(FormDD2)/V('.$FormDD2.')>>
	<</T(FormDD3)/V('.$FormDD3.')>>
	<</T(Rhone)/V('.$Rhone.')>>
	<</T(Isere)/V('.$Isere.')>>
	<</T(Ain)/V('.$Ain.')>>
	<</T(Loire)/V('.$Loire.')>>
	<</T(Haute_Loire)/V('.$Haute_Loire.')>>
	<</T(Drome)/V('.$Drome.')>>
	<</T(Autre)/V('.$Autre.')>>
	<</T(Ardeche)/V('.$Ardeche.')>>
	<</T(Savoie)/V('.$Savoie.')>>
	<</T(RQTH_Oui_2)/V('.$RQTH_Oui_2.')>>
	<</T(RQTH_Non_2)/V('.$RQTH_Non_2.')>>
	<</T(RQTH_Oui_3)/V('.$RQTH_Oui_3.')>>
	<</T(RQTH_Non_3)/V('.$RQTH_Non_3.')>>
	<</T(RQTH_Si_oui_lequel)/V('.$RQTH_Si_oui_lequel.')>>
	<</T(Salarie)/V('.$Salarie.')>>
	<</T(Nom_de_lentreprise_2)/V('.$Nom_de_lentreprise_2.')>>
	<</T(Demandeur_demploi)/V('.$Demandeur_demploi.')>>
	<</T(Stagiaire)/V('.$Stagiaire.')>>
	<</T(Duree)/V('.$Duree.')>>
	<</T(Formation_suivie)/V('.$Formation_suivie.')>>
	<</T(Nature_du_stage)/V('.$Nature_du_stage.')>>
	<</T(Autre_situation)/V('.$Autre_situation.')>>
	<</T(Case_Autre_situation_1)/V('.$Case_Autre_situation_1.')>>
	<</T(En_formation_en_alternance)/V('.$En_formation_en_alternance.')>>
	<</T(Nom_de_l_entreprise_3)/V('.$Nom_de_l_entreprise_3.')>>
	<</T(Duree_2)/V('.$Duree_2.')>>	
	<</T(Type_de_contrat)/V('.$Type_de_contrat.')>>
	<</T(Nature_de_l_emploi)/V('.$Nature_de_l_emploi.')>>
	<</T(A_temps_plein)/V('.$A_temps_plein.')>>
	<</T(A_temps_partiel)/V('.$A_temps_partiel.')>>
	<</T(LV1)/V('.$LV1.')>>
	<</T(LV2)/V('.$LV2.')>>
	<</T(LV1_Tres_bon)/V('.$LV1_Tres_bon.')>>
	<</T(LV1_Bon)/V('.$LV1_Bon.')>>
	<</T(LV1_Moyen)/V('.$LV1_Moyen.')>>
	<</T(LV1_Notions)/V('.$LV1_Notions.')>>
	<</T(LV2_Tres_bon_2)/V('.$LV2_Tres_bon_2.')>>
	<</T(LV2_Bon_2)/V('.$LV2_Bon_2.')>>
	<</T(LV2_Moyen_2)/V('.$LV2_Moyen_2.')>>
	<</T(LV2_Notions_2)/V('.$LV2_Notions_2.')>>
	<</T(Etudes1Row1)/V('.$Etudes1Row1.')>>
	<</T(AnneeRow1)/V('.$AnneeRow1.')>>
	<</T(ResultatRow1)/V('.$ResultatRow1.')>>
	<</T(EtablissementRow1)/V('.$EtablissementRow1.')>>
	<</T(Comment_connu_INSTIC)/V('.$Comment_connu_INSTIC.')>>
	<</T(Deja_CTI_Oui_4)/V('.$Deja_CTI_Oui_4.')>>
	<</T(Deja_CTI_Non_4)/V('.$Deja_CTI_Non_4.')>>
	<</T(Autre_centre_Oui_5)/V('.$Autre_centre_Oui_5.')>>
	<</T(Autre_centre_Non_5)/V('.$Autre_centre_Non_5.')>>
	<</T(Si_oui_lesquels_1)/V('.$Si_oui_lesquels_1.')>>
	<</T(Si_oui_lesquels_2)/V('.$Si_oui_lesquels_2.')>>
	<</T(Si_oui_lesquels_3)/V('.$Si_oui_lesquels_3.')>>
	<</T(Si_oui_lesquels_4)/V('.$Si_oui_lesquels_4.')>>
] >> >>
endobj
trailer
<</Root 1 0 R>>
%%EOF';

file_put_contents('../../documents/INSTIC.fdf', $fdf);
$nomfic=$user."_candidature.pdf";
exec("pdftk ../../documents/INSTIC.pdf fill_form ../../documents/INSTIC.fdf output ../../documents/$nomfic flatten dont_ask");

$errsVCA['RC_OK'][]="Fichier PDF génré!";

//=====================================
//Ouvrir le fichier PDF
$fichier=$nomfic;

headpdf("../../documents/".$nomfic);

//==================================

// On affiche la page (vue)
include_once('../../vue/cpro/instic_validermacandidature.php');