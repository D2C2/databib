
<table border="1" style ="width: 100%">
		<thead>
		<tr>	
			<th scope="col" colspan="2"><h3>Review Queue</h3></th>
		</tr>
		</thead>
		<tbody>

				<?php

				include_once('database_connection.php');

				$query_u = "SELECT name, username FROM users where user_role='editor' ORDER BY name";
				$result_u = mysql_query($query_u) or die(mysql_error());
				$user_count = array();
				$user_delay = array();
				$user_names = array();
				while($row = mysql_fetch_array($result_u)) {
					$user_count[$row['username']] = 0;
					$users_delay[$row['username']] = 0;
					$user_names[$row['username']] = $row['name'];
				}

				$total = 0;
				$query_e = "SELECT rep_editors, assignment_date FROM notapproved where assignedtoeditor='y' AND reviewed = 'n'";
				$result_e = mysql_query($query_e) or die(mysql_error());
				while($row_e = mysql_fetch_array($result_e)) {
					$total++;
					$editors = explode(',', $row_e['rep_editors']);
					$assign_date = strtotime($row_e['assignment_date']);
					$now_time = strtotime(date('Y-m-d H:i:s'));
					$days_diff = ($now_time - $assign_date)/(60*60*24);
					for($i = 0; $i < count($editors); $i++){
						if( array_key_exists($editors[$i], $user_count) ) {
							$user_count[$editors[$i]]++;
							if( $user_delay[$editors[$i]] < $days_diff) {
								$user_delay[$editors[$i]] = $days_diff;
							}
						}
					}
				}

				echo "<tr><th><font face=arial size=2 color=\"gray\">Total</font></th>";
				echo "<th><font face=arial size=2 color=\"gray\">$total</font></th></tr>";
				
				arsort($user_count);
				foreach ($user_count as $key => $val) {
					if($user_delay[$key] > 7) {
						$color = "red";
					} else if($user_delay[$key] > 5) {
						$color = "#FFBA00";
					} else {
						$color = "green";
					}
					if( $_SESSION['user_role'] == 'admin') {
						echo "<tr><th><a href=\"../viewassignedbyeditor.php?editor=$key\"><font face=arial size=2 color=\"$color\">" . $user_names[$key] . "</font></a></th>";
					} else {
						echo "<tr><th><font face=arial size=2 color=\"$color\">" . $user_names[$key] . "</font></th>";
					}
					echo "<th><font face=arial size=2 color=\"$color\">" . $val . "</font></th></tr>";
				}

				?>
	
	</tbody>
	<tfoot>
	<tr>
	<th colspan="2">
		<font face=arial size=2 color="black">
		<font face=arial size=2 color="red">Red</font> = more than 7 days old<br/>
		<font face=arial size=2 color="#FFBA00">Yellow</font> = more than 5 days old<br/>
		<font face=arial size=2 color="green">Green</font> = current<br/>
		</font>
	</th>
	</tr>
	</tfoot>
</table>