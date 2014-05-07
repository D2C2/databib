<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

include_once('database_connection.php');

require_once ( "sphinx/api/sphinxapi.php" );

$cl = new SphinxClient ();

$sphinx_hostname = "localhost";

$limit = 15;
$n_per_sections = 9;
$port = 9312;
$index = "*";
//$mode = SPH_MATCH_ANY;
$mode = SPH_MATCH_EXTENDED;
$groupby = "";
$groupsort = "@group desc";
$filtervals = array();
$filter = "group_id";
$distinct = "";
$sortby = "";
$sortexpr = "";
$ranker = SPH_RANK_PROXIMITY_BM25;
$ranker = SPH_RANK_FIELDMASK;
$select = "";
$startrow = intval(mysql_real_escape_string(@$_REQUEST['startrow']));
$startrow = (int)(floor($startrow / $limit) * $limit); // makes sure that startrow must be multiples of limit to avoid bugs
////////////
// do query
////////////

$query = str_replace(" and ", " & ", $query);
$query = str_replace(" or ", " | ", $query);
$query = str_replace(" not ", " -", $query);

$cl->SetMatchMode ( $mode );
$cl->SetServer ( $sphinx_hostname, $port );
$cl->SetConnectTimeout ( 1 );
$cl->SetArrayResult ( true );
#$cl->SetWeights ( array(100, 1) );
if ( count($filtervals) )	$cl->SetFilter ( $filter, $filtervals );
if ( $groupby )				$cl->SetGroupBy ( $groupby, SPH_GROUPBY_ATTR, $groupsort );
if ( $sortby )				$cl->SetSortMode ( SPH_SORT_EXTENDED, $sortby );
if ( $sortexpr )			$cl->SetSortMode ( SPH_SORT_EXPR, $sortexpr );
if ( $distinct )			$cl->SetGroupDistinct ( $distinct );
if ( $select )				$cl->SetSelect ( $select );
if ( $limit )				$cl->SetLimits ( $startrow, $limit, ( $limit>1000 ) ? $limit : 1000 );


$cl->SetRankingMode ( $ranker );
$cl->SetFieldWeights ( array('title' => 100, 'authority'=>1, 'description'=>4, 'location'=>1, 'subjects'=>50, 'classification'=>20 ) );

$res = $cl->Query ( $query, $index );

echo "<div id=\"results_div\" name=\"results_div\">";

if ( $res===false )
{
	print "<br/><p>Query failed: " . $cl->GetLastError() . ".</p>";

} else
{

}

//Display a message if no results found
$count = $res["total"];

if($count == 0){
	$resultmsg = "<br/><p>Search results for: ". $display_query ."</p><p>Sorry, your search returned zero results</p>" ;
	echo $resultmsg;
}
else {
	$i = 0;
	foreach ( $res["matches"] as $docinfo )	{
		if($i < $limit) {
			$newarr[$i] = $docinfo["id"];
			$i++;
		}
		else break;
	}
	echo "<br/><p>Search results for: <strong>" . $display_query."</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "Total number of results: <strong>" . $count."</strong>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "Showing results: <strong>" . ($startrow+1) . "-" . ($startrow+$i) . "</strong></p>";
	echo "<br/>";
	
	foreach($newarr as $value){
		
		$query_value = "SELECT * FROM approved WHERE id_rep = '".$value."'";
		$num_value = mysql_query ($query_value);
		$row_linkcat = mysql_fetch_array ($num_value);
		$row_num_links = mysql_num_rows ($num_value);
		if($row_num_links == 0) continue;
		
		//create summary of the long text. For example if the field2 is your full text grab only first 130 characters of it for the result
		$introcontent = strip_tags($row_linkcat[ 'rep_description']);
		$introcontent = substr($introcontent, 0, 100)."...";
		$record_id = $row_linkcat[ 'id_rep'];
		$title = preg_replace ( "'($query)'si" , "<strong>\\1</strong>" , $row_linkcat[ 'rep_title' ] );
		$desc = preg_replace ( "'($query)'si" , "<strong>\\1</strong>" , $introcontent);
		$link =  $row_linkcat[ 'rep_url' ] ;
		if(substr($link, 0, 4) != "http")
			$link = "http://". $link;

		echo '<div>';
		echo '<div>';
		echo '<a href="repository/'.$record_id.'" style="color:#993300; font-size:14px">';
		echo $title;
		echo  '</a>';
		echo "</div>\n";
		
		echo '<div>';
		echo $desc;
		echo "</div>\n";
		echo "</div>\n";
		echo '<br/><br/>';

	}
	if($count > $limit){
		echo "<br><br>";
		//echo '<p style="text-align: center;">';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		if ($startrow >= 1) { 
			$prevs = max( $startrow - $limit, 0);
			echo '<a href="'. $_SERVER['PHP_SELF'] . '?startrow=0&query='.$query.'&display_query=' . $display_query. '"><< First</a>';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '<a href="'. $_SERVER['PHP_SELF'].'?startrow='.$prevs.'&query='.$query.'&display_query=' . $display_query. '">< Previous</a>';
			echo "&nbsp;&nbsp;&nbsp;&nbsp;\n";
		} else {
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
		}
		
		$rem = $startrow % ($n_per_sections * $limit);
		$sections = (int) ($startrow / ($n_per_sections * $limit));
		$start_ind = $sections * $n_per_sections;
		$ind = $start_ind + (int)($rem / $limit);
		$max_ind = floor(($count-1) / $limit);
		$start_ind = max($ind - round($n_per_sections/2), 0);
		$end_ind = min($start_ind + $n_per_sections, $max_ind);
	
	
		for ($counter = $start_ind; $counter <= $end_ind; $counter++) {
			$nextrow = $counter * $limit;
			if ( $counter == $ind ) {
				echo '<a href="'. $_SERVER['PHP_SELF'] . '?startrow='. $nextrow . '&query='.$query.'&display_query=' . $display_query. '"><b>' . ($counter+1) . '</b></a>';
			} else {
				echo '<a href="'. $_SERVER['PHP_SELF'] . '?startrow='. $nextrow . '&query='.$query.'&display_query=' . $display_query. '">' . ($counter+1) . '</a>';
			}
			echo "&nbsp;&nbsp;&nbsp;&nbsp;\n";
		}
		
		$slimit = $startrow + $limit;
		if (!($slimit >= $count) && $count!=1) {
			$next = $startrow + $limit;
			echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.$next.'&query='.$query.'&display_query=' . $display_query. '">Next ></a>';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';
			$last = $max_ind * $limit;
			echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow=' . $last . '&query='.$query. '&display_query=' . $display_query. '">Last >></a>';
		}
		//echo '</p>';
		echo '<br/>';
	}
}

echo "</div>";
?>
















