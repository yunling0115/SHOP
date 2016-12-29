<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Create Profile</title>
	<link href="<?php echo base_url();?>css/sec.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url();?>jquery/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>jquery/customer.js"></script>
</head>
<body>
	<h1>Easy Filing SEC Forms</h1>	
	<h2>Customer's Page</h2>
	<strong style="color:green">USER: <?php if(isset($username)) {echo $username;} else {echo 'Guest<p></p>';} ?></strong>
	<?php if(isset($username)) { ?>
	<p><input type="button" class="log_out" value="Logout" onClick="window.location.href = 'product_select/logout'"/></p>
	<?php } ?>
	<div id="step1">
	<?php
		echo form_open('createprofile_done'); 
	?>
	<!-- summary error msg -->
	<p id="submit_msg" style="color:red"></p>
	<!-- choose an id -->
	<fieldset><legend><strong>User ID and Password</strong></legend>
		<p id="user_error" style="color:red"></p><table><!-- for JS -->
			<tr><td>User ID: </td>
			<td><input type="text" name="userid" id="userid"/></td><td style="color:red" id="user_exist"></td></td></tr>
			<tr><td>Password: </td>
			<td><input type="password" name="password" id="password"/></td></tr>
		</table></fieldset><p></p>
	<!-- company info -->
	<fieldset><legend><strong>Company Information</strong></legend>
		<p id="company_error" style="color:red"></p><table><!-- for JS -->
			<tr><td>Company Conformed Name: </td>
			<td><input type="text" name="name" id="name"/></td><td>&nbsp;</td>
			<td>Central Index Key: </td>
			<td><input type="text" name="cik" id="cik"/></td></tr>
			<tr><td>Fiscal Year End: </td>
			<td><input type="text" name="fyr" id="fyr"/></td><td>&nbsp;</td>
			<td>IRS Number: </td>
			<td><input type="text" name="irs" id="irs"/></td></tr>	
		</table><p>Standard Industrial Classification Code: </p><table>			
			<tr><td><input type="radio" name="sic_code" id="sic_notknow"/>Select Industry If You Do Not Know Your Code: </td><td>			
				<select name="sic1" id="sic1" size="1" disabled="true">
				<option selected="">Select First-Digit Industry</option></select>
				<select name="sic2" id="sic2" size="1" disabled="true">
				<option selected="">Select Second-Digit Industry</option></select>
				<select name="sic3" id="sic3" size="1" disabled="true">
				<option selected="">Select Third-Digit Industry</option></select>
				<select name="sic4" id="sic4" size="1" disabled="true">
				<option selected="">Select Fourth-Digit Industry</option></select>
			</td></tr>
			<tr><td><input type="radio" name="sic_code" id="sic_know"/>Enter Your Four-Digit SIC Code If You Know It: </td>
				<td><input id="sic_enter" name="sic_enter" type="text"/></td></tr>
		</table><p id="sic_code" style="color:blue"></p></fieldset><p></p>
	<!-- business address -->
	<fieldset><legend><strong>Business Address</strong></legend>
		<p id="address1_error" style="color:red"></p><table><!-- for JS -->
			<tr><td>Street: </td>
			<td><input type="text" name="street" id="street"/></td><td>&nbsp;</td>
			<td>City: </td>
			<td><input type="text" name="city" id="city"/></td></tr>
			<tr><td>State: </td>
			<td><input type="text" name="state" id="state"/></td><td>&nbsp;</td>
			<td>Zip Code: </td>
			<td><input type="text" name="zip" id="zip"/></td></tr>		
			<tr><td>Email: </td>
			<td><input type="text" name="email" id="email"/></td><td>&nbsp;</td>
			<td>Phone: </td>
			<td><input type="text" name="phone" id="phone"/></td></tr>
		</table></fieldset><p></p>
	<!-- mailing address -->
	<fieldset><legend><strong>Mailing Address</strong></legend>	
		<p id="address2_error" style="color:red"></p><!-- for JS -->
		<p>Is the Mail Address Same as Business Address?
			<input type="radio" name="mail" value="Y" id="mail_Y"/>Yes 
			<input type="radio" name="mail" value="N" id="mail_N"/>No 
		<p id="address2_error" style="color:red"></p><table>
			<tr><td>Street: </td>
			<td><input type="text" name="street2" id="street2"/></td><td>&nbsp;</td>
			<td>City: </td>
			<td><input type="text" name="city2" id="city2"/></td></tr>
			<tr><td>State: </td>
			<td><input type="text" name="state2" id="state2"/></td><td>&nbsp;</td>
			<td>Zip Code: </td>
			<td><input type="text" name="zip2" id="zip2"/></td></tr>
			<tr><td>Email: </td>
			<td><input type="text" name="email2" id="email2"/></td><td>&nbsp;</td>
			<td>Phone: </td>
			<td><input type="text" name="phone2" id="phone2"/></td></tr>
		</table></fieldset><p></p>
	<!-- submit button -->
	<p>Save Changes? 
		<input type="radio" name="check" id="checked_Y" value="Y"/>Yes
		<input type="radio" name="check" id="checked_N" value="N"/>No		
	</p>
	<p>
		<input id="submit_request" type="submit" value="Create" disabled="disabled" />
	</p>
	<input type="text" id="submit_status" hidden value="<?php echo isset($suc);?>" />
	<?php
		echo form_close(); 
	?>
	</div>
</body>
</html>