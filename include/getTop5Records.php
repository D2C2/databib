<?PHP

include_once('database_connection.php');

//path to directory to scan
$directory = "./Knplabs/Snappy/";
 
//get all image files with a .jpg extension.
$images_list = glob($directory . "*.jpg");
$images_count = sizeof($images_list);
//select a random image
$rnd_image = rand(0, $images_count -1);
$image_name = $images_list[$rnd_image];
$file_name = basename($image_name);
$img_web_path = 'http://databib.org/Knplabs/Snappy/' . $file_name;
$dot_pos = strpos($file_name, '.');
$url = "http://databib.org/repository/" . substr($file_name, 0, $dot_pos);

$id = substr($file_name, 0, $dot_pos);
$sql = "SELECT rep_title FROM approved WHERE id_rep = $id";
$row = mysql_fetch_array(mysql_query($sql));  
// Featured repository
//echo "<h5 style=\"color:#5E1919;font-style:normal;font-size:125%\">Featured repository:</h5><hr>";
echo "<img src='images/sidebar_fr.jpg' alt='>Featured Repository' />";
echo "<a href=\"$url\" class='class-link2'>";
echo "<img src=\"$img_web_path\" width=\"180\" height=\"140\" alt=\"\"/><br /><span class=\"notranslate\">$row[0]</span></a><br />";
echo "";

// Number of repositories
$total_qry = "SELECT count(*) as total FROM approved";
$result = mysql_query($total_qry) or die(mysql_error());
$row = mysql_fetch_assoc($result);
$n_records = $row['total'];
echo "<br/><h5 style=\"color:#5E1919;font-style:normal;font-size:110%\">$n_records data repositories total in Databib.</h5><br/>";

$sql = "SELECT * FROM approved ORDER BY creation_date DESC LIMIT 5";

$result = mysql_query($sql) or die(mysql_error());
$num_rows = mysql_num_rows($result);
$div = "";
//echo "<br/><br/><h5 style=\"color:#5E1919;font-style:normal;font-size:125%\">Recently added:</h5><hr>\n";
echo "<br/><img src='images/sidebar_ra.jpg' alt='>Recently Added' />";
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$title = $row['rep_title'];
	$url = "./repository/".$row['id_rep'];
	$description = $row['rep_description'];
	$div.= "<img width=\"9\" src=\"/images/bullet3.png\" alt=\"\"/> ";
	$div .= "<a class='class-link2' href='$url' title=\"$title\"><span class=\"notranslate\">$title</span></a><br/><br/>\n";
//	$div .= substr($description, 0, 50)."<br><br>";
}

//$div.= "<hr>";
$div .= "<br/>";


$div.="<div style=\"float:left; width:140px\"><a style=\"width: 200px;\" href=\"https://twitter.com/Databib\" class=\"twitter-follow-button\" data-show-count=\"false\">Follow @Databib</a>\n
<script type=\"text/javascript\">!function(d,s,id){var  js,fjs=d.getElementsByTagName(s)[0];\nif(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=\"//platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);}}(document,\"script\",\"twitter-wjs\");\n</script></div>\n<div>\n<a href=\"./displayRssFeeds.php\" title=\"Databib RSS\">\n
<img src=\"http://databib.org/images/rss.jpg\" width=\"21\" height=\"20\" alt=\"RSS\"/>\n</a>\n</div>\n";

echo $div;


//echo "<br/><br/><h5 style=\"color:#5E1919;font-style:normal;font-size:125%\">Classifications:</h5><hr>";
echo "<br/><br/><img src='images/sidebar_subjects.jpg' alt='Subjects' />";

$query = "SELECT classification, count(*) as freq FROM databibDB.approved group by classification";
$result = mysql_query($query) or die(mysql_error());
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$classification = $row['classification'];
	$freq = $row['freq'];
	if(!empty($classification)) {
		$id = substr($classification, 0, 3);
		echo "<img width=\"9\" src=\"/images/bullet3.png\" alt=\"\"/> ";
		echo "<a class='class-link' href=\"http://databib.org/index_subjects.php#$id\" title=\"$classification ($freq)\">$classification <u>($freq)</u></a><br/>\n";
	} else {
		//$unclassified = "<a class='class-link' href=\"http://databib.org/index.php?startrow_cat=true#Unc\" title=\"Unclassified ($freq)\">Unclassified <u>($freq)</u></a><br/>\n";
		$unclassified = "<a class='class-link' href=\"http://databib.org/index_subjects.php#Unc\" title=\"Unclassified ($freq)\">Unclassified <u>($freq)</u></a><br/>\n";
	}
}
echo "<img width=\"9\" src=\"/images/bullet3.png\" alt=\"\"/> ". $unclassified; //"<hr>";

?>
	<br/>
	<hr>
	<table>
		<tr>
			<td style="padding: 6px"><a href="javascript:jumpTranslation('en')">
			<img src="/flags/png/United-Kingdom-24.png" title="English" style="width: 24px; height: 20px;"/>
			</a></td>
			<td style="padding: 6px"><a href="javascript:jumpTranslation('es')">
			<img src="/flags/png/Spain-24.png" title="Spanish" style="width: 24px; height: 20px;"/>
			</a></td>
			<td style="padding: 6px"><a href="javascript:jumpTranslation('fr')">
			<img src="/flags/png/France-24.png" title="French" style="width: 24px; height: 20px;"/>
			</a></td>
			<td style="padding: 6px"><a href="javascript:jumpTranslation('de')">
			<img src="/flags/png/Germany-24.png" title="German" style="width: 24px; height: 20px;"/>
			</a></td>
			<td style="padding: 6px"><a href="javascript:jumpTranslation('it')">
			<img src="/flags/png/Italy-24.png" title="Italian" style="width: 24px; height: 20px;"/>
			</a></td>
		</tr>
		<tr>
			<td style="padding: 6px"><a href="javascript:jumpTranslation('zh-CN')">
			<img src="/flags/png/China-24.png" title="Chinese" style="width: 24px; height: 20px;"/>
			</a></td>
			<td style="padding: 6px"><a href="javascript:jumpTranslation('ja')">
			<img src="/flags/png/Japan-24.png" title="Japanese" style="width: 24px; height: 20px;"/>
			</a></td>
			<td style="padding: 6px"><a href="javascript:jumpTranslation('ar')">
			<img src="/flags/png/Egypt-24.png" title="Arabic" style="width: 24px; height: 20px;"/>
			</a></td>
			<td style="padding: 6px"><a href="javascript:jumpTranslation('hi')">
			<img src="/flags/png/India-24.png" title="Hindi" style="width: 24px; height: 20px;"/>
			</a></td>
			<td style="padding: 6px"><a href="javascript:jumpTranslation('pt')">
			<img src="/flags/png/Portugal-24.png" title="Portuguese" style="width: 24px; height: 20px;"/>
			</a></td>
		</tr>
	</table>