<?php 
	require_once("system-header.php"); 
	
?>
<style>
	#unofficial_referee, .badscore {
		display:none;
	}
	.submissionmsg {
		display:inline-block;
		position: relative;
		top: 7px;
		left: 20px;
	}
	
</style>
<div id="orderapp">
	<div class="title">Match Result Form</div>
	<form id="orderform" method="POST" action="match3.php">
		<input type="hidden" id="matchdate" name="matchdate" value="<?php echo $_POST['matchdate']; ?>" />
		<input type="hidden" id="division" name="division" value="<?php echo $_POST['division']; ?>" />
		<input type="hidden" id="leaguecup" name="leaguecup" value="<?php echo $_POST['leaguecup']; ?>" />
		<input type="hidden" id="awayteam" name="awayteam" value="<?php echo $_POST['awayteam']; ?>" />
		<input type="hidden" id="agegroupid" name="agegroupid" value="<?php echo $_POST['agegroupid']; ?>" />
		<input type="hidden" id="hometeamid_lazy" name="hometeamid_lazy" value="<?php echo $_POST['hometeamid_lazy']; ?>" />
		<input type="hidden" id="hometeamid" name="hometeamid" value="<?php echo $_POST['hometeamid']; ?>" />
		<input type="hidden" id="oppositionid_lazy" name="oppositionid_lazy" value="<?php echo $_POST['oppositionid_lazy']; ?>" />
		<input type="hidden" id="oppositionid" name="oppositionid" value="<?php echo $_POST['oppositionid']; ?>" />
		<input type="hidden" id="hometeamscore" name="hometeamscore" value="<?php echo $_POST['hometeamscore']; ?>" />
		<input type="hidden" id="awayteamscore" name="awayteamscore" value="<?php echo $_POST['awayteamscore']; ?>" />
		
		<input type="hidden" id="ratereferee" name="ratereferee" value="<?php if (isset($_POST['ratereferee'])) echo $_POST['ratereferee']; ?>" />
		<input type="hidden" id="rateplayers" name="rateplayers" value="<?php if (isset($_POST['rateplayers'])) echo $_POST['rateplayers']; ?>" />
		<input type="hidden" id="ratemanagement" name="ratemanagement" value="<?php if (isset($_POST['ratemanagement'])) echo $_POST['ratemanagement']; ?>" />
		<input type="hidden" id="ratespectators" name="ratespectators" value="<?php if (isset($_POST['ratespectators'])) echo $_POST['ratespectators']; ?>" />
		<input type="hidden" id="ratepitchsize" name="ratepitchsize" value="<?php if (isset($_POST['ratepitchsize'])) echo $_POST['ratepitchsize']; ?>" />
		<input type="hidden" id="ratepitchcondition" name="ratepitchcondition" value="<?php if (isset($_POST['ratepitchcondition'])) echo $_POST['ratepitchcondition']; ?>" />
		<input type="hidden" id="rategoalsize" name="rategoalsize" value="<?php if (isset($_POST['rategoalsize'])) echo $_POST['rategoalsize']; ?>" />
		<input type="hidden" id="ratechangingrooms" name="ratechangingrooms" value="<?php if (isset($_POST['ratechangingrooms'])) echo $_POST['ratechangingrooms']; ?>" />
<?php 
	$i = 0;
	
	if (isset($_POST['player'])) {
		for ($i = 0; $i < count($_POST['player']); $i++) {
?>
		<input type="hidden" name="player[]" value="<?php echo $_POST['player'][$i]; ?>"></input>
<?php 
		}
	}
?>
		<table>
			<tr>
				<td>
					<label>Did the pitch have the required barriers, cones and markings?</label>
				</td>
				<td>
					&nbsp;Yes&nbsp;
				</td>
				<td>
					<input type="radio" name="requiredbarriers" id="requiredbarriers_on" value="on" checked></input>
				</td>
				<td>
					&nbsp;No&nbsp;
				</td>
				<td>
					<input type="radio" name="requiredbarriers" id="requiredbarriers_off" value="off"></input>
				</td>
			</tr>
			<tr>
				<td>
					<label>Was the pitch size/condition, goals and changing rooms adequate?</label>
				</td>
				<td>
					&nbsp;Yes&nbsp;
				</td>
				<td>
					<input type="radio" name="pitchsize" id="pitchsize_on" value="on" checked></input>
				</td>
				<td>
					&nbsp;No&nbsp;
				</td>
				<td>
					<input type="radio" name="pitchsize" id="pitchsize_off" value="off"></input>
				</td>
			</tr>
			<tr>
				<td>
					<label>Did your opponent players, management and spectators comply with the Codes?</label>
				</td>
				<td>
					&nbsp;Yes&nbsp;
				</td>
				<td>
					<input type="radio" name="complycodes" id="complycodes_on" value="on" checked></input>
				</td>
				<td>
					&nbsp;No&nbsp;
				</td>
				<td>
					<input type="radio" name="complycodes" id="complycodes_off" value="off"></input>
				</td>
			</tr>
			<tr>
				<td>
					<label>Did you check your opponent players ID cards?</label>
				</td>
				<td>
					&nbsp;Yes&nbsp;
				</td>
				<td>
					<input type="radio" name="opponentids" id="opponentids_on" value="on" checked></input>
				</td>
				<td>
					&nbsp;No&nbsp;
				</td>
				<td>
					<input type="radio" name="opponentids" id="opponentids_off" value="off"></input>
				</td>
			</tr>
		</table>
		
		<br>
		<label><i>If NO to any of the above (or any other observations) please provide comments</i></label>
		<textarea id="remarks" name="remarks" rows="5" cols="70"></textarea>

		<hr />

		<table width='75%' cellspacing=5>
			<tr>
				<td>Referee: Appointed by the League? (Yes/No)</td>
				<td>
					<SELECT id="refappointedbyleague" name="refappointedbyleague">
						<OPTION value="Y">Yes</OPTION>
						<OPTION value="N">No</OPTION>
					</SELECT>
				</td>
				<td>Name</td>
				<td>
					<div id="leagueappointedref">
						<?php createLazyCombo("refereeid", "id", "name", "{$_SESSION['DB_PREFIX']}referee", "", true, 40); ?>
					</div>
					<div id="nonleagueappointedref" style="display:none">
						<input id="refereename" name="refereename" style="width:297px" />
					</div>
				</td>
			</tr>
			<tr>
				<td>Referee's mark out of 100</td>
				<td colspan=3>
					<input type="text" size="3" id="refereescore" name="refereescore" />
				</td>
			</tr>
			<tr class="badscore">
				<td colspan=4>
					<i>NOTE: A club awarding a mark of 60 or less must detail the reason(s) below</i><br>
					<textarea id="refereeremarks" name="refereeremarks" rows="5" cols="70"></textarea>
				</td>
			</tr>
		</table>
		<hr />
<?php 
	require_once('signature.php');

	addSignatureForm();
?>
		
		<input class="submitbutton" type="button" onclick="prevPage()" value="Prev"></input>&nbsp;
		<input class="submitbutton" type="button" onclick="processorder()" value="Submit"></input>
		<div class="submissionmsg"> Please allow the system to complete the submission before clicking any further buttons.</div>
	</form>
	<script>
		$(document).ready(
				function() {
					$("#refappointedbyleague").change(
							function() {
								if ($(this).val() == "N") {
									$("#leagueappointedref").hide();
									$("#nonleagueappointedref").show();
									$("#refereeid").val("0");
									$("#refereeid_lazy").val("");

								} else {
									$("#nonleagueappointedref").hide();
									$("#leagueappointedref").show();
									$("#refereename").val("");
								}
							}
						);

<?php 
					if (isset($_POST['rateplayers'])) echo "$('#rateplayers_" . $_POST['rateplayers'] . "').attr('checked', true);\n";
					if (isset($_POST['ratechangingrooms'])) echo "$('#ratechangingrooms_" . $_POST['ratechangingrooms'] . "').attr('checked', true);\n";
					if (isset($_POST['rategoalsize'])) echo "$('#rategoalsize_" . $_POST['rategoalsize'] . "').attr('checked', true);\n";
					if (isset($_POST['ratepitchcondition'])) echo "$('#ratepitchcondition_" . $_POST['ratepitchcondition'] . "').attr('checked', true);\n";
					if (isset($_POST['ratepitchsize'])) echo "$('#ratepitchsize_" . $_POST['ratepitchsize'] . "').attr('checked', true);\n";
					if (isset($_POST['ratespectators'])) echo "$('#ratespectators_" . $_POST['ratespectators'] . "').attr('checked', true);\n";
					if (isset($_POST['ratemanagement'])) echo "$('#ratemanagement_" . $_POST['ratemanagement'] . "').attr('checked', true);\n";
					
					if (isset($_POST['opponentids'])) echo "$('#opponentids_" . $_POST['opponentids'] . "').attr('checked', true);\n";
					if (isset($_POST['requiredbarriers'])) echo "$('#requiredbarriers_" . $_POST['requiredbarriers'] . "').attr('checked', true);\n";
					if (isset($_POST['pitchsize'])) echo "$('#pitchsize_" . $_POST['pitchsize'] . "').attr('checked', true);\n";
					if (isset($_POST['complycodes'])) echo "$('#complycodes_" . $_POST['complycodes'] . "').attr('checked', true);\n";
					
					if (isset($_POST['remarks'])) echo "$('#remarks').val('" . mysql_escape_string($_POST['remarks']) . "');\n";
					if (isset($_POST['refappointedbyleague'])) echo "$('#refappointedbyleague').val('" . mysql_escape_string($_POST['refappointedbyleague']) . "').trigger('change');\n";
					if (isset($_POST['refereeid'])) echo "$('#refereeid').val('" . mysql_escape_string($_POST['refereeid']) . "');\n";
					if (isset($_POST['refereeid_lazy'])) echo "$('#refereeid_lazy').val('" . mysql_escape_string($_POST['refereeid_lazy']) . "');\n";
					if (isset($_POST['refereescore'])) echo "$('#refereescore').val('" . mysql_escape_string($_POST['refereescore']) . "');\n";
					if (isset($_POST['refereeremarks'])) echo "$('#refereeremarks').val('" . mysql_escape_string($_POST['refereeremarks']) . "');\n";
					
					if (isset($_POST['refereename'])) echo "$('#refereename').val('" . mysql_escape_string($_POST['refereename']) . "');\n";
					
					if (isset($_POST['signatureid'])) echo "$('#signatureid').val('" . mysql_escape_string($_POST['signatureid']) . "');\n";
					if (isset($_POST['name'])) echo "$('#name').val('" . mysql_escape_string($_POST['name']) . "');\n";
					if (isset($_POST['output'])) echo "$('#output').val('" . mysql_escape_string($_POST['output']) . "');\n";
?>
					
			      	$('.sigPad').signaturePad(
			      			{
			      				validateFields: false
			      			}
						);

			      	$("#refereescore").change(
					      	function() {
						      	$(this).val(new Number($(this).val()).toFixed(0));

						      	if ($(this).val() == "NaN") {
							      	$(this).val(0);
						      	}
						      	
						      	if ($(this).val() <= 60) {
							      	$(".badscore").show();
							      	
						      	} else {
							      	$("#refereeremarks").val("");
							      	$(".badscore").hide();
						      	}
					      	}
						);

					$("#name").trigger("blur");
<?php 
					if (isset($_POST['refereescore'])) echo "$('#refereescore').trigger('change');\n";

?>					
				}
			);
		
		function processorder() {
			$(".submitbutton").attr("disabled", true);
			
			setTimeout(
					function() {
						if (($("#opponentids_off").is(':checked') || 
							 $("#complycodes_off").is(':checked') ||
							 $("#pitchsize_off").is(':checked') ||
							 $("#requiredbarriers_off").is(':checked')) &&
							 $("#remarks").val() == "") {
			
							pwAlert("If NO to any of the above (or any other observations) please provide comments");
							$(".submitbutton").attr("disabled", false);

							return false;
						}
						
						if (($("#refereeid").val() == "0" || $("#refereeid").val() == "") && $("#refereename").val() == "") {
							pwAlert("If appointed by the League, the referee must be selected from the drop-down");
							$(".submitbutton").attr("disabled", false);

							return false;
						}
						
						if ($("#refereescore").val() == "") {
							pwAlert("Referee score must be specified");
							$(".submitbutton").attr("disabled", false);

							return false;
						}
						
						score = parseFloat($("#refereescore").val());
						score = parseInt(score);
			
						if (score < 0 || score > 100) {
							pwAlert("Referee score must be between 0 and 100");
							$(".submitbutton").attr("disabled", false);

							return false;
						}
			
						if (score <= 60 && $("#refereeremarks").val() == "") {
							pwAlert("A club awarding a mark of 60 or less must detail the reason(s) below");
							$(".submitbutton").attr("disabled", false);

							return false;
						}
						
						if ($("#name").val() == "") {
							pwAlert("Signature required");
							$(".submitbutton").attr("disabled", false);

							return false;
						}
						
						$("#orderform").submit();
					},
					0
				);
		}
		
		function prevPage() {
			$("#orderform").attr("action", "match.php");
			$("#orderform").submit();
		}
	</script>
</div>
<?php include("system-footer.php"); ?>

