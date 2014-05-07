<?php
include_once('include/database_connection.php');

function xmlentities($string) {
    return str_replace(array("&", "<", ">", "\"", "'"),
        array("&amp;", "&lt;", "&gt;", "&quot;", "&apos;"), $string);
}

$sql = "SELECT * FROM approved ORDER BY creation_date DESC LIMIT 15";

$result = mysql_query($sql) or die(mysql_error());
$num_rows = mysql_num_rows($result);
	
$xml =  "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>
<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\"><channel>
<title>Databib Published records</title>
<link>http://www.databib.org</link>
<description>The latest records that are approved are displayed in this feed</description>\n";
$xml .= "<atom:link href=\"http://databib.org/displayRssFeeds.php\" rel=\"self\" type=\"application/rss+xml\" />";
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$title = xmlentities($row['rep_title']);
	$url = xmlentities($row['rep_url']);
	$description = "<![CDATA[" .xmlentities($row['rep_description']). "]]>"; 

 $xml .=  "<item><title>$title</title>
       <link>$url</link>
       <description>$description</description>
       <guid>$url</guid>
       </item>\n";
}

$xml .="</channel></rss>";

header("Content-Type: application/rss+xml");
echo formatXmlString($xml);





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
