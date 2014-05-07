<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once('database_connection.php');


$limit = 20;
$n_per_sections = 9;

if(isset($_REQUEST['startrow'])) {
	$startrow = trim(mysql_real_escape_string($_REQUEST['startrow']));
	$startrow = (int)($startrow /$limit) * $limit;
} else {
	$startrow = 0;
}

$is_char = isset($_REQUEST['ch']);
if($is_char)
	$char = mb_substr(trim(mysql_real_escape_string($_REQUEST['ch'])), 0, 1);

if(isset($startrow) &&  $startrow== -1)
{
	header( 'Location: browse_all.php' );
	exit;
}

include_once('database_connection.php');

$startrow_cat = 0;
$startrow_cat_oldval = 0;



$query = "SELECT id_rep FROM approved " . ($is_char ? "WHERE rep_title LIKE '$char%' " : "") . "ORDER BY rep_title ASC";

$result = mysql_query ($query) ;
$num_rows = mysql_num_rows($result);
while($row = mysql_fetch_array ($result)) {
	$adid_array[] = $row[ 'id_rep' ];
}
if($num_rows > 0) {
$tmparr = array_unique($adid_array);
$count = count($tmparr);

if($startrow > $count) {
$startrow = (int)(($count-1) / $limit) * $limit;
}

for ($i = 0, $j = $startrow; ($j < $startrow + $limit) && ($j < $count); $j++) {
	$newarr[$i] = $tmparr[$j];
	$i++;
}
	
$tmp = "1";
$ite = 1;
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
	
	if($tmp!=$first_letter || $ite == 1){
		$tmp = $first_letter;
		$tmp = strtoupper($tmp);
		echo '<h1 style="color:#A64B00;font-size:20px" >'.$tmp.'</h1>';
		echo '<br/>';
	}
	
	$ite = $ite + 1;
	
	echo '<div>';
	echo '<div>';
	echo "<a href='repository/$record_id' style='color:#993300; font-size:14px' title='$title'>";
	echo "<span class=\"notranslate\">\n";
	echo $title;
	echo  "\n</span></a>\n";
	echo "</div>\n";
	echo '<div>';
	echo $desc;
	echo '</div>';
	echo '</div>';
	echo '<br/>';

}
if($count > $limit){
	echo "<br><br>";
	//echo '<p style="text-align: center;">';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;';
	if ($startrow >= 1) {
		$prevs = ($startrow - $limit);
		echo '<a href="index.php?startrow=0"><< First</a>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<a href="index.php?startrow='. $prevs.'">< Previous</a>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	} else {
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	
	//echo '<a href="search.php?startrow=-1">All</a>';
	//echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	$rem = $startrow % ($n_per_sections * $limit);
	$sections = (int) ($startrow / ($n_per_sections * $limit));
	$start_ind = $sections * $n_per_sections;
	$ind = $start_ind + (int)($rem / $limit);
	$max_ind = floor($count / $limit);
	$start_ind = max($ind - round($n_per_sections/2), 0);
	$end_ind = min($start_ind + $n_per_sections, $max_ind);
	
	for ($counter = $start_ind; $counter <= $end_ind; $counter++) {
		$nextrow = $counter * $limit;
		if ( $counter == $ind ) {
			echo '<a href="index.php?startrow='. $nextrow. ($is_char ? "&ch=$char" : '') . '"><b>' . ($counter+1) . '</b></a>';
		} else {
			echo '<a href="index.php?startrow='. $nextrow. ($is_char ? "&ch=$char" : '') . '">' . ($counter+1) . '</a>';
		}
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	
	echo '&nbsp;&nbsp;&nbsp;&nbsp;';
	$slimit = $startrow + $limit;
	if (!($slimit >= $count) && $count!=1) {
		$next = $startrow + $limit;		
		echo '<a href="index.php?startrow='. $next. ($is_char ? "&ch=$char" : '') . '">Next ></a>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$last = $max_ind * $limit;
		echo '<a href="index.php?startrow=' . $last . '">Last >></a>';
	}
	
	//echo '</p>';
	// for(;$i < $limit; $i++) {
		// echo '<br/><br/>';
	// }
	echo '<br/>';
}
} else {
	echo '<h1 style="color:#A64B00;font-size:20px" >'.$char.'</h1>';
	echo '<br> No results found.</br>';
	echo '<br/><br/><br/><br/><br/>';
}
?>