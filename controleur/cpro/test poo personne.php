<?php
include_once('../../modele/cpro/Personne.class.php');
include_once('../../modele/cpro/PersonneManager.class.php');

//Il n'est pas obligatoire de renseigner les attributs de type date (g�r�s au moment de l'insert').
$donn�es=[
  'Id' => 'H�nard Jean-baptiste',
  'Titre' => 'Monsieur',
  'Nom' => 'H�nard',
  'Prenom' => 'Jean-Baptiste',
  'User' => 'jbhenard@free.fr',
  'Mdp' => 'jbh',  
  'Profil' => 'Candidat'
];

$personne = new Personne($donn�es);
//$perso->hydrate($donn�es);

$db = new PDO('mysql:host=localhost;dbname=instic', 'root', '');
$manager = new PersonneManager($db);
    
$rc=$manager->add($personne);
echo "code retour= ".$rc;
?>