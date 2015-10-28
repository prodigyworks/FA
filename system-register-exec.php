<?php
	//Include database connection details
	require_once('system-db.php');
	require_once('sqlfunctions.php');
	
	start_db();
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	//Sanitize the POST values
	$fname = mysql_real_escape_string($_POST['fname']);
	$lname = mysql_real_escape_string($_POST['lname']);
	$password = mysql_real_escape_string($_POST['password']);
	$cpassword = mysql_real_escape_string($_POST['cpassword']);
	$email = mysql_real_escape_string($_POST['email']);
	$landline = mysql_real_escape_string($_POST['telephone']);
	
	if (! isset($_GET['id'])) {
    	$teamid = mysql_real_escape_string($_POST['teamid']);
    	$clubid = mysql_real_escape_string($_POST['clubid']);
    	$cemail = mysql_real_escape_string($_POST['confirmemail']);
    	
    	try {
    		$imageid = getImageData("image", 100, 100);	
    		
    	} catch (Exception $e) {
    		$errmsg_arr[] = $e->getMessage();
    	}
	
		$login = mysql_real_escape_string($_POST['login']);

		if($login == '') {
			$errmsg_arr[] = 'Login ID missing';
			$errflag = true;
		}
		
    	if($password == '') {
    		$errmsg_arr[] = 'Password missing';
    		$errflag = true;
    	}
    	
    	if($cpassword == '') {
    		$errmsg_arr[] = 'Confirm password missing';
    		$errflag = true;
    	}
	
    	if( strcmp($email, $cemail) != 0 ) {
    		$errmsg_arr[] = 'Email addresses do not match';
    		$errflag = true;
    	}
	}
	
	//Input Validations
	if($fname == '') {
		$errmsg_arr[] = 'First name missing';
		$errflag = true;
	}
	if($lname == '') {
		$errmsg_arr[] = 'Last name missing';
		$errflag = true;
	}

	if( strcmp($password, $cpassword) != 0 ) {
		$errmsg_arr[] = 'Passwords do not match';
		$errflag = true;
	}
	
	$matches = null;
		
	$guid = uniqid();
	$memberid = 0;
	//If there are input validations, redirect back to the registration form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: " . $_SERVER['HTTP_REFERER']);
		exit();
	}
	
	if (! isset($_GET['id'])) {
		//Check for duplicate login ID
		if($login != '') {
			$qry = "SELECT * FROM {$_SESSION['DB_PREFIX']}members WHERE login='$login'";
			$result = mysql_query($qry);
			if($result) {
				if(mysql_num_rows($result) > 0) {
					$errmsg_arr[] = 'Login ID already in use';
					$errflag = true;
				}
				@mysql_free_result($result);
			}
		}
		
		$fullname = $fname . " " . $lname;
		
		//Create INSERT query
		$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}members " .
				"(firstname, lastname, fullname, login, passwd, email, imageid, accepted, guid, status, landline, clubid, teamid, metacreateddate, metacreateduserid, metamodifieddate, metamodifieduserid) " .
				"VALUES" .
				"('$fname','$lname', '$fullname', '$login', '".md5($_POST['password'])."', '$email', $imageid, 'Y', '$guid', 'Y', '$landline', $clubid, $teamid, NOW(), " . getLoggedOnMemberID() . ", NOW(), " .  getLoggedOnMemberID() . ")";
		$result = @mysql_query($qry);
		$memberid = mysql_insert_id();
		
		if (! $result) {
			logError("$qry - " . mysql_error());
		}
	
		//Create INSERT query
		$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}userroles(memberid, roleid, metacreateddate, metacreateduserid, metamodifieddate, metamodifieduserid) VALUES($memberid, 'PUBLIC', NOW(), " . getLoggedOnMemberID() . ", NOW(), " .  getLoggedOnMemberID() . ")";
		$result = @mysql_query($qry);
		$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}userroles(memberid, roleid, metacreateddate, metacreateduserid, metamodifieddate, metamodifieduserid) VALUES($memberid, 'USER', NOW(), " . getLoggedOnMemberID() . ", NOW(), " .  getLoggedOnMemberID() . ")";
		$result = @mysql_query($qry);
		
		if (isset($_POST['accounttype'])) {
			$accountrole = $_POST['accounttype'];

			$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}userroles(memberid, roleid, metacreateddate, metacreateduserid, metamodifieddate, metamodifieduserid) VALUES($memberid, '$accountrole', NOW(), " . getLoggedOnMemberID() . ", NOW(), " .  getLoggedOnMemberID() . ")";
			$result = @mysql_query($qry);
		}

		if ($teamid != 0) {
			$qry = "UPDATE {$_SESSION['DB_PREFIX']}teamagegroup SET 
					firstname = '$fname', 
					lastname = '$lname',
					telephone = '$landline',
					email = '$email',
					login = $memberid
					WHERE id = $teamid";
			$result = mysql_query($qry);
	
			if (! $result) {
				logError("UPDATE team failed ($qry):" . mysql_error());
			}
		}

		if ($clubid != 0) {
			$qry = "UPDATE {$_SESSION['DB_PREFIX']}team SET 
					firstname = '$fname', 
					lastname = '$lname',
					telephone = '$landline',
					email = '$email'
					WHERE id = $clubid";
			$result = mysql_query($qry);
	
			if (! $result) {
				logError("UPDATE team failed ($qry):" . mysql_error());
			}
		}
		
		mysql_query("COMMIT");
		
		sendUserMessage(getLoggedOnMemberID(), "User Registration", "User " . $_POST['login'] . " has been registered as a user.<br>Password : " . $_POST['password']);
		sendUserMessage($memberid, "User Registration", "<h3>Welcome " . $_POST['fname'] . " " . $_POST['lname'] . ".</h3><br>You have been invited to become a member of 'Harrow Youth Football League'.<br>Please click on the <a href='" . getSiteConfigData()->domainurl . "/index.php'>link</a> to activate your account.<br><br><h4>Login details</h4>User ID : " . $_POST['login'] . "<br>Password : " . $_POST['password']);
		
		if($result) {
			header("location: system-register-success.php");
	
		} else {
			logError("1 Query failed:" . mysql_error());
		}
			
	} else {
		$memberid = $_GET['id'];
		$qry = "UPDATE {$_SESSION['DB_PREFIX']}members 
				SET email = '$email', 
				landline = '$landline', 
				firstname = '$fname', 
				lastname = '$lname', 
				lastaccessdate = NOW() ";
				
	    if ($password != "") {
			$qry .= ", passwd = '" . md5($password) . "' ";
	    }
			
		$qry .= "WHERE member_id = $memberid";
		
		$result = mysql_query($qry);

		if (! $result) {
			logError("UPDATE members failed:" . mysql_error());
		}
		
		$_SESSION['SESS_FIRST_NAME'] = $fname;
		$_SESSION['SESS_LAST_NAME'] = $lname;
		
		sendUserMessage(getLoggedOnMemberID(), "User Amendment", "<h3>User amendment.</h3><br>Your details have been amended.<br>");

		header("location: system-register-amend.php");
	}
	
	//Check whether the query was successful or not
?>