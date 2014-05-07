
<?php
include_once('database_connection.php');

$record_id = mysql_real_escape_string(@$_REQUEST['record']);
$is_approved = false;
if(isset($_REQUEST['approved'])) {
	$is_approved = mysql_real_escape_string($_REQUEST['approved']);
}

if(!empty($_REQUEST['Assign']))  {
	 
	if($is_approved) { 
		$sql = "select * from approved where id_rep ='$record_id'";
	} else {
		$sql = "select * from notapproved where id_rep ='$record_id'";
	}
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	 
	$editor = $_POST['editorchoice1'];
	if(empty($editor)) {
		echo  '<h3>Editor 1 is mandatory. Please go back and add editor 1</h3>';
		echo '<br/>';
		exit;
	}
	$email = array();
	$mail = mysql_fetch_row(mysql_query("SELECT email FROM users WHERE username = '{$_POST['editorchoice1']}'"));
	$email[0] = $mail[0];
	 
	$editor2 = $_POST['editorchoice2'];
	$editor3 = $_POST['editorchoice3'];

	if(!empty($_POST['editorchoice2'])) {
		$editor = $editor . ',' . $editor2;
		$mail = mysql_fetch_row(mysql_query("SELECT email FROM users WHERE username = '{$_POST['editorchoice2']}'"));
		$email[1] = $mail[0];
	}
		
	if(!empty($_POST['editorchoice3'])) {
		$editor = $editor . ',' . $editor3;
	 	$mail = mysql_fetch_row(mysql_query("SELECT email FROM users WHERE username = '{$_POST['editorchoice3']}'"));
		$email[2] = $mail[0];
	}
	$rep_editors = $editor;

	echo  '<h2>The record has been assigned!</h2>';
	
	$todaydate = mysql_real_escape_string(date('Y-m-d H:i:s'));
	if($is_approved) {
		$sql = "UPDATE approved set rep_editors = '$rep_editors' where id_rep ='$record_id'";
		$result = mysql_query($sql) or die(mysql_error());
	} else {
		$sql = "UPDATE notapproved set rep_editors = '$rep_editors', assignedtoeditor = 'y', assignment_date='$todaydate' 
			where id_rep ='$record_id'";
		$result = mysql_query($sql) or die(mysql_error());
	
		$msg = "You have been assigned a new record in Databib to review. Please go to http://databib.org/dashboard.php to review to reject, edit and/or approve.";
		$msg .= "\n\nRecord title: " . $row['rep_title'];
		$msg .= "\n\nRecord URL: http://www.databib.org/viewnotapprovedbyrecordid.php?record=" . $record_id;
		for ($i=0;$i<=count($email);$i++) {
			mail($email[$i], "New Databib Record", $msg, "From: Databib Editor-in-Chief <databib@gmail.com>");
		}
		
		$sql = "SELECT * FROM notapproved where assignedtoeditor = 'n' AND reviewed='n'";
		$result = mysql_query($sql) or die(mysql_error());
		$num_rows = mysql_num_rows($result);
		$row = mysql_fetch_array($result);
		$record_id = $row['id_rep'];

		if($num_rows > 0) {
			echo '<p><h3>Click';
			echo '<a style="color:red;text-decoration:none" href="viewnotassignedbyrecordid.php?record='.$record_id.'"> here</a> for the next record</h3></p>';
		}
	}

}
else if(!empty($_REQUEST['Reject']) && !$is_approved)
{


	$query = "delete from subject_record_assoc where id_record=$record_id";
	mysql_query($query);

	$sql = "delete from notapproved where id_rep ='$record_id'";
	$result = mysql_query($sql) or die(mysql_error());

	$sql = "SELECT * FROM notapproved where assignedtoeditor = 'n' AND reviewed='n'";
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