<?php
	//Include database connection details
	require_once('system-config.php');
	
	if (! isset($_GET['password'])) {
		if (isUserInRole("SECRETARY")) {
			superUserLogin($_GET['login']);
			
			exit();
		}
	}
	
	if (isset($_GET['forward'])) {
		login($_GET['login'], $_GET['password'], $_GET['forward']);
		
	} else {
		login($_GET['login'], $_GET['password']);
	}
?>