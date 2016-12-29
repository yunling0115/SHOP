<?php
	session_start();
	$idletime=600;
	if (!isset($_SESSION['a_uid'])) {
		header ('location: login.php');
	}
	else {
		// refresh the time
		if (!isset($_SESSION['timestamp'])) {
			$_SESSION['timestamp']=time();
		}
		// destroy if idletime (time()-last_active_time>$idletime) onRefresh
		if (time()-$_SESSION['timestamp']>$idletime) {
			unset($_SESSION['a_uid']);
			session_destroy();
			session_unset();
			header("Location: login.php");
		}
	}
	echo '<strong style="color:green">MANAGER: '.$_SESSION['a_uid'].'</strong>';
?>
<html>
<title>Manager</title>
<head>
<!-- css -->
	<link href="sec.css" rel="stylesheet" type="text/css" />
<!-- javascript -->
	<script type="text/javascript">
	function ShowOrders(button) {
		var name = button.name;
		var table = document.getElementById('order_summary');
		var show = document.getElementById(name);
		// show detailed info
		if (button.value=="Details >") {
			button.value="< Hide Details";
			show.hidden=false;
		}
		// hide info
		else {
			button.value="Details >";
			show.hidden=true;
		}
	}
	</script>
<!-- AJAX -->
	<script>
	// AJAX for timeout - a seperate timeout variable is returned to browser for javascript to catch 
	function sendAJAX_timeout() {
		if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari			
			xmlhttp_timeout=new XMLHttpRequest();			
			}		
		else
			{// code for IE6, IE5
			xmlhttp_timeout=new ActiveXObject("Microsoft.XMLHTTP");
			}
	}
	function ReplyHandler_timeout() {
		if (xmlhttp_timeout.readyState==4 && xmlhttp_timeout.status==200) {
			var text=xmlhttp_timeout.responseText;
			document.getElementById("timeout").innerHTML = text;
			if (text=='1') {
				window.location = "login.php"
			}
		}			
	}
	function Timeout() {
		url = 'manager_timeout.php?timeout=timeout';
		sendAJAX_timeout();
		xmlhttp_timeout.onreadystatechange=ReplyHandler_timeout;
		xmlhttp_timeout.open("GET",url,true);
		xmlhttp_timeout.send();
	}
	// AJAX for report
	function sendAJAX() {
		if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari			
			xmlhttp=new XMLHttpRequest();			
			}		
		else
			{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
	}
	function ReplyHandler() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var text=xmlhttp.responseText;
			document.getElementById("report").innerHTML = text;
		}			
	}	
	function Get_Report() {
		// if time out redirect to login.php
		Timeout();
		var timeout=document.getElementById("timeout").innerHTML;
		// if not
		var name=order_report.name.value;
		var type=order_report.type.value;
		var start=order_report.start.value;
		var end=order_report.end.value;	
		var sales=order_report.sales.value;	
		url = 'manager_report.php?name='+name+'&type='+type+'&start='+start+'&end='+end+'&sales='+sales;
		sendAJAX();	
		xmlhttp.onreadystatechange=ReplyHandler;
		xmlhttp.open("GET",url,true);
		xmlhttp.send();
	}	
	</script>
</head>
<body>
<!-- html part: manager information -->
	<h1>Easy Filing SEC Forms</h1>	
	<h2>Manager's Page</h2>
	<form name="log_out" method="POST" action="logout.php">
		<p><input type="submit" value="Log Out" class="log_out"></input></p>
	</form>
<!-- view comprehensive information -->
	<!-- Order's information
	search by: product name, product type, start date, end date, sales items -->
	<form name="order_report" id="order_report">
		<fieldset>
		<legend><strong>Order Search</strong></legend>
		<p>By Form Name:
		<select name="name">
			<option value="name" selected="True"> ---- Form Name ---- </option>
			<?php
			$sql = "select Name from Product";
			$result = mysql_query($sql,$con);
			while ($row=mysql_fetch_assoc($result)) {
				echo '<option value='.$row['Name'].'>'.$row['Name'].'</option>';
			}
			?>
		</select>
		</p>
		<p>By Form Type:
		<select name="type" style="width:140px">
			<option value="type" selected="True"> ---- Form Type ---- </option>
			<?php
			$sql = "select distinct Type as Type from Product";
			$result = mysql_query($sql,$con);
			while ($row=mysql_fetch_assoc($result)) {
				echo '<option value='.$row['Type'].'>'.$row['Type'].'</option>';
			}
			?>
		</select>
		</p>
		<p>By Order Time:
		<select name="start">
			<option value="start" selected="True"> ---- Start Date ---- </option>
			<?php
			for ($i=1993;$i<=2015;$i++)
				{
				echo '<option value="'.$i.'-01-01">'.$i.'-01-01</option>';
			}
			?>			
		</select>
		<select name="end">
			<option value="end" selected="True"> ---- End date ---- </option>
			<?php
			for ($i=1993;$i<=2015;$i++)
				{
				echo '<option value="'.$i.'-12-31">'.$i.'-12-31</option>';
			}
			?>	
		</select>
		</p>
		<p>By Sales Form:
		<select name="sales">
			<option value="sales" selected="True"> ---- Form Name ---- </option>
			<?php
			$sql = "select Name from Sales";
			$result = mysql_query($sql,$con);
			while ($row=mysql_fetch_assoc($result)) {
				echo '<option value='.$row['Name'].'>'.$row['Name'].'</option>';
			}
			?>
		</select>
		</p>
		<input type="button" id="view" value="Report" onclick="Get_Report()"></input>
		</fieldset>
	</form>
	<!-- Response from AJAX -->
	<div id="report"></div>
	<!-- Time out -->
	<p id = "timeout" hidden>true: </p>
</body>
</html>