
<?php
include_once('database_connection.php');

$record_id = mysql_real_escape_string(@$_REQUEST['record']);

if(!empty($_REQUEST['Assign']))  {
	 
	$sql = "select * from notapproved where id_rep ='$record_id'";
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	 
	$editor = $_POST['editorchoice1'];
	if(empty($editor)) {
		echo  '<h3>Editor 1 is mandatory. Please go back and add editor 1</h3>';
		echo '<br/>';
		exit;
	}

	 
	$editor2 = $_POST['editorchoice2'];
	$editor3 = $_POST['editorchoice3'];

	if(!empty($_POST['editorchoice2']))
	$editor = $editor . ',' . $editor2;

	if(!empty($_POST['editorchoice3']))
	$editor = $editor . ',' . $editor3;
	 
	$rep_editors = $editor;

	// move data to approved table
	$sql = "UPDATE notapproved set rep_editors = '$rep_editors', assignedtoeditor = 'y'
        where id_rep ='$record_id'";
	$result = mysql_query($sql) or die(mysql_error());

	$sql = "SELECT * FROM notapproved where assignedtoeditor = 'n' AND reviewed='n';";
	$result = mysql_query($sql) or die(mysql_error());
	$num_rows = mysql_num_rows($result);
	$row = mysql_fetch_array($result);
	$record_id = $row['id_rep'];

	echo  '<h2>The record has been assigned!</h2>';
	if($num_rows > 0) {
		echo '<p><h3>Click';
		echo '<a style="color:red;text-decoration:none" href="viewnotassignedbyrecordid.php?record='.$record_id.'"> here</a> for the next record</h3></p>';
	}

}
else if(!empty($_REQUEST['Reject']))
{


	$query = "delete from subject_record_assoc where id_record=$record_id";
	mysql_query($query);

	$sql = "delete from notapproved where id_rep ='$record_id'";
	$result = mysql_query($sql) or die(mysql_error());

	$sql = "SELECT * FROM notapproved where assignedtoeditor = 'n' AND reviewed='n';";
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$num_rows = mysql_num_rows($result);
	$record_id = $row['id_rep'];

	echo  '<h2>The record has been rejected</h2>';
	if($num_rows > 0) {
		echo '<p><h3>Click';
		echo '<a style="color:red;text-decoration:none" href="viewnotassignedbyrecordid.php?record='.$record_id.'"> here</a> for the next record</h3></p>';
	}

}

?>








