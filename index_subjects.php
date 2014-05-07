<?PHP
require_once("./include/membersite_config.php");
$fgmembersite->CheckLogin();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Databib | Research Data Repositories</title>
<link rel="alternate" type="application/atom+xml" title="RSS" href="http://databib.org/displayRssFeeds.php">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="Author" content="Michael Witt" />
<meta name="keywords" content="data repository, repositories, data, datasets, research, data management plan, Databib, registry, catalog, directory, research repositories" />
<meta name="Description" content="Databib is a searchable catalog / registry / directory / bibliography of research data repositories. Find an appropriate place to deposit your data and discover new datasets to use in your research." />
<meta name="robots" content="All" />
<meta name="revisit-after" content="7 Days" />

<link title="Databib Repo Search" href="/opensearch.xml" rel="search" type="application/opensearchdescription+xml" />
<link href="css/site.css" rel="stylesheet" type="text/css" />
<link href="css/siteupdates.css" rel="stylesheet" type="text/css" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="handheld" />
<link rel="shortcut icon" href="/images/bullet.ico" type="image/x-icon" />

<script type="text/javascript" src="/scripts/dropdown.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
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


</head>

<body>

<div id="page-content">
	<?php include "include/header.php"; ?>
    <div id="wrapper2">
        <div id="wrapper">
            <div id="ticker">
            	<?PHP include_once("./include/getTop5Records.php");?>
            </div>
        	<div id="body-content" style="border-left:1px solid gray; padding:0 5px;" >
                <span class="style6"><br/>
                <strong>Databib</strong><span class="style7"> is a searchable</span>  catalog<span class="style7"> /</span> registry <span class="style7">/</span> directory <span class="style7">/</span> bibliography  <span class="style7">of </span><strong>research data repositories</strong>.                </span>
                <p>&nbsp;</p>
          <form name="search_bar" method="get" action="search_results.php">
                    <div style="width:700px; cellpadding:15px;">
                        <span style="font: 14px arial;">Search</span>&nbsp;
                        <input type="text" name="query" style="width:300px; height:22px;" /> 
                        &nbsp;&nbsp;
                        <input type="submit" name="Submit" style="width:45px; height:26px;" value="Find" class="button"/>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="advanced_search.php"> Advanced Search</a>                    </div>
                </form>
                <br/><br/>
                <h3>Browse 
                [ <a href="index.php" style="text-decoration:none" >Alphabetical</a> |
                <!--<a href="#" style="text-decoration:none" onClick="browseCategory(<?php echo $startrow_cat; ?>)">Subjects</a> |-->
				<?php 
						function displayAlphabetRow() {
							$letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
							for($i = 0; $i < 26; $i++) {
								$ch = $letters[$i];
								echo " <a href=\"search.php?startrow=-1#{$ch}\" style=\"text-decoration:none\">{$ch}</a> ";
							}
						}
					displayAlphabetRow(); ?> |
					<a href="#" style="text-decoration:none" onClick="browseAlphabet(-1)">All</a>
				]</h3>
				<br/>
                <?php include "include/browsedb_byCategory.php"; ?>
                <br/><br/><br/>
            </div>    
        
      </div>
    </div>
    <?php include "include/footer.php"; ?>
</div>
</body>
</html>
