<?php
	session_start();
	$idletime=60;
	if (isset($_SESSION['page'])) {
		$_SESSION['lastpage'] = $_SESSION['page'];
	}
	$_SESSION['page'] = 'add_cart.php';
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
	$sql = "select Name from Product";
	$result = mysql_query($sql,$con);
	$i=0; $j=0; $text = "";
	$date = date("Y-m-d");
	while ($row=mysql_fetch_assoc($result)) {
		if (isset($_POST[$i])) {
			if (isset($_SESSION['uid'])) {
				$sql = 'insert into Cart (UserID, Name, Quantity) values ("'.$_SESSION['uid'].'","'.$_POST[$i].'",1)';
				mysql_query($sql,$con);	
			}
			if (isset($_SESSION['sid'])) {
				$sql = 'insert into Cart (SessionID, Name, Quantity) values ("'.$_SESSION['sid'].'","'.$_POST[$i].'",1)';
				mysql_query($sql,$con);
			}
			$sql = 'select distinct SalesPrice from Sales where Name = "'.$_POST[$i].'"';
			$res = mysql_query($sql,$con);
			if($row2=mysql_fetch_assoc($res)) {
				$sql = 'update Cart set Price = '.$row2['SalesPrice'].' where Name = "'.$_POST[$i].'"';
			}
			else $sql = 'update Cart set Price = (select Price from Product where Name = "'.$_POST[$i].'") where Name = "'.$_POST[$i].'"';
			mysql_query($sql,$con);
			$j++;
		}
		$i++;
	}
	$N_chosen = $j;
?>
<html>
<head>

</head>
<body>
<?php
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
	// include the page
	require 'add_cart.html';
?>
	<script type="text/javascript">
	<?php 
	if ($N_chosen>0) {
	?>
		document.getElementById("edit_cart").disabled = false;
		document.getElementById("Message").innerHTML = "<span style='color:blue'><strong>Succesful! You Can Either Choose More Forms Or Go To Edit Your Cart</strong></span>";
	<?php
	}
	else {
	?>
		document.getElementById("edit_cart").disabled = false;
		//document.getElementById("Message").innerHTML = "<span style='color:red'><strong>No Form In Cart! Please Select Form</strong></span>";
	<?php
	}
	?>
	</script>
</body>
</html>