<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Checkout</title>
	<link href="<?php echo base_url();?>css/sec.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url();?>jquery/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>jquery/checkout.js"></script>
</head>
<body>
	<h1>Easy Filing SEC Forms</h1>	
	<h2>Customer's Page</h2>
	<strong style="color:green">USER: <?php if(isset($username)) {echo $username;} else {echo 'Guest<p></p>';} ?></strong>
	<?php if(isset($username)) { ?>
	<p><input type="button" class="log_out" value="Logout" onClick="window.location.href = 'product_select/logout'"/></p>
	<?php } ?>
	<?php echo form_open('checkout_done');  ?>
	<!-- output cart -->
	<div id="step1">
	<?php if(!$this->cart->contents()) echo '<p style="color:red"><strong>You have nothing in your cart</strong></p>'; else {?>
	<p style="color:red" id="Message" name="Message"></p>
	<fieldset>
	<legend><strong>In Your Cart</strong></legend>
	<?php $i=0;
		echo '<table><tr><td width="130"><strong>Name</strong></td>
			<td width="130"><strong>Quantity</strong></td>
			<td width="130"><strong>Price</strong></td>
			<td width="130"><strong>Subtotal</strong></td></tr>';
		foreach ($this->cart->contents() as $items) {
			echo '<tr>';
			echo '<td width="130">'.$items['name'].'</td>'; 
			echo '<td width="130">'.$items['qty'].'</td>';
			echo '<td width="130">'.$this->cart->format_number($items['price']).'</td>';
			echo '<td width="130">'.$this->cart->format_number($items['subtotal']).'</td>';
			echo '</tr>'; $i++;
		}
		echo '</table>';
		echo '<p><strong>Total</strong>&nbsp;&nbsp;&nbsp;&nbsp;';
		echo $this->cart->format_number($this->cart->total()).'</p>'; ?>
	</fieldset><p></p>	
	<!-- credit card -->
	<fieldset><legend><strong>Payment Information</strong></legend><table>
	<tr><td>Credit or Debit Card Number: </td>
	<td><input type="text" id="cardno" name="cardno" onblur="Validate()"/></td></tr>
	<tr><td>Cardholder's Name: </td>
	<td><input type="text" id="cardname" name="cardname" onblur="Validate()"/></td></tr>
	<tr><td>Expiration Date: </td>
	<td><select id="exmonth" name="exmonth">
		<option value="mm" selected></option>
		<script type='text/javascript'>
		var month = new Array('01','02','03','04','05','06','07','08','09','10','11','12');
		for (var i=0;i<month.length;i++) {
			document.write('<option value="'+month[i]+'">'+month[i]+'</option>');
		}
	</script></select>
	<select id="exyear" name="exyear">
		<option value="yyyy" selected></option>
		<script type='text/javascript'>
		for (var i=2014;i<=2030;i++) {
			document.write('<option value="'+i+'">'+i+'</option>');
		}
		</script></select></td>
	</tr></table></fieldset><p></p>	
	<!-- submit button -->
	<p><strong>Submit Your Order?</strong>
		<input type="radio" name="check" id="checked_Y" value="Y"/>Yes
		<input type="radio" name="check" id="checked_N" value="N"/>No &nbsp;&nbsp;&nbsp;&nbsp;
		<input id="submit_request" type="submit" value="Submit Order >>" onsubmit="return Validate()" disabled="disabled"/></p>
	<?php } ?>
	
	</div>
	<?php echo form_close();  ?>
</body>
</html>