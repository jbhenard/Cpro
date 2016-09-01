  <?php
$cpt=1;
$choix='choix'.$cpt;
//echo "nb select personnes: " + count($allpersonnes);

function afficheliste(){
global $choix, $id , $dte, $dtc;
global $user;
global $personne;
global $formationenvisagees;
global $etatcandidature;
global $cpt;

echo "<tr> <td> <INPUT type='checkbox' name='locationthemes' id='$choix' value='$user'> </td> <td style='color:black;'>".$dtc."</td>"."<td>"." <a href='http://cpro.jbh/controleur/cpro/controleurECIAdmin.php?userAdmin=$user'> ".$id." </a> "."</td>"."<td style='color:black;'>".$formationenvisagees." </td>"."<td style='color:black;'>". $etatcandidature." </td>"."<td style='color:black;'>".$dte." </td>"."</tr>";
$choix ='choix'.++$cpt;
}

if (count($allpersonnes) != 0) {
foreach($allpersonnes as $cle => $personne) {                                        
$user=$personne['user'];
$tbnom=$personne['id'];
$dtc=$personne['datecreation'];
$dte=$personne['dateentretien'];
$id=$personne['id'];           
$email=$personne['user'];
$etatcandidature=$personne['etatcandidature'];
$etatECI=$personne['etatECI'];
$etatFEN=$personne['etatFEN'];
$etatIPE=$personne['etatIPE'];
$etatIPR=$personne['etatIPR'];
$etatDIV=$personne['etatDIV'];
$etatFIC=$personne['etatFIC'];            
$formationenvisagees=$personne['formationenvisagees'];       //l1choix1-l2choix1-l3choix1-alternance- 
//echo "<br/>libellé formation envisagees: " +utf8_decode($formationenvisagees);
$tabchoix=explode("-", $formationenvisagees); // Array de l1choix1-l2choix1-l3choix1-alternance-
$tabchoix2=array();
$nbchoix=substr_count($formationenvisagees,'-');
$formationenvisagees='';
foreach ($tabchoix as $value) {  //pour chaque case du Array: l1choix1-l2choix1-l3choix1-alternance-
$tabchoix2[$value][0]=$value;
//echo "formation= ".$value;
$_SESSION['choix']=$value;
$formations0=get_formationsenvisagees2();
foreach($formations0 as $cle => $champs) { //Pour chaque champ l1choix1 (exemple) on récupère le libellé
    $formationenvisagees.=$champs['identifiant']."-";        
} //Fin foreach2
} //Fin foreach1

//echo "<br/>libellé formation envisagees après: " + json_decode($formationenvisagees);
//via un switch
switch ($typefiltre) {
case 'likenom':
    //echo "nom= ".$tbnom;
    //echo "critere= ".$likenomjstophp;
    if (strstr($tbnom,$likenomjstophp)) {
        afficheliste();
    }else{
    
    }     
    break;

case 'dtc':
    if ($dtc == $dtcjstophp) {
    afficheliste();
    }else{
        
    }  
    break;

case 'nom':
    if ($user == $varjstophp) {
        afficheliste();
    }else{
        
    }     
    break;

case 'formation':
//echo "<br />***************************************************<br />";
//echo $formationjstophp;
//echo "<br />***************************************************<br />";
//echo $formationenvisagees;
if (strstr($formationenvisagees,$formationjstophp)) {
    afficheliste();
}else{
    
}     
break;

case 'etat':
if ($etatcandidature == $etatjstophp) {
    afficheliste();
}else{
    
}     
break;

case 'dte':
if ($dte == $dtejstophp) {
    afficheliste();
}else{
    
}  
break;

case 'tridtc':
case 'trinom':
case 'trife':
case 'tristatut':
case 'tridte':
    afficheliste();
    break;

case 'tous':
    afficheliste();
    break;

default:
   afficheliste();
    break;
} // Fin Switch                                  
} //Fin Foreach      
} //Fin if count($allpersonnes)