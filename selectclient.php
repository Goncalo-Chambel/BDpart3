<html>
	<body>
		<h3>Client's List</h3>
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
			
			$name = $_REQUEST['name'];
			$VAT = $_REQUEST['VAT'];
			$street = $_REQUEST['street'];
			$city = $_REQUEST['city'];
			$zip = $_REQUEST['zip'];
			
			$sql = "SELECT * FROM client WHERE (name like'%$name%' AND '$name' != '') OR (VAT='$VAT' AND '$VAT' != '')  OR (street like'%$street%' AND '$street' != '') OR (city like'%$city%' AND '$city' != '') OR (zip like '%$zip%' AND '$zip' != '')";
			$result = $connection->query($sql);
			$nrows = $result->rowCount();
			if ($result == FALSE)
			{
				$info = $connection->errorInfo();
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}
			
			echo("<p>$nrows results</p>");
			
			echo("<table border=\"1\" cellspacing=\"5\">\n");
			
			echo("<tr>\n");
			echo("<td><a href=\"newclient.php?");
			echo("\">Add Client</a></td>\n");
			echo("</tr>\n");
			
			echo("</table>\n");
			
			
			echo("<table border=\"1\" cellspacing=\"5\">\n");
			
			foreach($result as $row)
			{
				echo("<tr>\n");
				echo("<td>{$row['name']}</td>\n");
				echo("<td>{$row['VAT']}</td>\n");
				echo("<td><a href=\"newappointment.php?VAT=");
				echo($row['VAT']);
				echo("\">Add appointment</a></td>\n");
				echo("<td><a href=\"prev_appoints.php?client=");
				echo($row['VAT']);
				echo("\">Check previous appointments</a></td>\n");
				echo("</tr>\n");
			}
			echo("</table>\n");
			
			
			$connection = null;
		?>
	</body>
</html>