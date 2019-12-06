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
			$VAT = $_REQUEST['VAT'];
			$name = $_REQUEST['name'];
			$street = $_REQUEST['street'];
			$city = $_REQUEST['city'];
			$zip = $_REQUEST['zip'];
			$gender = $_REQUEST['gender'];
			
			$birth_date = $_REQUEST['birth_date'];
			$birth_date = strtotime($birth_date);
			$birth_date = date("Y-m-d", $birth_date);
			
			
			$sql_client = $connection->prepare("INSERT INTO client VALUES (:VAT, :name, :birth_date, :street, :city, :zip, :gender, :age)");
			
			if($sql_client == FALSE){
				$info = $connection->errorInfo();				
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}
			$test = $sql_client->execute(array(
			":VAT" => $VAT,
			":name" => $name,
			":birth_date" => $birth_date,
			":street" => $street,
			":city" => $city,
			":zip" => $zip,
			":gender" => $gender,
			":age" => 0));
			
			
			if($test == FALSE){
				$info = $connection->errorInfo();
				echo("<h3>Client already in database.</h3>");	
				echo("<p></p>");					
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}
			else
			{
				echo("<p>A Prescription was succesfully inserte</p>");
			}
			
			$connection = null;
		?>
		<form action = "searchclient.php">
			<input type="submit" value="Go to search client page">
		</form>
	</body>
</html>
