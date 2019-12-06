<html>
	<body>
<?php
	$host = "db.tecnico.ulisboa.pt";
	$user = "ist425352";
	$pass = "juob1180";
	$dsn = "mysql:host=$host;dbname=$user";

	try
	{
		$connection = new PDO($dsn, $user, $pass);
	}
	catch(PDOException $exception)
	{
		echo("<p>Error: ");
		echo($exception->getMessage());
		echo("</p>");
		exit();
	}

	$date_timestamp = $_REQUEST['date_timestamp'];
	$VAT_doctor = $_REQUEST['VAT_doctor'];
	$quadrant = $_REQUEST['quadrant'];
	$number = $_REQUEST['number'];
	$measure = $_REQUEST['measure'];


	$sql_procedure =$connection->prepare("INSERT INTO procedure_in_consultation values(:_text,:VAT_doctor, :date_timestamp, '')");

	if($sql_procedure == FALSE){
		$info = $connection->errorInfo();				
		echo("<p>Error: {$info[2]}</p>");
		exit();
	}
	$test = $sql_procedure->execute(array(
		":_text" => 'Dental Charting',
		":VAT_doctor" => $VAT_doctor,
		":date_timestamp" => $date_timestamp));

	if($test == FALSE){
		$info = $connection->errorInfo();
		echo("<h3>This consultation already has one dental charting procedure</h3>");	
		echo("<p></p>");					
		echo("<p>Error: {$info[2]}</p>");
		exit();
	}
	else
	{
		echo("<p>A Procedure was succesfully inserted</p>");
	}


	for ($x = 0; $x < sizeof($_REQUEST['quadrant']); $x++) {

	 	 $sql_measure=$connection->prepare("INSERT INTO procedure_charting VALUES(:_text,:VAT_doctor, :date_timestamp, :quadrant, :_number, :description, :measure)");

		if($sql_measure == FALSE){
			$info = $connection->errorInfo();				
			echo("<p>Error: {$info[2]}</p>");
			exit();
		}

		$test = $sql_measure->execute(array(
			":_text" => 'Dental Charting',
			":VAT_doctor" => $VAT_doctor,
			":date_timestamp" => $date_timestamp,
			":quadrant" => $quadrant[$x],
			":_number" => $number[$x],
			":description" => '',
			":measure" => $measure[$x]));


		if($test == FALSE){
			$info = $connection->errorInfo();
			echo("<h3>This tooth already has a measurement</h3>");	
			echo("<p></p>");					
			echo("<p>Error: {$info[2]}</p>");
			exit();
		}
		else
		{
			echo("<p>A Measure was succesfully inserted</p>");
		}
	}
	 
	
 	$connection = null;
?>

<form action = "searchclient.php">
  <input type="submit" value="Go to search client page">
</form>
	</body>
</html>