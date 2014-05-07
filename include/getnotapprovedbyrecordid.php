	
	<?php
	include_once('database_connection.php');
	$record_id = mysql_real_escape_string(@$_REQUEST['record']);
	$sql = "select * from notapproved left join countries on notapproved.id_country = countries.id_country where id_rep ='$record_id' and reviewed='n'";
	mysql_query("set names 'utf8'");
	$result = mysql_query($sql) or die(mysql_error());
	$num_rows = mysql_num_rows($result);

	if($num_rows == 0) {
		echo "<h2>This record either does not exist or has been already reviewed.</h2>";
		return;
	}
	$row = mysql_fetch_array($result);
	
	$rep_link_to_approved = $row['rep_link_to_approved'];
	if($rep_link_to_approved != -1) {
		$sql_approved = "select * from approved left join countries on approved.id_country = countries.id_country where id_rep ='$rep_link_to_approved'";
		$result_approved = mysql_query($sql_approved) or die(mysql_error());
		$row_approved = mysql_fetch_array($result_approved);
	}
	

	function color_diffs ( $old, $new ) {

		if ( empty($old) ) {
			$ret = "<font face=arial size=2 color=\"red\">$new</font>";
		} else if ( strcmp($new, $old) == 0 ) {
			$ret = "<font face=arial size=2 color=\"gray\">$new</font>";
		} else {
			require_once('string_diff.php');
			$ret = htmlDiff( $old, $new );
		}
		return $ret;
	}
	
	?>
	<form name="submit_confirm" method="post"
		action="approvalresponse.php?record=<?php echo $record_id?>" onSubmit="return passSubjects(this);">
	<table border="0" cellspacing="5" width="90%">
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2 color=#993300>Title</font></td>
			<td>
			<?php 
				if($rep_link_to_approved != -1) {
					echo color_diffs($row_approved['rep_title'], $row['rep_title']);
				} else {
					echo color_diffs('', $row['rep_title']);
				}
			?>
			</td>
		</tr>
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2 color=#993300>URL</font></td>
			<td>
			<?php 
				if($rep_link_to_approved != -1) {
					echo color_diffs($row_approved['rep_url'], $row['rep_url']);
				} else {
					echo color_diffs('', $row['rep_url']);
				}
			?>
			</td>
		</tr>
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2 color=#993300>Authority</font></td>
			<td>
			<?php 
				$subquery = "select authorities.id_authority, authorities.auth_name from authorities, notapproved_authorities join approved_authorities on notapproved_authorities.id_authority = approved_authorities.id_authority where authorities.id_authority = notapproved_authorities.id_authority and notapproved_authorities.id_record = $record_id and approved_authorities.id_record = $rep_link_to_approved order by notapproved_authorities.auth_order";
				$subresult = mysql_query($subquery) or die(mysql_error());
		
				echo "<div id='selectedSubjects'>";
				while($subrow = mysql_fetch_array($subresult))
					{
							echo  "<div class = 'selectedsubject' style='color:gray'>".$subrow['auth_name'] . "<img id='killSubject' style='position:relative;display:none;left:10px' src='images/close_icon.gif'/>". "</div>";
					}
		
		
				$subquery = "select authorities.id_authority, authorities.auth_name from authorities, notapproved_authorities where not exists ( select 1 from approved_authorities where notapproved_authorities.id_authority = approved_authorities.id_authority and approved_authorities.id_record = $rep_link_to_approved) and authorities.id_authority = notapproved_authorities.id_authority and notapproved_authorities.id_record = $record_id 
 order by notapproved_authorities.auth_order";
				$subresult = mysql_query($subquery) or die(mysql_error());
		
				while($subrow = mysql_fetch_array($subresult))
					{
							echo  "<div class = 'selectedsubject'><ins>".$subrow['auth_name'] . "</ins><img id='killSubject' style='position:relative;display:none;left:10px' src='images/close_icon.gif'/></div>";
					}	

		
		$subquery = "select authorities.id_authority, authorities.auth_name from authorities, approved_authorities where not exists ( select 1 from notapproved_authorities where notapproved_authorities.id_authority = approved_authorities.id_authority and notapproved_authorities.id_record = $record_id) and authorities.id_authority = approved_authorities.id_authority and approved_authorities.id_record = $rep_link_to_approved  order by approved_authorities.auth_order";
		$subresult = mysql_query($subquery) or die(mysql_error());
		
			while($subrow = mysql_fetch_array($subresult))
					{
							echo  "<div class = 'selectedsubject'><del>".$subrow['auth_name'] . "</del><img id='killSubject' style='position:relative;display:none;left:10px' src='images/close_icon.gif'/></div>";
					}	
			?>
			</td>
		</tr>
         
        <tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2 color=#993300>Authority Email</font></td>
			<td>
			<?php 
				if($rep_link_to_approved != -1) {
					echo color_diffs($row_approved['rep_email'], $row['rep_email']);
				} else {
					echo color_diffs('', $row['rep_email']);
				}
			?>
			</td>
		</tr>
         
        <tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2 color=#993300>Classification</font></td>
			<td>
			<?php 
				if($rep_link_to_approved != -1) {
					echo color_diffs($row_approved['classification'], $row['classification']);
				} else {
					echo color_diffs('', $row['classification']);
				}
			?>
			</td>
		</tr>
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2
				color=#993300;>Subjects</font></td>
		<?php
		$subquery = "select subjects.sub_title, subjects.id_subject from subjects, subject_record_assoc join subject_record_assoc_approved on subject_record_assoc.id_subject = subject_record_assoc_approved.id_subject where subjects.id_subject = subject_record_assoc.id_subject and subject_record_assoc.id_record = $record_id and subject_record_assoc_approved.id_record = $rep_link_to_approved order by subjects.sub_title";
		$subresult = mysql_query($subquery) or die(mysql_error());
		
		echo "<td><div id='selectedSubjects'>";
			while($subrow = mysql_fetch_array($subresult))
					{
							echo  "<div class = 'selectedsubject' style='color:gray'>".$subrow['sub_title'] . "<img id='killSubject' style='position:relative;display:none;left:10px' src='images/close_icon.gif'/><div id='hiddenId' style='display:none'>". $subrow['id_subject'] ."</div></div>";
					}
		
		
		$subquery = "select subjects.sub_title, subjects.id_subject from subjects, subject_record_assoc where not exists ( select 1 from subject_record_assoc_approved where subject_record_assoc.id_subject = subject_record_assoc_approved.id_subject and subject_record_assoc_approved.id_record = $rep_link_to_approved) and subjects.id_subject = subject_record_assoc.id_subject and subject_record_assoc.id_record = $record_id 
 order by subjects.sub_title";
		$subresult = mysql_query($subquery) or die(mysql_error());
		
			while($subrow = mysql_fetch_array($subresult))
					{
							echo  "<div class = 'selectedsubject'><ins>".$subrow['sub_title'] . "</ins><img id='killSubject' style='position:relative;display:none;left:10px' src='images/close_icon.gif'/><div id='hiddenId' style='display:none'>". $subrow['id_subject'] ."</div></div>";
					}	

		
		$subquery = "select subjects.sub_title, subjects.id_subject from subjects, subject_record_assoc_approved where not exists ( select 1 from subject_record_assoc where subject_record_assoc.id_subject = subject_record_assoc_approved.id_subject and subject_record_assoc.id_record = $record_id) and subjects.id_subject = subject_record_assoc_approved.id_subject and subject_record_assoc_approved.id_record = $rep_link_to_approved  order by subjects.sub_title";
		$subresult = mysql_query($subquery) or die(mysql_error());
		
			while($subrow = mysql_fetch_array($subresult))
					{
							echo  "<div class = 'selectedsubject'><del>".$subrow['sub_title'] . "</del><img id='killSubject' style='position:relative;display:none;left:10px' src='images/close_icon.gif'/><div id='hiddenId' style='display:none'>". $subrow['id_subject'] ."</div></div>";
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
			<td>
			<?php 
				if($rep_link_to_approved != -1) {
					echo color_diffs($row_approved['rep_description'], $row['rep_description']);
				} else {
					echo color_diffs('', $row['rep_description']);
				}
			?>
			</td>
		</tr>

		
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2
				color=#993300;>Access</font></td>
			<td>
			<?php 
				if($rep_link_to_approved != -1) {
					echo color_diffs($row_approved['rep_status'], $row['rep_status']);
				} else {
					echo color_diffs('', $row['rep_status']);
				}
			?>
			</td>
		</tr>
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2
				color=#993300;>Start Date</font></td>
			<td>
			<?php 
				if($rep_link_to_approved != -1) {
					echo color_diffs($row_approved['rep_startdate'], $row['rep_startdate']);
				} else {
					echo color_diffs('', $row['rep_startdate']);
				}
			?>
			</td>
		</tr>
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2
				color=#993300;>Country</font></td>
			<td>
			<?php 
				if($rep_link_to_approved != -1) {
					echo color_diffs($row_approved['country_name'], $row['country_name']);
				} else {
					echo color_diffs('', $row['country_name']);
				}
			?>
			</td>
		</tr>
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2
				color=#993300;>Reuse</font></td>
			<td>
			<?php 
				if($rep_link_to_approved != -1) {
					echo color_diffs($row_approved['rep_access'], $row['rep_access']);
				} else {
					echo color_diffs('', $row['rep_access']);
				}
			?>
			</td>
		</tr>
				
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2
				color=#993300;>Deposit</font></td>
			<td>
			<?php 
				if($rep_link_to_approved != -1) {
					echo color_diffs($row_approved['rep_deposit'], $row['rep_deposit']);
				} else {
					echo color_diffs('', $row['rep_deposit']);
				}
			?>
			</td>
		</tr>
				 
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2
				color=#993300;>Type</font></td>
			<td>
			<?php 
				if($rep_link_to_approved != -1) {
					echo color_diffs($row_approved['rep_type'], $row['rep_type']);
				} else {
					echo color_diffs('', $row['rep_type']);
				}
			?>
			</td>
		</tr>
		
		<tr class="spaceUnder">
			<td class="textBold" width="20%"><font face=arial size=2
				color=#993300;>Certification</font></td>
			<td>
			<?php 
				if($rep_link_to_approved != -1) {
					echo color_diffs($row_approved['rep_certification'], $row['rep_certification']);
				} else {
					echo color_diffs('', $row['rep_certification']);
				}
			?>
			</td>
		</tr>
		
		<tr>
	      	<td><input type="hidden" id="hiddenIDbox" name="hiddenBox" style="width:300px; height:20px; margin-bottom:8px;"/><br/></td>
	     </tr>
		 <tr>
			<td><input type="hidden" id="hiddenCountryIDbox" name="hiddenCountryBox" style="width:300px; height:20px; margin-bottom:8px;" value="<?php echo $row['id_country']; ?>"/><br/></td>
		</tr>
		<tr class="spaceUnder">
			<td colspan=2>
				<h3>The following editors own this record: <font face=arial size=2	color=#993300;>
						<?php 	$editors = explode(',', $row['rep_editors']);
								for($i = 0; $i < count($editors); $i++){
									$u_sql="select name from users where user_role='editor' and username='" . $editors[$i] . "'";
									$u_result = mysql_query($u_sql);
									if($i > 0)
										echo ", ";
									if($data=mysql_fetch_assoc($u_result)) {
										echo $data['name'] . " (" . $editors[$i] . ")";
									}
								}
								
						?> </font></h3>
			</td>
		</tr>
	</table>
	<br />
	<?php 
		if($rep_link_to_approved != -1) {
			echo "<ins>Red</ins> is the inserted content, ";
			echo "<del>Strikethrough</del> is the deleted content and " ;
			echo "<font face=arial size=2 color=\"gray\">gray</font> is the unchanged content in the database." ;
		}
	 ?>
	
	<br/><br/><hr><br/><br/>
	<?php
		echo '<h3>Editor notes:</h3><br/>';
		$notes = explode("##", $row[editor_note]);
		$formatted_note = "";
		foreach ($notes as $value) {
			if($value != "") {
				$split_note = explode("#", $value);
				if(!empty($formatted_note))
					$formatted_note .= "<br/>";
				$formatted_note .= "<span style=\"font-weight:bold;font-style:italic;\" >" . mysql_fetch_row(mysql_query("SELECT name FROM users WHERE username = '" . $split_note[0] . "'"))[0] . ": </span>";
				$formatted_note .= $split_note[1];
			}
		}
		echo '<p name="editor_note" id="editor_note">' . $formatted_note . '</p>';
		$note_link = "Edit note";
		if( empty($row['editor_note']) ) {
			$note_link = "Add note";
		}
		echo "<a href=\"javascript:void(0)\" onclick=\"editNote('editor_note', '" . $record_id . "', 'notapproved')\"><i>$note_link</i></a>";
	?>
	<p>(Notes have to be made before acting on the submission)</p>
	<br />
	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php	
	echo ' <input type="submit"  name="Edit" value="Edit" />';
	echo ' <input type="submit"  name="Approve" value="Approve" />';
	echo ' <input type="submit"  name="Reject" value="Reject" />';
	?>

</form>