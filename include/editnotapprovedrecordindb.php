<link rel="stylesheet" href="/css/jquery.ui.all.css" />

<script src="./scripts/dropdown.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>

<script src="./scripts/jquery.ui.core.js"></script>
<script src="./scripts/jquery.ui.widget.js"></script>
<script src="./scripts/jquery.ui.position.js"></script>
<script src="./scripts/jquery.ui.autocomplete.js"></script>


<script src="./include/getsubjects.php"></script>
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
		// Concatenate text of authorities in hiddenAuthBox
		$("#hiddenAuthBox").val(function(){
	 		
	 		hiddenAuths = "";
	 		$("#selectedAuthorities").children().each(function() 
	 		{  
	 			hiddenAuths += $(this)[0].textContent + "#@!"; 
	 		})
			
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


// function to insert the approved record into the real time index of Sphinx
function index_it($insertId, $rep_title, $rep_authority, $rep_description, $country_name, $subjects_concat, $classification)
{
        $sphinx_host = '127.0.0.1';
        $sphinx_user = '';
        $sphinx_pwd = '';
        $sphinx_db = '';
        $sphinx_port = 9306;
        $sphinx_index_table = 'databibrt';

        // Replace inserts if the record does not exist, and updates if exists already
        $replace_qry = "REPLACE INTO $sphinx_index_table ( id, title, authority, description, location, subjects, classification ) VALUES ( $insertId, '$rep_title', '$rep_authority', '$rep_description', '$country_name', '$subjects_concat', '$classification')";

        // Open connection to Sphinx
        $sphinx_connection = new mysqli($sphinx_host, $sphinx_user, $sphinx_pwd, $sphinx_db, $sphinx_port);

        if ($sphinx_connection->connect_errno) {
                echo "<br>Connection to Sphinx failed: $sphinx_connection->connect_error, but this does not affect approval if it is confirmed in this page. </br>";
        }

        if ($sphinx_connection->query($replace_qry) === FALSE) {
                echo "<br>Indexing failed, query: $replace_qry, but this does not affect approval if it is confirmed in this page. </br>";
        }
        $sphinx_connection->close();
}

$record_id = mysql_real_escape_string(@$_REQUEST['record']);
$sql = "select * from notapproved left join countries on notapproved.id_country = countries.id_country where id_rep='$record_id'";
$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);

$username = $fgmembersite->UserName();
 
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
	$editor_note = $row['editor_note'];
	$rep_certification = $row['rep_certification'];
	?>

<form method="post" onSubmit="return checkAgree(this);">
<table border="0">
	<tr>
		<td><label for="rep_title">Title of repository*: </label></td>
		<td><input type="text" name="rep_title"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_title'];?>" /> <br />
		</td>
	</tr>

	<tr>
		<td><label for="rep_url">URL to repository main page*:</label></td>
		<td><input type="text" name="rep_url"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_url'];?>" /> <br />
		</td>
	</tr>

	<tr>
		<td><label for="rep_authority">Authority (who maintains repository)*:</label></td>
		<td><input type="text" id="authority" name="rep_authority"
			style="width: 300px; height: 20px; margin-bottom: 8px;" /><br />
		</td>
	</tr>
	
	<tr>
		<td><label>Authorities Selected: </label></td>
        <td><div id="selectedAuthorities" style="width: 300px; margin-bottom: 8px;">
		<?php
			$subquery = "select a.auth_name, a.id_authority from authorities a, notapproved_authorities n where a.id_authority = n.id_authority AND n.id_record = $record_id";
			mysql_query("set names 'utf8'");
			$subresult = mysql_query($subquery) or die(mysql_error());
			while($subrow = mysql_fetch_array($subresult))
			{
				echo  "<div class = 'selectedsubject'>". $subrow['auth_name'] . "<img id='killSubject' style='position:relative; left:10px' src='images/close_icon.gif'/><div id='hiddenId' style='display:none'>". $subrow['id_authority'] ."</div></div>";
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
				$results = mysql_query("SELECT * FROM main_subjects ORDER BY subject");
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
	$subquery = "select subjects.sub_title, subjects.id_subject from subjects, subject_record_assoc where subjects.id_subject = subject_record_assoc.id_subject AND subject_record_assoc.id_record = $record_id";
	mysql_query("set names 'utf8'");
	$subresult = mysql_query($subquery) or die(mysql_error());
	
	
	echo "<tr><td>Subjects Selected : </td><td><div id='selectedSubjects'>";
		while($subrow = mysql_fetch_array($subresult))
				{
						echo  "<div class = 'selectedsubject'>". $subrow['sub_title'] . "<img id='killSubject' style='position:relative; left:10px' src='images/close_icon.gif'/><div id='hiddenId' style='display:none'>". $subrow['id_subject'] ."</div></div>";
				}	
	echo "</div><br/></td></tr>";	
	?>
	<tr>
		<td><label for="rep_description">Description:</label></td>
		<td><textarea cols="36" rows="8" name="rep_description" style="margin-bottom: 8px;"><?php echo $row['rep_description'];?></textarea><br/>
		</td>
	</tr>
	
	
	<tr>
		<td><label for="rep_status">Access:</label></td>
		<td><input type="text" name="rep_status"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_status'];?>" /><br />
		</td>
	</tr>

	<tr>
		<td><label for="rep_startdate">Start date:</label></td>
		<td><input type="text" name="rep_startdate"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_startdate'];?>" /><br />
		</td>
	</tr>

	<tr>
		<td><label for="country_name">Country:</label></td>
		<td><input type="text" name="country_name" id="location"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['country_name'];?>" /><br />
		</td>
	</tr>

	<tr>
		<td><label for="rep_access">Reuse:</label></td>
		<td><input type="text" name="rep_access"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_access'];?>" /><br />
		</td>
	</tr>

	<tr>
		<td><label for="rep_deposit">Deposit:</label></td>
		<td><input type="text" name="rep_deposit"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_deposit'];?>" /> <br />
		</td>
	</tr>

	<tr>
		<td><label for="rep_type">Type:</label>
	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><input type="text" name="rep_type"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_type'];?>" /> <br />
		</td>
	</tr>
	
	<tr>
		<td><label for="rep_certification">Certification:</label>
	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><input type="text" name="rep_certification"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_certification'];?>" /> <br />
		</td>
	</tr>
	
	<tr><td/>
      	<td><input type="hidden" id="hiddenIDbox" name="hiddenBox" style="width:300px; height:20px; margin-bottom:8px;"/><br/>
			<input type="hidden" id="hiddenCountryIDbox" name="hiddenCountryBox" style="width:300px; height:20px; margin-bottom:8px;" value="<?php echo $row['id_country']; ?>"/> <br/>
			<input type="hidden" id="hiddenAuthBox" name="hiddenAuthBox" style="width:310px; height:20px; margin-bottom:8px;"/>
		</td>
     </tr>
</table>
<br />
    <input type ="checkbox" name="agreebox"> I agree that any content that contribute to Databib may be placed in the public domain using CC0. <br><br> </input>


<input type="submit" value="Approve" /> &nbsp;</form>

<?php
			 
} else {

	function add_authorities($authorities_concat, $insertId)
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
				$query = "INSERT INTO approved_authorities (id_record, id_authority, auth_order) VALUES (" . $insertId . ", " . $authId  . "," . $auth_order . ")";
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
	 
	$sql = "select * from notapproved left join countries on notapproved.id_country = countries.id_country where id_rep ='$record_id'";
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$rep_link_to_approved = $row['rep_link_to_approved'];
	$rep_editors = mysql_real_escape_string($row['rep_editors']);
	$submitter = mysql_real_escape_string($row['submitter']);

	$rep_title =  mysql_real_escape_string($_POST['rep_title']);
	$rep_url =   mysql_real_escape_string($_POST['rep_url']);
	//$rep_authority =  mysql_real_escape_string($_POST['rep_authority']);
	$rep_authority = $row['rep_authority']; // copy value from table, new authority implementation should take over
	$rep_email =  mysql_real_escape_string($_POST['rep_email']);
	$rep_description =  mysql_real_escape_string($_POST['rep_description']);
	$editor_note = mysql_real_escape_string($row['editor_note']);
	 
	$rep_status =  mysql_real_escape_string($_POST['rep_status']);
	$rep_startdate =  mysql_real_escape_string($_POST['rep_startdate']);
	$country_name = mysql_real_escape_string($_POST['country_name']);
	$rep_access = mysql_real_escape_string($_POST['rep_access']);
	$rep_deposit = mysql_real_escape_string($_POST['rep_deposit']);
	$rep_type = mysql_real_escape_string($_POST['rep_type']);
	$rep_class = mysql_real_escape_string($_POST['classification']); 
	$subjectheading_ids = addcslashes($_POST['hiddenBox'], '\'');
	$authorities_concat = $_POST['hiddenAuthBox'];
	
	$id_country = addcslashes($_POST['hiddenCountryBox'], '\'');
	$rep_certification = mysql_real_escape_string($_POST['rep_certification']);
	
	$contributors = $fgmembersite->UserName() . ',' . $row['contributors'];

	$subjects_concat = '';

	if($rep_link_to_approved != -1) {
		// move data to approved table
		$sql = "UPDATE approved set rep_title='$rep_title', rep_url='$rep_url', rep_authority='$rep_authority', rep_email = '$rep_email', rep_description='$rep_description', rep_status='$rep_status',
    		rep_startdate='$rep_startdate', rep_access='$rep_access', editor_note='$editor_note',
    		rep_deposit='$rep_deposit', rep_type='$rep_type',  contributors = '$contributors', classification = '$rep_class', id_country = '$id_country', rep_certification = '$rep_certification' 
    		where id_rep ='$rep_link_to_approved'";
		$result = mysql_query($sql) or die(mysql_error());
		
		$insertId = $rep_link_to_approved;	
		
		// delete authorities from the approved_authorities and re-insert them
		$query = "DELETE FROM approved_authorities WHERE id_record=" . $insertId;
		$result = mysql_query($query) or die(mysql_error());
		add_authorities($authorities_concat, $insertId);
		
		$subjects = explode(" ", $subjectheading_ids);
	
		foreach ($subjects as $subject) {
				if(empty($subject))
				{
					continue;		
				}
				
				$query = "INSERT INTO subject_record_assoc_approved SET id_record = $insertId, id_subject = $subject";
				mysql_query("set names 'utf8'");
				$sub_qry = "SELECT sub_title FROM subjects where id_subject = $subject";
				$result = mysql_query($sub_qry);
				$row = mysql_fetch_array($result);
				if( !empty($subjects_concat) ){
        	                       	$subjects_concat = $subjects_concat . ", ";
                	        }
                                $subjects_concat = $subjects_concat . $row['sub_title'];
			}
		
	} else {
		
		include_once('post_tweet.php');
		$mysqldate = mysql_real_escape_string(date('Y-m-d H:i:s'));
		$sql = $query ="INSERT INTO approved SET rep_title='$rep_title',
    		rep_url='$rep_url', rep_authority='$rep_authority', rep_email = '$rep_email', rep_status = '$rep_status',
    		rep_startdate = '$rep_startdate', rep_access = '$rep_access', editor_note='$editor_note',
    		rep_deposit = '$rep_deposit', rep_type = '$rep_type', rep_editors = '$username', submitter = '$submitter', 
    		contributors = '$contributors', rep_description='$rep_description' , creation_date = '$mysqldate', classification = '$rep_class', 
			id_country = '$id_country', rep_certification = '$rep_certification' ";
    		
		$result = mysql_query($sql) or die(mysql_error());
		
			
		$insertId = mysql_insert_id();
		
		add_authorities($authorities_concat, $insertId);
		
		$subjects = explode(" ", $subjectheading_ids);
	
	
			foreach ($subjects as $subject) {
				
					if(empty($subject))
					{
							continue;		
					}
					
					$query = "INSERT INTO subject_record_assoc_approved SET id_record = $insertId, id_subject = $subject";
					//echo $query;
					if (!mysql_query($query)) {
							echo "error";
							HandleError("Error inserting into the table \nquery was\n $query");
							$query = "delete from approved where id_rep=$insertId";
							mysql_query($query);
							$query = "delete from subject_record_assoc_approved where id_record=$insertId";
							mysql_query($query);
							return false;
					}
					mysql_query("set names 'utf8'");
					$sub_qry = "SELECT sub_title FROM subjects where id_subject = $subject";
	                                $result = mysql_query($sub_qry);
        	                        $row = mysql_fetch_array($result);
                	                if( !empty($subjects_concat) ){
                        	                $subjects_concat = $subjects_concat . ", ";
                                	}
	                                $subjects_concat = $subjects_concat . $row['sub_title'];
				}


		$shortUrl = getSmallLink("http://databib.org/viewapprovedbyrecordid.php?record=$insertId");

		
		$tweetlength = strlen("             was   added to @databib, $shortUrl");
		$titleLength = 140 - $tweetlength;
		
		if(strlen($rep_title) > $titleLength)
		{
			$rep_title = substr($rep_title,0,$titleLength-3);
			$rep_title = $rep_title . "..";
		}
		$tweet_text = "\"$rep_title\" was added to @databib, $shortUrl";
			
		post_tweet($tweet_text);
	}

	// Email the other editors notifying them that the record has been reviewed.
	$msg = "This is to notify that a Databib record that has been assigned to you has just been already reviewed by another editor. You can check the published record through the URL below.";
	$msg .= "\n\nRecord title: " . $rep_title;
	$msg .= "\n\nRecord URL: http://www.databib.org/viewapprovedbyrecordid.php?record=" . $insertId;
	
	$editors = explode(',', $rep_editors);
	for($i = 0; $i < count($editors); $i++){
		if($editors[$i] != $username) {
			$mail_add = mysql_fetch_row(mysql_query("SELECT email FROM users WHERE username = '$username'"))[0] . ', databib@gmail.com';
			$email = $mail_add[0];
			mail($email, "Databib Record is reviewed by another editor", $msg, "From: Databib Editor-in-Chief <databib@gmail.com>");
		}
	}
	
	$query = "delete from subject_record_assoc where id_record=$record_id";
	mysql_query($query);

	$sql = "delete from notapproved where id_rep ='$record_id'";
	$result = mysql_query($sql) or die(mysql_error());

	$subjects_concat = mysql_real_escape_string($subjects_concat);
	index_it($insertId, $rep_title, $rep_authority, $rep_description, $country_name, $subjects_concat, $rep_class); 
	
	echo  '<h2>The record has been committed to the database!</h2>';
	 
	
	$sql = "SELECT * FROM notapproved where reviewed = 'n' AND rep_editors=\"$username\"";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result)) {
		$row = mysql_fetch_array($result);
		$record_id = $row['id_rep'];
		echo '<p><h3>Click';
		echo '<a style="color:red;text-decoration:none" href="viewnotapprovedbyrecordid.php?record='.$record_id.'"> here</a> for the next record</h3></p>';
	}
	 
		
}

?>

