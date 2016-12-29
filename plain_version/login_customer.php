<?php
	session_start();
	// set sid or uid
	$con = mysql_connect('localhost','root','0418162');
	if (!$con) {
		die("Cannot establish a connection");
	}
	$db_selected = mysql_select_db("hw4",$con);
	$sql = 'select max(SessionID) as sid from Cart';
	$result = mysql_query($sql);
	if (!isset($_SESSION['uid']) && !isset($_SESSION['sid'])) {
		if ($row = mysql_fetch_assoc($result)) {
			$_SESSION['sid'] = $row['sid']+1;
		}
		else {
			$_SESSION['sid'] = 0;
		}
	}
	// get userid and password
	if(array_key_exists('userid',$_POST) && array_key_exists('userid',$_POST)) {
		// Get values
		$userid = $_POST['userid'];
		$passwrd = $_POST['password'];
		// Initialization
		$errmsg = "";
		$displayloginPage = True;
		// case 1
		if (strlen($userid)==0) {
			$errmsg = "Invalid login: Please Enter UserID"; 
		}
		// case 2
		if (strlen($passwrd)==0) {
			$errmsg = "Invalid login: Please Enter Password";
		}
		// case 3
		if (strlen($userid)==0 && strlen($passwrd)==0) {
			$errmsg = "";
		}
		// case 4
		if (strlen($userid)>0 && strlen($passwrd)>0) {	
			// (1) Connect to a mysql server
			$con = mysql_connect('localhost','root','0418162');		
			if (!$con) {
				die("Cannot establish a connection");
			}
			// (2) Select a database		
			$db_selected = mysql_select_db("hw4",$con);
			// (3) Submit sql statement and get return pointer
			$sql = 'select * from Customers where UserID="'.$userid.'" and Passwrd=password("'.$passwrd.'")';
			$result = mysql_query($sql,$con);
			// (4) Get return values
			if(!($row=mysql_fetch_assoc($result))) { // mysql_fetch_assoc turns it into an associate array: row
				// Bad login
				$errmsg = "Invalid Login: No User Exists";
			}
			else {
				// Good login - one case
				$errmsg = "";
				$displayloginPage = False;
				// Start a session (60 seconds)
				session_start();
				$idletime=60;
				$_SESSION['uid']=$userid;
				// Set a time (last active time) onStart
				if (!isset($_SESSION['timestamp'])) {
					$_SESSION['timestamp']=time();
				}
				// Destroy if idletime (time()-last_active_time>$idletime) onRefresh
				if (time()-$_SESSION['timestamp']>$idletime) {
					unset($_SESSION['uid']);
					session_destroy();
					session_unset();
				}
				// Update last_active_time=time() onRefresh if time()-last active time<$idletime -->
				else {						
					// Display the user's page when time is not out
					if ($_SESSION['page']=='edit_cart.php') {
						header ('Location: checkout_page.php');
					}
					else {
						header ('Location: add_cart.php');
					}
					echo '<html>';
					echo '<head>
							<!-- css -->
								<link href="sec.css" rel="stylesheet" type="text/css" />';
					echo '</head>
							<body>';	
						echo $_SESSION['lastpage'].'<br/>';
						echo $_SESSION['page'].'<br/>';
				}
				// Update Cart: replace uid when sid = sid 
				$sql = 'update Cart set UserID="'.$_SESSION['uid'].'" where SessionID='.$_SESSION['sid'];
				mysql_query($sql);
				// <-- Below:
				$_SESSION['timestamp']=time();
			}
		}
		// Display login html 
		if ($displayloginPage) {
			require 'login_customer.html'; 
			echo "<p style='color:red' align='center'>$errmsg</p>";
		}
	}
	else {
		require 'login_customer.html'; 
	}
?>
