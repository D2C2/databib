<?php
  session_start();
  require_once('recaptchalib.php');
  $privatekey = "6Ld5e9gSAAAAANmx7PAJw5YT9KH-fNz5C59Wo8Cm";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_REQUEST["recaptcha_challenge_field"],
                                $_REQUEST["recaptcha_response_field"]);

   $ret = "false";
   if ($resp->is_valid) {
     $ret = "true";	
     $_SESSION['valid'] = true;
   }
   echo $ret;
?>
