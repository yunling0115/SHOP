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
	$con = mysql_connect('localhost','root','0418162');
	if (!$con) {
		die("Cannot establish a connection");
	}
	$db_selected = mysql_select_db("hw4",$con);
	if (isset($_SESSION['uid'])) {
		echo "<span style='color:green'><strong>UserID: ".$_SESSION['uid']."</strong></span>";
	}
	if (isset($_SESSION['uid'])) {
		$sql = 'select Name, UserID, SessionID, Price, sum(Quantity) as Quantity from Cart where UserID="'.$_SESSION['uid'].'" group by Name';
	}
	else if (isset($_SESSION['sid'])) {
		$sql = 'select Name, UserID, SessionID, Price, sum(Quantity) as Quantity from Cart where SessionID="'.$_SESSION['sid'].'" group by Name';
	}
	else {
		header ('location: add_cart.php');
	}
	$result = mysql_query($sql);
?>
<html>
<head>
<!-- css -->
	<link href="sec.css" rel="stylesheet" type="text/css" />
<!-- javascript -->
	<script>
	function Enable() {
		if (Validate()) {
			document.getElementById('submit_request').disabled=false;
		}
		else {
			document.getElementById('submit_request').disabled=true;
		}
	}
	// global variable
	function Validate() {
		var error = document.getElementById("Message");
		error.innerHTML = "";
		var e = document.getElementById("exmonth");
		var exmonth = e.options[e.selectedIndex].value;
		var e = document.getElementById("exyear");
		var exyear = e.options[e.selectedIndex].value;
		var cardno = document.getElementById("cardno").value;
		var cardname = document.getElementById("cardname").value;
		var cardnopatt = /^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/;
		var cardnamepatt = /^[A-Za-z]{3,30} [A-Za-z]{3,30}$/;
		if (cardno.length==0) {
			error.innerHTML = "<span style='color:red'><strong>Please Enter Your Card Number</strong></span>";
		}
		else if (cardnopatt.test(cardno)==false) {
			error.innerHTML = "<span style='color:red'><strong>Please Enter A Valid Card Number</strong></span>";
		}
		if (cardname.length==0) {
			error.innerHTML = "<span style='color:red'><strong>Please Enter Cardholder's Name</strong></span>";
		}
		else if (cardnamepatt.test(cardname)==false) {
			error.innerHTML = "<span style='color:red'><strong>Please Enter A Valid Cardholer's Name</strong></span>";
		}
		if (exmonth=="mm") {
			error.innerHTML = "<span style='color:red'><strong>Please Select Expiration Month</strong></span>";
		}
		if (exyear=="yyyy") {
			error.innerHTML = "<span style='color:red'><strong>Please Select Expiration Year</strong></span>";
		}
		if (error.innerHTML=="") {
			document.getElementById("submit_request").disabled = false;
			return true;
		}
		else {
			document.getElementById("submit_request").disabled = true;
			return false;
		}
	}
	</script>
</head>
<body>
	<h1>Easy Filing SEC Forms</h1>
	<h2>Checkout</h2>
	<form name="log_out" method="POST" action="logout_customer.php">
		<p><input type="submit" value="Log Out" class="log_out"></input></p>
	</form>
	<form method="POST" action="checkout.php">
	<!-- Cart information -->
	<fieldset>
	<legend><strong>In Your Cart</strong></legend>
	<table>
	<?php
		if ($row=mysql_fetch_assoc($result)) {
			echo '<tr>
					<td width="130"><strong>Name</strong</td>
					<td width="130"><strong>Quantity</strong></td>
					<td width="130"><strong>Price</strong></td>					
				</tr>';
			echo '<tr>';
			echo '<td>'.$row['Name'].'</td>';
			echo '<td>'.$row['Quantity'].'</td>';
			echo '<td>'.$row['Price'].'</td>';				
			echo '</tr>';
		}
		else {
			echo '<tr><td><p style="color:red"><strong>Nothing in Your Cart!</strong></p></td></tr>';
		}
		while ($row=mysql_fetch_assoc($result)) {
			echo '<tr>';
			echo '<td>'.$row['Name'].'</td>';
			echo '<td>'.$row['Quantity'].'</td>';
			echo '<td>'.$row['Price'].'</td>';	
			echo '</tr>';
		}
	?>	
	</table>
	</fieldset>
	<!-- Go back to edit cart -->
	<p><input id="checkout" type="button" value="<< Back To Edit Your Cart" onClick="window.location.href = 'edit_cart.php'";/></p>	
	<p></p>	
	<!-- Payment information (validation)-->
	<fieldset>
	<legend><strong>Payment Information</strong></legend>
	<table>
	<tr>
	<td>Credit or Debit Card Number: </td>
	<td><input type="text" id="cardno" name="cardno" onblur="Validate()"/></td>
	</tr>
	<tr>
	<td>Cardholder's Name: </td>
	<td><input type="text" id="cardname" name="cardname" onblur="Validate()"/></td>
	</tr>
	<tr>
	<td>Expiration Date: </td>
	<td><select id="exmonth" name="exmonth">
		<option value="mm" selected></option>
		<option value="01">01</option>
		<option value="02">02</option>
		<option value="03">03</option>
		<option value="04">04</option>
		<option value="05">05</option>
		<option value="06">06</option>
		<option value="07">07</option>
		<option value="08">08</option>
		<option value="09">09</option>
		<option value="10">10</option>
		<option value="11">11</option>
		<option value="12">12</option>
	</select>
	<select id="exyear" name="exyear">
		<option value="yyyy" selected></option>
		<script type='text/javascript'>
		for (var i=2014;i<=2030;i++) {
			document.write('<option value="'+i+'">'+i+'</option>');
		}
		</script>
	</select>
	</td>
	</tr>
	</table>
	</fieldset>
	<p></p>	
	<!-- Submit button -->
	<p>Submit Your Order? 
		<input type="radio" name="check" id="checked_Y" value="Y" onClick="Enable()"/>Yes
		<input type="radio" name="check" id="checked_N" value="N" onClick="document.getElementById('submit_request').disabled=true"/>No		
	</p>
	<p><input id="submit_request" type="submit" value="Submit Order" onsubmit="return Validate()" disabled="disabled"/></p>
	<p id="Message" name="Message"></p>
	</form>
	<p><input id="view_order" type="button" value="View Order History >>" onClick="window.location.href = 'view_order_history.php'";/></p>
</body>
</html>