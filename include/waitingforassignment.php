<?php

include_once('database_connection.php');

//specify how many results to display per page
$limit = 1000;

$username = $fgmembersite->UserName();

$startrow_notassgn = mysql_real_escape_string(@$_REQUEST['startrow_notassgn']);
if (empty($startrow_notassgn))
$startrow_notassgn = 0;

$query = "SELECT * FROM notapproved where assignedtoeditor = 'n' ";
$numresults = mysql_query ($query) ;
$row = mysql_fetch_array ($numresults);

//store record id of every item that contains the keyword in the array we need to do this to avoid display of duplicate search result.
do{
	$adid_array[] = $row[ 'id_rep' ];
}while( $row= mysql_fetch_array($numresults));

//delete duplicate record id's from the array. To do this we will use array_unique function
$tmparr = array_unique($adid_array);
$total_num_results = count($tmparr);
for ($i = 0, $j = $startrow_notassgn; ($j < $startrow_notassgn + $limit) && ($j < $total_num_results); $j++) {
	$newarr[$i] = $tmparr[$j];
	$i++;
}

$counter = 1;

$tmp = "1";
foreach($newarr as $value){

	$query_value = "SELECT * FROM notapproved WHERE id_rep = '".$value."'";
	$num_value = mysql_query ($query_value);
	$num_of_rows = mysql_num_rows ($num_value);
	if($num_of_rows == 0 )
			echo '<i>None</i>';
	else {
		$row_linkcat = mysql_fetch_array ($num_value);
		$introcontent = strip_tags($row_linkcat[ 'rep_description']);
		$introcontent = substr($introcontent, 0, 100)."...";
		$record_id = $row_linkcat[ 'id_rep'];
		$title = $row_linkcat[ 'rep_title' ];
		$desc =   $introcontent;
		$link = $row_linkcat[ 'rep_url' ];
		$modified = $row_linkcat['rep_link_to_approved'];
		$submitter = $row_linkcat['submitter'];
		
		if($submitter == "")
		{
			$submitter = "Anonymous";
		}

		echo '<div>';
		echo $counter;
		echo '.&nbsp;&nbsp;';
		echo '<a href="viewnotassignedbyrecordid.php?record='.$record_id.'" style="color:#993300; font-size:14px">';
		echo $title;
		echo  '</a>';
		if($modified == -1)
		{
				echo "<span style=\"color:red\">- New Submission by <span style=\"color:black;font-weight:bold;\">$submitter</span> </span> ";
		}
		else
		{
				echo " <span style=\"color:green\">- Modification by <span style=\"color:black;font-weight:bold;\">$submitter</span> </span>";
		}
		echo '</div>';
		$counter++;
	}
	echo '<br/>';
}


if($total_num_results > $limit){
	if ($startrow_notassgn >= 1) {
		$prevs = ($startrow_notassgn - $limit);
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_notassgn='.$prevs.'">Previous</a>';
	}

	$slimit = $startrow_notassgn + $limit;
	if (!($slimit >= $total_num_results) && $total_num_results != 1) {
		$next = $startrow_notassgn + $limit;
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_notassgn='.$next.'">Next</a>';
	}
	echo '<br/>';
}

?>
