<?php 

require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/users.php';
require_once CLASS_DIR.'/inventory.php';
require_once CLASS_DIR.'/api.php';


$api = new api();
$inventory = new inventory();


if(isset($_GET['controller']) && $_GET['controller']=='listMainCategory'){

	$post = $api->jsonBody();
	$result = $inventory->mainCategoryList($post);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='listSubCategory'){

	$post = $api->jsonBody();
	$result = $inventory->subCategoryList($post);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
		
}


if(isset($_GET['controller']) && $_GET['controller']=='detail'){

	$id = $_GET['id'];

	//$result = $inventory->getContentByID($id);
	
	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
		
}


if(isset($_GET['controller']) && $_GET['controller']=='add'){

	$post = $api->jsonBody();
	$dataSet = $post['data'];
	foreach ($dataSet as $value) {
		$postArray[] = array(
			'parent_id'=>$value['parent'],
			'category_name'=>$value['name'],
			'description'=>$value['desc']
		);
	}

	$result = $inventory->addCategory($postArray);
	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'category successfully added.');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);

}

if(isset($_GET['controller']) && $_GET['controller']=='edit'){

	$post = $api->jsonBody();
	$id = $post['id'];
	$postArray = array(
		'parent_id'=>$post['parent'],
		'category_name'=>$post['name'],
		'description'=>$post['desc'],
		'is_ofa'=>$post['openforall']
	);

	$result = $inventory->updateCategory($id, $postArray);
	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'category successfully updated.');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);

}



if(isset($_GET['controller']) && $_GET['controller']=='delete'){

	$post = $api->jsonBody();
	$id = $post['id'];
	$result = $inventory->deleteCategory($id);

	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Success');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='subcatdelete'){

	$post = $api->jsonBody();
	$id = $post['id'];
	$result = $inventory->deleteSubCategory($id);

	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Success');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);
}

