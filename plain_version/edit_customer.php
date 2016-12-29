<?php
	session_start();
	$idletime=60;
	if (!isset($_SESSION['uid'])) {
		header ('Location: login_customer.php');
	}
	else {
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
	}
	if (isset($_SESSION['page'])) {
		$_SESSION['lastpage'] = $_SESSION['page'];
	}
	$_SESSION['page'] = 'edit_customer.php';
	$con = mysql_connect('localhost','root','0418162');
	if (!$con) {
		die("Cannot establish a connection");
	}
	$db_selected = mysql_select_db("hw4",$con);
	if (isset($_SESSION['uid'])) {
		$sql = 'select * from Customers where UserID="'.$_SESSION['uid'].'"';
	}
	// get data
	$userid = $_SESSION['uid'];
	$password = $_POST['password'];
	$name = $_POST['name'];
	$cik = $_POST['cik'];
	$fyr = $_POST['fyr'];
	$irs = $_POST['irs'];
	$sic_code = $_POST['sic_enter'];
	$street = $_POST['street'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$street2 = $_POST['street2'];
	$city2 = $_POST['city2'];
	$state2 = $_POST['state2'];
	$zip2 = $_POST['zip2'];
	$email2 = $_POST['email2'];
	$phone2 = $_POST['phone2'];
	// Update the account
	if (strlen($password)>30) {
		$sql = 'update Customers set Passwrd="'.$password.'", Name="'.$name.'", CIK='.$cik.', FYR="'.$fyr.'", IRS='.$irs.', SIC="'.$sic_code.'",
			Street="'.$street.'", City="'.$city.'", State="'.$state.'", Zip="'.$zip.'", Email="'.$email.'", Phone="'.$phone.'",
			Street2="'.$street2.'", City2="'.$city2.'", State2="'.$state2.'", Zip2="'.$zip2.'", Email2="'.$email2.'", Phone2="'.$phone2.'" 
			where UserID="'.$userid.'"';
	}
	else {
		$sql = 'update Customers set Passwrd=password("'.$password.'"), Name="'.$name.'", CIK='.$cik.', FYR="'.$fyr.'", IRS='.$irs.', SIC="'.$sic_code.'",
				Street="'.$street.'", City="'.$city.'", State="'.$state.'", Zip="'.$zip.'", Email="'.$email.'", Phone="'.$phone.'",
				Street2="'.$street2.'", City2="'.$city2.'", State2="'.$state2.'", Zip2="'.$zip2.'", Email2="'.$email2.'", Phone2="'.$phone2.'" 
				where UserID="'.$userid.'"';
	}
	$res = mysql_query($sql,$con);
?>
<html>
<head>
</head>
<body>
<?php
	if (isset($_SESSION['uid'])) {
		echo "<span style='color:green'><strong>UserID: ".$_SESSION['uid']."</strong></span>";
		// include the page
		require 'edit_customer.html';
		if ($res) echo "<p style='color:blue'><strong>Successful!</strong></p>";
		echo '</body>
			</html>';
	}
?>
</body>
</html>
