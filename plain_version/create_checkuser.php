<?php
	session_start();
	$userid = $_GET['userid'];
	$con = mysql_connect('localhost','root','0418162');
	if (!$con) {
		die("Cannot establish a connection");
	}
	$db_selected = mysql_select_db("hw4",$con);
	$sql = 'select UserID from Customers where UserID="'.$userid.'"';
	$res = mysql_query($sql);
	if ($row = mysql_fetch_assoc($res)) {
		// exist
		echo '<span style="color:red">User Name Already Exists!</span>';
	}
	else {
		echo '<span style="color:blue">No User Name Exists</span>';
	}
?>