

<html>
 <body>
 <form action="availabledoctors.php" method="post">
 <h3>Add a new appointment</h3>
 <p>Client's VAT: <input type="text" name="VAT_client" value="<?=$_REQUEST['VAT']?>"/></p>
 <p>date/time (Y-M-D H:m:s): <input type="text" name="date_timestamp"/></p>
 <p>Description: <input type="text" name="description"/></p>
<p><input type="submit" value="Submit"/></p>
 </form>
</body>
</html>