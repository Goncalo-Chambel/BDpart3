
<html>
	<body>
	<h3>All previous appointments:</h3>

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
			
			#Get the information about the appointment
			echo("<h4>Appointment Info</h4>");
			
			$sql = "SELECT *  FROM appointment
					WHERE VAT_doctor = '$VAT_d' AND date_timestamp = '$date'";
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
			echo("<p>There is no information about this appointment</p>");
			}

			$columns = array('VAT_doctor','date_timestamp','description','VAT_client');

			
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

			#Get the SOAPs
			
			echo("<h4>Consulatation Info</h4>");
			$sql = "SELECT SOAP_S,SOAP_O,SOAP_A,SOAP_P FROM consultation
					WHERE VAT_doctor = '$VAT_d' AND date_timestamp = '$date'";
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
					echo("<p>This appointment does not have any consultation associated.</p>");
					echo("
					<form action=\"number_prescriptions.php\" method=\"post\">
					 <h5>Add new consultation?</h5>
					 <input type=\"hidden\" name=\"VAT_d\" value=\"{$VAT_d}\">
					 <input type=\"hidden\" name=\"date\" value=\"{$date}\">");
					 echo("<p><input type=\"submit\" value=\"New Consultation\"/></p>");		
					
			}
			
			else{

			$columns = array('SOAP_S','SOAP_O','SOAP_A','SOAP_P');

			
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
				echo("<td><a href=\"numberofteeth.php?date_timestamp={$date}&VAT_doctor={$VAT_d}");
					echo("\">Add Dental Charting</a></td>\n");
				echo("</tr>");
			}

			echo("</table>");
			
			
			#Get the diagnostic codes
			echo("<h4>Diagnostic codes</h4>");
			
			$sql = "SELECT ID as Diagnostic_Code FROM consultation as c
					LEFT JOIN consultation_diagnostic as cd on c.VAT_doctor = cd.VAT_doctor
								AND c.date_timestamp = cd.date_timestamp
					WHERE c.VAT_doctor = '$VAT_d' AND c.date_timestamp = '$date'";
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

			$columns = array('Diagnostic_Code');

			
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
			}
		?>
	</body>
</html>
