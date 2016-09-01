<?php
#Include the connect.php file
include ('connect.php');
// Connect to the database
$mysqli = new mysqli($hostname, $username, $password, $database);
/* check connection */
if (mysqli_connect_errno())
	{
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
	}
// get data and store in a json array
$from = 0;
$to = 30;
$query = "SELECT id, domaine, formation, choix, identifiant FROM formation LIMIT ?,?";
$result = $mysqli->prepare($query);
$result->bind_param('ii', $from, $to);
$result->execute();
/* bind result variables */
$result->bind_result($id, $domaine, $formation, $choix, $identifiant);
/* fetch values */
while ($result->fetch())
	{
	$customers[] = array(
		'CompanyName' => $id,
		'ContactName' => $domaine,
		'ContactTitle' => $formation,
		'Address' => $choix,
		'City' => $identifiant
	);
	}
echo json_encode($customers);
/* close statement */
$result->close();
/* close connection */
$mysqli->close();
?>