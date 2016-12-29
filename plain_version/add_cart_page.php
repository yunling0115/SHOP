<?php
	$con = mysql_connect('localhost','root','0418162');
	if (!$con) {
		die("Cannot establish a connection");
	}
	$db_selected = mysql_select_db("hw4",$con);
	$sql = 'create table View select Product.Name, Type, FormDesc, Price from Product, FormDesc where Product.Name = FormDesc.Name';
	$result = mysql_query($sql,$con);
	$sql = 'select distinct View.*, SalesPrice, Start, End from View left join Sales on View.Name = Sales.Name';
	$result = mysql_query($sql,$con);
	$sql = 'drop table View';
	mysql_query($sql,$con);
	$i = 0;
	while ($row = mysql_fetch_assoc($result)) {
		if (!isset($row['Start'])) {
			$value[$i] = '"'.$row['Type'].'|'.$row['Name'].'|'.$row['FormDesc'].'|'.$row['Price'].'|"';
		}
		else {
			$value[$i] = '"'.$row['Type'].'|'.$row['Name'].'|'.$row['FormDesc'].'|'.$row['Price'].'|'.$row['SalesPrice'].'"';
		}
		$i++;
	}
	$N = $i;
?>
<html>
<head>
<!-- css -->
	<link href="sec.css" rel="stylesheet" type="text/css" />
<!-- javascript -->
	<script type="text/javascript">
	// 1. SEC forms
	var forms_all = new Array();
	forms_all[0] = ("1|1-A|Offering Statement under Regulation A|100|30");
	forms_all[1] = ("1|2-A|Report of sales and use of proceeds pursuant to Rule 257 of Regulation A|100|30");
	<?php
	for ($i=0; $i<$N; $i++) {
		?>
		forms_all[<?php echo $i ?>] = <? echo $value[$i] ?>;
		<?php
	}
	?>	
	/*
	function Try() {
		var text = "";
		for (i=0; i<forms_all.length; i++) {
			text = forms_all[i]+text;
		}
		window.alert(text);
	}	
	*/
	// 2. Generate SEC Forms For Specific Regulation
	function SelectForm(index) {
		// Generate arrays
		var forms = new Array();
		for (i=0; i<forms_all.length; i++) {
			var reg_index = forms_all[i].split("|")[0];
			if (reg_index==index.toString()) {
				forms[forms.length]=forms_all[i];
			}
		}
		// Add table rows - table id: form_table
		var table = document.getElementById("form_table");
		while (table.rows.length>0) {
			table.deleteRow(-1);
		}
		// 0. Add a button to check all or not
		if (forms.length>0) {
			var row = table.insertRow(0);
			var cell1 = row.insertCell(0);
			var element1 = document.createElement("input");
			element1.id = "select_all"
			element1.type = "button";
			element1.name = "form";
			element1.value = "Check All";			
			var cell2 = row.insertCell(1);
				var span = document.createElement("span");
				span.style.fontWeight="bold";
				span.innerHTML = "Name";
				cell2.appendChild(span);			
			var cell3 = row.insertCell(2);
				var span = document.createElement("span");
				span.style.fontWeight="bold";
				span.innerHTML = "Price";
				cell3.appendChild(span);			
			var cell4 = row.insertCell(3);
				var span = document.createElement("span");
				span.style.fontWeight="bold";
				span.innerHTML = "Sales";
				cell4.appendChild(span);
			var cell5 = row.insertCell(4);
				var span = document.createElement("span");
				span.style.fontWeight="bold";
				span.innerHTML = "Description";
				cell5.appendChild(span);
		}
		//element1.innerHTML = ;
		cell1.appendChild(element1);
		for (i=0; i<forms.length; i++) {
			var row = table.insertRow(i+1);			
			// 1. checkbox - checkbox name: form
			var cell1 = row.insertCell(0);
			var element1 = document.createElement("input");
			element1.type = "checkbox";
			element1.name = "form";
			element1.class = "SEC_checkbox";
			element1.value = forms[i].split("|")[1];
			cell1.appendChild(element1);
			cell1.width=80;
			// 2. form name
			var cell2 = row.insertCell(1);
			var text2 = document.createTextNode(forms[i].split("|")[1]);
			cell2.appendChild(text2);
			cell2.width=80;
			// 3. form price
			var cell3 = row.insertCell(2);
			var text = document.createTextNode(forms[i].split("|")[3]);
			cell3.appendChild(text);	
			cell3.width=80;
			// 4. sales price
			var cell4 = row.insertCell(3);
			var span = document.createElement("span");
			span.innerHTML = forms[i].split("|")[4];
			cell4.appendChild(span);
			cell4.width=80;
			// 5. form description
			var cell5 = row.insertCell(4);
			var text = document.createTextNode(forms[i].split("|")[2]);
			cell5.appendChild(text);
			
		}
		// Add button onClick attribute in the end
		element1 = document.getElementById("select_all");
		element1.onclick = function () {
			// If not checked -> set to check all
			var table = document.getElementById("form_table");
			if (element1.value=="Check All") {			
				for (i=0; i<table.rows.length; i++) {
					var checkbox = table.rows[i].cells[0].firstChild;
					checkbox.checked=true;
				}
				element1.value="Uncheck All";
				return;
			}
			// If checked -> set to uncheck all
			if (element1.value=="Uncheck All") {
				for (i=0; i<table.rows.length; i++) {
					var checkbox = table.rows[i].cells[0].firstChild;
					checkbox.checked=false;
				}
				element1.value="Check All";
				return;
			}
			return;
		};
	}
	// 3. reset
	function ClearForm() {
		var table = document.getElementById("form_table");
			while (table.rows.length>0) {
				table.deleteRow(-1);
			}
	}
	</script>
</head>
<body>
	<h1>Easy Filing SEC Forms</h1>
	<h2>Choose The SEC Form Your Company Want To File</h2>
	<form method="POST" action="add_cart.php" name="create_customer">
	<!-- Product List by type (on sale will have a sale information -->
	<fieldset>
	<legend><strong>Select Your Form</strong></legend>
	<p><strong>Step 1: Choose The Regulation Your SEC Form Is Conformed To (Choose One)</strong></p>
		<table>
			<tr>
			<td><input type="radio" name="regulation" value="1" onClick="SelectForm(1)"/>Securities Act of 1933</td>
			<td><input type="radio" name="regulation" value="2" onClick="SelectForm(2)"/>Securities Exchange Act of 1934</td>
			</tr>
			<tr>
			<td><input type="radio" name="regulation" value="3" onClick="SelectForm(3)"/>Municipal Advisor Registration</td>
			<td><input type="radio" name="regulation" value="4" disabled='disabled' onClick="SelectForm(4)"/>Proxy And Tender Offer</td>
			</tr>
			<tr>
			<td><input type="radio" name="regulation" value="5" onClick="SelectForm(5)"/>Small Business</td>
			<td><input type="radio" name="regulation" value="6" disabled='disabled' onClick="SelectForm(6)"/>International</td>
			</tr>
			<tr>		
			<td><input type="radio" name="regulation" value="7" disabled='disabled' onClick="SelectForm(7)"/>EDGAR</td>
			<td><input type="radio" name="regulation" value="8" onClick="SelectForm(8)"/>Trust Indenture Act of 1939</td>
			</tr>
			<tr>		
			<td><input type="radio" name="regulation" value="9" disabled='disabled' onClick="SelectForm(9)"/>Insiders (Officers, Directors & Significant Shareholders)</td>
			<td><input type="radio" name="regulation" value="10" onClick="SelectForm(10)"/>Division of Corporate Finance-Statutes, Rules, and Forms</td>
			</tr>
			<tr>		
			<td><input type="radio" name="regulation" value="11" onClick="SelectForm(11)"/>Investment Company Registration & Reporting</td>
			<td><input type="radio" name="regulation" value="12" onClick="SelectForm(12)"/>Broker-Dealer Registration & Reporting</td>
			</tr>
			<tr>		
			<td><input type="radio" name="regulation" value="13" onClick="SelectForm(13)"/>Clearing Agency Application</td>
			<td><input type="radio" name="regulation" value="14" onClick="SelectForm(14)"/>Municipal Securities Dealer Registration</td>
			</tr>
			<tr>		
			<td><input type="radio" name="regulation" value="15" onClick="SelectForm(15)"/>Transfer Agent Registration</td>
			<td><input type="radio" name="regulation" value="16" onClick="SelectForm(16)"/>SROs, Exchanges & Alternative Trading Systems</td>
			</tr>
			<tr>		
			<td><input type="radio" name="regulation" value="17" onClick="SelectForm(17)"/>Nationally Recognized Statistical Rating Organizations ("NRSROs")</td>
			<td><input type="radio" name="regulation" value="18" onClick="SelectForm(18)"/>Tips, Complaints, Referrals, and Whistleblower</td>
			</tr>
		<table>
	<p><strong>Step 2: Choose Your SEC Form (Choose One Or More Than One)</strong></p>
		<table id="form_table">
		</table>
		<p><input type="reset" value="Reset Form Selection" onClick="ClearForm()"/></p>		
	</fieldset>	
	<p></p>
	<!-- Recommended for you -->
	<fieldset>
	<legend><strong>Recomended For You</strong></legend>
	</fieldset>
	<p></p>
	<!-- Submit button -->
	<p>Is the above information correct? 
		<input type="radio" name="check" id="checked_Y" value="Y" onClick="document.getElementById('submit_request').disabled=false"/>Yes
		<input type="radio" name="check" id="checked_N" value="N" onClick="document.getElementById('submit_request').disabled=true"/>No		
	</p>
	<p>
		<input id="submit_request" type="submit" value="Add To Cart" disabled="disabled" onSubmit="return ValidateAll()"/>
	</p>
	</form>
	<!-- <p><input type="button" value="try" onClick="Try()"/></p> -->
<?php
	/*
	for($i=0;$i<=130;$i++) {
	echo $i.'||'.$value[$i].'<br/>';
	}
	*/
?>
</body>
</html>	