<?php
	require_once("system-db.php");
	
	start_db();
	
	function alter($sql) {
		$result = mysql_query($sql);
		
		if (! $result) {
			logError($sql . " - " . mysql_error());
		}
		
		echo "<div>$sql</div>";
	}
	
	$sql = "SELECT C.id,
			(
				select B.agegroupid 
				FROM fa_matchplayerdetails A 
				INNER JOIN fa_player B 
				ON B.id = A.playerid
				WHERE A.matchid = C.id
				LIMIT 1
			) AS teamid
			 FROM fa_matchdetails C";
	$result = mysql_query($sql);

	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			$teamid = $member['teamid'];
			$id = $member['id'];
			
			if ($teamid != null)
				alter("UPDATE fa_matchdetails SET teamid = $teamid WHERE id = $id");
		}
	}
	
	mysql_query("COMMIT");
	
?>
