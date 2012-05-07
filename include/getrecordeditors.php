<?php
$show_reassign_link = 0;
include_once('database_connection.php');
$record_id = mysql_real_escape_string(@$_REQUEST['recordchoice']);	
$sql = "select * from approved where id_rep ='$record_id'";
$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);

$pieces = explode(',', $row['rep_editors']);
$number = count($pieces);

$stringpool = "";
for ($i = 0; $i < $number; $i++) {
	if($i != $number -1)
		$stringpool = $stringpool. "'".$pieces[$i]."',";
	else 
		$stringpool = $stringpool. "'".$pieces[$i]."'";
}

$sql1 = "select * from users where username IN ($stringpool)";
$result1 = mysql_query($sql1) or die(mysql_error());
$row1 = mysql_fetch_array($result1);
$editors = "";
do {
	  $editors = $editors . $row1['name'] . ", ";
	} while( $row1 = mysql_fetch_array($result1));

?>

<h3>This record has been assigned to the following editors: 
<font face=arial size=2 color=#993300>
	<?php echo $editors?>
</font></h3> <br/><br/>

<form name="submit_confirm" method="get">
<table border="0" cellspacing="5" width="70%">
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2 color=#993300>Title</font></td>
		<td><font face=arial size=2><?php echo $row['rep_title'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2 color=#993300>URL</font></td>
		<td><font face=arial size=2><?php echo '<a href="'.$row['rep_url'].'">'; echo $row['rep_url']; echo '</a></div>';?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2 color=#993300>Authority</font></td>
		<td><font face=arial size=2><?php echo $row['rep_authority'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Subjects</font></td>
		<td><font face=arial size=2><?php echo $row['rep_subjects'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Description</font></td>
		<td><font face=arial size=2><?php echo $row['rep_description'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Status</font></td>
		<td><font face=arial size=2><?php echo $row['rep_status'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Start Date</font></td>
		<td><font face=arial size=2><?php echo $row['rep_startdate'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Location</font></td>
		<td><font face=arial size=2><?php echo $row['rep_location'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Access</font></td>
		<td><font face=arial size=2><?php echo $row['rep_access'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Deposit</font></td>
		<td><font face=arial size=2><?php echo $row['rep_deposit'];?></font></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold" width="20%"><font face=arial size=2
			color=#993300;>Type</font></td>
		<td><font face=arial size=2><?php echo $row['rep_type'];?></font></td>
	</tr>
</table>
<br />
<br />

</form>






