<?php
	require_once("system-header.php");
	
	logout();
?>
<script>
	$(document).ready(
			function() {
				pwAlert("The system has timed out. Press the Ok button to log back in");

				$(".ui-button").click(
						function() {
							window.location.href = "system-login.php";
						}
					);
			}
		);
</script>
<?php
	require_once("system-footer.php");
?>
