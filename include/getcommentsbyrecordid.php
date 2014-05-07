<?php
$record_id = mysql_real_escape_string(@$_REQUEST['record']);
$query = "SELECT * FROM comments WHERE recordid='$record_id' ORDER BY postdate DESC";
$result = mysql_query($query);
$num_rows = mysql_num_rows($result);
while($row = mysql_fetch_array($result)) {
	?>
<div class="comment">

<?php
echo '<table  width="65%" >';
if($row['approved'] == 'y') {
	echo ' <tr bgcolor="White" >';
	echo ' <td width="25%">'.$row['comment'].'</td>';
	echo '</tr>';
	echo '<tr  > <td> Posted at ' . substr($row['postdate'], 0, 16).' By:'. $row['authorfullname']. '</td></tr>';
	echo '<br/>';
}
else {
	echo ' <tr bgcolor="#D7D8DB">';
	echo ' <td width="25%">'.$row['comment'].'</td>';
	echo '</tr>';
	echo '<tr> <td>Posted at ' . substr($row['postdate'], 0, 16).' By: '. $row['authorfullname']. '</td></tr>';
	echo '<br/>';
}
?>

</div>
<?php
}
if($num_rows > 0)
echo '</table><br/><br/>';
?>
