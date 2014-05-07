
<?php
include_once('database_connection.php');

$sql="select name, username from users where user_role!='admin' order by name";
$result = mysql_query($sql);
?>
<br />
<b>Select a user from the drop down menu below </b><br /><br />
<form  method="get" action="viewuserdetails.php">
<select name="userchoice">
<option value="">Select...</option>
	<?php
		while ($data=mysql_fetch_assoc($result)){
	?>
		<option value="<?php $username = $data['username']; echo $data['username'] ?>"><?php echo $data['name'] ?></option>
	<?php } ?>

</select> &nbsp;
<input type=submit name="submit" value="Go" >
</form>
<br />



