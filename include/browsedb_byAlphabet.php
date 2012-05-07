<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once('database_connection.php');

$startrow_cat = 0;
$startrow_cat_oldval = 0;
$limit = 20;

$startrow = mysql_real_escape_string(@$_REQUEST['startrow']);
if (empty($startrow))
$startrow=0;
$query = "SELECT * FROM approved ORDER BY rep_title ASC";
$numresults = mysql_query ($query) ;
$row = mysql_fetch_array ($numresults);
do{
	$adid_array[] = $row[ 'id_rep' ];
} while( $row = mysql_fetch_array($numresults));
$tmparr = array_unique($adid_array);
$count = count($tmparr);
for ($i = 0, $j = $startrow; ($j < $startrow + $limit) && ($j < $count); $j++) {
	$newarr[$i] = $tmparr[$j];
	$i++;
}
$tmp = "1";
foreach($newarr as $value){
	$query_value = "SELECT * FROM approved WHERE id_rep = '".$value."'";
	$num_value=mysql_query ($query_value);
	$row_linkcat = mysql_fetch_array ($num_value);
	$row_num_links = mysql_num_rows ($num_value);
	if($row_num_links == 0)
		exit;
	
	$introcontent = strip_tags($row_linkcat[ 'rep_description']);
	$introcontent = substr($introcontent, 0, 100)."...";
	$record_id = $row_linkcat[ 'id_rep'];
	$title = $row_linkcat[ 'rep_title' ];
	$desc =   $introcontent;
	$link = $row_linkcat[ 'rep_url' ];
	if(substr($link, 0, 4) != "http")
		$link = "http://". $link;
	$first_letter = mb_substr($title,0,1);
	$first_letter = strtoupper($first_letter);
	if($tmp!=$first_letter){
		$tmp = $first_letter;
		$tmp = strtoupper($tmp);
		echo '<h1 style="color:#A64B00;font-size:20px" >'.$tmp.'</h1>';
		echo '<br/>';
	}
	echo '<div>';
	echo '<div>';
	echo '<a href="viewapprovedbyrecordid.php?record='.$record_id.'" style="color:#993300; font-size:14px">';
	echo $title;
	echo  '</a>';
	echo '</div>';
	echo '<div>';
	echo $desc;
	echo '</div>';
	echo '</div>';
	echo '<br/>';

}
if($count > $limit){
	if ($startrow >= 1) {
		$prevs = ($startrow - $limit);
		echo '<a href=search.php?startrow='. $prevs.'>Previous</a>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	$slimit = $startrow + $limit;
	if (!($slimit >= $count) && $count!=1) {
		$next = $startrow + $limit;
		echo '<a href=search.php?startrow='. $next.'>Next</a>';
	}
	echo '<br/>';
}

?>
