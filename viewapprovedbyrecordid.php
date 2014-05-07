<?PHP
require_once("./include/membersite_config.php");
$fgmembersite->CheckLogin();

include_once('include/database_connection.php');
$record_id = mysql_real_escape_string(@$_REQUEST['record']);
$sql = "select * from approved left join countries on approved.id_country = countries.id_country where id_rep ='$record_id'";
mysql_query("set names 'utf8'");
$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);
$country = $row['country_name'];
if(!empty($country)) {
	if(empty($row['latitude'])) {
		require('./gogeocode/src/GoogleGeocode.php');

		$apiKey = 'AIzaSyCHG22JDxC2tVrOrd9ynNKmUgVk5b_BbqM';
		$geo = new GoogleGeocode( $apiKey );

		$result = $geo->geocode( $country );

		$latitude = $result['Geometry']['Latitude'];
		$longitude = $result['Geometry']['Longitude'];
		//print_r( $result );
		$upd = 'UPDATE countries SET latitude= ' . $latitude . ', longitude=' . $longitude . ' WHERE id_country=' . $row['id_country'];
		$upd_result = mysql_query($upd) or die(mysql_error());
		
		//echo $result['Geometry']['Latitude'];
	} else
	{
		$latitude = $row['latitude'];
		$longitude = $row['longitude'];
	}

	if(empty($row['google_zoom']))
		$google_zoom = 4;
	else
		$google_zoom = $row['google_zoom'];
} else {
	$latitude = 0;
	$longitude = 0;
	$google_zoom = 0;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML + RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:foaf="http://xmlns.com/foaf/0.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:ore="http://openarchives.org/ore/terms/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"  xmlns:databib="http://databib.org/ns#" 
xmlns:gn="http://www.geonames.org/ontology#" xml:lang="en">
<head>

<style type="text/css">
textarea { width: 100%; margin: 0; padding: 0; border-width: 0; }
tr.spaceUnder > td
{
  padding-bottom: 1em;
}
</style>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="Author" content="Databib" />
<meta name="keywords" content="Databib, research, data, repository, repositories, registry, directory, research repositories, data repositories" />
<meta name="Description" content="Databib is a collaborative, annotated bibliography of primary research data repositories developed with support from the Institute of Museum and Library Services." />
<meta name="robots" content="All" />
<meta name="revisit-after" content="7 Days" />
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

<link href="http://databib.org/css/site.css" rel="stylesheet" type="text/css" />
<link href="http://databib.org/css/siteupdates.css" rel="stylesheet" type="text/css" />
<link href="http://databib.org/css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="http://databib.org/css/print.css" rel="stylesheet" type="text/css" media="handheld" />
<link href="../include/serializeRDFXML.php" rel="alternate" type="application/rdf+xml" />
<link rel="shortcut icon" href="/images/bullet.ico" type="image/x-icon" />

<script src="/scripts/dropdown.js" type="text/javascript"></script>
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="/scripts/comments.js" type="text/javascript"></script>

	<link href="http://code.google.com/apis/maps/documentation/javascript/examples/default.css" rel="stylesheet" type="text/css">

    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHG22JDxC2tVrOrd9ynNKmUgVk5b_BbqM&sensor=false">
    </script>

 <script type="text/javascript">
	var marker;  
	 
	function editNote(id_note, id_rep, table)
	{
		url = '/include/note_manager.php?type=' + table + '&id=' + id_rep;
		popupWindow = window.open(url,'popUpWindow','height=400,width=450,left=600,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');
	}

	function update_note(note)
	{
		document.getElementById("editor_note").innerHTML = note;
	}
	
	
	function initialize() {
	  // created using http://gmaps-samples-v3.googlecode.com/svn/trunk/styledmaps/wizard/index.html
		var stylez = [
		  {
			"featureType": "administrative.country",
			"elementType": "geometry",
			"stylers": [
				  { "weight": 1 }//,
				  //{ "color": "#e58682" }
				]
		  },
		  {
			"featureType": "administrative.country",
			"elementType": "labels.text.fill",
			"stylers": [
			  { "visibility": "off" }
			]
		  },
		  {
			"featureType": "landscape.natural",
			"stylers": [
			  { "visibility": "off" }
			]
		  }
		];

		var address = "<?php echo $country; ?>";
		var address_dashed = address.replace(" ", "-");
		
		var customMapType = new google.maps.StyledMapType(stylez,
				{name: address});

		var location = new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>);
        var mapOptions = {
			  center: location,
			  zoom: <?php echo $google_zoom; ?>,
			  mapTypeId: google.maps.MapTypeId.ROADMAP,
			  zoomControl: false,
			  streetViewControl: false,
			  draggable: false,
			  disableDoubleClickZoom: true,
			  //scrollwheel: false,
			  mapTypeControlOptions: {
				mapTypeIds: ['Border View']
              }
        };
		
		var map = new google.maps.Map(document.getElementById("myMap"),
            mapOptions);
			
		map.mapTypes.set('Border View', customMapType);
		map.setMapTypeId('Border View');

		marker = new google.maps.Marker({
				position: location,
				map: map
			});		

		var icon_path = "http://databib.org/flags/png/" + address_dashed + "-16.png";
			marker.setIcon(icon_path);
      }
      google.maps.event.addDomListener(window, 'load', initialize);

 </script>
		 
<title>Databib | <?php echo $row['rep_title']; ?></title>
</head>

<body>

<div id="page-content">
<?php include "include/header.php"; ?>


  <div id="wrapper2">
    <div id="wrapper">
      <div id="record-body">
      	
        <div class="col">
			<?php include("./include/getapprovedbyrecordid.php"); ?>
        </div>
        
        <div class="col2">

     <?php if ($url != '') { 
		$img_path = '/var/www/html/databib/Knplabs/Snappy/' . $record_id . '.jpg';
		$img_web_path = 'http://databib.org/Knplabs/Snappy/' . $record_id . '.jpg';
		/*if (!file_exists($img_path)) {
			$line = '';
			include("./include/gen_snap.php"); 
		}*/
		if (file_exists($img_path) && filesize($img_path) > 10*1024) {
	?>
    	<div id='mySnap'>
		<a href="<?php echo $url; ?>">
		<img src="<?php echo $img_web_path; ?>" alt="" width="320" height="250">
		</a>
        </div>
	<?php }	}?>


	
		<?php if ($country != '') { ?>
			<div id="myMap" style="width: 320px; height: 250px;"></div>	
		<?php } ?>
        

    <h1>Annotations</h1>
    <?php include("./include/getcommentsbyrecordid.php"); ?><br />
    <h2>Add an Annotation:</h2>
    <form method="post" action="" name="commentsform" id="commentsform">
        <input type="hidden" name="recordid" id="recordid" value="<?php echo $record_id ?>" />
        <input type="hidden" name="author" id="author" value="<?php echo $fgmembersite->UserName() ?>" />
        <table width="92%" cellpadding="3">
            <tr class="spaceUnder">
                <td>
					<textarea cols="42" rows="2" name="commenttext" id="commenttext"></textarea>
				</td>  
            </tr>
			<tr>
				<td align="right"><input type="submit" id="post" value="Post"/></td>
			</tr>
        </table>
    </form>
        
        </div>
        
        <div class="clear"></div>

      </div>  
    </div>
  </div>
  
<div style="clear:both;width: 974px; margin: 0 auto;display: block;height: 60px; padding:0; background:url(http://databib.org/images/tagline2.jpg) top center no-repeat #000">
    <div id="footer-copyright" style="margin:5px 0 0 0">
        <p xmlns:dct="http://purl.org/dc/terms/" xmlns:vcard="http://www.w3.org/2001/vcard-rdf/3.0#">
        <a href="../include/serializeRDFXML.php"><img src="http://www.w3.org/RDF/icons/rdf_metadata_button.32" width="55" height="21" border="0" alt="RDF Resource Description Framework Metadata Icon"/></a>
        <a rel="license" href="http://creativecommons.org/publicdomain/zero/1.0/"><img src="http://i.creativecommons.org/p/zero/1.0/88x31.png" style="border-style: none;" alt="The content, data, and source code of Databib are dedicated to the Public Domain using the CC0 protocol." /></a></p>
    </div>
</div>   

</div>
</body>
</html>