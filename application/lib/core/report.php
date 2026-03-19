<?php

class report extends dbclass {


	public function scanTrendModuleweek($filter){

		
		$start_date = $filter['start_date'];
		$end_date = $filter['end_date'];
		
		
			$subQuery="";
	
			
	
			$query = "SELECT 
			   
				count(s.coupon_id) as  num
				
			  FROM 
				scanned_coupons s,users u, coupon_codes c, coupon_batch_meta m
			  WHERE 
			  
				m.id=c.coupon_order_id AND 
				c.id=s.coupon_id AND 
				u.id=s.user_id AND
				date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
			";
			
			if(!empty($filter['plantId']))
				$query.=" AND m.plant_id=".$filter['plantId'];
			
				if(!empty($filter['customerType'])){
					$customerType = $filter['customerType'];
					$query.=" AND u.user_role_id='$customerType' ";
				}
				
			if(!empty($filter['categoryId'])){
	
				$categoryId = $filter['categoryId'];
				$query.=" AND m.category_id=$categoryId";
				//$query.=" GROUP BY sdate";
			} else {
				//$query.=" GROUP BY sdate";
			}
	
			//$query.=" ORDER BY s.scanned_on ASC";
			//echo $query;
			
			$result =  $this->fetchResult($query);
			//print_r($result);
			if($result){
				return $result;
			} else {
				return array();
			}
		}
		public function scanTrendCustomerweek($filter){
	
			
			$start_date = $filter['start_date'];
			$end_date = $filter['end_date'];
			
			
				$subQuery="";
		
				
		
				$query = "SELECT 
				   count(DISTINCT u.id) as ucount
					FROM 
					scanned_coupons s, coupon_codes c, coupon_batch_meta m,users u
				  WHERE 
				  
					m.id=c.coupon_order_id AND 
					c.id=s.coupon_id AND 
					u.id=s.user_id AND 
					date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
				";
				
				if(!empty($filter['plantId']))
					$query.=" AND m.plant_id=".$filter['plantId'];
				
					if(!empty($filter['customerType'])){
						$customerType = $filter['customerType'];
						$query.=" AND u.user_role_id='$customerType' ";
					}
					
				if(!empty($filter['categoryId'])){
		
					$categoryId = $filter['categoryId'];
					$query.=" AND m.category_id=$categoryId";
					//$query.=" GROUP BY sdate";
				} else {
					//$query.=" GROUP BY sdate";
				}
		
			//	$query.=" ORDER BY s.scanned_on ASC";
			//	echo $query;
				
				$result =  $this->fetchResult($query);
				//print_r($result);
				if($result){
					return $result;
				} else {
					return array();
				}
			}
	
	
			public function scanTrendModulemonth($filter){
	
			
				$year = $filter['year'];
				
				
				
					$subQuery="";
			
					
			
					$query = "SELECT 
					   
						count(s.coupon_id) as  num,
						DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m') AS month
							
						
					  FROM 
						scanned_coupons s,users u, coupon_codes c, coupon_batch_meta m
					  WHERE 
					  
						m.id=c.coupon_order_id AND 
						c.id=s.coupon_id AND 
						u.id=s.user_id AND
						date_format(CONVERT_TZ(FROM_UNIXTIME(scanned_on),'+00:00','+05:30'),'%Y-%m') BETWEEN '$year-01' AND '$year-12'";
					
					if(!empty($filter['plantId']))
						$query.=" AND m.plant_id=".$filter['plantId'];
					
						if(!empty($filter['customerType'])){
							$customerType = $filter['customerType'];
							$query.=" AND u.user_role_id='$customerType' ";
						}
						
					if(!empty($filter['categoryId'])){
			
						$categoryId = $filter['categoryId'];
						$query.=" AND m.category_id=$categoryId";
						//$query.=" GROUP BY sdate";
					} else {
						//$query.=" GROUP BY sdate";
					}
			
					$query.=" GROUP BY month ORDER BY s.scanned_on ASC";
					//echo $query;
					
					$result =  $this->fetchResult($query);
					//print_r($result);
					if($result){
						return $result;
					} else {
						return array();
					}
				}
				public function scanTrendCustomermonth($filter){
			
					
					$year = $filter['year'];
					
					
					
						$subQuery="";
				
						
				
						$query = "SELECT 
						   count(DISTINCT u.id) as ucount,
							DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m') AS month
							FROM 
							scanned_coupons s, coupon_codes c, coupon_batch_meta m,users u
						  WHERE 
						  
							m.id=c.coupon_order_id AND 
							c.id=s.coupon_id AND 
							u.id=s.user_id AND
							date_format(CONVERT_TZ(FROM_UNIXTIME(scanned_on),'+00:00','+05:30'),'%Y-%m') BETWEEN '$year-01' AND '$year-12'";
						
						if(!empty($filter['plantId']))
							$query.=" AND m.plant_id=".$filter['plantId'];
						
							if(!empty($filter['customerType'])){
								$customerType = $filter['customerType'];
								$query.=" AND u.user_role_id='$customerType' ";
							}
							
						if(!empty($filter['categoryId'])){
				
							$categoryId = $filter['categoryId'];
							$query.=" AND m.category_id=$categoryId";
							//$query.=" GROUP BY sdate";
						} else {
							//$query.=" GROUP BY sdate";
						}
				
						$query.="  GROUP BY month ORDER BY s.scanned_on ASC";
						//echo $query;
						
						$result =  $this->fetchResult($query);
						//print_r($result);
						if($result){
							return $result;
						} else {
							return array();
						}
					}
		

    public function scanTrendModuleByDate($filter){

		$startYear = $filter['year'];
		$endYear = $filter['year'] + 1;
		
	$start = $month = strtotime("$startYear-04-01");
	$end = strtotime("$endYear-03-30");
	$selected_moth =  $filter['month'];
	
	$days  = cal_days_in_month(CAL_GREGORIAN,$selected_moth,$startYear);
	$start_date = $startYear.'-'.$selected_moth.'-'.'01';
	$end_date = $startYear.'-'.$selected_moth.'-'.$days;
	
	
		$subQuery="";

		if(!empty($filter['productId'])){

			$subQuery=" m.product_id as moduleId, (SELECT product_name FROM products WHERE id=m.product_id) as moduleName, (SELECT product_series FROM products WHERE id=m.product_id) as productSeries, ";

		} else if(!empty($filter['subCategoryId'])){

			$subQuery=" m.product_id as moduleId, (SELECT product_name FROM products WHERE id=m.product_id) as moduleName,(SELECT product_series FROM products WHERE id=m.product_id) as productSeries, ";

		} else if(!empty($filter['categoryId'])){

			$subQuery=" p.category_id as moduleId, (SELECT category_name FROM product_category WHERE id=p.category_id) as moduleName, ";

		} else {

			$subQuery=" m.category_id as moduleId, (SELECT category_name FROM product_category WHERE id=m.category_id) as moduleName, ";
		}

		$query = "SELECT 
		    SUM(s.points) as point,
		    count(s.coupon_id) as num, ".$subQuery."
		    date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m-%d') as sdate
		  FROM 
		    scanned_coupons s, coupon_codes c, coupon_batch_meta m, products p
		  WHERE 
		  	p.id=m.product_id AND
		    m.id=c.coupon_order_id AND 
		    c.id=s.coupon_id AND 
		    date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
		";
		
		if(!empty($filter['plantId']))
	        $query.=" AND m.plant_id=".$filter['plantId'];
			
        if(!empty($filter['divisionId']))
	        $query.=" AND m.unit_id=".$filter['divisionId'];

		if(!empty($filter['state'])){
			$state = $filter['state'];
			$query.=" AND s.state='$state' ";

			if(!empty($filter['city'])){
				$city = $filter['city'];
				$query.=" AND s.city='$city' ";
			}
		}

		if(!empty($filter['productId'])){

			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";
			$query.=" GROUP BY sdate, m.product_id ";

		} else if(!empty($filter['subCategoryId'])){

			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id=$subCategoryId)";
			$query.=" GROUP BY sdate, m.product_id";

		} else if(!empty($filter['categoryId'])){

			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
			$query.=" GROUP BY sdate, p.category_id ";
		} else {
			$query.=" GROUP BY sdate, m.category_id ";
		}

		$query.=" ORDER BY s.scanned_on ASC";
	//	echo $query;
		
		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return array();
		}
	}



public function scanTrendModuleChart($filter){

	$startYear = $filter['year'];
	$endYear = $filter['year'] + 1;


	$subQuery="";

	if(!empty($filter['productId'])){

		$subQuery=" m.product_id as moduleId, (SELECT product_name FROM products WHERE id=m.product_id) as moduleName, (SELECT product_series FROM products WHERE id=m.product_id) as productSeries, ";

	} else if(!empty($filter['subCategoryId'])){

		$subQuery=" m.product_id as moduleId, (SELECT product_name FROM products WHERE id=m.product_id) as moduleName,(SELECT product_series FROM products WHERE id=m.product_id) as productSeries, ";

	} else if(!empty($filter['categoryId'])){

		$subQuery=" p.category_id as moduleId, (SELECT category_name FROM product_category WHERE id=p.category_id) as moduleName, ";

	} else {

		$subQuery=" m.category_id as moduleId, (SELECT category_name FROM product_category WHERE id=m.category_id) as moduleName, ";
	}

	$query = "SELECT 
		SUM(s.points) as point,
		count(s.coupon_id) as num, "."
		date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m') as month
	  FROM 
		scanned_coupons s, coupon_codes c, coupon_batch_meta m, products p
	  WHERE 
		  p.id=m.product_id AND
		m.id=c.coupon_order_id AND 
		c.id=s.coupon_id AND 
		date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m') BETWEEN '$startYear-04' AND '$endYear-03'
	";
	
	if(!empty($filter['plantId']))
		$query.=" AND m.plant_id=".$filter['plantId'];
		
	if(!empty($filter['divisionId']))
		$query.=" AND m.unit_id=".$filter['divisionId'];

	if(!empty($filter['state'])){
		$state = $filter['state'];
		$query.=" AND s.state='$state' ";

		if(!empty($filter['city'])){
			$city = $filter['city'];
			$query.=" AND s.city='$city' ";
		}
	}

	if(!empty($filter['productId'])){

		$productId = $filter['productId'];
		$query.=" AND m.product_id=$productId";
		//$query.=" GROUP BY month, m.product_id ";

	} else if(!empty($filter['subCategoryId'])){

		$subCategoryId = $filter['subCategoryId'];
		$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id=$subCategoryId)";
		//$query.=" GROUP BY month, m.product_id";

	} else if(!empty($filter['categoryId'])){

		$categoryId = $filter['categoryId'];
		$query.=" AND m.category_id=$categoryId";
	//	$query.=" GROUP BY month, p.category_id ";
	} else {
		//$query.=" GROUP BY month, m.category_id ";
	}
	$query.=" GROUP BY month";
	$query.=" ORDER BY s.scanned_on ASC";
	// echo $query;
	// die;
	
	
	$result =  $this->fetchResult($query);
	if($result){
		return $result;
	} else {
		return array();
	}
}

	public function scanTrendModule($filter){

		$startYear = $filter['year'];
		$endYear = $filter['year'] + 1;


		$subQuery="";

		if(!empty($filter['productId'])){

			$subQuery=" m.product_id as moduleId, (SELECT product_name FROM products WHERE id=m.product_id) as moduleName, (SELECT product_series FROM products WHERE id=m.product_id) as productSeries, ";

		} else if(!empty($filter['subCategoryId'])){

			$subQuery=" m.product_id as moduleId, (SELECT product_name FROM products WHERE id=m.product_id) as moduleName,(SELECT product_series FROM products WHERE id=m.product_id) as productSeries, ";

		} else if(!empty($filter['categoryId'])){

			$subQuery=" p.category_id as moduleId, (SELECT category_name FROM product_category WHERE id=p.category_id) as moduleName, ";

		} else {

			$subQuery=" m.category_id as moduleId, (SELECT category_name FROM product_category WHERE id=m.category_id) as moduleName, ";
		}

		$query = "SELECT 
		    SUM(s.points) as point,
		    count(s.coupon_id) as num, ".$subQuery."
		    date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m') as month
		  FROM 
		    scanned_coupons s, coupon_codes c, coupon_batch_meta m, products p
		  WHERE 
		  	p.id=m.product_id AND
		    m.id=c.coupon_order_id AND 
		    c.id=s.coupon_id AND 
		    date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m') BETWEEN '$startYear-04' AND '$endYear-03'
		";
		
		if(!empty($filter['plantId']))
	        $query.=" AND m.plant_id=".$filter['plantId'];
			
        if(!empty($filter['divisionId']))
	        $query.=" AND m.unit_id=".$filter['divisionId'];

		if(!empty($filter['state'])){
			$state = $filter['state'];
			$query.=" AND s.state='$state' ";

			if(!empty($filter['city'])){
				$city = $filter['city'];
				$query.=" AND s.city='$city' ";
			}
		}

		if(!empty($filter['productId'])){

			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";
			$query.=" GROUP BY month, m.product_id ";

		} else if(!empty($filter['subCategoryId'])){

			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id=$subCategoryId)";
			$query.=" GROUP BY month, m.product_id";

		} else if(!empty($filter['categoryId'])){

			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
			$query.=" GROUP BY month, p.category_id ";
		} else {
			$query.=" GROUP BY month, m.category_id ";
		}

		$query.=" ORDER BY s.scanned_on ASC";
		
		
		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return array();
		}
	}
	
	public function locationScanedTrend($filter){

		$startYear = $filter['year'];
		$endYear = $filter['year'] + 1;
		$query = "SELECT 
		    s.state, 
		    s.city,
		    SUM(s.points) as point,
		    count(s.coupon_id) as num,
		    date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m') as month
		  FROM 
		    scanned_coupons s, coupon_codes c, coupon_batch_meta m
		  WHERE 
		    m.id=c.coupon_order_id AND 
		    c.id=s.coupon_id AND 
		    date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m') BETWEEN '$startYear-04' AND '$endYear-03'
		";

        if(!empty($filter['plantId']))
	        $query.=" AND m.plant_id=".$filter['plantId'];
			
        if(!empty($filter['divisionId']))
	        $query.=" AND m.unit_id=".$filter['divisionId'];

		if(!empty($filter['productId'])){

			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";

		} else if(!empty($filter['subCategoryId'])){

			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id=$subCategoryId)";

		} else if(!empty($filter['categoryId'])){

			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
		}


		if(!empty($filter['state'])){
			$state = $filter['state'];
			$query.=" AND s.state='$state' ";

			if(!empty($filter['city'])){
				$city = $filter['city'];
				$query.=" AND s.city='$city' ";
			}

			$query.=" GROUP BY month, city ";
		} else {
			$query.=" GROUP BY month, state ";
		}

		$query.=" ORDER BY s.scanned_on ASC";
		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return array();
		}
	}
	
	
// start 15_may_2023
	public function scanTrendCustomerByDate($filter){
		// print_r($filter);
		// exit;
		$startYear = $filter['year'];
	//	echo "<br>";
		 $endYear = $filter['year'];
			
		 $start = $month = strtotime("$startYear-01-01");
		$end = strtotime("$endYear-12-31");
		//echo "<br>";
		$selected_moth =  $filter['month'];
				
		$days  = cal_days_in_month(CAL_GREGORIAN,$selected_moth,$startYear);
		$start_date = $startYear.'-'.$selected_moth.'-'.'01';
		$end_date = $startYear.'-'.$selected_moth.'-'.$days;

	$query="SELECT 
		SUM(s.points) AS point,
		COUNT(s.coupon_id) AS num,
		date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m-%d') as sdate,
		u.id AS userId,
		u.name,
		u.dealerCode,
		u.mobile,
		u.user_role_id AS userRoleId,
		u.company_group_id,
		COALESCE(gc.name, 'NA') as beat
	FROM 
		scanned_coupons s
		INNER JOIN users u ON u.id = s.user_id
		LEFT JOIN group_company gc ON gc.id = u.company_group_id
		INNER JOIN coupon_codes c ON c.id = s.coupon_id
		INNER JOIN coupon_batch_meta m ON m.id = c.coupon_order_id
	WHERE 
		date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
	";

	/*	$query1 = "
		  SELECT 
			SUM(s.points) as point,
			count(s.coupon_id) as num,
			date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m-%d') as sdate,
			u.id as userId,
			u.name,
			u.dealerCode,
			u.mobile,
			u.user_role_id as userRoleId,
			u.company_group_id
		  FROM 
			scanned_coupons s, users u, coupon_codes c, coupon_batch_meta m
		  WHERE 
			  m.id=c.coupon_order_id AND 
			  c.id=s.coupon_id AND 
			  u.id=s.user_id AND 
			  date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
			";

			*/
		
		 if(!empty($filter['plantId']))
			$query.=" AND m.plant_id=".$filter['plantId'];
			
		if(!empty($filter['divisionId']))
			$query.=" AND m.unit_id=".$filter['divisionId'];
			      
		if(!empty($filter['companyId']))
	        $query.=" AND u.company_group_id=".$filter['companyId'];

		if(!empty($filter['customerType'])){
			$customerType = $filter['customerType'];
			$query.=" AND u.user_role_id='$customerType' ";
		}
	
		if(!empty($filter['productId'])){
			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";
	
		} else if(!empty($filter['subCategoryId'])){
			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id='$subCategoryId')";
	
		} else if(!empty($filter['categoryId'])){
			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
		}
	
		if(!empty($filter['state'])){
			$state = $filter['state'];
			$query.=" AND s.state='$state' ";
	
			if(!empty($filter['city'])){
				$city = $filter['city'];
				$query.=" AND s.city='$city' ";
			}
	
			$query.=" GROUP BY sdate, s.user_id ";
		} else {
			$query.=" GROUP BY sdate, s.user_id ";
		}
		
		//$query.=" GROUP BY month, s.user_id ";
		$query.=" ORDER BY s.user_id ASC";
		//echo $query; die;
		$results =  $this->fetchResult($query);
		
		$data_new = $results;
		
		// start 13_02_2022 today
	/*
	$data_new = array();
	
	if(!empty($filter['companyId'])){
	
	//	echo "<pre>"; print_r($filter); die;
	
	if(!empty($results)) {
	foreach($results as $keys => $rowData)
	{
	
		$company_group_ids = $rowData['company_group_id'];
	
		$com_id = explode(",",$company_group_ids);	
	
		foreach($com_id as $newdata_row)		
		{
			$results2=array();
		if($newdata_row == $filter['companyId'])
			{
			$results2['point']=$rowData['point'];
			$results2['num']=$rowData['num'];
			$results2['sadte']=$rowData['sdate'];
			$results2['userId']=$rowData['userId'];
			$results2['name']=$rowData['name'];
			$results2['dealerCode']=$rowData['dealerCode'];
			$results2['mobile']=$rowData['mobile'];
			$results2['userRoleId']=$rowData['userRoleId'];
			$results2['company_group_id']=$rowData['company_group_id'];
			
		}
		else {
			continue;
	
		}
			array_push($data_new , $results2);
	
		}
	}
	}
	else {
	$data_new = $results;
	
	}
	
	} else 
	{
	$data_new = $results;
	
	}

	*/
	
	
	// end 13_02_2022 today
		
		
		if($data_new){
			return $data_new;
		} else {
			return array();
		}
	}
		
// end 15_may_2023	
	
// start 27_march_2023

	public function scanTrendCustomerMonthly($filter){		
		
		$monthly = $filter['year'];
		
		$endYear = $filter['year'] + 1;
		
		$query = "
		  SELECT 
		    SUM(s.points) as point,
		    count(s.coupon_id) as num,
		    date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%m') as month,
			date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%d') as date,
		    u.id as userId,
		    u.name,
		    u.dealerCode,
		    u.mobile,
		    u.user_role_id as userRoleId,
		    u.company_group_id
		  FROM 
		    scanned_coupons s, users u, coupon_codes c, coupon_batch_meta m
		  WHERE 
		  	m.id=c.coupon_order_id AND 
		  	c.id=s.coupon_id AND 
		  	u.id=s.user_id AND 
		  	date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'),'%m') = $monthly
		";
		
		 if(!empty($filter['plantId']))
	        $query.=" AND m.plant_id=".$filter['plantId'];
			
        if(!empty($filter['divisionId']))
	        $query.=" AND m.unit_id=".$filter['divisionId'];

		if(!empty($filter['customerType'])){
			$customerType = $filter['customerType'];
			$query.=" AND u.user_role_id='$customerType' ";
		}

		if(!empty($filter['productId'])){
			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";

		} else if(!empty($filter['subCategoryId'])){
			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id='$subCategoryId')";

		} else if(!empty($filter['categoryId'])){
			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
		}

        if(!empty($filter['state'])){
			$state = $filter['state'];
			$query.=" AND s.state='$state' ";

			if(!empty($filter['city'])){
				$city = $filter['city'];
				$query.=" AND s.city='$city' ";
			}

			$query.=" GROUP BY date, s.user_id ";
		} else {
			$query.=" GROUP BY date, s.user_id ";
		}
		
		//$query.=" GROUP BY month, s.user_id ";
		$query.=" ORDER BY s.user_id ASC";
		
		$results =  $this->fetchResult($query);
		
	
	$data_new = array();
	
if(!empty($filter['companyId'])){

//	echo "<pre>"; print_r($filter); die;

if(!empty($results)) {
foreach($results as $keys => $rowData)
{
	
		$company_group_ids = $rowData['company_group_id'];

		$com_id = explode(",",$company_group_ids);	

		foreach($com_id as $newdata_row)		
		{
			$results2=array();
		if($newdata_row == $filter['companyId'])
			{
			$results2['point']=$rowData['point'];
			$results2['num']=$rowData['num'];
			$results2['month']=$rowData['month'];
			$results2['userId']=$rowData['userId'];
			$results2['name']=$rowData['name'];
			$results2['dealerCode']=$rowData['dealerCode'];
			$results2['mobile']=$rowData['mobile'];
			$results2['userRoleId']=$rowData['userRoleId'];
			$results2['company_group_id']=$rowData['company_group_id'];
			
		}
		else {
			continue;

		}
			array_push($data_new , $results2);

		}
}
}
else {
	$data_new = $results;

}

 } else 
 {
	$data_new = $results;

 }


		if($data_new){
			return $data_new;
		} else {
			return array();
		}
	}
	
	
// end 27_march_2023
	



	public function scanTrendCustomer($filter){
	    
	 //   echo "<pre>"; print_r($filter); die;
	    
	    /*	$startMonth = $filter['monthStart'];
	    	$startYear = $filter['yearStart'];
	    	$endMonth = $filter['monthEnd'];
	    	$endYear = $filter['yearEnd'];
	    */	
	    	
	   $startYear = $filter['year'];
		$endYear = $filter['year']; 	
	    
	//	$startYear = $filter['year'];
	//	$endYear = $filter['year'] + 1;
		$query="SELECT 
    SUM(s.points) AS point,
    COUNT(s.coupon_id) AS num,
    DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m') AS month,
    u.id AS userId,
    u.name,
    u.dealerCode,
    u.mobile,
    u.user_role_id AS userRoleId,
    u.company_group_id,
    COALESCE(gc.name, 'NA') as beat
FROM 
    scanned_coupons s
    INNER JOIN users u ON u.id = s.user_id
    LEFT JOIN group_company gc ON gc.id = u.company_group_id
    INNER JOIN coupon_codes c ON c.id = s.coupon_id
    INNER JOIN coupon_batch_meta m ON m.id = c.coupon_order_id
WHERE 
    DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m') BETWEEN '$startYear-01' AND '$endYear-12'
";
		$query1 = "
		  SELECT 
		    SUM(s.points) as point,
		    count(s.coupon_id) as num,
		    date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m') as month,
		    u.id as userId,
		    u.name,
		    u.dealerCode,
		    u.mobile,
		    u.user_role_id as userRoleId,
		    u.company_group_id
		  FROM 
		    scanned_coupons s, users u, coupon_codes c, coupon_batch_meta m
		  WHERE 
		  	m.id=c.coupon_order_id AND 
		  	c.id=s.coupon_id AND 
		  	u.id=s.user_id AND 
		  	date_format(CONVERT_TZ(FROM_UNIXTIME(scanned_on),'+00:00','+05:30'),'%Y-%m') BETWEEN '$startYear-$startMonth' AND '$endYear-$endMonth'
		";
		
		 if(!empty($filter['plantId']))
	        $query.=" AND m.plant_id=".$filter['plantId'];
			
        if(!empty($filter['divisionId']))
	        $query.=" AND m.unit_id=".$filter['divisionId'];
	        
	     if(!empty($filter['companyId']))
	        $query.=" AND u.company_group_id=".$filter['companyId'];

		if(!empty($filter['customerType'])){
			$customerType = $filter['customerType'];
			$query.=" AND u.user_role_id='$customerType' ";
		}

		if(!empty($filter['productId'])){
			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";

		} else if(!empty($filter['subCategoryId'])){
			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id='$subCategoryId')";

		} else if(!empty($filter['categoryId'])){
			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
		}

        if(!empty($filter['state'])){
			$state = $filter['state'];
			$query.=" AND s.state='$state' ";

			if(!empty($filter['city'])){
				$city = $filter['city'];
				$query.=" AND s.city='$city' ";
			}

			$query.=" GROUP BY month, s.user_id ";
		} else {
			$query.=" GROUP BY month, s.user_id ";
		}
		
		//$query.=" GROUP BY month, s.user_id ";
		$query.=" ORDER BY s.user_id ASC";
	//	echo $query; die;
		$results =  $this->fetchResult($query);
		
		$data_new = $results;
		
		
		// start 13_02_2022 today

//	$data_new = array();
	/*
if(!empty($filter['companyId'])){
// echo "not empty"; die;
//	echo "<pre>"; print_r($filter); die;

if(!empty($results)) {
foreach($results as $keys => $rowData)
{
	
		$company_group_ids = $rowData['company_group_id'];

		$com_id = explode(",",$company_group_ids);	

		foreach($com_id as $newdata_row)		
		{
			$results2=array();
		if($newdata_row == $filter['companyId'])
			{
			$results2['point']=$rowData['point'];
			$results2['num']=$rowData['num'];
			$results2['month']=$rowData['month'];
			$results2['userId']=$rowData['userId'];
			$results2['name']=$rowData['name'];
			$results2['dealerCode']=$rowData['dealerCode'];
			$results2['mobile']=$rowData['mobile'];
			$results2['userRoleId']=$rowData['userRoleId'];
			$results2['company_group_id']=$rowData['company_group_id'];
			
		}
		else {
			continue;

		}
			array_push($data_new , $results2);

		}
}
}
else {
	$data_new = $results;

}

 } else 
 {
    // echo "empty"; die;
	$data_new22 = $results;
	
		foreach($data_new22 as $newdata_row)		
		{
			$results2=array();
		
			$results2['point']=$newdata_row['point'];
			$results2['num']=$newdata_row['num'];
			$results2['month']=$newdata_row['month'];
			$results2['userId']=$newdata_row['userId'];
			$results2['name']=$newdata_row['name'];
			$results2['dealerCode']=$newdata_row['dealerCode'];
			$results2['mobile']=$newdata_row['mobile'];
			$results2['userRoleId']=$newdata_row['userRoleId'];
			$results2['company_group_id']=$newdata_row['company_group_id'];
		
			
			array_push($data_new , $results2);
		}
		
	
	
//	echo "<pre>"; print_r($data_new); die;
	
	
	
	

 }
*/

// end 13_02_2022 today
		
	//	echo "<pre>"; print_r($data_new); die;
		if($data_new){
			return $data_new;
		} else {
			return array();
		}
	}

	public function pointSummary($filter){
		$startYear = $filter['year'];
		$endYear = $filter['year'] + 1;
		$userRoleId = $filter['customerType'];
		$query = "
		  SELECT 
		    u.id as userId,
		    u.name as customerName,
		    u.dealerCode,
		    u.mobile as customerMobile,
		    u.user_role_id as userRoleId,
		    (SELECT SUM(points) FROM scanned_coupons WHERE user_id=u.id AND date_format(CONVERT_TZ(FROM_UNIXTIME(scanned_on),'+00:00','+05:30'),'%Y-%m') BETWEEN '$startYear-01' AND '$startYear-12') as scannedPoints,
		    (SELECT SUM(points) FROM received_coupons WHERE user_id=u.id AND FROM_UNIXTIME(created_on, '%Y-%m') BETWEEN '$startYear-01' AND '$startYear-12') as receivedPoints,
		    u.current_point_balance as balance
		  FROM 
		    users u 
		  WHERE 
		  
		";
		
		$j=0;
		
		if(!empty($filter['customerType']))
		{
	        $query.=" u.user_role_id=".$filter['customerType'];
	        $j++;
		}
		
		if(!empty($filter['plantId']))
	    {
	        $query.=" AND m.plant_id=".$filter['plantId'];
	        $j++;
	    }	
        if(!empty($filter['divisionId']))
        {
	        $query.=" AND m.unit_id=".$filter['divisionId'];
	        $j++;
        }
        
		if(!empty($filter['state'])){
			$state = $filter['state'];
			$query.=" AND u.state='$state' ";
			$j++;
		}

		if(!empty($filter['city'])){
				$city = $filter['city'];
				$query.=" AND u.city='$city' ";
				$j++;
		}
		
    if($j == 0){
        $query.=" 1"; 
    }
        
    
		$query.=" ORDER BY u.id ASC";
		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return false;
		}
	}
	
	
	public function encashmentPending($filter){

		$date = $filter['date'];
		$query = "SELECT 
				count(s.id) as num,
		    SUM(s.points) as point,
		    u.user_role_id as userRoleId,
		    m.product_id as productId,
		    p.product_name as productName,
		    p.product_series as productSeries,
		    p.category_id as subCategoryId,
		    (SELECT category_name FROM product_category WHERE id=p.category_id) as subCategoryName,
		    m.category_id as categoryId,
		    (SELECT category_name FROM product_category WHERE id=m.category_id) as categorName
		  FROM 
		    scanned_coupons s, users u, coupon_codes c, coupon_batch_meta m, products p 
		  WHERE p.id=m.product_id AND m.id=c.coupon_order_id AND c.id=s.coupon_id AND u.id=s.user_id AND s.is_transferred=0
		";
		
		if(!empty($filter['plantId']))
	        $query.=" AND m.plant_id=".$filter['plantId'];
			
        if(!empty($filter['divisionId']))
	        $query.=" AND m.unit_id=".$filter['divisionId'];

		if(!empty($filter['state'])){
			$state = $filter['state'];
			$query.=" AND s.state='$state' ";

			if(!empty($filter['city'])){
				$city = $filter['city'];
				$query.=" AND s.city='$city' ";
			}
		}

		if(!empty($filter['productId'])){

			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";
			$query.=" GROUP BY u.user_role_id";

		} else if(!empty($filter['subCategoryId'])){

			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND p.category_id=$subCategoryId";
			$query.=" GROUP BY u.user_role_id, m.product_id";

		} else if(!empty($filter['categoryId'])){

			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
			$query.=" GROUP BY u.user_role_id, p.category_id";

		} else {
			$query.=" GROUP BY u.user_role_id, m.category_id";
		}

		$query.=" ORDER BY s.scanned_on ASC";
		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return false;
		}
	}

	public function encashmentPendingReceived($filter){

		$date = $filter['date'];
		$query = "SELECT 
				count(s.id) as num,
		    SUM(s.points) as point,
		    u.user_role_id as userRoleId,
		    m.product_id as productId,
		    p.product_name as productName,
		     p.product_series as productSeries,
		    p.category_id as subCategoryId,
		    (SELECT category_name FROM product_category WHERE id=p.category_id) as subCategoryName,
		    m.category_id as categoryId,
		    (SELECT category_name FROM product_category WHERE id=m.category_id) as categorName
		  FROM 
		    received_coupons s, users u, coupon_codes c, coupon_batch_meta m, products p 
		  WHERE p.id=m.product_id AND m.id=c.coupon_order_id AND c.id=s.coupon_id AND u.id=s.user_id AND s.is_transferred=0 AND u.user_role_id > 1
		";

		if(!empty($filter['state'])){
				//$state = $filter['state'];
				//$query.=" AND s.state='$state' ";

			if(!empty($filter['city'])){
				//$city = $filter['city'];
				//$query.=" AND s.city='$city' ";
			}
		}
		
		if(!empty($filter['plantId']))
	        $query.=" AND m.plant_id=".$filter['plantId'];
			
        if(!empty($filter['divisionId']))
	        $query.=" AND m.unit_id=".$filter['divisionId'];

		if(!empty($filter['productId'])){

			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";
			$query.=" GROUP BY u.user_role_id";

		} else if(!empty($filter['subCategoryId'])){

			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND p.category_id=$subCategoryId";
			$query.=" GROUP BY u.user_role_id, m.product_id";

		} else if(!empty($filter['categoryId'])){

			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
			$query.=" GROUP BY u.user_role_id, p.category_id";

		} else {
			$query.=" GROUP BY u.user_role_id, m.category_id";
		}

		$query.=" ORDER BY s.transferred_on ASC";
		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return false;
		}
	}

	public function getTotalIssuedPoints($filter){

		$subQuery="";
		if(!empty($filter['productId'])){
			$subQuery=" m.product_id as moduleId, (SELECT product_name FROM products WHERE id=m.product_id) as moduleName ";
		} else if(!empty($filter['subCategoryId'])){
			$subQuery=" m.product_id as moduleId, (SELECT product_name FROM products WHERE id=m.product_id) as moduleName ";
		} else if(!empty($filter['categoryId'])){
			$subQuery=" p.category_id as moduleId, (SELECT category_name FROM product_category WHERE id=p.category_id) as moduleName ";
		} else {
			$subQuery=" m.category_id as moduleId, (SELECT category_name FROM product_category WHERE id=m.category_id) as moduleName ";
		}

		$query = "SELECT 
				SUM(v.qty) as num,
		    SUM(v.face_value * v.qty) as point, ".$subQuery."
		  FROM 
		    coupon_batch_meta m, coupon_batch_meta_values v, products p
		  WHERE p.id=m.product_id AND v.coupon_order_id=m.id AND m.is_trash=0
		";

		$Y = $filter['year'];
		$EY = $Y;
		$startDate = $Y.'-01-01';
		$endDate =  $EY.'-12-31';
		$query.=" AND (m.date_of_mfg BETWEEN '$startDate' AND '$endDate')";
		
		if(!empty($filter['plantId']))
			$query.=" AND m.plant_id=".$filter['plantId'];
			
	    if(!empty($filter['divisionId']))
			$query.=" AND m.unit_id=".$filter['divisionId'];



		if(!empty($filter['productId'])){
			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['subCategoryId'])){
			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id='$subCategoryId')";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['categoryId'])){
			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
			$query.=" GROUP BY p.category_id ORDER BY p.category_id ASC";
		} else {
			$categoryId = $filter['categoryId'];
			$query.=" GROUP BY m.category_id ORDER BY m.category_id ASC";
		}

		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return false;
		}
	}

	public function getTotalActivatedPoints($filter){

		$subQuery="";
		if(!empty($filter['productId'])){
			$subQuery=" m.product_id as moduleId, (SELECT product_name FROM products WHERE id=m.product_id) as moduleName ";
		} else if(!empty($filter['subCategoryId'])){
			$subQuery=" m.product_id as moduleId, (SELECT product_name FROM products WHERE id=m.product_id) as moduleName ";
		} else if(!empty($filter['categoryId'])){
			$subQuery=" p.category_id as moduleId, (SELECT category_name FROM product_category WHERE id=p.category_id) as moduleName ";
		} else {
			$subQuery=" m.category_id as moduleId, (SELECT category_name FROM product_category WHERE id=m.category_id) as moduleName ";
		}

		$query = "SELECT 
				SUM(v.qty) as num,
		    SUM(v.face_value * v.qty) as point, ".$subQuery."
		  FROM 
		    coupon_batch_meta m, coupon_batch_meta_values v, products p
		  WHERE p.id=m.product_id AND v.coupon_order_id=m.id AND m.is_active=1 AND m.is_trash=0
		";

		$Y = $filter['year'];
		$EY = $Y;
		$startDate = $Y.'-01-01';
		$endDate =  $EY.'-12-31';
		$query.=" AND (m.date_of_mfg BETWEEN '$startDate' AND '$endDate')";
		
		
		if(!empty($filter['plantId']))
			$query.=" AND m.plant_id=".$filter['plantId'];
			
	    if(!empty($filter['divisionId']))
			$query.=" AND m.unit_id=".$filter['divisionId'];

		if(!empty($filter['productId'])){
			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['subCategoryId'])){
			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id='$subCategoryId')";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['categoryId'])){
			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
			$query.=" GROUP BY p.category_id ORDER BY p.category_id ASC";
		} else {
			$categoryId = $filter['categoryId'];
			$query.=" GROUP BY m.category_id ORDER BY m.category_id ASC";
		}

		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return false;
		}
	}

	public function getTotalEncashmentPending($filter){

		$subQuery="";
		if(!empty($filter['productId'])){
			$subQuery=" m.product_id as moduleId, (SELECT product_name FROM products WHERE id=m.product_id) as moduleName ";
		} else if(!empty($filter['subCategoryId'])){
			$subQuery=" m.product_id as moduleId, (SELECT product_name FROM products WHERE id=m.product_id) as moduleName ";
		} else if(!empty($filter['categoryId'])){
			$subQuery=" p.category_id as moduleId, (SELECT category_name FROM product_category WHERE id=p.category_id) as moduleName ";
		} else {
			$subQuery=" m.category_id as moduleId, (SELECT category_name FROM product_category WHERE id=m.category_id) as moduleName ";
		}

		$query = "SELECT 
				count(s.id) as num,
		    SUM(s.points) as point, ".$subQuery."
		  FROM 
		    scanned_coupons s, coupon_codes c, coupon_batch_meta m, products p 
		  WHERE p.id=m.product_id AND m.id=c.coupon_order_id AND c.id=s.coupon_id AND s.is_transferred=0
		";

		$Y = $filter['year'];
		$EY = $Y;
		$startDate = strtotime($Y.'-01-01 00:00:00');
		$endDate =  strtotime($EY.'-12-31 23:59:59');
		$query.=" AND (s.scanned_on BETWEEN '$startDate' AND '$endDate')";
    
        if(!empty($filter['plantId']))
			$query.=" AND m.plant_id=".$filter['plantId'];
			
	    if(!empty($filter['divisionId']))
			$query.=" AND m.unit_id=".$filter['divisionId'];
			
		if(!empty($filter['state'])){
			$state = $filter['state'];
			$query.=" AND s.state='$state' ";

			if(!empty($filter['city'])){
				$city = $filter['city'];
				$query.=" AND s.city='$city' ";
			}
		}

		if(!empty($filter['productId'])){
			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['subCategoryId'])){
			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id='$subCategoryId')";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['categoryId'])){
			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
			$query.=" GROUP BY p.category_id ORDER BY p.category_id ASC";
		} else {
			$categoryId = $filter['categoryId'];
			$query.=" GROUP BY m.category_id ORDER BY m.category_id ASC";
		}

		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return false;
		}
	}

	public function getCurrentYearScanned($filter){

		$subQuery="";
		if(!empty($filter['productId'])){
			$subQuery=" m.product_id as moduleId ";
		} else if(!empty($filter['subCategoryId'])){
			$subQuery=" m.product_id as moduleId ";
		} else if(!empty($filter['categoryId'])){
			$subQuery=" p.category_id as moduleId ";
		} else {
			$subQuery=" m.category_id as moduleId ";
		}

		$query = "SELECT 
		    count(s.id) as num, SUM(s.points) as point, ".$subQuery."
		  FROM 
		    scanned_coupons s, coupon_codes c, coupon_batch_meta m, products p 
		  WHERE p.id=m.product_id AND m.id=c.coupon_order_id AND c.id=s.coupon_id 
		";

		$Y = $filter['year'];
		$Y1 = $Y;
		$Y2 = $Y;
		$startDate = strtotime($Y1.'-01-01 00:00:00');
		$endDate =  strtotime($Y2.'-12-31 23:59:59');
		$query.=" AND (s.scanned_on BETWEEN '$startDate' AND '$endDate')";
		
		if(!empty($filter['plantId']))
			$query.=" AND m.plant_id=".$filter['plantId'];
			
	    if(!empty($filter['divisionId']))
			$query.=" AND m.unit_id=".$filter['divisionId'];

		if(!empty($filter['state'])){
			$state = $filter['state'];
			$query.=" AND s.state='$state' ";

			if(!empty($filter['city'])){
				$city = $filter['city'];
				$query.=" AND s.city='$city' ";
			}
		}

		if(!empty($filter['productId'])){
			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['subCategoryId'])){
			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id='$subCategoryId')";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['categoryId'])){
			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
			$query.=" GROUP BY p.category_id ORDER BY p.category_id ASC";
		} else {
			$categoryId = $filter['categoryId'];
			$query.=" GROUP BY m.category_id ORDER BY m.category_id ASC";
		}

		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return false;
		}
	}

	public function getCurrentMonthScanned($filter){

		$subQuery="";
		
		if(!empty($filter['productId'])){
			$subQuery=" m.product_id as moduleId ";
			
		} else if(!empty($filter['subCategoryId'])){
			$subQuery=" m.product_id as moduleId ";
			
		} else if(!empty($filter['categoryId'])){
			$subQuery=" p.category_id as moduleId ";
			
		} else {
			$subQuery=" m.category_id as moduleId ";
		}

		$query = "SELECT 
		    count(s.id) as num, SUM(s.points) as point, ".$subQuery."
		  FROM 
		    scanned_coupons s, coupon_codes c, coupon_batch_meta m, products p 
		  WHERE p.id=m.product_id AND m.id=c.coupon_order_id AND c.id=s.coupon_id 
		";
		
		
		
		$m = date('m');
		
		
	    if( date("m") < 4 && $filter['year'] < date ("Y"))
	        $Y = $filter['year'];
	        
	    else if( date("m") > 4 && $filter['year'] < date ("Y"))
	        $Y = $filter['year'];
	        
	    else
	       $Y = date ("Y");
		
	

		$startDate = strtotime($Y.'-'.$m.'-01 00:00:00');
		$endDate =  strtotime($Y.'-'.$m.'-31 23:59:59');
		
		
		$query.=" AND (s.scanned_on BETWEEN '$startDate' AND '$endDate')";
		
		if(!empty($filter['plantId']))
			$query.=" AND m.plant_id=".$filter['plantId'];
			
	    if(!empty($filter['divisionId']))
			$query.=" AND m.unit_id=".$filter['divisionId'];

		if(!empty($filter['state'])){
			$state = $filter['state'];
			$query.=" AND s.state='$state' ";

			if(!empty($filter['city'])){
				$city = $filter['city'];
				$query.=" AND s.city='$city' ";
			}
		}

		if(!empty($filter['productId'])){
			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['subCategoryId'])){
			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id='$subCategoryId')";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['categoryId'])){
			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
			$query.=" GROUP BY p.category_id ORDER BY p.category_id ASC";
		} else {
			$categoryId = $filter['categoryId'];
			$query.=" GROUP BY m.category_id ORDER BY m.category_id ASC";
		}
		
		//echo $query; die;

		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return false;
		}
	}
	
	
	public function getTodayScanned($filter){

		$subQuery="";
		if(!empty($filter['productId'])){
			$subQuery=" m.product_id as moduleId ";
		} else if(!empty($filter['subCategoryId'])){
			$subQuery=" m.product_id as moduleId ";
		} else if(!empty($filter['categoryId'])){
			$subQuery=" p.category_id as moduleId ";
		} else {
			$subQuery=" m.category_id as moduleId ";
		}

		$query = "SELECT 
		    count(s.id) as num, SUM(s.points) as point, ".$subQuery."
		  FROM 
		    scanned_coupons s, coupon_codes c, coupon_batch_meta m, products p 
		  WHERE p.id=m.product_id AND m.id=c.coupon_order_id AND c.id=s.coupon_id 
		";

		
		if( date("m") < 4 && $filter['year'] < date ("Y"))
	        $Y = $filter['year']+1;
	        
	    else if( date("m") > 4 && $filter['year'] < date ("Y"))
	        $Y = $filter['year'];
	        
	    else
	       $Y = date ("Y");
	       
	       
	 $date = date("$Y-m-d");

	//echo $date  = date('Y-m-d', strtotime('-1 day', strtotime($date)));
	//	die;
	 $startDate = strtotime($date.' 00:00:00');
	 $endDate =  strtotime($date.' 23:59:59');
	
		$query.=" AND (s.scanned_on BETWEEN '$startDate' AND '$endDate')";
		
		if(!empty($filter['plantId']))
			$query.=" AND m.plant_id=".$filter['plantId'];
			
	    if(!empty($filter['divisionId']))
			$query.=" AND m.unit_id=".$filter['divisionId'];

		if(!empty($filter['state'])){
			$state = $filter['state'];
			$query.=" AND s.state='$state' ";

			if(!empty($filter['city'])){
				$city = $filter['city'];
				$query.=" AND s.city='$city' ";
			}
		}

		if(!empty($filter['productId'])){
			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['subCategoryId'])){
			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id='$subCategoryId')";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['categoryId'])){
			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
			$query.=" GROUP BY p.category_id ORDER BY p.category_id ASC";
		} else {
			$categoryId = $filter['categoryId'];
			$query.=" GROUP BY m.category_id ORDER BY m.category_id ASC";
		}

		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return false;
		}
	}


	public function getYesterdayScanned($filter){

		$subQuery="";
		if(!empty($filter['productId'])){
			$subQuery=" m.product_id as moduleId ";
		} else if(!empty($filter['subCategoryId'])){
			$subQuery=" m.product_id as moduleId ";
		} else if(!empty($filter['categoryId'])){
			$subQuery=" p.category_id as moduleId ";
		} else {
			$subQuery=" m.category_id as moduleId ";
		}

		$query = "SELECT 
		    count(s.id) as num, SUM(s.points) as point, ".$subQuery."
		  FROM 
		    scanned_coupons s, coupon_codes c, coupon_batch_meta m, products p 
		  WHERE p.id=m.product_id AND m.id=c.coupon_order_id AND c.id=s.coupon_id 
		";

		
		if( date("m") < 4 && $filter['year'] < date ("Y"))
	        $Y = $filter['year']+1;
	        
	    else if( date("m") > 4 && $filter['year'] < date ("Y"))
	        $Y = $filter['year'];
	        
	    else
	       $Y = date ("Y");
	       
	       
		$date = date("$Y-m-d");

		$date  = date('Y-m-d', strtotime('-1 day', strtotime($date)));
		
		$startDate = strtotime($date.' 00:00:00');
		$endDate =  strtotime($date.' 23:59:59');
		
		$query.=" AND (s.scanned_on BETWEEN '$startDate' AND '$endDate')";
		
		if(!empty($filter['plantId']))
			$query.=" AND m.plant_id=".$filter['plantId'];
			
	    if(!empty($filter['divisionId']))
			$query.=" AND m.unit_id=".$filter['divisionId'];

		if(!empty($filter['state'])){
			$state = $filter['state'];
			$query.=" AND s.state='$state' ";

			if(!empty($filter['city'])){
				$city = $filter['city'];
				$query.=" AND s.city='$city' ";
			}
		}

		if(!empty($filter['productId'])){
			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['subCategoryId'])){
			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id='$subCategoryId')";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['categoryId'])){
			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
			$query.=" GROUP BY p.category_id ORDER BY p.category_id ASC";
		} else {
			$categoryId = $filter['categoryId'];
			$query.=" GROUP BY m.category_id ORDER BY m.category_id ASC";
		}

		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return false;
		}
	}

	public function getTotalUnScanned($filter){

		$subQuery="";
		if(!empty($filter['productId'])){
			$subQuery=" m.product_id as moduleId ";
		} else if(!empty($filter['subCategoryId'])){
			$subQuery=" m.product_id as moduleId ";
		} else if(!empty($filter['categoryId'])){
			$subQuery=" p.category_id as moduleId ";
		} else {
			$subQuery=" m.category_id as moduleId ";
		}

		$query = "
			SELECT 
				count(c.id) as num, SUM(c.points) as point, ".$subQuery."
		  FROM 
		    coupon_codes c, coupon_batch_meta m, products p 
		  WHERE p.id=m.product_id AND m.id=c.coupon_order_id AND c.is_scaned=0 AND m.is_active=1 AND m.is_trash=0
		";

		$Y = $filter['year'];
		$Y1 = $Y - 1;
		$Y2 = $Y;
		$startDate = $Y1.'-01-01';
		$endDate =  $Y2.'-12-31';
		$query.=" AND (m.date_of_mfg BETWEEN '$startDate' AND '$endDate')";
		
		if(!empty($filter['plantId']))
			$query.=" AND m.plant_id=".$filter['plantId'];
			
	    if(!empty($filter['divisionId']))
			$query.=" AND m.unit_id=".$filter['divisionId'];

		if(!empty($filter['productId'])){
			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['subCategoryId'])){
			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id='$subCategoryId')";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['categoryId'])){
			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
			$query.=" GROUP BY p.category_id ORDER BY p.category_id ASC";
		} else {
			$categoryId = $filter['categoryId'];
			$query.=" GROUP BY m.category_id ORDER BY m.category_id ASC";
		}

		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return false;
		}
	}

	public function getCurrentYearUnScanned($filter){

		$subQuery="";
		if(!empty($filter['productId'])){
			$subQuery=" m.product_id as moduleId ";
		} else if(!empty($filter['subCategoryId'])){
			$subQuery=" m.product_id as moduleId ";
		} else if(!empty($filter['categoryId'])){
			$subQuery=" p.category_id as moduleId ";
		} else {
			$subQuery=" m.category_id as moduleId ";
		}

		$query = "
			SELECT 
				count(c.id) as num, SUM(c.points) as point, ".$subQuery."
		  FROM 
		    coupon_codes c, coupon_batch_meta m, products p 
		  WHERE p.id=m.product_id AND m.id=c.coupon_order_id AND c.is_scaned=0 AND m.is_active=1 AND m.is_trash=0
		";

		$Y = $filter['year'];
		$Y1 = $Y;
		$Y2 = $Y;
		$startDate = $Y1.'-01-01 00:00:00';
		$endDate =  $Y2.'-12-31 23:59:59';


		$query.=" AND (m.date_of_mfg BETWEEN '$startDate' AND '$endDate')";
		
		if(!empty($filter['plantId']))
			$query.=" AND m.plant_id=".$filter['plantId'];
			
	    if(!empty($filter['divisionId']))
			$query.=" AND m.unit_id=".$filter['divisionId'];

		if(!empty($filter['productId'])){
			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['subCategoryId'])){
			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id='$subCategoryId')";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['categoryId'])){
			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
			$query.=" GROUP BY p.category_id ORDER BY p.category_id ASC";
		} else {
			$categoryId = $filter['categoryId'];
			$query.=" GROUP BY m.category_id ORDER BY m.category_id ASC";
		}

		//echo $query;

		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return false;
		}
	}

	public function getPreviousYearUnScanned($filter){

		$subQuery="";
		if(!empty($filter['productId'])){
			$subQuery=" m.product_id as moduleId ";
		} else if(!empty($filter['subCategoryId'])){
			$subQuery=" m.product_id as moduleId ";
		} else if(!empty($filter['categoryId'])){
			$subQuery=" p.category_id as moduleId ";
		} else {
			$subQuery=" m.category_id as moduleId ";
		}

		$query = "
			SELECT 
				count(c.id) as num, SUM(c.points) as point, ".$subQuery."
		  FROM 
		    coupon_codes c, coupon_batch_meta m, products p 
		  WHERE p.id=m.product_id AND m.id=c.coupon_order_id AND c.is_scaned=0 AND m.is_active=1 AND m.is_trash=0
		";

		$Y = $filter['year'];
		$Y1 = $Y - 1;
		$Y2 = $Y - 1;
		$startDate = $Y1.'-01-01';
		$endDate =  $Y2.'-12-31';
		$query.=" AND (m.date_of_mfg BETWEEN '$startDate' AND '$endDate')";
		
		if(!empty($filter['plantId']))
			$query.=" AND m.plant_id=".$filter['plantId'];
			
	    if(!empty($filter['divisionId']))
			$query.=" AND m.unit_id=".$filter['divisionId'];

		if(!empty($filter['productId'])){
			$productId = $filter['productId'];
			$query.=" AND m.product_id=$productId";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['subCategoryId'])){
			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND m.product_id IN (SELECT id FROM products WHERE category_id='$subCategoryId')";
			$query.=" GROUP BY m.product_id ORDER BY m.product_id ASC";

		} else if(!empty($filter['categoryId'])){
			$categoryId = $filter['categoryId'];
			$query.=" AND m.category_id=$categoryId";
			$query.=" GROUP BY p.category_id ORDER BY p.category_id ASC";
		} else {
			$categoryId = $filter['categoryId'];
			$query.=" GROUP BY m.category_id ORDER BY m.category_id ASC";
		}

		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return false;
		}
	}
	
	
	public function getModuleNames($filter){
	    
	    $query = "SELECT id, category_name as title FROM product_category WHERE parent_id=0 ORDER BY id ASC";

		if(!empty($filter['productId'])){
			$productId = $filter['productId'];
			$query = "SELECT id, product_name as title,product_series FROM products WHERE id=$productId ORDER BY id ASC";
			
		} else if(!empty($filter['subCategoryId'])){
			$subCategoryId = $filter['subCategoryId'];
			$query = "SELECT id, product_name as title,product_series FROM products WHERE category_id=$subCategoryId ORDER BY id ASC";
			
		} else if(!empty($filter['categoryId'])){
			$categoryId = $filter['categoryId'];
			$query = "SELECT id, category_name as title FROM product_category WHERE parent_id=$categoryId ORDER BY id ASC";
			
		} else if(!empty($filter['plantId'])){
			$plantAssignCatSql="SELECT assignedCatIds FROM plant_list WHERE plant_id=".$filter['plantId'];
		    $rowData = $this->fetchRow($plantAssignCatSql);
	
		    if(count($rowData) > 0 && $rowData['assignedCatIds'] ):
		        $categoryIds = $rowData['assignedCatIds'];
		        $query="SELECT id,category_name as title FROM product_category WHERE parent_id=0 AND status = 1 AND id IN ($categoryIds)  ORDER BY id ASC";
		    endif;
		}
		
		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return false;
		}
	}

	public function getModuleNames_OLD($filter){

		if(!empty($filter['productId'])){
			$productId = $filter['productId'];
			$query = "SELECT id, product_name as title,product_series FROM products WHERE id=$productId ORDER BY id ASC";
		} else if(!empty($filter['subCategoryId'])){
			$subCategoryId = $filter['subCategoryId'];
			$query = "SELECT id, product_name as title,product_series FROM products WHERE category_id=$subCategoryId ORDER BY id ASC";
		} else if(!empty($filter['categoryId'])){
			$categoryId = $filter['categoryId'];
			$query = "SELECT id, category_name as title FROM product_category WHERE parent_id=$categoryId ORDER BY id ASC";
		} else {
			$query = "SELECT id, category_name as title FROM product_category WHERE parent_id=0 ORDER BY id ASC";
		}

		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return false;
		}
	}

	public function getMainCategory(){
		$query="SELECT id, category_name as title FROM product_category WHERE parent_id=0 ORDER BY category_name ASC";
		return $this->fetchResult($query);
	}

	public function getSubCategory($categoryId){
		$query="SELECT id, category_name as title FROM product_category WHERE parent_id=$categoryId ORDER BY category_name ASC";
		return $this->fetchResult($query);
	}

	public function getSubCategoryProduct($categoryId){
		$query="SELECT id, product_name as title FROM products WHERE category_id=$categoryId ORDER BY product_name ASC";
		return $this->fetchResult($query);
	}

	public function getProductById($productId){
		$query="SELECT id, product_name as title FROM products WHERE id=$productId ORDER BY product_name ASC";
		return $this->fetchResult($query);
	}

	public function couponData($couponCode){
		$query="
		SELECT 
			c.id as couponId, 
			c.coupon_code as couponCode, 
			date_format(CONVERT_TZ(FROM_UNIXTIME(m.activated_on),'+00:00','+05:30'), '%d/%m/%Y') as activatedOn, 
			date_format(CONVERT_TZ(FROM_UNIXTIME(m.created_on),'+00:00','+05:30'), '%d/%m/%Y') as createdOn
		FROM coupon_codes c, coupon_batch_meta m
		WHERE m.id=c.coupon_order_id AND c.coupon_code='$couponCode' 
		ORDER BY c.id DESC LIMIT 1";
		return $this->fetchRow($query);
	}

	public function isCouponScanned($couponId){
		$query="
		SELECT 
			s.is_transferred as isTransferred, 
			date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%d/%m/%Y') as scannedOn,
			u.name,
			u.mobile,
			u.user_role_id as userRoleId
		FROM scanned_coupons s, users u
		WHERE u.id=s.user_id AND s.coupon_id='$couponId' 
		ORDER BY s.id DESC LIMIT 1";
		return $this->fetchRow($query);
	}

	public function couponTransferredTrial($couponId){
		$query="
		SELECT 
		date_format(CONVERT_TZ(FROM_UNIXTIME(r.created_on),'+00:00','+05:30'), '%d/%m/%Y')
			 as createdOn,
			u.name,
			u.mobile,
			u.user_role_id as userRoleId
		FROM received_coupons r, users u
		WHERE u.id=r.user_id AND r.coupon_id='$couponId' 
		ORDER BY r.id ASC";
		return $this->fetchResult($query);
	}

	public function getPointLedger($userId,$pointSdate=NULL,$pointEdate=NULL){
	    
	    $dateFilter = "";
	    
	    if($pointSdate):
	      $pointSdate = date("Y-m-d 00:000:00",strtotime($pointSdate));
	      $dateFilter .= " AND created_on >='$pointSdate'";
	    endif;
	    
	    if($pointEdate):
	       $pointEdate = date("Y-m-d 23:59:59",strtotime($pointEdate));
	      $dateFilter .= " AND created_on <='$pointEdate'";
	    endif;
	     
	    /*
		 $query="
			SELECT u.name,u.mobile, tp.pointPaidStatus, tp.pointRemark ,upl.id, upl.type, upl.points, upl.ref_id as refId, upl.balance, DATE_FORMAT(upl.created_on, '%d/%m/%Y') as createdDate
			FROM user_point_ledger upl JOIN transfer_points tp ON tp.id=upl.ref_id JOIN users u ON tp.user_id=u.id 
			WHERE upl.user_id=$userId ".$dateFilter;  

		$query.=" ORDER BY upl.id DESC";
		*/
		
		$query="
			SELECT id, type, points, ref_id as refId, balance, DATE_FORMAT(created_on, '%d/%m/%Y') as createdDate
			FROM user_point_ledger 
			WHERE user_id=$userId ".$dateFilter; 

		$query.=" ORDER BY id DESC";

	
		return $this->fetchResult($query);
	}

	public function userTotalScan($userId){
		$query="
			SELECT 
				count(s.id) as num,
				date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%d/%m/%Y') as dates
			FROM scanned_coupons s 
			WHERE s.user_id=$userId
			GROUP BY dates
			";
		$dataSet =  $this->fetchResult($query);
		if($dataSet){
			foreach ($dataSet as $value) {
				$date = $value['dates'];
				$data[$date] =  $value['num'];
			}

			return $data;

		} else {
			return array();
		}
	}
	public function userTotalBonusCouponGenerated($userId){
		$query="
			SELECT 
				count(s.id) as num,
				date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%d/%m/%Y') as dates
			FROM bonus_coupons s 
			WHERE s.user_id=$userId
			GROUP BY dates
			";
		$dataSet =  $this->fetchResult($query);
		if($dataSet){
			foreach ($dataSet as $value) {
				$date = $value['dates'];
				$data[$date] =  $value['num'];
			}

			return $data;

		} else {
			return array();
		}
	}

	public function userTotalTransfer($userId){
		 $query="
			SELECT 
			  s.id,
				s.ref_no, 
				u.name, 
				u.mobile,
				s.pointPaidStatus,
				s.pointRemark
			FROM transfer_points s, users u 
			WHERE u.id=s.transfer_to AND s.user_id=$userId GROUP BY created_on
		";
		$dataSet =  $this->fetchResult($query);
		if($dataSet){

			foreach ($dataSet as $value) {
				$id = $value['id'];
				$data[$id] =  $value;
			}

			return $data;

		} else {
			return $data[] = array('id'=>0, 'ref_no'=>'', 'name'=>'', 'mobile'=>'');
		}
	}

// change p.product_filed_1 as productFiled3 int p.product_name as productFiled3,

	public function scanPointDetail($userId, $date){
		$query="
			SELECT 
				s.coupon_id as couponId, 
				c.coupon_code as couponCode,
				s.points,
				p.id as productId,
				p.product_name as productName,
				p.product_mrp as productMRP,
				p.product_series as productSeries,
				p.product_name as productFiled3,
				m.batch_number as batchNumber,
				DATE_FORMAT(m.date_of_mfg, '%d/%m/%Y') as dateOfMfg,
				date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%d/%m/%Y') as scannedDate
			FROM 
				scanned_coupons s, 
				coupon_codes c, 
				coupon_batch_meta m, 
				products p
			WHERE 
				p.id=m.product_id AND
				m.id=c.coupon_order_id AND
				c.id=s.coupon_id AND 
				s.user_id=$userId AND 
				date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m-%d') = '$date' 
			ORDER BY s.id DESC";
		return $this->fetchResult($query);
	}
	public function bonusPointDetail($userId, $date){
		$query="
			SELECT 
				s.coupon_id as couponId, 
				c.coupon_code as couponCode,
				s.points,
				p.id as productId,
				p.product_name as productName,
				p.product_mrp as productMRP,
				p.product_series as productSeries,
				p.product_name as productFiled3,
				m.batch_number as batchNumber,
				DATE_FORMAT(m.date_of_mfg, '%d/%m/%Y') as dateOfMfg,
				date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%d/%m/%Y') as scannedDate
			FROM 
				bonus_coupons s, 
				coupon_codes c, 
				coupon_batch_meta m, 
				products p
			WHERE 
				p.id=m.product_id AND
				m.id=c.coupon_order_id AND
				c.id=s.coupon_id AND 
				s.user_id=$userId AND 
				date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%Y-%m-%d') = '$date' 
			ORDER BY s.id DESC";
		return $this->fetchResult($query);
	}

	public function receivedPointDetail($userId, $date){
		$query="
			SELECT 
				t.points, 
				t.ref_no,
				u.name as receivedFromName,
				u.mobile as receivedFromMobile
			FROM transfer_points t, users u
			WHERE u.id=t.user_id AND t.transfer_to=$userId AND FROM_UNIXTIME(t.created_on, '%Y-%m-%d') = '$date' 
			ORDER BY t.id DESC";
			
		return $this->fetchResult($query);
	}
	


	public function getUserLedger($userId,$pointSdate=NULL,$pointEdate=NULL){
	    
	    $dateFilter="";
	        
	    if($pointSdate):
	      $pointSdate = strtotime($pointSdate);
	      $dateFilter .= " AND t.created_on >='$pointSdate'";
	    endif;
	    
	    if($pointEdate):
	        $pointEdate = date("Y-m-d 23:59:59",strtotime($pointEdate));
	       $pointEdate = strtotime($pointEdate);
	      $dateFilter .= " AND t.created_on <='$pointEdate'";
	    endif;
	    
		 $query="
			SELECT 
				t.points, 
				t.ref_no as refId,
				a.id as receivedFromUserId,
				a.name as receivedFromName,
				a.mobile as receivedFromMobile,
				b.name as transferToUserId,
				b.name as transferToName,
				b.mobile as transferToMobile,
				t.pointPaidStatus,
				t.pointRemark,
				date_format(CONVERT_TZ(FROM_UNIXTIME(t.created_on),'+00:00','+05:30'), '%d/%m/%Y') as date,
				t.created_on as time
			FROM transfer_points t, users a, users b
			WHERE a.id=t.user_id AND b.id=t.transfer_to AND (t.user_id=$userId OR t.transfer_to=$userId)";
			
			$query .= $dateFilter;
			$query .="ORDER BY t.created_on DESC";
			
		return $this->fetchResult($query);
	}

	public function getUserScans($userId,$pointSdate=NULL,$pointEdate=NULL){
	    $dateFilter="";
	        
	    if($pointSdate):
	     $pointSdate = strtotime($pointSdate);
	      $dateFilter .= " AND s.scanned_on >='$pointSdate'";
	    endif;
	    
	    if($pointEdate):
	       $pointEdate = date("Y-m-d 23:59:59",strtotime($pointEdate));
	       $pointEdate = strtotime($pointEdate);
	      $dateFilter .= " AND s.scanned_on <='$pointEdate'";
	    endif;
	    
		$query="
			SELECT 
				c.coupon_code as couponCode,
				s.points,
				p.product_name as productName,
				p.product_series as productSeries,
				date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%d/%m/%Y') as date,
				s.scanned_on as time
			FROM 
				scanned_coupons s, 
				coupon_codes c, 
				coupon_batch_meta m, 
				products p
			WHERE 
				p.id=m.product_id AND
				m.id=c.coupon_order_id AND
				c.id=s.coupon_id AND 
				s.user_id=$userId";
				$query .=" ".$dateFilter;
		$query .=" ORDER BY s.scanned_on DESC";
		
		//var_dump($query);
		//die("scanuserdetails");
		return $this->fetchResult($query);
	}

	public function getScanLimitAlert($date){
		$query="
			SELECT 
				u.name,
				u.mobile,
				u.user_role_id as type,
				date_format(CONVERT_TZ(FROM_UNIXTIME(s.created_on),'+00:00','+05:30'), '%d/%m/%Y') as date
			FROM 
				scan_limit_alert s, 
				users u
			WHERE 
				u.id=s.user_id AND
				date_format(CONVERT_TZ(FROM_UNIXTIME(s.created_on),'+00:00','+05:30'), '%d/%m/%Y') = '$date' 
			ORDER BY s.created_on DESC";
		return $this->fetchResult($query);
	}

	// DASHBOARD //

	public function countScanAlert($date){
		$query="SELECT count(id) as num FROM scan_limit_alert WHERE date_format(CONVERT_TZ(FROM_UNIXTIME(created_on),'+00:00','+05:30'),'%Y-%m-%d') ='date'";
		$date = $this->fetchRow($query);
		return ($date) ? $date['num'] : 0;
	}

	public function countActivatedCoupon($date){
		$query="SELECT sum(c.qty) as num FROM coupon_batch_meta m, coupon_batch_qty c 
		WHERE c.coupon_order_id=m.id AND FROM_UNIXTIME(m.activated_on, '%Y-%m-%d') ='date'";
		$date = $this->fetchRow($query);
		return ($date) ? $date['num'] : 0;
	}

	public function countScannedCoupons($date){
		$query="SELECT count(id) as num FROM scanned_coupons WHERE date_format(CONVERT_TZ(FROM_UNIXTIME(scanned_on),'+00:00','+05:30'), '%Y-%m-%d') ='date'";
		$date = $this->fetchRow($query);
		return ($date) ? $date['num'] : 0;
	}

	public function countAdminReceivedPoints($date){
		$query="SELECT count(id) as num FROM received_coupons WHERE date_format(CONVERT_TZ(FROM_UNIXTIME(created_on),'+00:00','+05:30'),'%Y-%m-%d') ='date' AND user_id=1";
		$date = $this->fetchRow($query);
		return ($date) ? $date['num'] : 0;
	}


 public function giftRedeemDetail($userId, $refId){
		 $query="SELECT * FROM user_point_ledger upl JOIN gift_request gr ON gr.giftRequestDate = upl.created_on WHERE upl.user_id=$userId and upl.ref_id=$refId and gr.userId=$userId";
		
		return $this->fetchResult($query);
	}
	
	
 public function giftRetrunPoint($userId, $refId ){
     
     $query="SELECT * FROM user_point_ledger upl JOIN gift_request gr ON gr.updatedOn = upl.created_on WHERE upl.user_id=$userId and upl.ref_id=$refId and gr.userId=$userId AND gr.giftReturn=1 AND gr.requestStatus='Returned' ";
		
		return $this->fetchResult($query);
  
	}
	
	public function updatePointRemarkStatus($refId,$data){
	    return $this->_update('transfer_points', $data, array('id'=>$refId));
	}


	
public function multiScanRecord($filter){
    
		$couponcodefilter = $filter['couponcodefilter'];
		$numofscan = $filter['numofscan'];
		
		$query = "SELECT CBM.activated_on, CBM.batch_number, msr.QRcode,count(QRcode) as scanCount from multi_scan_record msr JOIN coupon_batch_meta CBM ON CBM.id=msr.CouponOrderId WHERE 1";
		
		if(!empty($couponcodefilter))
			$query.=" AND msr.QRcode='$couponcodefilter' ";
			
		if (!empty($filter['frmDate']) && !empty($filter['toDate'])) :
		    
			 $batchActivationFrom = strtotime($filter['frmDate']);
			 $batchActivationTo = strtotime($filter['toDate']);
			 
			$query.=" AND CBM.activated_on >= $batchActivationFrom AND  CBM.activated_on <= $batchActivationTo";
        else:
		    if (!empty($filter['frmDate'])){
			    $batchActivationFrom = strtotime($filter['frmDate']);
			    $query.=" AND CBM.activated_on  >= $batchActivationFrom ";
	    	}
		endif;

		$query.=" GROUP BY msr.QRcode";
		
		if(!empty($numofscan))
			$query.=" HAVING scanCount > $numofscan ";
		
	
		//echo $query; die;
		
		$result =  $this->fetchResult($query);
		if($result)
			return $result;
		else 
			return false;
		
	}
	
	
public function getMultiScanList($couponCode){
     $query="SELECT MSR.mobile,MSR.userId,CBM.activated_on, CBM.batch_number, MSR.QRcode,count(QRcode) as scanCount,MSR.CouponOrderId from multi_scan_record MSR JOIN coupon_batch_meta CBM ON CBM.id=MSR.CouponOrderId GROUP BY MSR.QRcode"; 
	return $this->fetchResult($query);
}
	
public function getScanDataByQrCode($couponCode){
     $query="SELECT * from multi_scan_record WHERE QRcode='$couponCode'"; 
	return $this->fetchResult($query);
}

public function getUserData($userId){
		$query="SELECT * FROM users WHERE id =$userId"; 
		return $this->fetchRow($query);
	}


public function getTotalCouponGenerated(){
	
	// $query="SELECT * from coupon_batch_meta where plant_id != 4 AND is_active = 1";	
	//	$query = " SELECT COUNT(DISTINCT cc.coupon_code) AS total_active_coupon_codes FROM coupon_codes cc JOIN coupon_batch_meta cm ON cc.coupon_order_id = cm.id WHERE  cm.plant_id != 4  AND cm.is_active = 1 ";

		$query = "SELECT COUNT(*) AS total_active_coupon_code FROM coupon_codes cc WHERE EXISTS ( SELECT 1 FROM coupon_batch_meta cm WHERE cc.coupon_order_id = cm.id AND cm.plant_id != 4 AND cm.is_active = 1)" ;

		return $this->fetchResult($query);
		 
   }	   
   
   public function totalCouponGeneratedFirst(){
	
		$query = "SELECT COUNT(*) AS total_active_coupon_code FROM coupon_codes cc WHERE EXISTS ( SELECT 1 FROM coupon_batch_meta cm WHERE cc.coupon_order_id = cm.id AND cm.plant_id = 1 AND cm.is_active = 1)" ;

		return $this->fetchResult($query);		 
   }	

   public function totalCouponGeneratedSecond(){
	
	$query = "SELECT COUNT(*) AS total_active_coupon_code FROM coupon_codes cc WHERE EXISTS ( SELECT 1 FROM coupon_batch_meta cm WHERE cc.coupon_order_id = cm.id AND cm.plant_id = 2 AND cm.is_active = 1)" ;
	return $this->fetchResult($query);
	 
	}
	
	public function totalCouponGeneratedThird(){
	
		$query = "SELECT COUNT(*) AS total_active_coupon_code FROM coupon_codes cc WHERE EXISTS ( SELECT 1 FROM coupon_batch_meta cm WHERE cc.coupon_order_id = cm.id AND cm.plant_id = 3 AND cm.is_active = 1)" ;
		return $this->fetchResult($query);
		 
		}

   public function getMonthsCouponGeneratedFirst(){

		$query ="SELECT COUNT(DISTINCT cc.coupon_code) AS num,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%Y') AS year, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%m') AS month, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%M') AS monthName FROM coupon_codes cc JOIN coupon_batch_meta cm ON cc.coupon_order_id = cm.id WHERE cm.plant_id = 1 AND cm.is_active = 1 GROUP BY year, month  ORDER BY year desc, month desc limit 3";

		return $this->fetchResult($query);
}   

public function getMonthsCouponGeneratedSecond(){

	$query ="SELECT COUNT(DISTINCT cc.coupon_code) AS num,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%Y') AS year, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%m') AS month, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%M') AS monthName FROM coupon_codes cc JOIN coupon_batch_meta cm ON cc.coupon_order_id = cm.id WHERE cm.plant_id = 2 AND cm.is_active = 1 GROUP BY year, month  ORDER BY year desc, month desc limit 3";

	return $this->fetchResult($query);
} 

public function getMonthsCouponGeneratedThird(){

	$query ="SELECT COUNT(DISTINCT cc.coupon_code) AS num,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%Y') AS year, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%m') AS month, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%M') AS monthName FROM coupon_codes cc JOIN coupon_batch_meta cm ON cc.coupon_order_id = cm.id WHERE cm.plant_id = 3 AND cm.is_active = 1 GROUP BY year, month  ORDER BY year desc, month desc limit 3";

	return $this->fetchResult($query);
}

public function getMonthsCouponGenerated(){

	//	$query = "SELECT COUNT(id) AS num, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(printed_on), '+00:00', '+05:30'), '%Y') AS year, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(printed_on), '+00:00', '+05:30'), '%m') AS month, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(printed_on), '+00:00', '+05:30'), '%M') AS monthName FROM coupon_batch_meta where plant_id != 4 AND is_active = 1 GROUP BY year DESC, month DESC LIMIT 3 ";

		$query ="SELECT COUNT(DISTINCT cc.coupon_code) AS num,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%Y') AS year, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%m') AS month, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%M') AS monthName FROM coupon_codes cc JOIN coupon_batch_meta cm ON cc.coupon_order_id = cm.id WHERE cm.plant_id != 4 AND cm.is_active = 1 GROUP BY year, month  ORDER BY year desc, month desc limit 3";

		return $this->fetchResult($query);
}   

public function getTotalScanCoupon(){
	
	$query ="SELECT COUNT(DISTINCT cc.coupon_code) AS num, cc.is_scaned, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%Y') AS year, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%m') AS month, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%M') AS monthName FROM coupon_codes cc JOIN coupon_batch_meta cm ON cc.coupon_order_id = cm.id WHERE cc.is_scaned = 1 AND cm.plant_id != 4 AND  cm.is_active = 1";

	return $this->fetchResult($query);
}

public function getTotalUnscanCoupon(){
	
	$query ="SELECT COUNT(DISTINCT cc.coupon_code) AS num, cc.is_scaned, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%Y') AS year, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%m') AS month, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%M') AS monthName FROM coupon_codes cc JOIN coupon_batch_meta cm ON cc.coupon_order_id = cm.id WHERE cc.is_scaned = 0 AND cm.plant_id != 4 AND  cm.is_active = 1";

	return $this->fetchResult($query);
}

public function getMonthScanNum(){

//	$query ="SELECT COUNT(DISTINCT cc.coupon_code) AS num,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%Y') AS year, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%m') AS month, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%M') AS monthName FROM coupon_codes cc JOIN coupon_batch_meta cm ON cc.coupon_order_id = cm.id WHERE cc.is_scaned = 1 AND cm.plant_id != 4 AND cm.is_active = 1 GROUP BY year, month  ORDER BY year desc, month desc limit 3";

	$query = "SELECT COUNT(s.coupon_id) AS num, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on), '+00:00', '+05:30'), '%Y') AS year, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on), '+00:00', '+05:30'), '%m') AS month, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on), '+00:00', '+05:30'), '%M') AS monthName FROM scanned_coupons s JOIN coupon_codes c ON c.id = s.coupon_id JOIN coupon_batch_meta m ON m.id = c.coupon_order_id JOIN products p ON p.id = m.product_id JOIN plant_list pt ON m.plant_id = pt.plant_id JOIN product_category pc ON m.subcat_id = pc.id JOIN product_category pc1 ON m.category_id = pc1.id WHERE m.plant_id!=4 AND m.is_active=1 AND c.is_scaned=1 GROUP BY year,month ORDER BY year desc, month desc limit 3";

		return $this->fetchResult($query);
}   

public function getMonthUnscanNum(){

//	$query ="SELECT COUNT(DISTINCT cc.coupon_code) AS num,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%Y') AS year, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%m') AS month, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.printed_on), '+00:00', '+05:30'), '%M') AS monthName FROM coupon_codes cc JOIN coupon_batch_meta cm ON cc.coupon_order_id = cm.id WHERE cc.is_scaned = 0 AND cm.plant_id != 4 AND cm.is_active = 1 GROUP BY year, month  ORDER BY year desc, month desc limit 3";

	$query = "SELECT COUNT(s.id) AS num, DATE_FORMAT(s.dateTime, '%Y') AS year, DATE_FORMAT(s.dateTime, '%m') AS month, DATE_FORMAT(s.dateTime, '%M') AS monthName FROM coupon_codes s JOIN coupon_batch_meta m ON m.id = s.coupon_order_id JOIN products p ON p.id = m.product_id JOIN plant_list pt ON m.plant_id = pt.plant_id JOIN product_category pc ON m.subcat_id = pc.id JOIN product_category pc1 ON m.category_id = pc1.id WHERE m.plant_id!=4 AND m.is_active=1 AND s.is_scaned=0 GROUP BY year,month ORDER BY year desc, month desc limit 3";

	return $this->fetchResult($query);
}   



public function budgetChart11($filter)
	{

		
	/* echo "<pre>"; print_r($filter); die;
	
	
	$dates = explode(" - ", $filter['dates']);
	$date1 = strtotime($dates[0]);
	$date2 = strtotime($dates[1]);
	*/
		$twoDates = $filter['dates'];
		$dates = explode(" - ", $twoDates);

		$date1 = strtotime($dates[0]);
		$date2 = strtotime($dates[1]);

		$dateNew1 = date("Y-m-d", $date1);
		$dateNew2 = date("Y-m-d", $date2);

		
		$query ="SELECT SUM(A.points) AS total_points_created, SUM(CASE WHEN A.is_scaned = 1 THEN A.points ELSE 0 END) AS total_points_scanned, SUM(CASE WHEN B.is_transferred = 1 THEN A.points ELSE 0 END) AS total_points_transferred FROM coupon_codes A LEFT JOIN scanned_coupons B ON A.id = B.coupon_id JOIN coupon_batch_meta C ON A.coupon_order_id = C.order_id WHERE ";		
		
		if(!empty($filter['plantId']))
		{
			$query.="  C.plant_id=".$filter['plantId'];
		} else {
			$query.="  C.plant_id != 4 " ;
		}
			
		if(!empty($filter['divisionId'])) {
			$query.=" AND C.unit_id=".$filter['divisionId'];
		} else {
			$query.=" AND C.unit_id != 10 " ;
		}
		
	
		if(!empty($filter['productId'])){
	
			$productId = $filter['productId'];
			$query.=" AND C.product_id=$productId ";
	
		} else {		
			$query.=" AND C.product_id != 101 " ;
		}	
			
		if(!empty($filter['subCategoryId'])){
	
			$subCategoryId = $filter['subCategoryId'];
			$query.=" AND C.subcat_id=$subCategoryId ";
			
		} else {
			
			$query.=" AND C.subcat_id != 101 " ;
		}
		
		if(!empty($filter['categoryId'])){
	
			$categoryId = $filter['categoryId'];
			$query.=" AND C.category_id=$categoryId ";	
		
		} else {
			$query.=" AND C.category_id != 101 " ;
		}

		if(!empty($filter['dates']) && $dateNew1 != "1970-01-01" && $dateNew2 != "2023-06-02" ) {	
		
			// $query.=" AND C.category_id=$categoryId";	
			$query.= "AND A.dateTime >= '".$dateNew1." 00:00:00' AND A.dateTime <= '".$dateNew2." 00:00:00'";
		
		} 
		else {

			$CurrentDate =date('Y-m-d');
			$query.= "AND A.dateTime >= '2019-01-01 00:00:00' AND A.dateTime <= '".$CurrentDate." 00:00:00'";
		}
			
		// echo $query;  die;
				
		$result =  $this->fetchResult($query);
		if($result){
			return $result;
		} else {
			return array();
		}

	}
	

public function budgetChart(){
//	echo "budget chart done";
//	die;

/*
echo date('d');
echo date('m');
echo date('Y');
*/

	$query = "SELECT SUM(A.points) AS total_points_created, SUM(CASE WHEN A.is_scaned = 1 THEN A.points ELSE 0 END) AS total_points_scanned, SUM(CASE WHEN B.is_transferred = 1 THEN A.points ELSE 0 END) AS total_points_transferred FROM coupon_codes A LEFT JOIN scanned_coupons B ON A.id = B.coupon_id JOIN coupon_batch_meta C ON A.coupon_order_id = C.order_id WHERE C.plant_id != 4 AND C.unit_id != 10 AND C.category_id != 101 AND C.subcat_id != 101 AND C.product_id != 101 AND A.dateTime >= '2019-01-01 00:00:00' AND A.dateTime <= '2023-06-01 00:00:00'";

	return $this->fetchResult($query);
}   



} // END CLASS


