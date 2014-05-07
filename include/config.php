<?php

	session_start();
	require_once("rand_generator.php");

	//Database configuration
	$database_hostname = ""; /*host name where the database is located*/
	$database_username = "";
	$database_password = "";
	$database_name = "";

	//Email configuration
	$website_name = ""; /* site name */
	$email_id  = ""; /*Provide the email address where you wish to get notifications*/
	$email_pass = "";
	
	$admin_email = "";
	
	//session configuration
	//$random_key = keygen(15);
	if(isset($_SESSION['random_key'])) {
		$random_key = $_SESSION["random_key"];
	}
	else
	{
		$random_key = keygen(15); //generate a new key
		$_SESSION["random_key"] =  $random_key;
	}

	// Twitter configuration
	$twitter_token = "";
	$twitter_tokensecret = "";
	
	$twitter_consumerKey = "";
    	$twitter_consumerSecret = "";
?>
