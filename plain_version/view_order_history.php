<?php
	session_start();
	$idletime=60;
	if (isset($_SESSION['page'])) {
		$_SESSION['lastpage'] = $_SESSION['page'];
	}
	$_SESSION['page'] = 'checkout.php';
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
?>
<?php
	if (isset($_SESSION['uid'])) {
		// refresh the time
		if (!isset($_SESSION['timestamp'])) {
			$_SESSION['timestamp']=time();
		}
		// destroy if idletime (time()-last_active_time>$idletime) onRefresh
		if (time()-$_SESSION['timestamp']>$idletime) {
			unset($_SESSION['uid']);
			session_destroy();
			session_unset();
			header("Location: login_customer.php");
		}
		echo "<span style='color:green'><strong>UserID: ".$_SESSION['uid']."</strong></span>";
		echo '<html>
		<head>
		</head>
		<body>';
	}
	else {
		header ('Location: login_customer.php');
	}
	// include the page
	require 'view_order_history.html';
	echo '</body>
		</html>';
?>
