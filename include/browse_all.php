<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once('database_connection.php');

function get_records($result, $show_letters)
{

	$last_letter = '@';
	while($row_linkcat = mysql_fetch_array ($result)) {
		
		$introcontent = strip_tags($row_linkcat[ 'rep_description']);
		$introcontent = substr($introcontent, 0, 100)."...";
		$record_id = $row_linkcat[ 'id_rep'];
		$title = $row_linkcat[ 'rep_title' ];
		$desc =   $introcontent;
		$link = $row_linkcat[ 'rep_url' ];
		if(substr($link, 0, 4) != "http")
			$link = "http://". $link;
		$letter = mb_substr($title,0,1);
		$letter = strtoupper($letter);
		
		if($show_letters && $letter != $last_letter) {
			for($i = chr(ord ($last_letter) +1); ord($i) <= ord($letter); $i = chr(ord ($i) +1) ) {
				echo "<a name=\"$i\" id=\"{$i}\"><h1 style=\"color:#A64B00;font-size:20px\" >{$i}</h1></a><br/>";
				if( ord ($i) < ord($letter) ) {
					echo "<br/><br/>";
				}
			}
			$last_letter = $letter;
		}
		
		echo "<div>\n";
		echo "<div>";
		echo "<a href=\"repository/$record_id\" style=\"color:#993300; font-size:14px\" title=\"$title\">";
		echo "\n<span class=\"notranslate\">\n";
		echo $title;
		echo  "\n</span></a>\n";
		echo "</div>\n";
		echo "<div>\n";
		echo $desc;
		echo "</div>\n";
		echo "</div>\n";
		echo "<br/>\n";
	}

}

$query_value = "SELECT * FROM approved WHERE rep_title < 'A' ORDER BY rep_title ASC";
$result = mysql_query ($query_value);
echo "<br/><br/>";

get_records($result, false);

$query_value = "SELECT * FROM approved WHERE rep_title > '@' ORDER BY rep_title ASC";
$result = mysql_query ($query_value);
echo "<br/>";

get_records($result, true);

?>
