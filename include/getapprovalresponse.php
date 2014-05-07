
<?php
include_once('database_connection.php');

ini_set('display_errors',1); 
error_reporting(E_ALL);

// function to insert the approved record into the real time index of Sphinx
function index_it($insertId, $rep_title, $rep_authority, $rep_description, $country_name, $subjects_concat, $classification)
{
	$sphinx_host = '127.0.0.1';
	$sphinx_user = '';
	$sphinx_pwd = '';
	$sphinx_db = '';
	$sphinx_port = 9306;
	$sphinx_index_table = 'databibrt';
	
	// Replace inserts if the record does not exist, and updates if exists already
	$replace_qry = "REPLACE INTO $sphinx_index_table ( id, title, authority, description, location, subjects, classification ) VALUES ( $insertId, '$rep_title', '$rep_authority', '$rep_description', '$country_name', '$subjects_concat', '$classification')";

	// Open connection to Sphinx
	$sphinx_connection = new mysqli($sphinx_host, $sphinx_user, $sphinx_pwd, $sphinx_db, $sphinx_port);

	if ($sphinx_connection->connect_errno) {
		echo "<br>Connection to Sphinx failed: $sphinx_connection->connect_error </br>";
	}

	if ($sphinx_connection->query($replace_qry) === FALSE) {
		echo "<br>Indexing failed, query: $replace_qry </br>";
	}
	$sphinx_connection->close();
}

$record_id = mysql_real_escape_string(@$_REQUEST['record']);
$username = $fgmembersite->UserName();
$sql = "select * from notapproved left join countries on notapproved.id_country = countries.id_country where id_rep ='$record_id'";
$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);

$rep_title =  mysql_real_escape_string($row['rep_title']);
$rep_editors = mysql_real_escape_string($row['rep_editors']);

if(!empty($_REQUEST['Edit']))
{
	$location = 'Location:editnotapprovedrecord.php?record='.$record_id.'';
	header($location);
}
else if(!empty($_REQUEST['Approve']))
{

	include_once('post_tweet.php');


	$rep_title =  mysql_real_escape_string($row['rep_title']);
	$rep_url =  mysql_real_escape_string($row['rep_url']);
	$rep_authority =  mysql_real_escape_string($row['rep_authority']);

	$rep_description =  mysql_real_escape_string($row['rep_description']);
	$classification = mysql_real_escape_string($row['classification']);
	$editor_note = mysql_real_escape_string($row['editor_note']);
	 
	$rep_status =  mysql_real_escape_string($row['rep_status']);
	$rep_startdate =  mysql_real_escape_string($row['rep_startdate']);
	$country_name = mysql_real_escape_string($row['country_name']);
	$rep_access = mysql_real_escape_string($row['rep_access']);
	$rep_deposit = mysql_real_escape_string($row['rep_deposit']);
	$rep_type = mysql_real_escape_string($row['rep_type']);
	$rep_certification = mysql_real_escape_string($row['rep_certification']);

	$submitter = mysql_real_escape_string($row['submitter']);
	$contributors = mysql_real_escape_string($row['contributors']);
	$rep_link_to_approved = mysql_real_escape_string($row['rep_link_to_approved']);
	$id_country = mysql_real_escape_string($row['id_country']);

	$subjects_concat = '';
	
	if($rep_link_to_approved != -1) {
		
		

		//set the record approved
		$sql = "select * from approved left join countries on approved.id_country = countries.id_country where id_rep ='$rep_link_to_approved'";
		$result = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_array($result);
		if(empty($contributors))
		$contributors = mysql_real_escape_string($row['contributors']);
		else
		$contributors = $contributors. ',' . mysql_real_escape_string($row['contributors']);
		// move data to approved table
		$sql = "UPDATE approved set rep_title='$rep_title', rep_url='$rep_url', rep_authority='$rep_authority',
    		rep_description='$rep_description', rep_status='$rep_status', editor_note='$editor_note',
    		rep_startdate='$rep_startdate', rep_access='$rep_access',
    		rep_deposit='$rep_deposit', rep_type='$rep_type',  contributors = '$contributors',
			classification = '$classification', id_country = '$id_country', rep_certification = '$rep_certification'
    		where id_rep ='$rep_link_to_approved'";
		$result = mysql_query($sql) or die(mysql_error());
	
		//get the id of the approved record
		$insertId = $rep_link_to_approved;
	
		//delete the old subjects
		$query = "delete from subject_record_assoc_approved where id_record = $insertId";
		mysql_query($query) or die(mysql_error());
		

		$query = "select a.id_subject,b.sub_title from subject_record_assoc a join subjects b on a.id_subject = b.id_subject where a.id_record=$record_id";
		mysql_query("set names 'utf8'");
		$result = mysql_query($query) or die(mysql_error());


		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$query = "INSERT INTO subject_record_assoc_approved SET id_subject= '" . $row['id_subject'] ."', id_record = $insertId";
			mysql_query($query) or die(mysql_error());

			if( ! empty($subjects_concat) ){
					$subjects_concat = $subjects_concat . ", ";
			}
			$subjects_concat = $subjects_concat . $row['sub_title'];
		}
		
		//delete the old authorities
		$query = "delete from approved_authorities where id_record = $insertId";
		mysql_query($query) or die(mysql_error());
		
		$query = "select id_authority, auth_order from notapproved_authorities where id_record=$record_id";
		$result = mysql_query($query) or die(mysql_error());

		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$query = "INSERT INTO approved_authorities SET id_authority= " . $row['id_authority'] .", id_record = $insertId, auth_order = " . $row['auth_order'];
			mysql_query($query) or die(mysql_error());
		}
	} else {
		
		$mysqldate = mysql_real_escape_string(date('Y-m-d H:i:s'));
		$sql = $query ="INSERT INTO approved SET rep_title='$rep_title',
    		rep_url='$rep_url', rep_authority='$rep_authority', 
    		rep_status = '$rep_status', editor_note='$editor_note',
    		rep_startdate = '$rep_startdate', rep_access = '$rep_access',
    		rep_deposit = '$rep_deposit', rep_type = '$rep_type', rep_editors = '$username', submitter = '$submitter', 
    		contributors = '$contributors', rep_description='$rep_description', creation_date = '$mysqldate',
			classification = '$classification', id_country = '$id_country', rep_certification = '$rep_certification'";
			    		

		$result = mysql_query($sql) or die(mysql_error());
		
			
		$insertId = mysql_insert_id();
		
		
		$query = "select a.id_subject,b.sub_title from subject_record_assoc a join subjects b on a.id_subject = b.id_subject where a.id_record=$record_id";
		mysql_query("set names 'utf8'");
		$result = mysql_query($query) or die(mysql_error());

		
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
				$query = "INSERT INTO subject_record_assoc_approved SET id_subject= '" . $row['id_subject'] ."', id_record = $insertId";
				mysql_query($query) or die(mysql_error());
				
				if( ! empty($subjects_concat) ){
					$subjects_concat = $subjects_concat . ", ";
				}
				$subjects_concat = $subjects_concat . $row['sub_title'];
		}
		
		$query = "select id_authority, auth_order from notapproved_authorities where id_record=$record_id";
		$result = mysql_query($query) or die(mysql_error());

		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$query = "INSERT INTO approved_authorities SET id_authority= " . $row['id_authority'] .", id_record = $insertId, auth_order = " . $row['auth_order'];
			mysql_query($query) or die(mysql_error());
		}
		
		$shortUrl = getSmallLink("http://databib.org/repository/$insertId");

		$tweetlength = strlen("             was   added to @databib, $shortUrl");
		$titleLength = 140 - $tweetlength;
		
		if(strlen($rep_title) > $titleLength)
		{
			$rep_title = substr($rep_title,0,$titleLength-3);
			$rep_title = $rep_title . "..";
		}

		$rep_title = preg_replace(
			'{\b(?:http://)?(www\.)?([^\s]+)(\.com|\.org|\.net)\b}mi',
			'\'$2\'',
			$rep_title
		);
		$tweet_text = "\"$rep_title\" was added to @databib, $shortUrl";
		
		try {		
			post_tweet($tweet_text);	
		} catch (Exception $e) {
			require_once("config.php");
			
			mail("databib@gmail.com," . $admin_email, "getapprovalresponse.php: Twitter problem", $e->getMessage(), "From: Databib Editor-in-Chief <databib@gmail.com>");
		}
	}


	$sql = "delete from notapproved where id_rep ='$record_id'";
	$result = mysql_query($sql) or die(mysql_error());
	$sql = "delete from subject_record_assoc where id_record=$record_id";
	$result = mysql_query($sql) or die(mysql_error());
	
	
	$sql = "SELECT * FROM notapproved where reviewed = 'n' AND rep_editors LIKE '%$username%' ORDER BY id_rep ASC";
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$num_rows = mysql_num_rows($result);

	echo  '<h2>The record has been approved!</h2>';
	if($num_rows > 0) {
		$record_id = $row['id_rep'];
		echo '<p><h3>Click';
		echo '<a style="color:red;text-decoration:none" href="viewnotapprovedbyrecordid.php?record='.$record_id.'"> here</a> for the next record</h3></p>';
	}

	$subjects_concat = mysql_real_escape_string($subjects_concat);
	index_it($insertId, $rep_title, $rep_authority, $rep_description, $country_name, $subjects_concat, $classification);

}
else if(!empty($_REQUEST['Reject']))
{
	
	$sql = "UPDATE notapproved set reviewed = 'y', rep_editors = '$username' where id_rep ='$record_id'";
	$result = mysql_query($sql) or die(mysql_error());
	
	$sql = "SELECT * FROM notapproved where reviewed = 'n' AND rep_editors=\"$username\"";
	$result = mysql_query($sql) or die(mysql_error());
	$row_next = mysql_fetch_array($result);
	$num_rows = mysql_num_rows($result);
	 
	 
	echo  '<h2>The record has been rejected!</h2>';
	if($num_rows > 0) {
		$record_id = $row_next['id_rep'];
		echo '<p><h3>Click';
		echo '<a style="color:red;text-decoration:none" href="viewnotapprovedbyrecordid.php?record='.$record_id.'"> here</a> for the next record</h3></p>';
	}
	 
}

if(!empty($_REQUEST['Approve']) || !empty($_REQUEST['Reject'])) {
	// Email the other editors notifying them that the record has been reviewed.
	$msg = "This is to notify that a Databib record that has been assigned to you has just been already reviewed by another editor.";
	if(!empty($_REQUEST['Approve']))
		$msg .= " You can check the published record through the URL below.";
	$msg .= "\n\nRecord title: " . $rep_title;
	if(!empty($_REQUEST['Approve']))
		$msg .= "\n\nRecord URL: http://www.databib.org/viewapprovedbyrecordid.php?record=" . $insertId;
	
	$editors = explode(',', $rep_editors);
	for($i = 0; $i < count($editors); $i++){
		if($editors[$i] != $username) {
			$mail_add = mysql_fetch_row(mysql_query("SELECT email FROM users WHERE username = '$username'"))[0] . ', databib@gmail.com';
			$email = $mail_add[0];
			mail($email, "Databib Record is reviewed by another editor", $msg, "From: Databib Editor-in-Chief <databib@gmail.com>");
		}
	}
}
?>








