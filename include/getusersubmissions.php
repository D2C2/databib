

<?php
include_once('database_connection.php');

$startrow_cat = 0;
$startrow_cat_oldval = 0;
$limit = 20;

$startrow = mysql_real_escape_string(@$_REQUEST['startrow']);
if (empty($startrow))
	$startrow=0;

$username = mysql_real_escape_string(@$_REQUEST['userchoice']);	
$query = "SELECT * FROM approved where submitter LIKE '%$username%' ORDER BY rep_title ASC";
$numresults = mysql_query ($query) ;
$total_submissions = mysql_num_rows ($numresults);
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
$counter = 1 + $startrow;
foreach($newarr as $value){
	$query_value = "SELECT * FROM approved WHERE id_rep = '".$value."'";
	$num_value=mysql_query ($query_value);
	$row_linkcat = mysql_fetch_array ($num_value);
	$num_of_rows = mysql_num_rows ($num_value);
	if($num_of_rows == 0 )
		echo '<i>None</i>';
	else {
		echo "Total number of submissions: <strong>" . $total_submissions."</strong></p>";
		$introcontent = strip_tags($row_linkcat[ 'rep_description']);
		$introcontent = substr($introcontent, 0, 100)."...";
		$record_id = $row_linkcat[ 'id_rep'];
		$title = $row_linkcat[ 'rep_title' ];
		$desc =   $introcontent;
		$link = $row_linkcat[ 'rep_url' ];
		if(substr($link, 0, 4) != "http")
		$link = "http://". $link;
		echo '<div>';
		echo $counter;
		echo '&nbsp;&nbsp;';
		echo '<a href="viewapprovedbyrecordid.php?record='.$record_id.'" style="color:#993300; font-size:14px">';
		echo $title;
		echo  '</a>';

		//echo '<div>';
		//echo '<a href="'.$link.'">';
		//echo $link;
		//echo '</a></div>';
		echo '<br/>&nbsp;&nbsp;';
		echo $desc;
		echo '</div>';
		$counter++;
	}
	echo '<br/><br/>';

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


