
<?php
include_once('database_connection.php');
$username = $fgmembersite->UserName();
$sql = "select * from users where username='$username'";
$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);
 
if (!$_POST)
{
	$name = $row['name'];
	$email = $row['email'];
	$password = $row['password'];
	?>

<form method=post>Name <input type='text' name="name"
	style="width: 250px; height: 20px; margin-left: 40px; margin-bottom: 8px;"
	value="<?php echo $row['name'];?>"> <br />

Email <input type='text' name="email"
	style="width: 250px; height: 20px; margin-left: 40px; margin-bottom: 8px;"
	value="<?php echo $row['email']; ?>" size=20> <br />

Password <input type='password' name="password"
	style="width: 250px; height: 20px; margin-left: 15px; margin-bottom: 8px;"
	value="" size=20><br>

<input type=submit name="submit" value="Update" class="button"></form>

	<?php
	 
} else {

	$id = $row['id_user'];
	$useremail = $_POST['email'];
	$name =  $_POST['name'];
	$password = $_POST['password'];
	if(!empty($password)){
			$sql = "update users set email='$useremail', name='$name', password='".md5($password)."'  where id_user='$id'";
			
	}
	else {
			$sql = "update users set email='$useremail', name='$name' where id_user='$id'";		
	}
	$result = mysql_query($sql) or die(mysql_error());
	echo 'The information was successfully updated';
}

?>


