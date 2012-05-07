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

$num_iter = 0;


$xml =  "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\"><channel>
<title>Databib search records</title>
<link>http://www.databib.com.com</link>
<description>Open search to search databib</description>\n";
$xml .= "<atom:link href=\"http://databib.lib.purdue.edu/include/search_results.php\" rel=\"self\" type=\"application/rss+xml\" />";

if( isset ($resultmsg)) {
	echo $resultmsg;
} else {
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
		$link =  $row_linkcat[ 'rep_url' ] ;
		
		$url = "http://databib.lib.purdue.edu/viewapprovedbyrecordid.php?record=".$record_id;
		$title = $row_linkcat['rep_title'];

		$title = "<![CDATA[" .$title. "]]>";
		$url =  "<![CDATA[" .$url. "]]>";
		$description = "<![CDATA[" .$description. "]]>"; 

	 	$xml .=  "<item><title>$title</title>
	       <link>$url</link>
	       <description>$introcontent</description>
	       <guid>$url</guid>
	       </item>\n";
	}

$xml .="</channel></rss>";
header("Content-Type: application/rss+xml");
echo formatXmlString($xml);
}

function formatXmlString($xml) {

		// add marker linefeeds to aid the pretty-tokeniser (adds a linefeed between all tag-end boundaries)
		$xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);

		// now indent the tags
		$token = strtok($xml, "\n");
		$result = '';
		// holds formatted version as it is built
		$pad = 0;
		// initial indent
		$matches = array();
		// returns from preg_matches()

		// scan each line and adjust indent based on opening/closing tags
		while ($token !== false) :

			// test for the various tag states

			// 1. open and closing tags on same line - no change
			if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)) :
				$indent = 0;
			// 2. closing tag - outdent now
			elseif (preg_match('/^<\/\w/', $token, $matches)) :
				$pad--;
			// 3. opening tag - don't pad this one, only subsequent tags
			elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)) :
				$indent = 1;
			// 4. no indentation needed
			else :
				$indent = 0;
			endif;

			// pad the line with the required number of leading spaces
			$line = str_pad($token, strlen($token) + $pad, ' ', STR_PAD_LEFT);
			$result .= $line . "\n";
			// add to the cumulative result, with linefeed
			$token = strtok("\n");
			// get the next token
			$pad += $indent;
			// update the pad size for subsequent lines
		endwhile;

		return $result;
	}


?>
















