<?php


ini_set('display_errors',1); 
error_reporting(E_ALL);


include_once ('database_connection.php');

function HandleError($err) {
	echo($err);
}

function Ensuretable() {
	$result = mysql_query("SHOW COLUMNS FROM notapproved");
	if (!$result || mysql_num_rows($result) <= 0)
		return false;
	else
		return true;
}

function InsertIntoDB() {
	if (!Ensuretable())
		return false;

	include ("membersite_config.php");

	include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';	
	$securimage = new Securimage();

	if(!$fgmembersite->CheckLogin())
	{
		if ($securimage->check($_POST['captcha_code']) == false) {
		  // the code was incorrect
		  // you should handle the error so that the form processor doesn't continue

		  // or you can use the following code if there is no validation or you do not know how
	 	 echo "The security code entered was incorrect.<br /><br />";
	  	 echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
	 	 exit;
		}
	}
	
	
	$rep_title = addcslashes(trim($_POST['rep_title']), '\'');
	$rep_url = addcslashes(trim($_POST['rep_url']), '\'');
	$rep_authority = addcslashes(trim($_POST['rep_authority']), '\'');
	$rep_subjects = $_POST['rep_subjects'];
	$rep_description = addcslashes(trim($_POST['rep_description']), '\'');
	$rep_status = addcslashes(trim($_POST['rep_status']), '\'');
	$rep_startdate = addcslashes(trim($_POST['rep_startdate']), '\'');
	$rep_location = addcslashes(trim($_POST['rep_location']), '\'');
	$rep_access = addcslashes(trim($_POST['rep_access']), '\'');
	$rep_deposit = addcslashes(trim($_POST['rep_deposit']), '\'');
	$rep_type = addcslashes(trim($_POST['rep_type']), '\'');
	$subjectheading_ids = addcslashes($_POST['hiddenBox'], '\'');
	if (empty($subjectheading_ids)) {
		echo "One or more of your subject headings do not  match to the Library of Congress subject headings.<br/><br/>";
		echo "Please go back and correct the subject headings by adding each subject heading
		individually <br/> using the autocompletefeature.";
		echo "<br/><br/><br/><br/>";
		exit();
	}

	$rep_editors = "";
	$submitter = $fgmembersite -> UserName();
	$contributors = "";
	$rep_link_to_approved = -1;
	$assignedtoeditor = 'n';
	$reviewed = 'n';

	$query = "INSERT INTO notapproved SET rep_title='$rep_title',
    	rep_url='$rep_url', rep_authority='$rep_authority', rep_status = '$rep_status',
    	rep_startdate = '$rep_startdate', rep_location = '$rep_location', rep_access = '$rep_access',
    	rep_deposit = '$rep_deposit', rep_type = '$rep_type', rep_editors = '$rep_editors', submitter = '$submitter', 
    	contributors = '$contributors', rep_link_to_approved = '$rep_link_to_approved', assignedtoeditor = '$assignedtoeditor', 
    	reviewed = '$reviewed', rep_description='$rep_description'";

	if (!mysql_query($query)) {
		echo mysql_error();
		HandleError("Error inserting into the table \nquery was\n $query");
		return false;
	} 

	$insertId = mysql_insert_id();
	$subjects = explode(" ", $subjectheading_ids);

	foreach ($subjects as $subject) {
		if(empty($subject))
			return true;
		$query = "INSERT INTO subject_record_assoc SET id_record = $insertId, id_subject = $subject";
		//echo $query;
		if (!mysql_query($query)) {
			HandleError("Error inserting into the table \nquery was\n $query");
			$query = "delete from notapproved where id_rep=$insertId";
			mysql_query($query);
			$query = "delete from subject_record_assoc where id_record=$insertId";
			mysql_query($query);
			return false;
		}
	}

}

InsertIntoDB() or die("Error connecting to the database");
?>
