	
	<?php
	include_once('database_connection.php');
	$record_id = mysql_real_escape_string(@$_REQUEST['record']);
	$sql = "select * from notapproved where id_rep ='$record_id'";
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	
	$rep_link_to_approved = $row['rep_link_to_approved'];
	if($rep_link_to_approved != -1) {
		$sql_approved = "select * from approved where id_rep ='$rep_link_to_approved'";
		$result_approved = mysql_query($sql_approved) or die(mysql_error());
		$row_approved = mysql_fetch_array($result_approved);
	}
	
	
	?>
	<form name="submit_confirm" method="post"
		action="approvalresponse.php?record=<?php echo $record_id?>" onSubmit="return passSubjects(this);">>
	<table border="0" cellspacing="5" width="70%">
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2 color=#993300>Title</font></td>
			<td><font face=arial size=2 color="red"><?php echo $row['rep_title'];?></font></td>
		</tr>
		<?php 
			if($rep_link_to_approved != -1) {
				$row_approved_rep_title = $row_approved['rep_title'];
				echo "<tr class=\"spaceUnder\">";
				echo "<td class=\"textBold\" width=\"20%\"></td>";
				echo "<td><font face=arial size=2 color=\"green\">$row_approved_rep_title</font></td>";
				echo "</tr>";
			}
		
		?>
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2 color=#993300>URL</font></td>
			<td><font face=arial size=2 color="red"><?php echo $row['rep_url'];?></font></td>
		</tr>
		<?php 
			if($rep_link_to_approved != -1) {
				$row_approved_rep_url = $row_approved['rep_url'];
				echo "<tr class=\"spaceUnder\">";
				echo "<td class=\"textBold\" width=\"20%\"></td>";
				echo "<td><font face=arial size=2 color=\"green\">$row_approved_rep_url</font></td>";
				echo "</tr>";
			}
		
		?>
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2 color=#993300>Authority</font></td>
			<td><font face=arial size=2 color="red"><?php echo $row['rep_authority'];?></font></td>
		</tr>
		<?php 
			if($rep_link_to_approved != -1) {
				$row_approved_rep_authority = $row_approved['rep_authority'];
				echo "<tr class=\"spaceUnder\">";
				echo "<td class=\"textBold\" width=\"20%\"></td>";
				echo "<td><font face=arial size=2 color=\"green\">$row_approved_rep_authority</font></td>";
				echo "</tr>";
			}
		 ?>
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2
				color=#993300;>Subjects</font></td>
		<?php
		$subquery = "select subjects.sub_title, subjects.id_subject from subjects, subject_record_assoc where subjects.id_subject = subject_record_assoc.id_subject AND subject_record_assoc.id_record = $record_id";
		$subresult = mysql_query($subquery) or die(mysql_error());
		
		
		echo "<td><div id='selectedSubjects'>";
			while($subrow = mysql_fetch_array($subresult))
					{
							echo  "<div class = 'selectedsubject' style='color:red'>".$subrow['sub_title'] . "<img id='killSubject' style='position:relative;display:none;left:10px' src='images/close_icon.gif'/><div id='hiddenId' style='display:none'>". $subrow['id_subject'] ."</div></div>";
					}	
		echo "</div>";
		
		$subquery = "select subjects.sub_title, subjects.id_subject from subjects, subject_record_assoc_approved where subjects.id_subject = subject_record_assoc_approved.id_subject AND subject_record_assoc_approved.id_record = $rep_link_to_approved";
		$subresult = mysql_query($subquery) or die(mysql_error());
		
		echo "<div>";
		while($subrow = mysql_fetch_array($subresult))
		{
			echo  "<div class = 'selectedsubject' style='color:green'>".$subrow['sub_title'] . "<img id='killSubject' style='position:relative;display:none;left:10px' src='images/close_icon.gif'/><div id='hiddenId' style='display:none'>". $subrow['id_subject'] ."</div></div>";
		}	
		echo "</div>";

		
		echo "</td><br/></tr>";	
		?>
		
		
		
		<?php 
			if($rep_link_to_approved != -1) {
				$row_approved_rep_subjects = $row_approved['rep_subjects'];
				echo "<tr class=\"spaceUnder\">";
				echo "<td class=\"textBold\" width=\"20%\"></td>";
				echo "<td><font face=arial size=2 color=\"green\">$row_approved_rep_subjects</font></td>";
				echo "</tr>";
			}
		 ?>
		 
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2
				color=#993300;>Description</font></td>
			<td><font face=arial size=2 color="red"><?php echo $row['rep_description'];?></font></td>
		</tr>
		
		<?php 
			if($rep_link_to_approved != -1) {
				$row_approved_rep_description = $row_approved['rep_description'];
				echo "<tr class=\"spaceUnder\">";
				echo "<td class=\"textBold\" width=\"20%\"></td>";
				echo "<td><font face=arial size=2 color=\"green\">$row_approved_rep_description</font></td>";
				echo "</tr>";
			}
		 ?>
		
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2
				color=#993300;>Status</font></td>
			<td><font face=arial size=2 color="red"><?php echo $row['rep_status'];?></font></td>
		</tr>
		
		<?php 
			if($rep_link_to_approved != -1) {
				$row_approved_rep_status = $row_approved['rep_status'];
				echo "<tr class=\"spaceUnder\">";
				echo "<td class=\"textBold\" width=\"20%\"></td>";
				echo "<td><font face=arial size=2 color=\"green\">$row_approved_rep_status</font></td>";
				echo "</tr>";
			}
		 ?>
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2
				color=#993300;>Start Date</font></td>
			<td><font face=arial size=2 color="red"><?php echo $row['rep_startdate'];?></font></td>
		</tr>
		
		<?php 
			if($rep_link_to_approved != -1) {
				$row_approved_rep_startdate = $row_approved['rep_startdate'];
				echo "<tr class=\"spaceUnder\">";
				echo "<td class=\"textBold\" width=\"20%\"></td>";
				echo "<td><font face=arial size=2 color=\"green\">$row_approved_rep_startdate</font></td>";
				echo "</tr>";
			}
		 ?>
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2
				color=#993300;>Location</font></td>
			<td><font face=arial size=2 color="red"><?php echo $row['rep_location'];?></font></td>
		</tr>
		
		<?php 
			if($rep_link_to_approved != -1) {
				$row_approved_rep_location = $row_approved['rep_location'];
				echo "<tr class=\"spaceUnder\">";
				echo "<td class=\"textBold\" width=\"20%\"></td>";
				echo "<td><font face=arial size=2 color=\"green\">$row_approved_rep_location</font></td>";
				echo "</tr>";
			}
		 ?>
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2
				color=#993300;>Access</font></td>
			<td><font face=arial size=2 color="red"><?php echo $row['rep_access'];?></font></td>
		</tr>
		
		<?php 
			if($rep_link_to_approved != -1) {
				$row_approved_rep_access = $row_approved['rep_access'];
				echo "<tr class=\"spaceUnder\">";
				echo "<td class=\"textBold\" width=\"20%\"></td>";
				echo "<td><font face=arial size=2 color=\"green\">$row_approved_rep_access</font></td>";
				echo "</tr>";
			}
		 ?>
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2
				color=#993300;>Deposit</font></td>
			<td><font face=arial size=2 color="red"><?php echo $row['rep_deposit'];?></font></td>
		</tr>
		
		<?php 
			if($rep_link_to_approved != -1) {
				$row_approved_rep_deposit = $row_approved['rep_deposit'];
				echo "<tr class=\"spaceUnder\">";
				echo "<td class=\"textBold\" width=\"20%\"></td>";
				echo "<td><font face=arial size=2 color=\"green\">$row_approved_rep_deposit</font></td>";
				echo "</tr>";
			}
		 ?>
		 
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2
				color=#993300;>Type</font></td>
			<td><font face=arial size=2 color="red"><?php echo $row['rep_type'];?></font></td>
		</tr>
		
		<?php 
			if($rep_link_to_approved != -1) {
				$row_approved_rep_type = $row_approved['rep_type'];
				echo "<tr class=\"spaceUnder\">";
				echo "<td class=\"textBold\" width=\"20%\"></td>";
				echo "<td><font face=arial size=2 color=\"green\">$row_approved_rep_type</font></td>";
				echo "</tr>";
			}
		 ?>
		 	<tr>
	      	<td><input type="hidden" id="hiddenIDbox" name="hiddenBox" style="width:300px; height:20px; margin-bottom:8px;"/><br/></td>
	     </tr>
	</table>
	<br />
	<?php 
		if($rep_link_to_approved != -1) {
			echo "<font face=arial size=2 color=\"red\">Red</font> is  the edited content and\" ";
			echo "<font face=arial size=2 color=\"green\">Green</font> is the existing content in the database." ;
		}
	 ?>
	<br/> <br /><br />
	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php	
	echo ' <input type="submit"  name="Edit" value="Edit" />';
	echo ' <input type="submit"  name="Approve" value="Approve" />';
	echo ' <input type="submit"  name="Reject" value="Reject" />';
	?></form>
	
	
	
	
	
	
	
