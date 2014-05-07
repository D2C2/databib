	<?php
	include_once('database_connection.php');
	//specify how many results to display per page
	$limit = 5;
	
	$username = $fgmembersite->UserName();
	$startrow_notreview = mysql_real_escape_string(@$_REQUEST['startrow_notreview']);
	if (empty($startrow_notreview))
		$startrow_notreview = 0;
	$query = "SELECT * FROM notapproved where rep_editors LIKE '%$username%' AND reviewed = 'n' ORDER BY id_rep ASC";
	$numresults = mysql_query ($query) ;
	$row = mysql_fetch_array ($numresults);
	do{
		$adid_array[] = $row[ 'id_rep' ];
	}while( $row= mysql_fetch_array($numresults));
	$tmparr = array_unique($adid_array);
	$total_num_results = count($tmparr);
	for ($i = 0, $j = $startrow_notreview; ($j < $startrow_notreview + $limit) && ($j < $total_num_results); $j++) {
		$newarr[$i] = $tmparr[$j];
		$i++;
	}
	
	$counter = 1 + $startrow_notreview;
	foreach($newarr as $value){
	
			$query_value = "SELECT * FROM notapproved WHERE id_rep = '".$value."'";
			$num_value = mysql_query ($query_value);
			$num_of_rows = mysql_num_rows ($num_value);
			if($num_of_rows == 0 )
				echo '<i>None</i>';
			else {
				
				$row_linkcat= mysql_fetch_array ($num_value);
				$introcontent = strip_tags($row_linkcat[ 'rep_description']);
				$introcontent = substr($introcontent, 0, 100)."...";
				$record_id = $row_linkcat[ 'id_rep'];
				$title = $row_linkcat[ 'rep_title' ];
				$desc =   $introcontent;
				$link = $row_linkcat[ 'rep_url' ];
				$modified = $row_linkcat['rep_link_to_approved'];
				$submitter = $row_linkcat['submitter'];
				$submission_date = $row_linkcat['submission_date'];
				
				if($submitter == "")
				{
					$submitter = "Anonymous";
				}
	
				echo '<div>';
				echo $counter;
				echo '.&nbsp;&nbsp;';
				
				echo '<a href="viewnotapprovedbyrecordid.php?record='.$record_id.'" style="color:#993300; font-size:14px">';
				echo $title;
				echo  '</a><br/>';
				if($modified == -1)
				{
							echo "<span class=\"tab1\"></span><span style=\"color:red\">New Submission by <span style=\"color:black;font-weight:bold;\">$submitter</span> </span> ";
				}
				else
				{
							echo "<span class=\"tab1\"></span><span style=\"color:green\">Modification by <span style=\"color:black;font-weight:bold;\">$submitter</span> </span>";
				}
				echo " <span style=\"color:gray\">$submission_date</span>";
				
				echo '</div>';
				$counter++;
			}
			echo '<br/>';
			
	
		}  //end foreach $newarr
	
		if($total_num_results > $limit){
		if ($startrow_notreview >= 1) {
			$prevs = ($startrow_notreview - $limit);
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';

			$get_v = $_GET;
			$get_v['startrow_notreview'] = $prevs;
			echo '<a href="'.$_SERVER['PHP_SELF'].'?'.http_build_query($get_v).'">Previous</a>';
		}
	
		$slimit = $startrow_notreview + $limit;
		if (!($slimit >= $total_num_results) && $total_num_results != 1) {
			$next = $startrow_notreview + $limit;
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';

			$get_v = $_GET;
			$get_v['startrow_notreview'] = $next;
			echo '<a href="'.$_SERVER['PHP_SELF'].'?'.http_build_query($get_v).'">Next</a>';
		}
		echo '<br/>';
	}
	
	?>
	
