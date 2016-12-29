<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Checkout Done</title>
	<link href="<?php echo base_url();?>css/sec.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url();?>jquery/jquery-1.10.2.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function OnReady() {
		$("#step1").hide();
		$("#step1").fadeIn(300);
	})
	</script>
</head>
<body>
	<h1>Easy Filing SEC Forms</h1>	
	<h2>Customer's Page</h2>
	<strong style="color:green">USER: <?php if(isset($username)) {echo $username;} else {echo 'Guest<p></p>';} ?></strong>
	<?php if(isset($username)) { ?>
	<p><input type="button" class="log_out" value="Logout" onClick="window.location.href = 'product_select/logout'"/></p>
	<?php } ?>
	<!-- output OrderID -->
	<div id="step1">
	<p style="color:blue"><strong>Successful! Your Order ID is: <?php echo $orderid;?></strong></p>
	<p><input id="view_order" type="button" value="View Order History >>" onClick="window.location.href = '<?php echo base_url();?>index/orderreport'";/></p>
	</div>
</body>
</html>