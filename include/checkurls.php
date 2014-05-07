<?php

  include_once('database_connection.php');

  $query = "SELECT id_rep, rep_url FROM approved";
  $result = mysql_query($query);          //query

  //--------------------------------------------------------------------------
	/**
	 * get_redirect_url()
	 * Gets the address that the provided URL redirects to,
	 * or FALSE if there's no redirect. 
	 *
	 * @param string $url
	 * @return string
	 */
	function get_redirect_url($url){
		$redirect_url = null; 
	 
		$url_parts = @parse_url($url);
		if (!$url_parts) return false;
		if (!isset($url_parts['host'])) return false; //can't process relative URLs
		if (!isset($url_parts['path'])) $url_parts['path'] = '/';
		  
		$sock = fsockopen($url_parts['host'], (isset($url_parts['port']) ? (int)$url_parts['port'] : 80), $errno, $errstr, 30);
		if (!$sock) return false;
		  
		$request = "HEAD " . $url_parts['path'] . (isset($url_parts['query']) ? '?'.$url_parts['query'] : '') . " HTTP/1.1\r\n"; 
		$request .= 'Host: ' . $url_parts['host'] . "\r\n"; 
		$request .= "Connection: Close\r\n\r\n"; 
		fwrite($sock, $request);
		$response = '';
		while(!feof($sock)) $response .= fread($sock, 8192);
		fclose($sock);
	 
		if (preg_match('/^Location: (.+?)$/m', $response, $matches)){
			if ( substr($matches[1], 0, 1) == "/" )
				return $url_parts['scheme'] . "://" . $url_parts['host'] . trim($matches[1]);
			else
				return trim($matches[1]);
	  
		} else {
			return false;
		}
		 
	}
	 
	/**
	 * get_all_redirects()
	 * Follows and collects all redirects, in order, for the given URL. 
	 *
	 * @param string $url
	 * @return array
	 */
	function get_all_redirects($url){
		$redirects = array();
		while ($newurl = get_redirect_url($url)){
			if (in_array($newurl, $redirects)){
				break;
			}
			$redirects[] = $newurl;
			$url = $newurl;
		}
		return $redirects;
	}
	 
	/**
	 * get_final_url()
	 * Gets the address that the URL ultimately leads to. 
	 * Returns $url itself if it isn't a redirect.
	 *
	 * @param string $url
	 * @return string
	 */
	function get_final_url($url){
		$redirects = get_all_redirects($url);
		if (count($redirects)>0){
			return array_pop($redirects);
		} else {
			return $url;
		}
	}
  //--------------------------------------------------------------------------
  function check_url($url) {
	  $url = @parse_url($url); 
	if (!$url) return false; 
	 
	$url = array_map('trim', $url); 
	$url['port'] = (!isset($url['port'])) ? 80 : (int)$url['port']; 
	 
	$path = (isset($url['path'])) ? $url['path'] : '/'; 
	$path .= (isset($url['query'])) ? "?$url[query]" : ''; 
	 
	if (isset($url['host']) && $url['host'] != gethostbyname($url['host'])) { 
	 
		 $fp = fsockopen($url['host'], $url['port'], $errno, $errstr, 30); 
	 
		  if (!$fp) return false; //socket not opened
	 
			fputs($fp, "HEAD $path HTTP/1.1\r\nHost: $url[host]\r\n\r\n"); //socket opened
			$headers = fread($fp, 4096); 
			fclose($fp); 
	 
		 if(preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers)){//matching header
			   return true; 
		 } 
		 else return false;
	 
	 } // if parse url
	 else return false;
  }
  
  
  while ($row = mysql_fetch_array($result, MYSQL_ASSOC))//loop through the retrieved values
  {
		$url = $row['rep_url'];
		if(!strpos($url,'http://') && !strpos($url,'www')) {
			//$http_url = "http://" . $url;
			$http_url = "//" . $url;
		} else $http_url = $url;
		try {
			$i = 0;
			//$url = get_final_url($url);
			if(!check_url($url)) {
				echo "<a target='_blank' href=\"http://www.databib.org/repository/" . $row['id_rep'] . "\">Repository</a> :  <a target='_blank' href=\"" . $http_url . "\">" . $url . "<br/>";
			}
			
		}
		catch (Exception $e)
		{
			echo "<a target='_blank' href=\"http://www.databib.org/repository/" . $row['id_rep'] . "\">Repository</a> :  <a target='_blank' href=\"" . $http_url . "\">" . $url . "<br/>";
		}
		ob_flush(); 
		flush();  
		usleep(50000);
  }
  //echo json_encode($row_set);
?>
