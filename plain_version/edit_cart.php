<?php
	session_start();
	$idletime=60;
	if (isset($_SESSION['page'])) {
		$_SESSION['lastpage'] = $_SESSION['page'];
	}
	$_SESSION['page'] = 'edit_cart.php';
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
	// collapse Cart table
	$con = mysql_connect('localhost','root','0418162');
	if (!$con) {
		die("Cannot establish a connection");
	}
	$db_selected = mysql_select_db("hw4",$con);
	$sql = 'create table Cart_temp as select Name, UserID, sum(Quantity) as Quantity, Price, SessionID from Cart group by Name, UserID, SessionID';
	mysql_query($sql,$con);
	$sql = 'drop table Cart';
	mysql_query($sql,$con);
	$sql = 'create table Cart as select * from Cart_temp';
	mysql_query($sql,$con);
	$sql = 'drop table Cart_temp';
	mysql_query($sql,$con);
	// get data
	if (isset($_SESSION['uid'])) {
		$sql = 'select * from Cart where UserID="'.$_SESSION['uid'].'"';
	}
	else if (isset($_SESSION['sid'])) {
		$sql = 'select * from Cart where SessionID="'.$_SESSION['sid'].'"';
	}
	$res = mysql_query($sql,$con);
	$i = 0;
	$N = 0;
	while ($row = mysql_fetch_assoc($res)) {
		$name[$i] = $row['Name'];
		if (!($_POST['Q_'.$row['Name']]>0)) {
			$error = 1;
			break;
		}
		else {
			$error = 0;
			$quantity[$i] = $_POST['Q_'.$row['Name']];
		}
		if ($_POST['D_'.$row['Name']]==$row['Name']) {
			$delete[$i]=1;
		}
		else $delete[$i]=0;
		if ($delete[$i]==1) {
			$sqls[$i] = 'delete from Cart where Name = "'.$name[$i].'"';
		}
		else {
			$sqls[$i] = 'update Cart set Quantity = '.$quantity[$i].' where Name = "'.$name[$i].'"';
		}
		$i++;
	}
	$N = $i;
	if ($error==0) {
		if (isset($_SESSION['uid'])) {
			for ($i=0;$i<$N;$i++) {
				$sqls[$i] = $sqls[$i].' and UserID = "'.$_SESSION['uid'].'"';
				mysql_query($sqls[$i],$con);
			}
		}
		else if (isset($_SESSION['sid'])) {
			for ($i=0;$i<$N;$i++) {
				$sqls[$i] = $sqls[$i].' and SessionID = "'.$_SESSION['sid'].'"';
				mysql_query($sqls[$i],$con);
			}
		}
	}
	
?>
<html>
<head>
</head>
<body>
<?php
	/*
	for ($i=0;$i<$N;$i++) {
		echo $name[$i].'<br/>';
		echo $quantity[$i].'<br/>';
		echo $delete[$i].'<br/>';
		echo $sqls[$i].'<br/>';
	}
	echo $N;
	*/
	if (isset($_SESSION['uid'])) {
		echo "<span style='color:green'><strong>UserID: ".$_SESSION['uid']."</strong></span>";
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
	/*
	else if (isset($_SESSION['sid'])) {
		echo "<span style='color:green'><strong>SessionID: ".$_SESSION['sid']."</strong></span>";
	}
	*/
	require 'edit_cart.html';
	//echo $error;
?>
	<script type="text/javascript">
	<?php 
	if ($error==0) {
	?>
		document.getElementById("Message").innerHTML = "<span style='color:blue'><strong>Succesful! You Can Either Choose More Forms Or Go Checkout</strong></span>";
	<?php
	}
	else if ($error==1) {
	?>
		document.getElementById("Message").innerHTML = "<span style='color:red'><strong>Failed! Please Enter A Quantity Greater Than 0</strong></span>";
	<?php
	}
	if (($N==0)) {
	?>
		document.getElementById("Message").innerHTML = "";
	<?php
	}
	?>
	</script>
</body>
</html>