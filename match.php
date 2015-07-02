<?php include("system-header.php"); ?>
<style>
	#cup_opposition {
		display:none;
	}
	
	.score {
		text-align: center;
	}
	
	#players {
		min-height:350px;
	}
</style>
<div id="orderapp">
	<div class="title">Match Result Card</div>
	<form id="orderform" method="POST" action="match2.php">
		<table width='75%' cellspacing=5>
			<tr>
				<td>Date of Match</td>
				<td>
					<input type="text" class="datepicker" id="matchdate" name="matchdate" />
				</td>
				<td>League / Cup</td>
				<td>
					<SELECT id="leaguecup" name="leaguecup">
						<OPTION value="L">League</OPTION>
						<OPTION value="C">Cup</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Age Group</td>
				<td>
					<?php createCombo("agegroupid", "id", "name", "{$_SESSION['DB_PREFIX']}teamagegroup", "WHERE teamid = " . getLoggedOnTeamID(), true); ?>
				</td>
				<td>Home / Away</td>
				<td>
					<SELECT id="homeaway" name="homeaway">
						<OPTION value="H">Home</OPTION>
						<OPTION value="A">Away</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Opposition</td>
				<td>
					<div id="cup_opposition">
						<input type="text" size="30" id="opposition" name="opposition" />
					</div>
					<div id="league_opposition">
						<?php createCombo("oppositionid", "id", "name", "{$_SESSION['DB_PREFIX']}team", "WHERE id != " . getLoggedOnTeamID(), true); ?>
					</div>
				</td>
				<td>Score</td>
				<td>
					<input type="text" size="2" id="hometeamscore" name="hometeamscore" class="score" value="0" /> - 
					<input type="text" size="2" id="awayteamscore" name="awayteamscore" class="score" value="0" />
				</td>
			</tr>
		</table>
		<hr>
		<div id="players">
		</div>
		<input id="submitbutton" type="button" onclick="processorder()" value="Next"></input>
	</form>
	<script>
		$(document).ready(
				function() {
					$("#leaguecup").change(
							function() {
								if ($(this).val() == "L") {
									$("#cup_opposition").hide();
									$("#cup_opposition").val("");
									$("#league_opposition").show();

								} else {
									$("#cup_opposition").show();
									$("#league_opposition").hide();
									$("#league_opposition").val(0);
								}
							}
						);
					
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

