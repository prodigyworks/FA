<?php
	require_once('system-db.php');
	require_once('pdfreport.php');
	require_once("simple_html_dom.php");
	
	class RefereeReport extends PDFReport {
		function newPage() {
			$this->Image("images/logomain2.png", 235.6, 1);
			
			$size = $this->addText( 10, 13, "Comments Made Report", 12, 4, 'B') + 5;
			$this->SetFont('Arial','', 8);
				
			$cols = array( 
					"Date of Match"  => 24,
					"Age Group"  => 24,
					"Division"  => 20,
					"Reported By"  => 45,
					"Match ID"  => 15,
					"Comments"  => 149
				);
			
			$this->addCols($size, $cols);

			$cols = array(
					"Date of Match"  => "L",
					"Age Group"  => "L",
					"Division"  => "L",
					"Reported By"  => "L",
					"Match ID"  => "L",
					"Comments"  => "L"
				);
			$this->addLineFormat( $cols);
			$this->SetY(30);
		}
		
		function AddPage($orientation='', $size='') {
			parent::AddPage($orientation, $size);
			
			$this->newPage();
		}
		
		function __construct($orientation, $metric, $size, $startdate, $enddate) {
			$dynamicY = 0;
			
	        parent::__construct($orientation, $metric, $size);
	        
	        $this->SetAutoPageBreak(true, 30);
	        
			$this->AddPage();
			
			try {
				$and = "";
				
				if ($startdate != "") {
					$and .= " AND A.matchdate >= '$startdate'  ";
				}
				
				if ($enddate != "") {
					$and .= " AND A.matchdate <= '$enddate'  ";
				}
				
				$sql = "SELECT A.*, DATE_FORMAT(A.matchdate, '%d/%m/%Y') AS matchdate,
					    B.name AS refereeename,
					    C.age, C.name AS teamname
						FROM {$_SESSION['DB_PREFIX']}matchdetails A 
						LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}referee B 
						ON B.id = A.refereeid 
						LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}teamagegroup C 
						ON C.id = A.teamid 
						WHERE (A.remarks IS NOT NULL AND A.remarks != '') $and
						ORDER BY A.matchdate";
				$result = mysql_query($sql);
				
				if ($result) {
					while (($member = mysql_fetch_assoc($result))) {
						$line=array(
								"Date of Match"  => $member['matchdate'],
								"Age Group"  => "Under " . $member['age'],
								"Division"  => $member['division'],
								"Reported By"  => $member['teamname'],
								"Match ID"  => $member['id'],
								"Comments"  => $member['remarks']
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
	
	$pdf = new RefereeReport( 'L', 'mm', 'A4', convertStringToDate($_POST['fromdate']), convertStringToDate($_POST['todate']));
	$pdf->Output();
?>