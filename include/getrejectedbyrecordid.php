<?php
$show_reassign_link = 0;
include_once('database_connection.php');
$username = $fgmembersite->UserName();
$sql = "select * from users where username ='$username'";
$result_u = mysql_query($sql) or die(mysql_error());
$row_u = mysql_fetch_array($result_u);
if($row_u['user_role'] == "admin")
	$show_reassign_link = 1;

//include_once('database_connection.php');
$record_id = mysql_real_escape_string(@$_REQUEST['record']);
$sql = "select * from notapproved left join countries on notapproved.id_country = countries.id_country where id_rep =$record_id and reviewed='y'";

$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);
?>
<form name="submit_confirm" method="get">
<table border="0" cellspacing="5" width="90%">
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2 color=#993300>Title</font></td>
		<td><font face=arial size=2><?php echo $row['rep_title'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2 color=#993300>URL</font></td>
		<td><font face=arial size=2><?php echo '<a href="'.$row['rep_url'].'">'; echo $row['rep_url']; echo '</a></div>';?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2 color=#993300>Authority</font></td>
		<td><font face=arial size=2><?php echo $row['rep_authority'];?></font></td>
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
			</font>
		</td>
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

<?php 
if($show_reassign_link) {
	echo '<h3>This record has been assigned to the following editors: <font
	face=arial size=2 color=#993300;>';
	echo $row['rep_editors'];
	echo '</font></h3>';
	echo '<br />';
	echo '<h3>To reassign editors click <a
	href="viewreassignbyrecordid?record=<?php echo $record_id?>"><font
	face=arial size=2 color=#993300;> here</font></a></h3>';
}
?>
	
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
</form>






