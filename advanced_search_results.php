<?PHP
require_once("./include/membersite_config.php");
$fgmembersite->CheckLogin();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="Author" content="Databib" />
<meta name="keywords" content="Databib, research, data, repository, repositories, registry, directory, research repositories, data repositories" />
<meta name="Description" content="Databib is a collaborative, annotated bibliography of primary research data repositories developed with support from the Institute of Museum and Library Services." />
<meta name="robots" content="All" />
<meta name="revisit-after" content="7 Days" />

<link href="css/site.css" rel="stylesheet" type="text/css" />
<link href="/css/siteupdates.css" rel="stylesheet" type="text/css" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="handheld" />
<link rel="shortcut icon" href="/images/bullet.ico" type="image/x-icon" />

<script src="/scripts/dropdown.js"></script>
<title>Databib</title>
</head>

<body>

<div id="page-content">
<?php include "include/header.php"; ?>

  <div id="wrapper2">
    <div id="wrapper">
      <div id="body-content">
	    <br/><br/><br/>
		<?php
		  include("./include/advancedsearchdb.php");
		?>
		<br/><br/><br/>
      </div>    
    </div>
  </div>

<?php include "include/footer.php"; ?>


</div>
</body>
</html>