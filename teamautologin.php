<?php
	//Include database connection details
	require_once('system-db.php');
	
	start_db();
	
	$id = $_GET['id'];
	$qry = "SELECT login FROM {$_SESSION['DB_PREFIX']}teamagegroup A
			WHERE A.id = $id ";
	$result = mysql_query($qry);
	$login = "";

	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			$login = $member['login'];
		}
	}
	
	if ($login != "") {
		header("location: autologin.php?login=$login");
	}
?>