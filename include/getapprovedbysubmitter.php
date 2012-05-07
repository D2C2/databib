<?php

include_once('database_connection.php');

$limit2 = 5;
$username2 = $fgmembersite->UserName();
$startrow_approved = mysql_real_escape_string(@$_REQUEST['startrow_approved']);
if (empty($startrow_approved))
	$startrow_approved = 0;
$query2 = "SELECT * FROM approved where submitter='$username2' ORDER BY rep_title ASC";
$numresults2 = mysql_query ($query2) ;
$row2 = mysql_fetch_array ($numresults2);
do{
	$adid_array2[] = $row2[ 'id_rep' ];
} while( $row2 = mysql_fetch_array($numresults2));

$tmparr2 = array_unique($adid_array2);
$total_num_results2 = count($tmparr2);
for ($i2 = 0, $j2 = $startrow_approved; ($j2 < $startrow_approved + $limit2) && ($j2 < $total_num_results2); $j2++) {
	$newarr2[$i2] = $tmparr2[$j2];
	$i2++;
}
$counter2 = 1;
foreach($newarr2 as $value2){
	$query_value2 = "SELECT * FROM approved WHERE id_rep = '".$value2."'";
	$num_value2 = mysql_query ($query_value2);
	$num_of_rows2 = mysql_num_rows ($num_value2);
	if($num_of_rows2 == 0 )
		echo '<i>None</i>';
	else {
		$row_linkcat2 = mysql_fetch_array ($num_value2);
		$introcontent2 = strip_tags($row_linkcat2[ 'rep_description']);
		$introcontent2 = substr($introcontent2, 0, 100)."...";
		$record_id2 = $row_linkcat2[ 'id_rep'];
		$title2 = $row_linkcat2[ 'rep_title' ];
		$desc2 =   $introcontent2;
		$link2 = $row_linkcat2[ 'rep_url' ];
		echo '<br/>';
		echo '<div>';
		echo $counter2;
		echo '.&nbsp;&nbsp;';
		echo '<a href="../viewapprovedbyrecordid.php?record='.$record_id2.'" style="color:#993300; font-size:14px">';
		echo $title2;
		echo  '</a>';
		echo '</div>';
		$counter2++;
	}
	echo '<br/><br/>';
}

if($total_num_results2 > $limit2){
	if ($startrow_approved >= 1) {
		$prevs2 = $startrow_approved - $limit2;
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_approved='.$prevs2.'">Previous</a>';
	}
	$slimit2 = $startrow_approved + $limit2;
	if (!($slimit2 >= $total_num_results2) && $total_num_results2!=2) {
		$next2 = $startrow_approved + $limit2;
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_approved='.$next2.'">Next</a>';
	}
	echo '<br/>';
}
?>
