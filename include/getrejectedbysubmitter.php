<?php

include_once('database_connection.php');

$limit1 = 5;
$username1 = $fgmembersite->UserName();
$startrow_rejected = mysql_real_escape_string(@$_REQUEST['startrow_rejected']);
if (empty($startrow_rejected))
$startrow_rejected = 0;
$query1 = "SELECT * FROM notapproved where submitter='$username1' AND reviewed = 'y' ORDER BY rep_title ASC";
$numresults1 = mysql_query ($query1) ;
$row1 = mysql_fetch_array($numresults1);
do{
	$adid_array1[] = $row1[ 'id_rep' ];
} while( $row1 = mysql_fetch_array($numresults1));
$tmparr1 = array_unique($adid_array1);
$total_num_results1 = count($tmparr1);
for ($i1 = 0, $j1 = $startrow_rejected; ($j1 < $startrow_rejected + $limit1) && ($j1 < $total_num_results1); $j1++) {
	$newarr1[$i1] = $tmparr1[$j1];
	$i1++;
}
$counter1 = 1;
foreach($newarr1 as $value1){
	$query_value1 = "SELECT * FROM notapproved WHERE id_rep = '".$value1."'";
	$num_value1 = mysql_query ($query_value1);
	$num_of_rows1 = mysql_num_rows ($num_value1);
	if($num_of_rows1 == 0 )
		echo '<i>None</i>';
	else {
		$row_linkcat1 = mysql_fetch_array ($num_value1);
		$introcontent1 = strip_tags($row_linkcat1[ 'rep_description']);
		$introcontent1 = substr($introcontent1, 0, 100)."...";
		$record_id1 = $row_linkcat1[ 'id_rep'];
		$title1 = $row_linkcat1[ 'rep_title' ];
		$desc1 =   $introcontent1;
		$link1 = $row_linkcat1[ 'rep_url' ];
		echo '<br/>';
		echo '<div>';
		echo $counter1;
		echo '.&nbsp;&nbsp;';
		echo '<a href="viewrejectedbyrecordid.php?record='.$record_id1.'" style="color:#993300; font-size:14px">';
		echo $title1;
		echo  '</a>';
		echo '</div>';
		$counter1++;
	}
	echo '<br/><br/>';

}

if($total_num_results1 > $limit1) {
	if ($startrow_rejected >= 1) {
		$prevs1 = $startrow_rejected - $limit1;
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_rejected='.$prevs1.'">Previous</a>';
	}
	$slimit1 = $startrow_rejected + $limit1;
	if (!($slimit1 >= $total_num_results1) && $total_num_results1!=1) {
		$next1 = $startrow_rejected + $limit1;
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_rejected='.$next1.'">Next</a>';
	}
	echo '<br/>';
}

?>
