<?php 
require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/users.php';
require_once CLASS_DIR.'/giftRequest.php';
require_once CLASS_DIR.'/api.php';

$api = new api();
$giftRequest = new giftRequest();


if(isset($_GET['controller']) && $_GET['controller']=='list'){

	$post = $api->jsonBody();

	$result = $giftRequest->getList($post);
	
	if($result):
	    
	    $finalResult = array();
	    
	    foreach ($result as $key=>$rowdata):
	        
	        $giftRowId = $rowdata['giftId'];
	       
	        $result[$key]['giftData'] = $api->callLamiService('/gift/detail', array('giftRowId'=>$giftRowId));
	        
	    endforeach;
	
	endif;
	
	
	//echo "<pre>";
	//print_r($result); die;


	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='listDownload'){

	$post = $api->jsonBody();

	$result = $giftRequest->getList($post);
	
	if($result):
	    
	    $finalResult = array();
	    
	    foreach ($result as $key=>$rowdata):
	        
	        $giftRowId = $rowdata['giftId'];
	       
	        $result[$key]['giftData'] = $api->callLamiService('/gift/detail', array('giftRowId'=>$giftRowId));
	        
	    endforeach;
	
	endif;
	
	
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="gift_request_report.csv"');
header('Cache-Control: max-age=0');

$out = fopen('php://output', 'w');
	
	$reportDownloadList[] = array('TARNSCATION ID','GIFT REQUEST DATE','CUSTOMER NAME','CUSTOMER ADDRESS','CUSTOMER PROFILE','CUSTOMER MOBILE','GIFT UNIQUE ID','GIFT POINTS','GIFT STOCK','GIFT STATUS','REQUEST STATUS','VENDOR NAME','DISPATCH DATE','AWB NUMBER','DELIVERY DATE','RETURN','REASON TO CANCEL');
	
	foreach($result as $data):
	
		  $txId = "TX#".$data['id'];
		  $custAddress = str_replace(","," - ",$data['deliveryAddress']);
		  $giftUniId = $data['giftData']['giftUniqueId'];
		  $giftPoints = $data['giftData']['points'];
		  $giftStock = $data['giftData']['stock_status'];
		  $giftStatus = $data['giftData']['status'];
		  $userRole = getUserRoleByNumber($data['userRoleId']);
		  
		  $customerAddress = ($custAddress) ? $custAddress : "Not Available";
		  
		  $giftReturn = ($data['giftReturn']) ? " YES" : "NO";
		  
		  if($giftStatus==1)
		    $giftStatusTitle = "Active";
		  else
		     $giftStatusTitle = "InActive";
    
    

        $reportDownloadList[] = array($txId,$data['giftRequestDate'],$data['userName'],$customerAddress,$userRole,$data['userMobile'],$giftUniId,$giftPoints,$giftStock,$giftStatusTitle,$data['requestStatus'],$data['dispatchVendorId'],$data['dispatchDate'],$data['AWBnumber'],$data['deliveryDate'], $giftReturn,$data['returnReason']); 
        
        
    endforeach;
    
   // echo "<pre>";
    //print_r($reportDownloadList); die;
    
    foreach ($reportDownloadList as $fields) 
        fputcsv($out, $fields);

 $api->setResponse(array('success'=>1), 200);

}


if(isset($_GET['controller']) && $_GET['controller']=='detail'){

	$id = $_GET['id'];

	$result = $giftRequest->detail($id);
	
	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);	
}



if(isset($_GET['controller']) && $_GET['controller']=='edit'){


	$post = $api->jsonBody();
	$id = $post['id'];
	
	$requestStatus = "Pending";
	
	if($post['dispatchDate']!="0000-00-00")
	    $requestStatus = "Dispatched";
	
	if($post['deliveryDate']!="0000-00-00")
	    $requestStatus = "Delivered";
	
	if($post['isReturn']==1)
	    $requestStatus = "Cancelled";

    $postArray = array(
		'dispatchVendorId'=>$post['vendorId'],
		'dispatchDate'=>$post['dispatchDate'],
		'AWBnumber'=>$post['awbNum'],
		'deliveryDate'=>$post['deliveryDate'],
		'giftReturn'=>$post['isReturn'],
		'requestStatus'=>$requestStatus,
		'updatedOn'=>date("Y-m-d H:i:s"),
		'returnReason'=>$post['returnReason']
		
	);


	$result = $giftRequest->update($id, $postArray);
	
	
	// call controller=giftReturn from API.php
	if($post['isReturn']==1)
	   $api->callService('/gift/return', array('transactionId'=>$id));
	    

	
	
	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Gift Request updated successfully.');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='delete'){

	
	$id = htmlspecialchars($_GET['id']);
	$result = $giftRequest->delete($id);

	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Success');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='getVendorList'){


	$result = $giftRequest->getVendorList();

	if($result['error']==false){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);
}


function getUserRoleByNumber($roleId)
{
     
     $userRole = "Other";
     
     if($roleId==3)
        $userRole ="Distributor/ Distributor Staff"; 
        
    if($roleId==4)
        $userRole = "Retailer"; 
        
    if($roleId==5)
        $userRole ="Customer";
        
    if($roleId==6)
        $userRole ="Mechanic /Garage Owner";
    
    if($roleId==7)
        $userRole ="EOW";
    
    if($roleId==8)
        $userRole = "Sales Staff";
    
    if($roleId==9)
        $userRole ="Engg. Workshop";
    
    return $userRole;

}
