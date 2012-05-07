
<?php
include_once('database_connection.php');


$record_id = mysql_real_escape_string(@$_REQUEST['record']);
 
if(!empty($_REQUEST['Edit']))
{
	$location = 'Location:editnotapprovedrecord.php?record='.$record_id.'';
	header($location);
}
else if(!empty($_REQUEST['Approve']))
{

	include_once('post_tweet.php');
	$sql = "select * from notapproved where id_rep ='$record_id'";
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);

	$rep_title =  mysql_real_escape_string($row['rep_title']);
	$rep_url =  mysql_real_escape_string($row['rep_url']);
	$rep_authority =  mysql_real_escape_string($row['rep_authority']);
	$rep_subjects =  mysql_real_escape_string($row['rep_subjects']);
	$rep_description =  mysql_real_escape_string($row['rep_description']);
	 
	$rep_status =  mysql_real_escape_string($row['rep_status']);
	$rep_startdate =  mysql_real_escape_string($row['rep_startdate']);
	$rep_location = mysql_real_escape_string($row['rep_location']);
	$rep_access = mysql_real_escape_string($row['rep_access']);
	$rep_deposit = mysql_real_escape_string($row['rep_deposit']);
	$rep_type = mysql_real_escape_string($row['rep_type']);

	$rep_editors = mysql_real_escape_string($row['rep_editors']);
	$submitter = mysql_real_escape_string($row['submitter']);
	$contributors = mysql_real_escape_string($row['contributors']);
	$rep_link_to_approved = mysql_real_escape_string($row['rep_link_to_approved']);
	$subjectheading_ids = addcslashes($_POST['hiddenBox'], '\'');


	if($rep_link_to_approved != -1) {
		
		

		//set the record approved
		$sql = "select * from approved where id_rep ='$rep_link_to_approved'";
		$result = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_array($result);
		if(empty($contributors))
		$contributors = mysql_real_escape_string($row['contributors']);
		else
		$contributors = $contributors. ',' . mysql_real_escape_string($row['contributors']);
		// move data to approved table
		$sql = "UPDATE approved set rep_title='$rep_title', rep_url='$rep_url', rep_authority='$rep_authority',
    		rep_description='$rep_description', rep_status='$rep_status',
    		rep_startdate='$rep_startdate', rep_location='$rep_location', rep_access='$rep_access',
    		rep_deposit='$rep_deposit', rep_type='$rep_type',  contributors = '$contributors' 
    		where id_rep ='$rep_link_to_approved'";
		$result = mysql_query($sql) or die(mysql_error());
	
		//get the id of the approved record
		$insertId = $rep_link_to_approved;
	
		//delete the old subjects
		$query = "delete from subject_record_assoc_approved where id_record = $insertId";
		mysql_query($query);
		
	
		//get the new subjects
		$subjects = explode(" ", $subjectheading_ids);
		
		
		//insert the new subjects
		foreach ($subjects as $subject) {
				if(empty($subject))
				{
					continue;
				}

				$query = "INSERT INTO subject_record_assoc_approved SET id_record = $insertId, id_subject = $subject";
			
				if (!mysql_query($query)) {
		
					HandleError("Error inserting into the table \nquery was\n $query");
					$query = "delete from subject_record_assoc_approved where id_record=$insertId";
					mysql_query($query);
					return false;
				}
		}
		
	

	
	} else {
				
		$mysqldate = mysql_real_escape_string(date('Y-m-d'));
		$sql = $query ="INSERT INTO approved SET rep_title='$rep_title',
    		rep_url='$rep_url', rep_authority='$rep_authority', 
    		rep_status = '$rep_status',
    		rep_startdate = '$rep_startdate', rep_location = '$rep_location', rep_access = '$rep_access',
    		rep_deposit = '$rep_deposit', rep_type = '$rep_type', rep_editors = '$rep_editors', submitter = '$submitter', 
    		contributors = '$contributors', rep_description='$rep_description', creation_date = '$mysqldate'";
			    		

		$result = mysql_query($sql) or die(mysql_error());
		
			
		$insertId = mysql_insert_id();
		
		
		$query = "select * from subject_record_assoc where id_record=$record_id";
		$result = mysql_query($query) or die(mysql_error());

		
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
				$query = "INSERT INTO subject_record_assoc_approved SET id_subject= '" . $row['id_subject'] ."', id_record = $insertId";
				mysql_query($query) or die(mysql_error());
		}
		
		$shortUrl = getSmallLink("http://databib.org/viewapprovedbyrecordid.php?record=$insertId");

		$tweetlength = strlen("             was   added to @databib, $shortUrl");
		$titleLength = 140 - $tweetlength;
		
		if(strlen($rep_title) > $titleLength)
		{
			$rep_title = substr($rep_title,0,$titleLength-3);
			$rep_title = $rep_title . "..";
		}

		$tweet_text = "\"$rep_title\" was added to @databib, $shortUrl";
			
		post_tweet($tweet_text);	
	}


	$sql = "delete from notapproved where id_rep ='$record_id'";
	$result = mysql_query($sql) or die(mysql_error());
	$username = $fgmembersite->UserName();
	$sql = "SELECT * FROM notapproved where reviewed = 'n' AND rep_editors=\"$username\"";
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$num_rows = mysql_num_rows($result);

	echo  '<h2>The record has been approved!</h2>';
	if($num_rows > 0) {
		$record_id = $row['id_rep'];
		echo '<p><h3>Click';
		echo '<a style="color:red;text-decoration:none" href="viewnotapprovedbyrecordid.php?record='.$record_id.'"> here</a> for the next record</h3></p>';
	}

}
else if(!empty($_REQUEST['Reject']))
{
	 
	$sql = "UPDATE notapproved set reviewed = 'y' where id_rep ='$record_id'";
	$result = mysql_query($sql) or die(mysql_error());
	$username = $fgmembersite->UserName();
	$sql = "SELECT * FROM notapproved where reviewed = 'n' AND rep_editors=\"$username\"";
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$num_rows = mysql_num_rows($result);
	 
	 
	echo  '<h2>The record has been rejected!</h2>';
	if($num_rows > 0) {
		$record_id = $row['id_rep'];
		echo '<p><h3>Click';
		echo '<a style="color:red;text-decoration:none" href="viewnotapprovedbyrecordid.php?record='.$record_id.'"> here</a> for the next record</h3></p>';
	}
	 
}

?>








