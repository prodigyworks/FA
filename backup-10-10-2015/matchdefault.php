<?php
	require_once("system-db.php");
	
	start_db();
	
	if (isUserInRole("TEAM")) {
		header("location: match.php");
		
	} else {
		header("location: matchdetails.php");
	}
?>