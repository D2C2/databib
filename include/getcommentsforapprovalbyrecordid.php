<?php
if (!$_POST) {
echo '<h1>Recent Comments</h1>';
$query = "SELECT * FROM comments WHERE recordid='$record_id' ORDER BY postdate DESC";
$result = mysql_query($query);
while($row = mysql_fetch_array($result)) {
	?>
<div class="comment">

<?php
if($row['approved'] != 'y') {
	echo '<table width="100%" >';
	echo '<tr bgcolor="#D7D8DB">';
	echo '<td width="25%"> <input type ="checkbox" name="options" value='.$row['id_comment'].'>&nbsp;&nbsp;';
	echo $row['comment']. '</input></td></tr>';
	echo '<tr"> <td>Posted at ' . substr($row['postdate'], 0, 16).' By: '. $row['authorfullname']. '</td></tr>';
	echo '<br/>';
}
?>

</div>
<?php
}
echo '</table><br/>';
echo '<input type="submit" name="Approve" value="Approve"/> &nbsp;&nbsp;&nbsp;';
echo '<input type="submit" name="Reject"  value="Reject"/> &nbsp;';
echo '<br/><br/><br/>';
}
else {
	if(!empty($_REQUEST['Approve'])){
		echo '<h3>The selected comment(s) were approved</h3>';
		$comment_id = mysql_real_escape_string(@$_REQUEST['options']);
		$query = "Update comments set approved='y' WHERE id_comment='$comment_id'";
	    $result = mysql_query($query);
	    echo '<br/><br/>';
	}
if(!empty($_REQUEST['Reject'])){
		echo '<h3>The selected comment(s) were rejected</h3>';
		$comment_id = mysql_real_escape_string(@$_REQUEST['options']);
		$query = "Delete from comments WHERE id_comment='$comment_id'";
	    $result = mysql_query($query);
	    echo '<br/><br/>';
	}
}
?>