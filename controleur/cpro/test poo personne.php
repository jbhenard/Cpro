<?php
include_once('../../modele/cpro/Personne.class.php');
include_once('../../modele/cpro/PersonneManager.class.php');

//Il n'est pas obligatoire de renseigner les attributs de type date (gérés au moment de l'insert').
$données=[
  'Id' => 'Hénard Jean-baptiste',
  'Titre' => 'Monsieur',
  'Nom' => 'Hénard',
  'Prenom' => 'Jean-Baptiste',
  'User' => 'jbhenard@free.fr',
  'Mdp' => 'jbh',  
  'Profil' => 'Candidat'
];

$personne = new Personne($données);
//$perso->hydrate($données);

$db = new PDO('mysql:host=localhost;dbname=instic', 'root', '');
$manager = new PersonneManager($db);
    
$rc=$manager->add($personne);
echo "code retour= ".$rc;
?>