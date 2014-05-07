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
include "./include/database_connection.php";
header('content-type:text/html;charset=utf-8');

?>

	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="Author" content="Databib" />
<meta name="keywords" content="Databib, research, data, repository, repositories, registry, directory, research repositories, data repositories" />
<meta name="Description" content="Databib is a collaborative, annotated bibliography of primary research data repositories developed with support from the Institute of Museum and Library Services." />
<meta name="robots" content="All" />
<meta name="revisit-after" content="7 Days" />

<link href="css/site.css" rel="stylesheet" type="text/css" />
<link href="./css/siteupdates.css" rel="stylesheet" type="text/css" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="handheld" />
<link rel="stylesheet" href="./css/jquery.ui.all.css" />
<link rel="shortcut icon" href="/images/bullet.ico" type="image/x-icon" />

<!--script src="./scripts/dropdown.js"></script-->
<script src="http://code.jquery.com/jquery-latest.js"></script>

<script src="scripts/jquery.ui.core.js"></script>
<script src="scripts/jquery.ui.widget.js"></script>
<script src="scripts/jquery.ui.position.js"></script>
<script src="scripts/jquery.ui.autocomplete.js"></script>


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

// Checks for the fields when clicking the submit button
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

		if($("#rep_startdate").val().length > 0 &&
				($("#rep_startdate").val().length != 4 || isNaN(Number($("#rep_startdate").val())))) {
			alert('Start date should be a 4-digit year.');	
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

// Handle autocomplete for subjects
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
                }, function(data) {
						response($.each(data, function(key, value) {
							value.label = utf8_decode(value.label);
							return {
								key: key,
								value: value
							}
						}));
					} );
            },
            change: function(event, ui) { if(!ui.item){ alert("No subjects selected: You can only use subjects from the predefined list of subjects (Wait till it autocompletes)");} },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
        		 $("#selectedSubjects").append("<div class = 'selectedsubject'>" + (ui.item.label)+"<img id='killSubject' style='position:relative; left:10px' src='images/close_icon.gif'/><div id='hiddenId' style='display:none'>"+ui.item.value+"</div></div>");                
        		 $(this).val("");
        		 return false;
            }
        });
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
	
	var options, a;
	jQuery(function(){
		
		options = 
		{
			source: function(request, response)
				{
					$.ajax({url: './include/getcountries.php', dataType: "json", data: { 'search_term': request.term },
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
			
	function match_url() {
		
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.open("GET","include/match_url.php?url="+document.getElementById("rep_url").value,false);
		xmlhttp.send();
		document.getElementById("url_matches").innerHTML = xmlhttp.responseText;
	}
	
	function toggleField(field1, field2) {
		var field1_elem = document.getElementById(field1);
		var field2_elem = document.getElementById(field2);
		if(field1_elem.style.display == 'none'){
		   field1_elem.style.display = 'inline';
		   field2_elem.style.display = 'inline';
		} else {
		   field1_elem.style.display = 'none';
		   field2_elem.style.display = 'none';
		   field1_elem.value = '';
		}
	}
</script>

<title>Submit Repositories to Databib</title>
<style type="text/css">
<!--
.style2 {color: #993300}
-->
textarea {
    resize: none;
}

#url_matches{
    word-wrap: break-word;
	word-break: break-all;
	width: 250px;
}
</style>
</head>

<body>

<div id="page-content">
<?php include "include/header.php"; ?>

  <div id="wrapper2">
    <div id="wrapper">
      <div id="main">
		<h1>Submit Repositories to Databib</h1>
	    <p>Are you familiar with a data repository that isn't included in Databib? Please consider submitting a new record. You can suggest a repository for us to catalog by simply entering its title, URL, authority, and a subject for it... and we'll do the rest!  </p>
	    <p>If you're not sure what to information to enter, please consult our <a href="Databib_Rubric_Draft.pdf" title="Guidelines for Bibliographers">Guidelines for Bibliographers</a>. Submissions are reviewed and approved before appearing in Databib.</p>
		 <script type="text/javascript">
			var RecaptchaOptions = {
				theme : 'white'
			};
		</script>
		
	    <form name="submit_confirm" method="post" action="submit-confirmation.php" onSubmit="return checkAgree(this);"> 
  	 <table border="0" width="90%" style="table-layout: fixed;">
      <tr>
    	<td width=280><label for="rep_title" >Title of repository<span class="style2">*</span>: </label></td>
    	<td width=340><input type="text" id="title" name="rep_title" style="width:310px; height:20px; margin-bottom:8px;"/> <img width="16" src="images/Button-info-icon.png" title="Name of the repository, e.g., &quot;Australian Repositories for Diffraction ImageS, The (TARDIS)&quot;" alt="Name of the repository, e.g., &quot;Australian Repositories for Diffraction ImageS, The (TARDIS)&quot;"/></td>
		<td rowspan=12 align="left" valign="top" style="width:300px;"><label id="url_matches" > </label></td>
      </tr>
      
      <tr>
    	<td><label for="rep_url"  >URL to repository main page<span class="style2">*</span>: </label></td>
    	<td><input type="text" id="rep_url" name="rep_url" style="width:310px; height:20px; margin-bottom:8px;" onkeyup="match_url()"/> <img width="16" src="images/Button-info-icon.png" title="Link to the repository, e.g., &quot;http://tardis.edu.au&quot;" alt="Link to the repository, e.g., &quot;http://tardis.edu.au&quot;"/></td>
      </tr>
      
      <tr>
      	<td><label for="rep_authority"  >Authority (who maintains repository)<span class="style2">*</span>: </label></td>
      	<td><input type="text" id="authority" name="rep_authority" style="width:310px; height:20px; margin-bottom:8px;"/> <img width="16" src="images/Button-info-icon.png" title="The organization(s) that maintain the repository, e.g., &quot;Monash University&quot;" alt="The organization(s) that maintain the repository, e.g., &quot;Monash University&quot;"/></td>
      </tr>
      
	  <tr>
		<td>Authorities Selected: </td>
        <td><div id="selectedAuthorities" style="margin-bottom:20px;"></div><br/></td>
      </tr>
	  
      <?php if ($_SESSION['user_role'] == 'editor' || $_SESSION['user_role'] == 'admin') { ?>
       <tr>
      	<td><label for="rep_email"  >Authority Email: </label></td>
      	<td><input type="text" id="rep_email" name="rep_email" style="width:310px; height:20px; margin-bottom:8px;"/><br/></td>
      </tr>
      <?php } ?>
      
      <tr>
      	<td><label for="rep_subjects">Subjects (e.g., FAST) covered<span class="style2">*</span>: </label></td>
      	<td><input type="text" name="rep_subjects" id ="tags" style="width:310px; height:20px; margin-bottom:8px;"/> <img width="16" src="images/Button-info-icon.png" title="Library of Congress Subject Headings that describe data collections, e.g., &quot;Crystallography&quot;" alt="Library of Congress Subject Headings that describe data collections, e.g., &quot;Crystallography&quot;"/></td>
      </tr>
       
      <tr>
      	<td>Subjects Selected: </td>
        <td><div id="selectedSubjects" style="margin-bottom:20px;"></div><br/></td>
      </tr>
      
      <tr>
      	<td><label for="rep_description">Description: </label></td>
      	<td><textarea cols="36" rows="8" name="rep_description" style="width:310px; margin-bottom:8px;"></textarea> <img width="16" style="vertical-align:top" src="images/Button-info-icon.png" title="A brief, narrative abstract that summarizes the purpose, collections, and audiences of the repository" alt="A brief, narrative abstract that summarizes the purpose, collections, and audiences of the repository"/></td>
      </tr>
      
      <tr>
      	<td> <label for="rep_status">Access: </label>
      	</td>
      	<td><input type="text" name="rep_status" style="width:310px; height:20px; margin-bottom:8px;"/> <img width="16" src="images/Button-info-icon.png" title="Who can access the repository? E.g., &quot;Open&quot;" alt="Who can access the repository? E.g., &quot;Open&quot;"/></td>
      </tr>
      
      <tr>
      	<td><label for="rep_startdate">Start date (year): </label> </td>
      	<td><input type="text" id="rep_startdate" name="rep_startdate" style="width:310px; height:20px; margin-bottom:8px;"/> <img width="16" src="images/Button-info-icon.png" title="The year the repository began operating, e.g., &quot;2010&quot;" alt="The year the repository began operating, e.g., &quot;2010&quot;"/></td>
      </tr>
      
      <tr>
      	<td><label for="country_name">Country: </label></td>
      	<td><input type="text" name="country_name" id="location" style="width:310px; height:20px; margin-bottom:8px;"/> <img width="16" src="images/Button-info-icon.png" title="The primary country where the repository authority resides" alt="The primary country where the repository authority resides"/></td>
      </tr>
      <tr>
      	<td> <label for="rep_access">Reuse: </label></td>
      	<td>  <input type="text" name="rep_access" style="width:310px; height:20px; margin-bottom:8px;"/> <img width="16" src="images/Button-info-icon.png" title="What can users do with data they&#39;ve downloaded from the repository? E.g., &quot;Open; Creative Commons suite of licenses; default is CC0.&quot;" alt="What can users do with data they&#39;ve downloaded from the repository? E.g., &quot;Open; Creative Commons suite of licenses; default is CC0.&quot;"/></td>
      </tr>
      
      <tr>
      	<td>  <label for="rep_deposit">Deposit: </label>
      	  </td>
      	<td><input type="text" name="rep_deposit" style="width:310px; height:20px; margin-bottom:8px;"/> <img width="16" src="images/Button-info-icon.png" title="Who can deposit data? E.g., &quot;Purdue faculty, staff, graduate students and their collaborators&quot;" alt="Who can deposit data? E.g., &quot;Purdue faculty, staff, graduate students and their collaborators&quot;"/></td>
      </tr>
      
      <tr>
      	<td><label for="rep_type">Type: </label></td>
      	<td> <input type="text" name="rep_type" style="width:310px; height:20px; margin-bottom:8px;"/> <img width="16" src="images/Button-info-icon.png" title="Generally, what kind of repository is it? E.g, &quot;Institutional&quot;" alt="Generally, what kind of repository is it? E.g, &quot;Institutional&quot;"/></td>
      </tr>
	  <tr>
		<td><label for="rep_certification">Is it certified? </label></td>
		<td><input type="checkbox" onclick="toggleField('rep_certification', 'rep_certification_info');" style="margin-bottom:8px;"/></td>
	  </tr>
	  <tr>
		<td><!--label id="cert_examples" style="font-size: 10px; color: gray; display:none;">Ex: TRAC, Data Seal of Approval,...</label--></td>
		<td><input name="rep_certification" id="rep_certification" type="text" style="width:310px; height:20px; margin-bottom:8px;display:none;" /> <img id="rep_certification_info" name="rep_certification_info" width="16" style="display:none;" src="images/Button-info-icon.png" title="Certification of repository, e.g., &quot;Data Seal of Approval&quot;" alt="Certification of repository, e.g., &quot;Data Seal of Approval&quot;"/></td>
	  </tr>
		<?php
			if(!$fgmembersite->CheckLogin()) {	
						echo "<tr><td/><td><br/><br/>";
						require_once('include/recaptchalib.php');
						$publickey = "6Ld5e9gSAAAAAPBl5p4apr3f-BvuHJmWfjxXCqbL"; // you got this from the signup page
						echo recaptcha_get_html($publickey);
						echo "</td></tr>";
			}
       ?>
       <tr><td/>
      	<td>
			<input type="hidden" id="hiddenIDbox" name="hiddenBox" style="width:310px; height:20px; margin-bottom:8px;"/><br/>
			<input type="hidden" id="hiddenCountryIDbox" name="hiddenCountryBox" style="width:310px; height:20px; margin-bottom:8px;"/><br/>
			<input type="hidden" id="hiddenAuthBox" name="hiddenAuthBox" style="width:310px; height:20px; margin-bottom:8px;"/><br/>
		</td>
       </tr>
      
    </table> <br/>
    <input type ="checkbox" name="agreebox"> &nbsp;I agree that any content that I contribute to Databib will be placed in the public domain via the <a href="http://creativecommons.org/publicdomain/zero/1.0/">CC0</a> protocol. <br>
    <br> </input>

    <input type="submit" value="Submit" class="button"/> &nbsp;
  </form>
  
<br/><br/>
        
      </div>    
    </div>
  </div>

<?php include "include/footer.php"; ?>

</div>
</body>
</html>
