<?php 

require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/users.php';
require_once CLASS_DIR.'/inventory.php';
require_once CLASS_DIR.'/uploads.php';


require_once BASE_DIR.'/application/lib/Excel/reader.php';
require_once CLASS_DIR.'/api.php';


$api = new api();
$inventory = new inventory();


if(isset($_GET['controller']) && $_GET['controller']=='list'){

	$post = $api->jsonBody();
	$result = $inventory->productList($post);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}

//importProductData
if(isset($_GET['controller']) && $_GET['controller']=='importProductData'){
	$post = $api->jsonBody();

	$id = $post['id'];
	$total = $post['total'];
	$page = $post['page'];
	$total = $post['total'];
	$filename = $post['filename'];
	$categoryId = $post['categoryId'];

	$uploaddir = BASE_DIR.'/uploads/import/file/';
	$filename = $post['filename'];
	$fileid = $post['fileid'];
	$target = $uploaddir.basename($filename);

	$data = new Spreadsheet_Excel_Reader();
	$data->read($target);

	$end = count($data->sheets[0]['cells']);
	$productKeyArray = $inventory->getAllotedProductKey();


	for ($i = $start; $i <= $end; $i++) {	
		if($i > 1){
			if(!empty($data->sheets[0]['cells'][$i][1]) && !empty($data->sheets[0]['cells'][$i][2])){

				  $productKey = $api->getUniqRandomNum($productKeyArray, 6);
				  $productKeyArray[] = $productKey;

					$insertArray[] = array(
						'category_id'=> $categoryId,
						'product_key'=> $productKey,
						'product_series'=> $data->sheets[0]['cells'][$i][1],
						'product_name'=> $data->sheets[0]['cells'][$i][2],
						'product_mrp'=> $data->sheets[0]['cells'][$i][3],
						'product_exp_date'=> $data->sheets[0]['cells'][$i][4],
						'product_filed_2'=> $data->sheets[0]['cells'][$i][5],
						'product_filed_3'=>$data->sheets[0]['cells'][$i][6],
						'is_active'=> 1,
						'is_trash'=> 0,
						'created_on'=> time()
				  );
			}
		}
	}

	if(isset($insertArray) && count($insertArray) > 0){
		$dataResult = $inventory->addBulkProduct($insertArray);
	}

	if($dataResult['error']==false){
		$success = 1;
		$message = NULL;
	} else {
		$success = 0;
		$message = "Error: ".$dataResult['error'];
	}

	$return = array(
		'success'=>$success,
		'message'=>$message,
  );

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='importProductFile'){



	$upload = new uplode();

	$uploaddir = BASE_DIR.'/uploads/import/file/';
	$return = $upload->uplodeExcel($_FILES['file'], $uploaddir);

	if($return['success']==1){

		$target = $uploaddir.basename($return['uploaded_name']);
		$data = new Spreadsheet_Excel_Reader();
		$data->read($target);

		$numRows =  $data->sheets[0]['numRows'];
		if($numRows > 1){
			$productRocords = ($numRows-1);
			$insert = array(
				'category_id'=>0,
				'filename'=>$return['uploaded_name'],
				'total_record'=>$productRocords,
				'completed_record'=>0,
				'is_completed'=>0,
				'created_on'=>time()
			);
			$logId = $inventory->addProductImportLog($insert);
		}

		$return['id'] = $logId;
		$return['totalRows'] = $productRocords;
	}
	
	$api->setResponse($return, 200);	
}

//delete
if(isset($_GET['controller']) && $_GET['controller']=='delete'){

	$post = $api->jsonBody();
	$id = $post['id'];

	if($inventory->isCouponProduct($id)){
		$return = array('success'=>0, 'message'=>'Coupon generated against this product');
	} else {
		$result = $inventory->deleteProduct($id);
		if($result['error']==false){
			$return = array('success'=>1, 'message'=>'Success');
		} else {
			$return = array('success'=>0, 'message'=>$result['error']);
		}
	}

	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='edit'){

	$post = $api->jsonBody();
	$id = $post['id'];

    $postArray = array(
		'product_series'=>$post['productSeries'],
		'product_name'=>$post['productName'],
		'product_mrp'=>$post['productMrp'],
		'product_exp_date'=>$post['productF1'],
		'product_filed_2'=>$post['productF2'],
		'product_filed_3'=>$post['productF3']
	);
	
$result = $inventory->updateProduct($id, $postArray);
	
if($result['error']==false)
	$return = array('success'=>1, 'message'=>'Product updated successfully.');
else 
	$return = array('success'=>0, 'message'=>$result['error']);
	

	$api->setResponse($return, 200);
}


