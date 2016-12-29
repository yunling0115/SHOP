<?php
	$data['username'] = $username;
	$data['type'] = $type;
	$data['username'] = $username;
	$data['salesname'] = $salesname;
	$this->load->view('manager_view', $data);	
	echo '<div id="step2">';
	// summary report
	if (!$summary) {echo '<p style="color:red"><strong>0 Search Result, Please Select Again</strong></p>';}
	else {
		echo '<fieldset><legend><strong>Orders Summary Report</strong></legend>';
		echo '<table id="order_summary">';
		echo '<tr><td width="130"><strong>Name</strong></td>
				<td width="100"><strong>Type</strong></td>
				<td width="100"><strong>Quantity</strong></td>
				<td width="130"><strong>Sales Revenue</strong></td>
				<td width="500"><strong>View Orders</strong></td></tr>';
		foreach ($summary as $s) {	
			echo '<tr><td width="130">'.$s->Name.'</td>';
			echo '<td width="100">'.$s->Type.'</td>';
			echo '<td width="100">'.$s->Quantity.'</td>';
			echo '<td width="130">'.$s->Revenue.'</td>';
			echo '<td><input type="button" class="button" value="Details >" name="'.$s->Name.'"/></td>';
			echo '<tr id="'.$s->Name.'" hidden><td></td><td></td><td></td><td></td><td><fieldset><table>';
			echo '<legend><strong>Order Details</strong></legend>';
			echo '<tr><td width="130"><strong>OrderID</strong></td>
					<td width="150"><strong>Date</strong></td>
					<td width="130"><strong>Price</strong></td>
					<td width="150"><strong>Sales?</strong></td></tr>';
			foreach ($details as $d) { // details
				if ($d->Name==$s->Name) {
					echo '<tr><td>'.$d->OrderID.'</td> 
					<td>'.$d->Date.'</td><td>'.$d->Price.'</td>';
					if (isset($d->SalesPrice) && ($d->SalesPrice==$d->Price)) {echo '<td>Yes</td>';}
					else {echo '<td>No</td></tr>';}	
				}
			}	
			echo '</table></fieldset></tr></tr>';
		}
		echo '</table><div id="report"></div></fieldset>';
	}
	echo '</div>';
?>
