<?PHP
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once("config.php");
require_once("membersite.php");


$fgmembersite = new FGMembersite();

//Provide your site name here
$fgmembersite->SetWebsiteName($website_name);

//Provide the email address where you want to get notifications
$fgmembersite->SetAdminEmail($email_id);

//Provide your database login details here:
//hostname, user name, password, database name and table name
//note that the script will create the table (for example, users in this case)
//by itself on submitting register.php for the first time

$fgmembersite->InitDB($database_hostname,
/*username*/$database_username ,
/*password*/$database_password,
/*database name DO NOT CHANGE THIS*/$database_name,
/*table name DO NOT CHANGE THIS*/'users');

?>