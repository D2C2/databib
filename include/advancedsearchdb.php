<?php

include_once('database_connection.php');

require ( "sphinx/api/sphinxapi.php" );


// get the search variable from URL
$query_all = trim(mysql_real_escape_string(@$_REQUEST['query_all']));
$query_title = trim(mysql_real_escape_string(@$_REQUEST['query_title']));
$query_description = trim(mysql_real_escape_string(@$_REQUEST['query_description']));
$query_authority = trim(mysql_real_escape_string(@$_REQUEST['query_authority']));
$query_subject = trim(mysql_real_escape_string(@$_REQUEST['query_subject']));
$query_classification = trim(mysql_real_escape_string(@$_REQUEST['query_classification']));
$query_country = trim(mysql_real_escape_string(@$_REQUEST['query_country']));

$query = trim(mysql_real_escape_string(@$_REQUEST['query']));
$display_query = trim(mysql_real_escape_string(@$_REQUEST['display_query']));

if(!isset($_REQUEST['query'])) {

	$query = "";
	$display_query = "";
	if(!empty($query_all)) {
		$query = "@* " . $query_all;
		$display_query = "All: " . $query_all;
	}
	if(!empty($query_title)) {
		$query = $query . " @title " . $query_title;
		$display_query = $display_query . " Title: " . $query_title;
	}
	if(!empty($query_description)) {
		$query = $query . " @description " . $query_description;
		$display_query = $display_query . " Description: " . $query_description;
	}
	if(!empty($query_authority)) {
		$query = $query . " @authority " . $query_authority;
		$display_query = $display_query . " Authority: " . $query_authority;
	}
	if(!empty($query_subject)) {
		$query = $query . " @subjects " . $query_subject;
		$display_query = $display_query . " Subjects: " . $query_subject;
	}
	if(!empty($query_classification)) {
		$query = $query . " @classification " . $query_classification;
		$display_query = $display_query . " Classification: " . $query_classification;
	}
	if(!empty($query_country)) {
		$query = $query . " @location " . $query_country;
		$display_query = $display_query . " Location: " . $query_country;
	}
}

echo "<a href=\"advanced_search.php\" > [Back to Advanced Search]</a><br/><br/>";

include("searchdb.php");
echo "<br><br>";

?>
