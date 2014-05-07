<?php
require_once("membersite_config.php");
if(!$fgmembersite->CheckLogin())
{
	session_start();
	$_SESSION["ORIG_LINK"] = $_SERVER['REQUEST_URI'];

    $fgmembersite->RedirectToURL("../login.php");
    exit;
}

include_once('database_connection.php');

$username = $fgmembersite->UserName();
if(isset($_REQUEST['id'])) {
	if($fgmembersite->UserFullName() !="Databib Admin")
	{
		echo "Restricted page for the user";
		exit;
	}

	$id = mysql_real_escape_string(@$_REQUEST['id']);
} else {
	// This is used to remove test records submitted by selenium, if no
	// id is identified, it will search for any record with title "mytitle"
	if($username != "ahmed")
	{
		echo "Restricted page for the user";
		exit;
	}
	
	$query = "select id_rep from notapproved where rep_title = 'mytitle'";
	$result = mysql_query($query) or die(mysql_error());
	if($row = mysql_fetch_array ($result)) {
		$id = $row['id_rep'];
	} else {
		exit;
	}
}

$query = "select submitter, rep_editors, contributors from notapproved where id_rep = " . $id;
$result = mysql_query($query) or die(mysql_error());
if($row = mysql_fetch_array ($result)) {
	$editors = explode(',', $row['rep_editors']);
	$is_allowed = false;
	for($i = 0; $i < count($editors); $i++){
		if($editors[$i] == $username) {
			$is_allowed = true;
		}
	}

	$contributors = explode(',', $row['contributors']);
	for($i = 0; $i < count($contributors); $i++){
		if($contributors[$i] == $username) {
			$is_allowed = true;
		}
	}
	
	if($row['submitter'] == $username) {
			$is_allowed = true;
	}
	
	if(!$is_allowed)
		exit;
	
}

$query = "delete from notapproved where id_rep = " . $id;
$result = mysql_query($query) or die(mysql_error());

//reset the autoincrement of notapproved
$query = "SELECT max(id_rep) FROM notapproved";
$result = mysql_query($query) or die(mysql_error());
if($row = mysql_fetch_array ($result)) {
	$new_id = $row[0] + 1;	
	$query = "ALTER TABLE notapproved AUTO_INCREMENT = " . $new_id;
	$result = mysql_query($query) or die(mysql_error());
}

// remove any authority that is no more used after deleting the record that uses it
$query = "select id_authority from notapproved_authorities where id_record = " . $id;
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_array ($result)) {
	
	$id_authority = $row['id_authority'];
	$sum = 0;
	
	$query2 = "select count(*) from notapproved_authorities where id_authority = " . $id_authority;
	$result2 = mysql_query($query2) or die(mysql_error());
	if($row2 = mysql_fetch_array ($result2)) {
		$sum = $sum + $row2[0];
	}
	
	$query2 = "select count(*) from approved_authorities where id_authority = " . $id_authority;
	$result2 = mysql_query($query2) or die(mysql_error());
	if($row2 = mysql_fetch_array ($result2)) {
		$sum = $sum + $row2[0];
	}
	
	if($sum <= 1) {
		$query3 = "delete from authorities where id_authority = " . $id_authority;
		$result3 = mysql_query($query3) or die(mysql_error());
	}
}

//reset the autoincrement of authorities
$query = "SELECT max(id_authority) FROM authorities";
$result = mysql_query($query) or die(mysql_error());
if($row = mysql_fetch_array ($result)) {
	$new_id = $row[0] + 1;	
	$query = "ALTER TABLE authorities AUTO_INCREMENT = " . $new_id;
	$result = mysql_query($query) or die(mysql_error());
}

$query = "delete from notapproved_authorities where id_record = " . $id;
$result = mysql_query($query) or die(mysql_error());

$query = "delete from subject_record_assoc where id_record = " . $id;
$result = mysql_query($query) or die(mysql_error());
?>
