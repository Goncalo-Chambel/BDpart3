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


	$sql =$connection->prepare("INSERT INTO procedure_in_consultation values('Dental Charting',:VAT_doctor, :date_timestamp, '')");

	if($sql == FALSE){
		$info = $connection->errorInfo();				
		echo("<p>Error: {$info[2]}</p>");
		exit();
	}
	$test = $sql->execute(array(
		":VAT_doctor" => $VAT_doctor,
		":date_timestamp" => $date_timestamp));

	echo("<p>Row to be added: $sql</p>");
	if($test == FALSE){
		$info = $connection->errorInfo();
		echo("<h3>This consultation already has one dental charting procedure</h3>");	
		echo("<p></p>");					
		echo("<p>Error: {$info[2]}</p>");
		exit();
	}


	for ($x = 0; $x < sizeof($_REQUEST['quadrant']); $x++) {

	# $sql=connection->prepare("INSERT INTO procedure_charting VALUES('Dental Charting',:VAT_doctor, :date_timestamp, $quadrant[$x], $number[$x], '', $measure[$x])");

	 	 $sql=connection->prepare("INSERT INTO procedure_charting VALUES('Dental Charting',:VAT_doctor, :date_timestamp, :quadrant, :_number, '', :measure)");

		if($sql == FALSE){
			$info = $connection->errorInfo();				
			echo("<p>Error: {$info[2]}</p>");
			exit();
		}

		$test = $sql->execute(array(
			":VAT_doctor" => $VAT_doctor,
			":date_timestamp" => $date_timestamp,
			":quadrant" => $quadrant[$x],
			":_number" => $number[$x],
			":measure" => $measure[$x]));

		echo("<p>Row to be added: $sql</p>");

		if($test == FALSE){
			$info = $connection->errorInfo();
			echo("<h3>This tooth already has a measurement</h3>");	
			echo("<p></p>");					
			echo("<p>Error: {$info[2]}</p>");
			exit();
	}
	 
	}
 	$connection = null;
?>

<form action = "searchclient.php">
  <input type="submit" value="Go to search client page">
</form>
	</body>
</html>