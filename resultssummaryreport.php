<?php
	require_once('system-db.php');
	require_once('pdfreport.php');
	require_once("simple_html_dom.php");
	
	class MatchResultReport extends PDFReport {
		function AddPage($orientation='', $size='') {
			parent::AddPage($orientation, $size);
			
			$this->Image("images/logomain2.png", 175.6, 1);
			
			$size = $this->addText( 10, 13, "Results summary – HYFL", 12, 4, 'B') + 5;
			$this->SetFont('Arial','', 6);
				
			$cols = array( 
					"Home Team"  => 65,
					"Score"  => 30,
					"Away Team"  => 65,
					" Score "  => 30
				);
			
			$this->addCols($size, $cols);

			$cols = array(
					"Home Team"  => "L",
					"Score"  => "C",
					"Away Team"  => "L",
					" Score "  => "C"
				);
			$this->addLineFormat( $cols);
			$this->SetY(30);
		}
		
		function __construct($orientation, $metric, $size, $startdate, $enddate) {
			$dynamicY = 0;
			
	        parent::__construct($orientation, $metric, $size);
	        
	        $this->SetAutoPageBreak(true, 30);
	        
			$this->AddPage();
			
			try {
				$and = "";
				
				if ($startdate != "") {
					$and = "AND A.matchdate >= '$startdate' ";
				}
				
				if ($enddate != "") {
					$and = "AND A.matchdate <= '$enddate' ";
				}
				
				$sql = "SELECT A.*, B.age,
						DATE_FORMAT(A.matchdate, '%d/%m/%Y') AS matchdate
						FROM {$_SESSION['DB_PREFIX']}matchdetails A 
						INNER JOIN {$_SESSION['DB_PREFIX']}teamagegroup B
						ON B.id = A.hometeamid 
						WHERE 1 = 1 $and  
						ORDER BY A.matchdate, B.age, A.division, A.hometeam";
				$result = mysql_query($sql);
				
				$division = "";
				$agegroup = "";
				$matchdate = "";
				
				if ($result) {
					while (($member = mysql_fetch_assoc($result))) {
						if ($matchdate != $member['matchdate']) {
							$line=array(
									"Home Team"  => "Match Date : " . $member['matchdate'],
									"Score"  => " ",
									"Away Team"  => " ",
									" Score "  => " "
								);
								
							$this->addLine( $this->GetY() + 5, $line );
							
							$matchdate = $member['matchdate'];
							$agegroup = "";
						}
						
						if ($agegroup != $member['age']) {
							$line=array(
									"Home Team"  => "Age Group : Under " . $member['age'],
									"Score"  => " ",
									"Away Team"  => " ",
									" Score "  => " "
								);
								
							$this->addLine( $this->GetY() + 2, $line );
							
							$agegroup = $member['age'];
							$division = "";
						}
						
						if ($division != $member['division']) {
							$line=array(
									"Home Team"  => "Division : " . $member['division'],
									"Score"  => " ",
									"Away Team"  => " ",
									" Score "  => " "
								);
								
							$this->addLine( $this->GetY() + 2, $line );
							
							$division = $member['division'];
							
							$line=array(
									"Home Team"  => " ",
									"Score"  => " ",
									"Away Team"  => " ",
									" Score "  => " "
								);
								
							$this->addLine( $this->GetY(), $line );
						}
						
						$line=array(
								"Home Team"  => $member['hometeam'],
								"Score"  => $member['hometeamscore'],
								"Away Team"  => $member['opposition'],
								" Score "  => $member['awayteamscore']
							);
							
						$this->addLine( $this->GetY(), $line );
					}
					
				} else {
					logError($sql . " - " . mysql_error());
				}
				
			} catch (Exception $e) {
				logError($e->getMessage());
			}
		}
	}
	
	start_db();
	
	$pdf = new MatchResultReport( 'P', 'mm', 'A4', convertStringToDate($_POST['datefrom']), convertStringToDate($_POST['dateto']));
	$pdf->Output();
?>