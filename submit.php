<?PHP
require_once("./include/membersite_config.php");
if(isset($_POST['submitted']))
{
   if($fgmembersite->Login())
   {
        $fgmembersite->RedirectToURL("login.php");
   }
}
$fgmembersite->CheckLogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css"/>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="Author" content="Siddharth Singh" />
<meta name="Keywords" content="Databib data curation bibliography bibliographies Michael Witt Mike Giarlo Purdue Penn State University library science libraries repositories" />
<meta name="Description" content="Databib is a collaborative, annotated bibliography of primary research data repositories developed with support from the Institute of Museum and Library Services." />
<meta name="Robots" content="all" />

<link href="http://www.lib.purdue.edu/resources/css/site.css" rel="stylesheet" type="text/css" />
<link href="./css/siteupdates.css" rel="stylesheet" type="text/css" />
<link href="http://www.lib.purdue.edu/resources/css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="http://www.lib.purdue.edu/resources/css/print.css" rel="stylesheet" type="text/css" media="handheld" />
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

		if( $("#title").val() == "" ||  $("#authority").val() == "" || $("#url").val() == "")
		{
			alert('Please fill the mandatory fields(*) to proceed. ');	
			return false;
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

	 	return true;
	 }
}

$("#killSubject").live("click",function redraw()
{
	console.log($(this));
	console.log($(this).parent().remove());
});



function checkNullSubject() {

			hiddenvalue = "";
	 		$("#selectedSubjects").children().each(function() 
	 		{  
	 			hiddenvalue += $(this).children().text() + " "; 
	 		})
	 		
	 		
	 		if(hiddenvalue == "")
	 		{
				return true;
			}
			else
			{
				return false;
			}
}

$(



	function() {
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
            change: function(event, ui) { if(!ui.item){ alert("No subjects selected: You can only use subjects from the predefined list of subjects (Wait till it autocompletes)");} },
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
			

</script>

<title>Databib</title>
</head>

<body>

<div id="page-content">
  <div id="header">
    <div id="new-header-content">
	  <div style="position: relative; z-index:100">
	    <img style="float:left; margin:0px; padding:0px;" id="imagebanner" alt="Header" src="/images/header.jpg"/>
	  </div> 
    </div> 
  </div>
  

  <div id="navigation">
   <div id="navigation-content">
    <ul>
	<li><a href="index.php">Home</a></li><span class="pipe">|</span>
	<li><a href="participate.php">Participate</a></li><span class="pipe">|</span>
	<li><a href="connect.php">Connect</a></li><span class="pipe">|</span>
	<li><a href="about.php">About</a></li>
	
	<?
	    $sessionvar = $fgmembersite->GetLoginSessionVar();
         if(empty($_SESSION[$sessionvar]))
         {	 
            echo("<li style=\"padding-left:490px;\"><a href='login.php'>Login/Register</a></li>");
         }
        else 
        {
        	echo("<li style=\"padding-left:370px;\"><a href='dashboard.php'>Dashboard</a></li>");
        	echo("<li style=\"padding-left:8px;\"><a href='accountsettings.php'>Account</a></li>");
        	echo("<li ><a href='logout.php'>Logout</a></li>");
        }
	   ?>
   </ul>
   <div style="clear:both"></div>
   <div style="clear:both"></div>
    </div>
  </div>

  <div id="wrapper2">
    <div id="wrapper">
      <div id="body-content">
	    <br/><br/><br/>

        
  <form name="submit_confirm" method="post" action="submit-confirmation.php" onSubmit="return checkAgree(this);"> 
  	 <table border="0">
      <tr>
    	<td><label for="rep_title" >Title of repository*: </label></td>
    	<td><input type="text" id="title" name="rep_title" style="width:300px; height:20px; margin-bottom:8px;"/> <br/></td>
      </tr>
      
      <tr>
    	<td><label for="rep_url"  >URL to repository main page*:</label></td>
    	<td><input type="text" id="url" name="rep_url" style="width:300px; height:20px; margin-bottom:8px;"/> <br/></td>
      </tr>
      
      <tr>
      	<td><label for="rep_authority"  >Authority (who maintains repository)*:</label></td>
      	<td><input type="text" id="authority" name="rep_authority" style="width:300px; height:20px; margin-bottom:8px;"/><br/></td>
      </tr>
      
      <tr>
      	<td><label for="rep_subjects">Subjects (e.g., LCSH) covered*:</label></td>
      	<td><input type="text" id="tags" name="rep_subjects" id = "rep_subjects" style="width:300px; height:20px; margin-bottom:8px;"/><br/></td>
       </tr>
      <tr><td>Subjects Selected : </td><td><div id="selectedSubjects"></div></td><br/></tr>
      <tr>
      	<td><label for="rep_description">Description:</label> </td>
      	<td>
      		<textarea cols="36" rows="8" name="rep_description" style="margin-bottom:8px;"></textarea> <br/>
     	 </td>
      </tr>
      
      <tr>
      	<td> <label for="rep_status">Access</label> </td>
      	<td><input type="text" name="rep_status" style="width:300px; height:20px; margin-bottom:8px;"/> <br/></td>
      </tr>
      
      <tr>
      	<td><label for="rep_startdate">Start date</label> </td>
      	<td><input type="text" name="rep_startdate" style="width:300px; height:20px; margin-bottom:8px;"/><br/></td>
      </tr>
      
      <tr>
      	<td><label for="rep_location">Location</label></td>
      	<td><input type="text" name="rep_location" id="location" style="width:300px; height:20px; margin-bottom:8px;"/> <br/></td>
      </tr>
      
      <tr>
      	<td> <label for="rep_access">Reuse</label></td>
      	<td>  <input type="text" name="rep_access" style="width:300px; height:20px; margin-bottom:8px;"/> <br/></td>
      </tr>
      
      <tr>
      	<td>  <label for="rep_deposit">Deposit</label> </td>
      	<td><input type="text" name="rep_deposit" style="width:300px; height:20px; margin-bottom:8px;"/> <br/></td>
      </tr>
      
      <tr>
      	<td><label for="rep_type">Type</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      	<td> <input type="text" name="rep_type" style="width:300px; height:20px; margin-bottom:8px;"/> <br/></td>
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
      
    </table> <br/>
    <input type ="checkbox" name="agreebox"> I agree that any content that I contribute to Databib may be placed in the public domain using CC0. <br><br> </input>

    <input type="submit" value="Submit"/> &nbsp;
  </form>
  
<br/><br/><br/>
        
      </div>    
    </div>
  </div>

<div style="clear:both;width: 974px;margin: 0;margin-right: auto;margin-left: auto;background:#000000;no-repeat;display: block;height: 37px; padding-right:0px;">
<img src="/images/tagline.jpg" />
     <div id="footer-copyright">
	 <p xmlns:dct="http://purl.org/dc/terms/" xmlns:vcard="http://www.w3.org/2001/vcard-rdf/3.0#">
     <a rel="license"
     href="http://creativecommons.org/publicdomain/zero/1.0/">
    <img src="http://i.creativecommons.org/p/zero/1.0/88x31.png" style="border-style: none;" alt="The content, data, and source code of Databib are dedicated to the Public Domain using the CC0 protocol." />
  </a></div>
</div>

</div>
</body>
</html>
