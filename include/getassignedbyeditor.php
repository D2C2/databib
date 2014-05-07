<?php

include_once('database_connection.php');

$query = "SELECT name FROM users where username='$editor'";
$result = mysql_query($query) or die(mysql_error());
if($row = mysql_fetch_array($result)) {
	$name = $row['name'];
}


echo "<h1>$name</h1>";
echo "<br/><br/>";

echo "<h3>Records waiting for review</h3>";

$query = "SELECT * FROM notapproved where rep_editors like '%$editor%' AND assignedtoeditor = 'y' AND reviewed = 'n' ORDER BY rep_title ASC";
$result = mysql_query($query) or die(mysql_error());

$counter = 1;
while($row = mysql_fetch_array($result)) {

	$title = $row['rep_title'];
	$submission_date = $row['submission_date'];
	$assignment_date = $row['assignment_date'];
	$record_id = $row['id_rep'];
	
	echo '<br/>';
	echo '<div>';
	echo $counter;
	echo '.&nbsp;&nbsp;';
	echo "<a href=\"viewassignedbyrecordid.php?record=" .$record_id . "\" style=\"color:#993300; font-size:14px\">";
	echo $title;
	echo  '</a><br/>';
	echo "<span class=\"tab1\"></span><span style=\"color:gray\">Submitted on $submission_date</span><br/>";
	echo "<span class=\"tab1\"></span><span style=\"color:gray\">Assigned on $assignment_date";
	echo '</div>';
	
	$counter++;
}
echo "<br/><br/>";

echo "<h3>Records approved and assigned to editor</h3>";

$query = "SELECT * FROM approved where rep_editors like '%$editor%' ORDER BY rep_title ASC";
$result = mysql_query($query) or die(mysql_error());

$counter = 1;
while($row = mysql_fetch_array($result)) {

	$title = $row['rep_title'];
	$submission_date = $row['submission_date'];
	$assignment_date = $row['assignment_date'];
	$record_id = $row['id_rep'];
	
	echo '<br/>';
	echo '<div>';
	echo $counter;
	echo '.&nbsp;&nbsp;';
	echo "<a href=\"viewapprovedbyrecordid.php?record=" .$record_id . "\" style=\"color:#993300; font-size:14px\">";
	echo $title;
	echo  '</a>';
	echo '</div>';
	
	$counter++;
}
echo "<br/><br/>";

?>
