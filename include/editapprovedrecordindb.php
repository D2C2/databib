<link rel="stylesheet" href="/css/jquery.ui.all.css" />

<script src="./scripts/dropdown.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>

<script src="./scripts/jquery.ui.core.js"></script>
<script src="./scripts/jquery.ui.widget.js"></script>
<script src="./scripts/jquery.ui.position.js"></script>
<script src="./scripts/jquery.ui.autocomplete.js"></script>



<script type="text/javascript">


function checkAgree(editForm)
{
	 if(!editForm.agreebox.checked)
	 {
	 	alert('You must agree to the license before you can edit the record');	
	 	return false;
	 }
	 else
	 {
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

$("#killSubject").live("click",function redraw()
{
	console.log($(this));
	console.log($(this).parent().remove());
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
					$.ajax({url: 'http://api.geonames.org/searchJSON', dataType: "jsonp", data: { 'name_startsWith': request.term,  'maxRows' : 10, 'username' : 'databib' },  
					success : function( data ) {
									response( $.map( data.geonames, function( item ) {
										return {
											label: item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName,
											value: item.name
										}
									}));
								}
							}
						);
				}
		};
		a = $('#location').autocomplete(options);
	});
});
</script>



<?php

include_once('database_connection.php');
$record_id = mysql_real_escape_string(@$_REQUEST['record']);
$sql = "select * from approved where id_rep='$record_id'";
$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);
 
if (!$_POST)
{
	$rep_title = $row['rep_title'];
	$rep_url = $row['rep_url'];
	$rep_authority = $row['rep_authority'];
	$rep_description =  $row['rep_description'];
	$rep_status =  $row['rep_status'];
	$rep_startdate =  $row['rep_startdate'];
	$rep_location =  $row['rep_location'];
	$rep_access =  $row['rep_access'];
	$rep_deposit =  $row['rep_deposit'];
	$rep_type =  $row['rep_type'];
	
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
		<td><input type="text" name="rep_authority"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_authority'];?>" /><br />
		</td>
	</tr>

	<tr>
    <td><label for="rep_subjects">Subjects (e.g., LCSH) covered*:</label></td>
    <td><input type="text" id="tags" name="rep_subjects" style="width:300px; height:20px; margin-bottom:8px;"/><br/></td>
    </tr>
	<?php
	$subquery = "select subjects.sub_title, subjects.id_subject from subjects, subject_record_assoc_approved where subjects.id_subject = subject_record_assoc_approved.id_subject AND subject_record_assoc_approved.id_record = $record_id";
	$subresult = mysql_query($subquery) or die(mysql_error());
	
	
	echo "<tr><td>Subjects Selected : </td><td><div id='selectedSubjects'>";
		while($subrow = mysql_fetch_array($subresult))
				{
						echo  "<div class = 'selectedsubject'>". $subrow['sub_title'] . "<img id='killSubject' style='position:relative; left:10px' src='images/close_icon.gif'/><div id='hiddenId' style='display:none'>". $subrow['id_subject'] ."</div></div>";
				}	
	echo "</div></td><br/></tr>";	
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
		<td><label for="rep_location">Location</label></td>
		<td><input type="text" name="rep_location" id="location"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_location'];?>" /><br />
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
	
	<?php
	if(!$fgmembersite->CheckLogin())
	{	
		echo "<tr>
		<td> Show us you are human: </td>
		<td> <img id='captcha' src='/securimage/securimage_show.php' alt='CAPTCHA Image' />  <input type='text' name='captcha_code' size='10' maxlength='6' /> <br>
		<a href='#' onclick='document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false'>[ Different Image ]</a></td>
		</tr>";
	}
       ?>
	
	 <tr>
      	<td><input type="hidden" id="hiddenIDbox" name="hiddenBox" style="width:300px; height:20px; margin-bottom:8px;"/><br/></td>
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


	if(!$fgmembersite->CheckLogin())
	{
		if ($securimage->check($_POST['captcha_code']) == false) {
		  // the code was incorrect
		  // you should handle the error so that the form processor doesn't continue

		  // or you can use the following code if there is no validation or you do not know how
	 	 echo "The security code entered was incorrect.<br /><br />";
	  	 echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
	 	 exit;
		}
	}
	
	$not_approved_record_id = mysql_real_escape_string($row['id_rep']);
	$not_approved_rep_title = mysql_real_escape_string($_POST['rep_title']);
	$not_approved_rep_url =  mysql_real_escape_string($_POST['rep_url']);
	$not_approved_rep_authority = mysql_real_escape_string($_POST['rep_authority']);
	$not_approved_rep_description =  mysql_real_escape_string($_POST['rep_description']);
	$not_approved_rep_status =  mysql_real_escape_string($_POST['rep_status']);
	$not_approved_rep_startdate =  mysql_real_escape_string($_POST['rep_startdate']);
	$not_approved_rep_location =  mysql_real_escape_string($_POST['rep_location']);
	$not_approved_rep_access =  mysql_real_escape_string($_POST['rep_access']);
	$not_approved_rep_deposit =  mysql_real_escape_string($_POST['rep_deposit']);
	$not_approved_rep_type =  mysql_real_escape_string($_POST['rep_type']);
	$not_approved_contributor = $fgmembersite->UserName();
	$not_approved_editor = mysql_real_escape_string($row['rep_editors']);
	$submitter = "";
	$assignedtoeditor = 'n';
	$reviewed = 'n';
	$not_approved_subjectheading_ids = $_POST['hiddenBox'];
	



	$sql = "INSERT INTO notapproved set rep_title='$not_approved_rep_title', rep_url='$not_approved_rep_url',
    rep_authority='$not_approved_rep_authority',
    rep_description='$not_approved_rep_description', rep_status='$not_approved_rep_status',
    rep_startdate='$not_approved_rep_startdate', rep_location='$not_approved_rep_location', 
    rep_access='$not_approved_rep_access', rep_deposit='$not_approved_rep_deposit', rep_type='$not_approved_rep_type',
    rep_editors = '$not_approved_editor', submitter = '$submitter', contributors = '$not_approved_contributor', rep_link_to_approved ='$not_approved_record_id', 
    assignedtoeditor = '$assignedtoeditor', reviewed = '$reviewed'";

	$result = mysql_query($sql) or die(mysql_error());
	echo 'The edit was successfully recorded. An editor will now review the edit before and approve/deny it.';
	echo '<br/><br/><a href="search.php">Back to Browsing</a>';
	
	
	$insertId = mysql_insert_id();
	$subjects = explode(" ", $not_approved_subjectheading_ids);

	foreach ($subjects as $subject) {
		if(empty($subject))
			return true;
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

?>

