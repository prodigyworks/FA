<?php 
	include("system-header.php"); 
	showErrors(); 
?>
<h4>Member Details</h4>
<!--  Start of content -->
<?php
	$memberid =  $_SESSION['SESS_MEMBER_ID'];
	
	if (isset($_GET['id'])) {
		global $memberid;
		
		$memberid = $_GET['id'];
	}
	
	$qry = "SELECT A.* " .
			"FROM {$_SESSION['DB_PREFIX']}members A " .
			"WHERE A.member_id = $memberid ";
	$result = mysql_query($qry);

	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			
?>
	<form id="loginForm" class="manualform" enctype="multipart/form-data" name="loginForm" method="post" action="system-register-exec.php?id=<?php echo $memberid; ?>">
	  <table border="0" align="left" width='100%'>
	    <tr>
	      <td>First Name </td>
	      <td><input required="true" name="fname" type="text" class="textfield" id="fname" value="<?php echo $member['firstname']; ?>" /></td>
	    </tr>
	    <tr>
	      <td>Last Name </td>
	      <td><input required="true" name="lname" type="text" class="textfield" id="lname" value="<?php echo $member['lastname']; ?>" /></td>
	    </tr>
	    <tr>
	      <td>Email</td>
	      <td>
	      	<input required="true" name="email" type="text" class="textfield60" id="email"  value="<?php echo $member['email']; ?>" />
	      	<input name="confirmemail" type="hidden" class="textfield60" id="confirmemail" />
	      </td>
	    </tr>
	    <tr>
	      <td>Telephone</td>
	      <td>
	      	<input name="telephone" type="text" class="textfield" id="telephone"  value="<?php echo $member['landline']; ?>" />
	      </td>
	    </tr>
	    <tr>
	    	<td colspan="2">
	    		<br />
	    		<h4>Security</h4>
	    		<hr />
	    	</td>
	    </tr>
	    <tr>
	      <td>Password</td>
	      <td><input name="password" class="pwd" type="password" class="textfield" id="password" /></td>
	    </tr>
	    <tr>
	      <td>Confirm Password </td>
	      <td><input name="cpassword" type="password" class="textfield" id="cpassword" /></td>
	    </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td>
		  	<span class="wrapper"><a class='link1' href="javascript:if (verify()) $('#loginForm').submit();"><em><b>Update</b></em></a></span>
	      </td>
	    </tr>
	  </table>
	  <script>
	  $(document).ready(
			function() {
<?php
	if (($memberid != $_SESSION['SESS_MEMBER_ID']) && ! isUserInRole("ADMIN")) {
?>
				$("#fname").attr("disabled", true);
				$("#lname").attr("disabled", true);
				$("#email").attr("disabled", true);
				
<?php
	}
?>	
				$(".pwd").blur(verifypassword);
				$("#cpassword").blur(verifycpassword);
				$("#fname").focus();
			});
	
	function verify() {
		var isValid = verifyStandardForm('#loginForm');
		
		if (! verifypassword()) {
			isValid = false;
		}
		
		if (! verifycpassword()) {
			isValid = false;
		}
		
		return isValid;
	}
	
	function verifypassword() {
		var node = $(".pwd");
		var str = $(node).val();
		
		return true;
	}
	
	function verifycpassword() {
		var node = $("#cpassword");
		var str = $(node).val();
		
		if( str == $(".pwd").val()) {
			$(node).removeClass("invalid");
			$(node).next().css("visibility", "hidden");
			$(node).next().attr("title", "Required field.");
			
			return true;
			
		} else {
			$(node).addClass("invalid");
			$(node).next().css("visibility", "visible");
			$(node).next().attr("title", "Passwords do not match.");
			
			return false;
		}
	}
</script>
</form>
<?php
		}
	}
			
?>
<!--  End of content -->

<?php include("system-footer.php"); ?>
