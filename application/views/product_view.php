<?php 
	$i = 0;
	foreach($product as $p) {
		if (!isset($p->Start)) {$value[$i]='"'.$p->Type.'|'.$p->Name.'|'.$p->FormDesc.'|'.$p->Price.'|"';}
		else {$value[$i]='"'.$p->Type.'|'.$p->Name.'|'.$p->FormDesc.'|'.$p->Price.'|'.$p->SalesPrice.'"';}
		$i++;
	} $N = $i;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Product</title>
	<link href="<?php echo base_url();?>css/sec.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url();?>jquery/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>jquery/cart.js"></script>
	<script type="text/javascript">
		var forms_all = new Array(); // global var for js: SEC forms
		<?php for ($i=0; $i<$N; $i++) { ?> forms_all[<?php echo $i ?>] = <? echo $value[$i] ?>; <?php } ?>
	</script>
</head>
<body>
	<h1>Easy Filing SEC Forms</h1>	
	<h2>Customer's Page</h2>
	<strong style="color:green">USER: <?php if(isset($username)) {echo $username;} else {echo 'Guest<p></p>';} ?></strong>
	<?php if(isset($username)) { ?>
	<p><input type="button" class="log_out" value="Logout" onClick="window.location.href = 'product_select/logout'"/></p>
	<?php } ?>
	<?php echo form_open('create_cart');  ?>
	<!-- step 1 -->
	<div id="step1"><fieldset>
		<legend><strong>Step 1: Choose The Regulation Your SEC Form Is Conformed To (Choose One)</strong></legend><table>
		<tr><td><input type="radio" name="regulation" value="1" id="id1"/>Securities Act of 1933</td>
			<td><input type="radio" name="regulation" value="2" id="id2"/>Securities Exchange Act of 1934</td></tr>	
		<tr><td><input type="radio" name="regulation" value="3" id="id3"/>Municipal Advisor Registration</td>
			<td><input type="radio" name="regulation" value="4" id="id4" disabled='disabled'/>Proxy And Tender Offer</td></tr>
		<tr><td><input type="radio" name="regulation" value="5" id="id5"/>Small Business</td>
			<td><input type="radio" name="regulation" value="6" id="id6" disabled='disabled'/>International</td></tr>
		<tr><td><input type="radio" name="regulation" value="7" id="id7" disabled='disabled'/>EDGAR</td>
			<td><input type="radio" name="regulation" value="8" id="id8"/>Trust Indenture Act of 1939</td></tr>
		<tr><td><input type="radio" name="regulation" value="9" id="id9" disabled='disabled'/>Insiders (Officers, Directors & Significant Shareholders)</td>
			<td><input type="radio" name="regulation" value="10" id="id10"/>Division of Corporate Finance-Statutes, Rules, and Forms</td></tr>
		<tr><td><input type="radio" name="regulation" value="11" id="id11"/>Investment Company Registration & Reporting</td>
			<td><input type="radio" name="regulation" value="12" id="id12"/>Broker-Dealer Registration & Reporting</td></tr>
		<tr><td><input type="radio" name="regulation" value="13" id="id13"/>Clearing Agency Application</td>
			<td><input type="radio" name="regulation" value="14" id="id14"/>Municipal Securities Dealer Registration</td></tr>
		<tr><td><input type="radio" name="regulation" value="15" id="id15"/>Transfer Agent Registration</td>
			<td><input type="radio" name="regulation" value="16" id="id16"/>SROs, Exchanges & Alternative Trading Systems</td></tr>
		<tr><td><input type="radio" name="regulation" value="17" id="id17"/>Nationally Recognized Statistical Rating Organizations ("NRSROs")</td>
			<td><input type="radio" name="regulation" value="18" id="id18"/>Tips, Complaints, Referrals, and Whistleblower</td></tr></table></fieldset><p></p></div>
	<!-- step 2 -->
	<div id="step2"><fieldset>
		<legend><strong>Step 2: Choose Your SEC Form (Choose One Or More Than One)</strong></legend>
		<table id="form_table"></table>
		</fieldset><p></p><p></p></div>
	<!-- step 3 -->
	<div id="step3"><fieldset>
		<legend><strong>Step 3: Selection Summary</strong></legend>
		<table><tr><input type="reset" style="width:70px" name="reset" id="reset" value="reset all"/></tr>
		<tr><td width=130>Current Selection</td><td>
		<span style="color:blue" id='chosen_form' name='chosen_form'></span></td></tr>
		<tr><td>Recommendation</td><td>
		<span style="color:blue" id='recommend_form' name='recommend_form'></span></td></tr></table></fieldset></div>
	<!-- submit -->
	<div id="step4"><p><strong>Add To Cart?</strong>
		<input type="radio" name="check" id="checked_Y" value="Y">Yes</input>
		<input type="radio" name="check" id="checked_N" value="N">No</input>&nbsp;&nbsp;&nbsp;&nbsp;			
		<input id="submit_request" type="submit" value="Add To Cart >>" disabled="disabled"/></p>
		<p id="Message" name="Message"></p></div>
	<?php form_close(); ?>
</body>
</html>