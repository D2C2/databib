
<?php
include_once('database_connection.php');
$record_id = mysql_real_escape_string(@$_REQUEST['record']);
$is_approved = 0;

if(isset($_REQUEST['approved'])) {
	$is_approved = mysql_real_escape_string($_REQUEST['approved']);
}

if($is_approved) {
	$sql = "select * from approved left join countries on approved.id_country = countries.id_country where id_rep ='$record_id'";
} else {
	$sql = "select * from notapproved left join countries on notapproved.id_country = countries.id_country where id_rep ='$record_id'";
}

$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);
?>

<form name="submit_confirm" method="post"
	action="assignmentresponse.php?record=<?php echo $record_id?>&approved=<?php echo $is_approved;?>">
<table border="0" cellspacing="5" width="70%">
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2 color=#993300>Title</font></td>
		<td><font face=arial size=2><?php echo $row['rep_title'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2 color=#993300>URL</font></td>
		<td><font face=arial size=2><?php echo $row['rep_url'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2 color=#993300>Authority</font></td>
		<td><font face=arial size=2>
			<?php 
				$subquery = "select auth_name from authorities, notapproved_authorities where authorities.id_authority = notapproved_authorities.id_authority AND notapproved_authorities.id_record = $record_id";
				mysql_query("set names 'utf8'");
				$subresult = mysql_query($subquery) or die(mysql_error());
				
				while($subrow = mysql_fetch_array($subresult))
				{
						echo  $subrow['auth_name'] . "<br>";
				}				
			?>
			</font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Subjects</font></td>
		<td><font face=arial size=2>
			<?php 
				$subquery = "select subjects.sub_title, subjects.id_subject from subjects, subject_record_assoc where subjects.id_subject = subject_record_assoc.id_subject AND subject_record_assoc.id_record = $record_id";
				mysql_query("set names 'utf8'");
				$subresult = mysql_query($subquery) or die(mysql_error());
				
				while($subrow = mysql_fetch_array($subresult))
				{
						echo  $subrow['sub_title'] . "<br>";
				}				
			?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Description</font></td>
		<td><font face=arial size=2><?php echo $row['rep_description'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Access</font></td>
		<td><font face=arial size=2><?php echo $row['rep_status'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Start Date</font></td>
		<td><font face=arial size=2><?php echo $row['rep_startdate'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Country</font></td>
		<td><font face=arial size=2><?php echo $row['country_name'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Reuse</font></td>
		<td><font face=arial size=2><?php echo $row['rep_access'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Deposit</font></td>
		<td><font face=arial size=2><?php echo $row['rep_deposit'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Type</font></td>
		<td><font face=arial size=2><?php echo $row['rep_type'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Certification</font></td>
		<td><font face=arial size=2><?php echo $row['rep_certification'];?></font></td>
	</tr>
</table>
<br />
<br />


Assign this record to editor 1 (*) &nbsp; <select name="editorchoice1">
<?php
$sql="select name, username from users where user_role='editor'";
$result = mysql_query($sql);
?>
	<option value="">Select...</option>
	<?php
	while ($data=mysql_fetch_assoc($result)){
		?>
	<option value="<?php echo $data['username'] ?>"><?php echo $data['name'] ?></option>
	<?php } ?>
</select> &nbsp; <br />
<br />

Assign this record to editor 2 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select
	name="editorchoice2">
	<?php
	$sql="select name, username from users where user_role='editor'";
	$result = mysql_query($sql);
	?>
	<option value="">Select...</option>
	<?php
	while ($data=mysql_fetch_assoc($result)){
		?>
	<option value="<?php echo $data['username'] ?>"><?php echo $data['name'] ?></option>
	<?php } ?>
</select> &nbsp; <br />
<br />

Assign this record to editor 3 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select
	name="editorchoice3">
	<?php
	$sql="select name, username from users where user_role='editor'";
	$result = mysql_query($sql);
	?>
	<option value="">Select...</option>
	<?php
	while ($data=mysql_fetch_assoc($result)){
		?>
	<option value="<?php echo $data['username'] ?>"><?php echo $data['name'] ?></option>
	<?php } ?>
</select> &nbsp; <br />
<br />

	<?php
	echo ' <input type="submit"  name="Assign" value="Submit" />';
	?> <br />
<br />
	<?php
	if(!$is_approved) {
		echo ' <input type="submit"  name="Reject" value="Reject the record" />';
	}
	?></form>






