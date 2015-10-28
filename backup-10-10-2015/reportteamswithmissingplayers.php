<?php
	require_once('system-db.php');
	require_once('pdfreport.php');
	require_once("simple_html_dom.php");
	
	class MissingTeamReport extends PDFReport {
		function newPage() {
			$this->Image("images/logomain2.png", 135.6, 1);
			
			$size = $this->addText( 10, 13, "Teams with No Players added", 12, 4, 'B') + 5;
			$this->SetFont('Arial','', 8);
				
			$cols = array( 
					"Club"  => 65,
					"Team"  => 125
				);
			
			$this->addCols($size, $cols);

			$cols = array(
					"Club"  => "L",
					"Team"  => "L"
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
				$sql = "SELECT A.name, B.name AS clubname
						FROM {$_SESSION['DB_PREFIX']}teamagegroup A 
						INNER JOIN {$_SESSION['DB_PREFIX']}team B 
						ON B.id = A.teamid 
						WHERE A.id NOT IN (SELECT C.agegroupid FROM {$_SESSION['DB_PREFIX']}player C)
						ORDER BY A.name, B.name";
				$result = mysql_query($sql);
				
				if ($result) {
				
					while (($member = mysql_fetch_assoc($result))) {
					
						$line=array(
								"Club"  => $member['clubname'],
								"Team"  => $member['name']
							);
							
						if ($this->GetY() > 265) {
							$this->AddPage();
						}
							
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
	
	$pdf = new MissingTeamReport( 'P', 'mm', 'A4');
	$pdf->Output();
?>