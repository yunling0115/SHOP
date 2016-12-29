<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Cart</title>
	<link href="<?php echo base_url();?>css/sec.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url();?>jquery/jquery-1.10.2.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function OnReady() {
		$("#step1").hide();
		$("#step1").fadeIn(300);
		$("#checked_Y").click(function() {
			$("#submit_request").prop("disabled", false);
		});
		$("#checked_N").click(function() {
			$("#submit_request").prop("disabled", true);
		});
		$(".delete").click(function() {
			if ($(this).prop("checked")==true) {
				$("#qty"+$(this).prop("id")).val(0);
			}
		});
		$(".qty").blur(ValidateAll);
		$("form").submit(function(e) {
			if (ValidateAll()==false) {
				e.preventDefault();
			}
		});
	});
	
	function ValidateAll() {	
		$("#message").html("");
		var qty_patt = /^[0-9]{2}$/;
		$(".qty").each(function() {			
			var qty = $(this).val();
			if (qty.length==0) {$("#message").html("Please Enter A Quantity");}
			else if (qty_patt.test(qty)==false) {$("#message").html("Please Enter A Valid Quantity Less Than 100");}			
			else {$("#message").html("");}
		});
		if ($("#message").html()=="") {return true;}
		else {return false;}
	}
	</script>
</head>
<body>
	<h1>Easy Filing SEC Forms</h1>	
	<h2>Customer's Page</h2>
	<strong style="color:green">USER: <?php if(isset($username)) {echo $username;} else {echo 'Guest<p></p>';} ?></strong>
	<?php if(isset($username)) { ?>
	<p><input type="button" class="log_out" value="Logout" onClick="window.location.href = 'product_select/logout'"/></p>
	<?php } ?>
	<?php echo form_open('edit_cart_done');  ?>
	<!-- output cart -->
	<div id="step1">
	<?php if(!$this->cart->contents()) echo '<p style="color:red"><strong>You have nothing in your cart</strong></p>'; else {?>
	<p id="message" style="color:red" name="message"></p>
	<fieldset>
	<legend><strong>Make Changes To Your Cart</strong></legend>
	<?php $i=0;
		echo '<table><tr><td width="130"><strong>Name</strong></td>
			<td width="130"><strong>Quantity</strong></td>
			<td width="130"><strong>Price</strong></td>
			<td width="130"><strong>Subtotal</strong></td>
			<td width="50"><strong>Delete</strong></td></tr>';
		foreach ($this->cart->contents() as $items) {
			echo '<tr>';
			echo '<td width="130">'.$items['name'].'</td>'; 
			echo '<td width="130"><input style="width:50px" type="text" class="qty" id="qty'.$i.'" name="'.$items['rowid'].'" value="'.$items['qty'].'"/></td>';
			echo '<td width="130">'.$this->cart->format_number($items['price']).'</td>';
			echo '<td width="130">'.$this->cart->format_number($items['subtotal']).'</td>';
			echo '<td width="50"><input type="checkbox" value="'.$items['name'].'" id="'.$i.'" class="delete"/></td>'; // no name, no post
			echo '</tr>'; $i++;
		}
		echo '</table>'; ?>
	</fieldset><p></p>	
	<!-- button -->
	<p>Save Changes? 
		<input type="radio" name="check" id="checked_Y" value="Y"/>Yes
		<input type="radio" name="check" id="checked_N" value="N"/>No</p>	
	<p><input id="submit_request" type="submit" value="Save" disabled="disabled"/></p>
	<p id="Message" name="Message"></p>
	<?php echo form_close();  ?>
	<!-- checkout -->
	<?php if(isset($username)) { ?>
	<p><input id="edit_cart" type="button" value="Continue to Checkout >>" onClick="window.location.href = '<?php echo base_url();?>index/checkout'";/></p>
	<?php } else { ?>
	<p><input id="edit_cart" type="button" value="Login/Register and Checkout >>" onClick="window.location.href = '<?php echo base_url();?>index/login_customer'";/></p>
	<?php } ?>
	<?php } ?>
	</div>
</body>
</html>