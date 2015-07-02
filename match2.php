<?php 
	require_once("system-header.php"); 
	require_once('signature.php');
	
?>
<div id="orderapp">
	<div class="title">Match Result Card</div>
	<form id="orderform" method="POST" action="match2.php">
		<input type="hidden" id="matchdate" name="matchdate" value="<?php echo $_POST['matchdate']; ?>" />
		<input type="hidden" id="leaguecup" name="leaguecup" value="<?php echo $_POST['leaguecup']; ?>" />
		<input type="hidden" id="awayteam" name="awayteam" value="<?php echo $_POST['awayteam']; ?>" />
		<input type="hidden" id="agegroupid" name="agegroupid" value="<?php echo $_POST['agegroupid']; ?>" />
<?php 
	$i = 0;
	
	for ($i = 0; $i < count($_POST['player']); $i++) {
?>
		<input type="hidden" name="player[]" value="<?php echo $_POST['player'][$i]; ?>"></input>
<?php 
	}
?>
		<div class="checkboxcontainer">
			<input type="checkbox" name="complycodes" id="complycodes">Did your opponent players, management and spectators comply with the Codes</input>
		</div>
		<div class="checkboxcontainer">
			<input type="checkbox" name="pitchsize" id=""pitchsize"">Was the pitch size/condition, goals and changing rooms adequate</input><br>
		</div>
		<div class="checkboxcontainer">
			<input type="checkbox" name="requiredbarriers" id=""requiredbarriers"">Did the pitch have the required barriers, cones and markings</input><br>
		</div>
		<div class="checkboxcontainer">
			<input type="checkbox" name="opponentids" id="opponentids">Did you check your opponent players ID cards</input><br>
		</div>

		<hr />

		<table width='75%' cellspacing=5>
			<tr>
				<td>Name of Referee</td>
				<td>
					<input type="text" id="referee" name="referee" />
				</td>
				<td>Appointed by the League</td>
				<td>
					<SELECT id="refappointedbyleague" name="refappointedbyleague">
						<OPTION value="Y">Yes</OPTION>
						<OPTION value="N">No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Referee's mark out of 100</td>
				<td colspan=3>
					<input type="text" size="3" id="refereemarks" name="refereemarks" />
				</td>
			</tr>
		</table>
		<hr />
<?php 
	addSignatureForm();
?>
		
		<input id="submitbutton" type="button" onclick="processorder()" value="Next"></input>
	</form>
	<script>
		$(document).ready(
				function() {
					$("#agegroupid").change(
							function() {
								$.ajax({
									url: "createplayerlist.php",
									dataType: 'html',
									async: false,
									data: {
										agegroupid: $("#agegroupid").val()
									},
									type: "POST",
									error: function(jqXHR, textStatus, errorThrown) {
										alert(errorThrown);
									},
									success: function(data) {
										$("#players").html(data).trigger("change");
									}
								});								
							}
						);
				}
			);
	function processorder() {
		$("#orderform").submit();
	}
	</script>
</div>
<?php include("system-footer.php"); ?>

