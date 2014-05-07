<table style ="width: 850px">
	<col style ="width: 600px">
	<col style ="width: 200px">
	<tr>
	<td>
		
		<?php

		require_once("membersite_config.php");
		if(!$fgmembersite->CheckLogin()) {
			$fgmembersite->RedirectToURL("login.php");
			exit;
		}
		echo ' <br/><h3>Submissions waiting to be assigned</h3><br/>';
		include("waitingforassignment.php");
		echo "<br />";
		echo ' <br/><h3>Submissions assigned but not reviewed</h3><br/>';
		include("alreadyassigned_notreviewed.php");
		echo "<br />";
		echo ' <br/><h3>Submissions assigned, already reviewed and rejected</h3><br/>';
		include("alreadyassigned_reviewed_rejected.php");
		?>
		
	</td>
	<td valign="top">
		<?php include("./getwaitingbyeditor.php");?>
	</td>
	</tr>
</table>