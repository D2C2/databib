<?PHP
require_once("./include/membersite_config.php");


error_reporting(E_ALL);
ini_set('display_errors', '1');

if(isset($_POST['submitted']))
{
   if($fgmembersite->Login())
   {
		if(isset($_SESSION['ORIG_LINK'])) {
			$destURL = $_SESSION['ORIG_LINK'];
			unset($_SESSION['ORIG_LINK']);
			header('Location: ' . $destURL);
			exit();
		} else {
			$fgmembersite->RedirectToURL("dashboard.php");
		}
   }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css"/>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="Author" content="Michael Witt" />
<meta name="Keywords" content="Databib data curation bibliography bibliographies Michael Witt Mike Giarlo Purdue Penn State University library science libraries repositories" />
<meta name="Description" content="Databib is a collaborative, annotated bibliography of primary research data repositories developed with support from the Institute of Museum and Library Services." />
<meta name="Robots" content="all" />

<link href="css/site.css" rel="stylesheet" type="text/css" />
<link href="/css/siteupdates.css" rel="stylesheet" type="text/css" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="handheld" />
<link rel="stylesheet" type="text/css" href="css/fg_membersite.css" />
<link rel="shortcut icon" href="/images/bullet.ico" type="image/x-icon" />

<script src="/scripts/dropdown.js"></script>
<title>Login</title>



<title>Databib</title>
</head>

<body>

<div id="page-content">
<?php include "include/header.php"; ?>

  <div id="wrapper2">
    <div id="wrapper">
      <div id="body-content" style ="width: 850px">
	    <br/><br/><br/>
        <div id='fg_membersite'>
		  <form id='login' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
		    <fieldset >
			  <legend>Login</legend>
			    <input type='hidden' name='submitted' id='submitted' value='1'/>
			    <div class='short_explanation'>* required fields</div>
				<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
				
				<div class='container'>
    			  <label for='username' >UserName* :</label><br/>
    			  <input type='text' name='username' id='username' value='<?php echo $fgmembersite->SafeDisplay('username') ?>' maxlength="50" autofocus/><br/>
    			  <span id='login_username_errorloc' class='error'></span>
			   </div>
				
			  <div class='container'>
    			<label for='password' >Password* :</label><br/>
    			<input type='password' name='password' id='password' maxlength="50" /><br/>
    			<span id='login_password_errorloc' class='error'></span>
			  </div>

			  <div class='container'>
    			<input type='submit' name='Submit' value='Submit' class="button"/>
			  </div>
			  <div class='short_explanation'><a href='reset-pwd-req.php'>Forgot Password?</a></div>
		  	</fieldset>
		  </form>
		  <br/>
		  <span style="font:14px arial,sans-serif; margin-left: 242px;"> 
		      New to Databib ? Create an account 
		  </span> 
		  
		  <a rel="license" href="register.php" style="text-decoration:none">
		    <span style="font:14px arial,sans-serif;">
		    here.  
		    </span> 
		  </a>
          <br/><br/><br/>
      </div>    
    </div>
  </div>

<?php include "include/footer.php"; ?>

<script type='text/javascript'>
// <![CDATA[

    var frmvalidator  = new Validator("login");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("username","req","Please provide your username");
    
    frmvalidator.addValidation("password","req","Please provide the password");

// ]]>
</script>

</div>
</body>
</html>


