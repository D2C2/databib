<?PHP
require_once("./include/membersite_config.php");
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
<link href="/css/siteupdates.css" rel="stylesheet" type="text/css" />
<link href="http://www.lib.purdue.edu/resources/css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="http://www.lib.purdue.edu/resources/css/print.css" rel="stylesheet" type="text/css" media="handheld" />

<script type="text/javascript" src="/scripts/dropdown.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
 <?php 
	include_once('./include/database_connection.php');
	$startrow = mysql_real_escape_string(@$_REQUEST['startrow']);
	if (empty($startrow))
		$startrow=0;
	$startrow_cat = mysql_real_escape_string(@$_REQUEST['startrow_cat']);
	$startrow_cat_oldval = mysql_real_escape_string(@$_REQUEST['old_val']);
	if (empty($startrow_cat))
		$startrow_cat=0;
	if (empty($startrow_cat_oldval))
		$startrow_cat_oldval=0;
 ?>

<script type="text/javascript">

var srow = "<?= $startrow ?>";
var srow_cat = "<?= $startrow_cat ?>";
var srow_cat_oldval = "<?= $startrow_cat_oldval ?>";

function browseAlphabet(startrow) {
	var xmlhttp;
	if (window.XMLHttpRequest)
		xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    	document.getElementById("contentDiv").innerHTML = xmlhttp.responseText;
  	}
  	var filename = new String("./include/browsedb_byAlphabet.php?startrow=") + startrow;
  	xmlhttp.open("GET", filename ,true);
	xmlhttp.send();
}
function browseCategory($startrow_cat) {
	var xmlhttp;
	if (window.XMLHttpRequest)
		xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    	document.getElementById("contentDiv").innerHTML=xmlhttp.responseText;
			$("#contentDiv").html = document.getElementById("contentDiv").innerHTML;
  	}
	var filename = new String("./include/browsedb_byCategory.php?startrow_cat=") + $startrow_cat;
	xmlhttp.open("GET",filename,true);
	xmlhttp.send();
}

function whenReady(srow) {
	if(srow_cat == 0 && srow_cat_oldval == 0)
		$("#contentDiv").text(browseAlphabet(srow));
	else 
		$("#contentDiv").text(browseCategory(srow_cat));
}

$(document).ready(whenReady(srow));

</script>

<title>Databib</title>
</head>

<body >

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
		  <div id="ticker">

      	<?PHP
      	include_once("./include/getTop5Records.php");?>
      </div>
      <div id="body-content" style="border-left:1px solid gray; padding-left: 4px;" >
	    <br/><br/><br/><br/>
	    
	   
  <form name="search_bar" method="get" action="search_results.php">
   <div style="width:700px; cellpadding:15px;">
       <span style="font: 14px arial;">Search</span>&nbsp;
         <input type="text" name="query" style="width:300px; height:22px;" autofocus> 
         </input> 
         &nbsp;&nbsp;
         <input type="submit" name="Submit" style="width:45px; height:26px;" 
           value="Find">
         </input> &nbsp;&nbsp;&nbsp;&nbsp;
         <a href="advanced_search.php"> Advanced Search</a> 
   </div>
  </form>
   <br/><br/><br/>
   <font size="4" color="#A27B30">Browse</font>
	[ <a href="#"  style="text-decoration:none" onclick="browseAlphabet(<?php echo $startrow ?>)">  <font size="2" color="#C80000 ">Alphabetical</font></a> |
	<a href="#"  style="text-decoration:none" onclick="browseCategory(<?php echo $startrow_cat ?>)"> <font size="2" color="#C80000 ">Subjects</font></a> ]
	 <br/><br/><br/>
	<div id="contentDiv"></div>
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
