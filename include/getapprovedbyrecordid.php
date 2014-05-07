<div class="data-row gray"><a href="javascript:history.go(-1)" >[Go Back]</a></div>

<div typeof="databib:Repository" about="http://databib.org/repository/<?php echo $record_id ?>#Repository" >
	<?php if (!empty($row['rep_title'])) { ?>
    <div class="data-row">
        <!--img width="16" src="/images/Button-info-icon.png" title="Name of the repository." alt="Name of the repository."/-->
		<span title="Name of the repository." alt="Name of the repository." class="title">Title: </span>
        <span property="dcterms:title"  class="notranslate"><?php echo $row['rep_title'];?></span>
    </div>
    <?php } if (!empty($row['rep_url'])) { ?>
	<div class="data-row">
    	<!--img width="16" src="/images/Button-info-icon.png" title="Link to the repository." alt="Link to the repository."/-->
		<span class="title" title="Link to the repository." alt="Link to the repository.">URL: </span>
        <span rel="foaf:homepage" resource="<?php echo $row['rep_url'];?>">
                <?php 
                    if (substr($row['rep_url'],0,4) != "http") {
                        $url = "http://{$row['rep_url']}";
                    } else {
                        $url = $row['rep_url'];
                    }
                    echo "<a href='$url'>$url</a>"; 
                ?>
        </span>
    </div>
	<?php } ?>
    <div class="data-row">
        <!--img width="16" src="/images/Button-info-icon.png" title="The organization(s) that maintain the repository." alt="The organization(s) that maintain the repository."/-->
		<span class="title" title="The organization(s) that maintain the repository." alt="The organization(s) that maintain the repository.">Authority: </span>
        <div>
			<?php
				$subquery = "select authorities.auth_name, authorities.id_authority from authorities, approved_authorities where approved_authorities.id_authority = authorities.id_authority AND approved_authorities.id_record = $record_id order by approved_authorities.auth_order";
				$subresult = mysql_query($subquery) or die(mysql_error());
				while($subrow = mysql_fetch_array($subresult)) {
					echo "<div class='bubblewrap_gray'><a  style='text-decoration: none;' href='/include/getrecordsbyauthority.php?authorityid=".$subrow['id_authority']."'><span property=\"dcterms:publisher\">" . $subrow['auth_name'] . "</span></a></div>";
				}
			?>
			</div>
    </div>
	<div class="data-row">
    	<div>
			<!--img width="16" src="/images/Button-info-icon.png" title="Library of Congress Subject Headings that describe data collections." alt="Library of Congress Subject Headings that describe data collections."/-->
			<span class="title" title="Library of Congress Subject Headings that describe data collections." alt="Library of Congress Subject Headings that describe data collections.">Subjects: </span>
			<?php
				if(!empty($row['classification']))
				echo "<div class='bubblewrap_gray'><a  style='text-decoration: none;' href='/index_subjects.php#". substr($row['classification'], 0, 3)."'>" . $row['classification']  . "</a></div>";
			?>
		</div>
        <div>
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
			?>
            </div>
         </div>
         <?php if (!empty($row['rep_description'])) { ?>
      <div class="data-row">
    	<!--img width="16" src="/images/Button-info-icon.png" title="A brief, narrative abstract that summarizes the purpose, collections, and audiences of the repository." alt="A brief, narrative abstract that summarizes the purpose, collections, and audiences of the repository."/-->
		<span class="title" title="A brief, narrative abstract that summarizes the purpose, collections, and audiences of the repository." alt="A brief, narrative abstract that summarizes the purpose, collections, and audiences of the repository.">Description: </span><br />
		<span property="dcterms:description" ><?php echo $row['rep_description'];?></span>
      </div>
      <?php } if (!empty($row['rep_status'])) { ?>
	<div class="data-row">
    	<!--img width="16" src="/images/Button-info-icon.png" title="Who can access the repository?" alt="Who can access the repository?"/-->
		<span class="title" title="Who can access the repository?" alt="Who can access the repository?">Access: </span>
		<span property="databib:status"><?php echo $row['rep_status'];?></span>
    </div>
    <?php } if (!empty($row['rep_startdate'])) { ?>
	<div class="data-row">
    	<!--img width="16" src="/images/Button-info-icon.png" title="The year the repository began operating." alt="The year the repository began operating."/-->
		<span class="title" title="The year the repository began operating." alt="The year the repository began operating.">Start Date: </span>
		<span property="dcterms:created" ><?php echo $row['rep_startdate'];?></span>
    </div>
    <?php } if (!empty($row['country_name'])) { ?>
	<div class="data-row">
    	<!--img width="16" src="/images/Button-info-icon.png" title="The primary country where the repository authority resides." alt="The primary country where the repository authority resides."/-->
		<span class="title" title="The primary country where the repository authority resides." alt="The primary country where the repository authority resides.">Country: </span>
		<span property="gn:parentCountry" content="<?php echo $row['uri'];?>"><?php echo $row['country_name'];?></span>
    </div>
    <?php } if (!empty($row['rep_access'])) { ?>
	<div class="data-row">
    	<!--img width="16" src="/images/Button-info-icon.png" title="What can users do with data they&#39;ve downloaded from the repository?" alt="What can users do with data they&#39;ve downloaded from the repository?"/-->
		<span class="title" title="What can users do with data they&#39;ve downloaded from the repository?" alt="What can users do with data they&#39;ve downloaded from the repository?">Reuse: </span>
		<span property="databib:reusePolicy" ><?php echo $row['rep_access'];?></span>
    </div>
    <?php } if (!empty($row['rep_deposit'])) { ?>
	<div class="data-row">
    	<!--img width="16" src="/images/Button-info-icon.png" title="Who can deposit data?" alt="Who can deposit data?"/-->
		<span class="title" title="Who can deposit data?" alt="Who can deposit data?">Deposit: </span>
		<span property="databib:depositPolicy"> <?php echo $row['rep_deposit'];?></span>
    </div>
    <?php } if (!empty($row['rep_type'])) { ?>
	<div class="data-row">
    	<!--img width="16" src="/images/Button-info-icon.png" title="Generally, what type of repository is it?" alt="Generally, what type of repository is it?"/-->
		<span class="title" title="Generally, what type of repository is it?" alt="Generally, what type of repository is it?">Type: </span>
		<span property="databib:type" > <?php echo $row['rep_type'];?></span>
    </div>
    <?php } if (!empty($row['rep_certification'])) { ?>
	<div class="data-row">
    	<!--img width="16" src="/images/Button-info-icon.png" title="Certification of repository" alt="Certification of repository"/-->
		<span class="title" title="Certification of repository" alt="Certification of repository"> Certification: </span>
		<span property="databib:certification" > <?php echo $row['rep_certification'];?></span>
    <?php } ?>
    </div>
    
<?php if (!isset($hide_buttons)) { ?>
 <input type="hidden" id="hiddenIDbox" name="hiddenBox" style="width:300px; height:20px; margin-bottom:8px;"/>
 <input type="hidden" id="hiddenCountryIDbox" name="hiddenCountryBox" style="width:300px; height:20px; margin-bottom:8px;"/>
	<div class="data-row">
        <input type='button' class='button' onclick="window.location='http://databib.org/editapprovedrecord.php?record=<?php echo $record_id;?>';" value='Edit'/>
		
		<?php if ($_SESSION['user_role'] == 'admin') { ?>
        <input type='button' class='button' onclick="window.location='http://databib.org/deleteapprovedrecord.php?record=<?php echo $record_id;?>';" value='Delete'/>
		<?php } ?>
	</div>

  <!-- AddThis Button BEGIN -->
  <div>
  <div class="addthis_toolbox addthis_default_style data-row gray">
  <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
  <a class="addthis_button_tweet"></a>
  <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
  <a class="addthis_counter addthis_pill_style"></a>		
  </div>
  </div>
  <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f45243a60145ecf"></script>
  <!-- AddThis Button END -->

  <?php 
		$sessionvar = $fgmembersite->GetLoginSessionVar();
		if(!empty($_SESSION[$sessionvar])) {
			$username = $fgmembersite->UserName();
			//$usql = "select * from users where username='$username'";
			$editors = explode(',', $row['rep_editors']);
			for($i = 0; $i < count($editors); $i++){
				if($editors[$i] == $username) {
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
					echo "<a href=\"javascript:void(0)\" onclick=\"editNote('editor_note', '" . $record_id . "', 'approved')\"><i>$note_link</i></a><br/><br/>";
				}
			}
		}
	?>
	
	<?php
		if ($_SESSION['user_role'] == 'admin') {
			$editors = explode(',', $row['rep_editors']);
			echo '<h3>Editors:</h3><br/>';
			for($i = 0; $i < count($editors); $i++){
				$u_sql="select name from users where user_role='editor' and username='" . $editors[$i] . "'";
				$u_result = mysql_query($u_sql);
				if($data=mysql_fetch_assoc($u_result)) {
					echo "<p>" . $data['name']. "</p>";
				}
			}
			echo "<h3>To reassign editors click <a href=\"../viewreassignbyrecordid.php?record=$record_id&approved=1\">";
			echo "<font face=arial size=2 color=#993300;> here</font></a></h3>";
		}
	?>
</div>
<?php } ?>
<?php
	$_SESSION["ID"] = $record_id;
	$_SESSION["curURI"] = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
?>
