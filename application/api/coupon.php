<?php 

require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/users.php';
require_once CLASS_DIR.'/coupon.php';
require_once CLASS_DIR.'/api.php';

$user = new users();

$api = new api();
$coupon = new coupon();


if(isset($_GET['qr'])){
	  $qrCodeImg = genrateOrderQR(1, 8734);
    echo '<img src="'.$qrCodeImg.'" />';
}

function genrateOrderQR($size=2, $orderNo, $couponString)
{
	  
	include LIB_DIR."/qr/qrlib.php"; 
	include_once($_SERVER['DOCUMENT_ROOT']."/PHP_CIPHER/php_aes_cipher_class.php");

	  $PNG_TEMP_DIR = BASE_DIR.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'qr'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
	  $PNG_WEB_DIR = APP_URL.'/uploads/qr/temp/';
	  $webApplication = "https://play.app.goo.gl/?link=https://play.google.com/store/apps/details?id=com.app.android.lami&couponstring=";

    $filename = $PNG_TEMP_DIR."od{$orderNo}.png";
    $errorCorrectionLevel = 'L';
    $qrSize = $size;
    $qrLevel = 'H'; //array('L','M','Q','H')

    $iv = 'fedcba9876543210'; #Same as in JAVA
	$key = '0123456789abcdef'; #Same as in JAVA
	$encryptedCouponString = PHP_AES_Cipher::encrypt($key, $iv, $couponString);
	
	$couponStringWithDeepLink = $webApplication.$couponString;

    QRcode::png($couponStringWithDeepLink, $filename, $qrLevel, $qrSize, 0); 

    return $PNG_WEB_DIR.basename($filename);
}

if(isset($_GET['controller']) && $_GET['controller']=='getCouponData'){

	$post = $api->jsonBody();
	$productData = $coupon->getProducts($post);
	$rows = 6;

	if($productData){

		$coupponData = $coupon->getCouponData($post);
		//print_r($coupponData);

		if($coupponData){

			$cData = array();
			foreach ($coupponData as $key => $value) {
				$productId = $value['product_id'];
				$cData[$productId][] = array(
					  'id'=>$value['id'],
					  'faceValue'=>$value['face_value'],
						'allHandCharge'=>$value['all_hand_charge'],
						'salesHandCharge'=>$value['sales_hand_charge'],
						'retailHandCharge'=>$value['retail_hand_charge'],
						'totalValue'=>$value['total_value'],
						'validity'=>$value['validity'],
				);
			}

			$dataSet = array();
			$p=0;

			foreach ($productData as $key => $value) {

				$productId = $value['productId'];
				$dataSet[$p]['productId'] = $productId;
				$dataSet[$p]['categoryId'] = $value['categoryId'];
				$dataSet[$p]['categoryName'] =  $value['categoryName'];
				$dataSet[$p]['productName'] = $value['productName'];
				$dataSet[$p]['productSeries'] = $value['productSeries'];

				for($i=0; $i<$rows; $i++){

					if(isset($cData[$productId][$i])){
						$dataSet[$p]['data'][] = $cData[$productId][$i];
					} else {
							$dataSet[$p]['data'][] = array(
								  'id'=>0,
								  'faceValue'=>'',
									'allHandCharge'=>'',
									'salesHandCharge'=>'',
									'retailHandCharge'=>'',
									'totalValue'=>0,
									'validity'=>'',
							);
					}
				}

				$p++;
			}

		} else {

			$dataSet = array();
			$p=0;
			//print_r($productData);
			foreach ($productData as $key => $value) {

				//print_r($value);

				$productId = $value['productId'];
				$dataSet[$p]['productId'] = $productId;
				$dataSet[$p]['categoryId'] = $value['categoryId'];
				$dataSet[$p]['categoryName'] =  $value['categoryName'];
				$dataSet[$p]['productName'] = $value['productName'];
				$dataSet[$p]['productSeries'] = $value['productSeries'];

				for($i=1; $i<=$rows; $i++){
					$dataSet[$p]['data'][] = array(
						  'id'=>0,
						  'faceValue'=>'',
							'allHandCharge'=>'',
							'salesHandCharge'=>'',
							'retailHandCharge'=>'',
							'totalValue'=>0,
							'validity'=>'',
					);
				}
				$p++;
			}

		//	print_r($dataSet); die;

		}

		$return = array('success'=>1, 'data'=>$dataSet);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='add'){

	$post = $api->jsonBody();
	$dataSet = $post['data'];
	
	foreach ($dataSet as $value) {

		if($value['id'] > 0){
			$id = $value['id'];
			$updateArray = array(
				'category_id'=>$value['categoryId'],
				'product_id'=>$value['productId'],
				'face_value'=>$value['faceValue'],
				'all_hand_charge'=>0, //$value['allHandCharge']
				'sales_hand_charge'=>0, //$value['salesHandCharge']
				'retail_hand_charge'=>0, //$value['retailHandCharge']
				'total_value'=>$value['faceValue'], //$value['retailHandCharge']
				'validity'=>$value['validity'],
				'plant_id'=>$value['plant_id']
			);

			$result = $coupon->updateCoupon($id, $updateArray);
		} else {
		    
		   $faceValue = !empty($value['faceValue']) ? $value['faceValue'] : '0.0';
		
			$addArray[] = array(
				'category_id'=>$value['categoryId'],
				'product_id'=>$value['productId'],
				'face_value'=> $faceValue,
				'all_hand_charge'=>0, //$value['allHandCharge']
				'sales_hand_charge'=>0, //$value['salesHandCharge']
				'retail_hand_charge'=>0, //$value['retailHandCharge']
				'total_value'=>$faceValue, //$value['retailHandCharge']
				'validity'=>$value['validity'],
				'plant_id'=>$value['plant_id']
			);
		}
	}
	

	if(isset($addArray) && count($addArray) > 0){
		$result = $coupon->addCoupon($addArray);
	}

	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Coupon data successfully saved');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='deleteCouponOrder'){

	$post = $api->jsonBody();
	$id = $post['id'];
	$result = $coupon->deleteCouponOrder($id);

	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'successfully delete.');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='getCouponBatchData'){

	$post = $api->jsonBody();
	$plantId = $post['plantId'];
	$catId = $post['catId'];
	$subCatId = $post['subCatId'];
	$productId = $post['productId'];

	$cData = array();
	$productFaceValues = $coupon->getProductFaceValues($productId,$plantId);
	$productBatchData = $coupon->getProductBatchData($productId,$plantId);

	$success=1;
	$message='Success';

  if($productFaceValues){
		if(!$productBatchData){
		    // echo "dd"; die;
		//	print_r($productFaceValues);
// die;
			if(isset($faceValues)){
				unset($faceValues);
			}

$j = 0;
			foreach ($productFaceValues as $value) {
			    
			    if($value['faceValue'] == 0 && $j == 0)
			    {
			        
			        $faceValues[] = array(
					'id'=>0,
					'faceValueId'=>$value['id'],
					'faceValue'=>$value['faceValue'],
					'faceValueQty'=>'',
				);
			        
			        $j++;
			    } elseif($value['faceValue'] != 0) {
			        
			          $faceValues[] = array(
					'id'=>0,
					'faceValueId'=>$value['id'],
					'faceValue'=>$value['faceValue'],
					'faceValueQty'=>'',
				);
			        
			    }
			    

			}

			//$cData = $productData;
			$cData[] = array(
				'batchId'=>0,
				'productId'=>$productId, 
				'batchSize'=>'',
				'data'=>$faceValues
			);
			

		} else {

			//print_r($productBatchData); die;
			foreach ($productBatchData as $key => $value) {

				$id = $value['id'];
				$batchId = $value['batchId'];
				$batchData[$batchId]['batchId'] = $batchId;
				$batchData[$batchId]['productId'] = $value['product_id'];
				$batchData[$batchId]['batchSize'] = $value['batchSize'];

				
				$batchData[$batchId][$value['faceValueId']] = array(
						'id'=>$id,
						'faceValueId'=>$value['faceValueId'],
						'faceValueQty'=>$value['qty'],
				);
			}


			foreach ($batchData as $batchId => $data) {

					if(isset($faceValues)){
							unset($faceValues);
					}
$j=0;
					foreach ($productFaceValues as $value) {
					    
					    if($value['faceValue'] == 0 && $j == 0)
			    {
					    
					    

						if(isset($batchData[$batchId][$value['id']])){

							$ff = $batchData[$batchId][$value['id']];
							$ff['faceValue'] = $value['faceValue'];
							$faceValues[] = $ff;

						} else {
							$faceValues[] = array(
								'id'=>0,
								'faceValueId'=>$value['id'],
								'faceValue'=>$value['faceValue'],
								'faceValueQty'=>'',
							);
						}

					$j++;
			        
			    }
			    
			    if($value['faceValue'] != 0)
			    {
					    
					    

						if(isset($batchData[$batchId][$value['id']])){

							$ff = $batchData[$batchId][$value['id']];
							$ff['faceValue'] = $value['faceValue'];
							$faceValues[] = $ff;

						} else {
							$faceValues[] = array(
								'id'=>0,
								'faceValueId'=>$value['id'],
								'faceValue'=>$value['faceValue'],
								'faceValueQty'=>'',
							);
						}

					$j++;
			        
			    }
					    
					}

					$cData[] = array(
						'batchId'=>$batchId,
						'productId'=>$batchData[$batchId]['productId'], 
						'batchSize'=>$batchData[$batchId]['batchSize'],
						'data'=>$faceValues
					);
			}


		}
  } else {
  	$success=0;
  	$message = "Face values not found for this product";
  }

// echo "<pre>"; print_r($cData); die;



	$return = array('success'=>$success, 'data'=>$cData, 'message'=>$message);
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='addBatch'){

	$post = $api->jsonBody();
	$dataSet = $post['data'];
	
	foreach ($dataSet as $value) {
	    
	      if($value['batchSize']=="")
	            continue;
	    

            $batchId = $value['id'];
			$batchArray = array(
			    'plant_id'=>$value['plantId'],
				'product_id'=>$value['productId'],
				'batch_size'=>$value['batchSize'],
			);

			if($batchId > 0){
				$coupon->updateCouponBatchSize($batchId, $batchArray);

			} else {
				$rr = $coupon->addCouponBatchSize($batchArray);
				$batchId = $rr['insert_id'];
			}

			foreach ($value['data'] as $k => $v) {
					
					$batchQtyId = $v['id'];
					$array = array(
						'coupon_batch_id'=>$batchId,
						'face_value_id'=>$v['faceValueId'],
						'qty'=>$v['faceValueQty'],
					);

					if($batchQtyId > 0){
						$result = $coupon->updateCouponBatchQty($batchQtyId, $array);

					} else {
						$result = $coupon->addCouponBatchQty($array);
					}
			}

	}


	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Coupon Batch successfully saved');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='genrateCoupons'){

	$userId = $user->id;
	$post = $api->jsonBody();
	$dataSet = $post['couponValues'];

	$order_id='';
	$insert = array(
			'order_id'=> $order_id,
			'category_id'=> $post['categoryId'],
			'subcat_id'=> $post['subcat_id'],
			'product_id'=> $post['productId'],
			'batch_id'=> $post['batchId'],
			'batch_size'=> $post['batchSize'],
			'batch_number'=> $post['batchNumber'],
			'date_of_mfg'=> $api->dateReplace($post['dateOfMfg']),
			'validity'=> $post['couponValidity'],
			'is_print'=>0,
			'is_active'=>0,
			'is_trash'=>0,
			'printed_on'=> 0,
			'activated_on'=> 0,
			'created_on'=> time(),
			'created_by'=> $userId,
			'updated_by'=> 0,
			'agmark_series'=> $post['agmarkSeries'],
			'agmark_number_start'=> $post['agmarkNumber'],
			'productExpDate'=> $api->dateReplace($post['expDateProduct']),
			'plant_id'=> $post['plant'],
			'unit_id'=> $post['divisionunit'],
			'coupon_type'=> $post['couponType']
			
	);

	$isBatchNumber = $coupon->isBatchNumber($post['batchNumber']);

	//if(!$isBatchNumber){
			$req = $coupon->_insert('coupon_batch_meta',$insert);
			if($req['error']==false){

				$coupon_order_id = $req['insert_id'];
				$n = $coupon->genratedOrderNo() + 1;
				
				//$order_id = 'OD'.date('Ymd').$n;
				
				$order_id = $coupon_order_id;
				
				$coupon->_update('coupon_batch_meta', array('order_id'=>$order_id), array('id'=>$coupon_order_id));

				if(is_array($dataSet)){
					foreach ($dataSet as $value) {
							$metaValues[] = array(
								'coupon_order_id'=>$coupon_order_id,
								'face_value_id'=>$value['faceValueId'],
								'face_value'=>$value['faceValue'],
								'qty'=>$value['qty'],
							);
					}

					$result = $coupon->_insertArray('coupon_batch_meta_values', $metaValues);
					if($result['error']==false){
						$success=1;
						$message='Coupon order successfully created.';
					}
				}
			} else {
				$success=0;
				$message='Error:'.$req['error'];
			}
//	} else {
			//$success=0;
			//$message='This batch number ('.$post['batchNumber'].') already used';
	//}

	$response = array('success'=>$success, 'message'=>$message);
	$api->setResponse($response, 200);
}


/* 14_april_2023
if(isset($_GET['controller']) && $_GET['controller']=='genratedCouponList'){
	$post = $api->jsonBody();
	$result = [];
	$result = $coupon->genratedCouponList($post);
	
	if($result){
	    $result['adminRole'] = $user->role; // user session class
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}

*/

// error_reporting(0);

if(isset($_GET['controller']) && $_GET['controller']=='genratedCouponList'){
	$post = $api->jsonBody();
	//$result = [];
	$result = $coupon->genratedCouponList($post);
	$result2 = $coupon->genratedCouponListtotal($post);
	
	if($result){
	  //  $role['adminRole'] = $user->role; // user session class
		$return = array('success'=>1, 'data'=>$result,'role'=>$user->role,'data2'=>$result2);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='viewGenratedCoupon'){
	$post = $api->jsonBody();
	$id = $post['id'];
	$result = $coupon->getCouponMeta($id);
	if($result){

		
		$couponValues = $coupon->getCouponMetaValues($id);

		if($result['isPrint']==1 || $result['isActive']==1){ 
		    
			$esplCompanyID = 3; //from company table
            $company = $coupon->company($esplCompanyID);
			$qrData = $coupon->getFirstCouponQr($id);
			
			//echo "<pre>";
			//print_r($qrData); die;

			$couponString = $company['manufacturer_code'].$company['client_code'].$result['productKey'].$result['couponDate'].$qrData['couponCode'];
			$result['qr'] = genrateOrderQR(2, $id, $couponString);
			$result['qrString'] = $couponString;
			$result['points'] = $qrData['points'];
			$result['couponCode'] = isset($qrData['couponCode']) ? $qrData['couponCode'] : "Either Coupon Scanned Or Not Active" ;
			
			$validTime = $result['printedTime'] + ($result['validity'] * 86400);
			
			$result['validUpTo']  = date('d/m/Y', $validTime);
		}

		$result['couponValues'] = ($couponValues) ? $couponValues : array();
		$return = array('success'=>1, 'data'=>$result);
		
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='PrintCouponCode'){
    echo "hi";
    die;
}

//PrintCouponCode -- Outer : Retailer
if(isset($_GET['controller']) && $_GET['controller']=='printOuterCouponCodes'){
    
    $currentDate = date("Y-m-d"); 

	$post = $api->jsonBody();
	$orderId = $post['id'];
	$orderMetaData = $coupon->getCouponMetaData($orderId);
	$orderMetaValues = $coupon->getCouponMetaValues($orderId);

	if($orderMetaValues){
	    
	    $agmarkNumber = "";
		$agmarkNumber = $orderMetaData['agmark_number_start'];
		$couponCodesArray = $coupon->getGenratedCouponKeys($currentDate);

		foreach ($orderMetaValues as $key => $value) {
		    	$couponCode = "";
		    
			for($i=1; $i<=$value['qty']; $i++){
				$couponCode = $api->getUniqRandomNum($couponCodesArray, 1);
			
				$arrayData[] = array(
					'coupon_order_id'=> $orderId,
					'product_key'=> $orderMetaData['product_key'],
					'coupon_code'=> $couponCode,
					'points'=> $value['faceValue'],
					'is_scaned'=>0,
					'agmark_number_increment'=>$agmarkNumber
				);
				
				$agmarkNumber = $agmarkNumber+1;
			}
		}
	}

	if(is_array($arrayData)){
		$result = $coupon->addCouponCodes($arrayData);
		
		if($result['error']==false){
		    $cd = array('is_generated'=>1, 'is_print'=>1, 'printed_on'=>time());
			$coupon->_update('coupon_batch_meta', $cd, array('id'=>$orderId));
			$return = array('success'=>1, 'message'=>'successfully printed.');
		} else {
			$return = array('success'=>0, 'message'=>'Error in print.');
		}
	}

	$api->setResponse($return, 200);
}




//PrintCouponCode -- Inner : Customer
if(isset($_GET['controller']) && $_GET['controller']=='printCouponCodes'){
    
  $currentDate = date("Y-m-d"); 

	$post = $api->jsonBody();
	$orderId = $post['id'];
	$orderMetaData = $coupon->getCouponMetaData($orderId);
	$orderMetaValues = $coupon->getCouponMetaValues($orderId);

	if($orderMetaValues){
	    
	    $agmarkNumber = "";
		$agmarkNumber = $orderMetaData['agmark_number_start'];
		$couponCodesArray = $coupon->getGenratedCouponKeys($currentDate);

		foreach ($orderMetaValues as $key => $value) {
		    	$couponCode = "";
		    
			for($i=1; $i<=$value['qty']; $i++){
				$couponCode = $api->getUniqRandomNum($couponCodesArray, 1);
			
				$arrayData[] = array(
					'coupon_order_id'=> $orderId,
					'product_key'=> $orderMetaData['product_key'],
					'coupon_code'=> $couponCode,
					'points'=> $value['faceValue'],
					'is_scaned'=>0,
					'agmark_number_increment'=>$agmarkNumber
				);
				
				$agmarkNumber = $agmarkNumber+1;
			}
		}
	}

	if(is_array($arrayData)){
		$result = $coupon->addCouponCodes($arrayData);
		
		if($result['error']==false){
			$cd = array('is_generated'=>1, 'printed_on'=>time());
			$coupon->_update('coupon_batch_meta', $cd, array('id'=>$orderId));
			$return = array('success'=>1, 'message'=>'successfully Generated.');
		} else {
			$return = array('success'=>0, 'message'=>'Error in generate.');
		}
	}

	$api->setResponse($return, 200);
}



//activateCouponCodes
if(isset($_GET['controller']) && $_GET['controller']=='activateCouponCodes'){

	$post = $api->jsonBody();
	$orderId = $post['id'];

	$cd = array('is_active'=>1, 'activated_on'=>time());
	$result = $coupon->_update('coupon_batch_meta', $cd, array('id'=>$orderId));
	
	// update coupon_code table
	$cc = array('is_active'=>1, 'is_print'=>1);
    $coupon->_update('coupon_codes', $cc, array('coupon_order_id'=>$orderId));
	
	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'successfully activated.');
	} else {
		$return = array('success'=>0, 'message'=>'Error in activation');
	}

	$api->setResponse($return, 200);
}

//adminInnerActivateCouponCodes
// start 25_aug_2023
if(isset($_GET['controller']) && $_GET['controller']=='adminInnerActivateCouponCodes'){

	$post = $api->jsonBody();
	$orderId = $post['id'];

	$cd = array('is_active'=>1, 'is_print'=>1, 'activated_on'=>time());
	$result = $coupon->_update('coupon_batch_meta', $cd, array('id'=>$orderId));
	
	// update coupon_code table
	$cc = array('is_active'=>1, 'is_print'=>1);
    $coupon->_update('coupon_codes', $cc, array('coupon_order_id'=>$orderId));
	
	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'successfully activated.');
	} else {
		$return = array('success'=>0, 'message'=>'Error in activation');
	}

	$api->setResponse($return, 200);
}

// end 25_aug_2023

if(isset($_GET['controller']) && $_GET['controller']=='resetScannedCoupon'){

	$post = $api->jsonBody();
	$id = $post['id'];

	$cp = $coupon->getScannedCouponUserInfo($id);
	$userId = $cp['userId'];
	$scannedOn = $cp['scannedOn'];
	$couponPoint = $cp['couponPoint'];
	$userCurrenPointBalance = $cp['userCurrenPointBalance'];

	$statmentEntryId = $coupon->getLastScannedlagerValue($userId, $scannedOn, $couponPoint);
	$isDelete = $coupon->deleteScannedCouponCode($id);
	if($isDelete){
		
		$coupon->deleteLastScannedlagerValue($statmentEntryId);
		$coupon->updateCouponStatus($id, 0);
		$updatedPointBalance = $userCurrenPointBalance - $couponPoint;
  	$user->updateCurrentPointBalance($userId, $updatedPointBalance);

		$return = array('success'=>1, 'message'=>'Coupon successfully reset');
	} else {
		$return = array('success'=>0, 'message'=>'Unable to reset this coupon');
	}

	$api->setResponse($return, 200);
}



if(isset($_GET['controller']) && $_GET['controller']=='deleteBatch'){

	$id = htmlspecialchars($_GET['id']); 
	$result = $coupon->deleteBatchData($id);

	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Success');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);
}



if(isset($_GET['controller']) && $_GET['controller']=='checkBatchNumberExist'){

	$post = $api->jsonBody();
	$batchNumber = $post['batchNumber'];
	$result = $coupon->checkBatchNumber($batchNumber);
	
	if($result['id']){
		$return = array('success'=>1);
	} else {
		$return = array('success'=>0);
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='lastAgmarkSeries'){

	$result = $coupon->getLastAgmarkSeries();
	
	if($result['id']){
		$return = array('success'=>1,'data'=>$result);
	} else {
		$return = array('success'=>0);
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='getPrintedNonPrinted'){

    $post = $api->jsonBody();
	//$result = $coupon->getPrintedNonPrintedCount($post['coponBatchMetaId']);
	$result = $coupon->getPrintedNonPrintedCountCouponList($post['coponBatchMetaIds']);
	
	
	if($result){
		$return = array('success'=>1,'data'=>$result);
	} else {
		$return = array('success'=>0);
	}

	$api->setResponse($return, 200);
}



if(isset($_GET['controller']) && $_GET['controller']=='couponDownloadFile'){

	$result = $coupon->downloadGenratedCouponList($_POST);
	
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="coupon_full_order_data_sheet.csv"');
    header('Cache-Control: max-age=0');

    $out = fopen('php://output', 'w');

	$reportDownloadList[] = array('ORDER NO','PLANT ID','PLANT NAME','DIVISION ID','DIVISION NAME','CATEGORY ID','SUB-CATEGORY ID','COUPON TYPE','PRODUCT NAME','BATCH NO','BATCH SIZE','COUPON SENT TO PRINTER','COUPON NOT SENT TO PRINTER','DATE OF MFG.','STATUS','CREATED ON');
	
	if(is_array($result) && count($result)>0) 
	{
	   
	foreach($result as $data):
	
	      $printedNonPrinted = $coupon->getPrintedNonPrintedCount($data['id']);
	      
	      $printedCount = $printedNonPrinted['printed'];
	      $nonprintedCount = $printedNonPrinted['nonPrinted'];
		  $orderNo = $data['orderNo'];
		  $productName = $data['productName'];
		  $batchNo = $data['batchNumber'];
		  $bathcSize = $data['batchSize'];
		  $couponSentPrint = $printedCount;
		  $couponNotSentPrint  = $nonprintedCount;
		  $dateOfMFG = $data['dateOfMfg'];
		  $status = $data['isPrint'];
		  $orderDate = $data['createdOn'];
		  
		  $categoryId = $data['category_id'];
		  $subcatId= $data['subcat_id'];
		  $plantId = $data['plant_id'];
		  $unitId = $data['unit_id'];
		  $couponType= $data['coupon_type'];
		  $plantName= $data['plant_name'];
		  $unitName= $data['unit_name'];
		  
		  $reportDownloadList[] = array($orderNo,$plantId, $plantName,$unitId,$unitName,$categoryId,$subcatId,$couponType,$productName,$batchNo,$bathcSize,$couponSentPrint,$couponNotSentPrint,$dateOfMFG,$status,$orderDate);
		  
    endforeach;
    
	}
    
    foreach ($reportDownloadList as $fields) 
        fputcsv($out, $fields);

}
