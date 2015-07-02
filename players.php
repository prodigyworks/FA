<?php
	require_once("crud.php");
	
	class PlayerCrud extends Crud {
		
		/* Post header event. */
		public function postHeaderEvent() {
			createDocumentLink();
		}
		
		public function postScriptEvent() {
?>
			function editDocuments(node) {
				viewDocument(node, "addcustomerdocument.php", node, "customerdocs", "customerid");
			}
	
			/* Derived  address callback. */
			function fullInvoiceAddress(node) {
				var address = "";
				
				if ((node.address1) != "") {
					address = address + node.address1;
				} 
				
				if ((node.address2) != "") {
					if (address != "") {
						address = address + ", ";
					}
					
					address = address + node.address2;
				} 
				
				if ((node.address3) != "") {
					if (address != "") {
						address = address + ", ";
					}
					
					address = address + node.address3;
				} 
				
				if ((node.city) != "") {
					if (address != "") {
						address = address + ", ";
					}
					
					address = address + node.city;
				} 
				
				if ((node.postcode) != "") {
					if (address != "") {
						address = address + ", ";
					}
					
					address = address + node.postcode;
				} 
				
				if ((node.country) != "") {
					if (address != "") {
						address = address + ", ";
					}
					
					address = address + node.country;
				} 
				
				return address;
			}
<?php			
		}
	}
	
	$agegroupid = $_GET['id'];
	
	$crud = new PlayerCrud();
	$crud->dialogwidth = 650;
	$crud->title = "Players";
	$crud->table = "{$_SESSION['DB_PREFIX']}player";
	$crud->sql = "SELECT A.*
				  FROM  {$_SESSION['DB_PREFIX']}player A
				  WHERE A.agegroupid = $agegroupid
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
				'name'       => 'agegroupid',
				'datatype'	 => 'integer',
				'length' 	 => 6,
				'showInView' => false,
				'filter'	 => false,
				'editable' 	 => false,
				'default'	 => $agegroupid,
				'label' 	 => 'Team'
			),
			array(
				'name'       => 'imageid',
				'type'		 => 'IMAGE',
				'required'   => false,
				'length' 	 => 35,
				'showInView' => false,
				'label' 	 => 'Logo'
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
				'name'       => 'address1',
				'length' 	 => 60,
				'showInView' => false,
				'label' 	 => 'Address 1'
			),
			array(
				'name'       => 'address2',
				'length' 	 => 60,
				'showInView' => false,
				'required'	 => false,
				'label' 	 => 'Address 2'
			),
			array(
				'name'       => 'address3',
				'length' 	 => 60,
				'showInView' => false,
				'required'	 => false,
				'label' 	 => 'Address 3'
			),
			array(
				'name'       => 'city',
				'length' 	 => 30,
				'showInView' => false,
				'label' 	 => 'City'
			),
			array(
				'name'       => 'postcode',
				'length' 	 => 10,
				'showInView' => false,
				'label' 	 => 'Post Code'
			),
			array(
				'name'       => 'country',
				'length' 	 => 30,
				'showInView' => false,
				'label' 	 => 'Country'
			),
			array(
				'name'       => 'address',
				'length' 	 => 90,
				'editable'   => false,
				'bind'		 => false,
				'type'		 => 'DERIVED',
				'function'	 => 'fullInvoiceAddress',
				'label' 	 => 'Address'
			),
			array(
				'name'       => 'email',
				'length' 	 => 40,
				'label' 	 => 'Email'
			),
			array(
				'name'       => 'telephone',
				'length' 	 => 12,
				'label' 	 => 'Telephone'
			)
		);

	$crud->subapplications = array(
			array(
				'title'		  => 'Documents',
				'imageurl'	  => 'images/document.gif',
				'script' 	  => 'editDocuments'
			)
		);
		
	$crud->run();
?>
