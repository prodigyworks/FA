<?php
	require_once("crud.php");
	
	class MatchCrud extends Crud {
		
		/* Post header event. */
		public function postHeaderEvent() {
			createDocumentLink();
		}
		
		public function postScriptEvent() {
?>
			
			function editDocuments(node) {
				viewDocument(node, "addmatchdocument.php", node, "matchdocs", "matchid");
			}
			
			function reportCard(node) {
				window.open("matchcard.php?id=" + node);
			}
	
<?php			
		}
	}
	
	$crud = new MatchCrud();
	$crud->dialogwidth = 760;
	$crud->title = "Match Details";
	$crud->allowAdd = false;
	$crud->allowEdit = false;
	$crud->allowRemove = false;
	$crud->table = "{$_SESSION['DB_PREFIX']}matchdetails";
	
	if (isUserInRole("ADMIN")) {
		$crud->sql = "SELECT A.*, A.id AS uniqueid,
					  B.name AS refereename, 
					  C.name AS submittedteamname, 
					  D.name AS oppositionname,
					  E.name AS agegroupname, E.age
					  FROM  {$_SESSION['DB_PREFIX']}matchdetails A
					  LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}referee B
					  ON B.id = A.refereeid
					  LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}team C
					  ON C.id = A.teamid
					  LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}team D
					  ON D.id = A.oppositionid
					  LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}teamagegroup E
					  ON E.id = A.agegroupid
					  ORDER BY A.id DESC";
		
	} else {
		$teamid = getLoggedOnTeamID();
		$crud->allowAdd = false;
		$crud->allowEdit = false;
		$crud->allowRemove = false;
		$crud->sql = "SELECT A.*, A.id AS uniqueid,
					  B.name AS refereename, 
					  C.name AS submittedteamname, 
					  D.name AS oppositionname,
					  E.name AS agegroupname, E.age
					  FROM  {$_SESSION['DB_PREFIX']}matchdetails A
					  LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}referee B
					  ON B.id = A.refereeid
					  LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}team C
					  ON C.id = A.teamid
					  LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}team D
					  ON D.id = A.oppositionid
					  LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}teamagegroup E
					  ON E.id = A.agegroupid
					  WHERE A.teamid = $teamid;
					  ORDER BY A.id DESC";
	}
	
	$crud->columns = array(
			array(
				'name'       => 'matchdate',
				'length' 	 => 12,
				'datetype'	 => 'date',
				'label' 	 => 'Match Date'
			),		
			array(
				'name'       => 'agegroupid',
				'type'       => 'DATACOMBO',
				'length' 	 => 18,
				'label' 	 => 'Age Group',
				'table'		 => 'teamagegroup',
				'required'	 => true,
				'table_id'	 => 'id',
				'sortcolumn' => 'E.age',
				'alias'		 => 'agegroupname',
				'table_name' => 'name'
			),
			array(
				'name'       => 'division',
				'length' 	 => 17,
				'label' 	 => 'Division / Group',
				'type'       => 'COMBO',
				'options'    => array(
						array(
							'value'		=> 'X',
							'text'		=> 'N/A'
						),
						array(
							'value'		=> '1',
							'text'		=> 'League 1'
						),
						array(
							'value'		=> 'P',
							'text'		=> 'Premier'
						),
						array(
							'value'		=> '2',
							'text'		=> 'League 2'
						),
						array(
							'value'		=> '3',
							'text'		=> 'League 3'
						),
						array(
							'value'		=> '4',
							'text'		=> 'League 4'
						),
						array(
							'value'		=> '5',
							'text'		=> 'League 5'
						),
						array(
							'value'		=> '6',
							'text'		=> 'League 6'
						),
						array(
							'value'		=> 'A',
							'text'		=> 'A'
						),
						array(
							'value'		=> 'B',
							'text'		=> 'B'
						),
						array(
							'value'		=> 'C',
							'text'		=> 'C'
						),
						array(
							'value'		=> 'D',
							'text'		=> 'D'
						),
						array(
							'value'		=> 'E',
							'text'		=> 'E'
						),
						array(
							'value'		=> 'F',
							'text'		=> 'F'
						),
						array(
							'value'		=> 'G',
							'text'		=> 'G'
						),
						array(
							'value'		=> 'H',
							'text'		=> 'H'
						)
					)
			),
			array(
				'name'       => 'leaguecup',
				'length' 	 => 15,
				'label' 	 => 'League / Cup',
				'type'       => 'COMBO',
				'options'    => array(
						array(
							'value'		=> 'L',
							'text'		=> 'League'
						),
						array(
							'value'		=> 'N',
							'text'		=> 'Combination'
						),
						array(
							'value'		=> 'C',
							'text'		=> 'Challenge Cup',
						),
						array(
							'value'		=> 'T',
							'text'		=> 'Challenge Trophy'
						)
					)
			),
			array(
				'name'       => 'hometeam',
				'length' 	 => 20,
				'label' 	 => 'Home Team'
			),
			array(
				'name'       => 'hometeamscore',
				'length' 	 => 12,
				'align'		 => 'center',
				'label' 	 => 'Score'
			),			
			array(
				'name'       => 'opposition',
				'length' 	 => 20,
				'label' 	 => 'Away Team'
			),
			array(
				'name'       => 'awayteamscore',
				'length' 	 => 12,
				'align'		 => 'center',
				'label' 	 => 'Score'
			),			
			array(
				'name'       => 'uniqueid',
				'length' 	 => 12,
				'filter'	 => false,
				'bind' 	 	 => false,
				'editable' 	 => false,
				'pk'		 => true,
				'label' 	 => 'ID'
			),
			array(
				'name'       => 'teamid',
				'type'       => 'DATACOMBO',
				'length' 	 => 18,
				'label' 	 => 'Submitted By Team',
				'table'		 => 'team',
				'required'	 => true,
				'table_id'	 => 'id',
				'alias'		 => 'submittedteamname',
				'table_name' => 'name'
			),
			array(
				'name'       => 'remarks',
				'type'		 => 'BASICTEXTAREA',
				'showInView' => false,
				'label' 	 => 'Remarks'
			)
		);

	$crud->subapplications = array(
			array(
				'title'		  => 'Documents',
				'imageurl'	  => 'images/document.gif',
				'script' 	  => 'editDocuments'
			),
			array(
				'title'		  => 'Match Card',
				'imageurl'	  => 'images/print.png',
				'script' 	  => 'reportCard'
			)
		);
		
	$crud->run();
?>
