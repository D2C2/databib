<?php
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

<script src="/scripts/dropdown.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">

function advanceSearch() {
	var xmlhttp;
	if (window.XMLHttpRequest)
		xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    	document.getElementById("contentDiv").innerHTML=xmlhttp.responseText;
  	}
	xmlhttp.open("GET","./include/advancestyle=\"padding-left:8px;\"dsearchdb.php",true);
	xmlhttp.send();
}

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

<form name="advanced_search_bar" method="get" action="advanced_search_results.php">
   <div style="width:700px; cellpadding:0px;">
       <span style="font:14px arial;">Search for</span>&nbsp;
         <input type="text" name="query1" style="width:300px; height:22px;" autofocus> 
         </input>&nbsp;in&nbsp;
         <select name="search_cat1" size="1">
         	<option value="-1">All Categories </option>
         	<option value="-2">-------------- </option>
         	<option value="1">Title</option>
         	<option value="2">Description </option>
         	<option value="3">Authority </option>
         	<option value="4">Subject </option>
         	<option value="5">Access</option>
      	 </select> &nbsp; &nbsp;&nbsp;
      	 <select name="boolean_cat1" size="0">
         	<option value="-1">Boolean</option>
         	<option value="-2">-------------- </option>
         	<option value="1">AND</option>
         	<option value="2">OR </option>
         	<option value="3">NOT </option>
      	 </select> &nbsp;&nbsp; <br/><br/>
      	 <input type="text" name="query2" style="width:300px; height:22px; margin-left:75px" > 
         </input>&nbsp;in&nbsp;&nbsp;
         <select name="search_cat2" size="1">
         	<option value="-1">All Categories </option>
         	<option value="-2">-------------- </option>
         	<option value="1">Title</option>
         	<option value="2">Description </option>
         	<option value="3">Authority </option>
         	<option value="4">Subject </option>
         	<option value="5">Access</option>
      	 </select> &nbsp; &nbsp;
      	 <select name="boolean_cat2" size="0">
         	<option value="-1">Boolean</option>
         	<option value="-2">-------------- </option>
         	<option value="1">AND</option>
         	<option value="2">OR </option>
         	<option value="3">NOT </option>
      	 </select> &nbsp;&nbsp; <br /><br />
      	 <input type="text" name="query3" style="width:300px; height:22px; margin-left:75px" > 
         </input>&nbsp;in&nbsp;
         <select name="search_cat3" size="1">
         	<option value="-1">All Categories </option>
         	<option value="-2">-------------- </option>
         	<option value="1">Title</option>
         	<option value="2">Description </option>
         	<option value="3">Authority </option>
         	<option value="4">Subject </option>
         	<option value="5">Access</option>
      	 </select> &nbsp;&nbsp;&nbsp;&nbsp;
      	 <br/>  <br/>
      	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      	  &nbsp;&nbsp;
         <input type="submit" name="Submit" style="width:45px; height:26px;" 
           value="Find">
         </input>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <a href="alpha.php"> Go back to Basic Search</a> 
   </div>
  </form> 
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
