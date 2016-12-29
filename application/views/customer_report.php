<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>History Orders</title>
	<link href="<?php echo base_url();?>css/sec.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url();?>jquery/jquery-1.10.2.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$('.button').click(ShowItems);
		$("#step1").hide();
		$("#step1").fadeIn(300);
	});
	function ShowItems() {
		var name = $(this).prop('name');
		var show = $("#"+name);		
		if ($(this).val()=="Details >") {$(this).val("< Hide Details"); show.fadeIn(300);}
		else {$(this).val("Details >"); show.fadeOut(300);}		
	}
	</script>
</head>
<body>
	<h1>Easy Filing SEC Forms</h1>	
	<h2>Customer's Page</h2>
	<strong style="color:green">USER: <?php echo $username; ?></strong>
	<!-- no need to post data -->
	<p><input type="button" class="log_out" value="Logout" onClick="window.location.href = 'orderreport/logout'"/></p>
	<div id="step1">
	<?php
	if (!$summary) {echo '<p style="color:red"><strong>You have no orders</strong></p>';}
	else {
		echo '<fieldset><legend><strong>Order Summary</strong></legend>';
		echo '<table id="order_summary">';
		echo '<tr><td width="80"><strong>OrderID</strong</td>
				<td width="120"><strong>Date</strong</td>
				<td width="350"><strong>Shipping Address</strong></td>	
				<td width="400"><strong>View Items</strong></td></tr>';
		foreach ($summary as $s) {
			$ship = $s->Street.', '.$s->City.', '.$s->State.', '.$s->Zip;
			echo '<tr><td valign="top">'.$s->OrderID.'</td>';
			echo '<td valign="top">'.$s->Date.'</td>';
			echo '<td valign="top">'.$ship.'</td>';
			echo '<td valign="top"><input class="button" type="button" value="Details >" name="'.$s->OrderID.'"/></td></tr>';
			// details
			echo '<tr id="'.$s->OrderID.'" hidden><td></td><td></td><td></td><td><fieldset><table><tr>'; 
			echo '<td width="130"><strong>Form Name</strong></td>
				<td width="130"><strong>Quantity</strong></td>
				<td width="140"><strong>Price</strong></td></tr>';
			foreach ($details as $d) {
				if ($d->OrderID==$s->OrderID) {echo '<tr><td>'.$d->Name.'</td><td>'.$d->Quantity.'</td><td>'.$d->Price.'</td></tr>';}
			}
			echo '</table><p><strong>Total Price</strong>&nbsp;&nbsp;&nbsp;&nbsp;'.$s->TotalPrice.'</p>';
			echo '</fieldset></tr>';
		}
		echo '</table></fieldset>';
	}
	?>
	</div>
</body>
</html>