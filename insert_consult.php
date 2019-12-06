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
			
			$SOAP_S = $_REQUEST['SOAP_S'];
			$SOAP_O = $_REQUEST['SOAP_O'];
			$SOAP_A = $_REQUEST['SOAP_A'];
			$SOAP_P = $_REQUEST['SOAP_P'];
			
			$N = $_REQUEST['N_diagnostics'];
			$diagnostics = $_REQUEST['diagnostic_desc'];
			$diagnostic_code = $_REQUEST['diagnostic_code'];
			
			$VAT_nurse = $_REQUEST['VAT_nurse'];

			
			
			$meds_per_diag = [];
			for($i=0; $i < $N; $i++)	
			{
				echo("<p>{$diagnostics[$i]}&nbsp&nbsp{$diagnostic_code[$i]}:</p>");
				
				$meds = $_REQUEST["meds_{$i}"];
				
				$meds_cleaned = [];
				foreach($meds as $m)
				{
					$m_tuple = [];
					array_push($m_tuple, explode(' - ',$m));
					array_push($meds_cleaned,$m_tuple);
				}
				array_push($meds_per_diag ,$meds_cleaned);
			}
			
			
			
			/*
			for($i=0; $i < $N; $i++)	
			{
				echo("<p>{$diagnostics[$i]}&nbsp&nbsp{$diagnostic_code[$i]}:</p>");
				
				$meds = $_REQUEST["meds_{$i}"];
				foreach($meds as $m){
					echo("<p>&nbsp&nbsp&nbsp{$m}</p>");
				}
				
			}*/


			
			
			
			$sql_consult = $connection->prepare("INSERT INTO consultation VALUES (:VAT_doctor, :date_timestamp, :SOAP_S, :SOAP_O, :SOAP_A, :SOAP_P)");
			if ($sql_consult == FALSE)
			{
				$info = $connection->errorInfo();				
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}
			
			
			$test = $sql_consult->execute(array(":VAT_doctor" => $VAT_d , 
			":date_timestamp" => $date,
			":SOAP_S" => $SOAP_S,
			":SOAP_O" => $SOAP_O,
			":SOAP_A" => $SOAP_A,
			":SOAP_P" => $SOAP_P ));
			if ($test == FALSE)
			{
				$info = $connection->errorInfo();
				echo("<h3>Consult is already in the Database</h3>");	
				echo("<p></p>");					
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}
			
			$sql_diagn = $connection->prepare("INSERT INTO consultation_diagnostic VALUES (:VAT_doctor, :date_timestamp, :ID)");
			
			if ($sql_consult == FALSE)
			{
				$info = $connection->errorInfo();				
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}
			for($i=0; $i < $N; $i++)	
			{
				$test = $sql_diagn->execute(array(":VAT_doctor" => $VAT_d , 
				":date_timestamp" => $date,
				":ID" => $diagnostic_code[$i]));
				
				if ($test == FALSE)
				{
					$info = $connection->errorInfo();
					echo("<h3>Consult is already in the Database</h3>");	
					echo("<p></p>");					
					echo("<p>Error: {$info[2]}</p>");
					exit();
				}
			}

			$sql_nurse = $connection->prepare("INSERT INTO consultation_assistant VALUES (:VAT_doctor, :date_timestamp, :VAT_nurse)");
			
			if ($sql_nurse == FALSE)
			{
				$info = $connection->errorInfo();				
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}

			foreach($VAT_nurse as $nurse)
			{
			
			$test = $sql_nurse->execute(array(":VAT_doctor" =>  $VAT_d , 
			":date_timestamp" => $date,
			":VAT_nurse" => $nurse));
			
			if ($test == FALSE)
			{
				$info = $connection->errorInfo();
				echo("<h3>Nurse is already in the Database</h3>");	
				echo("<p></p>");					
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}
			}

			$sql_meds = $connection->prepare("INSERT INTO prescription VALUES (:name, :lab, :VAT_doctor, :date_timestamp, :ID, :dosage, :description)");
			
			if ($sql_meds == FALSE)
			{
				$info = $connection->errorInfo();				
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}

			for($i=0; $i < $N; $i++)	
			{
				echo("<p>{$diagnostics[$i]}&nbsp&nbsp{$diagnostic_code[$i]}:</p>");
				
				$meds = $meds_per_diag[$i];

				foreach($meds as $m_)
				{
					$m = $m_[0];
				
					$test = $sql_meds->execute(array(
					":name" => $m[0], 
					":lab" => $m[1], 
					":VAT_doctor" =>  $VAT_d , 
					":date_timestamp" => $date,
					":ID" => intval($diagnostic_code[$i]),
					":dosage" => 0.0,
					":description" => ''));
					
					if ($test == FALSE)
					{
						$info = $connection->errorInfo();
						echo("<h3>Med is already in the Database</h3>");	
						echo("<p></p>");					
						echo("<p>Error: {$info[2]}</p>");
						exit();
					}
				
				}
			}
			

			
			
			
			
			
			$connection = null;
		?>

		
<form action = "searchclient.php">
  <input type="submit" value="Go to seach client page">
</form>
	</body>
</html>
