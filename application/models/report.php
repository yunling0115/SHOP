<?php
// Model - get the data
Class Report extends CI_Model
{
	function getname() {
		$this->db->select('Name');
		$this->db->from('Product');
		$query=$this->db->get();
		return $query->result();
	}
	
	function gettype() {
		$this->db->select('Type');
		$this->db->from('FormType');
		$query=$this->db->get();
		return $query->result();
	}
	
	function getsalesname() {
		$this->db->select('Name');
		$this->db->from('Sales');
		$query=$this->db->get();
		return $query->result();
	}
	
	function getsummary_customer($username) {
		// select distinct Orders.*, sum(Items.Price*Items.Quantity) as TotalPrice from Orders, Items where Orders.UserID = $username and Orders.OrderID = Items.OrderID group by OrderID
		$this->db->select('Orders.*, sum(Items.Price*Items.Quantity) as TotalPrice');
		$this->db->from('Orders');
		$this->db->join('Items','Orders.OrderID = Items.OrderID');
		$this->db->where('Orders.UserID',$username);
		$this->db->group_by('Orders.OrderID');
		$query=$this->db->get();
		return $query->result();
	}
	
	function getdetails_customer($username) {
		// select distinct Items.* from Orders, Items where Orders.OrderID = Items.OrderID and Orders.UserID = $username
		$this->db->select('Items.*');
		$this->db->from('Items');
		$this->db->join('Orders','Orders.OrderID = Items.OrderID');
		$this->db->where('Orders.UserID',$username);
		$query=$this->db->get();
		return $query->result();
	}

	function getsummary($sales, $name, $type, $start, $end)
	{
		// select distinct Product.Name, Product.Type, sum(Items.Quantity) as Quantity, sum(Items.Quantity*Items.Price) as Revenue from Product, Items where Product.Name=Items.Name group by Product.Name;
		$this->db->select('Product.Name, Product.Type, sum(Items.Quantity) as Quantity, sum(Items.Quantity*Items.Price) as Revenue');
		$this->db->from('Items');
		$this->db->join('Product','Product.Name=Items.Name');
		$this->db->join('Orders','Orders.OrderID=Items.OrderID');
		$this->db->group_by('Product.Name');
		// adding conditions
		if ($name!='name') {
			$this->db->where('Product.Name',$name);
		}
		if ($type!='type') {
			$this->db->where('Product.Type',$type);
		}
		if ($start!='start') {
			$this->db->where('CAST(Orders.Date AS DATE)<=','CAST('.$start.' AS DATE)');
		}
		if ($end!='end') {
			$this->db->where('CAST(Orders.Date AS DATE)>=','CAST('.$end.' AS DATE)');
		}
		if ($sales!='sales') {
			$this->db->join('Sales','Sales.Name=Product.Name');
		}
		// submit query
		$query=$this->db->get();
		return $query->result();
	}
	
	function getdetails($sales, $name, $type, $start, $end)
	{
		// select Items.Name, Items.OrderID, Orders.Date, Items.Price, if(Sales.SalesPrice=Items.Price,'yes','no') as Sales from (Items join Orders on Items.OrderID = Orders.OrderID ) left join Sales on Items.Name=Sales.Name
		$this->db->select('Items.Name, Items.OrderID, Orders.Date, Items.Price, Sales.SalesPrice');
		$this->db->from('Items join Product join Orders on Items.OrderID = Orders.OrderID and Product.Name=Items.Name');
		$this->db->join('Sales','Sales.Name=Items.Name','left');
		// adding conditions
		if ($name!='name') {
			$this->db->where('Product.Name',$name);
		}
		if ($type!='type') {
			$this->db->where('Product.Type',$type);
		}
		if ($start!='start') {
			$this->db->where('CAST(Orders.Date AS DATE)<=','CAST('.$start.' AS DATE)');
		}
		if ($end!='end') {
			$this->db->where('CAST(Orders.Date AS DATE)>=','CAST('.$end.' AS DATE)');
		}
		if ($sales!='sales') {
			$this->db->join('Sales','Sales.Name=Product.Name');
		}
		$query=$this->db->get();
		return $query->result();
	}
	
	function getrecommend($formname_text_ajax) 
	{
		return $this->db->query("select distinct a.Name FROM Items as a, Items as b where a.OrderID=b.OrderID and
				 b.Name in (".$formname_text_ajax.") and a.Name not in (".$formname_text_ajax.")")->result_array();
	}
	
	function insertOrder($username, $totalprice) // return OrderID 
	{
		$orders = $this->db->query("select max(OrderID) as OrderID from Orders")->result_array();
		$orderid = $orders[0]['OrderID']+1;
		// get date
		$date = date("Y-m-d");
		// get address
		$this->db->select("Street, City, State, Zip, Street2, City2, State2, Zip2");
		$this->db->from("Customers");
		$this->db->where('UserID',$username);
		$query=$this->db->get();
		$customer = $query->result_array();
		$street = $customer[0]['Street'];
		$city = $customer[0]['City'];
		$state = $customer[0]['State'];
		$zip = $customer[0]['Zip'];
		$street2 = $customer[0]['Street2'];
		$city2 = $customer[0]['City2'];
		$state2 = $customer[0]['State2'];
		$zip2 = $customer[0]['Zip2'];
		// insert
		$data = array(
			'OrderID' => $orderid,
			'UserID' => $username,
			'Date' => $date,
			'TotalPrice' => $totalprice,
			'Street' => $street,
			'City' => $city,
			'State' => $state,
			'Zip' => $zip,
			'Street2' => $street2,
			'City2' => $city2,
			'State2' => $state2,
			'Zip2' => $zip2
			);
		$this->db->insert('Orders', $data); 	
		return $orderid;
	}
	
	function insertItems($orderid, $name, $qty, $price)
	{
		$data = array(
			'OrderID' => $orderid,
			'Name' => $name,
			'Quantity' => $qty,
			'Price' => $price
			);
		$this->db->insert('Items', $data); 
	}
}
?>