<?php

include_once('database_connection.php');

$limit = 10;

// get the search variable from URL
$var1 = mysql_real_escape_string(@$_REQUEST['query1']);
$var2 = mysql_real_escape_string(@$_REQUEST['query2']);
$var3 = mysql_real_escape_string(@$_REQUEST['query3']);

$search_cat1_val = mysql_real_escape_string(@$_REQUEST['search_cat1']);
$search_cat2_val = mysql_real_escape_string(@$_REQUEST['search_cat2']);
$search_cat3_val = mysql_real_escape_string(@$_REQUEST['search_cat3']);

$search_cat1 = "";
$search_cat2 = "";
$search_cat3 = "";

if (!empty($search_cat1_val)){
	switch ($search_cat1_val) {
		case -1:
			$search_cat1 = "All";
			break;
		case 1:
			$search_cat1 = "rep_title";
			break;
		case 2:
			$search_cat1 = "rep_description";
			break;
		case 3:
			$search_cat1 = "rep_authority";
			break;
		case 4:
			$search_cat1 = "rep_subject";
			break;
		case 5:
			$search_cat1 = "rep_access";
			break;
	}
}


if (!empty($search_cat2_val)){
	switch ($search_cat2_val) {
		case -1:
			$search_cat2 = "All";
			break;
		case 1:
			$search_cat2 = "rep_title";
			break;
		case 2:
			$search_cat2 = "rep_description";
			break;
		case 3:
			$search_cat2 = "rep_authority";
			break;
		case 4:
			$search_cat2 = "rep_subject";
			break;
		case 5:
			$search_cat2 = "rep_access";
			break;
	}
}

if (!empty($search_cat3_val)){
	switch ($search_cat3_val) {
		case -1:
			$search_cat3 = "All";
			break;
		case 1:
			$search_cat3 = "rep_title";
			break;
		case 2:
			$search_cat3 = "rep_description";
			break;
		case 3:
			$search_cat3 = "rep_authority";
			break;
		case 4:
			$search_cat3 = "rep_subject";
			break;
		case 5:
			$search_cat3 = "rep_access";
			break;
	}
}


$boolean1 = "";
$boolean2 = "";
$boolean1_val = mysql_real_escape_string(@$_REQUEST['boolean_cat1']);
$boolean2_val = mysql_real_escape_string(@$_REQUEST['boolean_cat2']);

// check for a search parameter
if (!empty($boolean1_val)){
	switch ($boolean1_val) {
		case 1:
			$boolean1 = "AND";
			break;
		case 2:
			$boolean1 = "OR";
			break;
		case 3:
			$boolean1 = "NOT";
			break;
	}
}

if (!empty($boolean2_val)){
	switch ($boolean2_val) {
		case 1:
			$boolean2 = "AND";
			break;
		case 2:
			$boolean2 = "OR";
			break;
		case 3:
			$boolean2 = "NOT";
			break;
	}
}

//get pagination
$s = mysql_real_escape_string(@$_REQUEST['s']);

//trim whitespace from the stored variable
$trimmed1 = trim($var1);
$trimmed2 = trim($var2);
$trimmed3 = trim($var3);

//separate key-phrases into keywords
$trimmed_array1 = explode(" ",$trimmed1);
$trimmed_array2 = explode(" ",$trimmed2);
$trimmed_array3 = explode(" ",$trimmed3);
$adid_array1 = array();
$adid_array2 = array();
$adid_array3 = array();

// check for an empty string and display a message.
if ($trimmed1 == "" && $trimmed2 == "" && $trimmed3 == "") {
	$resultmsg = "<br/><p>Search Error</p><p>Please enter a search...</p>" ;
}

// check for a search parameter
if (!isset($var1) && !isset($var2) && !isset($var3) ){
	$resultmsg =  "<p>Search Error</p><p>We don't seem to have a search parameter! </p>" ;
}

// check for categories
if (empty($search_cat1) && empty($search_cat2) && empty($search_cat3) ){
	$resultmsg =  "<p>Search Error</p><p>We don't seem to have a category! </p>" ;
}

foreach ($trimmed_array1 as $trimm) {
	if($search_cat1 == "All") {
		 //remove subjects from here
		$query = "SELECT * FROM approved WHERE rep_title LIKE '%$trimm%' OR 
				  rep_description LIKE '%$trimm%' OR
				  rep_authority LIKE '%$trimm%' OR
				  rep_access LIKE '%$trimm%' ";
				  
		$query2 = "SELECT sub.id_record from ((select id_record, sub_title FROM subject_record_assoc_approved natural join subjects) As sub ) where sub.sub_title LIKE'%$trimm%' ";
		
	}
	else {
			if($search_cat1 == "rep_subject")
			{
				$query2 = "SELECT sub.id_record from ((select id_record, sub_title FROM subject_record_assoc_approved natural join subjects) As sub ) where sub.sub_title LIKE '%$trimm%' ";
			}
			else
				$query = "SELECT * FROM approved WHERE $search_cat1 LIKE '%$trimm%'" ;
		}
		
	if(isset($query))
	{
		$numresults = mysql_query ($query, $connection);
		$row = mysql_fetch_array ($numresults);
		do {
			$adid_array1[] = $row[ 'id_rep' ];
		} while( $row= mysql_fetch_array($numresults));
	}
	
	if(isset($query2))
	{
			$numresults = mysql_query ($query2, $connection);
			$row = mysql_fetch_array ($numresults);
			do {
				$adid_array1[] = $row[ 'id_record' ];
			} while( $row= mysql_fetch_array($numresults));
	}
}

$tmparr1 = array_unique($adid_array1);

$i=0;
foreach ($tmparr1 as $v) {
	$newarr1[$i] = $v;
	$i++;
}

if(!empty($search_cat2) && !empty($boolean1) && !empty($trimmed2)) {
	foreach ($trimmed_array2 as $trimm) {
		if($search_cat2 == "All") //remove subjects from here
		{
				$query = "SELECT * FROM approved WHERE rep_title LIKE '%$trimm%' OR 
				  rep_description LIKE '%$trimm%' OR
				  rep_authority LIKE '%$trimm%' OR
				  rep_access LIKE '%$trimm%' ";
				 
				 $query2 = "SELECT sub.id_record from ((select id_record, sub_title FROM subject_record_assoc_approved natural join subjects) As sub ) where sub.sub_title LIKE '%$trimm%' ";
		}
		else 
		{
			if($search_cat2 == "rep_subject")
				$query2 = "SELECT sub.id_record from ((select id_record, sub_title FROM subject_record_assoc_approved natural join subjects) As sub ) where sub.sub_title LIKE '%$trimm%' ";
			else
				$query = "SELECT * FROM approved WHERE $search_cat2 LIKE '%$trimm%'" ;
		}
				
		if(isset($query))
		{
			$numresults = mysql_query ($query, $connection);
			$row = mysql_fetch_array ($numresults);
			do {
				$adid_array2[] = $row[ 'id_rep' ];
			} while( $row= mysql_fetch_array($numresults));
		}
		

		if(isset($query2))
		{	
				//echo $query2;
				$numresults = mysql_query ($query2, $connection);
				$row = mysql_fetch_array ($numresults);
				do {
					$adid_array2[] = $row[ 'id_record' ];
				} while( $row= mysql_fetch_array($numresults));
		}
	}
	
	$tmparr2 = array_unique($adid_array2);
	$i=0;
	foreach ($tmparr2 as $v) {
		$newarr2[$i] = $v;
		$i++;
	}
	
	if($boolean1 == "OR")
		$newarr1 = array_unique(array_merge($newarr1,$newarr2));
	else  if($boolean1 == "AND")
		$newarr1 = array_intersect($newarr1,$newarr2);
	else 
		$newarr1 = array_diff($newarr1,$newarr2);
	
}

if(!empty($search_cat3) && !empty($boolean2) && !empty($trimmed3)) {
	foreach ($trimmed_array3 as $trimm) {
		if($search_cat3 == "All")
		{
						 //remove subjects from here
			$query = "SELECT * FROM approved WHERE rep_title LIKE '%$trimm%' OR 
					  rep_description LIKE '%$trimm%' OR
					  rep_authority LIKE '%$trimm%' OR
					  rep_access LIKE '%$trimm%' ";
			$query2 = "SELECT sub.id_record from ((select id_record, sub_title FROM subject_record_assoc_approved natural join subjects) As sub ) where sub.sub_title LIKE '%$trimm%' ";
		}
		else 
		{
			if($search_cat3 == "rep_subject")
				$query2 = "SELECT sub.id_record from ((select id_record, sub_title FROM subject_record_assoc_approved natural join subjects) As sub ) where sub.sub_title LIKE '%$trimm%' ";
			else
				$query = "SELECT * FROM approved WHERE $search_cat3 LIKE '%$trimm%'" ;
		}
		
		if(isset($query))
		{
			$numresults = mysql_query ($query, $connection);
			$row = mysql_fetch_array ($numresults);
			do {
				$adid_array3[] = $row[ 'id_rep' ];
			} while( $row= mysql_fetch_array($numresults));
		}
		
		if(isset($query2))
		{
				//echo $query2;
				$numresults = mysql_query ($query2, $connection);
				$row = mysql_fetch_array ($numresults);
				do {
					$adid_array3[] = $row[ 'id_record' ];
				} while( $row= mysql_fetch_array($numresults));
		}
	}
	
	$tmparr3 = array_unique($adid_array3);
	$i=0;
	foreach ($tmparr3 as $v) {
		$newarr3[$i] = $v;
		$i++;
	}
	
	if($boolean2 == "OR")
		$newarr1 = array_unique(array_merge($newarr1,$newarr3));
	else  if($boolean2 == "AND")
		$newarr1 = array_intersect($newarr1,$newarr3);
	else 
		$newarr1 = array_diff($newarr1,$newarr3);
}

// display an error or, what the person searched
if( isset ($resultmsg)) {
	echo $resultmsg;
} else {
	
	$row_num_links_main = 0;
	echo "<a href=\"javascript:history.go(-1)\" > [Back to Advanced Search]</a><br/><br/>";

	$count = 0;
	foreach($newarr1 as $value){
	
		if($value == "")
			continue;
		
		$count = $count + 1;
	}
	echo "Total number of results: <strong>".$count."</strong></p>";
	foreach($newarr1 as $value){

		if($value == "")
			continue;
		

		$query_value = "SELECT * FROM approved WHERE id_rep = '".$value."'";
		$num_value = mysql_query ($query_value);
		$row_linkcat = mysql_fetch_array ($num_value);
	
		$row_num_links_main = mysql_num_rows($num_value);
		
		$record_id = $row_linkcat[ 'id_rep'];
		$title = $row_linkcat[ 'rep_title' ] ;
		$link =  $row_linkcat[ 'rep_url' ] ;
		if(substr($link, 0, 4) != "http")
			$link = "http://". $link;
		$desc = strip_tags($row_linkcat[ 'rep_description']);
		$desc = substr($desc, 0, 100)."...";
		echo '<div>';
		echo '<div>';
		echo '<a href="viewapprovedbyrecordid.php?record='.$record_id.'" style="color:#993300; font-size:14px">';
		echo $title;
		echo  '</a>';
		echo '</div>';
		echo '<div class="search-link">';
		echo '<a href="'.$link.'">';
		echo $link;
		echo '</a></div>';
		echo '<div class="search-text">';
		echo $desc;
		echo '</div>';
		echo '</div>';
		echo '<br/><br/>';

	}  //end foreach $newarr

	if($row_num_links_main > $limit){
		// next we need to do the links to other search result pages
		if ($s >=1) { // do not display previous link if 's' is '0'
			$prevs=($s-$limit);
			echo '<div class="search_previous"><a href="'.$PHP_SELF.'?s='.$prevs.'&q='.$var.'">Previous</a>
            </div>';
		}
		// check to see if last page
		$slimit = $s + $limit;
		if (!($slimit >= $row_num_links_main) && $row_num_links_main!=1) {
			// not last page so display next link
			$n=$s+$limit;
			echo '<div  class="search_next"><a href="'.$PHP_SELF.'?s='.$n.'&q='.$var.'">Next</a>
            </div>';
		}
	}//end if $row_num_links_main > $limit
}//end if search result



?>
