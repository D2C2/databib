
<?php

include_once('database_connection.php');

$email_msg1 = "The following record has been assigned to you for reviewing more than 10 days ago:\n\n";
$email_msg2 = "\n\nPlease go to http://databib.org/dashboard.php to review to reject, edit and/or approve.";
$headers = 'From: Databib Editor-in-Chief <databib@gmail.com>' . "\r\n";
$headers .= 'Cc: databib@gmail.com' . "\r\n";


$old_date = strtotime ( '-10 day', strtotime(date('Y-m-d H:i:s')));
$old_date = date('Y-m-d', $old_date);

$query_e = "SELECT rep_title, rep_editors, assignment_date FROM notapproved WHERE assignedtoeditor='y' AND reviewed = 'n' AND assignment_date between '" . $old_date . " 00:00:00' AND '" . $old_date . " 23:59:59'";
$result_e = mysql_query($query_e) or die(mysql_error());

while($row_e = mysql_fetch_array($result_e)) {
	$editors = explode(',', $row_e['rep_editors']);
	for($i = 0; $i < count($editors); $i++){
		$query_u = "SELECT name, email FROM users WHERE username='" . $editors[$i] . "'";
		$result_u = mysql_query($query_u) or die(mysql_error());
		if($row_u = mysql_fetch_array($result_u)) {
			mail($row_u['email'], "Review reminder", $email_msg1 . $row_e['rep_title'] . $email_msg2, $headers);
		}
	}
}

?>