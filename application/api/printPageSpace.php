<?php 
require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/printPageSpace.php';
require_once CLASS_DIR.'/api.php';

$api = new api();
$printPageSpace = new printPageSpace();


if(isset($_GET['controller']) && $_GET['controller']=='list'){

	$post = $api->jsonBody();
	$result = $printPageSpace->getList($post);

	if($result)
		$return = array('success'=>1, 'data'=>$result);
	else
		$return = array('success'=>0, 'data'=>array());
	
	
	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='detail'){

	$id = $_GET['id'];
	$result = $printPageSpace->detail($id);
	
	if($result)
		$return = array('success'=>1, 'data'=>$result);
	 else 
		$return = array('success'=>0, 'data'=>array());
	
	
	$api->setResponse($return, 200);
		
}

if(isset($_GET['controller']) && $_GET['controller']=='edit'){

	$post = $api->jsonBody();
	$id = $post['id'];

	$postArray = array(
		'page_top_space'=> $post['inptTPS'],
		'space_two_row'=> $post['inptTRS'],
		'space_two_col'=> $post['inptTCS'],
		'space_left'=> $post['inptLS'],
		'coupon_width'=> $post['inptCW'],
		'coupon_height'=> $post['inptCH']
		
	);
	

	$result = $printPageSpace->update($id, $postArray);
	
	if($result['error']==false)
		$return = array('success'=>1, 'message'=>'Space set up successfully updated.');
	else
		$return = array('success'=>0, 'message'=>$result['error']);


	$api->setResponse($return, 200);
}


