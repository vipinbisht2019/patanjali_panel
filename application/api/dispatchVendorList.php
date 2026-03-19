<?php 
require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/users.php';
require_once CLASS_DIR.'/dispatchVendorList.php';
require_once CLASS_DIR.'/api.php';

$api = new api();
$dispatchVendorList = new dispatchVendorList();


if(isset($_GET['controller']) && $_GET['controller']=='list'){

	$post = $api->jsonBody();
	$result = $dispatchVendorList->getList($post);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}



if(isset($_GET['controller']) && $_GET['controller']=='detail'){

	$id = $_GET['id'];

	$result = $dispatchVendorList->detail($id);
	
	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);	
}

if(isset($_GET['controller']) && $_GET['controller']=='add'){

	$post = $api->jsonBody();

	$postArray = array(
		'vendorName'=>$post['name'],
		'status'=>$post['status'],
		'created_on'=>date("Y-m-d H:i:s")
	);

	$result = $dispatchVendorList->add($postArray);
	

	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Vendor successfully added.');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='edit'){

	$post = $api->jsonBody();
	$id = $post['id'];

$postArray = array(
		'vendorName'=>$post['name'],
		'status'=>$post['status'],
		'created_on'=>date("Y-m-d H:i:s")
	);

	$result = $dispatchVendorList->update($id, $postArray);
	
	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Vendor updated successfully.');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='delete'){

	
	$id = htmlspecialchars($_GET['id']);
	$result = $dispatchVendorList->delete($id);

	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Success');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='import_vendor_list'){

	
	$filename = $_FILES['inptProductFile']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

	if(!empty($_FILES['inptProductFile']['name']) && $ext=="csv")
	{
 		$file_data = fopen($_FILES['inptProductFile']['tmp_name'], 'r');
		$column = fgetcsv($file_data);

 		while($row = fgetcsv($file_data))
 			{
				$postArray = array(
					'vendorName'=>$row[0],
					'status'=>$row[1],
					'created_on'=>date("Y-m-d H:i:s")
				);
			
				$result = $dispatchVendorList->add($postArray);
				
               
			 } // end while loop
			 
		
		$message = "<p style='color:green'>Vendor list has been imported.</p>";
		$_SESSION['redirectMessage'] = $message;
		header("Location:".APP_URL."/dispatchVendorList"); 
 		
	} // end file check if
	else
	{
		$message = "<p style='color:red'>Please upload the CSV file !!</p>";
		$_SESSION['redirectMessage'] = $message;
		header("Location:".APP_URL."/dispatchVendorList"); 
	}

}

