<?php
	require_once("system-db.php");
	
	start_db();
	
	if (isUserInRole("ADMIN")) {
		header("location: teams.php");
		
	} else {
		header("location: levels.php");
	}
?>
