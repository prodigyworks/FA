<?php
	//Include database connection details
	require_once('system-db.php');
	
	start_db();
	
	$login = null;
									
//	$qry = "UPDATE {$_SESSION['DB_PREFIX']}loginaudit SET " .
//			"timeoff = NOW() " .
//			"WHERE id = " . $_SESSION['SESS_LOGIN_AUDIT'] . "";
//	$result = mysql_query($qry);
//	
//	if (! $result) {
//		logError($qry . " - " . mysql_error());
//	}
	
	if (isset($_SESSION['SUPER_USER'])) {
		$login = $_SESSION['SUPER_USER'];
	}
	
	if ($login != null) {
		unset($_SESSION['SUPER_USER']);
		
		login($login);
		
	} else {
		unset($_SESSION['SESS_MEMBER_ID']);
		unset($_SESSION['SESS_FIRST_NAME']);
		unset($_SESSION['SESS_LAST_NAME']);
		unset($_SESSION['SESS_TEAM_ID']);
		unset($_SESSION['SESS_TEAM_AGE']);
		unset($_SESSION['SESS_TEAM_NAME']);
		unset($_SESSION['SESS_TEAM_IMAGE_ID']);
		unset($_SESSION['SESS_TEAM_EMAIL']);
		unset($_SESSION['SESS_CLUB_ID']);
		unset($_SESSION['SESS_CLUB_NAME']);
	}
	
	header("location: system-login.php?id=" . $_GET['id']);
?>
