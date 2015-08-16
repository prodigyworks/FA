<?php
	require_once("crud.php");
	
	class MatchCrud extends Crud {
		
		/* Post header event. */
		public function postHeaderEvent() {
			createDocumentLink();
		}
		
		public function postScriptEvent() {
?>

			function ageReference(node) {
				return "Under " + node.age;
			}
			
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
	$crud->allowFilter = false;
	$crud->allowView = false;
	$crud->table = "{$_SESSION['DB_PREFIX']}matchdetails";
	
	if (isUserInRole("ADMIN")) {
		$crud->sql = "SELECT A.*, A.id AS uniqueid,
					  B.name AS refereename, C.age,
					  C.name AS submittedteamname
					  FROM  {$_SESSION['DB_PREFIX']}matchdetails A
					  LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}referee B
					  ON B.id = A.refereeid
					  LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}teamagegroup C
					  ON C.id = A.teamid
					  ORDER BY A.id DESC";
		
	} else if (isUserInRole("SECRETARY")) {
		$clubid = getLoggedOnClubID();
		$crud->allowAdd = false;
		$crud->allowEdit = false;
		$crud->allowRemove = false;
		$crud->sql = "SELECT A.*, A.id AS uniqueid,
					  B.name AS refereename, C.age,
					  C.name AS submittedteamname
					  FROM  {$_SESSION['DB_PREFIX']}matchdetails A
					  LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}referee B
					  ON B.id = A.refereeid
					  LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}teamagegroup C
					  ON C.id = A.teamid
					  WHERE C.teamid = $clubid;
					  ORDER BY A.id DESC";
		
	} else {
		$teamid = getLoggedOnTeamID();
		$crud->allowAdd = false;
		$crud->allowEdit = false;
		$crud->allowRemove = false;
		$crud->sql = "SELECT A.*, A.id AS uniqueid,
					  B.name AS refereename, C.age,
					  C.name AS submittedteamname
					  FROM  {$_SESSION['DB_PREFIX']}matchdetails A
					  LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}referee B
					  ON B.id = A.refereeid
					  LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}teamagegroup C
					  ON C.id = A.teamid
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
				'name'       => 'ageref',
				'function'   => 'ageReference',
				'sortcolumn' => 'C.age',
				'type'		 => 'DERIVED',
				'length' 	 => 10,
				'editable'	 => false,
				'bind' 	 	 => false,
				'filter'	 => false,
				'label' 	 => 'Age Group'
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
							'value'		=> 'P',
							'text'		=> 'Premier'
						),
						array(
							'value'		=> '1',
							'text'		=> '1'
						),
						array(
							'value'		=> '2',
							'text'		=> '2'
						),
						array(
							'value'		=> '3',
							'text'		=> '3'
						),
						array(
							'value'		=> '4',
							'text'		=> '4'
						),
						array(
							'value'		=> '5',
							'text'		=> '5'
						),
						array(
							'value'		=> '6',
							'text'		=> '6'
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
				'label' 	 => 'Competition',
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
				'length' 	 => 28,
				'label' 	 => 'Home Team'
			),
			array(
				'name'       => 'hometeamscore',
				'length' 	 => 5,
				'align'		 => 'center',
				'label' 	 => 'Score'
			),			
			array(
				'name'       => 'opposition',
				'length' 	 => 28,
				'label' 	 => 'Away Team'
			),
			array(
				'name'       => 'awayteamscore',
				'length' 	 => 5,
				'align'		 => 'center',
				'label' 	 => 'Score'
			),			
			array(
				'name'       => 'uniqueid',
				'length' 	 => 5,
				'filter'	 => false,
				'bind' 	 	 => false,
				'editable' 	 => false,
				'pk'		 => true,
				'label' 	 => 'ID'
			),
			array(
				'name'       => 'teamid',
				'type'       => 'DATACOMBO',
				'length' 	 => 28,
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
				'title'		  => 'Match Result Form',
				'imageurl'	  => 'images/print.png',
				'script' 	  => 'reportCard'
			)
		);
		
	$crud->run();
?>
