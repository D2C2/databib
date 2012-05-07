<?php

include_once('database_connection.php');

$username = $_POST['author'];
if(!empty($username)) {
	$comment = $_POST['comment'];
	$recordid =  $_POST['recordid'];
	// Lets find the editor for this record
	$query = "select rep_editors from approved where id_rep='$recordid'";
	$result = mysql_query($query);
	$row = 	 mysql_fetch_array ($result);
	$editor = $row['rep_editors'];
	
	// Lets find the name of the user
	
	$query = "select name from users where username='$username'";
	$result = mysql_query($query);
	$row = 	 mysql_fetch_array ($result);
	$authorfullname = $row['name'];
	
	echo $editor;

	$now =  date("Y-m-d H:i:s");;
	$sql = "insert into comments set comment='$comment', recordid='$recordid',
	        author='$username', approved = 'n', editor = '$editor', postdate='$now',
	        authorfullname = '$authorfullname'";
	$result = mysql_query($sql) or die(mysql_error());
}

else {
  header("HTTP/1.0 404 Not Found");
  exit();
}
  
?>