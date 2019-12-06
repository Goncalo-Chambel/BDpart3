<html>
 <body>
 <form action="insertapp.php" method="post">
 <h3>Available doctors for the desired date/time</h3>
 <p>Doctor:
 <select name="VAT">
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
$VAT_client = $_REQUEST['VAT_client'];
$description = $_REQUEST['description'];

$date_timestamp = date("Y-m-d H:i:s", strtotime($date_timestamp));


$sql = "SELECT employee.VAT, name FROM employee, doctor WHERE (employee.VAT = doctor.VAT) AND doctor.VAT NOT IN (SELECT VAT_doctor FROM appointment WHERE DATE(date_timestamp) = DATE('$date_timestamp') AND HOUR(date_timestamp) = HOUR('$date_timestamp'))";

$result = $connection->query($sql);
if ($result == FALSE)
{
$info = $connection->errorInfo();
echo("<p>Error: {$info[2]}</p>");
exit();
}

foreach($result as $row)
{
$VAT_doctor= $row['VAT'];
$name = $row['name'];
echo("<option value=\"$VAT_doctor \">$name</option>");

}

$connection = null;
?>
 </select>
 </p>

 <input type="hidden" name="date_timestamp" value="<?=$_REQUEST['date_timestamp']?>">
 <input type="hidden" name="VAT_client" value="<?=$_REQUEST['VAT_client']?>">
 <input type="hidden" name="description" value="<?=$_REQUEST['description']?>">
 <p><input type="submit" value="Submit"/></p>
 </form>

</body>
</html>