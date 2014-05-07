
<?php
include_once('database_connection.php');
$record_id = mysql_real_escape_string(@$_REQUEST['record']);
$sql = "select * from notapproved left join countries on notapproved.id_country = countries.id_country where id_rep ='$record_id'";
$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);
?>
<form name="submit_confirm" method="post"
	action="assignmentresponse.php?record=<?php echo $record_id?>">
<table border="0" cellspacing="5" width="90%">
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
			?>
			
			
			</font></td>
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
	$sql="select name, username from users  where user_role='editor'";
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
	$sql="select name, username from users  where user_role='editor'";
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

	<br/><hr><br/><br/>
	<?php
		echo '<h3>Editor notes:</h3><br/>';
		$notes = explode("##", $row[editor_note]);
		$formatted_note = "";
		foreach ($notes as $value) {
			if($value != "") {
				$split_note = explode("#", $value);
				if(!empty($formatted_note))
					$formatted_note .= "<br/>";
				$formatted_note .= "<span style=\"font-weight:bold;font-style:italic;\" >" . mysql_fetch_row(mysql_query("SELECT name FROM users WHERE username = '" . $split_note[0] . "'"))[0] . ": </span>";
				$formatted_note .= $split_note[1];
			}
		}
		echo '<p name="editor_note" id="editor_note">' . $formatted_note . '</p>';
		$note_link = "Edit note";
		if( empty($row['editor_note']) ) {
			$note_link = "Add note";
		}
		echo "<a href=\"javascript:void(0)\" onclick=\"editNote('editor_note', '" . $record_id . "', 'notapproved')\"><i>$note_link</i></a>";
	?>
	<br/><br/><br/>
	<?php
	echo ' <input type="submit"  name="Assign" value="Submit" />';
	?> <br />
<br />
	<?php
	echo ' <input type="submit"  name="Reject" value="Reject the record" />';
	?>

</form>






