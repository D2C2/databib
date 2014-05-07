<?PHP
/*
error_reporting(E_ALL);
ini_set("display_errors", 1);*/
require_once("membersite_config.php");
	//echo $random_key;
$fgmembersite->CheckLogin();

include_once('database_connection.php');

$subject_id = mysql_real_escape_string($_GET['subjectid']);	

$cat = mysql_fetch_row(mysql_query("SELECT sub_title FROM subjects WHERE id_subject = $subject_id")); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="Author" content="Databib" />
<meta name="keywords" content="Databib, research, data, repository, repositories, registry, directory, research repositories, data repositories" />
<meta name="Description" content="Databib is a collaborative, annotated bibliography of primary research data repositories developed with support from the Institute of Museum and Library Services." />
<meta name="robots" content="All" />
<meta name="revisit-after" content="7 Days" />

<link href="/css/site.css" rel="stylesheet" type="text/css" />
<link href="/css/siteupdates.css" rel="stylesheet" type="text/css" />
<link href="/css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="/css/print.css" rel="stylesheet" type="text/css" media="handheld" />

<script type="text/javascript" src="/scripts/dropdown.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>

<title>Databib <?php if ($cat[0] != "") echo "| $cat[0] Data Repositories"; ?></title>
</head>

<body >

<div id="page-content">
<?php include "header.php"; ?>

  <div id="wrapper2">
    <div id="wrapper">
      <div id="body-content">
	    <br/><br/><br/><br/>
	    
	   
  <form name="search_bar" method="get" action="/search_results.php">
   <div style="width:700px; cellpadding:15px;">
       <span style="font: 14px arial;">Search</span>&nbsp;
         <input type="text" name="query" style="width:300px; height:22px;" autofocus> 
         </input> 
         &nbsp;&nbsp;
         <input type="submit" name="Submit" style="width:45px; height:26px;" 
           value="Find">
         </input> &nbsp;&nbsp;&nbsp;&nbsp;
<!--         <a href="advanced_search.php"> Advanced Search</a> -->
   </div>
  </form>
   <br/><br/>
   <h1>Browse <?php echo $cat[0]; ?></h1>
	 <br/>
	<div id="contentDiv">
	<?php 
	
		$results = mysql_query("SELECT a.rep_title, a.id_rep FROM approved a, subject_record_assoc_approved s WHERE s.id_subject = $subject_id AND s.id_record = a.id_rep ORDER BY a.rep_title"); 
		

		if (mysql_num_rows($results) > 0) {
			while( $row = mysql_fetch_row($results)) {
				echo "<a href='../repository/$row[1]' title='$row[0]'>$row[0]</a><br />";
			}
		}
		
		/* old
		$subject_id = mysql_real_escape_string(@$_REQUEST['subjectid']);

		$query = "select * from subject_record_assoc_approved where id_subject = ". $subject_id;
		$numresults = mysql_query ($query) or die(mysql_error()) ;

		while( $row = mysql_fetch_array($numresults) and $row['id_subject']!='')
		{
			$query2 = "select * from approved where id_rep = ". $row['id_record'];
			$recordresults = mysql_query ($query2) or die(mysql_error()) ;
			$rowrecord = mysql_fetch_array($recordresults);
			echo '<a href="../viewapprovedbyrecordid.php?record='.$rowrecord['id_rep']. '"style="color:#993300; font-size:14px">';
			echo $rowrecord['rep_title'];
			echo  '</a>';	
			if($rowrecord['rep_title'] != "")
			echo "<br>";

		}
		*/
	?>
	</div>
  <br/><br/><br/>
      </div>    
    </div>
  </div>

<?php include "footer.php"; ?>

</div>
</body>
</html>
