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
$VAT_client = $_REQUEST['VAT_client'];
$VAT_doctor = $_REQUEST['VAT'];
$date_timestamp = $_REQUEST['date_timestamp'];
$description = $_REQUEST['description'];

$sql = $connection->prepare("INSERT INTO appointment VALUES (:VAT_doctor, :date_timestamp, :description, :VAT_client)");

if($sql == FALSE){
	$info = $connection->errorInfo();				
	echo("<p>Error: {$info[2]}</p>");
	exit();
}

$test = $sql->execute(array(
	":VAT_doctor" => $VAT_doctor,
	":date_timestamp" => $date_timestamp,
	":description" => $description,
	":VAT_client" => $VAT_client));

if ($test == FALSE)
{
	$info = $connection->errorInfo();
	echo("<h3>Appointment is already in the Database</h3>");	
	echo("<p></p>");					
	echo("<p>Error: {$info[2]}</p>");
	exit();
}else{
	echo("<p>An appointment was succesfully inserted</p>");
}

 $connection = null;
?>

<form action = "searchclient.php">
  <input type="submit" value="Go to search client page">
</form>

 </body>
</html>
