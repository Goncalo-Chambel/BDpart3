<html>
 <body>
 <form action="insertclient.php" method="post">
 <h3>Insert a new client</h3>
 <p>Client's name.: <input type="text" name="name"/></p>
 <p>VAT: <input type="text" name="VAT"/></p>
 <p>Birth date (Y-M-D): <input type="text" name="birth_date"/></p>
 <p>Street: <input type="text" name="street"/></p>
 <p>City:<input type="text" name="city"/></p>
 <p>ZIP: <input type="text" name="zip"/></p>
 <p>Gender:
 <select name = "gender">
 	<option value="">Select...</option>
 	<option value="M">Male</option>
 	<option value="F">Female</option>
 	<option value="Other">Other</option>
</select>
 </p>
<p><input type="submit" value="Submit"/></p>
 </form>
 </body>
</html>