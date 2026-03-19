<?php 

require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/uploads.php';
require_once CLASS_DIR.'/api.php';


$api = new api();


function slug($name){
   $string = str_replace(' ', '-', $string);
   $string = str_replace('_', '-', $string);
   $string = trim($string, '-');
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
   $string = strtolower($string);
   return $string;	
}

if(isset($_GET['controller']) && $_GET['controller']=='uploadCompanyLogo'){

	$uplode = new uplode();
	$uploadPath = BASE_DIR.'/uploads/logo';
	$result = $uplode->uplodeSingleImages($_FILES['file'], '120|420', $uploadPath);
	if(isset($result['error'])){
		$return = array('success'=>0, 'msg'=>$result['msg']);
	} else {
		$result['src'] = APP_URL.'/uploads/logo/120/'.$result['uploaded_name'];
		$return = array('success'=>1, 'data'=>$result);
	}

	$api->setResponse($return, 200);
}