<?php
	session_start();
	$idletime=600;
	// Refresh the time 
	// If idle time is not greater than $idletime, refresh $_SESSION['timestmap']
	if (time()-$_SESSION['timestamp']<$idletime) {
		echo 0; // not time out
		$_SESSION['timestamp'] = time();
	}
	// otherwise: not refresh, time is out
	else {
		echo 1; // time out
	}
?>