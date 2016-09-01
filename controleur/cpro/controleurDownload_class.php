<?php
	
if (isset($_SESSION['user'])) $user=$_SESSION['user'];
else $user='';

if (isset($_COOKIE['cookieUser'])) $user=$_COOKIE['cookieUser'];
else $user='';

$_SESSION['user']=$user;

	// Put the unique user id in a variable - the script know what record to pull from the database because of this variable, which comes to the script as a GET variable in this case. You could/should use a fancier, securer, less user-editable way of transmitting ids, like using a unique md5 hash for the id... again, this is just a simple example
	$id = $_GET['id'];

//Connexion à la base
include_once '../../modele/connexion_sql.php';
include_once '../../modele/connexion_mysqli.php';
	
//Accès à la class Personne & à la class d'accès au SGBD pour cette class personne, son'PersonneManager'
include_once('../../modele/cpro/Upfile.class.php');
include_once('../../modele/cpro/UpfileManager.class.php');

        //Début mode POO ajout Personne        	            
			$manager = new UpfileManager($bdd);			    
			$fichier =$manager->get($id);
        //Fin mode POO

 	//CV
    if ($fichier->getUpfiletitle() == 'CV'){
        //echo "=======================";
        //echo $user;
        //$chemin="http://cpro.jbh/uploads/$user/cv.pdf";
        $chemin="http://cpro.jbh/".$fichier->getUpfilefinalname();
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
			//headpdf($chemin);			
		//Fin test header()
		    
    } //Fin if CV


    //LDM
    if ($fichier->getUpfiletitle() == 'LDM'){
        //echo "=======================";

        //echo $user;
        //$chemin="http://cpro.jbh/uploads/$user/ldm.pdf";
        $chemin="http://cpro.jbh/".$fichier->getUpfilefinalname();
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
    if ($fichier->getUpfiletitle() == 'RDN'){
        //echo "=======================";
        //echo $user;
        //$chemin="http://cpro.jbh/uploads/$user/rdn.pdf";
        $chemin="http://cpro.jbh/".$fichier->getUpfilefinalname();
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
    if($fichier->getUpfiletitle() == 'DIPLOMES'){
        //echo "=======================";
        //echo $user;
        //$chemin="http://cpro.jbh/uploads/$user/diplomes.pdf";
        $chemin="http://cpro.jbh/".$fichier->getUpfilefinalname();
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
	
	if (strlen($fichier->getUser()) > 0) {
		// Include pdftk-php class
		require('../../modele/cpro/pdftk.class.php');
		//require('../pdftk.class.php');
		
		// Initiate the class
		$pdfmaker = new pdftk_php;
		
		// Define variables for all the data fields in the PDF form. You need to assign a column in the database to each field that you'll be using in the PDF. 
		// Example:
		// $pdf_column = $data['column'];
		
		// You can also format the MySQL data how you want here. One common example is formatting a date saved in the database. For example:
		// $pdf_date = date("l, F j, Y, g:i a", strtotime($data['date']));
	
		$pdf_firstname = $fichier->getId();
		$pdf_lastname = $fichier->getUpfiletitle();
		//echo "<br/>".$pdf_lastname;		
	
		// $fdf_data_strings associates the names of the PDF form fields to the PHP variables you just set above. In order to work correctly the PDF form field name has to be exact. PDFs made in Acrobat generally have simpler names - just the name you assigned to the field. PDFs made in LiveCycle Designer nest their forms in other random page elements, creating a long and hairy field name. You can use pdftk to discover the real names of your PDF form fields: run "pdftk form.pdf dump_data_fields > form-fields.txt" to generate a report.

		// Example of field names from a PDF created in LiveCycle:
		// $fdf_data_strings= array('form1[0].#subform[0].#area[0].LastName[0]' => $pdf_lastname,  'form1[0].#subform[0].#area[0].FirstName[0]' => $pdf_firstname, 'form1[0].#subform[0].#area[0].EMail[0]' => $pdf_email, );
		$fdf_data_strings= array('firstname' => $pdf_firstname,  'lastname' => "C:\\".$pdf_lastname.".pdf");
		
		// See the documentation of pdftk-php.php for more explanation of these other variables.
		
		// Used for radio buttons and check boxes
		// Example: (For check boxes options are Yes and Off)
		// $pdf_checkbox1 = "Yes";
		// $pdf_checkbox2 = "Off";
		// $pdf_checkbox3 = "Yes";
		// $fdf_data_names = array('checkbox1' => $pdf_checkbox1,'checkbox2' => $pdf_checkbox2,'checkbox3' => $pdf_checkbox3,'checkbox4' => $pdf_checkbox4); 
		$fdf_data_names = array(); // Leave empty if there are no radio buttons or check boxes
		
		$fields_hidden = array(); // Used to hide form fields
		
		$fields_readonly = array(); // Used to make fields read only - however, flattening the output with pdftk will in effect make every field read only. If you don't want a flattened pdf and still want some read only fields, use this variable and remove the flatten flag near line 70 in pdftk-php.php
		
		// Take each REQUEST value and clean it up for fdf creation
		foreach( $_REQUEST as $key => $value ) {
		   // Translate tildes back to periods
		   $fdf_data_strings[strtr($key, '~', '.')]= $value;
		}
		
		// Name of file to be downloaded
		$pdf_filename = "Test PDF for $pdf_firstname $pdf_lastname.pdf";
		
		// Name/location of original, empty PDF form
		$pdf_original = "../../pdftk/example/example.pdf";
		
		// Finally make the actual PDF file!
		$pdfmaker->make_pdf($fdf_data_strings, $fdf_data_names, $fields_hidden, $fields_readonly, $pdf_original, $pdf_filename);
		// The end!
	} //Fin if (strlen($fichier->getUser()) > 0)
?> 