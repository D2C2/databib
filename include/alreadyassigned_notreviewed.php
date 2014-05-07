<?php

include_once('database_connection.php');

//specify how many results to display per page
$limit1 = 1000;

$username1 = $fgmembersite->UserName();
$startrow_notreviewed = mysql_real_escape_string(@$_REQUEST['startrow_notreviewed']);
if (empty($startrow_notreviewed))
$startrow_notreviewed = 0;
$query1 = "SELECT * FROM notapproved where assignedtoeditor='y' and reviewed ='n' ORDER BY rep_title ASC";
$numresults1 = mysql_query ($query1) ;
$row1 = mysql_fetch_array($numresults1);
do{
	$adid_array1[] = $row1[ 'id_rep' ];
} while( $row1 = mysql_fetch_array($numresults1));
$tmparr1 = array_unique($adid_array1);
$total_num_results1 = count($tmparr1);
for ($i1 = 0, $j1 = $startrow_notreviewed; ($j1 < $startrow_notreviewed + $limit1) && ($j1 < $total_num_results1); $j1++) {
	$newarr1[$i1] = $tmparr1[$j1];
	$i1++;
}
$counter1 = 1;
foreach($newarr1 as $value1) {

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
		$editors1 = $row_linkcat1[ 'rep_editors' ];
		$desc1 =   $introcontent1;
		$link1 = $row_linkcat1[ 'rep_url' ];
		$submission_date1 = $row_linkcat1['submission_date'];
		$assignment_date1 = $row_linkcat1['assignment_date'];
		
		echo '<br/>';
		echo '<div>';
		echo $counter1;
		echo '.&nbsp;&nbsp;';
		echo '<a href="viewassignedbyrecordid.php?record='.$record_id1.'" style="color:#993300; font-size:14px">';
		echo $title1;
		echo  '</a><br/>';
		echo "<span class=\"tab1\"></span><span style=\"color:gray\">Submitted on $submission_date1</span><br/>";
		echo "<span class=\"tab1\"></span><span style=\"color:gray\">Assigned on $assignment_date1 to ";
		echo "<a href=\"viewassignedbyeditor.php?editor=$editors1\" style=\"color:#993300; font-size:14px\"><span style=\"color:black;font-weight:bold;\">$editors1</span></a></span>";
		
		echo '</div>';
		$counter1++;
	}
	//echo '<br/>';

}
if($total_num_results1 > $limit1){
	if ($startrow_notreviewed >= 1) {
		$prevs1 = ($startrow_notreviewed - $limit1);
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_notreviewed='.$prevs1.'">Previous</a>';
	}
	$slimit1 = $startrow_notreviewed + $limit1;
	if (!($slimit1 >= $total_num_results1) && $total_num_results1 != 1) {
		$next1 = $startrow_notreviewed + $limit1;
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_notreviewed='.$next1.'">Next</a>';
	}
	echo '<br/>';
}

?>
