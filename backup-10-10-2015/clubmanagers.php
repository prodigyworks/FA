<?php
	require_once("crud.php");
	
	class TeamCrud extends Crud {
		
	}
	
	$teamid = $_GET['id'];
	
	$crud = new TeamCrud();
	$crud->dialogwidth = 650;
	$crud->title = "Club Managers";
	$crud->allowFilter = false;
	$crud->allowEdit = false;
	$crud->allowRemove = false;
	$crud->allowAdd = false;
	$crud->table = "{$_SESSION['DB_PREFIX']}members";
	$crud->sql = "SELECT A.*, B.name
				  FROM  {$_SESSION['DB_PREFIX']}members A
				  INNER JOIN  {$_SESSION['DB_PREFIX']}teamagegroup B
				  ON B.id = A.teamid
				  WHERE A.teamid = $teamid
				  ORDER BY A.firstname, A.lastname";
	
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
				'bind'       => false,
				'editable'   => false,
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

	$crud->run();
?>