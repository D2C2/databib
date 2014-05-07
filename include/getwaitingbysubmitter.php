<?php

include_once('database_connection.php');

$limit_w = 5;
$username_w = $fgmembersite->UserName();
$startrow_waiting = mysql_real_escape_string(@$_REQUEST['startrow_waiting']);
if (empty($startrow_waiting))
$startrow_waiting = 0;
$query_w = "SELECT * FROM notapproved where submitter='$username_w' AND reviewed = 'n' ORDER BY rep_title ASC";
$numresults1 = mysql_query ($query_w) ;
$row_w = mysql_fetch_array($numresults1);
do{
	$adid_array_w[] = $row_w[ 'id_rep' ];
} while( $row_w = mysql_fetch_array($numresults1));
$tmparr_w = array_unique($adid_array_w);
$total_num_results_w = count($tmparr_w);
for ($i1 = 0, $j1 = $startrow_waiting; ($j1 < $startrow_waiting + $limit_w) && ($j1 < $total_num_results_w); $j1++) {
	$newarr1[$i1] = $tmparr_w[$j1];
	$i1++;
}
$counter_w = $startrow_waiting + 1;
foreach($newarr1 as $value_w){
	$query_value_w = "SELECT * FROM notapproved WHERE id_rep = '".$value_w."'";
	$num_value_w = mysql_query ($query_value_w);
	$num_of_rows_w = mysql_num_rows ($num_value_w);
	if($num_of_rows_w == 0 )
		echo '<i>None</i>';
	else {
		$row_linkcat_w = mysql_fetch_array ($num_value_w);
		$introcontent_w = strip_tags($row_linkcat_w[ 'rep_description']);
		$introcontent_w = substr($introcontent_w, 0, 100)."...";
		$record_id_w = $row_linkcat_w[ 'id_rep'];
		$title_w = $row_linkcat_w[ 'rep_title' ];
		$desc_w =   $introcontent_w;
		$link_w = $row_linkcat_w[ 'rep_url' ];
		$submission_date_w = $row_linkcat_w['submission_date'];
		
		echo '<br/>';
		echo '<div>';
		echo $counter_w;
		echo '.&nbsp;&nbsp;';
		echo '<a href="viewassignedbyrecordid.php?record='.$record_id_w.'" style="color:#993300; font-size:14px">';
		echo $title_w;
		echo  '</a><br/>';
		echo "<span class=\"tab1\"></span><span style=\"color:gray\">Submitted on $submission_date_w</span>";
		
		echo '</div>';
		$counter_w++;
	}
	echo '<br/>';

}

if($total_num_results_w > $limit_w) {
	if ($startrow_waiting >= 1) {
		$prevs_w = $startrow_waiting - $limit_w;
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		
		$get_v = $_GET;
		$get_v['startrow_waiting'] = $prevs_w;
		echo '<a href="'.$_SERVER['PHP_SELF'].'?'.http_build_query($get_v).'">Previous</a>';
	}
	$slimit_w = $startrow_waiting + $limit_w;
	if (!($slimit_w >= $total_num_results_w) && $total_num_results_w!=1) {
		$next1 = $startrow_waiting + $limit_w;
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		
		$get_v = $_GET;
		$get_v['startrow_waiting'] = $next_w;
		echo '<a href="'.$_SERVER['PHP_SELF'].'?'.http_build_query($get_v).'">Next</a>';
	}
	echo '<br/>';
}

?>
