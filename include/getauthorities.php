<?PHP
include_once('database_connection.php');

$q = strtolower($_GET["term"]);

if (!$q) return;

$sql = "select id_authority, auth_name from authorities where auth_name like '%$q%' LIMIT 0, 20 ";
mysql_query("set names 'utf8'");
$result = mysql_query($sql)  or die(mysql_error());

if (!$result) {
    echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    exit;
}

if (mysql_num_rows($result) == 0) {
	$rows = array();
	
	echo json_encode($rows);
	exit;
}

$rows = array();

while ($row = mysql_fetch_array($result)) {
	$auth_utf = utf8_encode($row[1]);
	$rows[] = array ( "id" => $row[0] , "label" => $auth_utf, "value" => $auth_utf ); 
	
}
echo json_encode($rows);

?>