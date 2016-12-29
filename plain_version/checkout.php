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
	$error = 1;
	// 0. get card number and card name
	$exmonth = $_POST['exmonth'];
	$exyear = $_POST['exyear'];
	$cardno = $_POST['cardno'];
	$cardname = $_POST['cardname'];
	$cardnopatt = '/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/';	
	$cardnamepatt = '/^[A-Za-z]{3,30} [A-Za-z]{3,30}$/';
	if (strlen($cardnamepatt)!=0 && strlen($cardnopatt)!=0) {
		if (preg_match($cardnamepatt,$cardname) && preg_match($cardnopatt,$cardno)) {
			if ($exmonth!="mm" && $exyear!="yyyy") {
			$error=0;
			}
		}
	}
	// 1. Orders
	// date
	$date = date("Y-m-d");
	// order id
	$sql = 'select max(OrderID) as max from Orders';
	$result = mysql_query($sql);
	if ($row = mysql_fetch_assoc($result)) $orderid = $row['max']+1;
	else $orderid = 0;
	// total price
	if (isset($_SESSION['uid'])) {
		$sql = 'select distinct sum(Price*Quantity) as TotalPrice from Cart where UserID="'.$_SESSION['uid'].'" group by UserID';
	}
	else {
		header ('location: login_customer.php');
	}
	$result = mysql_query($sql);
	if ($row = mysql_fetch_assoc($result)) $totalprice = $row['TotalPrice'];
	// customer info
	if (isset($_SESSION['uid'])) {
		$sql = 'select * from Customers where UserID="'.$_SESSION['uid'].'"';
	}
	$result = mysql_query($sql);
	if ($row = mysql_fetch_assoc($result)) {
		$sql = 'insert into Orders (OrderID, UserID, Date, TotalPrice, Street, City, State, Zip, Street2, City2, State2, Zip2) values 
				('.$orderid.', "'.$row['UserID'].'", "'.$date.'", '.$totalprice.', 
				"'.$row['Street'].'", "'.$row['City'].'", "'.$row['State'].'", "'.$row['Zip'].'", 
				"'.$row['Street2'].'", "'.$row['City2'].'", "'.$row['State2'].'", "'.$row['Zip2'].'")';
		mysql_query($sql);
	}
	// 2. Items
	// get cart info
	if (isset($_SESSION['uid'])) {
		$sql = 'select Name, UserID, SessionID, Price, sum(Quantity) as Quantity from Cart where UserID="'.$_SESSION['uid'].'" group by UserID, Name order by UserID, Name';
	}
	$result = mysql_query($sql);
	$i = 0;
	if ($error==0) {
		$error=1;
		while ($row=mysql_fetch_assoc($result)) {
			$sql = 'insert into Items (OrderID, Name, Quantity, Price) values ('.$orderid.', "'.$row['Name'].'", '.$row['Quantity'].', '.$row['Price'].')';
			mysql_query($sql);
			$i++;
		}
		$N = $i;
		if ($N>0) $error=0;
	}
	// clear cart
	// display successful info
	
?>
<html>
<head>
</head>
<body>
<?php
	// include the page
	require 'checkout_page.php';
	// display successful info
	if ($error==0) {
	?>
	<script type='text/javascript'>
		document.getElementById("Message").innerHTML = "<span style='color:blue'><strong>Succesful! Your OrderID is <?php echo $orderid ?> </strong></span>";
	</script>
	<?php
	}
?>
</body>
</html>