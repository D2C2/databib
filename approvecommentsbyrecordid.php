<?PHP
require_once("./include/membersite_config.php");
$fgmembersite->CheckLogin();

include_once('include/database_connection.php');
$record_id = mysql_real_escape_string(@$_REQUEST['record']);
$sql = "select * from approved left join countries on approved.id_country = countries.id_country where id_rep ='$record_id'";
$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);
$country = $row['country_name'];
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
<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="handheld" />
<link rel="shortcut icon" href="/images/bullet.ico" type="image/x-icon" />

<script src="/scripts/dropdown.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>

<script type="text/javascript">

$(function() {
	
	  $("#post").click(function() {
		  
		  var commenttext =  $.trim($("#commenttext").val());
		  var recordid = $("#recordid").val();  
	      var author = $("#author").val();  
	      
	      var dataString = 'comment='+ commenttext + '&recordid=' + recordid + '&author=' + author ;  
		  
		  $.ajax({
	      type: "POST",
	      url: "./include/insertcomments.php",
	      data: dataString,
	      success: function(data) {
			$('#commentsform').append("<div id='message'></div>");
	        $('#message').html("<p> Your comment was successfully posted !</p>");
	      },
	      error : function(XMLHttpRequest, textStatus, errorThrown) {
	    		$('#commentsform').append("<div id='message'></div>");
		        $('#message').html("<p> <font color=\"Red\"> Your must be logged in !</font></p>");
	    	  }
	      
	     });
	    return false;
		});
});

	
</script>


<title>Databib</title>
</head>

<body>

<div id="page-content">
<?php include "include/header.php"; ?>

  <div id="wrapper2">
    <div id="wrapper">
      <div id="body-content" width="900px">
	    <br/><br/><br/>
		<div class="col">
			<div id='fg_membersite_content'>
				
					 <?php
					 $hide_buttons = true;
					  include("./include/getapprovedbyrecordid.php");
					 ?>
			</div>
			<br/><br/><hr/><br/><br/>
			
			<form name="approveconfirm" method="post" action="">
			<?php
			  include("./include/getcommentsforapprovalbyrecordid.php");
			 ?>
			 </form>
  	     </div>
      </div>    
    </div>
  </div>
	
<?php include "include/footer.php"; ?>

</div>
</body>
</html>
