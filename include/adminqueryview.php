
<?php
include_once('database_connection.php');

$sql="select name, username from users where user_role!='admin'";
$result = mysql_query($sql);
?>
<br /><br />
<b>Select a user from the drop down menu below </b><br /><br />
<form  method="get" action="viewusersubmissions.php">
<select name="userchoice">
<option value="">Select...</option>
	<?php
		while ($data=mysql_fetch_assoc($result)){
	?>
		<option value="<?php $username = $data['username']; echo $data['username'] ?>"><?php echo $data['name'] ?></option>
	<?php } ?>

</select> &nbsp;
<input type=submit name="submit" value="Get submissions" >
</form>
<br />


<?php
include_once('database_connection.php');

$sql="select id_rep, rep_title from approved";
$result = mysql_query($sql);
?>
<br /><br />
<b>Select a record from the drop down menu below </b><br /><br />
<form  method="get" action="viewrecordeditors.php">
<select name="recordchoice">
<option value="">Select...</option>
	<?php
		while ($data=mysql_fetch_assoc($result)){
	?>
		<option value="<?php $recordid = $data['id_rep']; echo $data['id_rep'] ?>">
		<?php 
		$title = $data['rep_title'];
		if(strlen($title))
			$title = substr($title, 0, 27)."..."; 
		echo $title?>
		</option>
	<?php } ?>

</select> &nbsp;
<input type=submit name="submit" value="Get editors" >
</form>
<br />
