<?php


function post_tweet($tweet_text) {

	$clientLibraryPath = '/var/www/html/databib/ZendFramework-1.12.3-minimal/library/';
	$oldPath = set_include_path($clientLibraryPath);
	include_once('config.php');
	require_once('Zend/Service/Twitter.php');
	require_once('Zend/Oauth/Token/Access.php');

	global $twitter_token;
	global $twitter_tokensecret;
	global $twitter_consumerKey;
	global $twitter_consumerSecret;
 
	$token = new Zend_Oauth_Token_Access();
	$token->setToken($twitter_token)
		->setTokenSecret($twitter_tokensecret);

	$twitter = new Zend_Service_Twitter(array(
		'username' => 'databib',
		'accessToken' => $token,
		'oauthOptions' => array('consumerKey' => $twitter_consumerKey,
		'consumerSecret' => $twitter_consumerSecret)
	));

	$response = $twitter->statuses->update($tweet_text);
 
	return $response;
}  


function getSmallLink($longurl){  
// Bit.ly  
$url = "http://api.bit.ly/shorten?version=2.0.1&longUrl=$longurl&login=naveenatceg&apiKey=R_8af1b52ae10d55340375f9fd3ecc0b58&format=json&history=1";  
  
$s = curl_init();  
curl_setopt($s,CURLOPT_URL, $url);  
curl_setopt($s,CURLOPT_HEADER,false);  
curl_setopt($s,CURLOPT_RETURNTRANSFER,1);  
$result = curl_exec($s);  
curl_close( $s );  
  
$obj = json_decode($result, true);  
return $obj["results"]["$longurl"]["shortUrl"];  
}
?>
