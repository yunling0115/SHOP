<?php
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
			$db_selected = mysql_select_db("hw3",$con);
			// (3) Submit sql statement and get return pointer
			$sql = 'select UserType from Employees where UserID="'.$userid.'" and Passwrd=password("'.$passwrd.'")';
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
				$idletime=600;
				$_SESSION['a_uid']=$userid;
				// Set a time (last active time) onStart
				if (!isset($_SESSION['timestamp'])) {
					$_SESSION['timestamp']=time();
				}
				// Destroy if idletime (time()-last_active_time>$idletime) onRefresh
				if (time()-$_SESSION['timestamp']>$idletime) {
					unset($_SESSION['a_uid']);
					session_destroy();
					session_unset();
					//header("Location: login.php");
				}
				// Update last_active_time=time() onRefresh if time()-last active time<$idletime -->
				else {
				echo '<html>
						<head>
						<!-- css -->
							<link href="sec.css" rel="stylesheet" type="text/css" />
						</head>
						<body>';	
					// Display the appropriate user's page when time is not out
					switch ($row['UserType']) 
					{
						/*
						case 0:
							require 'administrator.php';
							//header('location: administrator.php');
							break;
						case 1:
							require 'sales_manager.php';
							//header('location: sales_manager.php');
							break;
						*/
						case 0:
							$displayloginPage = True;
							break;
						case 1:
							$displayloginPage = True;
							break;
						case 2:
							require 'manager.php';
							//header('location: manager.php');
							break;
						default:
							break;
					}
				}
				// <-- Below:
				$_SESSION['timestamp']=time();
			}
		}
		// Display login html for bad login - three cases (prelogin.html + postlogin.html) 
		if ($displayloginPage) {
		echo '<html>
				<head>
				<!-- css -->
					<link href="sec.css" rel="stylesheet" type="text/css" />
				</head>
				<body>';
			require 'prelogin.html'; 
			echo "<p style='color:red' align='center'>$errmsg</p>";
			require 'postlogin.html'; 
		}
	}
	else {
		require 'prelogin.html';
		require 'postlogin.html';
	}
	?>

<!-- login.php -->
</body>
</html>