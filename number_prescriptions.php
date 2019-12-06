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
			$VAT_d = $_REQUEST['VAT_d'];
			$date = $_REQUEST['date'];
			
			echo("<form action=\"create_consultation.php\" method=\"post\">
			<h5>Insert the diagnostics for the new consultation</h5>
			<input type=\"hidden\" name=\"VAT_d\" value=\"{$VAT_d}\">
			<input type=\"hidden\" name=\"date\" value=\"{$date}\">");
			$sql_diag  = "SELECT * FROM diagnostic_code";
			$result_diag = $connection->query($sql_diag );
			if ($result_diag == FALSE)
			{
				$info = $connection->errorInfo();
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}
			foreach($result_diag as $row)
			{
				$ID = $row["ID"];
				$description = $row["description"];
				echo("<p><input type=\"checkbox\" name=\"diagnostic_code[]\" value=\"{$ID}\"/>{$description}</p>");
				echo("<p><input type=\"hidden\" name=\"diagnostic_desc[]\" value=\"{$description}\"/></p>");

			}
			
			
			echo("<p><input type=\"submit\" value=\"Create New Diagnostic\"/></p>");;
			
			
		?>
	</body>
</html>