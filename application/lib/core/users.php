<?php

class users extends dbclass {
	
	var $id;
	var $name;
	var $role_access;
	
	public function __construct() {
		parent::__construct();
		$this->id = $_SESSION['ADMIN_USER']['ID'];
		$this->name = $_SESSION['ADMIN_USER']['NAME'];
		$this->email = $_SESSION['ADMIN_USER']['EMAIL'];
		$this->mobile = $_SESSION['ADMIN_USER']['MOBILE'];
		$this->role = $_SESSION['ADMIN_USER']['ROLE'];
		$this->role_access = $_SESSION['ADMIN_USER']['ACCESS'];
	}
	
	
	public function createUserSession($array){ 
	   
		$_SESSION['ADMIN_USER']['ID'] = $array['id'];
		$_SESSION['ADMIN_USER']['NAME'] = $array['name'];
		$_SESSION['ADMIN_USER']['EMAIL'] = $array['email'];
		$_SESSION['ADMIN_USER']['MOBILE'] = $array['mobile'];
		$_SESSION['ADMIN_USER']['ROLE'] = $array['user_role_id'];
		$_SESSION['ADMIN_USER']['ACCESS'] = $array['role_access'];
		$_SESSION['ADMIN_USER']['DB_TOKEN_OTP_HASH'] = $array['otp_hash'];
		$_SESSION['ADMIN_USER']['logged_domain'] = "test_paras";
	
		
	}

	public function destroyUserSession(){
		unset($_SESSION['ADMIN_USER']);
		session_destroy();
	}

	public function validateSession(){ 
	
		if(!empty($_SESSION['ADMIN_USER']['ID']) || !empty($_SESSION['ADMIN_USER']['NAME']) || !empty($_SESSION['ADMIN_USER']['ROLE'])){
			return true;
		} else {
			header('location:'.SITE_URL.'/login');
			exit(0);
		}
	}

	public function isLogin(){
		if(!empty($_SESSION['ADMIN_USER']['ID']) && !empty($_SESSION['ADMIN_USER']['ROLE'])){
			return true;
		} else {
			return false;
		}
	}

  // USER LOGIN CHECK
	public function userLogin($data){

		$error=false;
		$username = $data['username'];
		$password = md5($data['password']);
		$password = filter_var($password, FILTER_SANITIZE_STRING);

		$query="SELECT a.id, a.name, a.email, a.mobile, a.user_role_id, b.role_access 
		FROM admin a, admin_roles b
		WHERE b.role_id=a.user_role_id AND a.username='$username' AND a.password='$password' AND a.status=1"; 
		$result = $this->fetchRow($query);
		
		if(!$result){
			$error = 'Invalid username or password';
			$this->destroyUserSession();
		}

		if($error){
			return array('error'=>$error);
		} else {
			return array('error'=>false, 'data'=>$result);
		}
	}

	public function userLoginData___OLDER($userId=0){
		$query="
		SELECT a.id, a.name, a.email, a.mobile, a.user_role_id, b.role_access
		FROM admin a, admin_roles b
		WHERE b.role_id=a.user_role_id AND a.id=$userId"; 
		return $this->fetchRow($query);
	}

	public function addAdminLoginOtp____OLDER($adminUserId, $otpCode){
		$token = md5(time().rand().'otp');
		$insert = array(
			'admin_user_id'=>$adminUserId,
			'otp_hash'=> md5($token.$otpCode)
		);
		$result = $this->_insert('admin_otp', $insert);
		if($result['error']==false){
			return $token;
		} else {
			return false;
		}
	}


 	public function userLoginData($userId=0){
		$query="
		SELECT a.id, a.name, a.email, a.mobile, a.user_role_id, b.role_access , c.otp_hash 
		FROM admin a, admin_roles b , admin_otp c
		WHERE b.role_id=a.user_role_id AND a.id=c.admin_user_id AND a.id=$userId"; 
		return $this->fetchRow($query);
	}

   	public function addAdminLoginOtp($adminUserId, $otpCode){
   	    
		$token = md5(time().rand().'otp');
		
		$table= array('admin_otp');
		$getColumn = array('admin_user_id','otp_hash','id');
		$whereCond = array("admin_user_id=$adminUserId");
		
		$checkOtpHashExistSql = $this->_createQuery($table,$getColumn,$whereCond,array(),array(),1);
		$fetchRow = $this->fetchRow($checkOtpHashExistSql);
		
		
		if( count($fetchRow)>0 && $fetchRow['id'])
		{

		   $whereUpdateCond['id'] = $fetchRow['id'];
		   $updateCol = array('otp_hash'=> md5($token.$otpCode)); 
		   $result = $this->_update('admin_otp', $updateCol,$whereUpdateCond);
		    
		}
		else
		{
		  
		    $insert = array('admin_user_id'=>$adminUserId,'otp_hash'=> md5($token.$otpCode));
		    $result = $this->_insert('admin_otp', $insert);
		    
		}
		
		
		if($result['error']==false)
			return $token;
		 else 
			return false;
		
	}


	public function validateAdminLoginOtp($token, $otpCode){
		$otp_hash = md5($token.$otpCode);
		$query="SELECT admin_user_id FROM admin_otp WHERE otp_hash='$otp_hash'";
		$data = $this->fetchRow($query);
		return ($data) ? $data['admin_user_id'] : false;
	}


// CHECK EMAIL ALREADY EXIST
	public function userExist($email){
		$query="SELECT id FROM users WHERE email ='$email'"; 
		$responce = $this->fetchRow($query);
		if(!$responce){
			return false;
		} else {
			return true;
		}
	}
	
// CHECK MOBILE ALREADY EXIST
	public function userMobileExist($mobile){
		$query="SELECT id FROM users WHERE mobile ='$mobile'"; 
		$responce = $this->fetchRow($query);
		if(!$responce){
			return false;
		} else {
			return true;
		}
	}

// VALIDATE EMAIL VARIFICATION CODE
	public function validateEmailToken($token){

		$check = $this->fetchRow("SELECT uid FROM users_meta WHERE meta_key='email_verification_code' AND meta_value='$token'");
		if($check){

			$uid  = $check['uid'];
			$this->activateSignUp($uid);
			$rr = $this->fetchRow("SELECT id, name, email, user_role FROM users WHERE id='$uid'");
			$this->createUserSession($rr);

			return true;
		} else {
			return false;
		}
	}
	
// USER ROLE
	public function addUser($data){
		return $this->_insert('users', $data);
	}
	
	public function updateUser($id, $data){
		return $this->_update('users', $data, array('id'=>$id));
	}
	
	public function updateAdminUser($id, $data){
		return $this->_update('admin', $data, array('id'=>$id));
	}
	
	
	public function deleteUser($id){
		$query="DELETE FROM users WHERE id=$id";
		return $this->_query($query);
	}

	public function isCompany(){
		$query = "SELECT id FROM company ORDER BY id ASC LIMIT 1";
		$result = $this->fetchRow($query);
		if($result){
			return  $result['id'];
		} else {
			return false;
		}
	}

	public function getCompany(){
		$query = "SELECT * FROM company ORDER BY id ASC LIMIT 1";
		$result = $this->fetchRow($query);
		if($result){
			return  $result;
		} else {
			return false;
		}
	}

	public function addCompany($data){
		return $this->_insert('company', $data);
	}
	
	public function updateCompany($id, $data){
		return $this->_update('company', $data, array('id'=>$id));
	}

	public function adminRoleList(){
		$query = "SELECT role_id as roleId, role_name as roleName FROM admin_roles WHERE role_id > 2 ORDER BY role_name ASC";
		$result = $this->fetchResult($query);
		if($result){
			return  $result;
		} else {
			return false;
		}
	}

	public function addRole($data){
		return $this->_insert('admin_roles', $data);
	}

	public function isRoleUser($roleId){
		$query="SELECT id FROM admin WHERE user_role_id=$roleId"; 
		return $this->fetchResult($query);
	}

	public function deleteAdminRole($roleId){
		$query="DELETE FROM admin_roles WHERE role_id=$roleId";
		return $this->_query($query);
	}

	public function getUserPermission($userRoleId){
	  $query = "SELECT role_access FROM `admin_roles` WHERE role_id=$userRoleId";
		$data = $this->fetchRow($query);
		return (!empty($data['role_access'])) ? json_decode($data['role_access']) : array();
	}

	public function adminUsersList($filter){
		$query = "SELECT a.id, a.name, a.mobile, a.email, a.username FROM admin a WHERE a.user_role_id > 2 ORDER BY a.id DESC";
		$result = $this->fetchResult($query);
		if($result){
			return  $result;
		} else {
			return false;
		}
	}

	//userFeedback
	public function userFeedback($filter){
		$query = "
		SELECT 
			f.id, 
			p.product_name as productName, 
			c.coupon_code as couponCode, 
			u.name, 
			u.mobile,
			u.city,
			f.option_id as optionId,
			f.remark,
			date_format(CONVERT_TZ(FROM_UNIXTIME(f.created_on),'+00:00','+05:30'), '%d/%m/%Y') as createdOn
		FROM product_feedback f, products p, coupon_codes c, users u
		WHERE u.id=f.user_id AND c.id=f.coupon_id AND p.id=product_id
		ORDER BY f.id DESC";
		$result = $this->fetchResult($query);
		if($result){
			return  $result;
		} else {
			return false;
		}
	}

	public function getUserIdByMobile($mobile){
		$query="SELECT id FROM users WHERE mobile ='$mobile'"; 
		$data = $this->fetchRow($query);
		return ($data) ? $data['id'] : false;
	}

	public function getUserProfileByMobile($mobile){
		$query="
		SELECT id, name, dealerCode, email, mobile, city, user_role_id, current_point_balance as balance
		FROM users WHERE mobile ='$mobile'  ORDER BY id DESC LIMIT 1 "; 
		return $this->fetchRow($query);
	}

	public function updateCurrentPointBalance($userId, $currentPointBalance){
		return $this->_update('users', array('current_point_balance'=>$currentPointBalance), array('id'=>$userId));
	}
	
	
	//dashboardNegativeUserFeedback
    public function dashboardNegativeUserFeedback($filter)
    {
        $query = "
		SELECT
			id,
			option_id as optionId,
			remark,
			date_format(CONVERT_TZ(FROM_UNIXTIME(created_on),'+00:00','+05:30'), '%d/%m/%Y') as createdOn
		FROM product_feedback
		WHERE option_id NOT IN(1,9) AND read_status=1
		ORDER BY id DESC";
        $result = $this->fetchResult($query);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function negativeFeedbackDetail($id)
    {
        $query = "
		SELECT
			f.id,
			p.product_name as productName,
			c.coupon_code as couponCode,
			u.name,
			u.mobile,
			u.city,
			f.option_id as optionId,
			f.remark,
			date_format(CONVERT_TZ(FROM_UNIXTIME(f.created_on),'+00:00','+05:30'), '%d/%m/%Y') as createdOn
		FROM product_feedback f, products p, coupon_codes c, users u
		WHERE u.id=f.user_id AND c.id=f.coupon_id AND p.id=product_id
		AND f.id=$id";
        $result = $this->fetchRow($query);
        if ($result) {
            return $result;
        } else {
            return false;
        }

    }

    public function updateFeedbackReadStatus($id)
    {
        return $this->_update('product_feedback', array('read_status' => 0), array('id' => $id));
    }

    //ENd of dashboardNegativeUserFeedback


	
} // END USER CLASS


