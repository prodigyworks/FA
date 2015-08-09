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
<h3>
<center>
Match card received at <?php echo $createddate; ?>. Reference: <?php echo $id; ?>
</center>
</h3>
</div>
<?php
	require_once("system-footer.php");
?>
