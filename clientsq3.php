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
			$sql = "SELECT * FROM client";
			$result = $connection->query($sql);
			if ($result == FALSE)
			{
				$info = $connection->errorInfo();
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}
			echo("<h3>Clients:</h3>");
			echo("<table border=\"1\">");
			echo("<tr><td>VAT</td><td>Name</td><td>Birth date</td><td>Street</td><td>City</td><td>Zip</td><td>Gender</td></tr>");
			foreach($result as $row)
			{
				echo("<tr><td>");
				echo($row['VAT']);
				echo("</td><td>");
				echo($row['name']);
				echo("</td><td>");
				echo($row['birth_date']);
				echo("</td><td>");
				echo($row['street']);
				echo("</td><td>");
				echo($row['city']);
				echo("</td><td>");
				echo($row['zip']);
				echo("</td><td>");
				echo($row['gender']);
				echo("<td><a href=\"prev_appoints.php?client=");
				echo($row['VAT']);
				echo("\">Check previous appointments</a></td>\n");
				echo("</td></tr>");
			}
			echo("</table>");
			$connection = null;
		?>
	</body>
</html>
