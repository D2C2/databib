<?php
require_once("config.php");

$hostname_logon = $database_hostname;
$database_logon = $database_name;
$username_logon = $database_username;
$password_logon = $database_password;
//open database connection
$connection = mysql_connect($hostname_logon, $username_logon, $password_logon) 
or die ( "Unable to connect to the database" );
//select database
mysql_select_db($database_logon) or die ( "Unable to select database!" );
?>
