<?PHP
require_once("./include/membersite_config.php");
$fgmembersite->CheckLogin();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:foaf="http://xmlns.com/foaf/0.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:ore="http://openarchives.org/ore/terms/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"  xmlns:databib="http://databib.org/ns#" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css"/>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="Author" content="Siddharth Singh" />
<meta name="Keywords" content="Databib data curation bibliography bibliographies Michael Witt Mike Giarlo Purdue Penn State University library science libraries repositories" />
<meta name="Description" content="Databib is a collaborative, annotated bibliography of primary research data repositories developed with support from the Institute of Museum and Library Services." />
<meta name="Robots" content="all" />

<link href="http://www.lib.purdue.edu/resources/css/site.css" rel="stylesheet" type="text/css" />
<link href="css/siteupdates.css" rel="stylesheet" type="text/css" />
<link href="http://www.lib.purdue.edu/resources/css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="http://www.lib.purdue.edu/resources/css/print.css" rel="stylesheet" type="text/css" media="handheld" />

<script src="/scripts/dropdown.js" type="text/javascript"></script>
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="/scripts/comments.js" type="text/javascript"></script>


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
        <div id='fg_membersite_content'>
		 <?php
		  include("./include/getapprovedbyrecordid.php");
		 ?>
		<br></br><br></br><br></br>
		</div>

		
		<!-- AddThis Button BEGIN -->
		<div class="addthis_toolbox addthis_default_style ">
		<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
		<a class="addthis_button_tweet"></a>
		<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
		<a class="addthis_counter addthis_pill_style"></a>		
		</div>
		<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f45243a60145ecf"></script>
		<!-- AddThis Button END -->

		
		<p>&nbsp;</p>
		<h1>Annotations</h1>
		<?php
		  include("./include/getcommentsbyrecordid.php");
		 ?>
		   
	   <br></br>
	   <h1>Add an annotation:</h1>
	   <form method="post" action="" name="commentsform" id="commentsform">
		<div>         	
		<input type="hidden" name="recordid" id="recordid" value="<?php echo $record_id ?>" />
        	 <input type="hidden" name="author" id="author" value="<?php echo $fgmembersite->UserName() ?>" />
		</div>		 
		<table>
		   <tr>
		    <td>
	    	      <textarea cols="56" rows="2" name="commenttext" id="commenttext" style="margin-bottom:12px;
	    	        margin-top:12px;">
	     	      </textarea> 
	     	    </td>  
		    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    <input type="submit" id="post" value="post"/> &nbsp;
		    </td>
		  </tr>
		 </table>
       </form><br></br>
      </div>    
    </div>
  </div>
 
<div style="clear:both;width: 974px; margin: 0; margin-right: auto;margin-left: auto;background:#000000;no-repeat;display: block;height: 60px; padding-right:0px;">
<img src="http://www.lib.purdue.edu/resources/images/backgrounds/tagline.jpg" />
     <div id="footer-copyright">
	 <p xmlns:dct="http://purl.org/dc/terms/" xmlns:vcard="http://www.w3.org/2001/vcard-rdf/3.0#">
		<a href="./include/serializeRDFXML.php"><img src="http://www.w3.org/RDF/icons/rdf_metadata_button.32" width="55" height="21" border="0" alt="RDF Resource Description Framework Metadata Icon"/></a>
     <a rel="license"
     href="http://creativecommons.org/publicdomain/zero/1.0/">
    <img src="http://i.creativecommons.org/p/zero/1.0/88x31.png" style="border-style: none;" alt="The content, data, and source code of Databib are dedicated to the Public Domain using the CC0 protocol." />

  </a></div>
</div>

</div>
</body>
</html>
