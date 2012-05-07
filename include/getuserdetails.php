
<?php
include_once('database_connection.php');
$username = mysql_real_escape_string(@$_REQUEST['userchoice']);
$sql = "select * from users where username='$username'";
$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);

if (!$_POST)
{
	$name = $row['name'];
	$email = $row['email'];
	$user_role = $row['user_role'];
	$username = $row['username'];	
	$password = $row['password'];
	
	$all_roles = "member editor";
	$other_role = str_replace($user_role, "", $all_roles);
	$other_role = trim($other_role);
	?>

<form method=post>
 <table border="0">
 <tr>
   <td>Name</td>
   <td> <input type='text' name="name" style="width: 250px; height: 20px; margin-left: 40px; margin-bottom: 10px;"
	value="<?php echo $row['name'];?>"> <br /> </td>
 </tr>

 <tr>
   <td>Email</td> 
   <td><input type='text' name="email" style="width: 250px; height: 20px; margin-left: 40px; margin-bottom: 10px;"
	value="<?php echo $row['email']; ?>" size=20> <br /></td>
</tr>	

 <tr>
   <td>User Role</td>
   <td> <select name="user_role" style="width: 250px; height: 20px; margin-left: 40px; margin-bottom: 10px;">
		   <option value="<?php echo $row['user_role'] ?>"><?php echo $row['user_role'] ?></option>
	       <option value="<?php echo $other_role ?>"><?php echo $other_role ?></option>
	    </select>  <br />
	</td>
 </tr>
 
 <tr>
   <td> User Name </td> 
   <td> <input type='text' name=username style="width: 250px; height: 20px; margin-left: 40px; margin-bottom: 10px;"
	value="<?php echo $row['username'];?>"> <br /> </td>
 </tr> 

 <tr>
  <td>Password </td> 
  <td><input type='password' name="password" style="width: 250px; height: 20px; margin-left: 40px; margin-bottom: 10px;"
	value="" size=20><br></td> 
  </tr>
  
 </table> <br/>
  <input type="submit" value="Submit"  value="Update"/> &nbsp;
  </form>
	<?php
	 
} else {
	$id = $row['id_user'];
	$name =  $_POST['name'];
	$useremail = $_POST['email'];
	$user_role = $_POST['user_role'];
	$username = $_POST['username'];	
	$password = $_POST['password'];
	if(!empty($password))
	{
			$sql = "update users set name='$name', email='$useremail', user_role='$user_role', 
			username='$username', password='".md5($password)."' where id_user='$id'";
	}
	else {
			$sql = "update users set name='$name', email='$useremail', user_role='$user_role', 
			username='$username' where id_user='$id'";
	}

	$result = mysql_query($sql) or die(mysql_error());
	echo 'The information was successfully updated';
}

?>


