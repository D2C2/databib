<?php
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
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">

function advanceSearch() {
	var xmlhttp;
	if (window.XMLHttpRequest)
		xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    	document.getElementById("contentDiv").innerHTML=xmlhttp.responseText;
  	}
	xmlhttp.open("GET","./include/advancestyle=\"padding-left:8px;\"dsearchdb.php",true);
	xmlhttp.send();
}

</script>
<title>Databib</title>

<style type="text/css">
.style_b {font-weight:bold;}
td
{
height:50px;
vertical-align:center;
}
</style>
</head>

<body>

<div id="page-content">
<?php include "include/header.php"; ?>

  <div id="wrapper2">
    <div id="wrapper">
      <div id="body-content">
	    <br/><br/><br/>

<form name="advanced_search_bar" method="get" action="advanced_search_results.php">
   <div style="width:800px; cellpadding:0px;">
       <span style="font:18px helvetica;font-weight:bold;" >Search for</span>&nbsp;	   
	   <table border="0" width="90%">
		<tr>
		 <td><label class="style_b">All fields: </label></td>
         <td><input type="text" name="query_all" style="width:300px; height:22px; margin-bottom:0px;" autofocus></input></td>
		 <th rowspan="8" style="width:250px;vertical-align: top;font-weight:normal;"><br/><i>Hints for search:
		 <br> You can use 'and', 'or' and 'not' operators to control the search within any field.
		 <br>
		 <br> Examples:
		 <br> 'biology or agriculture'
		 <br> 'biology not agriculture'</i></th>
		</tr>
		<tr>
		 <td><label class="style_b">Title: </label></td>
         <td><input type="text" name="query_title" style="width:300px; height:22px; margin-bottom:0px;" ></input></td>
		</tr>
		<tr>
		 <td><label class="style_b">Description: </label></td>
         <td><input type="text" name="query_description" style="width:300px; height:22px; margin-bottom:0px;" ></input></td>
		</tr>
		<tr>
		 <td><label class="style_b">Authority: </label></td>
         <td><input type="text" name="query_authority" style="width:300px; height:22px; margin-bottom:0px;" ></input></td>
		</tr>
		<tr>
		 <td><label class="style_b">Subject: </label></td>
         <td><input type="text" name="query_subject" style="width:300px; height:22px; margin-bottom:0px;" ></input></td>
		</tr>
		<tr>
		 <td><label class="style_b">Classification: </label></td>
         <td><input type="text" name="query_classification" style="width:300px; height:22px; margin-bottom:0px;" ></input></td>
		</tr>
		<tr>
		 <td><label class="style_b">Country: </label></td>
         <td><input type="text" name="query_country" style="width:300px; height:22px; margin-bottom:0px;" ></input></td>
		</tr>
		
		<tr>
		 <td/>
		 <td>
         <input type="submit" name="Submit" style="width:45px; height:26px;" 
           value="Find">
         </input>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <a href="search.php" title="Go back to Basic Search">Go back to Basic Search</a> 
		 </td>
		 </tr>
		</table>
   </div>
  </form> 
    <br/><br/><br/>
  	  <div id="contentDiv"></div>
    <br/><br/><br/>
      </div>    
    </div>
  </div>

<?php include "include/footer.php"; ?>


</div>
</body>
</html>
