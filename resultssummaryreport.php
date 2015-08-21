<?php
	require_once('system-db.php');
	require_once('pdfreport.php');
	require_once("simple_html_dom.php");
	
	class MatchResultReport extends PDFReport {
		function AddPage($orientation='', $size='') {
			parent::AddPage($orientation, $size);
			
			$this->Image("images/logomain2.png", 245.6, 1);
			$this->Image("images/footer.png", 134, 190);
			
			$size = $this->addText( 10, 13, "Results summary – HYFL", 12, 4, 'B') + 5;
			$this->SetFont('Arial','', 6);
				
			$cols = array( 
					"Home Team"  => 93,
					"Score"  => 35,
					"Away Team"  => 35,
					" Score "  => 49
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
		
		function __construct($orientation, $metric, $size, $startdate, $enddate, $userid) {
			$dynamicY = 0;
			
	        parent::__construct($orientation, $metric, $size);
	        
	        $this->SetAutoPageBreak(true, 30);
	        
			$this->AddPage();
			
			try {
				$and = "";
				
				if ($startdate != "") {
				}
				
				if ($enddate != "") {
				}
				
				if ($userid != "0") {
					$and .= " AND A.takenbyid = $userid   ";
				}
				
				$sql = "SELECT A.*, 
						DATE_FORMAT(A.matchdate, '%d/%m/%Y') AS matchdate
						FROM {$_SESSION['DB_PREFIX']}matchdetails A 
						LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}customer B 
						ON B.id = A.customerid 
						LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}members C 
						ON C.member_id = A.takenbyid 
						WHERE A.metacreateddate >= '$startdate' 
						AND A.metacreateddate <= '$enddate 23:59:59' 
						WHERE 1 = 1 $and  
						ORDER BY B.name, A.metacreateddate";
				$result = mysql_query($sql);
				
				if ($result) {
					while (($member = mysql_fetch_assoc($result))) {
						$line=array(
								"Customer"  => $member['customername'],
								"Customer Code"  => $member['accountnumber'],
								"Quotation Number"  => getSiteConfigData()->bookingprefix . "-" . sprintf("%06d", $member['id']),
								"User"  => $member['fullname'],
								"Quotation Date"  => $member['metacreateddate'],
								"Value"  => number_format($member['total'], 2)
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
	
	$pdf = new MatchResultReport( 'L', 'mm', 'A4', convertStringToDate($_POST['datefrom']), convertStringToDate($_POST['dateto']));
	$pdf->Output();
?>