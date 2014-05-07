<link rel="stylesheet" href="/css/jquery.ui.all.css" />

<!--script src="./scripts/dropdown.js"></script-->
<script src="http://code.jquery.com/jquery-latest.js"></script>

<script src="./scripts/jquery.ui.core.js"></script>
<script src="./scripts/jquery.ui.widget.js"></script>
<script src="./scripts/jquery.ui.position.js"></script>
<script src="./scripts/jquery.ui.autocomplete.js"></script>



<script type="text/javascript">
// UTF-8 decode corresponding to the utf8_encode used at the server side
function utf8_decode(utftext) {
		var string = "";
		var i = 0;
		var c = c1 = c2 = 0;
 
		while ( i < utftext.length ) {
 
			c = utftext.charCodeAt(i);
 
			if (c < 128) {
				string += String.fromCharCode(c);
				i++;
			}
			else if((c > 191) && (c < 224)) {
				c2 = utftext.charCodeAt(i+1);
				string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
				i += 2;
			}
			else {
				c2 = utftext.charCodeAt(i+1);
				c3 = utftext.charCodeAt(i+2);
				string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
				i += 3;
			}
 
		}
 
		return string;
}


function checkAgree(editForm)
{
	 if(!editForm.agreebox.checked)
	 {
	 	alert('You must agree to the license before you can edit the record');	
	 	return false;
	 }
	 else
	 {
		if( $("#title").val() == "" ||  $("#rep_url").val() == "")
		{
			alert('Please fill the mandatory fields(*) to proceed. ');	
			return false;
		}
		// Concatenate text of authorities in hiddenAuthBox
		$("#hiddenAuthBox").val(function(){
	 		
	 		hiddenAuths = "";
	 		$("#selectedAuthorities").children().each(function() 
	 		{  
	 			hiddenAuths += $(this)[0].textContent + "#@!"; 
	 		})
			//alert(hiddenAuths);
			return hiddenAuths;
	 	});

		if($("#hiddenAuthBox").val() == "")
		{
			if($("#authority").val() == "") {
				alert('Please fill the mandatory fields(*) to proceed. ');	
				return false;
			} else {
				$("#hiddenAuthBox").val($("#authority").val());
			}
		}	
		
	 	$("#hiddenIDbox").val(function(){
	 		
	 		hiddenvalue = "";
	 		$("#selectedSubjects").children().each(function() 
	 		{  
	 			hiddenvalue += $(this).children().text() + " "; 
	 		})
			
			return hiddenvalue;
	 	});
		
		if($("#hiddenIDbox").val() == "")
		{
			alert('Please fill the mandatory fields(*) to proceed. ');	
			return false;
		}
		
		if(<?php if($fgmembersite->CheckLogin()) {echo "\"member\"";} else {echo "\"\"";}?> == "") {
			var url = 'http://databib.org/include/verify_recaptcha.php?recaptcha_challenge_field=' + $('#recaptcha_challenge_field').val() + '&recaptcha_response_field=' + $('#recaptcha_response_field').val();
			if (window.XMLHttpRequest) {              
				AJAX=new XMLHttpRequest();              
			} else {                                  
				AJAX=new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			if (AJAX) {
				AJAX.open("GET", url, false);                             
				AJAX.send(null);
				if (AJAX.responseText != "true")
				{
					alert('Text entered does not correspond to image, please try a different image.');
					Recaptcha.reload();
					return false;
				}
			}
		}
		
	 	return true;
	 }
}

$(document).on("click", "#killSubject", function redraw()
{
	console.log($(this));
	console.log($(this).parent().remove());
});

// Handle autocomplete for authorities
$(
	function() {
    function split( val ) {
        return val.split( /;\s*/ );
    }
    
    function extractLast( term ) {
        return split( term ).pop();
    }

    $( "#authority" )
        .autocomplete({
        	minLength: 2,
            source: function( request, response ) {
                $.getJSON( "./include/getauthorities.php", {
                    term: extractLast( request.term )
                }, function(data) {
						response($.each(data, function(key, value) {
							value.label = utf8_decode(value.label);
							value.value = utf8_decode(value.value);
							return {
								key: key,
								value: value
							}
						}));
					} );
            },
			select: function( event, ui ) {
				 $("#selectedAuthorities").append("<div class = 'selectedsubject'>" + ui.item.label+"<img id='killSubject' style='position:relative; left:10px' src='images/close_icon.gif'/><div id='hiddenAuthId' style='display:none'>~^"+ui.item.id+"</div></div>");                
        		 $(this).val("");
        		 return false;
            }
        });
		
	$("#authority").keypress(function(e) {
	  if(e.keyCode == 13 && this.value != "")
		 {
			 e.preventDefault();
			 $("#selectedAuthorities").append("<div class = 'selectedsubject'>" + this.value +"<img id='killSubject' style='position:relative; left:10px' src='images/close_icon.gif'/></div>");
			 this.value = "";
			 $(this).autocomplete('close');
		 }
	});
});


$(function() {
    function split( val ) {
        return val.split( /;\s*/ );
    }
    
    function extractLast( term ) {
        return split( term ).pop();
    }

    $( "#tags" )
        // don't navigate away from the field on tab when selecting an item
        .bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                    $( this ).data( "autocomplete" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
        	minLength: 1,
            source: function( request, response ) {
                $.getJSON( "./include/getsubjects.php", {
                    term: extractLast( request.term )
                }, response );
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
        		 $("#selectedSubjects").append("<div class = 'selectedsubject'>" + ui.item.label+"<img id='killSubject' style='position:relative; left:10px' src='images/close_icon.gif'/><div id='hiddenId' style='display:none'>"+ui.item.value+"</div></div>");                
        		 $(this).val("");
        		 return false;
            }
        });
        
        
 var options, a;
	jQuery(function(){
		options = 
		{
			source: function(request, response)
				{
					$.ajax({url: 'include/getcountries.php', dataType: "json", data: { 'search_term': request.term },
						success : function( data ) {
 							response( $.map( data, function( item ) {
								return {
										id: item.id_country,
									label: item.country_name,
									value: item.country_name
									}
								}));
							}
						}
					);
				},
                         change: function (event, ui) {
                                        if (!ui.item) {
                                            this.value = '';
                                        }
				},
				select: function( event, ui) {
					$("#hiddenCountryIDbox").val(ui.item.id);
                                    }

		};
		a = $('#location').autocomplete(options);
	});
});
</script>



<?php

include_once('database_connection.php');

$record_id = mysql_real_escape_string(@$_REQUEST['record']);
$sql = "select * from approved left join countries on approved.id_country = countries.id_country where id_rep='$record_id'";
$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);
 
if (!$_POST)
{
	$rep_title = $row['rep_title'];
	$rep_url = $row['rep_url'];
	$rep_authority = $row['rep_authority'];
	$rep_email =  $row['rep_email'];
	$rep_description =  $row['rep_description'];
	$rep_status =  $row['rep_status'];
	$rep_startdate =  $row['rep_startdate'];
	$country_name =  $row['country_name'];
	$rep_access =  $row['rep_access'];
	$rep_deposit =  $row['rep_deposit'];
	$rep_type =  $row['rep_type'];
	$rep_class = $row['classification'];
	$id_country = $row['id_country'];
	$rep_certification = $row['rep_certification'];
	?>

<form method="post" onSubmit="return checkAgree(this);">
<table border="0">
	<tr>
		<td><label for="rep_title">Title of repository*: </label></td>
		<td><input type="text" id="title" name="rep_title"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_title'];?>" /> <br />
		</td>
	</tr>

	<tr>
		<td><label for="rep_url">URL to repository main page*:</label></td>
		<td><input type="text" id="rep_url" name="rep_url"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_url'];?>" /> <br />
		</td>
	</tr>

	<tr>
		<td><label for="rep_authority">Authority (who maintains repository)*:</label></td>
		<td><input type="text" id="authority" name="rep_authority"
			style="width: 300px; height: 20px; margin-bottom: 8px;"/><br />
		</td>
	</tr>

	
	<tr>
		<td><label for="selectedAuthorities">Authorities Selected: </label></td>
        <td><div id="selectedAuthorities" style="width: 300px; margin-bottom: 8px;">
		<?php
			$subquery = "select a.auth_name, a.id_authority from authorities a, approved_authorities n where a.id_authority = n.id_authority AND n.id_record = $record_id order by auth_order";
			mysql_query("set names 'utf8'");
			$subresult = mysql_query($subquery) or die(mysql_error());
			while($subrow = mysql_fetch_array($subresult))
			{
				echo  "<div class = 'selectedsubject'>". $subrow['auth_name'] . "<img id='killSubject' style='position:relative; left:10px' src='images/close_icon.gif'/><div id='hiddenId' style='display:none'>~^". $subrow['id_authority'] ."</div></div>";
			}
		?>
			</div><br/>
		</td>
    </tr>
    
    <?php if ($_SESSION['user_role'] == 'editor' || $_SESSION['user_role'] == 'admin') { ?>
    <tr>
		<td><label for="rep_email">Authority Email:</label></td>
		<td><input type="text" name="rep_email"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_email'];?>" /><br />
		</td>
	</tr>
    
       <tr>
      	<td><label for="rep_subjects">Classification:</label></td>
      	<td>
        	<select name="classification" id="classification" style="width:300px; height:20px; margin-bottom:8px;">
            <option value="">Select One...</option>
            <?php
				mysql_query("set names 'utf8'");
				$results = mysql_query("SELECT id, subject FROM main_subjects ORDER BY subject");
				while ($crow = mysql_fetch_row($results)) {
					echo "<option value='$crow[1]'";
					if ($rep_class == $crow[1]) { echo " selected='selected'"; }
					echo ">$crow[1]</option>";
				}
				mysql_free_result($results);
			?>
            </select>
            <br/>
        </td>
      </tr>
      <?php } ?>

	<tr>
    <td><label for="rep_subjects">Subjects (e.g., FAST) covered*:</label></td>
    <td><input type="text" id="tags" name="rep_subjects" style="width:300px; height:20px; margin-bottom:8px;"/><br/></td>
    </tr>
	<?php
	$subquery = "select subjects.sub_title, subjects.id_subject from subjects, subject_record_assoc_approved where subjects.id_subject = subject_record_assoc_approved.id_subject AND subject_record_assoc_approved.id_record = $record_id";
	mysql_query("set names 'utf8'");
	$subresult = mysql_query($subquery) or die(mysql_error());
	
	echo "<tr><td>Subjects Selected : </td><td><div id='selectedSubjects'>";
	while($subrow = mysql_fetch_array($subresult))
		{
			$orig_subj_ids = $orig_subj_ids . $subrow['id_subject'] . " ";
			echo  "<div class = 'selectedsubject'>". $subrow['sub_title'] . "<img id='killSubject' style='position:relative; left:10px' src='images/close_icon.gif'/><div id='hiddenId' style='display:none'>". $subrow['id_subject'] ."</div></div>";
		}	
	echo "</div><br/></td></tr>";	
	?>
	<tr>
		<td><label for="rep_description">Description:</label></td>
		<td><textarea cols="36" rows="8" name="rep_description"	style="margin-bottom: 8px;"><?php echo $row['rep_description']; ?></textarea><br/></td>
	</tr>

	<tr>
		<td><label for="rep_status">Access</label></td>
		<td><input type="text" name="rep_status"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_status'];?>" /><br />
		</td>
	</tr>

	<tr>
		<td><label for="rep_startdate">Start Date</label></td>
		<td><input type="text" name="rep_startdate"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_startdate'];?>" /><br />
		</td>
	</tr>

	<tr>
		<td><label for="country_name">Country</label></td>
		<td><input type="text" name="country_name" id="location"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['country_name'];?>" /><br />
		</td>
	</tr>

	<tr>
		<td><label for="rep_access">Reuse</label></td>
		<td><input type="text" name="rep_access"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_access'];?>" /><br />
		</td>
	</tr>

	<tr>
		<td><label for="rep_deposit">Deposit</label></td>
		<td><input type="text" name="rep_deposit"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_deposit'];?>" /> <br />
		</td>
	</tr>

	<tr>
		<td><label for="rep_type">Type</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><input type="text" name="rep_type"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_type'];?>" /> <br />
		</td>
	</tr>
	
	<tr>
		<td><label for="rep_certification">Certification</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><input type="text" name="rep_certification"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_certification'];?>" /> <br />
		</td>
	</tr>
	
	<?php
	if(!$fgmembersite->CheckLogin())
	{	
		echo "<tr><td> Show us you are human: </td><td>";
		require_once('recaptchalib.php');
		$publickey = "6Ld5e9gSAAAAAPBl5p4apr3f-BvuHJmWfjxXCqbL"; // you got this from the signup page
		echo recaptcha_get_html($publickey);
		echo "</td></tr>";
		
		/*echo "<tr>
		<td> Show us you are human: </td>
		<td> <img id='captcha' src='/securimage/securimage_show.php' alt='CAPTCHA Image' />  <input type='text' name='captcha_code' size='10' maxlength='6' /> <br>
		<a href='#' onclick='document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false'>[ Different Image ]</a></td>
		</tr>";*/
	}
       ?>
	
	 <tr>
      	<td/>
      	<td><input type="hidden" id="hiddenIDbox" name="hiddenBox" style="width:300px; height:20px; margin-bottom:8px;"/><br/>
			<input type="hidden" id="hiddenCountryIDbox" name="hiddenCountryBox" style="width:300px; height:20px; margin-bottom:8px;" value="<?php echo $row['id_country']; ?>"/><br/>
			<input type="hidden" id="hiddenAuthBox" name="hiddenAuthBox" style="width:310px; height:20px; margin-bottom:8px;"/>
		</td>
     </tr>
</table>
<br />

    <input type ="checkbox" name="agreebox"> I agree that any content that I contribute to Databib may be placed in the public domain using CC0. </a><br><br> </input>


<input type="submit" value="Submit" /> &nbsp;</form>

<?php
			 
} else {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';	

	session_start();
	$securimage = new Securimage();

	function add_authorities($authorities_concat, $insertId, $table)
	{
		require_once("config.php");
		$auth_order = 1;
		$authorities = explode("#@!", $authorities_concat);
		foreach ($authorities as $authority) {
			if(!empty($authority)) {
				$auth = addcslashes($authority, '\'');
				$auth_parts = explode("~^", $auth);
				if(count($auth_parts) == 2) {
					$authId = $auth_parts[1];
				} else {
					$query = "select id_authority from authorities where auth_name = '" . $auth ."'";
					mysql_query("set names 'utf8'");
					$result = mysql_query($query);
					if($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
						$authId = $row['id_authority'];
					} else {
						$query = "INSERT INTO authorities (auth_name) VALUES ('" . $auth . "')";
						if (!mysql_query($query)) {
							echo mysql_error();
							HandleError("Error inserting into the table \nquery was\n $query");
							mail($admin_email, "editnotapprovedrecordindb.php: Authority insertion problem", "Authority insertion query:\n" . $query, "From: Databib Editor-in-Chief <databib@gmail.com>");
							return false;
						}
						$authId = mysql_insert_id();
					}
				}
				$query = "INSERT INTO " . $table . " (id_record, id_authority, auth_order) VALUES (" . $insertId . ", " . $authId  . "," . $auth_order . ")";
				if (!mysql_query($query)) {
					echo mysql_error();
					HandleError("Error inserting into the table \nquery was\n $query");
					mail($admin_email, "editnotapprovedrecordindb.php: notapproved_authorities insertion problem", "Notapproved_authorities insertion query:\n" . $query, "From: Databib Editor-in-Chief <databib@gmail.com>");
					return false;
				}
				$auth_order = $auth_order + 1;
			}
		}
	}

	if(!$fgmembersite->CheckLogin())
	{
		if(!isset($_SESSION['valid']) || $_SESSION['valid'] != true) {
			//invalid code
			echo "The security code entered was incorrect.<br /><br />";
			echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
			exit;
		}
		session_destroy();
		/*if ($securimage->check($_POST['captcha_code']) == false) {
		  // the code was incorrect
		  // you should handle the error so that the form processor doesn't continue

		  // or you can use the following code if there is no validation or you do not know how
	 	 echo "The security code entered was incorrect.<br /><br />";
	  	 echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
	 	 exit;
		}*/
	}
	
	$not_approved_record_id = mysql_real_escape_string($row['id_rep']);
	$not_approved_rep_title = mysql_real_escape_string($_POST['rep_title']);
	$not_approved_rep_url =  mysql_real_escape_string($_POST['rep_url']);
	$not_approved_rep_authority = mysql_real_escape_string($_POST['rep_authority']);
	$not_approved_rep_description =  mysql_real_escape_string($_POST['rep_description']);
	$not_approved_rep_status =  mysql_real_escape_string($_POST['rep_status']);
	$not_approved_rep_startdate =  mysql_real_escape_string($_POST['rep_startdate']);
	$not_approved_country_name =  mysql_real_escape_string($_POST['country_name']);
	$not_approved_rep_access =  mysql_real_escape_string($_POST['rep_access']);
	$not_approved_rep_deposit =  mysql_real_escape_string($_POST['rep_deposit']);
	$not_approved_rep_type =  mysql_real_escape_string($_POST['rep_type']);
	$not_approved_rep_certification = mysql_real_escape_string($_POST['rep_certification']);
	
	$not_approved_contributor = $fgmembersite->UserName();
	$not_approved_editor = mysql_real_escape_string($row['rep_editors']);
	$submitter = $fgmembersite->UserName();
	if(empty($not_approved_editor)) {
		$assignedtoeditor = 'n';
	} else {
		$assignedtoeditor = 'y';
	}
	$reviewed = 'n';
	
	$not_approved_subjectheading_ids = $_POST['hiddenBox'];
	$authorities_concat = $_POST['hiddenAuthBox'];
	$id_country = $_POST['hiddenCountryBox'];
	$mysqldate = mysql_real_escape_string(date('Y-m-d H:i:s'));

	if ($_SESSION['user_role'] == 'editor' || $_SESSION['user_role'] == 'admin') {
		$rep_email = mysql_real_escape_string($_POST['rep_email']);
		$rep_class = mysql_real_escape_string($_POST['classification']);
	} else {
		$rep_email = mysql_real_escape_string($row['rep_email']);
		$rep_class = mysql_real_escape_string($row['classification']);
	}
	
	$subquery = "select subjects.sub_title, subjects.id_subject from subjects, subject_record_assoc_approved where subjects.id_subject = subject_record_assoc_approved.id_subject AND subject_record_assoc_approved.id_record = $not_approved_record_id";
	mysql_query("set names 'utf8'");
	$subresult = mysql_query($subquery) or die(mysql_error());
	
	$orig_subj_ids = "";
	while($subrow = mysql_fetch_array($subresult))
	{
			$orig_subj_ids = $orig_subj_ids . $subrow['id_subject'] . " ";
	}

	$subquery = "select a.auth_name, a.id_authority from authorities a, approved_authorities n where a.id_authority = n.id_authority AND n.id_record = $record_id order by auth_order";
	mysql_query("set names 'utf8'");
	$subresult = mysql_query($subquery) or die(mysql_error());
	$orig_auths = "";
	while($subrow = mysql_fetch_array($subresult))
	{
		$orig_auths = $orig_auths . $subrow['auth_name'] . "~^" . $subrow['id_authority'] ."#@!";
	}
			
	if ($_POST['rep_title'] == $row['rep_title'] &&
		$_POST['rep_url'] == $row['rep_url'] &&
		//$_POST['rep_authority'] == $row['rep_authority'] &&
		$rep_email == $row['rep_email'] &&
		$rep_class == $row['classification'] &&
		$_POST['rep_description'] == $row['rep_description'] &&
		$_POST['rep_status'] == $row['rep_status'] &&
		$_POST['rep_startdate'] == $row['rep_startdate'] &&
		$_POST['country_name'] == $row['country_name'] &&
		$_POST['rep_access'] == $row['rep_access'] &&
		$_POST['rep_deposit'] == $row['rep_deposit'] &&
		$_POST['rep_type'] == $row['rep_type'] &&
		$_POST['rep_certification'] == $row['rep_certification'] &&
		$_POST['hiddenBox'] == $orig_subj_ids &&
		$_POST['hiddenAuthBox'] == $orig_auths) {
		echo "The edit was not recorded since no change was found in the record fields.<br/><br/>";
		echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
		exit;
	}

	$is_submitter_editor = false;
	$editors = explode(',', $not_approved_editor);
	if($_SESSION['user_role'] == 'editor') {
		for($i = 0; $i < count($editors); $i++){
			if($editors[$i] == $_SESSION['user_name']) {
				$is_submitter_editor = true;
			}
		}
	}
	
	if($is_submitter_editor) {
		if(empty($id_country))
			$country_query = "";
		else
			$country_query = ",id_country=" .$id_country;
			
		$sql = "update approved SET rep_title='$not_approved_rep_title', rep_url='$not_approved_rep_url', rep_authority='$not_approved_rep_authority', rep_email='$rep_email', rep_description='$not_approved_rep_description', rep_status='$not_approved_rep_status', rep_startdate='$not_approved_rep_startdate', rep_access='$not_approved_rep_access', rep_deposit='$not_approved_rep_deposit', rep_type='$not_approved_rep_type', rep_editors='$not_approved_editor', classification='$rep_class'" . $country_query . ", modified_date='$mysqldate', rep_certification='$not_approved_rep_certification' where id_rep = $record_id";
		$result = mysql_query($sql) or die(mysql_error());
		echo '<h3>Your updates were committed successfully directly to the database.</h3>';
	} else {
		if(empty($id_country)) {
			$country_query = "";
			$country_val = "";
		} else {
			$country_query = ",id_country";
			$country_val = "," . $id_country;
		}
	//check for existing in notapproved
//	if (mysql_num_rows(mysql_query("SELECT * FROM notapproved WHERE rep_id = $not_approved_record_id")) == 0) {
		$sql = "INSERT INTO notapproved (rep_title, rep_url, rep_authority, rep_email, rep_description, rep_status, rep_startdate, rep_access, rep_deposit, rep_type, rep_editors, submitter, contributors, rep_link_to_approved, assignedtoeditor, reviewed, classification" . $country_query . ", submission_date, assignment_date, rep_certification) VALUES ('$not_approved_rep_title', '$not_approved_rep_url', '$not_approved_rep_authority', '$rep_email', '$not_approved_rep_description', '$not_approved_rep_status', '$not_approved_rep_startdate', '$not_approved_rep_access', '$not_approved_rep_deposit', '$not_approved_rep_type', '$not_approved_editor', '$submitter', '$not_approved_contributor', '$not_approved_record_id', '$assignedtoeditor', '$reviewed', '$rep_class'" . $country_val . ", '$mysqldate', '$mysqldate', '$not_approved_rep_certification')";
/*	} else { 
		$sql = "UPDATE notapproved SET rep_title='$not_approved_rep_title', rep_url='$not_approved_rep_url',
		rep_authority='$not_approved_rep_authority', rep_email='$rep_email', rep_description='$not_approved_rep_description', rep_status='$not_approved_rep_status',
    rep_startdate='$not_approved_rep_startdate',
		rep_access='$not_approved_rep_access', rep_deposit='$not_approved_rep_deposit', rep_type='$not_approved_rep_type',
		rep_editors = '$not_approved_editor', submitter = '$submitter', contributors = '$not_approved_contributor', rep_link_to_approved ='$not_approved_record_id', 
		assignedtoeditor = '$assignedtoeditor', reviewed = '$reviewed', classification='$rep_class', id_country=$id_country, submission_date='$mysqldate' WHERE id_rep = $not_approved_record_id";
	}*/
	
		$result = mysql_query($sql) or die(mysql_error());
		echo 'The edit was successfully recorded. An editor will now review the edit before and approve/deny it.';
		echo '<br/><br/><a href="search.php">Back to Browsing</a>';
		
		$insertId = mysql_insert_id();
		$msg = "An update has been submitted to an existing record in Databib that is assigned to you to review. Please go to http://databib.org/dashboard.php to review to reject, edit and/or approve the update.";
		$msg .= "\n\nRecord title: " . $not_approved_rep_title;
		$msg .= "\n\nRecord URL: http://www.databib.org/viewnotapprovedbyrecordid.php?record=" . $insertId;
		 for($i = 0; $i < count($editors); $i++){
                	$email = mysql_fetch_row(mysql_query("SELECT email FROM users WHERE username = '" . $editors[$i] . "'"));
	                mail($email[0], "Updated Databib Record", $msg, "From: Databib Editor-in-Chief <databib@gmail.com>");
        	}

	}
	
	// Add authorities
	if($is_submitter_editor) {
		$del_sql = "DELETE FROM approved_authorities where id_record = $record_id";
		$chk_result = mysql_query($del_sql) or die(mysql_error());
		add_authorities($authorities_concat, $record_id, "approved_authorities");
	} else {
		add_authorities($authorities_concat, $insertId, "notapproved_authorities");
	}
	
	$subjects = explode(" ", $not_approved_subjectheading_ids);

	if($is_submitter_editor) {
		$del_sql = "DELETE FROM subject_record_assoc_approved where id_record = $record_id";
		$chk_result = mysql_query($del_sql) or die(mysql_error());
	}
	
	foreach ($subjects as $subject) {
		if(empty($subject))
			return true;
		if($is_submitter_editor) {
			$query = "INSERT INTO subject_record_assoc_approved SET id_record = $record_id, id_subject = $subject";
			if (!mysql_query($query)) {
				HandleError("Error inserting into the table \nquery was\n $query");
				die(mysql_error());
				return false;
			}
		} else {
			$query = "INSERT INTO subject_record_assoc SET id_record = $insertId, id_subject = $subject";		
			//echo $query;
			if (!mysql_query($query)) {
				HandleError("Error inserting into the table \nquery was\n $query");
				$query = "delete from notapproved where id_rep=$insertId";
				mysql_query($query);			
				die(mysql_error());
				return false;
			}
		}
	}
	
}

?>
