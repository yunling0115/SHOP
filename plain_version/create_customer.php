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
	// get data
	$userid = $_POST['userid'];
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
	// Create new account if userid doesn't exist: Customer table
	$con = mysql_connect('localhost','root','0418162');
	if (!$con) {
		die("Cannot establish a connection");
	}
	$db_selected = mysql_select_db("hw4",$con);
	$sql = 'insert into Customers (UserID, Passwrd, Name, CIK, FYR, IRS, SIC, Street, City, State) 
		values ("'.$userid.'","'.$password.'","'.$name.'",'.$cik.',"'.$fyr.'",'.$irs.','.$sic_code.',"'.$street.'","'.$city.'","'.$state.'")';
	$sql = 'insert into Customers (UserID, Passwrd, Name, CIK, FYR, IRS, SIC, Street, City, State, Zip, Email, Phone, Street2, City2, State2, Zip2, Email2, Phone2) 
		values ("'.$userid.'",password("'.$password.'"),"'.$name.'",'.$cik.',"'.$fyr.'",'.$irs.','.$sic_code.',
		"'.$street.'","'.$city.'","'.$state.'","'.$zip.'","'.$email.'","'.$phone.'",
		"'.$street2.'","'.$city2.'","'.$state2.'","'.$zip2.'","'.$email2.'","'.$phone2.'")';
	$res = mysql_query($sql,$con);
?>
<html>
<head>
</head>
<body>
<?php
	// include the page
	require 'create_customer.html';
	if ($res) {
		echo "<p style='color:blue'><strong>Successful!</strong></p>";
		echo '<p><input type="button" value="'.'Go To Login >>'.'" onclick="'.'window.location.href = '."'login_customer.php'".'"></p>';
	}
?>
</body>
</html>
