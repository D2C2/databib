<?php

/**
 * Tweets a message from the user whose user token and secret you use.
 *
 * Although this example uses your user token/secret, you can use
 * the user token/secret of any user who has authorised your application.
 *
 * Instructions:
 * 1) If you don't have one already, create a Twitter application on
 *      https://dev.twitter.com/apps
 * 2) From the application details page copy the consumer key and consumer
 *      secret into the place in this code marked with (YOUR_CONSUMER_KEY
 *      and YOUR_CONSUMER_SECRET)
 * 3) From the application details page copy the access token and access token
 *      secret into the place in this code marked with (A_USER_TOKEN
 *      and A_USER_SECRET)
 * 4) Visit this page using your web browser.
 *
 * @author themattharris
 */

function post_tweet($tweet_text) {

  // Use Matt Harris' OAuth library to make the connection
  // This lives at: https://github.com/themattharris/tmhOAuth
  require_once('tmhOAuth/tmhOAuth.php');
  require 'tmhOAuth/tmhUtilities.php'; 
  // Set the authorization values
  // In keeping with the OAuth tradition of maximum confusion, 
  // the names of some of these values are different from the Twitter Dev interface
  // user_token is called Access Token on the Dev site
  // user_secret is called Access Token Secret on the Dev site
  // The values here have asterisks to hide the true contents 
  // You need to use the actual values from Twitter
 $tmhOAuth = new tmhOAuth(array(
    'consumer_key' => 'tmDpE7IXt1F5kY7bACrbQ',
    'consumer_secret' => 'hpwx56KlccBsQbACwYLIujqgx5FmczSXx6EndpzPwms',
    'user_token' => '463042482-bWJ2QpYnD84xqidiHQCI5sAIgqV0egou38Vafr0Q',
    'user_secret' => 'IxpQTJpsfYF2hzmpWtBV99Ww5PaG6fYtheIwSxGqAQ',
  )); 


  

$code = $tmhOAuth->request('POST', $tmhOAuth->url('1/statuses/update'), array(
  'status' => $tweet_text
));

/*
if ($code == 200) {
  tmhUtilities::pr(json_decode($tmhOAuth->response['response']));
} else {
  tmhUtilities::pr($tmhOAuth->response['response']);
}*/
  
  return $tmhOAuth->response['code'];
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
