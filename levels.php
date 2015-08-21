<?php
	require_once("system-db.php");
	require_once("crud.php");
	
	start_db();
	
	class TeamCrud extends Crud {
		
		/* Post header event. */
		public function postHeaderEvent() {
			createDocumentLink();
		}
		
		public function postAddScriptEvent() {
?>
			$("#editpanel #name").val("<?php echo getLoggedOnClubName(); ?>");
<?php			
		}
		
		public function postScriptEvent() {
?>
			function age_onchange() {
				$("#editpanel #name").val("<?php echo getLoggedOnClubName(); ?> U" + $("#age").val());
			}
			
			function login(node) {
				callAjax(
						"finddata.php", 
						{ 
							sql: "SELECT login FROM <?php echo $_SESSION['DB_PREFIX'];?>teamagegroup WHERE id = " + node
						},
						function(data) {
							if (data.length == 1 && data[0].login != null) {
								window.location.href = "autologin.php?login=" + data[0].login;
							}
						}
					);				
			}
		
			function editDocuments(node) {
				viewDocument(node, "addleveldocument.php", node, "teamagegroupdocs", "agegroupid");
			}
	
<?php			
		}
	}
	
	$crud = new TeamCrud();
	
	if (isset($_GET['id'])) {
		$teamid = $_GET['id'];
		$crud->sql = "SELECT A.*, C.name AS clubname
					  FROM  {$_SESSION['DB_PREFIX']}teamagegroup A
					  INNER JOIN {$_SESSION['DB_PREFIX']}team C
					  ON C.id = A.teamid
					  WHERE A.teamid = $teamid
					  ORDER BY A.age";
		
	} else if (isUserInRole("SECRETARY")) {
		$clubid = getLoggedOnClubID();
		$crud->sql = "SELECT A.*, C.name AS clubname
					  FROM  {$_SESSION['DB_PREFIX']}teamagegroup A
					  INNER JOIN {$_SESSION['DB_PREFIX']}team C
					  ON C.id = A.teamid
					  WHERE A.teamid = $clubid
					  ORDER BY A.age";
		
	} else {
		$teamid = getLoggedOnTeamID();
		$crud->sql = "SELECT A.*, C.name AS clubname
					  FROM  {$_SESSION['DB_PREFIX']}teamagegroup A
					  INNER JOIN {$_SESSION['DB_PREFIX']}team C
					  ON C.id = A.teamid
					  WHERE A.id = $teamid
					  ORDER BY A.age";
	}
	
	$crud->dialogwidth = 450;
	$crud->allowFilter = false;
	$crud->allowAdd = false;
	$crud->allowEdit = false;
	$crud->allowRemove = isUserInRole("ADMIN");
	$crud->title = "Teams";
	$crud->table = "{$_SESSION['DB_PREFIX']}teamagegroup";
	$crud->columns = array(
			array(
				'name'       => 'id',
				'viewname'   => 'uniqueid',
				'length' 	 => 6,
				'showInView' => false,
				'filter'	 => false,
				'bind' 	 	 => false,
				'editable' 	 => false,
				'pk'		 => true,
				'label' 	 => 'ID'
			),
			array(
				'name'       => 'clubname',
				'length' 	 => 28,
				'editable'	 => false,
				'bind'		 => false,
				'label' 	 => 'Club'
			),			
			array(
				'name'       => 'name',
				'length' 	 => 28,
				'label' 	 => 'Team'
			),			
			array(
				'name'       => 'teamid',
				'length' 	 => 28,
				'default'	 => getLoggedOnClubID(),
				'label' 	 => 'Team',
				'showInView' => false,
				'editable'	 => false
			),			
			array(
				'name'       => 'age',
				'type'		 => 'COMBO',
				'onchange'	 => 'age_onchange',
				'options'    => array(
						array(
							'value'		=> '7',
							'text'		=> 'Under 7'
						),
						array(
							'value'		=> '8',
							'text'		=> 'Under 8'
						),
						array(
							'value'		=> '9',
							'text'		=> 'Under 9'
						),
						array(
							'value'		=> '10',
							'text'		=> 'Under 10'
						),
						array(
							'value'		=> '11',
							'text'		=> 'Under 11'
						),
						array(
							'value'		=> '12',
							'text'		=> 'Under 12'
						),
						array(
							'value'		=> '13',
							'text'		=> 'Under 13'
						),
						array(
							'value'		=> '14',
							'text'		=> 'Under 14'
						),
						array(
							'value'		=> '15',
							'text'		=> 'Under 15'
						),
						array(
							'value'		=> '16',
							'text'		=> 'Under 16'
						),
						array(
							'value'		=> '17',
							'text'		=> 'Under 17'
						),
						array(
							'value'		=> '18',
							'text'		=> 'Under 18'
						)
					),
				'length' 	 => 15,
				'label' 	 => 'Age Group'
			),
			array(
				'name'       => 'firstname',
				'length' 	 => 15,
				'label' 	 => 'First Name'
			),			
			array(
				'name'       => 'lastname',
				'length' 	 => 15,
				'label' 	 => 'Last Name'
			),			
			array(
				'name'       => 'email',
				'length' 	 => 40,
				'label' 	 => 'Email'
			),
			array(
				'name'       => 'telephone',
				'length' 	 => 12,
				'label' 	 => 'Telephone'
			)
		);

	$crud->subapplications = array(
			array(
				'title'		  => 'Players',
				'imageurl'	  => 'images/team.png',
				'application' => 'players.php'
			),
			array(
				'title'		  => 'Log In',
				'imageurl'	  => 'images/lock.png',
				'script' 	  => 'login'
			)
		);
		
	$crud->run();
?>
