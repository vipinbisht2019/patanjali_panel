<?php 

require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/master.php';
require_once CLASS_DIR.'/api.php';

$api = new api();
$master = new master();


if(isset($_GET['list']) && $_GET['list']=='state'){

	$result = $master->ajaxState();
	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'msg'=>$result['error']);
	}

	$api->setResponse($return, 200);

}

if(isset($_GET['list']) && $_GET['list']=='cities'){

	$post = $api->jsonBody();
	$stateCode = $post['stateCode'];
	if($stateCode==7){
		$result[] = array('id'=>3416, 'cityName'=>'New Delhi');
	} else {
		$result = $master->ajaxCities($stateCode);
	}

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'msg'=>$result['error']);
	}

	$api->setResponse($return, 200);

}


if(isset($_GET['list']) && $_GET['list']=='productMainCategory'){

	$result = $master->ajaxMainCategory();
	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'msg'=>$result['error']);
	}

	$api->setResponse($return, 200);

}


if(isset($_GET['list']) && $_GET['list']=='productSubCategory'){

	$post = $api->jsonBody();
	$id = $post['id'];
	$result = $master->ajaxSubCategory($id);
	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'msg'=>$result['error']);
	}

	$api->setResponse($return, 200);

}


if(isset($_GET['list']) && $_GET['list']=='categoryProduct'){

	$post = $api->jsonBody();
	$catId = $post['id'];
	$result = $master->ajaxCategoryProduct($catId);
	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'msg'=>$result['error']);
	}

	$api->setResponse($return, 200);

}


if(isset($_GET['list']) && $_GET['list']=='productBatch'){

	$post = $api->jsonBody();
	$productId = $post['productId'];
	$plantId = $post['plantId'];
	
	$result = $master->ajaxProductBatch($productId,$plantId);
	$validity = $master->ajaxProductValidity($productId,$plantId);

	if($result){
		$return = array('success'=>1, 'data'=>$result, 'validity'=>$validity);
	} else {
		$return = array('success'=>0, 'validity'=>$data, 'msg'=>$result['error']);
	}

	$api->setResponse($return, 200);
}


if(isset($_GET['list']) && $_GET['list']=='productBatchQty'){

	$post = $api->jsonBody();
	$batchId = $post['batchId'];
	$result = $master->ajaxProductBatchQty($batchId);
	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'msg'=>$result['error']);
	}

	$api->setResponse($return, 200);
}


if(isset($_GET['list']) && $_GET['list']=='ajaxCouponState'){

	$result = $master->ajaxCouponState();
	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'msg'=>$result['error']);
	}

	$api->setResponse($return, 200);

}

if(isset($_GET['list']) && $_GET['list']=='ajaxGroup'){

	$result = $master->ajaxGroupList();
	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'msg'=>$result['error']);
	}

	$api->setResponse($return, 200);

}


if(isset($_GET['list']) && $_GET['list']=='ajaxCouponCity'){

	$post = $api->jsonBody();
	$stateName = $post['stateName'];
	$result = $master->ajaxCouponCity($stateName);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'msg'=>$result['error']);
	}

	$api->setResponse($return, 200);

}


// start 12_may_2023

if(isset($_GET['list']) && $_GET['list']=='ajaxGetGroupList'){

	$post = $api->jsonBody();
	$result = $master->ajaxGetGroupList($post);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'msg'=>$result['error']);
	}
	
	$api->setResponse($return, 200);
}

if(isset($_GET['list']) && $_GET['list']=='ajaxGroupId'){

	$post = $api->jsonBody();

	$result = $master->ajaxGroupId($post['groupId']);
	
	if(is_array($result) && count($result) > 0 ){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'msg'=>$result['error']);
	}
	
	$api->setResponse($return, 200);
}

if(isset($_GET['list']) && $_GET['list']=='ajaxSubGroupId'){

	$post = $api->jsonBody();

	$result = $master->ajaxSubGroupId($post['groupId'],$post['subGroupId']);
	
	if(is_array($result) && count($result) > 0 ){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'msg'=>$result['error']);
	}
	
	$api->setResponse($return, 200);
}

if(isset($_GET['list']) && $_GET['list']=='ajaxGetSubGroupList'){

	$post = $api->jsonBody();
	$result = $master->ajaxGetSubGroupList($post);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'msg'=>$result['error']);
	}
	
	$api->setResponse($return, 200);
}

// end 12_may_2023

