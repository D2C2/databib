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

	function color_diffs ( $old, $new ) {

		if ( empty($old) ) {
			$ret = "<font face=arial size=2 color=\"black\">$new</font>";
		} else if ( strcmp($new, $old) == 0 ) {
			$ret = "<font face=arial size=2 color=\"gray\">$new</font>";
		} else {
			require_once('string_diff.php');
			$ret = htmlDiff( $old, $new );
		}
		return $ret;
	}
	
	function format_note($editor_note) {
		if(strlen($editor_note) == 0)
			return '';
			
		$notes = array_filter(explode("##", $editor_note), 'strlen');

		$formatted_note = "";
		foreach ($notes as $key => $value) {
			if($key > 0) {
				$split_note = explode("#", $value);
				if(!empty($formatted_note))
					$formatted_note .= "<br/>";
				$formatted_note .= "<span style=\"font-weight:bold;font-style:italic;\" >" . mysql_fetch_row(mysql_query("SELECT name FROM users WHERE username = '" . $split_note[0] . "'"))[0] . ": </span>";
				$formatted_note .= $split_note[1];
			}
		}
		if(strlen($formatted_note))
			return '<p name="editor_note" id="editor_note">' . $formatted_note . '</p>';
		return '';
	}
	
	//--------------------------------------------------------------------------
	// Query database for countries
	//--------------------------------------------------------------------------
	$record_type = mysql_real_escape_string(@$_REQUEST['type']) ;
	$record_id = mysql_real_escape_string(@$_REQUEST['record_id']) ;
	if($record_type == "N") {
		$query = "SELECT * FROM notapproved left join countries on notapproved.id_country = countries.id_country where id_rep =$record_id";
		$result = mysql_query($query);
		if($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$rep_link_to_approved = $row['rep_link_to_approved'];
			if($rep_link_to_approved != -1) {
				$sql_approved = "select * from approved left join countries on approved.id_country = countries.id_country where id_rep ='$rep_link_to_approved'";
				$result_approved = mysql_query($sql_approved) or die(mysql_error());
				$row_approved = mysql_fetch_array($result_approved);
			}
			
			foreach($row as $key => $value) {
				if($rep_link_to_approved != -1) {
					$res[$key] = color_diffs($row_approved[$key], $value);
				} else {
					$res[$key] = color_diffs('', $value);
				}
			}
			
			if($rep_link_to_approved != -1) {
				$color_sub = "gray";
				$is_ins_beg = "><ins>";
				$is_ins_end = "</ins>";
			} else {
				$color_sub = "black";
				$is_ins_beg = " style=\"color:black\">";
				$is_ins_end = "";
			}
			
			$subjects = "";
			$authorities = "";
			mysql_query("set names 'utf8'");
			if($rep_link_to_approved != -1) {
				$subquery = "select subjects.sub_title, subjects.id_subject from subjects, subject_record_assoc join subject_record_assoc_approved on subject_record_assoc.id_subject = subject_record_assoc_approved.id_subject where subjects.id_subject = subject_record_assoc.id_subject and subject_record_assoc.id_record = $record_id and subject_record_assoc_approved.id_record = $rep_link_to_approved order by subjects.sub_title";
				$subresult = mysql_query($subquery) or die(mysql_error());
				
				$subjects .= "<div id='selectedSubjects'>";
				while($subrow = mysql_fetch_array($subresult))
				{
					$subjects .= "<div class = 'selectedsubject' style='color:" . $color_sub . "'>".$subrow['sub_title'] . "</div>";
				}
				
				$subquery = "select a.auth_name, a.id_authority from authorities a, notapproved_authorities n join approved_authorities aa on n.id_authority = aa.id_authority where a.id_authority = n.id_authority and n.id_record = $record_id and aa.id_record = $rep_link_to_approved order by aa.auth_order";
				$subresult = mysql_query($subquery) or die(mysql_error());
				
				$authorities .= "<div id='selectedSubjects'>";
				while($subrow = mysql_fetch_array($subresult))
				{
					$authorities .= "<div class = 'selectedsubject' style='color:" . $color_sub . "'>".$subrow['auth_name'] . "</div>";
				}
			}
			
			$subquery = "select subjects.sub_title, subjects.id_subject from subjects, subject_record_assoc where not exists ( select 1 from subject_record_assoc_approved where subject_record_assoc.id_subject = subject_record_assoc_approved.id_subject and subject_record_assoc_approved.id_record = $rep_link_to_approved) and subjects.id_subject = subject_record_assoc.id_subject and subject_record_assoc.id_record = $record_id 
	 order by subjects.sub_title";
			$subresult = mysql_query($subquery) or die(mysql_error());
			
			while($subrow = mysql_fetch_array($subresult))
			{
				$subjects .= "<div class = 'selectedsubject'" . $is_ins_beg . $subrow['sub_title'] . $is_ins_end . "</div>";
			}

			$subquery = "select a.auth_name, a.id_authority from authorities a, notapproved_authorities n where not exists ( select 1 from approved_authorities aa where n.id_authority = aa.id_authority and aa.id_record = $rep_link_to_approved) and a.id_authority = n.id_authority and n.id_record = $record_id order by n.auth_order";
			$subresult = mysql_query($subquery) or die(mysql_error());
			
			while($subrow = mysql_fetch_array($subresult))
			{
				$authorities .= "<div class = 'selectedsubject'" . $is_ins_beg . $subrow['auth_name'] . $is_ins_end . "</div>";
			}				

			if($rep_link_to_approved != -1) {
				$subquery = "select subjects.sub_title, subjects.id_subject from subjects, subject_record_assoc_approved where not exists ( select 1 from subject_record_assoc where subject_record_assoc.id_subject = subject_record_assoc_approved.id_subject and subject_record_assoc.id_record = $record_id) and subjects.id_subject = subject_record_assoc_approved.id_subject and subject_record_assoc_approved.id_record = $rep_link_to_approved  order by subjects.sub_title";
				$subresult = mysql_query($subquery) or die(mysql_error());
				
				while($subrow = mysql_fetch_array($subresult))
				{
					$subjects .=  "<div class = 'selectedsubject'><del>".$subrow['sub_title'] . "</del></div>";
				}	
				$subjects .= "</div>";
				
				$subquery = "select a.auth_name, a.id_authority from authorities a, approved_authorities aa where not exists ( select 1 from notapproved_authorities n where n.id_authority = aa.id_authority and n.id_record = $record_id) and a.id_authority = aa.id_authority and aa.id_record = $rep_link_to_approved  order by aa.auth_order";
				$subresult = mysql_query($subquery) or die(mysql_error());
				
				while($subrow = mysql_fetch_array($subresult))
				{
					$authorities .=  "<div class = 'selectedsubject'><del>".$subrow['auth_name'] . "</del></div>";
				}	
				$authorities .= "</div>";
			}
			$res['subjects'] = $subjects;
			$res['authorities'] = $authorities;
			/*if($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			
				$subquery = "SELECT subjects.sub_title FROM subjects, subject_record_assoc WHERE subjects.id_subject = subject_record_assoc.id_subject AND subject_record_assoc.id_record = $record_id ORDER BY subjects.sub_title";
				$subresult = mysql_query($subquery);
				while($subrow = mysql_fetch_array($subresult,MYSQL_ASSOC))
					$row['subjects'][] = $subrow['sub_title'];
			}*/
		}
	} else if($record_type == "A") {
		$query = "SELECT * FROM approved left join countries on approved.id_country = countries.id_country where id_rep =$record_id";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
		
		$subquery = "SELECT subjects.sub_title, subjects.id_subject FROM subjects, subject_record_assoc_approved WHERE subjects.id_subject = subject_record_assoc_approved.id_subject AND subject_record_assoc_approved.id_record = $record_id ORDER BY subjects.sub_title";
		$subresult = mysql_query($subquery);
		$res = $row;
		
		while($subrow = mysql_fetch_array($subresult,MYSQL_ASSOC))
			$res['subjects'][] = $subrow['sub_title'];
		$res['subjects'] = join("<br/>", $res['subjects']);

		$subquery = "SELECT a.auth_name, a.id_authority FROM authorities a, approved_authorities aa WHERE a.id_authority = aa.id_authority AND aa.id_record = $record_id ORDER BY aa.auth_order";
		$subresult = mysql_query($subquery);
		while($subrow = mysql_fetch_array($subresult,MYSQL_ASSOC))
			$res['authorities'][] = $subrow['auth_name'];
		$res['authorities'] = join("<br/>", $res['authorities']);
	}
    $res['editor_note'] = format_note($res['editor_note']);
	echo json_encode($res);
?>
