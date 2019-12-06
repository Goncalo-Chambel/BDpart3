<html>
	<body>
	<h3>All (previous?) appointments for client <?=$_REQUEST['date']?></h3>

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
			
			$VAT_d = $_REQUEST['doctor'];
			$date = $_REQUEST['date'];

			
			$sql = "SELECT * FROM consultation WHERE VAT_doctor = '$VAT_d' AND date_timestamp = '$date'";
			$result = $connection->query($sql);
			if ($result == FALSE)
			{
				$info = $connection->errorInfo();
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}
			$nrows = $result->rowCount();
			if ($nrows == 0)
			{
			echo("<p>This appointment still has no consultation associated.</p>");
			}
			$columns = array('VAT_doctor','date_timestamp','SOAP_S','SOAP_O','SOAP_A','SOAP_P');

			
			echo("<table border=\"1\">");
			
			echo("<tr>");
			foreach($columns as $c){
				echo("<td>{$c}</td>");
				}
			echo("</tr>");
			

			foreach($result as $row)
			{
				echo("<tr>");
				foreach($columns as $c){
					echo("<td>{$row[$c]}</td>");
				}
				echo("</tr>");
			}

			echo("</table>");
			
			

			
			
			$connection = null;
		?>
	</body>
</html>
