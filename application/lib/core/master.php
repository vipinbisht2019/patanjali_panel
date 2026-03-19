<?php

class master extends dbclass {
	
	public function __construct() {
		parent::__construct();
	}


	## SELECT LIST ##

	public function ajaxState(){
		$query="SELECT state_code as stateCode, state as stateName FROM state_city_town GROUP BY state_code ORDER BY stateName ASC";
		return $this->fetchResult($query);
	}

	public function ajaxCities($stateCode){
		$query="SELECT id, city_town_name as cityName FROM state_city_town WHERE state_code='$stateCode' ORDER BY city_town_name ASC";
		return $this->fetchResult($query);
	}

	public function ajaxMainCategory(){
		$query="SELECT  id, category_name as categoryName FROM product_category WHERE parent_id=0 ORDER BY category_name ASC";
		return $this->fetchResult($query);
	}

	public function ajaxSubCategory($id){
		$query="SELECT  id, category_name as categoryName FROM product_category WHERE parent_id=$id ORDER BY category_name ASC";
		return $this->fetchResult($query);
	}

	public function ajaxCategoryProduct($catId){
		$query="
		SELECT  
			id, product_exp_date,
			product_series as productSeries, 
			product_mrp as productMrp,
			product_name as productName 
		FROM products WHERE category_id=$catId ORDER BY product_series ASC";
		return $this->fetchResult($query);
	}

	public function ajaxProductBatch($productId,$plantId){
		$query="
		SELECT  
			id, 
			batch_size as batchSize
		FROM coupon_batch_master WHERE product_id=$productId AND plant_id=$plantId ORDER BY batch_size ASC";
		return $this->fetchResult($query);
	}

	public function ajaxProductValidity($productId,$plantId){
		$query="SELECT validity FROM coupon_master WHERE product_id=$productId AND plant_id=$plantId ORDER BY id ASC LIMIT 1";
		$data = $this->fetchRow($query);
		return ($data) ? $data['validity'] : '';
	}

	public function ajaxProductBatchQty($batchId){
		$query="
		SELECT  
			c.id, 
			c.qty, 
			c.face_value_id as faceValueId, 
			b.face_value as faceValue
		FROM coupon_batch_qty c, coupon_master b 
		WHERE b.id=c.face_value_id AND c.coupon_batch_id=$batchId 
		ORDER BY b.face_value ASC";
		return $this->fetchResult($query);
	}


	## COUPON STATE LIST ##
	public function ajaxCouponState(){
		$query="SELECT DISTINCT(state) as stateName FROM scanned_coupons ORDER BY state ASC";
		return $this->fetchResult($query);
	}

	## COUPON CITY LIST ##
	public function ajaxCouponCity($stateName){
		$query="SELECT DISTINCT(city) as cityName FROM scanned_coupons WHERE state='$stateName' ORDER BY city ASC";
		return $this->fetchResult($query);
	}
	
	
	public function ajaxGroupList(){
		$query="SELECT * FROM group_company ORDER BY name ASC";
		return $this->fetchResult($query);
	}

    // start 11_april_2023
    
    public function ajaxGroupListNew($id){
	    $query="SELECT * FROM group_company where id ='$id' ";
		$data = $this->fetchRow($query);
		return $data['name'];
	}
	
	// end 11_april_2023
	
// start 12_may_2023	
	
	public function ajaxGetGroupList(){
		$query = "SELECT * FROM `groups` ORDER BY name ASC";
		return $this->fetchResult($query);
	}
	
	public function ajaxGroupId($groupId){
		$query = "SELECT * FROM sub_groups WHERE group_id=$groupId ORDER BY name ASC";
		return $this->fetchResult($query);
	}
	
	public function ajaxSubGroupId($groupId,$subGroupId){
    $query = "SELECT * FROM group_company WHERE group_id=$groupId and sub_group_id=$subGroupId ORDER BY name ASC"; 
		return $this->fetchResult($query);
	}
	
	public function ajaxGetSubGroupList(){
		$query = "SELECT * FROM sub_groups ORDER BY name ASC";
		return $this->fetchResult($query);
	}
	
// end 12_may_2023

		
} // END CLASS