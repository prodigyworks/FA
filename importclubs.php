<?php
	include("system-header.php"); 
	
	if (isset($_FILES['clubfile']) && $_FILES['clubfile']['tmp_name'] != "") {
		if ($_FILES["clubfile"]["error"] > 0) {
			echo "Error: " . $_FILES["clubfile"]["error"] . "<br />";
			
		} else {
		  	echo "Upload: " . $_FILES["clubfile"]["name"] . "<br />";
		  	echo "Type: " . $_FILES["clubfile"]["type"] . "<br />";
		  	echo "Size: " . ($_FILES["clubfile"]["size"] / 1024) . " Kb<br />";
		  	echo "Stored in: " . $_FILES["clubfile"]["tmp_name"] . "<br>";
		}
		
		$row = 1;
		
		if (($handle = fopen($_FILES['clubfile']['tmp_name'], "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		        $team = trim(mysql_escape_string($data[0]));
		        $club = substr($team, 0, lastIndexOf($team, " "));
		        $age = substr($team, lastIndexOf($team, " ") + 2);
		        
				if (preg_match("/[A-Z]$/", $age)) {
			        $age = substr($age, 0, strlen($age) - 1);
				}
		        		        
		        if ($data[0] != "") {
		        	echo "<div>Product code: ($club) ($team) ($age)</div>";
		        	
					$qry = "SELECT id 
							FROM {$_SESSION['DB_PREFIX']}team
							WHERE name = '$club'";
					$result = mysql_query($qry);
					$clubid = 0;
					
					//Check whether the query was successful or not
					if ($result) {
						while (($member = mysql_fetch_assoc($result))) {
							$clubid = $member['id'];
						}
					}
					
					if ($clubid == 0) {
						$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}team 
								(
								name
								)  
								VALUES  
								(
								'$club'
								)";
								
						$result = mysql_query($qry);
						$clubid = mysql_insert_id();
	        	
						if (! $result) {
							logError(mysql_error() . " : " .  $qry);
						}
					}
		        		        
					$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}teamagegroup 
							(
							teamid, name, age
							)  
							VALUES  
							(
							$clubid, '$team', $age
							)";
							
					$result = mysql_query($qry);
        	
					if (! $result) {
						logError(mysql_error() . " : " .  $qry);
					}
		        }
		    }
		    
		    fclose($handle);
			echo "<h1>" . $row . " downloaded</h1>";
		}
	}
	
	if (! isset($_FILES['clubfile'])) {
?>	
		
<form class="contentform" method="post" enctype="multipart/form-data" onsubmit="return askPassword()">
	<label>Clubs file </label>
	<input type="file" name="clubfile" id="clubfile" /> 
	
	<br />
	 	
	<div id="submit" class="show">
		<input type="submit" value="Upload" />
	</div>
</form>
<?php
	}
	
	include("system-footer.php"); 
?>