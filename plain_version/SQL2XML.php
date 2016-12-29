<?php
	$con = mysql_connect('localhost','root','0418162');
	if (!$con) {
		die("Cannot establish a connection");
	}
	$db_selected = mysql_select_db("hw5",$con);
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
<?php 
	echo 
	'<?xml version="1.0" encoding="ISO-8859-1"?>
	<?xml-stylesheet type="text/xsl" href="XML2HTML_noforeach.xsl"?>
	<products>';
	// product
	echo 
	'	<product>
		<name>1-A</name>
		<type>1</type>
		<price>100</price>
		<desc>Offering Statement under Regulation A</desc>
	</product>
	<product>
		<name>2-A</name>
		<type>1</type>
		<price>100</price>
		<desc>Report of sales and use of proceeds pursuant to Rule 257 of Regulation A</desc>
	</product>';	
	// product
	echo 
	'</products>';
?>

