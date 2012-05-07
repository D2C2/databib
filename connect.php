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

<title>Databib</title>

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
<h2>Connect</h2>
<p>&nbsp;</p>

<p>The purpose of Databib is to maximize the connections that can be made between researchers and data repositories in a bibliographic context. Open data encourage sharing and making these kinds of connections. For this reason, all data and source code associated with Databib are made available to the public domain using the <a href="http://creativecommons.org/publicdomain/zero/1.0/">Creative Commons Zero protocol</a>. Our data are your data.</p>
<p>How can you connect to Databib now?</p>
<p>The primary interface is the Databib website itself. From the <a href="http://databib.lib.purdue.edu">homepage</a>, you can search for data repositories using a basic keyword search or an advanced Boolean search. Searchable metadata fields include the title of the repository, its URL, who maintains the repository, its access, use, and deposit policies, a 2-3 sentence abstract describing the repository, annotations from users, and Library of Congress Subject Headings. When viewing a record, you can click on its subjects to see other repositories that contain datasets in the same subject area.</p>
            <p>You can receive a dynamic feed of records from Databib by subscribing to its <a href="http://databib.lib.purdue.edu/display/RssFeeds.php">RSS feed</a>.</p>
            <p>You can also follow <a href="http://www.twitter.com/databib">@databib</a> on Twitter to receive tweets when new data repositories are described and added to Databib.</p>
            <p>If you'd like to recommend or share a particular repository with your favorite social network, over 300 are supported including Facebook, Twitter, Google+, and FriendFeed.</p>
            <p>Last but not least, we have begun to expose records from Databib using <a href="http://linkeddata.org">Linked Data</a>. Metadata are serialized with web pages for each repository using RDFa.</p>
            <p>We plan on providing a dump of Databib in MARC and RDF formats in the near future, as well as adding OpenSearch capability.</p>
            <p>Please keep in mind that Databib is currently being beta-tested, and it is still a work-in-progress. Its interfaces and metadata schema are likely to change as we make improvements.</p>
            <p>&nbsp;</p>
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
