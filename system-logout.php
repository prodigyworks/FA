<?php
	//Include database connection details
	require_once('system-db.php');
	
	start_db();
	
	$login = null;
									
	$qry = "UPDATE {$_SESSION['DB_PREFIX']}loginaudit SET " .
			"timeoff = NOW() " .
			"WHERE id = " . $_SESSION['SESS_LOGIN_AUDIT'] . "";
	$result = mysql_query($qry);
	
	if (! $result) {
		logError($qry . " - " . mysql_error());
	}
	
	if (isset($_SESSION['SUPER_USER'])) {
		$login = $_SESSION['SUPER_USER'];
	}
	
	if ($login != null) {
		unset($_SESSION['SUPER_USER']);
		
		login($login);
		
	} else {
		session_unset();
	}
	
	header("location: index.php");
?>
