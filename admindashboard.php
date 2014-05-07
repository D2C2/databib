<?PHP
require_once("./include/membersite_config.php");
if(!$fgmembersite->CheckLogin()) {
    $fgmembersite->RedirectToURL("login.php");
    exit;
}


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
function userManagement() {
        var xmlhttp;
        if (window.XMLHttpRequest)
                xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function()
        {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                document.getElementById("contentDiv").innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","./include/usermanagement.php",true);
        xmlhttp.send();
}
function recordManagement() {
        var xmlhttp;
        if (window.XMLHttpRequest)
                xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function()
        {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                document.getElementById("contentDiv").innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","./include/recordmanagement.php",true);
        xmlhttp.send();
}
function queryView() {
    var xmlhttp;
    if (window.XMLHttpRequest)
            xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            document.getElementById("contentDiv").innerHTML=xmlhttp.responseText;
    }
    xmlhttp.open("GET","./include/adminqueryview.php",true);
    xmlhttp.send();
}
function initialContent() {
	recordManagement();
};
</script>

<title>Databib</title>

<style>
span.tab1 {padding-left: 2.5em;}
span.tab2 {padding-left: 3em;}

thead th,
tbody th
{
  background            : #FFF;
  color                 : #666;  
  padding               : 5px 10px;
  border-left           : 1px solid #CCC;
  border-right           : 2px solid #CCC;
}
tbody th
{
  background            : #fafafb;
  border-top            : 1px solid #CCC;
  text-align            : left;
  font-weight           : normal;
  border-right           : 2px solid #CCC;
}

tfoot th
{
  background            : #fafafb;
  border-top            : 1px solid #CCC;
  text-align            : left;
  font-weight           : normal;
  border-right           : 2px solid #CCC;
  border-bottom           : 2px solid #CCC;
}
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
			<h1>Welcome <?php echo $fgmembersite->UserFullName(); ?>!</h1>
			<br/>
			 [<a href="#"  style="text-decoration:none" onclick="userManagement();"> 
			 	<font size="2" color="FireBrick">User Management</font>
			 </a> |
			 <a href="#"  style="text-decoration:none" onclick="recordManagement();">
			 	<font size="2" color="FireBrick">Record Management</font> 
			 </a> |
			 <a href="#"  style="text-decoration:none" onclick="queryView();">
			 	<font size="2" color="FireBrick">Query View</font> 
			 </a> |
			 <a href="include/gen_all_snap.php"  target='_blank' style="text-decoration:none" >
			 	<font size="2" color="FireBrick">Generate thumbnails</font> 
			 </a> |
			 <a href="export_googlesheet.php"  target='_blank' style="text-decoration:none" >
			 	<font size="2" color="FireBrick">Generate Googlesheet</font> 
			 </a> | <br/>
			 <a href="include/checkurls.php"  target='_blank' style="text-decoration:none" >
			 	<font size="2" color="FireBrick">Find broken URLs</font> 
			 </a>]
	      	<div id="contentDiv"></div>
			<br><br><br>
		</div>
      </div>    
    </div>
  </div>

<?php include "include/footer.php"; ?>

</div>
</body>
</html>
