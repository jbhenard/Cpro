<?php

$newfile="../Racine_Site/vue/cpro/mail12a.html";

//D�truire le brouillon si il existe
if (file_exists($newfile)) { unlink ($newfile); }

//Ouverture du fichier en lecture seul
$nomficmodele="../Racine_Site/vue/cpro/mail12.html";
//$newfile="../Racine_Site/vue/cpro/mail12a.html";

if (!copy($nomficmodele, $newfile)) {
    echo "La copie $nomficmodele du fichier a �chou�...\n";
}

$fichier_a_ouvrir = fopen($newfile, "r");
// On boucle et tant que l'on n'est pas la fin du fichier ,on continue de le lire. 
$contenu_du_fichier='';
$contenu_du_fichier0='';
$contenu_du_fichierfinal='';

while(!feof($fichier_a_ouvrir))	{
	$contenu_du_fichier = fgets($fichier_a_ouvrir, 1024);
	//Affichage du contenu

	//M�j des variables	
	$contenu_du_fichier0=str_replace("[NOMPrenom]",'H&eacute;nard Jean-Baptiste christ',$contenu_du_fichier);
	//echo strlen($contenu_du_fichier0)."<br/>";
	if(strlen($contenu_du_fichier0) > 0 ) {
		echo $contenu_du_fichier0;
		$contenu_du_fichierfinal.= $contenu_du_fichier0;
	}else{
		 echo ($contenu_du_fichier);
		$contenu_du_fichierfinal.= $contenu_du_fichier;
	}
}
//Fermeture du fichier
fclose ($fichier_a_ouvrir);

echo("<br/>=====================================================<br/>");
echo $contenu_du_fichierfinal;

//M�J du fichier html
//$filename = "../Racine_Site/vue/cpro/mail12.html";
$filename = $newfile;
 
if (is_writable($filename)) { // Le fichier est il inscriptible
 
	if (!$handle = fopen($filename, 'w+')) { // Je vous conseil de lire la fonction fopen($filename, 'a')
		echo "Impossible d'ouvrir le fichier ($filename)";
		exit;
	}
 
	if (fwrite($handle, $contenu_du_fichierfinal) === FALSE) { // On �crit dans le fichier en testant les droits
		echo "Le fichier $filename n'est pas inscriptible";
		exit;
	}
 
	echo utf8_decode("L'�criture dans le fichier ($filename) a r�ussi");
	fclose($handle); // on ferme le fichier apr�s avoir �crit dedans
 
} else {echo utf8_decode("Le fichier $filename n'est pas accessible en �criture.");}
 			
			
 //lien site: http://www.developpez.net/forums/d1254314/php/scripts/editeurs/editer-fichier-html-php-ligne/
			