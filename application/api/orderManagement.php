<?php
require_once '../../config.php';
require_once CLASS_DIR . '/dbclass.php';
require_once CLASS_DIR . '/orderManagement.php';
require_once CLASS_DIR . '/api.php';

$api = new api();
$orderManagement = new orderManagement();


if (isset($_GET['controller']) && $_GET['controller'] == 'list') {

	$post = $api->jsonBody();

	$result = $orderManagement->getList($post);

	if ($result) {
		$return = array('success' => 1, 'data' => $result);
	} else {
		$return = array('success' => 0, 'data' => array());
	}

	$api->setResponse($return, 200);
}


if (isset($_GET['controller']) && $_GET['controller'] == 'distributorList') {

	$post = $api->jsonBody();

	$result = $orderManagement->getDistributorList($post);

	if ($result) {
		$return = array('success' => 1, 'data' => $result);
	} else {
		$return = array('success' => 0, 'data' => array());
	}

	$api->setResponse($return, 200);
}


if (isset($_GET['controller']) && $_GET['controller'] == 'getUserDataById') {

    $userId =  $_GET['id']; 
	$result = $orderManagement->getUserData($userId);

	if ($result) {
		$return = array('success' => 1, 'data' => $result);
	} else {
		$return = array('success' => 0, 'data' => array());
	}

	$api->setResponse($return, 200);
}



if (isset($_GET['controller']) && $_GET['controller'] == 'detail') {

	$id = $_GET['id'];

	$result = $orderManagement->detail($id);
	$orderItems = $orderManagement->orderItems($id);
	
	foreach ($orderItems as $key => $orderItem):
	        
	        $itemProductId = $orderItem['item_product_id'];
	       
	        $result['order_item_data'][$key] = $api->callLamiService('/orderitem/detail', array('itemProductId'=> $itemProductId));
	        
	        $result['order_item_data'][$key]['qty'] = $orderItem['item_qty'];
	        $result['order_item_data'][$key]['item_id'] = $orderItem['item_id'];
	        
	        $dispatchItemsQty = $orderManagement->disPatchQty($id,$orderItem['item_id']);
	        
	        $dispatchItemsQty = !empty($dispatchItemsQty['dispatchQTY']) ? $dispatchItemsQty['dispatchQTY'] : 0;
	        
	        $result['order_item_data'][$key]['dispatchItemQty'] =  $dispatchItemsQty;

	    endforeach;
	    
	    
	    
	    $disPatchOrderDetail = $orderManagement->disPatchOrderDetail($id);
	    
	    if(is_array($disPatchOrderDetail) && count( $disPatchOrderDetail ) > 0):
	        
	        foreach ($disPatchOrderDetail as $key => $dispatchItem):
	        
	            $dispatchItemId = $dispatchItem['item_product_id'];
	       
	            $result['dispatch_item_data'][$key] = $api->callLamiService('/orderitem/detail', array('itemProductId'=> $dispatchItemId));
	        
	            $result['dispatch_item_data'][$key]['dispatchDate'] = $dispatchItem['dispatchDate'];
	            
	            $result['dispatch_item_data'][$key]['dispatchItemQty'] = $dispatchItem['dispatch_qty'];
	            
	            $result['dispatch_item_data'][$key]['dispatchItemComment'] = $dispatchItem['dispatch_comment'];

	    endforeach;
	    
	    endif;
	   
	    
	  //echo "<pre>";
	//print_r($result); die;
	

	if ($result) {
		$return = array('success' => 1, 'data' => $result);
	} else {
		$return = array('success' => 0, 'data' => array());
	}

	$api->setResponse($return, 200);
}



if (isset($_GET['controller']) && $_GET['controller'] == 'edit') {


	$post = $api->jsonBody();
	$orderId = $post['id'];

	$postArray = array(
		'order_comment' => $post['orderComment'],
		'order_status' => $post['orderStatus'],
		'payment_status' => $post['paymentStatus'],
		'user_id' => $post['userId'],
		'user_mobile' => $post['userMobile'],
		'order_updateDate' => date("Y-m-d H:i:s")
	);


	$result = $orderManagement->update($orderId, $postArray);


	if ($result['error'] == false) {
		$return = array('success' => 1, 'message' => 'Order Updated successfully.');
	} else {
		$return = array('success' => 0, 'message' => $result['error']);
	}

	$api->setResponse($return, 200);
}



if (isset($_GET['controller']) && $_GET['controller'] == 'dispatch') {


	$post = $api->jsonBody();
	$orderId = $post['id'];

	$postArray = array(
		'order_status' => $post['orderStatus'],
		'payment_status' => $post['paymentStatus'],
		'manufacture_comment' => $post['manufactureComment'],
		'order_updateDate' => date("Y-m-d H:i:s")
	);
	
	$result = $orderManagement->update($orderId, $postArray);
		
	$postDispatchQty= $post['dispatchQtyArray'];
	$postDispatchComment= $post['dispatchCommentArray'];
	
	$dispatchDataArray = [];
	
	if(is_array($postDispatchQty) && sizeof($postDispatchQty)>0):
	    
	    foreach($postDispatchQty as $key => $itemId_dispatchQty):
	            $orderItemId = $itemId_dispatchQty['itemId'];
	            $dispatchQty =$itemId_dispatchQty['value'];
	            
	       if($dispatchQty < 1 )
	           continue;
	            
	       if($postDispatchComment[$key]['itemId'] == $orderItemId)
	            $dispatchComment = $postDispatchComment[$key]['value'];
	            
	       $dispatchDataArray = array(
		        'order_item_id' => $orderItemId,
		        'dispatch_qty' => $dispatchQty,
		        'dispatch_comment' => $dispatchComment,
		        'order_id' => $orderId,
		        'dispatchDate' => date("Y-m-d H:i:s")
	        );
	        
	   $dispatchOrder = $orderManagement->dispatchUpdate($orderId, $dispatchDataArray);
	        
	    endforeach;
	    
	endif;


	if ($result['error'] == false) {
		$return = array('success' => 1, 'message' => 'Order Dispatch/Updated successfully.');
	} else {
		$return = array('success' => 0, 'message' => $result['error']);
	}

	$api->setResponse($return, 200);
}

if (isset($_GET['controller']) && $_GET['controller'] == 'delete') {


	$id = htmlspecialchars($_GET['id']);
	$result = $orderManagement->delete($id);

	if ($result['error'] == false) {
		$return = array('success' => 1, 'message' => 'Success');
	} else {
		$return = array('success' => 0, 'message' => $result['error']);
	}

	$api->setResponse($return, 200);
}



if(isset($_GET['controller']) && $_GET['controller']=='listOrderDownload'){

	$result = $orderManagement->getList($_POST);
	
	if($result):
	    
	    foreach ($result as $key=>$orderData):
	        
	       $orderId = $orderData['order_id'];
	       $orderItemArray = getOrderItemsByOrderId($orderId,$orderManagement,$api);
	       
	       $result[$key]['orderItemData'] = $orderItemArray;
	        
	    endforeach;
	
	endif;
	
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="ordersList.csv"');
    header('Cache-Control: max-age=0');

    $out = fopen('php://output', 'w');

	$reportDownloadList[] = array('Order ID','CUSTOMER NAME','CUSTOMER PROFILE','CUSTOMER MOBILE','Dealer Code','Order Status','Order Comment','Manufacture Comment','Payment Status','Order Date/Time');
	
	foreach($result as $data):
	
		  $orderId = "OrderId#".$data['order_id'];
		  $customerName = $data['userName'];
		  $customerProfile = getUserRoleByNumber($data['userRoleId']);
		  $customerMobile = $data['userMobile'];
		  
		  $dealerCode = $data['dealerCode'];
		  $orderStatus = $data['order_status'];
		  $orderComment = $data['order_comment'];
		  $manufactureComment = $data['manufacture_comment'];
		  $paymentStatus = $data['payment_status'];
		  $orderDate = $data['order_date'];
		  
		  $reportDownloadList[] = array($orderId,$customerName,$customerProfile,$customerMobile,$dealerCode,$orderStatus,$orderComment,$manufactureComment,$paymentStatus,$orderDate);
		  
		  $orderItemArray = $data['orderItemData']['order_item_data'];
		  
		  if(count($orderItemArray)){
		      
		      $reportDownloadList[] = array('Order Item List: ','Product Part Number','Product Name','Product Mrp','Sub Title','Order QTY','Dispatch QTY','Balance QTY');
		      
		      foreach($orderItemArray as $orderItemData):
		          
		          $productId = $orderItemData['id'];
		          $productName = $orderItemData['product_name'];
		          $productMrp = $orderItemData['product_mrp'];
		          $partNo = $orderItemData['part_no'];
		          $subTitle = $orderItemData['sub_title'];
		          $orderQty = $orderItemData['qty'];
		          $dispatchQty = $orderItemData['dispatchItemQty'];
		          
		          $balanceQtyCheck = $orderQty - $dispatchQty;
		          $balanceQty =  ( $balanceQtyCheck > 0) ?  $balanceQtyCheck : 0;
		          
		          $reportDownloadList[] = array(' ',$partNo,$productName, $productMrp, $subTitle,$orderQty,$dispatchQty,$balanceQty);
		     
		       endforeach;
	
		  }

	        $reportDownloadList[] = array();
	        
    endforeach;
    
    //echo "<pre>";
    //print_r($reportDownloadList); die;
    
    foreach ($reportDownloadList as $fields) 
        fputcsv($out, $fields);

}


function getOrderItemsByOrderId($orderId,$orderManagement,$api)
{

    $orderItemsArray = array();
    $orderItems = $orderManagement->orderItems($orderId);
	    
	foreach ($orderItems as $key => $orderItem):
	 
	        $itemProductId = $orderItem['item_product_id'];
	       
	        $orderItemsArray['order_item_data'][$key] = $api->callLamiService('/orderitem/detail', array('itemProductId'=> $itemProductId));
	        
	        $orderItemsArray['order_item_data'][$key]['qty'] = $orderItem['item_qty'];
	        
	        $dispatchItemsQty = $orderManagement->disPatchQty($orderId,$orderItem['item_id']);
	        
	        $dispatchItemsQty = !empty($dispatchItemsQty['dispatchQTY']) ? $dispatchItemsQty['dispatchQTY'] : 0;
	        
	        $orderItemsArray['order_item_data'][$key]['dispatchItemQty'] =  $dispatchItemsQty;
	     
	    endforeach;
	    
	 
	    return $orderItemsArray;
    
}

function getUserRoleByNumber($roleId)
{
     
     $userRole = "Other";
     
     if($roleId==2 || $roleId==3)
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
