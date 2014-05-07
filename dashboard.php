<?PHP
require_once("./include/membersite_config.php");

$show_review_link = 0;
if(!$fgmembersite->CheckLogin()) {
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
else {
	include_once('./include/database_connection.php');
	$username = $fgmembersite->UserName();
    $sql = "select * from users where username ='$username'";
    $result = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($result);
	
    if($row['user_role'] == "editor") 
    	$show_review_link = 1;
    else if($row['user_role'] == "admin") 
    	header("Location: admindashboard.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css"/>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="Author" content="Databib" />
<meta name="Keywords" content="Databib data curation bibliography bibliographies Michael Witt Mike Giarlo Purdue Penn State University library science libraries repositories" />
<meta name="Description" content="Databib is a collaborative, annotated bibliography of primary research data repositories developed with support from the Institute of Museum and Library Services." />
<meta name="Robots" content="all" />

<link href="css/site.css" rel="stylesheet" type="text/css" />
<link href="css/siteupdates.css" rel="stylesheet" type="text/css" />
<link href="http://databib.org/css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="http://databib.org/css/print.css" rel="stylesheet" type="text/css" media="handheld" />
<link rel="shortcut icon" href="/images/bullet.ico" type="image/x-icon" />

<script src="/scripts/dropdown.js"></script>


<link rel="stylesheet" type="text/css" href="/dhtmlxTree/dhtmlxTree/codebase/dhtmlxtree.css">
<script type="text/javascript" src="/dhtmlxTree/dhtmlxTree/codebase/dhtmlxcommon.js"></script>
<script type="text/javascript" src="/dhtmlxTree/dhtmlxTree/codebase/dhtmlxtree.js"></script>   
<script type="text/javascript" src="/dhtmlxTree/dhtmlxTree/codebase/ext/dhtmlxtree_start.js"></script>  



<title>Databib</title>
<style>

span.tab1 {padding-left: 2.5em;}


thead th,
tbody th
{
  background            : #FFF;
  color                 : #666;  
  padding               : 5px 10px;
  border-left           : 1px solid #CCC;
  border-right           : 2px solid #CCC;
}
tbody th
{
  background            : #fafafb;
  border-top            : 1px solid #CCC;
  text-align            : left;
  font-weight           : normal;
  border-right           : 2px solid #CCC;
}

tfoot th
{
  background            : #fafafb;
  border-top            : 1px solid #CCC;
  text-align            : left;
  font-weight           : normal;
  border-right           : 2px solid #CCC;
  border-bottom           : 2px solid #CCC;
}

del {color:gray;}
ins {color:red;text-decoration:none;}

submitter::selection {color:red}

</style>
</head>

<body>

<div id="page-content">
<?php include "include/header.php"; ?>

  <div id="wrapper2">
    <div id="wrapper">
      <div id="body-content"  style ="width: 960px">
	    <br/>
        <div id='fg_membersite_content' style ="width: 930px">
		<h1>Welcome <?php echo $fgmembersite->UserFullName(); ?>!</h1>
			<br/>
		<table style ="width: 930px;padding:4px;margin:4px;">
		<col style ="width: 710px;">
		<col style ="width: 10px;">
		<col style ="width: 200px;">
		<tr>
			<td valign="top" colspan=3>
				<div id="treeboxbox_tree" setImagePath="/dhtmlxTree/dhtmlxTree/codebase/imgs/csh_bluebooks/" style="width:930px; height:250px; background-color:#f5f5f5;border :1px solid Silver;margin-bottom:8px;">
				<ul>
					<li id="Waiting"><span style="font-weight:bold">Waiting your review</span>
					<ul>
						<li id="Records"><span style="font-weight:bold">Records</span>
						<ul>
							<li id="Waiting_New"> <span style="font-weight:bold"> New submissions
								<?php echo "(" . mysql_fetch_row(mysql_query("SELECT count(*) FROM notapproved where rep_editors LIKE '%$username%' AND reviewed = 'n' AND rep_link_to_approved = -1"))[0] . ")"; ?>
								</span>
							<ul>
								<?php 
									$query = "SELECT id_rep, rep_title, submitter, submission_date FROM notapproved where rep_editors LIKE '%$username%' AND reviewed = 'n' AND rep_link_to_approved = -1 ORDER BY id_rep ASC";
									$results_w = mysql_query ($query) ;
									while($row = mysql_fetch_array ($results_w)) {
										$submitter = $row['submitter'];
										$submission_date = $row['submission_date'];
										if($submitter == "")
										{
											$submitter = "Anonymous";
										}
										
										echo "<li id=\"NS" . $row['id_rep'] . "\">" . $row['rep_title'];
										echo "<span class=\"tab1\"></span><span style=\"color:#993300\">By <span class=\"submitter\" style=\"color:#993300;font-weight:bold;\">" . $submitter . "</span> </span> ";
										echo " <span style=\"color:gray\">$submission_date</span>";
										echo "</li>\n";
									}
								?>
							</ul>
							<li><span style="font-weight:bold"> Edits
								<?php echo "(" . mysql_fetch_row(mysql_query("SELECT count(*) FROM notapproved where rep_editors LIKE '%$username%' AND reviewed = 'n' AND rep_link_to_approved <> -1"))[0] . ")"; ?>
								</span>
							<ul>
								<?php 
									$query = "SELECT id_rep, rep_title, submitter, submission_date FROM notapproved where rep_editors LIKE '%$username%' AND reviewed = 'n' AND rep_link_to_approved <> -1 ORDER BY id_rep ASC";
									$results_w = mysql_query ($query) ;
									while($row = mysql_fetch_array ($results_w)) {
										$submitter = $row['submitter'];
										$submission_date = $row['submission_date'];
										if($submitter == "")
										{
											$submitter = "Anonymous";
										}
										
										echo "<li id=\"NE" . $row['id_rep'] . "\">" . $row['rep_title'];
										echo "<span class=\"tab1\"></span><span style=\"color:#993300\">By <span class=\"submitter\" style=\"color:#993300;font-weight:bold;\">" . $submitter . "</span> </span> ";
										echo " <span style=\"color:gray\">$submission_date</span>";
										echo "</li>\n";
									}
								?>
							</ul>
							</li>
						</ul>
						</li>
						<!--li><span style="font-weight:bold">Comments</span>
						<ul>
							<?php
								$query = "SELECT * FROM comments where editor LIKE '%$username%' AND approved ='n' ORDER BY postdate ASC";
								$results_c = mysql_query ($query) ;
								while($row = mysql_fetch_array ($results_c)) {
									echo "<li id=\"C" . $row['id_rep'] . "\">" . $row['rep_title'] . "</li>\n";
								}
							?>
						</ul>
						</li-->
					</ul>
					<li><span style="font-weight:bold">Yours waiting review
						<?php echo "(" . mysql_fetch_row(mysql_query("SELECT count(*) FROM notapproved where submitter='$username' AND reviewed = 'n'"))[0] . ")"; ?>
						</span>
					<ul>
						<?php
							$query = "SELECT * FROM notapproved where submitter='$username' AND reviewed = 'n' ORDER BY rep_title ASC";
							$results_w = mysql_query ($query) ;
							while($row = mysql_fetch_array ($results_w)) {
								$submitter = $row['submitter'];
								$submission_date = $row['submission_date'];
								if($submitter == "")
								{
									$submitter = "Anonymous";
								}
								echo "<li id=\"NW" . $row['id_rep'] . "\">" . $row['rep_title'];
								echo "<span class=\"tab1\"></span><span style=\"color:#993300\">By <span class=\"submitter\" style=\"color:#993300;font-weight:bold;\">" . $submitter . "</span> </span> ";
								echo " <span style=\"color:gray\">$submission_date</span>";
								echo "</li>\n";
							}
						?>
					</ul>
					</li>
					<li><span style="font-weight:bold">Yours not approved
						<?php echo "(" . mysql_fetch_row(mysql_query("SELECT count(*) FROM notapproved where submitter='$username' AND reviewed = 'y'"))[0] . ")"; ?>
						</span>
					<ul>
						<?php
							$query = "SELECT * FROM notapproved where submitter='$username' AND reviewed = 'y' ORDER BY rep_title ASC";
							$results_r = mysql_query ($query) ;
							while($row = mysql_fetch_array ($results_r)) {
								$submitter = $row['submitter'];
								$submission_date = $row['submission_date'];
								if($submitter == "")
								{
									$submitter = "Anonymous";
								}
								echo "<li id=\"NR" . $row['id_rep'] . "\">" . $row['rep_title'];
								echo "<span class=\"tab1\"></span><span style=\"color:#993300\">By <span class=\"submitter\" style=\"color:#993300;font-weight:bold;\">" . $submitter . "</span> </span> ";
								echo " <span style=\"color:gray\">$submission_date</span>";
								echo "</li>\n";
							}
						?>
					</ul>
					</li>
					<li><span style="font-weight:bold">Yours approved
						<?php echo "(" . mysql_fetch_row(mysql_query("SELECT count(*) FROM approved where submitter='$username'"))[0] . ")"; ?>
						</span>
					<ul>
						<?php
							$query = "SELECT * FROM approved where submitter='$username' ORDER BY rep_title ASC";
							$results_r = mysql_query ($query) ;
							while($row = mysql_fetch_array ($results_r)) {
								$submitter = $row['submitter'];
								$submission_date = $row['creation_date'];
								if($submitter == "")
								{
									$submitter = "Anonymous";
								}
								echo "<li id=\"AA" . $row['id_rep'] . "\">" . $row['rep_title'];
								echo "<span class=\"tab1\"></span><span style=\"color:#993300\">By <span class=\"submitter\" style=\"color:#993300;font-weight:bold;\">" . $submitter . "</span> </span> ";
								echo " <span style=\"color:gray\">$submission_date</span>";
								echo "</li>\n";
							}
						?>
					</ul>
					</li>
				</ul></li>
			</div>
			</td>
		</tr>
		<tr>
			<td valign="top" style="background:#fafafb;border:1px solid #CCC;padding:10px;margin:1px;">
			<form id="submit_confirm" method="post">
				<table border="0" cellspacing="5" width="98%" id="record_table" >
			
				<tr class="spaceUnder">
					<td class="textBold" width="20%"><font face=arial size=2 color=#993300>Title</font></td>
					<td></td>
				</tr>
				<tr>
					<td id="rep_title" colspan=2></td>
				</tr>
				
				<tr class="spaceUnder">
					<td class="textBold" width="20%"><font face=arial size=2 color=#993300>URL</font></td>
					<td></td>
				</tr>
				<tr>
					<td id="rep_url" colspan=2></td>
				</tr>
				
				<tr class="spaceUnder">
					<td class="textBold" width="20%"><font face=arial size=2 color=#993300>Authority</font></td>
					<td></td>
				</tr>
				<tr>
					<td id="rep_authority" colspan=2></td>
				</tr>
				 
				<tr class="spaceUnder">
					<td class="textBold" width="20%"><font face=arial size=2 color=#993300>Authority Email</font></td>
					<td></td>
				</tr>
				<tr>
					<td id="rep_email" colspan=2></td>
				</tr>
				 
				<tr class="spaceUnder">
					<td class="textBold" width="20%"><font face=arial size=2 color=#993300>Classification</font></td>
					<td></td>
				</tr>
				<tr>
					<td id="classification" colspan=2></td>
				</tr>
				
				<tr class="spaceUnder">
					<td class="textBold" width="20%"><font face=arial size=2 color=#993300;>Subjects</font></td>
					<td></td>
				</tr>
				<tr>
					<td id="subjects" colspan=2></td>
				 </tr>
				 
				<tr class="spaceUnder">
					<td class="textBold" width="20%"><font face=arial size=2 color=#993300;>Description</font></td>
					<td></td>
				</tr>
				<tr>
					<td id="rep_description" colspan=2></td>
				</tr>
				
				<tr class="spaceUnder">
					<td class="textBold" width="20%"><font face=arial size=2 color=#993300;>Access</font></td>
				<td></td>
				</tr>
				<tr>
					<td id="rep_status" colspan=2></td>
				</tr>
				
				<tr class="spaceUnder">
					<td class="textBold" width="20%"><font face=arial size=2 color=#993300;>Start Date</font></td>
					<td></td>
				</tr>
				<tr>
					<td id="rep_startdate" colspan=2></td>
				</tr>
				
				<tr class="spaceUnder">
					<td class="textBold" width="20%"><font face=arial size=2 color=#993300;>Country</font></td>
					<td></td>
				</tr>
				<tr>
					<td id="country_name" colspan=2></td>
				</tr>
				
				<tr class="spaceUnder">
					<td class="textBold" width="20%"><font face=arial size=2 color=#993300;>Reuse</font></td>
					<td></td>
				</tr>
				<tr>
					<td id="rep_access" colspan=2></td>
				</tr>
						
				<tr class="spaceUnder">
					<td class="textBold" width="20%"><font face=arial size=2 color=#993300;>Deposit</font></td>
					<td></td>
				</tr>
				<tr>
					<td id="rep_deposit" colspan=2></td>
				</tr>
						 
				<tr class="spaceUnder">
					<td class="textBold" width="20%"><font face=arial size=2 color=#993300;>Type</font></td>
					<td></td>
				</tr>
				<tr>
					<td id="rep_type" colspan=2></td>
				</tr>
				
				<tr class="spaceUnder">
					<td class="textBold" width="20%"><font face=arial size=2 color=#993300;>Certification</font></td>
					<td></td>
				</tr>
				<tr>
					<td id="rep_certification" colspan=2></td>
				</tr>
				<tr style="border-bottom:1px solid gray;">
					<td colspan=2><br/><br/></td>
				</tr>
				
				<tr class="spaceUnder">
					<td><h3>Editor notes:</h3></td>
					<td></td>
				</tr>
				<tr>
					<td id="editor_note" colspan=2></td>
				</tr>
				<tr>
					<td id="edit_note_link"></td>
					<td><br/><br/><br/></td>
				</tr>
				<tr>
					<td style="text-align:center;" colspan=2>
						
							<input type="submit"  id="Edit" name="Edit" value="Edit" style="display:none"/>
							<input type="submit"  id="Approve" name="Approve" value="Approve" style="display:none"/>
							<input type="submit"  id="Reject" name="Reject" value="Reject" style="display:none"/>
						
					</td>
				</tr>
				</table>
			</form>
			   <!--?php 
				if($show_review_link) {
					echo ' <br/><h3>Submissions waiting your review</h3><br/>';
					include("./include/waitingforreview.php");
					$counter4 = $counter;
					include("./include/commentswaitingforreview.php");
				}
				?>
				<br/>
				<h3>Your submissions waiting review</h3>
				 <br/>
			   <!--?php include("./include/getwaitingbysubmitter.php");?>
				<br/>
				<h3>Your submissions that were not approved by the editor</h3>
				 <br/>
			   <!--?php include("./include/getrejectedbysubmitter.php");?>
				<br/>
				<h3>Your submissions that were approved by the editor</h3>
				 <br/>
			   <!--?php include("./include/getapprovedbysubmitter.php");?>
				<!--h3>Comments waiting your review</h3>
				 <br/-->
			   <!--?php //include("./include/commentswaitingforreview.php");?-->
			</td>
			<td></td>
			<td valign="top">
				<?php if($show_review_link) {?>
				<?php include("./include/getwaitingbyeditor.php");?>
				<br/><br/><br/>
				<?php } ?>
			</td>
		</tr>
		<tr style="height:10px"></tr>
		
		</table>
		</div>
      </div>    
    </div>
  </div>

<?php include "include/footer.php"; ?>

</div>
</body>
<script>
	var rep_id, rec_type;
	
	function editNote(id_note, id_rep, table)
	{
		url = 'include/note_manager.php?type=' + table + '&id=' + id_rep;
		popupWindow = window.open(url,'popUpWindow','height=400,width=450,left=600,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');
	}

	function update_note(note)
	{
		document.getElementById("editor_note").innerHTML = note;
		setEditNoteLink(note);
	}

	function setButtons(status) {
		document.getElementById('Edit').style.display = status;
		document.getElementById('Approve').style.display = status;
		document.getElementById('Reject').style.display = status;
	}
	
	function setEditNoteLink(note) {
		if(note.length > 0)
			lnk_txt = "Edit note";
		else
			lnk_txt = "Add note";
		if(rec_type == "N")
			table = "notapproved";
		else
			table = "approved";
		document.getElementById('edit_note_link').innerHTML = "<a href=\"javascript:void(0)\" onclick=\"editNote('editor_note', '" + rep_id + "', '" + table + "')\"><i>" + lnk_txt + "</i></a>";
	}
	
	function tonclick(id) {
		rec_type = id.substring(0,1);
		if(typeof id == "string" && (rec_type == "N" || rec_type == "A")) {
			document.getElementById("record_table").style.display = "block";
			rep_id = id.substring(2);
			var url = 'http://databib.org/include/getJSONrecord.php?record_id=' + rep_id + '&type=' + rec_type;
				
			if (window.XMLHttpRequest) {              
				AJAX=new XMLHttpRequest();              
			} else {                                  
				AJAX=new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			if (AJAX) {
				AJAX.open("GET", url, false);
				AJAX.send(null);
				record = JSON.parse(AJAX.responseText);
				document.getElementById('rep_title').innerHTML = record.rep_title;
				document.getElementById('rep_url').innerHTML = record.rep_url;
				document.getElementById('rep_authority').innerHTML = record.authorities;
				document.getElementById('rep_email').innerHTML = record.rep_email;
				document.getElementById('classification').innerHTML = record.classification;
				document.getElementById('subjects').innerHTML = record.subjects;
				document.getElementById('rep_description').innerHTML = record.rep_description;
				document.getElementById('rep_status').innerHTML = record.rep_status;
				document.getElementById('rep_startdate').innerHTML = record.rep_startdate;
				document.getElementById('country_name').innerHTML = record.country_name;
				document.getElementById('rep_access').innerHTML = record.rep_access;
				document.getElementById('rep_deposit').innerHTML = record.rep_deposit;
				document.getElementById('rep_type').innerHTML = record.rep_type;
				document.getElementById('rep_certification').innerHTML = record.rep_certification;
				document.getElementById('editor_note').innerHTML = record.editor_note;
				document.getElementById('submit_confirm').setAttribute('action','approvalresponse.php?record=' + rep_id);
				//alert(document.getElementById('submit_confirm').getAttribute('action'));
				setEditNoteLink(record.editor_note);
			}
			if(id.substring(1, 2) == "S" || id.substring(1, 2) == "E") {
				setButtons('inline');
			} else {
				setButtons('none');
			}
		} else {
			document.getElementById("record_table").style.display = "none";
			setButtons('none');
		}
	};
	
    var myTree = dhtmlXTreeFromHTML("treeboxbox_tree"); // for script conversion
	dhtmlx.skin = "dhx_skyblue";
	myTree.setOnClickHandler(tonclick);
    myTree.enableCheckBoxes(1);
	myTree.openItem("Records");
	
	document.getElementById("record_table").style.display = "none";
</script>
</html>
