<?php
	require_once("system-header.php");
	
	$id = $_GET['id'];
	$sql = "SELECT DATE_FORMAT(metacreateddate, '%d/%m/%Y %H:%i') AS createddate 
			FROM {$_SESSION['DB_PREFIX']}matchdetails
			WHERE id = $id";

	$result = mysql_query($sql);
	$createddate = "";

	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			$createddate = $member['createddate'];
		}
		
	} else {
		logError($sql . " " . mysql_error());
	}
	?>
<div id="orderapp">
<br>
<center>
<h3>
Match card received at <?php echo $createddate; ?>. Reference: <?php echo $id; ?>
</h3>
<br>
<br>
<h4>
Please click on 'Home' to see your submitted result.
</h4>
<br>
<h4>
To see the contents of the Match Result Form you have submitted click on the <img src="images/matchconfirmbutton.png" /> button.
</h4>
<br>
<br>
<h4>
                          This report can then be printed by your system or saved.
</h4>
</center>
</div>
<?php
	require_once("system-footer.php");
?>
