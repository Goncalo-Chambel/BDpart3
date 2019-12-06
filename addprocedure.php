<html>
	<body>
<?php
	$host = "db.ist.utl.pt";
	$user = "ist425203";
	$pass = "cfbv3345";
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
	$nrows = 0;
	$sql = "INSERT INTO procedure_in_consultation values('Dental Charting','$VAT_doctor', '$date_timestamp', '')";
	$nrows = $connection->exec($sql);
	if($nrows == 0){
		echo "<p>Can't add procedure</p>";
	}
	else{
		echo("<p>Row added: $sql</p>");
	}
	echo("<p>Rows Added: $nrows</p>");

	$nrows = 0;
	$i = 0;
	for ($x = 0; $x < sizeof($_REQUEST['quadrant']); $x++) {

	 $sql="INSERT INTO procedure_charting VALUES('Dental Charting','$VAT_doctor','$date_timestamp', $quadrant[$x], $number[$x], '', $measure[$x])";
	 
	 $nrows += $connection->exec($sql);
	 if($nrows + $i == $x){
	 	echo("<p>Can't add row $sql</p>");
	 	$i = $i + 1;
	 }
	 else
	 {
	 	echo("<p>Row added: $sql</p>");
	 }
	}
	echo("<p>Rows Added: $nrows</p>");
 	$connection = null;
?>

<form action = "searchclient.php">
  <input type="submit" value="Go to search client page">
</form>
	</body>
</html>