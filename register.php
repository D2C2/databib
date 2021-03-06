<?PHP
require_once("./include/membersite_config.php");
echo $fgmembersite->GetErrorMessage();

if(isset($_POST['submitted']))
{
   if($fgmembersite->RegisterUser())
   {
        $fgmembersite->RedirectToURL("thank-you.php");
   }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css"/>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="Author" content="Databib" />
<meta name="Keywords" content="Databib data curation bibliography bibliographies Michael Witt Mike Giarlo Purdue Penn State University library science libraries repositories" />
<meta name="Description" content="Databib is a collaborative, annotated bibliography of primary research data repositories developed with support from the Institute of Museum and Library Services." />
<meta name="Robots" content="all" />

<link href="css/site.css" rel="stylesheet" type="text/css" />
<link href="/css/siteupdates.css" rel="stylesheet" type="text/css" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="handheld" />
<link rel="shortcut icon" href="/images/bullet.ico" type="image/x-icon" />

<script src="/scripts/dropdown.js"></script>

<title>Databib</title>


    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    <title>Contact us</title>
    <link rel="STYLESHEET" type="text/css" href="css/fg_membersite.css" />
    <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
    <link rel="STYLESHEET" type="text/css" href="css/pwdwidget.css" />
    <script src="scripts/pwdwidget.js" type="text/javascript"></script>      

</head>

<body>

<div id="page-content">
<?php include "include/header.php"; ?>

  <div id="wrapper2">
    <div id="wrapper">
      <div id="body-content" style ="width: 850px">
	   <!-- Form Code Start -->
		<div id='fg_membersite'>
		   <br/><br/><br/>
		  <form id='register' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
			<fieldset >
			 <legend>Register</legend>
			 <input type='hidden' name='submitted' id='submitted' value='1'/>

             <div class='short_explanation'>* required fields</div>
			 <input type='text'  class='spmhidip' name='<?php echo $fgmembersite->GetSpamTrapInputName(); ?>' />

			<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
			
			<div class='container'>
    		  <label for='name' >Your Full Name*: </label><br/>
    		  <input type='text' name='name' id='name' value='<?php echo $fgmembersite->SafeDisplay('name') ?>' maxlength="50" /><br/>
		      <span id='register_name_errorloc' class='error'></span>
			</div>
			
			<div class='container'>
    		  <label for='email' >Email Address*:</label><br/>
    		  <input type='text' name='email' id='email' value='<?php echo $fgmembersite->SafeDisplay('email') ?>' maxlength="50" /><br/>
    		  <span id='register_email_errorloc' class='error'></span>
            </div>

			<div class='container'>
    		  <label for='username' >UserName*:</label><br/>
    		  <input type='text' name='username' id='username' value='<?php echo $fgmembersite->SafeDisplay('username') ?>' maxlength="50" /><br/>
    		  <span id='register_username_errorloc' class='error'></span>
            </div>

			<div class='container' style='height:80px;'>
    		  <label for='password' >Password*:</label><br/>
    		  <div class='pwdwidgetdiv' id='thepwddiv' ></div>
              <noscript>
    		  <input type='password' name='password' id='password' maxlength="50" />
    		  </noscript>    
    	      <div id='register_password_errorloc' class='error' style='clear:both'></div>
		   </div>		

			<div class='container'>
    		  <input type='submit' name='Submit' value='Submit' class="button"/>
			</div>

	      </fieldset>
		</form>
		 <br/><br/><br/>
      </div>    
    </div>
  </div>

<?php include "include/footer.php"; ?>

</div>

<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->

<script type='text/javascript'>
// <![CDATA[
    var pwdwidget = new PasswordWidget('thepwddiv','password');
    pwdwidget.MakePWDWidget();
    
    var frmvalidator  = new Validator("register");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();
    frmvalidator.addValidation("name","req","Please provide your name");

    frmvalidator.addValidation("email","req","Please provide your email address");

    frmvalidator.addValidation("email","email","Please provide a valid email address");

    frmvalidator.addValidation("username","req","Please provide a username");
    
    frmvalidator.addValidation("password","req","Please provide a password");

// ]]>
</script>
</body>
</html>

