
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

	//print_r($_POST);
	$id_rep = addcslashes(trim($_POST['hiddenID']), '\'');
	$table = addcslashes(trim($_POST['hiddenTable']), '\'');
	$note_count = addcslashes(trim($_POST['hiddenCount']), '\'');

	$username = $fgmembersite->UserName();
	
	$query = "select rep_editors from " . $table . " where id_rep = " . $id_rep;
	$result = mysql_query($query) or die(mysql_error());
	if($row = mysql_fetch_array ($result)) {
		$editors = explode(',', $row['rep_editors']);
		$is_allowed = false;
		for($i = 0; $i < count($editors); $i++){
			if($editors[$i] == $username) {
				$is_allowed = true;
			}
		}

		if(!$is_allowed)
			exit;
	}

	$new_note = "";
	$formatted_note = "";
	for($i = 1; $i <= $note_count; $i++) {
	 $editor = addcslashes(trim($_POST['editor' . $i]), '\'');
	 $note = addcslashes(trim($_POST['note' . $i]), '\'');
	 if(!empty($note)) {
		$new_note .= "##" . $editor . "#" . $note;
		if(!empty($formatted_note))
			$formatted_note .= "<br/>";
		$formatted_note .= "<span style='font-weight:bold;font-style:italic;' >" . mysql_fetch_row(mysql_query("SELECT name FROM users WHERE username = '" . $editor . "'"))[0] . ": </span>" . str_replace(array("\r", "\r\n", "\n"), ' ', $note);
	}
	}
	echo $formatted_note;
	$new_note = mysql_real_escape_string($new_note);
	$query = "update databibDB." . $table . " set editor_note = '" . $new_note . "' where id_rep = " . $id_rep;
	$result = mysql_query($query);

	if($result) {
	echo "true";
	} else {
	echo "false";
	}
?>
<html><body>  
<script>window.opener.update_note(<?php echo "\"" . $formatted_note . "\""; ?>);
window.close();
</script>  
</body>  
</html>  