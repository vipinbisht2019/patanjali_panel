<?php

class inventory extends dbclass {
	

	public function detail($id){
		$query = "SELECT * FROM `product_category` WHERE id=$id";
		return $this->fetchRow($query);
	}
	
	public function addCategory($data){
		return $this->_insertArray('product_category', $data);
	}
	
	public function updateCategory($id, $data){
		return $this->_update('product_category', $data, array('id'=>$id));
	}

	public function deleteCategory($id){
	    
	  $checkCouponExist = "SELECT cc.product_key as couponProductKey, p.category_id as productCategoryId,pc.parent_id as productParentCategoryId FROM product_category pc JOIN products p ON p.category_id=pc.id JOIN coupon_codes cc ON cc.product_key=p.product_key WHERE pc.parent_id=$id limit 1";  
	   
	  $checkCouponExistResult =  $this->_query($checkCouponExist);
	  
	  if($checkCouponExistResult['affected_rows']):
	      
	       return array('error'=>'Category would not delete !! Coupon has been generated for this category.');
	  else:
	     
		$checkNoSubCate = $this->_query("SELECT * FROM product_category WHERE parent_id=$id limit 1");

			if ($checkNoSubCate['affected_rows'])
				$query = "DELETE pc,pc1 FROM product_category pc,product_category pc1 WHERE pc.id=pc1.parent_id And pc.id=$id";
			else
				$query = "DELETE FROM product_category WHERE id=$id";

			return $this->_query($query);
		
	  endif;
	  
	}
	
	
	public function deleteSubCategory($id){
	    
	    $checkCouponExist = "SELECT cc.product_key as couponProductKey, p.category_id as productCategoryId,pc.parent_id as productParentCategoryId FROM product_category pc JOIN products p ON p.category_id=pc.id JOIN coupon_codes cc ON cc.product_key=p.product_key WHERE pc.id=$id limit 1"; 
	   
	  $checkCouponExistResult =  $this->_query($checkCouponExist);
	  
	  if($checkCouponExistResult['affected_rows']):
	      
	       return array('error'=>'Sub-Category would not delete !! Coupon has been generated for this category.');
	  else:
	     
		 $query="DELETE FROM product_category WHERE id=$id";
		 return $this->_query($query);
		
	  endif;
	  
	}

	public function mainCategoryList($filter){
		$query = "SELECT 
		    id, 
		    category_name as categoryName, 
		    description, 
		    is_ofa,
		    status
		  FROM 
		    product_category
		  WHERE 
		    parent_id=0
		";

		if(!empty($filter['categoryName'])){
			$categoryName = $filter['categoryName'];
			$query.=" AND category_name LIKE '%$categoryName%'";
		}

		$query.=" ORDER BY id DESC LIMIT 500";
		return $this->fetchResult($query);
	}

	public function subCategoryList($filter){
		$query = "SELECT 
		    c.id, 
		    c.parent_id as parentId,
		    c.category_name as categoryName, 
		    c.description,
		    (SELECT category_name FROM product_category WHERE id=c.parent_id) as mainCategoryName
		  FROM 
		    product_category c
		  WHERE 
		    c.parent_id > 0
		";

		if(!empty($filter['categoryName'])){
			$categoryName = $filter['categoryName'];
			$query.=" AND c.category_name LIKE '%$categoryName%'";
		}

		if(!empty($filter['parentId'])){
			$parentId = $filter['parentId'];
			$query.=" AND c.parent_id=$parentId%";
		}

		$query.=" ORDER BY c.id DESC LIMIT 500";
		return $this->fetchResult($query);
	}

	public function addProductImportLog($data){
		$result = $this->_insert('product_import_log', $data);
		return $result['insert_id'];
	}

	public function addBulkProduct($data){
		return $this->_insertArray('products', $data);
	}

	public function getAllotedProductKey(){
		$query = "SELECT product_key FROM products ORDER BY id ASC";
		$data = $this->fetchResult($query);
		if($data){
			foreach ($data as $key => $value) {
				$codes[] = $value['product_key'];
			}
			return $codes;
		} else {
			return array();
		}
	}


	//productList
	public function productList($filter){
		$query = "SELECT 
		    p.id, 
		    p.product_series as productSeries,
		    p.product_name as productName, 
		    p.product_mrp as productMrp, 
		    p.product_exp_date, 
		    p.product_filed_2, 
		    p.product_filed_3, 
		    (SELECT category_name FROM product_category WHERE id=p.category_id) as categoryName,
		    p.is_active as IsActive
		  FROM 
		    products p
		  WHERE 
		    p.id > 0
		";

		if(!empty($filter['productName'])){
			$productName = $filter['productName'];
			$query.=" AND p.category_name LIKE '%$productName%'";
		}

		if(!empty($filter['parentId'])){
			$parentId = $filter['parentId'];
			$query.=" AND p.parent_id=$parentId%";
		}

		$query.=" ORDER BY p.id DESC LIMIT 500";
		return $this->fetchResult($query);
	}

	public function dateReplace($dates){
		$d = explode('/', $dates);
		return $d[2].'-'.$d[1].'-'.$d[0];
	}

	public function getStartEndData($dates){

		$dates = explode(' - ', $dates);
		$d1 = explode('/',$dates[0]);
		$d2 = explode('/',$dates[1]);

		$date[0] = $d1[2].'-'.$d1[1].'-'.$d1[0];
		$date[1] = $d2[2].'-'.$d2[1].'-'.$d2[0];

		return $date;
	}

	public function deleteProduct($id){
		$this->_query("DELETE FROM coupon_master WHERE id=$id");
		$this->_query("DELETE FROM coupon_batch_master WHERE id=$id");
		return $this->_query("DELETE FROM products WHERE id=$id");
	}

	//coupon_batch_meta
	public function isCouponProduct($id){
		$query="SELECT id FROM coupon_batch_meta WHERE product_id=$id ORDER BY id DESC LIMIT 1";
		return $this->fetchRow($query);
	}
	
	
	public function updateProduct($id, $data){
		return $this->_update('products', $data, array('id'=>$id));
	}
	

	
} // END USER CLASS


