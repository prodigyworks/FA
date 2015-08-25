<?php include("system-header.php"); ?>
<h4>Referee Negative Answers</h4>
<form method="POST" action="reportcommentsmadelib.php" class="entryform" target="_new">
	<table cellspacing=10>
		<tr>
			<td>
				From Date
			</td>
			<td>
				<input type="text" class="datepicker" id="fromdate" name="fromdate" />
			</td>
		</tr>
		<tr>
			<td>
				To Date
			</td>
			<td>
				<input type="text" class="datepicker" id="todate" name="todate" />
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type="submit" />
			</td>
		</tr>
	</table>
</form>
<?php include("system-footer.php"); ?>
