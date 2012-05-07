<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
include_once('database_connection.php');
$record_id = mysql_real_escape_string(@$_REQUEST['record']);
$sql = "select * from approved where id_rep ='$record_id'";
$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);
?>

<a href="javascript:history.go(-1)" > [Go Back]</a><br/><br/>

<table border="0" cellspacing="5" width="70%" typeof="databib:Repository" about="http://databib.org/viewapprovedbyrecordid.php?record=<?php echo $record_id ?>#Repository" >
	<tr class="spaceUnder">
		<td class="textBold leftTitle">Title</td>
		<td property="dcterms:title"><?php echo $row['rep_title'];?></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold leftTitle">URL</td>
		<td  rel="foaf:homepage" resource="<?php echo $row['rep_url'];?>" ><?php echo '<a href="'.$row['rep_url'].'">'; echo $row['rep_url']; echo '</a>';?></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold leftTitle" >Authority</td>
		<td property="dcterms:publisher"><?php echo $row['rep_authority'];?></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold leftTitle" >Subjects</td>
		<td>
			<?php 
					

				$subquery = "select subjects.sub_title, subjects.id_subject from subjects, subject_record_assoc_approved where subjects.id_subject = subject_record_assoc_approved.id_subject AND subject_record_assoc_approved.id_record = $record_id order by subjects.sub_title";
				$subresult = mysql_query($subquery) or die(mysql_error());
				
				$count=mysql_num_rows($subresult);

				$i=0;
				while($subrow = mysql_fetch_array($subresult))
				{
					echo "<div class='bubblewrap'><a  style='text-decoration: none;' href='/include/getrecordsbysubject.php?subjectid=".$subrow['id_subject']."'>" . $subrow['sub_title']  . "</a></div>";
					
					$i++;
					if($i != $count)
					{
						echo " ";
					}
				}	


				$subquery = "select * from subjects, subject_record_assoc_approved where subjects.id_subject = subject_record_assoc_approved.id_subject AND subject_record_assoc_approved.id_record = $record_id";
				$subresult = mysql_query($subquery) or die(mysql_error());
				$i =0;
				while($subrow = mysql_fetch_array($subresult))
				{
					echo "<span rel='dcterms:subject' style='visibility:hidden;display:none' resource='".$subrow['sub_url']."'></span>";

				}					
			?></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold leftTitle">Description &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td class="rightText" property="dcterms:description" ><?php echo $row['rep_description'];?></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold leftTitle" >Access</td>
		<td property="databib:status"><?php echo $row['rep_status'];?></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold leftTitle" >Start Date</td>
		<td property="dcterms:created" ><?php echo $row['rep_startdate'];?></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold leftTitle" >Location</td>
		<td	property="dcterms:spatial" ><?php echo $row['rep_location'];?></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold leftTitle" >Reuse</td>
		<td property="databib:reusePolicy" ><?php echo $row['rep_access'];?></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold leftTitle" >Deposit</td>
		<td property="databib:depositPolicy"> <?php echo $row['rep_deposit'];?></td>
	</tr>
	<tr class="spaceUnder">
		<td class="textBold leftTitle" >Type</td>
		<td  property="databib:type" > <?php echo $row['rep_type'];?></td>
	</tr>
	 <tr>
      	<td><input type="hidden" id="hiddenIDbox" name="hiddenBox" style="width:300px; height:20px; margin-bottom:8px;"/><br/></td>
     </tr>
</table>
 

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php
echo '<a href="editapprovedrecord.php?record='.$record_id.'" style="color:#993300; font-size:14px">';
echo 'Edit';
echo  '</a>';
?>

&nbsp;&nbsp;
<?php

echo '<a href="deleteapprovedrecord.php?record='.$record_id.'" style="color:#993300; font-size:14px">';
echo 'Delete';
echo  '</a>';


?>

&nbsp;&nbsp;
<?php
	$_SESSION["ID"] = $record_id;
	$_SESSION["curURI"] = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
?>


