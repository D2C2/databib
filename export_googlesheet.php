<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?PHP
//require_once("./include/membersite_config.php");
//$fgmembersite->CheckLogin();
require_once("include/config.php");
?>
<?php

global $email_id; /*Provide the email address where you wish to get notifications*/
global $email_pass;

$clientLibraryPath = '/var/www/html/databib/ZendFramework-1.12.3-minimal/library/';
//$oldPath = set_include_path(get_include_path() . PATH_SEPARATOR . $clientLibraryPath);
$oldPath = set_include_path($clientLibraryPath);

require_once('Zend/Loader.php');
Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');

include_once('include/database_connection.php');

$email = $email_id;
$password = $email_pass;
$spreadsheetKey = "0AoLuWEbu78KydExwNjZLSU9PUDhKQkRMNU0yUGxRQ3c";
$sheet_url = "https://docs.google.com/spreadsheet/ccc?key=" . $spreadsheetKey;
$worksheetId = "od6";

try {
	$client = Zend_Gdata_ClientLogin::getHttpClient($email, $password,
			Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME);
	
	$spreadsheetService = new Zend_Gdata_Spreadsheets($client);
	
	
	$query = new Zend_Gdata_Spreadsheets_ListQuery();
    $query->setSpreadsheetKey($spreadsheetKey);
    $query->setWorksheetId($worksheetId);
	//$query->setReverse('true');
    $listFeed = $spreadsheetService->getListFeed($query);

	//foreach ($listFeed->entries as $entry) {
		/*$rowData = $entry->getCustom();
		foreach($rowData as $customEntry) {
			echo $customEntry->getColumnName() . " = " . $customEntry->getText() . "\n";
		}*/
	//	$spreadsheetService->deleteRow($entry);
	//}
	
	
	$q = "SELECT id_rep FROM approved ORDER BY rep_title ASC";
	$connection = new mysqli($database_hostname, $database_username, $database_password, $database_name);
	if(mysqli_connect_errno()){
		echo mysqli_connect_error();
	}

	$result = $connection->query ($q);
	
	$ids = array();
	if($result){
		while ($row = $result->fetch_object()){
			$ids[] = $row->id_rep;
		}
		$result->close();
		$connection->next_result();
	}

	$i = 0;
	foreach ($ids as $id) {
		$q = "SELECT * FROM approved left join countries on approved.id_country = countries.id_country WHERE id_rep = " . $id ;
		$result = $connection->query ($q);
		$rowData = array();
		if($result && $row = $result->fetch_object()) {
				$rowData["title"] = $row->rep_title;
				$rowData["url"] = $row->rep_url;
				$rowData["description"] = $row->rep_description;
				$rowData["access"] = $row->rep_status;
				$rowData["startdate"] = $row->rep_startdate;
				$rowData["location"] = $row->country_name;
				$rowData["reuse"] = $row->rep_access;
				$rowData["deposit"] = $row->rep_deposit;
				$rowData["type"] = $row->rep_type;
				
				$result->close();
				$connection->next_result();
				
				$q = "select authorities.auth_name from approved_authorities left join authorities on authorities.id_authority = approved_authorities.id_authority where approved_authorities.id_record = " .$id;
				$result = $connection->query ($q);
				if($result) {
					$auths = "";
					while($row = $result->fetch_object()) {
						if($auths != "")
							$auths .= ", ";
						$auths .= $row->auth_name ;
					}
					$rowData["authority"] = $auths;
					$result->close();
					$connection->next_result();
				}
				
				$q = "select subjects.sub_title from subject_record_assoc_approved left join subjects on subjects.id_subject = subject_record_assoc_approved.id_subject where subject_record_assoc_approved.id_record = " .$id;
				$result = $connection->query ($q);
				if($result) {
					$subs = "";
					while($row = $result->fetch_object()) {
						if($subs != "")
							$subs .= ", ";
						$subs .= $row->sub_title ;
					}
					$rowData["subjects"] = $subs;
					$result->close();
					$connection->next_result();
				}
		}
		if($i < sizeof($listFeed->entries)) {
			$data = $listFeed->entries[$i]->getCustom();
			foreach($data as $customEntry) {
				if($customEntry->getColumnName() == "title" && $customEntry->getText() != $rowData["title"]) {
					$spreadsheetService->updateRow($listFeed->entries[$i], $rowData);
					break;
				}
			}
			$i++;
		} else {
			$insertedListEntry = $spreadsheetService->insertRow($rowData,
																$spreadsheetKey,
																$worksheetId);
		}
	}
	$connection->close();
	
	/*while ($i < sizeof($listFeed->entries)) {
		$spreadsheetService->deleteRow($listFeed->entries[$i]);
	}*/

} catch (Zend_Gdata_App_AuthException $ae) {
	echo "<br/>Error: " . $ae->getMessage() . "<br/>";
	exit();
}

echo "<br/>DONE generating the Googlesheet <a href=\"". $sheet_url . "\">" . $sheet_url . "</a><br/>";
?>
</html>