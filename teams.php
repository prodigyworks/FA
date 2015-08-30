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
	$crud->sql = "SELECT A.*
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
				'label' 	 => 'Contact Number'
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
			)
		);
		
	$crud->run();
?>
