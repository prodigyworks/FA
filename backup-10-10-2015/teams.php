<?php
	require_once("crud.php");
	
	class TeamCrud extends Crud {
		
		/* Post header event. */
		public function postHeaderEvent() {
			createDocumentLink();
		}
		
		public function postScriptEvent() {
?>
			function editDocuments(node) {
				viewDocument(node, "addteamdocument.php", node, "teamdocs", "teamid");
			}
<?php			
		}
	}
	
	$crud = new TeamCrud();
	$crud->dialogwidth = 650;
	$crud->title = "Clubs";
	$crud->allowFilter = false;
	$crud->allowEdit = isUserInRole("ADMIN");
	$crud->allowRemove = isUserInRole("ADMIN");
	$crud->allowAdd = isUserInRole("ADMIN");
	$crud->table = "{$_SESSION['DB_PREFIX']}team";
	$crud->sql = "SELECT A.*, 
				 (SELECT B.fullname FROM {$_SESSION['DB_PREFIX']}members B WHERE B.clubid = A.id ORDER BY member_id LIMIT 1) AS fullname,
				 (SELECT C.email FROM {$_SESSION['DB_PREFIX']}members C WHERE C.clubid = A.id ORDER BY member_id LIMIT 1) AS email,
				 (SELECT D.landline FROM {$_SESSION['DB_PREFIX']}members D WHERE D.clubid = A.id ORDER BY member_id LIMIT 1) AS telephone
				  FROM  {$_SESSION['DB_PREFIX']}team A
				  ORDER BY A.name";
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
				'name'       => 'name',
				'length' 	 => 30,
				'label' 	 => 'Name'
			),
			array(
				'name'       => 'fullname',
				'length' 	 => 25,
				'readonly'	 => true,
				'required'	 => false,
				'bind'		 => false,
				'label' 	 => 'Secretary'
			),
			array(
				'name'       => 'email',
				'bind'		 => false,
				'length' 	 => 35,
				'readonly'	 => true,
				'required'	 => false,
				'label' 	 => 'Email'
			),
			array(
				'name'       => 'telephone',
				'length' 	 => 14,
				'bind'		 => false,
				'readonly'	 => true,
				'required'	 => false,
				'label' 	 => 'Telephone'
			)
			);


	$crud->subapplications = array(
			array(
				'title'		  => 'Documents',
				'imageurl'	  => 'images/document.gif',
				'script' 	  => 'editDocuments'
			),
			array(
				'title'		  => 'Teams',
				'imageurl'	  => 'images/team.png',
				'application' => 'levels.php'
			),
			array(
				'title'		  => 'Secretaries',
				'imageurl'	  => 'images/team.png',
				'application' => 'clubsecretaries.php'
			)
		);
		
	$crud->run();
?>

?>
