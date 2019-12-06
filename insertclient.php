

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
$VAT = $_REQUEST['VAT'];
$name = $_REQUEST['name'];
$street = $_REQUEST['street'];
$city = $_REQUEST['city'];
$zip = $_REQUEST['zip'];
$gender = $_REQUEST['gender'];

$birth_date = $_REQUEST['birth_date'];
$birth_date = strtotime($birth_date);
$birth_date = date("Y-m-d", $birth_date);


$sql = "INSERT INTO client VALUES ('$VAT', '$name', '$birth_date', '$street', '$city', '$zip', '$gender', 0)";
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
