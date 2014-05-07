<?PHP
require_once("./include/membersite_config.php");
if(!$fgmembersite->CheckLogin()) {
	session_start();
	$_SESSION["ORIG_LINK"] = $_SERVER['REQUEST_URI'];
	
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
$editor = @$_REQUEST['editor'];

if($fgmembersite->UserFullName() !="Databib Admin")
	{
		echo "Restricted page for the user";
		exit;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css"/>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="Author" content="Databib" />
<meta name="Keywords" content="Databib data curation bibliography bibliographies Michael Witt Mike Giarlo Purdue Penn State University library science libraries repositories" />
<meta name="Description" content="Databib is a collaborative, annotated bibliography of primary research data repositories developed with support from the Institute of Museum and Library Services." />
<meta name="Robots" content="all" />

<link href="css/site.css" rel="stylesheet" type="text/css" />
<link href="css/siteupdates.css" rel="stylesheet" type="text/css" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="handheld" />
<link rel="shortcut icon" href="/images/bullet.ico" type="image/x-icon" />

<script src="/scripts/dropdown.js"></script>
<script type="text/javascript">

</script>

<title>Databib</title>

<style>
span.tab1 {padding-left: 1.7em;}
span.tab2 {padding-left: 3em;}
</style>

</head>

<body onload="initialContent();">

<div id="page-content">
<?php include "include/header.php"; ?>

  <div id="wrapper2">
    <div id="wrapper">
      <div id="body-content" style ="width: 900px">
	    <br/><br/><br/>	
        <div id='fg_membersite_content' style ="width: 800px">
			<?php include "include/getassignedbyeditor.php"; ?>
		</div>
      </div>    
    </div>
  </div>

<?php include "include/footer.php"; ?>

</div>
</body>
</html>
