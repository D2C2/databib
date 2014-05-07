<?PHP
require_once("./include/membersite_config.php");
$fgmembersite->CheckLogin();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="Author" content="Databib" />
<meta name="keywords" content="Databib, research, data, repository, repositories, registry, directory, research repositories, data repositories" />
<meta name="Description" content="Databib is a collaborative, annotated bibliography of primary research data repositories developed with support from the Institute of Museum and Library Services." />
<meta name="robots" content="All" />
<meta name="revisit-after" content="7 Days" />

<link href="css/site.css" rel="stylesheet" type="text/css" />
<link href="css/siteupdates.css" rel="stylesheet" type="text/css" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="handheld" />
<link rel="shortcut icon" href="/images/bullet.ico" type="image/x-icon" />

<script type="text/javascript" src="/scripts/dropdown.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>

<script type='text/javascript'>
	if (window.top !== window.self) {window.top.location = window.self.location;}
	
	function jumpTranslation(lang) {
		if(lang == "en") {
			window.location = "http://www.databib.org";
		} else {
			window.location = "http://translate.googleusercontent.com/translate_c?depth=1&hl=en&rurl=translate.google.com&sl=en&tl=" + lang + "&u=http://www.databib.org";
		}
	}
</script>

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
		
	$is_char = isset($_REQUEST['ch']);
	if($is_char) {
		$char = mysql_real_escape_string($_REQUEST['ch']);
	} else {
		$char = -1;
	}
 ?>

<title>Databib</title>
</head>

<body>


<div id="page-content">
<?php include "include/header.php"; ?>
  <div id="wrapper2">
    <div id="wrapper">
		  <div id="ticker">

      	<?PHP
      	include_once("./include/getTop5Records.php");?>
      </div>
      <div id="body-content" style="border-left:1px solid gray; padding-left: 4px;" >
	    <br/><br/><br/><br/>
	    
	   
  <form name="search_bar" method="get" action="search_results.php">
   <div style="width:700px;">
       <span style="font: 14px arial;">Search</span>&nbsp;
         <input type="text" name="query" style="width:300px; height:22px;" /> 
         &nbsp;&nbsp;
         <input type="submit" name="Submit" style="width:45px; height:26px;" value="Find"/>
         &nbsp;&nbsp;&nbsp;&nbsp;
         <a href="advanced_search.php"> Advanced Search</a> 
   </div>
  </form>
   <br/><br/>
   <h3>Browse 
	[ <!--<a href="#" style="text-decoration:none" onClick="browseAlphabet(<?php echo $startrow; ?>)">Alphabetical</a> |-->
	<a href="index_subjects.php" style="text-decoration:none" >Subjects</a> |
	<?php 
			function displayAlphabetRow() {
				$letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
				for($i = 0; $i < 26; $i++) {
					$ch = $letters[$i];
					echo " <a href=\"search.php?startrow=-1#{$ch}\" style=\"text-decoration:none\">{$ch}</a> ";
				}
			}
		displayAlphabetRow(); ?> |
		<a href="search.php?startrow=-1" style="text-decoration:none" >All</a>
	]</h3>
	<br/>
		<?php include "include/browse_all.php"; ?>
		<br/><br/>
		
      </div>    
    </div>
  </div>

<?php include "include/footer.php"; ?>

</div>
</body>
</html>
