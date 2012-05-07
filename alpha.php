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
<link href="css/siteupdates.css" rel="stylesheet" type="text/css" />
<link href="http://www.lib.purdue.edu/resources/css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="http://www.lib.purdue.edu/resources/css/print.css" rel="stylesheet" type="text/css" media="handheld" />

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="/scripts/dropdown.js"></script>

<title>Databib</title>
</head>

<body>

<div id="page-content">
  <div id="header">
    <div id="new-header-content">
	  <div style="position: absolute; z-index:100">
	    <img style="float:left; margin:0px; padding:0px;" id="imagebanner" alt="Header" src="/images/header.jpg"/>
	  </div> 
    </div> 
  </div>
   
  <div id="navigation">
   <div id="new-navigation-content" style="background-color:#504A4B">
    <ul>
	<li><a href="index.php">Home</a>
	</li>
	<li><a href="participate.php">Participate</a>
	</li>
	<li><a href="connect.php" onmouseover="mopen('m5')" onmouseout="mclosetime()">Connect</a>
		<div id="m5" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
		<a href="connect.php">RSS</a>
		<a href="connect.php">Linked Data</a>
		</div>
	</li>
	<li><a href="about.php">About</a>
	</li>
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
      <div id="body-content"  style="border-left:1px solid gray;">
	    <br/><br/><br/>

        <span style="font:20px arial,sans-serif;  margin-left: 42px;">A collaborative, annotated bibliography of primary research data repositories</span>
 	    <br/><br/><br/>
	    <div style="background-color: #FFFFFF; margin-left: 205px; float: left; display:inline">
	      <div style="background-color: #41627E" id="dwrap"><br/><br/> 
	        <a href="search.php"> <span class="tile"> Browse </span> </a>
	      </div>
	     
	      <div style="background-color: #617C58" id="dwrap"> <br/><br/> 
	        <a href="search.php"> <span class="tile"> Search </span> </a>
	      </div>
	     
	      <br/><br/><br/><br/><br/><br/>
	      <div style="background-color: #7F462C" id="dwrap"> <br/><br/> 
	        <a href="submit.php"> <span class="tile"> Submit </span> </a>
	      </div>
	     
	      <div style="background-color: #827B60" id="dwrap"> <br/><br/> 
	        <a href="connect.php"> <span class="tile"> Connect </span> </a>
	      </div>
	    </div>

	    <div id="content-2col" style="float: left; padding: 10px 10px 20px 5px; width:744px; display:inline">
	    <br/>
          <p>Databib is a collaboration between the Purdue University Libraries and Penn State University to create a 
          community-driven, annotated bibliography of research data repositories. It will also serve as a testbed for linking, 
          integrating, and presenting information about research data providers in Web 1.0, 2.0, and 3.0 contexts. This work 
          is supported in part by a Sparks! Innovation National Leadership Grant from the Institute of Museum and Library Services. 
          Databib is a nine-month project that will conclude development in May 2012.</p>
        </div>
      </div>    
    </div>
  </div>

  <div id="new-footer">
    <div id="new-footer-content">
      <div id="new-footer-copyright">
	    Databib is being developed with support from the <a href="http://www.lib.purdue.edu/">Purdue University Libraries</a>
	    and the <a href="http://www.imls.gov/"> IMLS  &nbsp;&nbsp; </a>
	    <a rel="license"
          href="http://creativecommons.org/publicdomain/zero/1.0/">
          <img src="http://i.creativecommons.org/p/zero/1.0/88x31.png" width="55" height= "20" style="border-style: none;" alt="The content, data, and source code of Databib are dedicated to the Public Domain using the CC0 protocol." />
      </div> 	  
    </div>
  </div>

</div>
</body>
</html>
