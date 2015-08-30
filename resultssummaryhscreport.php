<?php
	require_once('system-db.php');
	require_once('pdfreport.php');
	require_once("simple_html_dom.php");
	
	class MatchResultReport extends PDFReport {
		function AddPage($orientation='', $size='') {
			parent::AddPage($orientation, $size);
			
			$this->Image("images/logo_under12.png", 175.6, 1);
			
			$size = $this->addText( 10, 13, "Results summary - HSC", 12, 4, 'B') + 5;
			$this->SetFont('Arial','', 8);
				
			$cols = array( 
					"Age Group"  => 40,
					"Group"  => 30,
					"Home Team"  => 45,
					"Score"  => 15,
					"Away Team"  => 45,
					" Score "  => 15
				);
			
			$this->addCols($size, $cols);

			$cols = array(
					"Age Group"  => "L",
					"Group"  => "L",
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
					$and .= "AND A.matchdate >= '$startdate' ";
				}
				
				if ($enddate != "") {
					$and .= "AND A.matchdate <= '$enddate' ";
				}
				
				$sql = "SELECT A.*, B.age,
						DATE_FORMAT(A.matchdate, '%d/%m/%Y') AS matchdate
						FROM {$_SESSION['DB_PREFIX']}matchdetails A 
						INNER JOIN {$_SESSION['DB_PREFIX']}teamagegroup B
						ON B.id = A.hometeamid 
						WHERE B.age < 12 $and  
						ORDER BY A.matchdate, B.age, A.division, A.hometeam";
				$result = mysql_query($sql);
				
				$division = "";
				$agegroup = "";
				$matchdate = "";
				
				if ($result) {
					while (($member = mysql_fetch_assoc($result))) {
						if ($matchdate != $member['matchdate']) {
							$line=array(
                					"Age Group"  => "Match Date : " . $member['matchdate'],
                					"Group"  => " ",
									"Home Team"  => " ",
									"Score"  => " ",
									"Away Team"  => " ",
									" Score "  => " "
								);
								
							$this->addLine( $this->GetY() + 5, $line );
							$line=array(
                					"Age Group"  => " ",
                					"Group"  => " ",
									"Home Team"  => " ",
									"Score"  => " ",
									"Away Team"  => " ",
									" Score "  => " "
								);
								
							$this->addLine( $this->GetY(), $line);
							
							$matchdate = $member['matchdate'];
							$agegroup = "";
						}
						
					    $division = $member['division'];
					    
		    			if ($member['division'] == "X") {
                			if ($member['leaguecup'] == "L") {
                				$pdivision = "League";
                				
                			} else if ($member['leaguecup'] == "C") {
                				$pdivision = "Challenge Cup";
                				
                			} else if ($member['leaguecup'] == "N") {
                				$pdivision = "Combination";
                				
                			} else if ($member['leaguecup'] == "X") {
                				$pdivision = "Cup";
                				
                			} else if ($member['leaguecup'] == "T") {
                				$pdivision = "Challenge Trophy";
                			}

            			} else if ($member['division'] == "P") {
            				$pdivision = "Premier";
            				
            			} else if ($member['division'] == "1") {
            				$pdivision = "1";
            				
            			} else if ($member['division'] == "2") {
            				$pdivision = "2";
            				
            			} else if ($member['division'] == "3") {
            				$pdivision = "3";
            				
            			} else if ($member['division'] == "4") {
            				$pdivision = "4";
            				
            			} else if ($member['division'] == "5") {
            				$pdivision = "5";
            				
            			} else if ($member['division'] == "6") {
            				$pdivision = "6";
            				
            			} else if ($member['division'] == "A") {
            				$pdivision = "A";
            				
            			} else if ($member['division'] == "B") {
            				$pdivision = "B";
            				
            			} else if ($member['division'] == "C") {
            				$pdivision = "C";
            				
            			} else if ($member['division'] == "D") {
            				$pdivision = "D";
            				
            			} else if ($member['division'] == "E") {
            				$pdivision = "E";
            				
            			} else if ($member['division'] == "F") {
            				$pdivision = "F";
            				
            			} else if ($member['division'] == "G") {
            				$pdivision = "G";
            				
            			} else if ($member['division'] == "H") {
            				$pdivision = "H";
            			}

						$line=array(
            					"Age Group"  => "Under " . $member['age'],
            					"Group"  => $pdivision,
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