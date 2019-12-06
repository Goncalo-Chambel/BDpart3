<html>
	<body>
	<h3>All previous appointments for client <?=$_REQUEST['client']?></h3>

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
			
			$VAT_c = $_REQUEST['client'];

			
			$sql = "SELECT * FROM appointment WHERE VAT_client = '$VAT_c'";
			$result = $connection->query($sql);
			if ($result == FALSE)
			{
				$info = $connection->errorInfo();
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}
			
			echo("<table border=\"1\">");
			echo("<tr><td>VAT_doctor</td><td>VAT_client</td><td>Date</td></tr>");
			foreach($result as $row)
			{
				echo("<tr><td>");
				echo($row['VAT_doctor']);
				echo("</td><td>");
				echo($row['VAT_client']);
				echo("</td><td>");
				echo($row['date_timestamp']);
				echo("<td><a href=\"consult.php?doctor=");
				echo($row['VAT_doctor']);
				echo("&date=");
				echo($row['date_timestamp']);
				echo("\">Check info</a></td>\n");
				echo("</td></tr>");
			}
			echo("</table>");
			$connection = null;
		?>
	</body>
</html>
