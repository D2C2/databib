<?php

include_once('database_connection.php');


$limit = 15;
$var = mysql_real_escape_string(@$_REQUEST['query']);
$startrow = mysql_real_escape_string(@$_REQUEST['startrow']);
if (empty($startrow))
	$startrow=0;

//trim whitespace from the stored variable
$trimmed = trim($var);
//separate key-phrases into keywords
$trimmed_array = explode(" ",$trimmed);
// check for an empty string and display a message.
if ($trimmed == "") {
	$resultmsg =  "<br/><p>Search Error</p><p>Please enter a search...</p>" ;
}
// check for a search parameter
if (!isset($var)){
	$resultmsg =  "<p>Search Error</p><p>We don't seem to have a search parameter! </p>" ;
}

$total_num_results = 0 ;

foreach ($trimmed_array as $trimm) {
	
	
	/*$query = "SELECT *, MATCH (rep_title, rep_description) AGAINST ('$trimm')
	AS score FROM approved WHERE MATCH(rep_title, rep_description) AGAINST('$trimm') ORDER BY score DESC ";
	$numresults = mysql_query ($query) ;
	$num_results_fulltext = mysql_num_rows ($numresults);
	
	$num_results_without_fulltext = 0;
	//If MATCH query doesn't return any results due to how it works do a search using LIKE
	if($num_results_fulltext < 1) {
		$query = "SELECT * FROM approved WHERE rep_title LIKE '%$trimm%' OR rep_description LIKE '%$trimm%'";
		$numresults = mysql_query ($query, $connection);
		$num_results_without_fulltext = mysql_num_rows ($numresults);
	}

	$total_num_results +=  $num_results_fulltext + $num_results_without_fulltext;*/

	$query = "SELECT * FROM approved WHERE rep_title LIKE '%$trimm%' OR rep_description LIKE '%$trimm%'";
	$numresults = mysql_query ($query, $connection);
	$num_results_without_fulltext = mysql_num_rows ($numresults);
	$total_num_results +=  $num_results_without_fulltext;

	$numresults = mysql_query ($query) ;
	$row = mysql_fetch_array ($numresults);

	//store record id of every item that contains the keyword in the array we need to do this to avoid display of duplicate search result.
	do {
		$adid_array[] = $row[ 'id_rep' ];
	} while( $row= mysql_fetch_array($numresults));
}

//Display a message if no results found
if($num_results_fulltext == 0 && $num_results_without_fulltext == 0){
	$resultmsg = "<br/><p>Search results for: ". $trimmed."</p><p>Sorry, your search returned zero results</p>" ;
}

//delete duplicate record id's from the array. To do this we will use array_unique function
$tmparr = array_unique($adid_array);
$count = count($tmparr);
for ($i = 0, $j = $startrow; ($j < $startrow + $limit) && ($j < $count); $j++) {
	$newarr[$i] = $tmparr[$j];
	$i++;
}

// now you can display the results returned. But first we will display the search form on the top of the page
echo ' <form name="search_bar" method="get" action="search_results.php">
   <div style="width:700px; cellpadding:15px;">
       <span style="font: 14px arial;">Search</span>&nbsp;
         <input type="text" name="query" style="width:300px; height:22px;" autofocus> 
         </input> 
         &nbsp;&nbsp;
         <input type="submit" name="Submit" style="width:45px; height:26px;" 
           value="Find">
         
         </input>
         &nbsp;&nbsp;&nbsp;&nbsp;
<!--         <a href="advanced_search.php"> Advanced Search</a> -->

   </div>
  </form>';

$num_iter = 0;

if( isset ($resultmsg)) {
	echo $resultmsg;
} else {
	echo "<br/><p>Search results for: <strong>" . $var."</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "Total number of results: <strong>" . $total_num_results."</strong></p>";
	foreach($newarr as $value){
		if($num_iter < $limit)
			$num_iter++;
		else 
			break;
		$query_value = "SELECT * FROM approved WHERE id_rep = '".$value."'";
		$num_value = mysql_query ($query_value);
		$row_linkcat = mysql_fetch_array ($num_value);
		$row_num_links = mysql_num_rows ($num_value);
		
		//create summary of the long text. For example if the field2 is your full text grab only first 130 characters of it for the result
		$introcontent = strip_tags($row_linkcat[ 'rep_description']);
		$introcontent = substr($introcontent, 0, 100)."...";
		$record_id = $row_linkcat[ 'id_rep'];
		$title = preg_replace ( "'($var)'si" , "<strong>\\1</strong>" , $row_linkcat[ 'rep_title' ] );
		$desc = preg_replace ( "'($var)'si" , "<strong>\\1</strong>" , $introcontent);
		$link =  $row_linkcat[ 'rep_url' ] ;
		if(substr($link, 0, 4) != "http")
			$link = "http://". $link;
		foreach($trimmed_array as $trimm){
			if($trimm != 'b' ){
				//$title = preg_replace( "'($trimm)'si" ,  "<strong>\\1</strong>" , $title);
				$desc = preg_replace( "'($trimm)'si" , "<strong>\\1</strong>" , $desc);
			}
		}//end foreach $trimmed_array
		echo '<div>';
		echo '<div>';
		echo '<a href="repository/'.$record_id.'" style="color:#993300; font-size:14px">';
		echo $title;
		echo  '</a>';
		echo '</div>';
		
		echo '<div>';
		echo $desc;
		echo '</div>';
		echo '</div>';
		echo '<br/><br/>';

	}
	if($total_num_results > $limit){
		if ($startrow >= 1) { 
			$prevs = ( $startrow - $limit);
			echo '<a href="'. $_SERVER['PHP_SELF'].'?startrow='.$prevs.'&query='.$var.'">Previous</a>';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		
		}
		if (!(($startrow + $limit) >= $total_num_results) && $total_num_results!=1) {
			$next = $startrow + $limit;
			echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.$next.'&query='.$var.'">Next</a>';
		}
		echo '<br/>';
	}
}
?>
