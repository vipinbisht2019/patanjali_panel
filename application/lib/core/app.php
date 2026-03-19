<?php

class app extends dbclass {

	public function isScannedOnlyUser($mobile){
		$scanNumber = $this->getScanOnlyNumber($mobile);
	
	//	if($scanNumber==$mobile){
		 if($scanNumber){
			return true;
		} else {
			return false;
		}
	}

	public function isFinalPointReceiver($mobile){
		$scanNumber = $this->getFinalPointReceiver();
		if($scanNumber==$mobile){
			return true;
		} else {
			return false;
		}
	}

	public function validateCouponCode($couponCede){
		$query = "
		SELECT 
			a.id,
			a.coupon_order_id as couponOrderId,
			a.coupon_code as couponCode,
			a.points,
			a.is_scaned as isScaned,
			b.batch_number as batchNumber,
			b.date_of_mfg as batchDate,
			DATE_FORMAT(b.date_of_mfg, '%d/%m/%Y') as dateOfMfg,
			b.printed_on as printedOn,
			b.validity,
			b.is_active as isActive,
			b.is_trash as isTrash,
			p.id as productId,
			p.product_name as productName,
			p.product_mrp as productMRP,
			p.product_series as productSeries,
			p.product_exp_date as productFiled3,
			c.parent_id as categoryId,
			(SELECT is_ofa FROM product_category WHERE id=c.parent_id) as openForAll
		FROM coupon_codes a, coupon_batch_meta b, products p, product_category c
		WHERE c.id=p.category_id AND p.id=b.product_id AND b.id=a.coupon_order_id AND a.coupon_code='$couponCede'";
		return $this->fetchRow($query);
	}
	
	public function getTodayScanCount($userId){
		$date = date('Y-m-d');
		$query = "SELECT count(id) as num FROM scanned_coupons WHERE user_id=$userId AND date_format(CONVERT_TZ(FROM_UNIXTIME(scanned_on),'+00:00','+05:30'), '%Y-%m-%d') = '$date'";
		$data = $this->fetchRow($query);
		return ($data) ? $data['num'] : 0;
	}

	public function getDailyScanLimit(){
		$query="SELECT meta_value FROM setting_meta WHERE meta_key='DAILY_SCAN_LIMIT'";
		$data = $this->fetchRow($query);
		return ($data) ? $data['meta_value'] : 1;
	}

	public function isUserScanLimitLog($userId, $date){
		$query = "
		SELECT id FROM scan_limit_alert 
		WHERE user_id=$userId AND date_format(CONVERT_TZ(FROM_UNIXTIME(created_on),'+00:00','+05:30'),'%Y-%m-%d') = '$date' ORDER BY id DESC LIMIT 1";
		return $this->fetchRow($query);
	}

	public function addUserScanLimitLog($userId){
		$date = date('Y-m-d');
		$isUserScanLimitLog = $this->isUserScanLimitLog($userId, $date);
		if(!$isUserScanLimitLog){
			$data = array(
				'user_id'=>$userId,
				'created_on'=>time()
			);
			$this->_insert('scan_limit_alert', $data);
		}
	}

	public function getScannedDetail($couponId){
	 
		$query = "
				SELECT
				    s.id,
				    date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%d/%m/%Y') as scannedDime,
				    date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%h:%i %p') as scannedTime,
				    u.name as scannedName,
				    u.mobile as scannedMobile
				FROM 
				    scanned_coupons s, users u
				WHERE
				    u.id=s.user_id AND s.coupon_id='$couponId' 
				ORDER BY s.id DESC LIMIT 1
		"; 
		return $this->fetchRow($query);
	}

	public function updateCouponStatus($id, $isScaned){
		return $this->_update('coupon_codes', array('is_scaned'=>$isScaned), array('id'=>$id));
	}

	public function authorisedCategoryMobiles($categoryId){
		$query="SELECT mobile FROM user_authrise_category WHERE category_id ='$categoryId'"; 
		$data = $this->fetchResult($query);
		if($data){
			foreach ($data as $key => $value) {
				$mobiles[] = $value['mobile'];
			}
			return $mobiles;
		} else {
			return array();
		}
	}

	public function deauthorisedCategoryMobiles($categoryId){
		$query="SELECT mobile FROM user_deauthrise_category WHERE category_id ='$categoryId'"; 
		$data = $this->fetchResult($query);
		if($data){
			foreach ($data as $key => $value) {
				$mobiles[] = $value['mobile'];
			}
			return $mobiles;
		} else {
			return array();
		}
	}
	

public function isAuthriseToScan($openForAll, $categoryId, $mobile){

	if($openForAll==1)
	{
		$deauthorisedMobile = $this->deauthorisedCategoryMobiles($categoryId);
		if(in_array($mobile, $deauthorisedMobile))
			return false;
		else 
			return true;
			
	} else {
	    
	    $authorisedMobile = $this->authorisedCategoryMobiles($categoryId);
	    if(is_array($authorisedMobile)):
			if(in_array($mobile, $authorisedMobile))
					return true;
			else 
					return false;
						
		endif;
	    }
		 
	}

	public function addScanData($userId, $couponId, $points, $latitude, $longitude, $state, $city){
		$dataSet = array(
			'coupon_id'=> $couponId,
			'points'=> $points,
			'user_id'=> $userId,
			'state'=> $state,
			'city'=> $city,
			'latitude'=> $latitude,
			'longitude'=> $longitude,
			'scanned_on'=> time(),
			'is_transferred'=> 0,
			'transferred_on'=> 0,
		);
		return $this->_insert('scanned_coupons', $dataSet);
	}
	public function addBonusData($userId, $couponId, $points, $latitude, $longitude, $state, $city,$from_user_id){
		$dataSet = array(
			'coupon_id'=> $couponId,
			'points'=> $points,
			'user_id'=> $userId,
			'state'=> $state,
			'city'=> $city,
			'latitude'=> $latitude,
			'longitude'=> $longitude,
			'scanned_on'=> time(),
			'is_transferred'=> 0,
			'transferred_on'=> 0,
			'from_user_id'=>$from_user_id
		);
		return $this->_insert('bonus_coupons', $dataSet);
	}
	
	public function getUserIdByMobile($mobile){
		$query="SELECT id FROM users WHERE mobile ='$mobile'"; 
		$data = $this->fetchRow($query);
		return ($data) ? $data['id'] : false;
	}

	public function getUserIdRoleByMobile($mobile){
		$query="SELECT id, user_role_id FROM users WHERE mobile ='$mobile'"; 
		return $this->fetchRow($query);
	}
	public function getUserTransferRoleByMobile($mobile){
		$query="SELECT id, user_role_transfer_id FROM users WHERE mobile ='$mobile'"; 
		$data = $this->fetchRow($query);
		return ($data['user_role_transfer_id']!=0) ? $data['user_role_transfer_id'] : false;
	}
	public function getUserTransferToRoleByMobile($mobile){
		$query="SELECT id, user_role_transfer_id FROM users WHERE mobile ='$mobile'"; 
		$data = $this->fetchRow($query);
		return ($data['user_role_transfer_id']!=0) ? $data['user_role_transfer_id'] : false;
	}
	public function checkCanTransfer($from_role_id,$to_role_id){
		 $query="SELECT id FROM coupon_transfer_control WHERE role_id ='$from_role_id' and FIND_IN_SET($to_role_id,transfer_to_role_ids)"; 
		
		$data = $this->fetchRow($query);
		return ($data) ? $data['id'] : false;
	}
	public function checkCanReceive($from_role_id,$to_role_id){
		$query="SELECT id FROM coupon_transfer_control WHERE role_id ='$to_role_id' and FIND_IN_SET($from_role_id,rec_from_role_ids)"; 
		$data = $this->fetchRow($query);
		return ($data) ? $data['id'] : false;
	}
	public function getbonusInfo(){
		$query="SELECT bounus_percent FROM coupon_bonus_settings"; 
		$data = $this->fetchRow($query);
		return ($data) ? $data['bounus_percent'] : false;
	}


	

	public function adduserByMobile($mobile){
		$dataSet = array(
			'name'=> '',
			'mobile'=> $mobile,
			'email'=> '',
			'password'=> '',
			'email'=>'',
			'state_code'=> 0,
			'city_town_id'=> 0,
			'user_role_id'=> 3,
			'status'=> 1,
			'is_trash'=> 0,
			'created'=> time()
		);
		$result = $this->_insert('users', $dataSet);
		return ($result['error']==false) ? $result['insert_id'] : false;
	}

	public function getUserRoleByString($roleNameString){
        $data['Admin'] = 1;
		$data['Distributor/ Distributor staff'] = 3; 
		$data['Retailer'] = 4;
		$data['Customer'] = 5;
		$data['Mechanic /Garage owner'] = 6;
		$data['EOW'] = 7;
		$data['Sales Staff'] = 8;
		$data['Engg. Workshop'] = 9;
		$data['Other'] = 10;

		if(isset($data[$roleNameString])){
			return $data[$roleNameString];
		} else {
			return 10;
		}
	}
	
	

	public function createUser($userData){

	//	$user_role_id = $this->getUserRoleByString($userData['profession']);
		$array = array(
			'name' => $userData['name'],
			'username' => '',
			'password' => '',
			'email' => $userData['email'],
			'mobile' => $userData['mobile'],
			'state_code' => 0,
			'city_town_id' => 0,
			'state'=> $userData['state'],
			'city'=> $userData['city'],
		//	'user_role_id' => $user_role_id,
			'user_role_id' => 14,
			'current_point_balance' => 0,
			'status' => 1,
			'is_trash' => 0,
			'created' => time()
		);

		$result = $this->_insert('users', $array);
		if($result['error']==false){
			return $result['insert_id'];
		} else {
			return false;
		}
	}
	public function creditPointLedgerBonus($userId, $points, $currentPointBalance,$ref_id=0){
		$dataSet = array(
			'user_id'=> $userId,
			'ref_id'=> $ref_id,
			'type'=> 6,
			'points'=> $points,
			'balance'=> $currentPointBalance,
			'created_on'=>date('Y-m-d H:i:s')
		);
	
		$result = $this->_insert('user_point_ledger', $dataSet);
		
		return ($result['error']==false) ? $result['insert_id'] : false;
	}
	public function creditPointLedger($userId, $points, $currentPointBalance,$ref_id=0){
		$dataSet = array(
			'user_id'=> $userId,
			'ref_id'=> $ref_id,
			'type'=> 1,
			'points'=> $points,
			'balance'=> $currentPointBalance,
			'created_on'=>date('Y-m-d H:i:s')
		);
	
		$result = $this->_insert('user_point_ledger', $dataSet);
		
		return ($result['error']==false) ? $result['insert_id'] : false;
	}

	public function debitPointLedger($userId, $points, $currentPointBalance){
		$dataSet = array(
			'user_id'=> $userId,
			'type'=> 2,
			'points'=> $points,
			'balance'=> $currentPointBalance,
			'created_on'=>date('Y-m-d H:i:s')
		);
		$result = $this->_insert('user_point_ledger', $dataSet);
		return ($result['error']==false) ? $result['insert_id'] : false;
	}

	public function addPointLedger($userId, $points, $currentPointBalance, $type, $ref_id=0){
		$dataSet = array(
			'user_id'=> $userId,
			'type'=> $type,
			'points'=> $points,
			'balance'=> $currentPointBalance,
			'ref_id'=> $ref_id,
			'created_on'=>date('Y-m-d H:i:s')
		);

		$result = $this->_insert('user_point_ledger', $dataSet);
		return ($result['error']==false) ? $result['insert_id'] : false;
	}

	public function updateCurrentPointBalance($userId, $currentPointBalance){
		return $this->_update('users', array('current_point_balance'=>$currentPointBalance), array('id'=>$userId));
	}

	public function userCurrentPointBalance($userId){
		$query = "SELECT current_point_balance FROM users WHERE id=$userId";
		$data = $this->fetchRow($query);
		return ($data) ? $data['current_point_balance'] : 0;
	}
	

	public function getPointLedger($userId, $startDate, $endDate){
		$query="
			SELECT id, type, points, ref_id as refId, balance, DATE_FORMAT(created_on, '%d/%m/%Y') as createdDate
			FROM user_point_ledger 
			WHERE user_id=$userId AND DATE_FORMAT(created_on, '%Y-%m-%d') BETWEEN '$startDate' AND '$endDate' ";

		$query.=" ORDER BY id DESC";
		return $this->fetchResult($query);
	}

	
	public function userTotalScan($userId, $startDate, $endDate){
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

	public function userTotalTransfer($userId, $startDate, $endDate){
		$query="
			SELECT 
			  s.id,
				s.ref_no, 
				u.name, 
				u.mobile,
				s.pointPaidStatus,
				s.pointRemark
			FROM transfer_points s, users u 
			WHERE u.id=s.transfer_to AND s.user_id=$userId
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

	public function scanHistory($userId){
		//	s.points,
		$query="
			SELECT 
				s.coupon_id as couponId, 
				c.coupon_code as couponCode,
				date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%d/%m/%Y') as scannedDate,
				date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%h:%i %p') as scannedTime
			FROM scanned_coupons s, coupon_codes c 
			WHERE c.id=s.coupon_id AND s.user_id=$userId
			ORDER BY s.id DESC LIMIT 90";
		return $this->fetchResult($query);
	}

	public function scannedCouponDetail($couponId){
		//	s.points,
		$query="
			SELECT 
				c.coupon_code as couponCode,
				c.points,
				p.id as productId,
				p.product_name as productName,
				p.product_mrp as productMRP,
				p.product_series as productSeries,
				p.product_exp_date as productFiled3,
				m.batch_number as batchNumber,
				m.batch_size as batchSize,
				DATE_FORMAT(m.date_of_mfg,'%d/%m/%Y') as dateOfMfg,
				m.date_of_mfg as dateOfExpiry,
				m.validity
			FROM coupon_codes c, coupon_batch_meta m, products p 
			WHERE p.id=m.product_id AND m.id=c.coupon_order_id AND c.id=$couponId
		";
		return $this->fetchRow($query);
	}

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
				p.product_exp_date as productFiled3,
				m.batch_number as batchNumber,
				DATE_FORMAT(m.date_of_mfg, '%d/%m/%Y') as dateOfMfg,
				date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%d/%m/%Y') as scannedDate,
				date_format(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on),'+00:00','+05:30'), '%h:%i %p') as scannedTime
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

	public function receivedPointDetail($userId, $date){
		$query="
			SELECT 
				t.points, 
				t.ref_no,
				u.name as receivedFromName,
				CONCAT(u.name,' - ',u.mobile) as receivedFromMobile,
				date_format(CONVERT_TZ(FROM_UNIXTIME(t.created_on),'+00:00','+05:30'), '%h:%i:%p') as receiveTime
			FROM transfer_points t, users u
			WHERE u.id=t.user_id AND t.transfer_to=$userId AND FROM_UNIXTIME(t.created_on, '%Y-%m-%d') = '$date' 
			ORDER BY t.id DESC";
			
		return $this->fetchResult($query);
	}

	public function userScanCoupons($userId){
		$query = "SELECT coupon_id as couponId, points FROM scanned_coupons WHERE user_id=$userId AND is_transferred=0 ORDER BY id ASC";
		return $this->fetchResult($query);
	}
	public function userBonusCoupons($userId){
		$query = "SELECT coupon_id as couponId, points FROM bonus_coupons WHERE user_id=$userId AND is_transferred=0 ORDER BY id ASC";
		return $this->fetchResult($query);
	}

	public function userReceivedCoupons($userId){
		$query = "SELECT coupon_id as couponId, points FROM received_coupons WHERE user_id=$userId AND is_transferred=0 ORDER BY id ASC";
		return $this->fetchResult($query);
	}

	public function isReceivedFromAll(){
		$query ="SELECT meta_value FROM setting_meta WHERE meta_key='IS_RECEIVED_FOR_ALL'";
		$data = $this->fetchRow($query);
		return ($data && $data['meta_value']==1) ? true : false; 
	}

	public function allAuthoriseNumbers(){
		$query="SELECT mobile FROM user_authrise_category"; 
		$data = $this->fetchResult($query);
		if($data){
			foreach ($data as $key => $value) {
				$mobiles[] = $value['mobile'];
			}
			return $mobiles;
		} else {
			return array();
		}
	}

	public function isAuthoriseToReceive($mobile){
		$isReceivedFromAll = $this->isReceivedFromAll();
		if($isReceivedFromAll){
			return true;
		} else {
			$allAuthoriseNumbers = $this->allAuthoriseNumbers($mobile);
			if(in_array($mobile, $allAuthoriseNumbers)){
				return true;
			} else {
				return false;
			}
		}
	}

	public function getLastScanTime($userId){
		$query = "SELECT scanned_on FROM scanned_coupons WHERE user_id=$userId ORDER BY id DESC LIMIT 3";
		$data =  $this->fetchResult($query);
		if($data){
			return (isset($data[2]['scanned_on'])) ? $data[2]['scanned_on'] : 0;
		} else {
			return 0;
		}
	}

	//id	user_id	transfer_to	points	ref_no	created_on

	public function addTransferTransaction($userId, $tansferUserId, $points){
	    
	    $ref_no = date('YmdHis').$userId;
			$insertData = array(
				'user_id' => $userId,	
				'transfer_to' => $tansferUserId,	
				'points' => $points,	
				'ref_no' => $ref_no,
				'created_on' => time()
			);

			$result = $this->_insert('transfer_points', $insertData);
			if($result['error']==false){
				return $result['insert_id'];
			} else {
				return false;
			}
	}

	public function addReceivedCoupons($transactionId, $couponReceived){

		  $i=0;
		  foreach ($couponReceived as $value) {
		  	$couponReceived[$i]['transaction_id'] = $transactionId;
		  	$i++;
		  }

			$result = $this->_insertArray('received_coupons', $couponReceived);
			if($result['error']==false){
				return true;
			} else {
				return false;
			}
	}

	public function markUserCouponTransferred($userId){
		$time = time();
	  $this->_update('scanned_coupons', array('is_transferred'=>1, 'transferred_on'=>$time), array('user_id'=>$userId));
	  $this->_update('received_coupons', array('is_transferred'=>1, 'transferred_on'=>$time), array('user_id'=>$userId));
	  $this->_update('bonus_coupons', array('is_transferred'=>1, 'transferred_on'=>$time), array('user_id'=>$userId));
	
	
	}

	public function getScanOnlyNumber($mobile){
		$query="SELECT meta_value FROM setting_meta WHERE meta_key='ADMIN_SCAN_NUMBER' and meta_value = $mobile";
		$data = $this->fetchRow($query);
		return ($data) ? $data['meta_value'] : 0;
	}

	public function getFinalPointReceiver(){
		$query="SELECT meta_value FROM setting_meta WHERE meta_key='ADMIN_POINT_RECEIVER'";
		$data = $this->fetchRow($query);
		return ($data) ? $data['meta_value'] : 0;
	}

	public function addFeedback($userId, $couponId, $productId, $optionId, $remark){

		$array = array(
			'user_id' => $userId, 
			'coupon_id' => $couponId,  
			'product_id' => $productId, 
			'option_id' => $optionId, 
			'remark' => $remark,
			'created_on'=> time()
		);

		return $this->_insert('product_feedback', $array);

	}
	
	
public function pointTransferDetail($transferDate,$transferByUserId){
    
	 $query="SELECT u.name as transferToUser,u.mobile as transferToMobile,tp.*,date_format(CONVERT_TZ(FROM_UNIXTIME(tp.created_on),'+00:00','+05:30'), '%Y-%m-%d') as createdOn, date_format(CONVERT_TZ(FROM_UNIXTIME(tp.created_on),'+00:00','+05:30'), '%h:%i %p') as scannedTime FROM transfer_points tp JOIN users u on tp.transfer_to=u.id Where tp.user_id=$transferByUserId AND  date_format(CONVERT_TZ(FROM_UNIXTIME(tp.created_on),'+00:00','+05:30'), '%Y-%m-%d')='$transferDate' ";      
		
		$data =  $this->fetchResult($query);
		
		return $data;
	}




	public function pointTransferDetailByWeek($filter){
		
		
		$start_date = $filter['start_date'];
		$end_date = $filter['end_date'];
			
		
		 $query="SELECT sum(tp.points) as sumofpoints FROM transfer_points tp JOIN users u on tp.user_id=u.id Where date_format(CONVERT_TZ(FROM_UNIXTIME(tp.created_on),'+00:00','+05:30'), '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";  
		if(!empty($filter['customerType'])){
				$customerType = $filter['customerType'];
				$query.=" AND u.user_role_id='$customerType'";
			}	 

	 
		
		$data =  $this->fetchResult($query);
		
		return $data;
	}
	public function userByWeek($filter){
		
		
		$start_date = $filter['start_date'];
		$end_date = $filter['end_date'];
			
		
		 $query="SELECT count(tp.user_id) as totaluser FROM transfer_points tp JOIN users u on tp.user_id=u.id Where date_format(CONVERT_TZ(FROM_UNIXTIME(tp.created_on),'+00:00','+05:30'), '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";  
		if(!empty($filter['customerType'])){
				$customerType = $filter['customerType'];
				$query.=" AND u.user_role_id='$customerType'";
			}	 

	 
		
		$data =  $this->fetchResult($query);
		
		return $data;
	}
	public function totalPointTransferDetailByWeek($filter){
		
		
		$start_date = $filter['start_date'];
		$end_date = $filter['end_date'];
			
		
	 $query="SELECT sum(tp.points) as sumofpoints FROM transfer_points tp JOIN users u on tp.user_id=u.id Where date_format(CONVERT_TZ(FROM_UNIXTIME(tp.created_on),'+00:00','+05:30'), '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";  
	
	 
		
		$data =  $this->fetchResult($query);
		
		return $data;
	}
	public function pointTransferDetailByMonth($filter)
	{
	$year = $filter['year'];
    
	$query="SELECT sum(tp.points) as sumofpoints,
							DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(tp.created_on),'+00:00','+05:30'), '%Y-%m') AS month FROM transfer_points tp JOIN users u on tp.user_id=u.id Where date_format(CONVERT_TZ(FROM_UNIXTIME(tp.created_on),'+00:00','+05:30'), '%Y-%m-%d') BETWEEN '$year-01' AND '$year-12'";  
			if(!empty($filter['customerType'])){
					$customerType = $filter['customerType'];
					$query.=" AND u.user_role_id='$customerType' ";
				}	 

	 $query.="  GROUP BY month ORDER BY tp.created_on ASC";
		
		$data =  $this->fetchResult($query);
		return $data;
	}
	public function userByMonth($filter)
	{
	$year = $filter['year'];
    
	$query="SELECT count(distinct tp.user_id) as totaluser,
							DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(tp.created_on),'+00:00','+05:30'), '%Y-%m') AS month FROM transfer_points tp JOIN users u on tp.user_id=u.id Where date_format(CONVERT_TZ(FROM_UNIXTIME(tp.created_on),'+00:00','+05:30'), '%Y-%m-%d') BETWEEN '$year-01' AND '$year-12'";  
			if(!empty($filter['customerType'])){
					$customerType = $filter['customerType'];
					$query.=" AND u.user_role_id='$customerType' ";
				}	 

	 $query.="  GROUP BY month ORDER BY tp.created_on ASC";
		
		$data =  $this->fetchResult($query);
		return $data;
	}
	public function totalPointTransferDetailByMonth($filter){
	$year = $filter['year'];
    
	 $query="SELECT sum(tp.points) as sumofpoints,
							DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(tp.created_on),'+00:00','+05:30'), '%Y-%m') AS month FROM transfer_points tp JOIN users u on tp.user_id=u.id Where date_format(CONVERT_TZ(FROM_UNIXTIME(tp.created_on),'+00:00','+05:30'), '%Y-%m-%d') BETWEEN '$year-01' AND '$year-12'";
$query.="  GROUP BY month ORDER BY tp.created_on ASC";	
			 

	 
		
		$data =  $this->fetchResult($query);
		return $data;
	}
	// public function pointTransferDetail($transferDate,$transferByUserId){
    
	 // $query="SELECT u.name as transferToUser,u.mobile as transferToMobile,tp.*,date_format(CONVERT_TZ(FROM_UNIXTIME(tp.created_on),'+00:00','+05:30'), '%Y-%m-%d') as createdOn, date_format(CONVERT_TZ(FROM_UNIXTIME(tp.created_on),'+00:00','+05:30'), '%h:%i %p') as scannedTime FROM transfer_points tp JOIN users u on tp.transfer_to=u.id Where tp.user_id=$transferByUserId AND  date_format(CONVERT_TZ(FROM_UNIXTIME(tp.created_on),'+00:00','+05:30'), '%Y-%m-%d')='$transferDate' ";      
		
		// $data =  $this->fetchResult($query);
		
		// return $data;
	// }
	
	
	
	
public function createGiftRequest($userId, $giftId,$giftDeliveryAddress){

		$array = array(
		    'giftRequestDate'=>date("Y-m-d H:i:s"),
			'userId' => $userId, 
			'giftId' => $giftId,
			'deliveryAddress' => $giftDeliveryAddress,
			'updatedOn'=>date("Y-m-d H:i:s")
			
		);

		return $this->_insert('gift_request', $array);

	}

public function getGiftRequestInfo($giftRequestId){
		
		$query="SELECT gr.*,u.name as userName,u.mobile as userMobile,u.user_role_id as userRoleId FROM  gift_request gr JOIN users u ON u.id=gr.userId WHERE gr.id=$giftRequestId ";      
		
		$data =  $this->fetchResult($query);
		
		return $data;

	}
	
	

public function getGiftRequestByUser($userId){
		
		$query="SELECT gr.*,u.name as userName,u.mobile as userMobile,u.user_role_id as userRoleId FROM  gift_request gr JOIN users u ON u.id=gr.userId WHERE gr.userId=$userId ";      
		
		$data =  $this->fetchResult($query);
		
		return $data;

	}
	
	
public function getAdminReceiverNumber(){
		$query = "SELECT meta_value FROM setting_meta WHERE meta_key='ADMIN_POINT_RECEIVER' ";
		$data = $this->fetchRow($query);
		if($data){
			return $data['meta_value'];
		} else {
			return '';
		}
	}


 public function giftIdInPointsSummaryAPI ($userId, $refId){
		 $query="SELECT gr.giftId FROM user_point_ledger upl JOIN gift_request gr ON gr.giftRequestDate = upl.created_on WHERE upl.user_id=$userId and upl.ref_id=$refId and gr.userId=$userId";
		 $response = $this->fetchResult($query);
		
		return $response['0']['giftId'];
	}
	
	
public function giftDataByUserIdAndDate ($userId, $requestDate){
		  $query="SELECT *, date_format(giftRequestDate, '%Y-%m-%d') as requestDate , date_format(giftRequestDate, '%h:%i %p') as requestTime FROM gift_request WHERE userId=$userId AND 	giftRequestDate like '%$requestDate%' "; 
		 return $this->fetchResult($query);
		
	}
	
	
public function getCategoryScanLimit($categoryId)
    {
        $query = "SELECT * FROM scan_category_restriction WHERE catId=$categoryId";
        $resultData = $this->fetchRow($query);
        return (isset($resultData['scanLimit']) && $resultData['scanLimit'] > 0) ? $resultData['scanLimit'] : 0;
    }

public function getCategoryScanLimitTotal($categoryId)
    {
        $query = "SELECT * FROM scan_category_restriction WHERE catId=$categoryId";
        $resultData = $this->fetchRow($query);
        return (isset($resultData['total_scan_limit']) && $resultData['total_scan_limit'] > 0) ? $resultData['total_scan_limit'] : 0;
    }    

public function getTodayCategoryScanCount($userId, $parentCategoryId)
    {
        $date = date('Y-m-d');
      $query = "SELECT count(sc.id) as num FROM scanned_coupons sc JOIN coupon_codes cc ON cc.id=sc.coupon_id  JOIN coupon_batch_meta cbm ON cc.coupon_order_id=cbm.id WHERE sc.user_id=$userId AND cbm.category_id=$parentCategoryId AND date_format(CONVERT_TZ(FROM_UNIXTIME(sc.scanned_on),'+00:00','+05:30'), '%Y-%m-%d') = '$date'"; 
        
        $data = $this->fetchRow($query);
        return ($data) ? $data['num'] : 0;
    }
    
    public function getTotalCategoryScanCount($userId, $parentCategoryId)
    {
        $date = date('Y-m-d');
        $query = "SELECT count(sc.id) as num FROM scanned_coupons sc JOIN coupon_codes cc ON cc.id=sc.coupon_id  JOIN coupon_batch_meta cbm ON cc.coupon_order_id=cbm.id WHERE sc.user_id=$userId AND cbm.category_id=$parentCategoryId"; 
        
        $data = $this->fetchRow($query);
        return ($data) ? $data['num'] : 0;
    }

 public function submitOrder($userId, $mobile, $orderItemQty,$orderComment)
    {
        $orderData = array(
            'user_id' => $userId,
            'user_mobile' => $mobile,
            'order_date' => date("Y-m-d H:i:s"),
            'payment_status' => "Pending Payment",
            'order_status' => "Pending",
            'order_comment' => $orderComment
        );

        $orderData = $this->_insert('orders', $orderData);
        $lastInsterOrderId = $orderData['insert_id'];

        foreach ($orderItemQty as $id => $qty) :
            $orderItemData = array(
                'item_product_id' => $id,
                'item_qty' => $qty,
                'order_id' => $lastInsterOrderId,
            );
            $this->_insert('order_items', $orderItemData);
        endforeach;

        return $lastInsterOrderId;
    }

    public function getOrderList($userId,$mobile)
    {

        $query = "SELECT order_id,order_date,order_status,payment_status,	order_updateDate,order_date FROM orders where user_id=$userId and user_mobile=$mobile";

        $data = $this->fetchResult($query);

        return $data;
    }

    public function orderDetail($orderId)
    {
        $query = "SELECT o.*,oi.item_product_id,oi.item_qty,oi.item_id FROM orders o JOIN order_items oi ON oi.order_id=o.order_id WHERE o.order_id=$orderId";
        
        return $this->fetchResult($query);

    }
    
    public function disPatchQty($id,$itemid)
	{
	    $dispatchQuery = "SELECT sum(dispatch_qty) as dispatchQTY FROM order_items_dispatch WHERE order_item_id=$itemid and order_id=$id"; 
	    
	   return $this->fetchRow($dispatchQuery);
	}
	
	
	public function userCurrentRoleIdDealerCode($userId){
		$query = "SELECT user_role_id,dealerCode FROM users WHERE id=$userId";
		$data = $this->fetchRow($query);
		return $data;
	}
	
	public function addMultiScanRecord($dataSet){
		return $this->_insert('multi_scan_record', $dataSet);
	}
	
	public function isUserData($mobile){
	 
		$query = "SELECT * FROM users WHERE mobile='$mobile' ORDER BY id DESC LIMIT 1"; 
		return $this->fetchRow($query);
	}

	
public function allReportDataScanned($startDate,$endDate){   

$startDate1 = strtotime($startDate);
$startDate2 = date('Y-m-d',$startDate1);
$startDate3 = strtotime($startDate2);

$endDate1 = strtotime($endDate);
$endDate2 = date('Y-m-d',$endDate1);
$endDate3 = strtotime($endDate2);
  

$query = "SELECT DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(s.scanned_on), '+00:00', '+05:30'), '%Y-%m-%d') AS datef, pt.plant_name AS plant_name, pc1.category_name as main_category, pc.category_name AS sub_category, SUM(s.points) AS points_received, COUNT(s.coupon_id) AS total_scanned_code, p.product_name AS product, p.product_series AS product_series FROM scanned_coupons s JOIN coupon_codes c ON c.id = s.coupon_id JOIN coupon_batch_meta m ON m.id = c.coupon_order_id JOIN products p ON p.id = m.product_id JOIN plant_list pt ON m.plant_id = pt.plant_id JOIN product_category pc ON m.subcat_id = pc.id JOIN product_category pc1 ON m.category_id = pc1.id WHERE s.scanned_on BETWEEN '$startDate3' AND '$endDate3' GROUP BY datef, m.product_id ORDER BY s.scanned_on ASC";    
  
	  $data =  $this->fetchResult($query);
	  
	  return $data;
  }

  public function allReportData($startDate,$endDate){
	  
$startDate1 = strtotime($startDate);
$startDate2 = date('Y-m-d',$startDate1);
$startDate3 = strtotime($startDate2);

$endDate1 = strtotime($endDate);
$endDate2 = date('Y-m-d',$endDate1);
$endDate3 = strtotime($endDate2);
  
  
  $query="SELECT
DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(cm.created_on), '+00:00', '+05:30'), '%Y-%m-%d') AS datef,  
pt.plant_name AS plant_name,
pc1.category_name as main_category,
pc.category_name AS sub_category,
SUM(cc.points) AS total_points,
SUM(sc.points) AS activated_scanned_points,
p.product_name AS Product,
  p.product_series,
  COUNT(cc.id) AS Total_active_code,
  COUNT(sc.coupon_id) AS activated_scanned_code
FROM `coupon_codes` cc
JOIN `coupon_batch_meta` cm ON cc.coupon_order_id = cm.id
JOIN products p ON p.id = cm.product_id
left JOIN scanned_coupons sc ON sc.coupon_id = cc.id
  JOIN plant_list pt ON cm.plant_id = pt.plant_id
  JOIN product_category pc ON cm.subcat_id = pc.id
  JOIN product_category pc1 ON cm.category_id = pc1.id
WHERE cm.created_on BETWEEN '$startDate3' AND '$endDate3'
GROUP BY 
  datef, cm.product_id";      
	  
	  $data =  $this->fetchResult($query);
	  
	  return $data;
  }


public function wholesalerList($state,$city,$market){

	$query="SELECT * FROM users WHERE state ='$state' AND city ='$city' AND market ='$market' AND user_role_id = 13 "; 
	$data = $this->fetchResult($query);
	return ($data) ? $data : '';
}

public function marketList($state,$city){

	$query="SELECT market FROM users WHERE state ='$state' AND city ='$city'  AND user_role_id = 13  group by market"; 
	$data = $this->fetchResult($query);
	return ($data) ? $data : '';
}

public function cityList($state){

	$query="SELECT city FROM users WHERE state ='$state' AND user_role_id = 13  group by city"; 
	$data = $this->fetchResult($query);
	return ($data) ? $data : '';
}
  	
public function stateList(){

	$query="SELECT state FROM users WHERE user_role_id = 13 group by state "; 
	$data = $this->fetchResult($query);
	return ($data) ? $data : '';
}


public function wholesalerTransferList($user_id){
	
	$query="SELECT tp.user_id AS user_id, tp.transfer_to as transfer_to, u.* FROM transfer_points tp JOIN users u ON u.id = tp.transfer_to WHERE tp.user_id = '$user_id'  AND u.user_role_id = 13 group by u.mobile"; 
	$data = $this->fetchResult($query);
	return ($data) ? $data : '';
}
  	

} // END USER CLASS