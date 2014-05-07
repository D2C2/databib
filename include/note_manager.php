<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<script>
function closeMe()
{
	var win=window.open("","_self");
	win.close();
}

/*$('#note_form').submit(function() {
    input.setAttribute('editor1', 'mwitt');
});*/
</script>
<body>

<?php

require_once("membersite_config.php");
if(!$fgmembersite->CheckLogin())
{
	session_start();
	$_SESSION["ORIG_LINK"] = $_SERVER['REQUEST_URI'];

    $fgmembersite->RedirectToURL("../login.php");
    exit;
}

include_once('database_connection.php');

$username = $fgmembersite->UserName();

$command = mysql_real_escape_string(@$_REQUEST['cmd']);
$table = mysql_real_escape_string(@$_REQUEST['type']);
$id = mysql_real_escape_string(@$_REQUEST['id']);
?>
<form name="note_form" method="post" action="update_editornote.php">
<input type="hidden" id="hiddenID" name="hiddenID" value="<?php echo $id;?>"/>
<input type="hidden" id="hiddenTable" name="hiddenTable" value="<?php echo $table;?>"/>
<table border="0" width="90%" style="table-layout: fixed;">
<col width=100>
<col width=320>

<?php
	

	$query = "SELECT editor_note FROM " . $table . " where id_rep = " . $id;
	$results = mysql_query ($query) ;
	if($row = mysql_fetch_array ($results)) {

		$editor_note = $row['editor_note'];
		$notes = explode("##", $editor_note);
		$note_count = 0;
		$last_note_editor = "";
		foreach ($notes as $value) {
			if($value != "") {
				$split_note = explode("#", $value);
				if(count($split_note) == 2) {
					$note_count += 1;
					$editor_name = mysql_fetch_row(mysql_query("SELECT name FROM users WHERE username = '" . $split_note[0] . "'"))[0];
					echo "<tr><td><input readonly type=\"hidden\" id=\"editor$note_count%\" name=\"editor$note_count\" value=\"$split_note[0]\" style=\"border:0\"><input readonly id=\"editorname$note_count%\" name=\"editorname$note_count\" value=\"$editor_name\" style=\"border:0\"></td><td>";
					
					if($username != $split_note[0])
						$read_only = "readonly";
					else
						$read_only = "";
					
					$split_note[1] = stripslashes($split_note[1]);
					echo "<textarea $read_only cols=\"50\" rows=\"4\" style=\"width:310px; margin-bottom:8px; resize: none;\" id=\"note$note_count\" name=\"note$note_count\">$split_note[1]</textarea>";
					
					echo "</td></tr>";
					$last_note_editor = $split_note[0];
				} else {
					require_once("config.php");
					
					mail($admin_email, "note_manager.php: Note problem", $id . " " . $split_note[0] . " " . $split_note[1], "From: Databib Editor-in-Chief <databib@gmail.com>");
				}
			}
		}
		
		if($username != $last_note_editor) {
			$note_count += 1;
			$editor_name = mysql_fetch_row(mysql_query("SELECT name FROM users WHERE username = '" . $username . "'"))[0];
			echo "<tr><td><input readonly type=\"hidden\" id=\"editor$note_count%\" name=\"editor$note_count\" value=\"$username\" style=\"border:0\"><input readonly id=\"editorname$note_count%\" name=\"editorname$note_count\" value=\"$editor_name\" style=\"border:0\"></td><td>";
			echo "<textarea cols=\"50\" rows=\"4\" style=\"width:310px; margin-bottom:8px; resize: none;\" id=\"note$note_count\" name=\"note$note_count\"></textarea>";
		}
	}

?>
	<tr>
		<td style="text-align:center;" colspan=2>
		<div>
			<input type="submit" value="Save note"/> 
			<input type="button" value="Cancel" onclick="closeMe()"/>
		</div>
		</td>
	</tr>
</table>
<input type="hidden" id="hiddenCount" name="hiddenCount" value="<?php echo $note_count;?>"/>
</form>
</body>
</html>