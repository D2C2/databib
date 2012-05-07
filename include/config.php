<?php
	
	require_once("rand_generator.php");

	//Database configuration
	$database_hostname = "localhost"; /*host name where the database is located*/
	$database_username = "root";
	$database_password = "yu112358$";
	$database_name = "databibDB";

	//Email configuration
	$website_name = "databib.org"; /* site name */
	$email_id  = "databib@gmail.com"; /*Provide the email address where you want to get notifications*/
	
	//session configuration
	if(isset($_SESSION['random_key'])) {
		$random_key = $_SESSION["random_key"];
	}
	else
	{
		$random_key = keygen(15); //generate a new key
		$_SESSION["random_key"] =  $random_key;
	}
?>
