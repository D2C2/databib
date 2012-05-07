<?PHP
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once("membersite_config.php");
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
	include_once('database_connection.php');
 ?>

<script type="text/javascript">


</script>

<title>Databib</title>
</head>

<body >

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
	<li><a href="../index.php">About</a>
	</li>
	<li><a href="../search.php">Search</a>
	</li>
	<li><a href="../submit.php">Submit</a>
	</li>
	<li><a href="../connect.php" onmouseover="mopen('m5')" onmouseout="mclosetime()">Connect</a>
		<div id="m5" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
		<a href="connect.php">RSS</a>
		<a href="connect.php">Linked Data</a>
		</div>
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
      <div id="body-content">
	    <br/><br/><br/><br/>
	    
	   
  <form name="search_bar" method="get" action="/search_results.php">
   <div style="width:700px; cellpadding:15px;">
       <span style="font: 14px arial;">Search</span>&nbsp;
         <input type="text" name="query" style="width:300px; height:22px;" autofocus> 
         </input> 
         &nbsp;&nbsp;
         <input type="submit" name="Submit" style="width:45px; height:26px;" 
           value="Find">
         </input> &nbsp;&nbsp;&nbsp;&nbsp;
<!--         <a href="advanced_search.php"> Advanced Search</a> -->
   </div>
  </form>
   <br/><br/><br/>
   <font size="4" color="#A27B30">Browse</font>
	[ <a href="#"  style="text-decoration:none" onclick="browseAlphabet(<?php echo $startrow ?>)">  <font size="2" color="#C80000 ">Alphabetical</font></a> |
	<a href="#"  style="text-decoration:none" onclick="browseCategory(<?php echo $startrow_cat ?>)"> <font size="2" color="#C80000 ">Category</font></a> ]
	 <br/><br/><br/>
	<div id="contentDiv">
	<?php 

		$subject_id = mysql_real_escape_string(@$_REQUEST['subjectid']);

		$query = "select * from subject_record_assoc_approved where id_subject = ". $subject_id;
		$numresults = mysql_query ($query) or die(mysql_error()) ;

		while( $row = mysql_fetch_array($numresults) and $row['id_subject']!='')
		{
			$query2 = "select * from approved where id_rep = ". $row['id_record'];
			$recordresults = mysql_query ($query2) or die(mysql_error()) ;
			$rowrecord = mysql_fetch_array($recordresults);


			echo '<a href="../viewapprovedbyrecordid.php?record='.$rowrecord['id_rep']. '"style="color:#993300; font-size:14px">';
			echo $rowrecord['rep_title'];
			echo  '</a>';			
			echo "<br>";

		}
	?>
	</div>
  <br/><br/><br/>
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
        </a>  
      </div> 	  
    </div>
  </div>

</div>
</body>
</html>
