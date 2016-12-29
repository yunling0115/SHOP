<html>
<head>
<!-- css -->
	<link href="sec.css" rel="stylesheet" type="text/css" />
</head>
<body>
<!-- manager's rerpot -->
	<?php
		// Get values
		$sales = $_GET['sales'];
		$name = $_GET['name'];		
		$type = $_GET['type'];
		$start = $_GET['start'];
		$end = $_GET['end'];
		// Create Detailed Table
		$con = mysql_connect('localhost','root','0418162');
		mysql_select_db('hw4',$con);
		$s = 'create table temp1 as select distinct Product.Name, Product.Type, Orders.OrderID, Orders.Date, Items.Price, Items.Quantity from Product, Orders, Items where Orders.OrderID=Items.OrderID and Items.Name=Product.Name';
		mysql_query($s);
		$s = 'create table temp2 as select distinct temp1.*, Sales.Name as SalesName, Sales.SalesPrice from temp1 left join Sales on temp1.Name=Sales.Name';
		mysql_query($s);
		$sql[0] = 'create table temp3 as select * from temp2';
		if ($name=='name') {$sql[1]="";}
		else {$sql[1] = 'temp2.Name="'.$name.'"';}
		if ($type=='type') {$sql[2]="";}
		else {$sql[2] = 'temp2.Type='.$type;}
		if ($sales=='sales') {$sql[3]="";}
		else {$sql[3] = 'temp2.SalesName="'.$sales.'"';}
		if ($start=='start') {$sql[4]="";}
		else {$sql[4] = 'CAST(temp2.Date AS DATE)>=CAST("'.$start.'" AS DATE)';}
		if ($end=='end') {$sql[5]="";}
		else {$sql[5] = 'CAST(temp2.Date AS DATE)<=CAST("'.$end.'" AS DATE)';}
		$sql_c = $sql[0];
		for ($first=1;$first<=5;$first++) {
			if ($sql[$first]!="") {
				break;
			}
		}
		if ($first<6) {
			$sql_c = $sql_c.' where '.$sql[$first];	
			if ($first<5) {
				for ($i=$first+1;$i<=5;$i++) {
					if ($sql[$i]!="") {
						$sql_c = $sql_c.' and '.$sql[$i];
					}
				}
			}
		}
		mysql_query($sql_c,$con);
		// Summary Query
		$sql_s = 'select distinct Name, Type, sum(Quantity) as Quantity, sum(Quantity*Price) as TotalRevenue from temp3 group by Name order by Name';
		$res = mysql_query($sql_s,$con);
		// Report Summary Table
		if (!($exist=mysql_fetch_array($res))) {
			echo '<p style="color:red"><strong>0 Search Result, Please Select Again</strong></p>';
		}
		else {
			echo '<fieldset><legend><strong>Orders Summary Report</strong></legend>';
			echo '<table id="order_summary">';
			echo '<tr>
					<td><strong>Name</strong></td>
					<td><strong>Type</strong></td>
					<td><strong>Quantity</strong></td>
					<td><strong>Sales Revenue</strong></td>
					<td><strong>View Orders</strong></td>
				</tr>';
			// 1. echo first result in exist
			echo '<tr>';
			echo '<td width="130">'.$exist['Name'].'</td>';
			echo '<td width="130">'.$exist['Type'].'</td>';
			echo '<td width="130">'.$exist['Quantity'].'</td>';
			echo '<td width="160">'.$exist['TotalRevenue'].'</td>';
			echo '<td><input type="button" value="Details >" name="'.$exist['Name'].'" onclick="ShowOrders(this)" /></td>';
			// button to view details
			echo '<tr id="'.$exist['Name'].'" hidden>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><fieldset><table>
			<legend><strong>Order Details</strong></legend>';
			echo '<tr>
					<td width="130"><strong>OrderID</strong></td>
					<td width="130"><strong>Date</strong></td>
					<td width="130"><strong>Price</strong></td>
					<td width="130"><strong>Sales?</strong></td>
				</tr>';
			// get detailed information from temp3 table
			$sql_d = 'select distinct * from temp3 where Name="'.$exist['Name'].'"';
			$res_d = mysql_query($sql_d);
			while ($row_d = mysql_fetch_assoc($res_d)) {
				echo '<tr><td>'.$row_d['OrderID'].'</td> <td>'.$row_d['Date'].'</td> <td>'.$row_d['Price'].'</td>';
				if (isset($row_d['SalesPrice']) && ($row_d['SalesPrice']==$row_d['Price'])) {
					echo '<td>Yes</td>';
				}
				else echo '<td>No</td>';
				echo '</tr>';
			}
			echo '</table></fieldset></tr>';
			echo '</tr>';			
			// 2. echo following rows
			while ($exist=mysql_fetch_array($res)) {
				echo '<tr>';
				echo '<td width="130">'.$exist['Name'].'</td>';
				echo '<td width="130">'.$exist['Type'].'</td>';
				echo '<td width="130">'.$exist['Quantity'].'</td>';
				echo '<td width="160">'.$exist['TotalRevenue'].'</td>';
				echo '<td><input type="button" value="Details >" name="'.$exist['Name'].'" onclick="ShowOrders(this)" /></td>';
				// button to view details
				echo '<tr id="'.$exist['Name'].'" hidden>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><fieldset><table>
				<legend><strong>Order Details</strong></legend>';
				echo '<tr>
						<td width="130"><strong>OrderID</strong></td>
						<td width="130"><strong>Date</strong></td>
						<td width="130"><strong>Price</strong></td>
						<td width="130"><strong>Sales?</strong></td>
					</tr>';
				// get detailed information from temp3 table
				$sql_d = 'select distinct * from temp3 where Name="'.$exist['Name'].'"';
				$res_d = mysql_query($sql_d);
				while ($row_d = mysql_fetch_assoc($res_d)) {
					echo '<tr><td>'.$row_d['OrderID'].'</td> <td>'.$row_d['Date'].'</td> <td>'.$row_d['Price'].'</td>';
					if (isset($row_d['SalesPrice']) && ($row_d['SalesPrice']==$row_d['Price'])) {
						echo '<td>Yes</td>';
						}
					else echo '<td>No</td>';
				echo '</tr>';
				}
				echo '</table></fieldset></tr>';
				echo '</tr>';	
			}
			echo '</table>';	
			echo '<div id="report"></div></fieldset>';
		}
		// Delete temp tables
		$sql_d = 'drop table temp1';
		mysql_query($sql_d,$con);
		$sql_d = 'drop table temp2';
		mysql_query($sql_d,$con);
		$sql_d = 'drop table temp3';
		mysql_query($sql_d,$con);
	?>
</body>
</html>