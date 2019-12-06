<html>
	<body>
 		<h3>Enter number of teeth measured</h3>
 		<form action="newprocedure.php" method="post">
 			<p><input type="hidden" name="date_timestamp" value="<?=$_REQUEST['date_timestamp']?>"/></p>
	 		<p><input type="hidden" name="VAT_doctor" value="<?=$_REQUEST['VAT_doctor']?>"/></p>
 			<p>Number: <input type="text" name="numberofteeth" required="" /></p>
 			<p><input type="submit" value="Submit"/></p>
 		</form>
	</body>
</html>