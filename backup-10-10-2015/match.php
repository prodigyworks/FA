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
	<div class="title">Match Result Form</div>
	<form id="orderform" method="POST" action="match2.php">
		<input type="hidden" id="ratereferee" name="ratereferee" value="<?php if (isset($_POST['ratereferee'])) echo $_POST['ratereferee']; ?>" />
		<input type="hidden" id="rateplayers" name="rateplayers" value="<?php if (isset($_POST['rateplayers'])) echo $_POST['rateplayers']; ?>" />
		<input type="hidden" id="ratemanagement" name="ratemanagement" value="<?php if (isset($_POST['ratemanagement'])) echo $_POST['ratemanagement']; ?>" />
		<input type="hidden" id="ratespectators" name="ratespectators" value="<?php if (isset($_POST['ratespectators'])) echo $_POST['ratespectators']; ?>" />
		<input type="hidden" id="ratepitchsize" name="ratepitchsize" value="<?php if (isset($_POST['ratepitchsize'])) echo $_POST['ratepitchsize']; ?>" />
		<input type="hidden" id="ratepitchcondition" name="ratepitchcondition" value="<?php if (isset($_POST['ratepitchcondition'])) echo $_POST['ratepitchcondition']; ?>" />
		<input type="hidden" id="rategoalsize" name="rategoalsize" value="<?php if (isset($_POST['rategoalsize'])) echo $_POST['rategoalsize']; ?>" />
		<input type="hidden" id="ratechangingrooms" name="ratechangingrooms" value="<?php if (isset($_POST['ratechangingrooms'])) echo $_POST['ratechangingrooms']; ?>" />
		<input type="hidden" id="opponentids" name="opponentids" value="<?php if (isset($_POST['opponentids'])) echo $_POST['opponentids']; ?>" />
		<input type="hidden" id="requiredbarriers" name="requiredbarriers" value="<?php if (isset($_POST['requiredbarriers'])) echo $_POST['requiredbarriers']; ?>" />
		<input type="hidden" id="pitchsize" name="pitchsize" value="<?php if (isset($_POST['pitchsize'])) echo $_POST['pitchsize']; ?>" />
		<input type="hidden" id="complycodes" name="complycodes" value="<?php if (isset($_POST['complycodes'])) echo $_POST['complycodes']; ?>" />
		<input type="hidden" id="refereeremarks" name="refereeremarks" value="<?php if (isset($_POST['refereeremarks'])) echo $_POST['refereeremarks']; ?>" />
		<input type="hidden" id="remarks" name="remarks" value="<?php if (isset($_POST['remarks'])) echo $_POST['remarks']; ?>" />
		<input type="hidden" id="refereename" name="refereename" value="<?php if (isset($_POST['refereename'])) echo $_POST['refereename']; ?>"/>
		<input type="hidden" id="refappointedbyleague" name="refappointedbyleague" value="<?php if (isset($_POST['refappointedbyleague'])) echo $_POST['refappointedbyleague']; ?>"/>
		<input type="hidden" id="refereeid" name="refereeid" value="<?php if (isset($_POST['refereeid'])) echo $_POST['refereeid']; ?>" />
		<input type="hidden" id="refereeid_lazy" name="refereeid_lazy" value="<?php if (isset($_POST['refereeid_lazy'])) echo $_POST['refereeid_lazy']; ?>" />
		<input type="hidden" id="name" name="name" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" />
		<input type="hidden" id="output" name="output" value="<?php if (isset($_POST['output'])) echo $_POST['output']; ?>" />
		<input type="hidden" id="signatureid" name="signatureid" value="<?php if (isset($_POST['signatureid'])) echo $_POST['signatureid']; ?>" />
		<input type="hidden" id="refereescore" name="refereescore" value="<?php if (isset($_POST['refereescore'])) echo $_POST['refereescore']; ?>" />
		
		<table width='75%' cellspacing=5>
			<tr>
				<td>Date of Match</td>
				<td>
					<input type="text" class="datepicker" id="matchdate" name="matchdate" value="<?php if (isset($_POST['matchdate'])) echo $_POST['matchdate']; ?>" />
				</td>
				<td>Age Group</td>
				<td>
					<SELECT id="agegroupid" name="agegroupid">
						<OPTION value="<?php echo getLoggedOnTeamAge(); ?>">Under <?php echo getLoggedOnTeamAge(); ?></OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Competition</td>
				<td>
					<SELECT id="leaguecup" name="leaguecup">
						<OPTION value="L">League</OPTION>
						<OPTION value="C">Challenge Cup</OPTION>
						<OPTION value="T">Challenge Trophy</OPTION>
					</SELECT>
				</td>
				<td>Division / Group</td>
				<td>
					<SELECT id="division" name="division">
						<OPTION value="X">N/A</OPTION>
						<OPTION value="1">A</OPTION>
						<OPTION value="2">B</OPTION>
						<OPTION value="3">C</OPTION>
						<OPTION value="4">D</OPTION>
						<OPTION value="5">E</OPTION>
						<OPTION value="6">F</OPTION>
						<OPTION value="7">G</OPTION>
						<OPTION value="8">H</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Home Team</td>
				<td>
					<?php createLazyCombo("hometeamid", "id", "name", "{$_SESSION['DB_PREFIX']}teamagegroup", "WHERE age = " . getLoggedOnTeamAge(), true, 40); ?>
				</td>
				<td>Home Team Score</td>
				<td>
					<input type="text" size="2" id="hometeamscore" name="hometeamscore" class="score"  value="<?php if (isset($_POST['hometeamscore'])) echo $_POST['hometeamscore']; else echo "0"; ?>" />
				</td>
			</tr>
			<tr>
				<td>Away Team</td>
				<td>
					<?php createLazyCombo("oppositionid", "id", "name", "{$_SESSION['DB_PREFIX']}teamagegroup", "WHERE age = " . getLoggedOnTeamAge(), true, 40); ?>
				</td>
				<td>Away Team Score</td>
				<td>
					<input type="text" size="2" id="awayteamscore" name="awayteamscore" class="score"  value="<?php if (isset($_POST['awayteamscore'])) echo $_POST['awayteamscore']; else echo "0"; ?>"/>
				</td>
			</tr>
		</table>
		<hr>
		<i>Please only include the players who played in the match</i><br><br>
		<div id="players">
		</div>
		<input class="submitbutton" type="button" onclick="processCard()" value="Next"></input>
	</form>
	<script>
		$(document).ready(
				function() {
					$("#leaguecup").change(
							function() {
								if ($(this).val() != "L" && $(this).val() != "N") {
									$("#division").val("X");
									$("#division").attr("disabled", true);

								} else {
									$("#division").attr("disabled", false);
								}
							}
						);
							
					if (<?php echo getLoggedOnTeamAge(); ?> < 12) {
						$("#orderform").attr("action", "match2u7.php");
						$("#leaguecup").html("<OPTION value='N'>Combination</OPTION>");
						$("#division").attr("disabled", false);
						
						$("#division").html(
								"<OPTION value='X'>N/A</OPTION>" +
								"<OPTION value='A'>A</OPTION>" +
								"<OPTION value='B'>B</OPTION>" +
								"<OPTION value='C'>C</OPTION>" +
								"<OPTION value='D'>D</OPTION>" +
								"<OPTION value='E'>E</OPTION>" +
								"<OPTION value='F'>F</OPTION>" +
								"<OPTION value='G'>G</OPTION>" +
								"<OPTION value='H'>H</OPTION>");
						
					} else {
						$("#orderform").attr("action", "match2.php");

						$("#leaguecup").html(
							"<OPTION value='L'>League</OPTION>" +
							"<OPTION value='C'>Challenge Cup</OPTION>" +
							"<OPTION value='T'>Challenge Trophy</OPTION>");

						$("#division").html(
							"<OPTION value='X'>N/A</OPTION>" +
							"<OPTION value='P'>Premier</OPTION>" +
							"<OPTION value='1'>1</OPTION>" +
							"<OPTION value='2'>2</OPTION>" +
							"<OPTION value='3'>3</OPTION>" +
							"<OPTION value='4'>4</OPTION>" +
							"<OPTION value='5'>5</OPTION>" +
							"<OPTION value='6'>6</OPTION>");
					}

					$.ajax({
							url: "createplayerlist.php",
							dataType: 'html',
							async: true,
							data: {
								agegroupid: <?php echo getLoggedOnTeamID(); ?>,
								selected: '<?php echo (isset($_POST['player']) ? json_encode($_POST['player']) : "null"); ?>'
							},
							type: "POST",
							error: function(jqXHR, textStatus, errorThrown) {
								alert(errorThrown);
							},
							success: function(data) {
								$("#players").html(data).trigger("change");
							}
						});								
	
<?php 
					if (isset($_POST['homeaway'])) echo "$('#homeaway').val('" . $_POST['homeaway' ] . "');";
					if (isset($_POST['division'])) echo "$('#division').val('" . $_POST['division' ] . "');";
					if (isset($_POST['leaguecup'])) echo "$('#leaguecup').val('" . $_POST['leaguecup' ] . "');";
					if (isset($_POST['agegroupid'])) echo "$('#agegroupid').val('" . $_POST['agegroupid' ] . "').trigger('change');";
					if (isset($_POST['oppositionid'])) echo "$('#oppositionid').val('" . $_POST['oppositionid' ] . "');";
					if (isset($_POST['oppositionid_lazy'])) echo "$('#oppositionid_lazy').val('" . $_POST['oppositionid_lazy' ] . "');";
					if (isset($_POST['hometeamid'])) echo "$('#hometeamid').val('" . $_POST['hometeamid' ] . "');";
					if (isset($_POST['hometeamid_lazy'])) echo "$('#hometeamid_lazy').val('" . $_POST['hometeamid_lazy' ] . "');";
					?>
				}
			);
		
	function processCard() {
		if (! isDate($("#matchdate").val())) {
			pwAlert("Date of Match must be a valid date");
			return false;
		}

		if ($("#hometeamid").val() != "<?php echo getLoggedOnTeamID()?>" && $("#oppositionid").val() != "<?php echo getLoggedOnTeamID()?>") {
			pwAlert("Either home or away team must be your team and MUST be selected from the dropdown list");
			return false;
		}
		
		if ($("#agegroupid").val() == 0) {
			pwAlert("Age group must be specified");
			return false;
		}
		
		if ($("#hometeamid").val() == "0" || $("#hometeamid").val() == "") {
			pwAlert("Home team must be specified");
			return false;
		}
		
		if (($("#leaguecup").val() == "N" || $("#leaguecup").val() == "L") && $("#division").val() == "X") {
			pwAlert("Division / Group must be specified");
			return false;
		}
		
		if ($("#oppositionid").val() == "0" || $("#oppositionid").val() == "0") {
			pwAlert("Away team must be specified");
			return false;
		}
		
		$("#orderform").submit();
	}
	</script>
</div>
<?php include("system-footer.php"); ?>

