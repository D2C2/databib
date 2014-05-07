<?php
//require_once("membersite_config.php");
//$fgmembersite->CheckLogin();

include_once('database_connection.php');
$is_force = mysql_real_escape_string(@$_REQUEST['force']);

$sql = "select id_rep, rep_url from approved order by id_rep desc";
$result = mysql_query($sql) or die(mysql_error());
echo "Generating...<br/>";
ob_flush(); 
flush();
usleep(50000);
			
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$url = $row['rep_url'];
	$img_path = '/var/www/html/databib/Knplabs/Snappy/' . $row['id_rep'] . '.jpg';

	if ($is_force || !file_exists($img_path)) {
		try {
			$line = $row['id_rep'] . " : " . $url . "<br/>";
			echo "Processing " . $line;
			ob_flush(); 
			flush();
			usleep(50000);
			include("gen_snap.php"); 
		} catch (Exception $e) {
			echo " (FAILED) " . $line;
		}
	} else {
		//break;
	}
}

echo "<br/>DONE generating the thumbnails.<br/>";

?>

