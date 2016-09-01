<?php

include_once '../../controleur/cpro/fonctions.php';


// On demande les informations en table (modèle)
// Connexion à la base
include_once('../../modele/connexion_sql.php');
include_once('../../modele/cpro/get_personne.php');
$reponse=get_allpersonnes2A();

//************************************************
//Début

//echo "<br/>==================Var dump de SESSION============================================";
//var_dump($_SESSION);
// On effectue du traitement sur les données (contrôleur)
$tab=$_SESSION['tab'];
$tab2=explode(",", $tab);

//Fin
//************************************************


/*
 * send response headers to the browser
 * following headers instruct the browser to treat the data as a csv file called CproA.csv
 */
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="CproA.csv"');


/*
 * output header row (if atleast one row exists)
 */
$row = $reponse->fetch();
if ($row) {
    echocsv(array_keys($row));
}

/*
 * output data rows (if atleast one row exists)
 */
while ($row) {
	echo "<br/>==================Echo ============================================";
	echo $row;
	if(strlen($tab2[0]) !=0){
		foreach ($tab2 as $key => $user) {
		    if ($user == $row['user']) echocsv($row);
		} // fin de foreach
	} // fin de if

	$row =  $reponse->fetch();
    //echocsv($row);
    //$row =  $reponse->fetch();
} // Fin while