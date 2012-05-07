<?PHP

include_once('database_connection.php');

$sql = "SELECT * FROM approved ORDER BY creation_date DESC LIMIT 5";

$result = mysql_query($sql) or die(mysql_error());
$num_rows = mysql_num_rows($result);
$div = "";
echo "<h5 style=\"color:#5E1919;font-style:normal;font-size:125%\">Recently added...</h5><br>";
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$title = $row['rep_title'];
	$url = "./viewapprovedbyrecordid.php?record=".$row['id_rep'];
	$description = $row['rep_description'];
	$div .= "<b><a style=\"font-style:normal; font-size:80%\" href='$url'>$title</a></b><br><br>";
//	$div .= substr($description, 0, 50)."<br><br>";
}

$div.="<div \"float:right; position: relative; left: 20px; top: 10px;\"><a href=\"./displayRssFeeds.php\"> 
	   <img src=\"http://databib.org/images/rss.jpg\" width=\"21\" height=\"20\"></a>";

$div.="<div style=\"float:left; width:140px\"><a style=\"align:bottom,left; width: 200px;\" href=\"https://twitter.com/Databib\" class=\"twitter-follow-button\" data-show-count=\"false\">Follow @Databib</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=\"//platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);}}(document,\"script\",\"twitter-wjs\");</script></div></div>";

echo $div;


?>
