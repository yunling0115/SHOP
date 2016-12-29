<?php
// Model - get the data
Class Product extends CI_Model
{
	function getproduct() {
		$this->db->select("Product.Name, Product.Type, FormDesc.FormDesc, Product.Price, Sales.SalesPrice, Sales.Start, Sales.End");
		$this->db->from("Product join FormDesc on Product.Name=FormDesc.Name");
		$this->db->join("Sales","Product.Name=Sales.Name","left");
		$query=$this->db->get();
		return $query->result();
	}
	
	function getprice($name) {
		$this->db->select("Product.Price, Sales.SalesPrice");
		$this->db->from("Product");
		$this->db->join("Sales", "Product.Name=Sales.Name", "left");
		$this->db->where("Product.Name",$name);
		$query=$this->db->get();
		return $query->result();
	}
}
?>
