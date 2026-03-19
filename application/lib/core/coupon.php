<?php

class coupon extends dbclass {
	

	public function detail($id){
		$query = "SELECT * FROM `coupon_master` WHERE id=$id";
		return $this->fetchRow($query);
	}
	
	public function addCoupon($data){
		return $this->_insertArray('coupon_master', $data);
	}
	
	public function updateCoupon($id, $data){
		return $this->_update('coupon_master', $data, array('id'=>$id));
	}

	public function deleteCategory($id){
		$query="DELETE FROM coupon_master WHERE id=$id";
		return $this->_query($query);
	}

	public function company($id){
		$query = "SELECT company_name,manufacturer_code, client_code, logo FROM `company` WHERE id=$id";
		return $this->fetchRow($query);
	}

	public function getOrderCouponData($id){
		$query = "
		SELECT 
			c.id as couponId,
			c.coupon_code as couponCode,
			c.points,
			c.is_print,
			c.is_active,
			c.product_key as productCode,
			c.agmark_number_increment,
			p.product_series as productSeries,
			p.product_exp_date,
			p.product_name,p.product_mrp,p.product_filed_2 as Qty,
			m.batch_number,
			m.date_of_mfg as batchDate,
			m.printed_on as printedOn,
			m.validity,
			m.batch_size as size,
			m.agmark_series,
			p.product_filed_2 as retailerCouponInfo_2,
			p.product_filed_3 as retailerCouponInfo
		FROM coupon_codes c, coupon_batch_meta m, products p
		WHERE m.id=c.coupon_order_id AND p.product_key = c.product_key AND c.coupon_order_id=$id";
		return $this->fetchResult($query);
	}


	public function getProducts($filter){
		$catId = $filter['catId'];
		$subCatId = $filter['subCatId'];
		$query = "SELECT 
		    p.id as productId,
		    p.category_id as categoryId, 
		    (SELECT category_name FROM product_category WHERE id=p.category_id) as categoryName, 
		    p.product_series as productSeries, 
		    p.product_name as productName
		  FROM 
		    products p
		  WHERE p.is_active=1 AND p.is_trash=0  
		";

		if($subCatId > 0){
			$query.=" AND p.category_id=$subCatId";
		} else {
			$query.=" AND ( p.category_id IN (SELECT id FROM product_category WHERE parent_id=$catId) )";
		}

		$query.=" ORDER BY p.id ASC";
		return $this->fetchResult($query);
	}

	public function getCouponData($filter){
		$catId = $filter['catId'];
		$subCatId = $filter['subCatId'];
		$plantId = $filter['plantId'];
		
		$query = "SELECT 
		    a.id, 
		    a.plant_id,
		    a.category_id,
		    a.product_id,
		    a.face_value,
		    a.all_hand_charge,
		    a.sales_hand_charge,
		    a.retail_hand_charge,
		    a.total_value,
		    a.validity
		  FROM 
		    coupon_master a
		  WHERE 1
		";
		
		if($plantId)
		    $query.=" AND a.plant_id=$plantId";

		if($subCatId > 0){
			$query.=" AND a.category_id=$subCatId";
		} else {
			$query.=" AND ( a.category_id IN (SELECT id FROM product_category WHERE parent_id=$catId) )";
		}
		
		$query.=" ORDER BY a.category_id ASC LIMIT 500";
		return $this->fetchResult($query);
	}


	public function getProductFaceValues($productId,$plantId){
	//	$query="SELECT id, product_id as productId, face_value as faceValue FROM coupon_master WHERE product_id=$productId AND plant_id=$plantId AND face_value > 0 ORDER By face_value ASC";
	
	$query="SELECT id, product_id as productId, face_value as faceValue FROM coupon_master WHERE product_id=$productId AND plant_id=$plantId ORDER By face_value ASC";
		return $this->fetchResult($query);
	}


	public function getProductBatchData($productId,$plantId){
		  $query="
		SELECT a.id as batchId, b.id, a.product_id, a.batch_size as batchSize, b.face_value_id as faceValueId, b.qty
		FROM coupon_batch_master a, coupon_batch_qty b 
		WHERE b.coupon_batch_id=a.id AND a.product_id=$productId AND a.plant_id=$plantId ORDER By a.batch_size ASC";
		return $this->fetchResult($query);
	}

	public function addCouponBatchSize($data){
		return $this->_insert('coupon_batch_master', $data);
	}

	public function updateCouponBatchSize($id, $data){
		return $this->_update('coupon_batch_master', $data, array('id'=>$id));
	}

	public function addCouponBatchQty($data){
		return $this->_insert('coupon_batch_qty', $data);
	}

	public function updateCouponBatchQty($id, $data){
		return $this->_update('coupon_batch_qty', $data, array('id'=>$id));
	}

	public function genratedOrderNo(){
		$date = date('Y-m-d');
		$query="SELECT count(id) as num FROM coupon_batch_meta WHERE date_format(CONVERT_TZ(FROM_UNIXTIME(created_on),'+00:00','+05:30'),'%Y-%m-%d') = '$date'";
		$data = $this->fetchRow($query);
		return $data['num'];
	}

	
	
	public function genratedCouponListtotal($filter){
	    
	    $no_of_records_per_page = $filter['limit'];
        $pageno = isset($filter['page']) ? $filter['page'] : 1;
        $offset = ($pageno-1) * $no_of_records_per_page;
	   
	  	  $query = "SELECT 
		    a.id,
		    a.plant_id,
		    a.category_id,
		    a.subcat_id,
		    a.product_id,
		    a.coupon_type,
		    a.unit_id,
		    a.order_id as orderNo,
		    p.product_name as productName,
		    a.batch_size as batchSize,
		    a.batch_number as batchNumber,
		    DATE_FORMAT(a.date_of_mfg, '%d/%m/%Y') as dateOfMfg,
		    a.validity,
		    a.is_print as isPrint,
		    a.is_active as isActive,
		    a.is_trash as isTrash,
		    a.is_generated,
			date_format(CONVERT_TZ(FROM_UNIXTIME(a.printed_on),'+00:00','+05:30'), '%d/%m/%Y') as printedOn,
		    date_format(CONVERT_TZ(FROM_UNIXTIME(a.activated_on),'+00:00','+05:30'), '%d/%m/%Y') as activatedOn,
		    date_format(CONVERT_TZ(FROM_UNIXTIME(a.created_on),'+00:00','+05:30'), '%d/%m/%Y') as createdOn
		  FROM 
		    coupon_batch_meta a, products p
		  WHERE 
		    p.id=a.product_id 
		";

        $plantPermission = getPlantPermission(); 
		if($plantPermission)
		    $query.=" AND (a.plant_id IN ($plantPermission))";
		    
		$divisionPermission = getDivisionPermission(); 
		if($divisionPermission)
		    $query.=" AND (a.unit_id IN ($divisionPermission))";
		
		if(!empty($filter['orderNo'])){
			$orderNo = $filter['orderNo'];
			$query.=" AND (a.order_id LIKE '$orderNo%')";
		}

		if(!empty($filter['productName'])){
			$productName = $filter['productName'];
			$query.=" AND (p.product_name LIKE '$productName%')";
		}

		if(!empty($filter['batchNo'])){
			$batchNo = $filter['batchNo'];
			$query.=" AND a.batch_number='$batchNo'";
		}

		if(!empty($filter['dateOfMfg'])){
			$dateOfMfg = $filter['dateOfMfg'];
			$query.=" AND DATE_FORMAT(a.date_of_mfg, '%d/%m/%Y') = '$dateOfMfg'";
		}
		
		if(!empty($filter['plantId'])){
			$plantId = $filter['plantId'];
			$query.=" AND a.plant_id =$plantId";
		}
		
		if(!empty($filter['divisionId'])){
			$divisionId = $filter['divisionId'];
			$query.=" AND a.unit_id = $divisionId";
		}
		
		if(!empty($filter['couponType'])){
			$couponType = $filter['couponType'];
			$query.=" AND a.coupon_type = '".$couponType."'";
		}
		
		if(!empty($filter['mainCategory'])){
			$mainCategory = $filter['mainCategory'];
			$query.=" AND a.category_id = $mainCategory";
		}
		
		if(!empty($filter['subCategory'])){
			$subCategory = $filter['subCategory'];
			$query.=" AND a.subcat_id = $subCategory";
		}
		
		if(!empty($filter['categoryProduct'])){
			$categoryProductId = $filter['categoryProduct'];
			$query.=" AND a.product_id = $categoryProductId";
		}
		
		if(!empty($filter['status']) && $filter['status'] > 0){
			$status = ($filter['status']==1) ? 1 : 0;
			$query.=" AND a.is_active = $status";
		}

		$query.=" ORDER BY a.id DESC";
		
		//echo $query; die;
		
		return $this->fetchResult($query);
	}
	
	
	public function genratedCouponList($filter){
	    
	    $no_of_records_per_page = $filter['limit'];
        $pageno = isset($filter['page']) ? $filter['page'] : 1;
        $offset = ($pageno-1) * $no_of_records_per_page;
	   
	  	  $query = "SELECT 
		    a.id,
		    a.plant_id,
		    a.category_id,
		    a.subcat_id,
		    a.product_id,
		    a.coupon_type,
		    a.unit_id,
		    a.order_id as orderNo,
		    p.product_name as productName,
		    a.batch_size as batchSize,
		    a.batch_number as batchNumber,
		    DATE_FORMAT(a.date_of_mfg, '%d/%m/%Y') as dateOfMfg,
		    a.validity,
		    a.is_print as isPrint,
		    a.is_active as isActive,
		    a.is_trash as isTrash,
		    a.is_generated,
			date_format(CONVERT_TZ(FROM_UNIXTIME(a.printed_on),'+00:00','+05:30'), '%d/%m/%Y') as printedOn,
		    date_format(CONVERT_TZ(FROM_UNIXTIME(a.activated_on),'+00:00','+05:30'), '%d/%m/%Y') as activatedOn,
		    date_format(CONVERT_TZ(FROM_UNIXTIME(a.created_on),'+00:00','+05:30'), '%d/%m/%Y') as createdOn
		  FROM 
		    coupon_batch_meta a, products p
		  WHERE 
		    p.id=a.product_id 
		";

        $plantPermission = getPlantPermission(); 
		if($plantPermission)
		    $query.=" AND (a.plant_id IN ($plantPermission))";
		    
		$divisionPermission = getDivisionPermission(); 
		if($divisionPermission)
		    $query.=" AND (a.unit_id IN ($divisionPermission))";
		
		if(!empty($filter['orderNo'])){
			$orderNo = $filter['orderNo'];
			$query.=" AND (a.order_id LIKE '$orderNo%')";
		}

		if(!empty($filter['productName'])){
			$productName = $filter['productName'];
			$query.=" AND (p.product_name LIKE '$productName%')";
		}

		if(!empty($filter['batchNo'])){
			$batchNo = $filter['batchNo'];
			$query.=" AND a.batch_number='$batchNo'";
		}

		if(!empty($filter['dateOfMfg'])){
			$dateOfMfg = $filter['dateOfMfg'];
			$query.=" AND DATE_FORMAT(a.date_of_mfg, '%d/%m/%Y') = '$dateOfMfg'";
		}
		
		if(!empty($filter['plantId'])){
			$plantId = $filter['plantId'];
			$query.=" AND a.plant_id =$plantId";
		}
		
		if(!empty($filter['divisionId'])){
			$divisionId = $filter['divisionId'];
			$query.=" AND a.unit_id = $divisionId";
		}
		
		if(!empty($filter['couponType'])){
			$couponType = $filter['couponType'];
			$query.=" AND a.coupon_type = '".$couponType."'";
		}
		
		if(!empty($filter['mainCategory'])){
			$mainCategory = $filter['mainCategory'];
			$query.=" AND a.category_id = $mainCategory";
		}
		
		if(!empty($filter['subCategory'])){
			$subCategory = $filter['subCategory'];
			$query.=" AND a.subcat_id = $subCategory";
		}
		
		if(!empty($filter['categoryProduct'])){
			$categoryProductId = $filter['categoryProduct'];
			$query.=" AND a.product_id = $categoryProductId";
		}
		
		if(!empty($filter['status']) && $filter['status'] > 0){
			$status = ($filter['status']==1) ? 1 : 0;
			$query.=" AND a.is_active = $status";
		}

		$query.=" ORDER BY a.id DESC LIMIT $offset, $no_of_records_per_page";
		
		//echo $query; die;
		
		return $this->fetchResult($query);
	}
	

	public function getCouponMeta($id){
		$query = "SELECT 
		    a.id, 
		    a.order_id as orderNo,
		    p.product_name as productName,
		    p.product_series as productSeries,
		    p.product_key as productKey,
		    p.product_mrp as productMrp,
		    (SELECT category_name FROM product_category WHERE id=p.category_id) as categoryName,
		    a.batch_size as batchSize,
		    a.batch_number as batchNumber,
		    DATE_FORMAT(a.date_of_mfg, '%d/%m/%Y') as dateOfMfg,
		    DATE_FORMAT(a.date_of_mfg, '%d%m%Y') as couponDate,
		    a.date_of_mfg as validUpTo,
		    a.printed_on as printedTime,
		    a.validity,
		    a.is_print as isPrint,
		    a.is_active as isActive,
		    a.is_trash as isTrash,
		    a.is_generated,
		    a.coupon_type,
		    a.agmark_series,
		    a.agmark_number_start,
		    DATE_FORMAT(a.productExpDate,'%d/%M/%Y') as expDate,
		    date_format(CONVERT_TZ(FROM_UNIXTIME(a.activated_on),'+00:00','+05:30'), '%d/%m/%Y') as activatedOn,
		    date_format(CONVERT_TZ(FROM_UNIXTIME(a.created_on),'+00:00','+05:30'), '%d/%m/%Y') as createdOn
		  FROM 
		    coupon_batch_meta a, products p
		  WHERE 
		    p.id=a.product_id AND a.id=$id
		";
		return $this->fetchRow($query);
	}

	public function getCouponMetaValues($id){
		$query = "SELECT 
		    a.id,
		    b.face_value as faceValue,
		    a.qty
		  FROM 
		    coupon_batch_meta_values a, coupon_master b
		  WHERE 
		    b.id=a.face_value_id AND a.coupon_order_id=$id 
		    ORDER BY b.face_value ASC
		";
		return $this->fetchResult($query);
	}

	public function getCouponMetaData($id){
		$query = "SELECT 
		    a.id, 
		    a.agmark_number_start,
		    p.product_key,
		    a.date_of_mfg as dateOfMfg,
		    a.validity
		  FROM 
		    coupon_batch_meta a, products p
		  WHERE 
		    p.id=a.product_id AND a.id=$id
		";
		return $this->fetchRow($query);
	}

	public function getGenratedCouponKeys($currentDate){
		$query="SELECT coupon_code FROM coupon_codes Where dateTime like '%$currentDate%' ORDER BY id ASC";
		$result = $this->fetchResult($query);
		if($result){
			foreach ($result as $key => $value) {
				$codes[] = $value['coupon_code'];
			}
			return $codes;
		} else {
			return array();
		}
		
	}

	public function addCouponCodes($data){
		return $this->_insertArray('coupon_codes', $data);
	}
	public function addCouponCode($data){
		return $this->_insert('coupon_codes', $data);
	}


	public function getFirstCouponQr($id){
		$query="
		SELECT coupon_code as couponCode, points
		FROM coupon_codes WHERE coupon_order_id=$id AND is_scaned=0 ORDER BY id ASC";
		return $this->fetchRow($query);
	}

	public function getClintCode(){
		$query="SELECT 
		manufacturer_code as manufacturerCode, 
		client_code as clientCode
		FROM company WHERE id=1";
		return $this->fetchRow($query);
	}

	public function isBatchNumber($number){
		$query="SELECT id FROM coupon_batch_meta WHERE batch_number='$number' AND is_trash=0 ORDER BY id DESC LIMIT 1";
		return $this->fetchRow($query);
	}

	public function deleteCouponOrder($id){
		$query="UPDATE coupon_batch_meta SET is_trash=1 WHERE id=$id";
		return $this->_query($query);
	}

	public function deleteLastScannedlagerValue($id){
		$query="DELETE FROM user_point_ledger WHERE id=$id";
		return $this->_query($query);
	}

	public function getLastScannedlagerValue($userId, $date, $points){
		$query="
		SELECT id 
		FROM user_point_ledger 
		WHERE user_id=$userId AND type=1 AND points='$points' AND DATE_FORMAT(created_on, '%d/%m/%Y') = '$date' 
		ORDER BY id DESC LIMIT 1";
		$data =  $this->fetchRow($query);
		return ($data) ? $data['id'] : 0;
	}

	public function deleteScannedCouponCode($couponCodeId){
		$query="DELETE FROM scanned_coupons WHERE coupon_id=$couponCodeId";
		return $this->_query($query);
	}

	public function getScannedCouponUserInfo($id){
		$query="
		SELECT 
			user_id as userId, 
			points as couponPoint,
			date_format(CONVERT_TZ(FROM_UNIXTIME(scanned_on),'+00:00','+05:30'), '%d/%m/%Y') as scannedOn,
			(SELECT current_point_balance FROM users WHERE id=user_id) as userCurrenPointBalance
		FROM scanned_coupons 
		WHERE coupon_id=$id 
		ORDER BY id DESC LIMIT 1";
		return $this->fetchRow($query);
	}

	public function updateCouponStatus($id, $isScaned){
		return $this->_update('coupon_codes', array('is_scaned'=>$isScaned), array('id'=>$id));
	}



 public function deleteBatchData($batchId){
		$query="DELETE cbm,cbq FROM coupon_batch_master cbm, coupon_batch_qty cbq WHERE cbm.id=cbq.coupon_batch_id AND cbm.id=$batchId"; 
		return $this->_query($query);
	}

public function getPrintPageSpaceSetting(){
	 $query="SELECT * FROM print_page_spacing WHERE id=1"; 
	 return $this->fetchRow($query);
	}
	
public function checkBatchNumber($batchNum){
    $query = "SELECT id FROM coupon_batch_meta WHERE batch_number='".$batchNum."'"; 
		return $this->fetchRow($query);
	}
	
	public function getLastAgmarkSeries()
	{
		$query = "SELECT id,agmark_series FROM  coupon_batch_meta Order By id DESC LIMIT 1";
		return $this->fetchRow($query);
	}
	
public function downloadGenratedCouponList($filter){
    
	 	 $query = "SELECT 
		    a.id, 
		    a.order_id as orderNo,
		    p.product_name as productName,
		    a.batch_size as batchSize,
		    a.batch_number as batchNumber,
		    DATE_FORMAT(a.date_of_mfg, '%d/%m/%Y') as dateOfMfg,
		    a.validity,
		    a.is_print as isPrint,
		    a.is_active as isActive,
		    a.is_trash as isTrash,
		    a.is_generated,
		    a.category_id,
		    a.subcat_id,
		    a.plant_id,
		    a.unit_id,
		    a.coupon_type,
		    pl.plant_name,
		    pd.unit_name,
			date_format(CONVERT_TZ(FROM_UNIXTIME(a.printed_on),'+00:00','+05:30'), '%d/%m/%Y') as printedOn,
		    date_format(CONVERT_TZ(FROM_UNIXTIME(a.activated_on),'+00:00','+05:30'), '%d/%m/%Y') as activatedOn,
		    date_format(CONVERT_TZ(FROM_UNIXTIME(a.created_on),'+00:00','+05:30'), '%d/%m/%Y') as createdOn
		  FROM 
		    coupon_batch_meta a, products p, plant_list pl , plant_division pd
		  WHERE 
		   p.id=a.product_id and a.plant_id=pl.plant_id and a.unit_id=pd.unit_id ORDER BY a.id DESC";
		   
		return $this->fetchResult($query);
		
	}
	
	public function getPrintedNonPrintedCount($couponOrderId){
		$query = "select count(case when is_print=1 AND is_active=1 then 1 else null end) as printed, count(case when is_print=0 AND is_active=0 then 1 else null end) as nonPrinted 
		from coupon_codes where coupon_order_id='$couponOrderId' GROUP BY coupon_order_id ";
		return $this->fetchRow($query);
	}
	
	public function getPrintedNonPrintedCountCouponList($couponOrderArrayIds){
	    $couponOrderIds = rtrim(implode(",",$couponOrderArrayIds),",");
		$query = "select cc.coupon_order_id,cbm.is_trash,cbm.is_print,cbm.is_active,cbm.is_generated,count(case when cc.is_print=1 AND cc.is_active=1 then 1 else null end) as printed, count(case when cc.is_print=0 AND cc.is_active=0 then 1 else null end) as nonPrinted 
		from coupon_codes cc JOIN coupon_batch_meta cbm ON cbm.id=cc.coupon_order_id WHERE cc.coupon_order_id IN ($couponOrderIds) GROUP BY cc.coupon_order_id";
		return $this->fetchResult($query);
	}
	
	
	
	
	/*************** Middleware API function******************/
	public function getReadyToPrintCoupon($orderId=0,$plantId=0,$subcatId=0,$limit=10){
	    
	    $query="SELECT cbm.*,
	            cc.id as couponId,
			    cc.coupon_code as couponCode,
			    coupon_order_id,
			    cc.is_print,
			    cc.is_active,
			    cc.agmark_number_increment,
			    p.product_filed_2 as perGram,
		        p.product_name,
		        p.product_mrp,
		        p.product_exp_date
			FROM coupon_codes cc JOIN coupon_batch_meta cbm ON cbm.id=cc.coupon_order_id LEFT JOIN products p ON cbm.product_id=p.id WHERE cc.is_print=0 AND cc.is_active=0";
			
		    if($orderId)
			     $query .= " AND cc.coupon_order_id=$orderId "; 
			    
			if($plantId)
			    $query .= " AND cbm.plant_id=$plantId ";
			    
			if($subcatId)
			    $query .= " AND cbm.subcat_id=$subcatId ";
			    
		$query .= " ORDER BY cc.id ASC";
			
		    if($limit)
			     $query .= " LIMIT $limit";
			    
		 //echo $query; die;
	    
		return $this->fetchResult($query);
	}
	
    public function middlewareUpdateCoupon($couponIds){
	
		$this->updateCouponMetaIdFromCouponId($couponIds);
		
		$query="UPDATE coupon_codes SET is_print=1 , is_active=1 WHERE id IN ($couponIds)";  
		return $this->_query($query);
		
	}
	
	public function updateCouponMetaIdFromCouponId($couponIds){
	 	$query="SELECT GROUP_CONCAT(distinct(coupon_order_id)) as couponOrderIds FROM coupon_codes WHERE id IN ($couponIds)";  
		$rowData = $this->fetchRow($query);
		
		if(is_array($rowData) && count($rowData) > 0){
		    $couponOrderIds = $rowData['couponOrderIds'];
		    $activate = time();
		    $updatePrintSql="UPDATE coupon_batch_meta SET is_print=1 , is_active=1 , activated_on=$activate WHERE order_id IN ($couponOrderIds)";  
		    $this->_query($updatePrintSql);
		}
	}
	
	// start 15_02_2023
	
    public function get_ag_mark($plantId){
		$query = "SELECT is_ag_mark FROM `plant_list` WHERE plant_id=$plantId";
		return $this->fetchRow($query);
	}
	
	// end 15_02_2023
	
/*************** Middleware API function******************/

} // END CLASS


