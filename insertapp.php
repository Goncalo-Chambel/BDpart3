<html>
 <body>
<?php
$host = "db.tecnico.ulisboa.pt";
$user = "ist425473";
$pass = "rfwz7043";
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


echo("Date: $date_timestamp");
echo "<br>";
echo("VAT doctor: $VAT_doctor");
echo "<br>";
echo("VAT client: $VAT_client");
echo "<br>";
echo("Description: $description");
echo "<br>";


$sql = "INSERT INTO appointment VALUES ('$VAT_doctor', '$date_timestamp', '$description', '$VAT_client')";
echo("<p>$sql</p>");
$nrows = $connection->exec($sql);
echo("<p>Rows inserted: $nrows</p>");
 $connection = null;
?>

<form action = "searchclient.php">
  <input type="submit" value="Go to search client page">
</form>

 </body>
</html>
