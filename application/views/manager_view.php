<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Manager's Page</title>
	<link href="<?php echo base_url();?>css/sec.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url();?>jquery/jquery-1.10.2.min.js"></script>
	<script type="text/javascript">	
	$(document).ready(function() {
		$('.button').click(ShowOrders);
		$('#view').click(function() {
			$("#step2").hide();
			$("#step2").fadeIn(300);
		});
	});
	function ShowOrders() {
		var name = $(this).prop('name');
		var show = $("#"+name);		
		if ($(this).val()=="Details >") {$(this).val("< Hide Details"); show.fadeIn(300);}
		else {$(this).val("Details >"); show.fadeOut(300);}		
	}
	</script>
</head>
<body>
	<h1>Easy Filing SEC Forms</h1>	
	<h2>Manager's Page</h2>
	<strong style="color:green">MANAGER: <?php echo $username; ?></strong>
	<!-- use the logout function in home controller -->
	<p><input type="button" class="log_out" value="Logout" onClick="window.location.href = 'manager/logout'"/></p>
	<div id="step1">
	<?php echo form_open('getreport'); ?>
	<fieldset>
		<legend><strong>Order Search</strong></legend>
		<p>By Form Name:
		<select name="name">
			<option value="name" selected="True"> ---- Form Name ---- </option>
			<?php foreach($name as $n) {echo '<option value="'.$n->Name.'">'.$n->Name.'</option>';} ?>
		</select></p><p>By Form Type:
		<select name="type" style="width:140px">
			<option value="type" selected="True"> ---- Form Type ---- </option>
			<?php foreach($type as $n) {echo '<option value="'.$n->Type.'">'.$n->Type.'</option>';} ?>
		</select></p><p>By Order Time:
		<select name="start">
			<option value="start" selected="True"> ---- Start Date ---- </option>
			<?php for ($i=1993;$i<=2015;$i++) {echo '<option value="'.$i.'-01-01">'.$i.'-01-01</option>';} ?>			
		</select><select name="end">
			<option value="end" selected="True"> ---- End date ---- </option>
			<?php for ($i=1993;$i<=2015;$i++) {echo '<option value="'.$i.'-12-31">'.$i.'-12-31</option>';} ?>	
		</select></p><p>By Sales Form:
		<select name="sales">
			<option value="sales" selected="True"> ---- Form Name ---- </option>
			<?php foreach($salesname as $n) {echo '<option value="'.$n->Name.'">'.$n->Name.'</option>';} ?>
		</select></p>	
	</fieldset>
	<p><input type="submit" id="view" value="Get Report"></input></p>
	<?php echo form_close(); ?>
	</div>
</body>
</html>
