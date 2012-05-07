<?PHP
require_once("./include/membersite_config.php");
$fgmembersite->CheckLogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css"/>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="Keywords" content="Databib data curation bibliography bibliographies Michael Witt Mike Giarlo Purdue Penn State University library science libraries repositories" />
<meta name="Description" content="Databib is a collaborative, annotated bibliography of primary research data repositories developed with support from the Institute of Museum and Library Services." />
<meta name="Robots" content="all" />

<link href="http://www.lib.purdue.edu/resources/css/site.css" rel="stylesheet" type="text/css" />
<link href="/css/siteupdates.css" rel="stylesheet" type="text/css" />
<link href="http://www.lib.purdue.edu/resources/css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="http://www.lib.purdue.edu/resources/css/print.css" rel="stylesheet" type="text/css" media="handheld" />

<script src="/scripts/dropdown.js"></script>

<title>Databib: Participate</title>

 <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>An Access Controlled Page</title>
      <link rel="stylesheet" type="text/css" href="css/fg_membersite.css"/>
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


<div style="float: left;width: 954px;background-color: #fff;padding-left:10px; padding-right:10px;">

<p>&nbsp;</p>
<h2>Participate</h2>
<p>&nbsp;</p>

<p>Databib is currently being developed and improved. Your input and participation are welcomed! Please <a href="http://databib.lib.purdue.edu/register.php">create an account</a> and begin using the site.</p>

<p>Are you familiar with a data repository that isn't on Databib yet? <a href="mailto:databib@gmail.com">Email us</a> its URL for us to add a record for it, or better yet, <a href="http://databib.lib.purdue.edu/submit.php">submit a record</a> yourself. A rubric with guidelines for identifying and describing data repositories for Databib is in draft form <a href="http://databib.lib.purdue.edu/Databib_Rubric_Draft.pdf">here</a>.</p>
<p>Can you enhance or correct existing Databib records? Click the &quot;Edit&quot; link underneath each record to suggest changes.</p>
<p>You can also add an annotation to append information or comments that are not acommodated within the metadata of the record.</p>
<p>All submitted records, edits, and annotations will be queued for review by an editor and become available after they have been approved.</p>
<p>If you are interested in serving in the future as an editor for Databib, please contact <a href="mailto:mwitt@purdue.edu">Michael Witt</a>, Project Director.</p>
<p><strong>What do you think?</strong></p>
<p>Are there other features you'd like to see with Databib? Are there other useful connections that we could be making through controlled vocabularies or new collaborations? Is this tool useful to you?</p>

<p>We would appreciate your suggestions and feedback! Please e-mail us at <a href="mailto:databib@gmail.com">databib@gmail.com</a>.</p>
<p>&nbsp;</p>

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
