<?php
	// initiate DB connection
	ini_set('display_errors',1);
	// ignore warnings, 
	error_reporting(E_ERROR | E_PARSE);
	include_once('database_connection.php');
	$sql = "select id_rep from approved";
	$result = mysql_query($sql) or die(mysql_error());
	$ids = array();
	while($elm = mysql_fetch_assoc($result)){
		array_push($ids, $elm['id_rep']);
	}
	$name = './tmp/resource.xml';
	
	//Creates XML string and XML document using the DOM  
 	$dom = new DomDocument('1.0', 'utf-8');  

	$rdf = $dom->createElement('rdf:RDF');
	$dom->appendChild($rdf);
	//rdf
	$xmlns_rdf = $dom->createAttribute('xmlns:rdf');
	$rdf->appendChild($xmlns_rdf);
	$value = $dom->createTextNode('http://www.w3.org/1999/02/22-rdf-syntax-ns#');
	$xmlns_rdf->appendChild($value);
	//dc
	$xmlns_dc = $dom->createAttribute('xmlns:dc');
	$rdf->appendChild($xmlns_dc);
	$value = $dom->createTextNode('http://purl.org/dc/elements/1.1/');
	$xmlns_dc->appendChild($value);
	//dcterms
	$xmlns_dcterms = $dom->createAttribute('xmlns:dcterms');
	$rdf->appendChild($xmlns_dcterms);
	$value = $dom->createTextNode('http://purl.org/dc/terms/');
	$xmlns_dcterms->appendChild($value);
	//foaf
	$xmlns_foaf = $dom->createAttribute('xmlns:foaf');
	$rdf->appendChild($xmlns_foaf);
	$value = $dom->createTextNode('http://xmlns.com/foaf/0.1/');
	$xmlns_foaf->appendChild($value);
	//cc
	$xmlns_cc = $dom->createAttribute('xmlns:cc');
	$rdf->appendChild($xmlns_cc);
	$value = $dom->createTextNode('http://creativecommons.org/ns#');
	$xmlns_cc->appendChild($value);
	//ore
	$xmlns_ore = $dom->createAttribute('xmlns:ore');
	$rdf->appendChild($xmlns_ore);
	$value = $dom->createTextNode('http://openarchives.org/ore/terms/');
	$xmlns_ore->appendChild($value);
	//databib
	$xmlns_databib = $dom->createAttribute('xmlns:databib');
	$rdf->appendChild($xmlns_databib);
	$value = $dom->createTextNode('http://databib.org/ns#');
	$xmlns_databib->appendChild($value);		
	
	foreach($ids as $ID){
		//adding elements to the RDFXML
		$query = "select * from approved where id_rep ='$ID'";
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_array($result);
		
		$content = $rdf->appendChild($dom->createElement('rdf:Description'));
		$contentAttr = $dom->createAttribute('rdf:about');
		$contentAttr->value = $_SERVER['HTTP_HOST'].'/viewapprovedbyrecordid.php?record='.$ID;
		$content->appendChild($contentAttr);
	
		//dcterms:title
		$title = $dom->createElement('dcterms:title');
		$content->appendChild($title);
		$item = $dom->createTextNode($row['rep_title']);
		$title->appendChild($item);
		//foaf:homepage
		$homepage = $dom->createElement('foaf:homepage');
		$content->appendChild($homepage);
		$item = $dom->createTextNode($row['rep_url']);
		$homepage->appendChild($item);
		//dcterms:publisher
		$publisher = $dom->createElement('dcterms:publisher');
		$content->appendChild($publisher);
		$item = $dom->createTextNode($row['rep_authority']);
		$publisher->appendChild($item);
		//dcterms:description
		$description = $dom->createElement('dcterms:description');
		$content->appendChild($description);
		$item = $dom->createTextNode($row['rep_description']);
		$description->appendChild($item);
		//databib:status
		$status = $dom->createElement('databib:status');
		$content->appendChild($status);
		$item = $dom->createTextNode($row['rep_status']);
		$status->appendChild($item);
		//dcterms:created
		$created = $dom->createElement('dcterms:created');
		$content->appendChild($created);
		$item = $dom->createTextNode($row['rep_startdate']);
		$created->appendChild($item);
		//dcterms:spatial
		$spatial = $dom->createElement('dcterms:spatial');
		$content->appendChild($spatial);
		$item = $dom->createTextNode($row['rep_location']);
		$spatial->appendChild($item);
		//databib:reusePolicy
		$reuse = $dom->createElement('databib:reusePolicy');
		$content->appendChild($reuse);
		$item = $dom->createTextNode($row['rep_access']);
		$reuse->appendChild($item);
		//databib:depositPolicy
		$deposit = $dom->createElement('databib:depositPolicy');
		$content->appendChild($deposit);
		$item = $dom->createTextNode($row['rep_deposit']);
		$deposit->appendChild($item);
		//databib:type
		$type = $dom->createElement('databib:type');
		$content->appendChild($type);
		$item = $dom->createTextNode($row['rep_type']);
		$type->appendChild($item);
		//dcterms:subject
		$subquery = "select * from subjects, subject_record_assoc_approved where subjects.id_subject = subject_record_assoc_approved.id_subject AND subject_record_assoc_approved.id_record = $ID";
		$subresult = mysql_query($subquery) or die(mysql_error());
		while($subrow = mysql_fetch_array($subresult))
			{
				$subject = $dom->createElement('dcterms:subject');
				$content->appendChild($subject);
				$item = $dom->createTextNode($subrow['sub_url']);
				$subject->appendChild($item);

			}
		//dcterms:rights
		$rights = $dom->createElement('dcterms:rights');
		$content->appendChild($rights);
		$rightsAttr = $dom->createAttribute('rdf:resource');
		$rightsAttr->value = 'http://creativecommons.org/licenses/by-nc/2.5/';
		$rights->appendChild($rightsAttr);	
	}
	//generate xml  
 	$dom->formatOutput = true; // set the formatOutput attribute of  
                            // domDocument to true  
 	// save XML as string or file  
 	$stringDom = $dom->saveXML();   
 	//$dom->save($name); // save as file  
 	
	
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Length: ". filesize("$name").";");
	header("Content-Disposition: attachment; filename=".basename($name));
	header("Content-Type: application/octet-stream; "); 
	header("Content-Transfer-Encoding: binary");
	echo $stringDom;
 
?>
