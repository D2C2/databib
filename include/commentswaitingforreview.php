<?php

include_once('database_connection.php');

$limit4 = 5;
$username4 = $fgmembersite->UserName();
$startrow_approved = mysql_real_escape_string(@$_REQUEST['startrow_approved']);
if (empty($startrow_approved))
	$startrow_approved = 0;
$query4 = "SELECT * FROM comments where editor LIKE '%$username%' AND approved ='n' ORDER BY postdate ASC";
$numresults4 = mysql_query ($query4) ;
$row4 = mysql_fetch_array ($numresults4);
do{
	$adid_array4[] = $row4[ 'id_comment' ];
} while( $row4 = mysql_fetch_array($numresults4));

$tmparr4 = array_unique($adid_array4);
$total_num_results4 = count($tmparr4);
for ($i4 = 0, $j4 = $startrow_approved; ($j4 < $startrow_approved + $limit4) && ($j4 < $total_num_results4); $j4++) {
	$newarr4[$i4] = $tmparr4[$j4];
	$i4++;
}
$counter4 = 1;
foreach($newarr4 as $value4){
	$query_value4 = "SELECT * FROM comments WHERE id_comment = '".$value4."'";
	$num_value4 = mysql_query ($query_value4);
	$num_of_rows4 = mysql_num_rows ($num_value4);
	if($num_of_rows4 == 0 )
		echo '<i>None</i>';
	else {
		$row_linkcat4 = mysql_fetch_array ($num_value4);
		$introcontent4 = strip_tags($row_linkcat4[ 'comment']);
		$introcontent4 = substr($introcontent4, 0, 75)."...";
		$record_id4 = $row_linkcat4[ 'recordid'];
		$author = $row_linkcat4[ 'authorfullname'];
		
		$sql = "select rep_title from approved where id_rep = '$record_id4'";
		$result = mysql_query ($sql);
		$row = mysql_fetch_array ($result);
		$title4 = $row['rep_title'];
		
		$desc4 =   $introcontent4;
	
		echo '<br/>';
		echo '<div>';
		echo $counter4;
		echo '.&nbsp;&nbsp;'. $author. ' commented on ';
		echo '<a href="../approvecommentsbyrecordid.php?record='.$record_id4.'" style="color:#993300; font-size:14px">';
		echo $title4;
		echo  '</a>';
		echo '<br/>';
		echo '<p style="margin-left:22px";>"'.$introcontent4.'"</p>';
		echo '</div>';
		$counter4++;
	}
	
}

if($total_num_results4 > $limit4){
	if ($startrow_approved >= 1) {
		$prevs4 = $startrow_approved - $limit4;
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_approved='.$prevs4.'">Previous</a>';
	}
	$slimit4 = $startrow_approved + $limit4;
	if (!($slimit4 >= $total_num_results4) && $total_num_results4!=4) {
		$next4 = $startrow_approved + $limit4;
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_approved='.$next4.'">Next</a>';
	}
	echo '<br/>';
}
?>


