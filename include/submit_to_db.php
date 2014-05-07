<?php
require_once("config.php");

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

	$rep_title = addcslashes(trim($_POST['rep_title']), '\'');
	$rep_url = addcslashes(trim($_POST['rep_url']), '\'');
	$rep_authority = addcslashes(trim($_POST['rep_authority']), '\'');
	$rep_email = addcslashes(trim($_POST['rep_email']), '\'');
	$rep_subjects = $_POST['rep_subjects'];
	$rep_description = addcslashes(trim($_POST['rep_description']), '\'');
	$rep_status = addcslashes(trim($_POST['rep_status']), '\'');
	$rep_startdate = addcslashes(trim($_POST['rep_startdate']), '\'');
	$country_name = addcslashes(trim($_POST['country_name']), '\'');
	$rep_access = addcslashes(trim($_POST['rep_access']), '\'');
	$rep_deposit = addcslashes(trim($_POST['rep_deposit']), '\'');
	$rep_type = addcslashes(trim($_POST['rep_type']), '\'');
	$id_country = addcslashes(trim($_POST['hiddenCountryBox']), '\'');
	$subjectheading_ids = addcslashes($_POST['hiddenBox'], '\'');
	$authorities_concat = $_POST['hiddenAuthBox'];
	$rep_certification = addcslashes($_POST['rep_certification'], '\'');
	
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
	$mysqldate = mysql_real_escape_string(date('Y-m-d H:i:s'));
	
	$query = "INSERT INTO notapproved SET rep_title='$rep_title',
    	rep_url='$rep_url', rep_authority='$rep_authority', rep_email = '$rep_email', rep_status = '$rep_status',
    	rep_startdate = '$rep_startdate', rep_access = '$rep_access',
    	rep_deposit = '$rep_deposit', rep_type = '$rep_type', rep_editors = '$rep_editors', submitter = '$submitter', 
    	contributors = '$contributors', rep_link_to_approved = '$rep_link_to_approved', assignedtoeditor = '$assignedtoeditor', 
    	reviewed = '$reviewed', rep_description='$rep_description', id_country='$id_country', submission_date='$mysqldate', rep_certification='$rep_certification'";

	if (!mysql_query($query)) {
		echo mysql_error();
		HandleError("Error inserting into the table \nquery was\n $query");
		mail($admin_email, "submit_to_db.php: Insertion problem", "Insertion query:\n" . $query, "From: Databib Editor-in-Chief <databib@gmail.com>");
		return false;
	} 

	$insertId = mysql_insert_id();
	
	$auth_order = 1;
	$authorities = explode("#@!", $authorities_concat);
	foreach ($authorities as $authority) {
		if(!empty($authority)) {
			$auth = addcslashes($authority, '\'');
			$auth_parts = explode("~^", $auth);
			if(count($auth_parts) == 2) {
				$authId = $auth_parts[1];
			} else { 
				$query = "select id_authority from authorities where auth_name = '" . $auth ."'";
				mysql_query("set names 'utf8'");
				$result = mysql_query($query);
				if($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
					$authId = $row['id_authority'];
				} else {
					$query = "INSERT INTO authorities (auth_name) VALUES ('" . $auth . "')";
					if (!mysql_query($query)) {
						echo mysql_error();
						HandleError("Error inserting into the table \nquery was\n $query");
						mail($admin_email, "submit_to_db.php: Authority insertion problem", "Authority insertion query:\n" . $query, "From: Databib Editor-in-Chief <databib@gmail.com>");
						return false;
					}
					$authId = mysql_insert_id();
				}
			}
			$query = "INSERT INTO notapproved_authorities (id_record, id_authority, auth_order) VALUES (" . $insertId . ", " . $authId . ", " . $auth_order . ")";
			if (!mysql_query($query)) {
				echo mysql_error();
				HandleError("Error inserting into the table \nquery was\n $query");
				mail($admin_email, "submit_to_db.php: notapproved_authorities insertion problem", "Notapproved_authorities insertion query:\n" . $query, "From: Databib Editor-in-Chief <databib@gmail.com>");
				return false;
			}
			$auth_order = $auth_order + 1;
		}
	}
	
	$subjects = explode(" ", $subjectheading_ids);

	foreach ($subjects as $subject) {
		if(empty($subject))
			break;
		$query = "INSERT INTO subject_record_assoc SET id_record = $insertId, id_subject = $subject";
		//echo $query;
		if (!mysql_query($query)) {
			HandleError("Error inserting into the table \nquery was\n $query");
			$query = "delete from notapproved where id_rep=$insertId";
			mysql_query($query);
			mail($admin_email, "submit_to_db.php: subject_record_assoc insertion problem", "Subject_record_assoc insertion query:\n" . $query, "From: Databib Editor-in-Chief <databib@gmail.com>");
			
			$query = "delete from subject_record_assoc where id_record=$insertId";
			mysql_query($query);
			return false;
		}
	}
	
	if($rep_title !== "mytitle") { // to avoid sending email when it is the dummy insertion
		$query = "SELECT email FROM users where username = 'admin' or username = 'mwitt'";
		$result = mysql_query($query) or die(mysql_error());
		
		$email = "";
		while($row = mysql_fetch_array ($result)) {
			if($email != "")
				$email .= ",";
			$email .= $row['email'];	
		}
		$msg = "A new record was submitted to Databib with title " . $rep_title . ".\n\n";
		$msg .= "To login to Databib visit:\thttp://www.databib.org/login.php";
		mail($email, "[Databib] New record", $msg, "From: Databib Editor-in-Chief <databib@gmail.com>");
	}
	return true;
}

InsertIntoDB() or die("Error connecting to the database");
?>
