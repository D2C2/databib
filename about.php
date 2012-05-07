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

<title>Databib: About</title>

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
<h2>About Databib</h2>
<p>&nbsp;</p>

<p>A partnership between Purdue and Penn State Universities proposes the creation of a new resource called Databib that will provide a “spark” to help engage librarians in data services by providing them with an online, community-driven, annotated bibliography and registry of research data repositories. In addition to being an important reference resource to librarians, data users, data producers, publishers, and research funding agencies, the Databib platform will challenge the concept of the traditional bibliography by serving and integrating bibliographic content in Web 1.0, Web 2.0, and Web 3.0 environments in order to help overcome some shortcomings or perceptions of traditional bibliographies. One technology in particular, Linked Data, shows a great deal of promise for delivering a “web of data” (i.e., the Semantic Web) and giving librarians a new toolkit for describing and classifying data in a relational manner.</p>

<p>An expanded role for research libraries in digital data stewardship was forecasted by an Association of Research Libraries (ARL) workshop report to the NSF in 2006 [<a href="http://www.arl.org/bm~doc/digdatarpt.pdf">1</a>]. This forecast was substantiated in August 2010 by a survey of 57 ARL libraries, of which 21 libraries reported that they currently provide infrastructure or support services for e-Science, and an additional 23 libraries are in planning stages [<a href="http://www.arl.org/bm~doc/escience_report2010.pdf">2</a>]. A number of academic and research libraries are beginning to take a more active role in data management on their campuses, applying library science principles to help address the data deluge. This includes a wide range of activities such as helping researchers formulate funder-required data plans, adapting library practice to help organize and describe research datasets, developing data collections and data repositories, digital preservation, and data literacy.</p>

<p>Librarians are in a good position to provide these services; unfortunately, there is currently no framework in place to support the organization and discovery of data repositories. Many funding agencies are requiring their sponsored researchers to submit their data to repositories without giving further instructions to them. What repositories are appropriate for a researcher to submit his or her data to? How do potential users find appropriate data repositories and discover datasets that meet their needs? How can librarians help patrons who are looking for data find and integrate it into the patrons’ research, learning, or teaching? Databib will begin to address these needs for librarians, data users, data producers, publishers, and funding agencies.</p>

<p>The deliverables of this nine-month project will be 1) a functional and useful Databib platform as described in the project design; 2) the original description and annotation of primary repositories of research data represented by records in Databib; 3) a rubric for evaluating new repositories for inclusion in Databib; 4) documentation and supporting activities to catalyze a community of bibliographers; and 5) a white paper written for IMLS that describes the project design and provides an analysis of the project's results in terms of meeting these outcomes. A small panel of advisers will provide guidance throughout the project as well as to periodically review progress and give input to maximize the effectiveness of the project. The project’s design and evaluation plan establish measurable goals and outcomes for software development, the creation of new Databib records by both project personnel and community bibliographers, the number of integrations accomplished, usage statistics, and user feedback. All source code, content, and data will be sharing and dedicated to the public domain using <a href="http://creativecommons.org/publicdomain/zero/1.0/">Creative Commons Zero 1.0</a>.</p>
<p><em>Adapted from proposal narrative, November 2010</em></p>

<p>&nbsp;</p>

<p>Databib is supported in part by a Sparks! Ignition National Leadership Grant (LG-46-11-0091-11) from the Institute of Museum and Library Services.</p>
<p align="right"><a href="http://imls.gov"><img src="/images/IMLS.jpg" alt="IMLS" width="250" height="114" /></a></p>
 
<h2>Personnel</h2>
 
<div id="stuff" style="float: left;width: 944px;background-color: #fff;padding-left:10px; padding-right:10px;">
 
<p><ul>
<li style="list-style-image:url(/images/bullet.gif);"><p><a href="http://www.lib.purdue.edu/research/witt">Michael Witt</a>, Project Director (PI)<br />
Assistant Professor of Library Science<br />
<a href="http://www.lib.purdue.edu">Purdue University Libraries</a></p></li>

<li style="list-style-image:url(/images/bullet.gif);"><p><a href="http://lackoftalent.org/michael/">Michael Giarlo</a>, Technical Architect (co-PI)<br />
Digital Library Architect<br />
<a href="http://www.psu.edu">Penn State University</a></p></li>

<li style="list-style-image:url(/images/bullet.gif);"><p>Gretchen Stephens, Community Bibliographer<br />
Associate Professor of Library Science<br />
<a href="http://www.lib.purdue.edu">Purdue University Libraries</a></p></li>

<li style="list-style-image:url(/images/bullet.gif);">
  <p>Rachel Newbury &amp; Marcy Wilhelm-South, Interns<br />
<a href="http://www.slis.iupui.edu/">School of Library and Information Science</a><br />
Indiana University-Indianapolis</p></li>

</ul>
</div>

<p>&nbsp;</p>
<h2>Project Advisors</h2>

<div id="stuff" style="float: left;width: 944px;background-color: #fff;padding-left:10px; padding-right:10px;">

<ul>
<p><li style="list-style-image:url(/images/bullet.gif);"><a href="http://www.lib.unc.edu/users/jlriley/">Jenn Riley</a></li>
<li style="list-style-image:url(/images/bullet.gif);"><a href="http://vivo.cornell.edu/display/individual7769">Gail Steinhart</a></li>
<li style="list-style-image:url(/images/bullet.gif);"><a href="http://inkdroid.org/journal/about/">Ed Summers</a></li>
<li style="list-style-image:url(/images/bullet.gif);"><a href="http://www.icpsr.umich.edu/icpsrweb/content/shared/ICPSR/staff/vardigan.html">Mary Vardigan</a></li>
<li style="list-style-image:url(/images/bullet.gif);"><a href="http://www.nescent.org/dir/leaders.php">Todd Vision</a></li></p></ul>

</div>


<p>&nbsp;</p>
<hr />
<p>&nbsp;</p>
<p>1. Association of Research Libraries, <a href="http://www.arl.org/bm~doc/digdatarpt.pdf">To Stand the Test of Time: Long-term Stewardship of Digital Data Sets in Science and Engineering: ARL Workshop on New Collaborative Relationships: The Role of Academic Libraries in the Digital Data Universe</a>. 2006.</p>
<p>2. C. Soehner, C. Steeves, and J. Ward, <a href="http://www.arl.org/bm~doc/escience_report2010.pdf">E-Science and Data Support Services: A Study of ARL Member Institutions</a>. Association of Research Libraries, 2010.</p>

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
