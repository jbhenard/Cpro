<?php

//Copie fichier html mailxx en mail12a et MàJ les variables éventuelles
//=======================================================================================
//Mail x (concerne tous les mails)
//=======================================================================================
function majhmtl_Mail($nomficmodele){
	global $varnomprenom; //Variable html du mail [NOMPrenom] qui sera remplacée par sa valeur $id
	global $varidentifiant;
	global $varmdp;
	global $user;
	global $id; //valeur Nom + Prénom, exemple: "Hénard Jean-Baptiste christ" qui va remplacé variable html [NOMPrenom]
	global $idmail; //Valeur mail12, mail1, ...
	
	$newfile="../../vue/cpro/mail12a.html";

	//Détruire le brouillon si il existe
	if (file_exists($newfile)) { unlink ($newfile); }

	if (!copy($nomficmodele, $newfile)) { return("La copie $nomficmodele du fichier a échoué..."); }

	//Ouverture du fichier en lecture seul
	$fichier_a_ouvrir = fopen($newfile, "r");
		
	$contenu_du_fichier='';
	$contenu_du_fichier0='';
	$contenu_du_fichier1='';
	$contenu_du_fichierfinal='';

	// On boucle et tant que l'on n'est pas la fin du fichier ,on continue de le lire. 
	while(!feof($fichier_a_ouvrir))	{
		$contenu_du_fichier = fgets($fichier_a_ouvrir, 1024);

		//Màj des variables du fichier html	
		
		//MàJ de [NOMPrenom]
		//MàJ de [IDENTIFIANT]		
		//$contenu_du_fichier0=str_replace("[NOMPrenom]",'H&eacute;nard Jean-Baptiste christ',$contenu_du_fichier);
		$contenu_du_fichier0=str_replace($varnomprenom, utf8_decode($id), $contenu_du_fichier);		
				
		if(strlen($contenu_du_fichier0) > 0 ) {	$contenu_du_fichierfinal.= $contenu_du_fichier0; }
		else{ $contenu_du_fichierfinal.= $contenu_du_fichier; }	
		
	} //Fin du while
	
	//Fermeture du fichier
	fclose ($fichier_a_ouvrir);
	
	//MàJ du fichier html
	$filename = $newfile;
	 
	if (is_writable($filename)) { // Le fichier est il inscriptible
	 
		if (!$handle = fopen($filename, 'w+')) { // Je vous conseil de lire la fonction fopen($filename, 'a')
			return("Impossible d'ouvrir le fichier ($filename)"); }
	 
		if (fwrite($handle, $contenu_du_fichierfinal) === FALSE) { // On écrit dans le fichier en testant les droits
			return("Le fichier $filename n'est pas inscriptible"); }
	 
		$coderetour= "L'écriture dans le fichier ($filename) a réussi";
		fclose($handle); // on ferme le fichier aprés avoir écrit dedans
	 	return($coderetour);
	} else { return("Le fichier $filename n'est pas accessible en écriture."); }
} //Fin fonction

//=======================================================================================
//Mail 1
//=======================================================================================
function majhmtl_Mail1a($nomficmodele){
	global $varnomprenom; //Variable html du mail [NOMPrenom] qui sera remplacée par sa valeur $id
	global $varidentifiant;
	global $varmdp;
	global $user;
	global $id; //valeur Nom + Prénom, exemple: "Hénard Jean-Baptiste christ" qui va remplacé variable html [NOMPrenom]
	global $idmail; //Valeur mail12, mail1, ...
	
	$newfile="../../vue/cpro/mail12b.html";

	//Détruire le brouillon si il existe
	if (file_exists($newfile)) { unlink ($newfile); }

	if (!copy($nomficmodele, $newfile)) { return("La copie $nomficmodele du fichier a échoué..."); }

	//Ouverture du fichier en lecture seul
	$fichier_a_ouvrir = fopen($newfile, "r");
		
	$contenu_du_fichier='';
	$contenu_du_fichier0='';
	$contenu_du_fichier1='';
	$contenu_du_fichierfinal='';

	// On boucle et tant que l'on n'est pas la fin du fichier ,on continue de le lire. 
	while(!feof($fichier_a_ouvrir))	{
		$contenu_du_fichier = fgets($fichier_a_ouvrir, 1024);

		//Màj des variables du fichier html	
		
		//MàJ de [NOMPrenom]
		//MàJ de [IDENTIFIANT]		
		//$contenu_du_fichier0=str_replace("[NOMPrenom]",'H&eacute;nard Jean-Baptiste christ',$contenu_du_fichier);		
		$contenu_du_fichier0=str_replace($varidentifiant, utf8_decode($user), $contenu_du_fichier); 
				
		if(strlen($contenu_du_fichier0) > 0 ) {	$contenu_du_fichierfinal.= $contenu_du_fichier0; }
		else{ $contenu_du_fichierfinal.= $contenu_du_fichier; }	
		
	} //Fin du while
	
	//Fermeture du fichier
	fclose ($fichier_a_ouvrir);
	
	//MàJ du fichier html
	$filename = $newfile;
	 
	if (is_writable($filename)) { // Le fichier est il inscriptible
	 
		if (!$handle = fopen($filename, 'w+')) { // Je vous conseil de lire la fonction fopen($filename, 'a')
			return("Impossible d'ouvrir le fichier ($filename)"); }
	 
		if (fwrite($handle, $contenu_du_fichierfinal) === FALSE) { // On écrit dans le fichier en testant les droits
			return("Le fichier $filename n'est pas inscriptible"); }
	 
		$coderetour= "L'écriture dans le fichier ($filename) a réussi";
		fclose($handle); // on ferme le fichier aprés avoir écrit dedans
	 	return($coderetour);
	} else { return("Le fichier $filename n'est pas accessible en écriture."); }
} //Fin fonction

//Copie fichier html mailxx en mail12a et MàJ les variables éventuelles
function majhmtl_Mail1b($nomficmodele){
	global $varnomprenom; //Variable html du mail [NOMPrenom] qui sera remplacée par sa valeur $id
	global $varidentifiant;
	global $varmdp;
	global $user;
	global $mdp;
	global $id; //valeur Nom + Prénom, exemple: "Hénard Jean-Baptiste christ" qui va remplacé variable html [NOMPrenom]
	global $idmail; //Valeur mail12, mail1, ...
	
	$newfile="../../vue/cpro/mail12c.html";

	//Détruire le brouillon si il existe
	if (file_exists($newfile)) { unlink ($newfile); }

	if (!copy($nomficmodele, $newfile)) { return("La copie $nomficmodele du fichier a échoué..."); }

	//Ouverture du fichier en lecture seul
	$fichier_a_ouvrir = fopen($newfile, "r");
		
	$contenu_du_fichier='';
	$contenu_du_fichier0='';
	$contenu_du_fichier1='';
	$contenu_du_fichierfinal='';

	// On boucle et tant que l'on n'est pas la fin du fichier ,on continue de le lire. 
	while(!feof($fichier_a_ouvrir))	{
		$contenu_du_fichier = fgets($fichier_a_ouvrir, 1024);

		//Màj des variables du fichier html	
		
		//MàJ de [NOMPrenom]
		//MàJ de [IDENTIFIANT]		
		//màJ de [MDP]
		//$contenu_du_fichier0=str_replace("[NOMPrenom]",'H&eacute;nard Jean-Baptiste christ',$contenu_du_fichier);		
		$contenu_du_fichier0=str_replace($varmdp, utf8_decode($mdp), $contenu_du_fichier); 
				
		if(strlen($contenu_du_fichier0) > 0 ) {	$contenu_du_fichierfinal.= $contenu_du_fichier0; }
		else{ $contenu_du_fichierfinal.= $contenu_du_fichier; }	
		
	} //Fin du while
	
	//Fermeture du fichier
	fclose ($fichier_a_ouvrir);
	
	//MàJ du fichier html
	$filename = $newfile;
	 
	if (is_writable($filename)) { // Le fichier est il inscriptible
	 
		if (!$handle = fopen($filename, 'w+')) { // Je vous conseil de lire la fonction fopen($filename, 'a')
			return("Impossible d'ouvrir le fichier ($filename)"); }
	 
		if (fwrite($handle, $contenu_du_fichierfinal) === FALSE) { // On écrit dans le fichier en testant les droits
			return("Le fichier $filename n'est pas inscriptible"); }
	 
		$coderetour= "L'écriture dans le fichier ($filename) a réussi";
		fclose($handle); // on ferme le fichier aprés avoir écrit dedans
	 	return($coderetour);
	} else { return("Le fichier $filename n'est pas accessible en écriture."); }
} //Fin fonction


//=======================================================================================
//Mail 5
//=======================================================================================
//Copie fichier html mailxx en mail12a et MàJ les variables éventuelles
function majhmtl_Mail5a($nomficmodele){
	global $varnomprenom; //Variable html du mail [NOMPrenom] qui sera remplacée par sa valeur $id
	global $varformation1;
	global $varformation2;
	global $user;
	global $id; //valeur Nom + Prénom, exemple: "Hénard Jean-Baptiste christ" qui va remplacé variable html [NOMPrenom]
	global $idmail; //Valeur mail12, mail1, ...
	global $formation1;
	
	$newfile="../../vue/cpro/mail12b.html";

	//Détruire le brouillon si il existe
	if (file_exists($newfile)) { unlink ($newfile); }

	if (!copy($nomficmodele, $newfile)) { return("La copie $nomficmodele du fichier a échoué..."); }

	//Ouverture du fichier en lecture seul
	$fichier_a_ouvrir = fopen($newfile, "r");
		
	$contenu_du_fichier='';
	$contenu_du_fichier0='';
	$contenu_du_fichier1='';
	$contenu_du_fichierfinal='';

	// On boucle et tant que l'on n'est pas la fin du fichier ,on continue de le lire. 
	while(!feof($fichier_a_ouvrir))	{
		$contenu_du_fichier = fgets($fichier_a_ouvrir, 1024);

		//Màj des variables du fichier html	
		
		//MàJ de [NOMPrenom]
		//MàJ de [IDENTIFIANT]		
		//$contenu_du_fichier0=str_replace("[NOMPrenom]",'H&eacute;nard Jean-Baptiste christ',$contenu_du_fichier);		
		$contenu_du_fichier0=str_replace($varformation1, utf8_decode($formation1), $contenu_du_fichier); 
				
		if(strlen($contenu_du_fichier0) > 0 ) {	$contenu_du_fichierfinal.= $contenu_du_fichier0; }
		else{ $contenu_du_fichierfinal.= $contenu_du_fichier; }	
		
	} //Fin du while
	
	//Fermeture du fichier
	fclose ($fichier_a_ouvrir);
	
	//MàJ du fichier html
	$filename = $newfile;
	 
	if (is_writable($filename)) { // Le fichier est il inscriptible
	 
		if (!$handle = fopen($filename, 'w+')) { // Je vous conseil de lire la fonction fopen($filename, 'a')
			return("Impossible d'ouvrir le fichier ($filename)"); }
	 
		if (fwrite($handle, $contenu_du_fichierfinal) === FALSE) { // On écrit dans le fichier en testant les droits
			return("Le fichier $filename n'est pas inscriptible"); }
	 
		$coderetour= "L'écriture dans le fichier ($filename) a réussi";
		fclose($handle); // on ferme le fichier aprés avoir écrit dedans
	 	return($coderetour);
	} else { return("Le fichier $filename n'est pas accessible en écriture."); }
} //Fin fonction

//Copie fichier html mailxx en mail12a et MàJ les variables éventuelles
function majhmtl_Mail9b2($nomficmodele){
	global $varnomprenom; //Variable html du mail [NOMPrenom] qui sera remplacée par sa valeur $id
	global $varformation1;
	global $varformation2;
	global $vardateentretien;
	global $user;
	global $mdp;
	global $id; //valeur Nom + Prénom, exemple: "Hénard Jean-Baptiste christ" qui va remplacé variable html [NOMPrenom]
	global $idmail; //Valeur mail12, mail1, ...
	global $formation2;
	global $dateentretien;
	
	//echo('Dt entretien dans Fonctions:').$dateentretien;
    //die();
	
	$newfile="../../vue/cpro/mail12c2.html";

	//Détruire le brouillon si il existe
	if (file_exists($newfile)) { unlink ($newfile); }

	if (!copy($nomficmodele, $newfile)) { return("La copie $nomficmodele du fichier a échoué..."); }

	//Ouverture du fichier en lecture seul
	$fichier_a_ouvrir = fopen($newfile, "r");
		
	$contenu_du_fichier='';
	$contenu_du_fichier0='';
	$contenu_du_fichier1='';
	$contenu_du_fichierfinal='';

	// On boucle et tant que l'on n'est pas la fin du fichier ,on continue de le lire. 
	while(!feof($fichier_a_ouvrir))	{
		$contenu_du_fichier = fgets($fichier_a_ouvrir, 1024);

		//Màj des variables du fichier html	
				
		//$contenu_du_fichier0=str_replace("[NOMPrenom]",'H&eacute;nard Jean-Baptiste christ',$contenu_du_fichier);		
		$contenu_du_fichier0=str_replace($vardateentretien, utf8_decode($dateentretien), $contenu_du_fichier); 
				
		if(strlen($contenu_du_fichier0) > 0 ) {	$contenu_du_fichierfinal.= $contenu_du_fichier0; }
		else{ $contenu_du_fichierfinal.= $contenu_du_fichier; }	
		
	} //Fin du while
	
	//Fermeture du fichier
	fclose ($fichier_a_ouvrir);
	
	//MàJ du fichier html
	$filename = $newfile;
	 
	if (is_writable($filename)) { // Le fichier est il inscriptible
	 
		if (!$handle = fopen($filename, 'w+')) { // Je vous conseil de lire la fonction fopen($filename, 'a')
			return("Impossible d'ouvrir le fichier ($filename)"); }
	 
		if (fwrite($handle, $contenu_du_fichierfinal) === FALSE) { // On écrit dans le fichier en testant les droits
			return("Le fichier $filename n'est pas inscriptible"); }
	 
		$coderetour= "L'écriture dans le fichier ($filename) a réussi";
		fclose($handle); // on ferme le fichier aprés avoir écrit dedans
	 	return($coderetour);
	} else { return("Le fichier $filename n'est pas accessible en écriture."); }
} //Fin fonction
//=======================================================================================


//Copie fichier html mailxx en mail12a et MàJ les variables éventuelles
function majhmtl_Mail5b($nomficmodele){
	global $varnomprenom; //Variable html du mail [NOMPrenom] qui sera remplacée par sa valeur $id
	global $varformation1;
	global $varformation2;
	global $user;
	global $mdp;
	global $id; //valeur Nom + Prénom, exemple: "Hénard Jean-Baptiste christ" qui va remplacé variable html [NOMPrenom]
	global $idmail; //Valeur mail12, mail1, ...
	global $formation2;
	
	$newfile="../../vue/cpro/mail12c.html";

	//Détruire le brouillon si il existe
	if (file_exists($newfile)) { unlink ($newfile); }

	if (!copy($nomficmodele, $newfile)) { return("La copie $nomficmodele du fichier a échoué..."); }

	//Ouverture du fichier en lecture seul
	$fichier_a_ouvrir = fopen($newfile, "r");
		
	$contenu_du_fichier='';
	$contenu_du_fichier0='';
	$contenu_du_fichier1='';
	$contenu_du_fichierfinal='';

	// On boucle et tant que l'on n'est pas la fin du fichier ,on continue de le lire. 
	while(!feof($fichier_a_ouvrir))	{
		$contenu_du_fichier = fgets($fichier_a_ouvrir, 1024);

		//Màj des variables du fichier html	
		
		//MàJ de [NOMPrenom]
		//MàJ de [IDENTIFIANT]		
		//màJ de [MDP]
		//$contenu_du_fichier0=str_replace("[NOMPrenom]",'H&eacute;nard Jean-Baptiste christ',$contenu_du_fichier);		
		$contenu_du_fichier0=str_replace($varformation2, utf8_decode($formation2), $contenu_du_fichier); 
				
		if(strlen($contenu_du_fichier0) > 0 ) {	$contenu_du_fichierfinal.= $contenu_du_fichier0; }
		else{ $contenu_du_fichierfinal.= $contenu_du_fichier; }	
		
	} //Fin du while
	
	//Fermeture du fichier
	fclose ($fichier_a_ouvrir);
	
	//MàJ du fichier html
	$filename = $newfile;
	 
	if (is_writable($filename)) { // Le fichier est il inscriptible
	 
		if (!$handle = fopen($filename, 'w+')) { // Je vous conseil de lire la fonction fopen($filename, 'a')
			return("Impossible d'ouvrir le fichier ($filename)"); }
	 
		if (fwrite($handle, $contenu_du_fichierfinal) === FALSE) { // On écrit dans le fichier en testant les droits
			return("Le fichier $filename n'est pas inscriptible"); }
	 
		$coderetour= "L'écriture dans le fichier ($filename) a réussi";
		fclose($handle); // on ferme le fichier aprés avoir écrit dedans
	 	return($coderetour);
	} else { return("Le fichier $filename n'est pas accessible en écriture."); }
} //Fin fonction
//=======================================================================================


// header
function headpdf($rep)
{
    header('filename=' . $rep);
    header("Content-Disposition:attachment;filename=".basename($rep));
    header("Content-type:application/pdf");
    header("Content-Transfer-Encoding:binary");
    header("Content-Length:".filesize($rep));
    readfile($rep);
}

//Contrôles fichier à uploader
function upload($index, $nom, $maxsize=FALSE, $extensions=FALSE){
    //Test1: fichier correctement uploadé
    if(!isset($_FILES[$index]) OR $_FILES[$index]['error'] >0) return FALSE;

    //Test2: taille limite
    if($maxsize !== FALSE AND $_FILES[$index]['size'] > $maxsize) return FALSE;

    //Test3: extension
    $ext = substr(strrchr($_FILES[$index]['name'], '.'), 1);
    if ($extensions !== FALSE AND !in_array($ext, $extensions)) return FALSE;

    //Déplacement
    return move_uploaded_file($_FILES[$index]['tmp_name'], $nom);
}


//Pour remplacer les caractères spéciaux ci-dessous
function strtoupperFr($string)
{
    $string = strtoupper($string);
    $string = str_replace(
        array('ç', 'é', 'è', 'ê', 'ë', 'à', 'â', 'î', 'ï', 'ô', 'ù', 'û'),
        array('C','E', 'E', 'E', 'E', 'A', 'A', 'I', 'I', 'O', 'U', 'U'),
        $string);

    return $string;
}

//Pour créer les champs avec séparateur ';'
function echocsv($fields)
{
    $separator = '';
    foreach ($fields as $field) {
        if (preg_match('/\\r|\\n|,|"/', $field)) {
            $field = '"' . str_replace('"', '""', $field) . '"';
        }
        echo $separator . utf8_decode($field);
        $separator = ';';
    }
    echo "\r\n";
}