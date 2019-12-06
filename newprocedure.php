<html>
	<body>
 		<h3>Add dental charting procedure for the consultation with the following:</h3>
 		<?php 
 		echo("<p>Date: {$_REQUEST['date_timestamp']}</p>");
 		echo("<p>VAT doctor: {$_REQUEST['VAT_doctor']}</p>");
 		?> 
 		<form action="addprocedure.php" method="post">
 			 	<p><input type="hidden" name="date_timestamp" value="<?=$_REQUEST['date_timestamp']?>"/></p>
	 			<p><input type="hidden" name="VAT_doctor" value="<?=$_REQUEST['VAT_doctor']?>"/></p>
	 			<?php
					for ($x = 1; $x <= $_REQUEST['numberofteeth']; $x++) {
					    echo "Tooth: $x <br>";

						echo("<div>");
			 			echo("<p>Quadrant:");
			 			echo("<select name = 'quadrant[]'>");
						  echo("<option value ='1'>1</option>");
						  echo("<option value='2'>2</option>");
						  echo("<option value='3'>3</option>");
						  echo("<option value='4'>4</option>");
						echo("</select>");
						echo("</p>");
						echo("<p> Number:");
			 			echo("<select name='number[]'>");
						  echo("<option value='1'>1</option>");
						  echo("<option value='2'>2</option>");
						  echo("<option value='3'>3</option>");
						  echo("<option value='4'>4</option>");
						  echo("<option value='5'>5</option>");
						  echo("<option value='6'>6</option>");
						  echo("<option value='7'>7</option>");
						  echo("<option value='8'>8</option>");
						echo("</select>");
						echo("</p>");
			 			echo("<p>Measure: <input type='text' name='measure[]'/></p>");
		 				echo("</div>");
				}
	 			echo("<p><input type='submit' value='Submit'/></p>");
				?>
 		</form>
	</body>
</html>