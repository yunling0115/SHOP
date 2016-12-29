<?php
// Model - get the data
Class Customer extends CI_Model
{
	function login($username, $password)
	{
		// $this establish the query
		$this -> db -> select('UserID, Passwrd'); // select ___
		$this -> db -> from('Customers'); // from table ___
		$this -> db -> where('UserID', $username); // where ____
		$this -> db -> where('Passwrd', MD5($password)); // where ____
		$this -> db -> limit(1);

		// $this submitted
		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	
	function getuser($username) {
		$this->db->select('*');
		$this->db->where('UserID',$username);
		$this -> db -> from('Customers');
		$query=$this->db->get();
		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{	
			return false;
		}
	}
	
	function createuser($username, $password, $name, $cik, $fyr, $irs, $sic_code, 
		$street, $city, $state, $zip, $email, $phone,
		$street2, $city2, $state2, $zip2, $email2, $phone2)
	{
		// insert
		$data = array(
			'UserID' => $username,
			'Passwrd' => MD5($password),
			'Name' => $name,
			'CIK' => $cik,
			'FYR' => $fyr,
			'IRS' => $irs,
			'SIC' => $sic_code,
			'Street' => $street,
			'City' => $city,
			'State' => $state,
			'Zip' => $zip,
			'Email' => $email,
			'Phone' => $phone,
			'Street2' => $street2,
			'City2' => $city2,
			'State2' => $state2,
			'Zip2' => $zip2,
			'Email2' => $email2,
			'Phone2' =>	$phone2
		);
		$this->db->insert('Customers', $data); 
	}
	
	function edituser($username, $password, $name, $cik, $fyr, $irs, $sic_code, 
		$street, $city, $state, $zip, $email, $phone,
		$street2, $city2, $state2, $zip2, $email2, $phone2)
	{
		if (strlen($password)==32) 
		{
			// update if password = password
			$data = array(
				'Passwrd' => $password,
				'Name' => $name,
				'CIK' => $cik,
				'FYR' => $fyr,
				'IRS' => $irs,
				'SIC' => $sic_code,
				'Street' => $street,
				'City' => $city,
				'State' => $state,
				'Zip' => $zip,
				'Email' => $email,
				'Phone' => $phone,
				'Street2' => $street2,
				'City2' => $city2,
				'State2' => $state2,
				'Zip2' => $zip2,
				'Email2' => $email2,
				'Phone2' =>	$phone2
			);
		}
		else 
		{
			// update if password = MD5(password)
			$data = array(
				'Passwrd' => MD5($password),
				'Name' => $name,
				'CIK' => $cik,
				'FYR' => $fyr,
				'IRS' => $irs,
				'SIC' => $sic_code,
				'Street' => $street,
				'City' => $city,
				'State' => $state,
				'Zip' => $zip,
				'Email' => $email,
				'Phone' => $phone,
				'Street2' => $street2,
				'City2' => $city2,
				'State2' => $state2,
				'Zip2' => $zip2,
				'Email2' => $email2,
				'Phone2' =>	$phone2
			);
		}
		$this->db->where('UserID', $username);
		$this->db->update('Customers', $data); 
	}
}
?>