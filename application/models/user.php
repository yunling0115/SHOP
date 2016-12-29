<?php
// Model - get the data
Class User extends CI_Model
{
 function login($username, $password)
 {
	// $this establish the query
   $this -> db -> select('UserID, Passwrd'); // select ___
   $this -> db -> from('Employees'); // from table ___
   $this -> db -> where('UserID', $username); // where ____
   $this -> db -> where('Passwrd', MD5($password)); // where ____
   $this -> db -> limit(1);

	// $this submitted
   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
	// $query['result()']
     return $query->result();
   }
   else
   {
     return false;
   }
 }
}
?>