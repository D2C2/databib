<?PHP
require_once("./include/membersite_config.php");
if(!$fgmembersite->CheckLogin())
{
	session_start();
	$_SESSION["ORIG_LINK"] = $_SERVER['REQUEST_URI'];

    $fgmembersite->RedirectToURL("login.php");
    exit;
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
<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="handheld" />
<link rel="shortcut icon" href="images/bullet.ico" type="image/x-icon" />

<script src="/scripts/dropdown.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>

<script src="./scripts/jquery.ui.core.js"></script>
<script src="./scripts/jquery.ui.widget.js"></script>
<script src="./scripts/jquery.ui.position.js"></script>
<script src="./scripts/jquery.ui.autocomplete.js"></script>


<script src="./include/getsubjects.php"></script>
<script type="text/javascript">
function editNote(id_note, id_rep, table)
{
	url = 'include/note_manager.php?type=' + table + '&id=' + id_rep;
	popupWindow = window.open(url,'popUpWindow','height=400,width=450,left=600,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');
}

function update_note(note)
{
	document.getElementById("editor_note").innerHTML = note;
}

function passSubjects(form)
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
	
	
	$(function() {
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}
		$( "#tags1" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 4,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						availableTags, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = split( this.value );
					// remove the current input	
					terms.pop();
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					return false;
				}
			});
	});
	</script>
	<style>
		del {color:gray;}
		ins {color:red;text-decoration:none;}
	</style>
<title>Databib</title>
</head>

<body>

<div id="page-content">
<?php include "include/header.php"; ?>

  <div id="wrapper2">
    <div id="wrapper">
      <div id="body-content" style ="width: 800px">
	    <br/><br/><br/>
        <div id='fg_membersite_content' style ="width: 700px">
		 <?php
		  include("./include/getnotapprovedbyrecordid.php");
		 ?>
		<br><br><br>
		</div>
      </div>    
    </div>
  </div>

<?php include "include/footer.php"; ?>

</div>
</body>
</html>