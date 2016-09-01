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
$query = "SELECT clef, champ, valeur, mail, sequence FROM param";
if (isset($_GET['insert']))
	{
	// INSERT COMMAND
	$query = "INSERT INTO param (clef, champ, valeur, mail, sequence) VALUES (?,?,?,?,?)";
	$result = $mysqli->prepare($query);
	$result->bind_param('sssss', $_GET['EmployeeID'], $_GET['FirstName'], $_GET['LastName'], $_GET['Title'], $_GET['Address']);
	$res = $result->execute() or trigger_error($result->error, E_USER_ERROR);
	// printf ("New Record has id %d.\n", $mysqli->insert_id);
	echo $res;
	}
  else if (isset($_GET['update']))
	{
	// UPDATE COMMAND
	$query = "UPDATE param SET valeur=?, mail=?, sequence=? WHERE clef=?";
	$result = $mysqli->prepare($query);
	$result->bind_param('sssi', $_GET['FirstName'], $_GET['LastName'], $_GET['Title'], $_GET['Address'], $_GET['EmployeeID']);
	$res = $result->execute() or trigger_error($result->error, E_USER_ERROR);
	// printf ("Updated Record has id %d.\n", $_GET['EmployeeID']);
	echo $res;
	}
  else if (isset($_GET['delete']))
	{
	// DELETE COMMAND
	$query = "DELETE FROM employees WHERE clef=?";			  
	$result = $mysqli->prepare($query);
	$result->bind_param('i', $_GET['EmployeeID']);
	$res = $result->execute() or trigger_error($result->error, E_USER_ERROR);
	// printf ("Deleted Record has id %d.\n", $_GET['EmployeeID']);
	echo $res;
	}
  else
	{
	// SELECT COMMAND
	$result = $mysqli->prepare($query);
	$result->execute();
	/* bind result variables */
	$result->bind_result($EmployeeID, $FirstName, $LastName, $Title, $Address);
	/* fetch values */
	while ($result->fetch())
		{
		$employees[] = array(
			'EmployeeID' => $EmployeeID,
			'FirstName' => $FirstName,
			'LastName' => $LastName,
			'Title' => $Title,
			'Address' => $Address			
		);
		}
	echo json_encode($employees);
	}
$result->close();
$mysqli->close();
/* close connection */
?>