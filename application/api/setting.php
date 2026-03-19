<?php 

require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/users.php';
require_once CLASS_DIR.'/setting.php';
require_once CLASS_DIR.'/api.php';

$setting = new setting();
$api = new api();

if(isset($_GET['controller']) && $_GET['controller']=='getSettingMeta'){

  $data['ADMIN_SCAN_NUMBER'] = $setting->getSettingMeta('ADMIN_SCAN_NUMBER');
  $data['ADMIN_POINT_RECEIVER'] = $setting->getSettingMeta('ADMIN_POINT_RECEIVER');

	if($data){
		$return = array('success'=>1, 'data'=>$data);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='getSettingMeta_all_delete'){

	$post = $api->jsonBody();
 	 $meta_value = $post['meta_value'];

	$result = $setting->getSettingMeta_all_delete($meta_value);
	
	if($result['error']==false){
			$return = array('success'=>1, 'message'=>'Success');
		} else {
			$return = array('success'=>0, 'message'=>$result['error']);
		}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='getSettingMeta_all'){

	
	$data = $setting->getSettingMeta_all('ADMIN_SCAN_NUMBER');
	// $data['ADMIN_POINT_RECEIVER'] = $setting->getSettingMeta('ADMIN_POINT_RECEIVER');
  
	  if($data){
		  $return = array('success'=>1, 'data'=>$data);
	  } else {
		  $return = array('success'=>0, 'data'=>array());
	  }
	  
	  $api->setResponse($return, 200);
  }



if(isset($_GET['controller']) && $_GET['controller']=='updateSettingMeta'){

	$post = $api->jsonBody();
	$metaKey = $post['key'];
	$metaValue = $post['value'];
	
	$metaMinimumPointKey = $post['keyPoint'];
	$metaMinimumPointValue = $post['MiniPointTxLimitValue'];

	$result = $setting->updateSettingMeta($metaKey, $metaValue);
	$resultPoint = $setting->updateSettingMeta($metaMinimumPointKey, $metaMinimumPointValue);
	
	if($result){

		/*if($metaKey=="ADMIN_POINT_RECEIVER"){
			$mobile = $metaValue;
			$mRefId = $setting->getSettingMeta('MAN_REF_ID');
			$response = $api->callLamiService('/updateAdminPointReceiver', array('mRefId'=>$mRefId, 'mobile'=>$mobile));
			if($response['success']==1){
				$setting->_update('users', array('mobile'=>$mobile), array('id'=>1));
			}
		}*/

		$return = array('success'=>1, 'message'=>'Successfully saved.');
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='getSettingScanLimit'){

	$data['DAILY_SCAN_LIMIT'] = $setting->getSettingMeta('DAILY_SCAN_LIMIT');
	$data['MINIMUM_POINT_TX_LIMIT'] = $setting->getSettingMeta('MINIMUM_POINT_TX_LIMIT');
	
	if($data){
		$return = array('success'=>1, 'data'=>$data);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='getBonusPercent'){

	$data['BONUS_PERCENT'] = $setting->getBonusPercent();
	
	if($data){
		$return = array('success'=>1, 'data'=>$data);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}
if(isset($_GET['controller']) && $_GET['controller']=='updateBonusPercent'){

	$post = $api->jsonBody();
	
	
	$percent = $post['bonuspercent'];
	$data['id'] = $setting->updateBonusPercent($percent);
	
	if($data){
		$return = array('success'=>1, 'data'=>$data);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}