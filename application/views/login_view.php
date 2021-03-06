<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- View: html page -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Manager Login</title>
	<link href="<?php echo base_url();?>css/sec.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url();?>jquery/jquery-1.10.2.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function OnReady() {
		$("#step1").hide();
		$("#step1").fadeIn(300);
	});
	</script>
</head>
<body>
	<h1>Easy Filing SEC Forms</h1>
	<div id="step1">
	<?php // login form
		echo form_open('verifylogin'); 
	?>
	<!-- login table -->
	<div id="login_form">
	<fieldset>
	<legend><strong>Administrative Login</strong></legend>
	<table align="center">
	<tr>
	<td width="50%" style="color:blue"><strong><em>Username:</em></strong></td> 
	<td><input type="text" name="username" id="username" width="100px"/></td>
	</tr>
	<tr>
	<td width="50%" style="color:blue"><strong><em>Password:</em></strong></td>
	<td><input type="password" name="password" id="password" width="100px"/></td>
	</tr>
	</table>
	<p align="center"><input type="submit" value="Login" class="log_in"/></p>	
	</fieldset>	
	</div>
	<?php 
		echo form_close();
	?>
	<div align="center"><span style="color:red"><?php echo validation_errors(); ?></span></div>
	<!-- poast login -->
   	<p align="center">This login page is for <strong>administrator, sales manager, and manager</strong>. Please use your <strong>employee account</strong> to login</p>	
	<table align="center">
		<tr>
		<td><em>As an administrator, you can only create, modify, and delete employee's information.</em></td>
		</tr>
		<tr>
		<td><em>As a sales manager, you can only add, modify, and delete product's information.</em></td>
		</tr>
		<tr>
		<td><em>As a manager, you can only view reports.</em></td>
		</tr>
	</table>
	</div>
</body>
</html>
