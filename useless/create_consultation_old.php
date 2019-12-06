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
			$VAT_d = $_REQUEST['VAT_d'];
			$date = $_REQUEST['date'];	
			
			
			echo("
			<form action=\"insert_consult.php\" method=\"post\">
			<h4>Insert info about new consultation</h4>
			<p>SOAP_S: <input type=\"text\" name=\"SOAP_S\"/></p>
			<p>SOAP_O: <input type=\"text\" name=\"SOAP_O\"/></p>
			<p>SOAP_A: <input type=\"text\" name=\"SOAP_A\"/></p>
			<p>SOAP_P: <input type=\"text\" name=\"SOAP_P\"/></p>
			<input type=\"hidden\" name=\"VAT_d\" value=\"{$VAT_d}\">
			<input type=\"hidden\" name=\"date\" value=\"{$date}\">
			");
			
			
			echo("<h4>Insert the diagnostics for the new consultation</h4>
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
			echo("<select name=diagnostic >");
			foreach($result_diag as $row)
			{
				$ID = $row["ID"];
				$description = $row["description"];
				echo("<p><option value=\"{$ID}\"/>{$description}</p>");

			}
			echo("</select>");
			
			echo("<p><h4>Select Consultation Assistants:</h4></p>");
			
			$sql_nurse  = "SELECT DISTINCT(VAT) FROM nurse";
			$result_nurse = $connection->query($sql_nurse );
			if ($result_nurse == FALSE)
			{
				$info = $connection->errorInfo();
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}
			foreach($result_nurse as $row)
			{
				$VAT_nurse = $row["VAT_nurse"];
				echo("<p><input type='checkbox' name='VAT_nurse[]' value='$VAT_nurse'/>$VAT_nurse</p>");
			}
			
			echo("<p><h4>Select Medication for each diagnostic:</h4></p>");
			



					
			$sql_meds  = "select lab, name, concat(name,\" - \", lab) as med from medication";
			$result_meds = $connection->query($sql_meds);
			if ($result_meds == FALSE)
			{
				$info = $connection->errorInfo();
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}
			
			foreach($result_meds as $row)
			{
				$med = $row["med"];
				$lab= $row["lab"];
				$name= $row["name"];
				echo("<p><input type='checkbox' name=\"meds[]\" value='{$med}'/>{$med}</p>");
				
			}
			
					
				
				
				
				
				echo("<p><input type=\"submit\" value=\"Submit\"/></p>");
			
				
			?>
		</body>
	</html>	