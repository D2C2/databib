<?PHP
require_once("./include/membersite_config.php");
$fgmembersite->CheckLogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="Author" content="Michael Witt" />
<meta name="keywords" content="Databib, research, data, repository, repositories, registry, directory, research repositories, data repositories, data management plan" />
<meta name="Description" content="Databib is a directory, registry, catalog, and bibliography of primary research data repositories." />
<meta name="robots" content="All" />
<meta name="revisit-after" content="7 Days" />

<link rel="alternate" type="application/atom+xml" title="RSS" href="http://databib.org/displayRssFeeds.php">
<link href="css/site.css" rel="stylesheet" type="text/css" />
<link href="/css/siteupdates.css" rel="stylesheet" type="text/css" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="handheld" />
<link rel="shortcut icon" href="/images/bullet.ico" type="image/x-icon" />

<script src="/scripts/dropdown.js"></script>

<title>Connect to Databib</title>

 <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>An Access Controlled Page</title>
      <link rel="stylesheet" type="text/css" href="css/fg_membersite.css"/>
</head>

<body>

<div id="page-content">
 <?php include "include/header.php"; ?>
              
<div id="main">
<h1>Connect to Databib</h1>
<p>The purpose of Databib is to maximize the connections that can be made between researchers and data repositories in a bibliographic context. It is our goal to make it easy for you to use and integrate Databib in as many ways as possible. Here are the interfaces we currently provide beyond the Databib website:</p>


<div class="db-social db-social-top">
	<a href="http://twitter.com/databib" title="Twitter"><img src="images/db-twit.png" alt="Twitter" /></a>
    <p>Follow <a href="http://twitter.com/databib" title="@databib">@databib</a> on Twitter. When new repositories are added to Databib, they are automatically tweeted. Stay informed about new repositories as they are identified and cataloged. It is also easy to integrate Twitter streams into your website or, for example, an online library resource guide.</p>
    <div class="clear"></div>
</div>
<div class="db-social">
	<a href="http://databib.org/displayRssFeeds.php" title="RSS"><img src="images/db-rss.png" alt="RSS" /></a>
    <p>You can also subscribe to an <a href="http://databib.org/displayRssFeeds.php" title="RSS feed">RSS feed</a> (Really Simple Syndication) from Databib that publishes the addition of new data repositories. RSS feeds can be easily aggregated with other feeds and displayed in your reader, as well as integrated to provide dynamic content for your website or libguide.</p>
    <div class="clear"></div>
</div>
<div class="db-social">
	<a href="http://databib.org/include/serializeRDFXMLAll.php" title="RDFXML"><img src="images/db-rdfxml.png" alt="RDFXML" /></a>
    <p>You can <a href="http://databib.org/include/serializeRDFXMLAll.php" title="download all of the bibliographic records">download all of the bibliographic records</a> in Databib in <a href="http://www.w3.org/TR/REC-rdf-syntax" title="RDF/XML">RDF/XML</a> format. This dump of records is generated dynamically, so it will include the entire, current content of Databib.  You can also click the RDF icon at the bottom of each page to download a record for an individual repository. We fully endorse the <a href="http://openbiblio.net/principles/" title="Principles of Open Bibliographic Data">Principles of Open Bibliographic Data</a>.</p>
    <div class="clear"></div>
</div>
<div class="db-social">
	<a href="http://databib.org/opensearch.xml" title="OpenSearch"><img src="images/db-open.png" alt="OpenSearch" /></a>
    <p>Databib supports <a href="http://www.opensearch.org/Specifications/OpenSearch/1.1#OpenSearch_description_document" title="OpenSearch">OpenSearch</a>, which exposes information about our search interface and how it can be queried. Web browsers can auto-discover Databib as an OpenSearch target, enabling you to search Databib directly from your browser without having  to return to the website. It also enables you to subscribe to our RSS  feed and filter it by search terms to create a &quot;saved search&quot; that is dynamically updated.</p>
    <div class="clear"></div>
</div>
<div class="db-social">
	<img src="images/db-rdfa.png" alt="RDFa" />
    <p>Each record in Databib  exposes <a href="http://linkeddata.org" title="Linked Data">Linked Data</a> in the form of <a href="http://www.w3.org/TR/xhtml-rdfa-primer/" title="RDFa">RDFa</a> that is embedded within the web page that represents each repository. The entire bibliographic metadata record is expressed using the <a href="http://purl.org/dc/terms/" title="Dublin Core">Dublin Core</a>, <a href="http://xmlns.com/foaf/0.1/" title="FOAF">FOAF</a>, <a href="http://creativecommons.org/ns#" title="Creative Commons">Creative Commons</a>, and<a href="http://databib.org/ns#" title="Databib Terms"> Databib Terms</a> vocabularies.</p>
    <div class="clear"></div>
</div>
<div class="db-social">
	<img src="images/db-ss.png" alt="Google" />
    <p>Descriptive metadata about the repositories in Databib is accessible as <a href="https://docs.google.com/spreadsheet/ccc?key=0AoLuWEbu78KydExwNjZLSU9PUDhKQkRMNU0yUGxRQ3c">a spreadsheet in Google Docs</a> that is updated automatically every night. This is an easy way to download the content of Databib, which is used by other websites, such as <a href="http://datacite.org/repolist">DataCite</a>.</p>
    <div class="clear"></div>
</div>
<div class="db-social">
	<img src="images/db-add.png" alt="AddThis" />
    <p>You can recommend, like, tag, bookmark, or otherwise share information about repositories in Databib with over 300 social network platforms, including Facebook, Google+, Twitter, LinkedIn, Reddit, CiteULike, Tumblr, FriendFeed, MySpace, Connotea, Delicious, and Blogger! Look for the Share button at the bottom of each repository page. The number of shares are reported back to Databib from Facebook, Google+, and Twitter.</p>
    <div class="clear"></div>
</div>
<hr />
<div class="db-social">
	<a href="http://creativecommons.org/publicdomain/zero/1.0/" title="CC0"><img src="images/db-cc.png" alt="CC" /></a>
    <p>Open data encourage sharing and making connections that advance research and learning.  For this reason, all of the data associated with Databib are made available to the public domain using the <a href="http://creativecommons.org/publicdomain/zero/1.0/" title="Creative Commons Zero protocol">Creative Commons Zero protocol</a>. Our data are your data. The software that makes up Databib is available as free, open source software from <a href="http://code.google.com/p/databib" title="Google Code">Google Code</a> under the terms of the <a href="http://www.gnu.org/licenses/gpl.html" title="GNU General Public License">GNU General Public License</a>.</p>
    <div class="clear"></div>
</div>
</div>    

<?php include "include/footer.php"; ?>

</div>
</body>
</html>
