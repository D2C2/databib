    <div id="header">
        <div id="new-header-content">
          <div>
			<a href="/index.php">
				<img id="imagebanner" alt="Header" src="/images/header2.jpg"/>
			</a>
          </div> 
        </div> 
    </div>
    <div id="navigation">
		<div id="navigation-content">
			<table style="width:950px">
			<tr>
			<td style="text-align:left;width:600px">
				<ul class="nav-ul">
					<li><a href="/index.php" title="Find Repositories">Find Repositories</a><span class="pipe">|</span></li>
					<li><a href="/submit.php" title="Submit">Submit</a><span class="pipe">|</span></li>
					<li><a href="/connect.php" title="Connect">Connect</a><span class="pipe">|</span></li>
					<li><a href="/about.php" title="About">About</a></li>
				</ul>
			</td>
			<td style="text-align:right;width:350px">
				<ul>
					<?php
						$sessionvar = $fgmembersite->GetLoginSessionVar();
						if(empty($_SESSION[$sessionvar])) {	 
							//echo("<li style=\"padding-left:338px;\"><a href='/login.php' title='Login'>Login/Register</a></li>");
							echo("<li style=\"\"><a href='/login.php' title='Login'>Login/Register</a></li>");
							
							//echo("<li style=\"padding-left:490px;\"><a href='login.php'>Login/Register</a></li>");
						} else  {
							echo("<li style=\"\"><a href='/dashboard.php'>Dashboard</a></li>");
							//echo("<li style=\"padding-left:218px;\"><a href='/dashboard.php'>Dashboard</a></li>");
							
							//echo("<li style=\"padding-left:370px;\"><a href='dashboard.php'>Dashboard</a></li>");
							echo("<li style=\"padding-left:8px;\"><a href='/accountsettings.php'>Account</a> </li>");
							echo("<li ><a href='/logout.php' title='Logout'>Logout</a></li>");
						}
					?>
				</ul>
			</td>
			</tr>
			</table>
        	<div style="clear:both"></div>
        </div>
    </div>
