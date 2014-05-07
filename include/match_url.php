<?php

  include_once('database_connection.php');

  function is_candidate($val)
  {
  
	if(strlen($val) < 3)
		return false;
	
	if($val === "com" ||
	$val === "org" ||
	$val === "net" ||
	$val === "gov" ||
	$val === "edu" ||
	strpos($val, "www") !==false)
		return false;
	
	return true;
  }
  
  function get_base_url($url)
  {
	if(strpos($url, "http") === false) {
		$url = "http://" . $url; // parse_url does not work properly if there is no scheme
	}
	
	$url_host = parse_url($url, PHP_URL_HOST);
	
	if(empty($url_host)) {
		$url_host = $url;
	}
	
	return $url_host;
  }
  //--------------------------------------------------------------------------
  // Query database for countries
  //--------------------------------------------------------------------------
  $url = mysql_real_escape_string(@$_REQUEST['url']) ;
  
  if(empty($url)) {
	return;
  }
  $base_url = get_base_url($url);
  
  $url_splits = explode(".", $base_url);  
  $url_filtered = array_filter($url_splits, "is_candidate");
  $url_splits = array_values($url_filtered);
  
  $url_splits[] = $url;
  

  $query = "SELECT id_rep,rep_url FROM approved ORDER BY rep_url";
  $result = mysql_query($query);          //query

  //--------------------------------------------------------------------------
  // echo result as json
  //--------------------------------------------------------------------------
  
  $url_score = array();
  $url_id_rep = array();

  //print_r($url_splits);
  
  while ($row = mysql_fetch_array($result, MYSQL_ASSOC))//loop through the retrieved values
  {
	$score = 0;
	for($j=0; $j < count($url_splits); $j++) {
	
		if(strpos($row['rep_url'], $url_splits[$j]) !== false) {
			$score += strlen($url_splits[$j]);
		}
	}
	if($score > 0) {
		$url_score[$row['rep_url']] = $score;
		$url_id_rep[$row['rep_url']] = $row['id_rep'];
	}
  }
  
  arsort($url_score);
  
  $i=0;
  $limit = 20;
  $matches = "";
  if(count($url_score) > 0) {
	$matches = "Matching records:<br>";
  }
  foreach($url_score as $key => $val) {
	$matches = $matches . "<a target=\"_blank\" href=\"repository/" . $url_id_rep[$key] . "\">" . $key . "</a><br/>";
	$i++;
	if( $i >= $limit)
		break;
  }
  echo $matches;
  //echo json_encode($row_set);
  
?>
