<link rel="stylesheet" href="/css/jquery.ui.all.css" />

<script src="./scripts/dropdown.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>

<script src="./scripts/jquery.ui.core.js"></script>
<script src="./scripts/jquery.ui.widget.js"></script>
<script src="./scripts/jquery.ui.position.js"></script>
<script src="./scripts/jquery.ui.autocomplete.js"></script>


<script src="./include/getsubjects.php"></script>
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
});
</script>


<?php

include_once('database_connection.php');
$record_id = mysql_real_escape_string(@$_REQUEST['record']);
$sql = "select * from notapproved where id_rep='$record_id'";
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
	$subquery = "select subjects.sub_title, subjects.id_subject from subjects, subject_record_assoc where subjects.id_subject = subject_record_assoc.id_subject AND subject_record_assoc.id_record = $record_id";
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
		<td><textarea cols="36" rows="8" name="rep_description" style="margin-bottom: 8px;"><?php echo $row['rep_description'];?></textarea><br/>
		</td>
	</tr>
	
	
	<tr>
		<td><label for="rep_status">Open/Closed/Commercial:</label></td>
		<td><input type="text" name="rep_status"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_status'];?>" /><br />
		</td>
	</tr>

	<tr>
		<td><label for="rep_startdate">Start date of repository:</label></td>
		<td><input type="text" name="rep_startdate"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_startdate'];?>" /><br />
		</td>
	</tr>

	<tr>
		<td><label for="rep_location">Location (Lat/Long or Country)</label></td>
		<td><input type="text" name="rep_location"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_location'];?>" /><br />
		</td>
	</tr>

	<tr>
		<td><label for="rep_access">Access (open, licenses, closed)</label></td>
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
		<td><label for="rep_type">Type of repository (institutional,
		disciplinary, <br />
		commercial, etc.)</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><input type="text" name="rep_type"
			style="width: 300px; height: 20px; margin-bottom: 8px;"
			value="<?php echo $row['rep_type'];?>" /> <br />
		</td>
	</tr>
	
	<tr>
      	<td><input type="hidden" id="hiddenIDbox" name="hiddenBox" style="width:300px; height:20px; margin-bottom:8px;"/><br/></td>
     </tr>

</table>
<br />
    <input type ="checkbox" name="agreebox"> I agree that any content that contribute to Databib may be placed in the public domain using CC0. <br><br> </input>


<input type="submit" value="Approve" /> &nbsp;</form>

<?php
			 
} else {
	 
	$sql = "select * from notapproved where id_rep ='$record_id'";
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$rep_link_to_approved = $row['rep_link_to_approved'];
	$rep_editors = mysql_real_escape_string($row['rep_editors']);
	$submitter = mysql_real_escape_string($row['submitter']);

	$rep_title =  mysql_real_escape_string($_POST['rep_title']);
	$rep_url =   mysql_real_escape_string($_POST['rep_url']);
	$rep_authority =  mysql_real_escape_string($_POST['rep_authority']);
	$rep_description =  mysql_real_escape_string($_POST['rep_description']);
	 
	$rep_status =  mysql_real_escape_string($_POST['rep_status']);
	$rep_startdate =  mysql_real_escape_string($_POST['rep_startdate']);
	$rep_location = mysql_real_escape_string($_POST['rep_location']);
	$rep_access = mysql_real_escape_string($_POST['rep_access']);
	$rep_deposit = mysql_real_escape_string($_POST['rep_deposit']);
	$rep_type = mysql_real_escape_string($_POST['rep_type']);
	$subjectheading_ids = addcslashes($_POST['hiddenBox'], '\'');
	
	
	$contributors = $fgmembersite->UserName() . ',' . $row['contributors'];

	if($rep_link_to_approved != -1) {
		// move data to approved table
		$sql = "UPDATE approved set rep_title='$rep_title', rep_url='$rep_url', rep_authority='$rep_authority',
    		rep_description='$rep_description', rep_status='$rep_status',
    		rep_startdate='$rep_startdate', rep_location='$rep_location', rep_access='$rep_access',
    		rep_deposit='$rep_deposit', rep_type='$rep_type',  contributors = '$contributors' 
    		where id_rep ='$rep_link_to_approved'";
		$result = mysql_query($sql) or die(mysql_error());
		
		
		$subjects = explode(" ", $subjectheading_ids);
	
		foreach ($subjects as $subject) {
					if(empty($subject))
					{
							continue;		
					}
					
					$query = "INSERT INTO subject_record_assoc_approved SET id_record = $insertId, id_subject = $subject";
			}
		
	} else {
		
		include_once('post_tweet.php');
		$mysqldate = mysql_real_escape_string(date('Y-m-d'));
		$sql = $query ="INSERT INTO approved SET rep_title='$rep_title',
    		rep_url='$rep_url', rep_authority='$rep_authority', 
    		rep_status = '$rep_status',
    		rep_startdate = '$rep_startdate', rep_location = '$rep_location', rep_access = '$rep_access',
    		rep_deposit = '$rep_deposit', rep_type = '$rep_type', rep_editors = '$rep_editors', submitter = '$submitter', 
    		contributors = '$contributors', rep_description='$rep_description' , creation_date = '$mysqldate'";
    		
		$result = mysql_query($sql) or die(mysql_error());
		
			
		$insertId = mysql_insert_id();
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


	$query = "delete from subject_record_assoc where id_record=$record_id";
	mysql_query($query);

	$sql = "delete from notapproved where id_rep ='$record_id'";
	$result = mysql_query($sql) or die(mysql_error());
	 
	echo  '<h2>The record has been committed to the database!</h2>';
	 
	$username = $fgmembersite->UserName();
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

