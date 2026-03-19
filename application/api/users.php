<?php 

require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/users.php';
require_once CLASS_DIR.'/api.php';
require_once CLASS_DIR.'/Feedback.php';
	

$api = new api();
$user = new users();
$feedback = new Feedback();


if(isset($_GET['controller']) && $_GET['controller']=='doLogin'){

	$post = $api->jsonBody();
	

	$data = array(
		'username'=> $post['username'],
		'password'=> $post['password'],
	);
	
	$result = $user->userLogin($data);

	if($result['error']==false){

		$adminUserId = $result['data']['id'];
		$adminUserMobile = $result['data']['mobile'];
		if(empty($adminUserMobile)){
			$return = array('success'=>0, 'message'=>'Admin profile information incomplete');
		} else {

			//$otpcode = $api->otpcode(4);
			//$api->sendOTP($adminUserMobile, $otpcode);
			$otpcode = 1234;
			
		 	$token = $user->addAdminLoginOtp($adminUserId, $otpcode); 
			if($token){
				$return['token'] = $token;
				$return = array('success'=>1, 'data'=>$return, 'message'=>'Success');
			} else {
				$return = array('success'=>0, 'data'=>$return, 'message'=>'Something went wrong.');
			}
		}

	} else {
		$return = array('success'=>0, 'data'=>array(), 'message'=>$result['error']);
	}
	
	$api->setResponse($return, 200);		
}

if(isset($_GET['controller']) && $_GET['controller']=='validateLoginOtp'){

	$post = $api->jsonBody();
	$otpcode = $post['otpcode'];
	$token = $post['token'];
	
	$userId = $user->validateAdminLoginOtp($token, $otpcode);
	if($userId){
			$result = $user->userLoginData($userId);
			
			if($result){

				if(!empty($result['role_access'])){
					$result['role_access'] = json_decode($result['role_access']);
				} else {
					$result['role_access'] = array();
				}
				
			    
			
				$user->createUserSession($result);
				
				$return = array('success'=>1, 'data'=>$result, 'message'=>'Successfully Login...');
			} else {
				$return = array('success'=>0, 'message'=>'Something went wrong.');
			}
	} else {
		$return = array('success'=>0, 'message'=>'Invalid OTP Code');
	}
	$api->setResponse($return, 200);		
}

if(isset($_GET['controller']) && $_GET['controller']=='updateCompanyInfo'){
	$post = $api->jsonBody();

	$data = array(
		'company_name'=> $post['company'],
		'email'=> $post['email'],
		'mobile'=> $post['mobile'],
		'phone'=> '',
		'logo'=> $post['logo'],
	);

	$companyId = $user->isCompany();
	if($companyId){
		$result = $user->updateCompany($companyId, $data);
	} else {
		$result = $user->addCompany($data);
	}
	
	// update Password
    $adminUserId = $_SESSION['ADMIN_USER']['ID'];
    $passwordData = array(
	    'password'=> md5($post['pass'])
		);
		
 if(count($passwordData) > 0){
     $user->updateAdminUser($adminUserId,$passwordData);
 }

// end of update password


	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Company information successfully updated');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='getCompany'){

	$data = $user->getCompany();
	if($data){
		$return = array('success'=>1, 'data'=>$data, 'message'=>'Success');
	} else {
		$return = array('success'=>0, 'data'=>array(), 'message'=>'');
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='update'){
	$post = $api->jsonBody();

	$id = $_GET['id'];

	$data = array(
		'name'=> $post['name'],
		'username'=> $post['username'],
		'password'=> md5($post['password']),
		'email'=> $post['email'],
		'mobile'=> $post['mobile'],
		'user_role_id'=> $post['user_role_id'],
	);


	if(empty($post['password'])){
		unset($data['password']);
	}


	$result = $user->updateUser($id, $data);

	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Success');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='adminUsers'){

	$post = $api->jsonBody();
	$result = $user->adminUsersList($post);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='addAdminUser'){

	$post = $api->jsonBody();
	$postArray = array(
		'name'=>$post['name'],
		'mobile'=>$post['mobile'],
		'email'=>$post['email'],
		'username'=>$post['username'],
		'password'=>md5($post['password']),
		'user_role_id'=>$post['userRoleId'],
		'status'=>$post['status'],
		'is_trash'=>0,
		'created'=>time()
	);
	$result = $user->_insert('admin', $postArray);

	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Role successfully added.');
	} else {
		$return = array('success'=>0, 'message'=>'Unable to add role.');
	}
	
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='deleteAdminUser'){

	$post = $api->jsonBody();
	$id = $post['id'];

	$result = $user->_query("DELETE FROM admin WHERE id=$id");
	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Admin User successfully delete.');
	} else {
		$return = array('success'=>0, 'message'=>'Unable to add role.');
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='adminRoles'){

	$post = $api->jsonBody();
	$result = $user->adminRoleList($post);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='addAdminRole'){

	$post = $api->jsonBody();
	$postArray = array(
		'role_name'=>$post['roleName'],
		'role_access'=>''
	);
	$result = $user->addRole($postArray);

	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Role successfully added.');
	} else {
		$return = array('success'=>0, 'message'=>'Unable to add role.');
	}
	
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='deleteAdminRole'){

	$post = $api->jsonBody();
	$roleId = $post['roleId'];

	$isRoleUser = $user->isRoleUser($roleId);
	if(!$isRoleUser){
		$result = $user->deleteAdminRole($roleId);
		if($result['error']==false){
			$return = array('success'=>1, 'message'=>'Role successfully delete.');
		} else {
			$return = array('success'=>0, 'message'=>'Unable to add role.');
		}
	} else {
		$return = array('success'=>0, 'message'=>'Unable to delete. User register under this role.');
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='getUserPermission'){
	$userRoleId = $_GET['userRoleId'];
	$permission = $user->getUserPermission($userRoleId);
	$api->setResponse($permission, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='updateUserPermission'){

	//print_r($_POST['up']);

	$userRoleId = $_POST['userRole'];
	$permission = json_encode($_POST['up'], true);
	$result = $user->_update('admin_roles', array('role_access'=>$permission), array('role_id'=>$userRoleId));

	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Permission assigned successfully.');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='userFeedback'){

	$post = $api->jsonBody();
	$result = $user->userFeedback($post);

// 	$userFeedbackOption = array(
// 		'1'=>'Product quality is good',
// 		'2'=>'New Product is not good in condition',
// 		'3'=>'Product not available',
// 		'4'=>'Product not getting fitted',
// 		'5'=>'Product not working properly',
// 		'6'=>'Life of product is short',
// 		'7'=>'Points not getting redeemed',
// 		'8'=>'Fake parts are selling in my area',
// 		'9'=>'Develop product for other vechiles',
// 		'10'=>'Other'
// 	);
	
	  $feedBackOptions = $feedback->feedbackOption();
      $userFeedbackOption = [];
      if(!empty($feedBackOptions)){
          foreach($feedBackOptions as $key=>$value){
              $userFeedbackOption[$value['id']] = $value['name'];
          }
      }

	if($result){

		$i = 0;
		foreach ($result as $key => $value) {
			$optionId = $value['optionId'];
			$result[$i]['title'] = $userFeedbackOption[$optionId];
			$i++;
		}

		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}


if (isset($_GET['controller']) && $_GET['controller'] == 'dashNegativeFeedback') {

    $post = $api->jsonBody();
    $result = $user->dashboardNegativeUserFeedback($post);

    // $userFeedbackOption = array(
    //     '1' => 'Product quality is good',
    //     '2' => 'New Product is not good in condition',
    //     '3' => 'Product not available',
    //     '4' => 'Product not getting fitted',
    //     '5' => 'Product not working properly',
    //     '6' => 'Life of product is short',
    //     '7' => 'Points not getting redeemed',
    //     '8' => 'Fake parts are selling in my area',
    //     '9' => 'Develop product for other vechiles',
    //     '10' => 'Other',
    // );
    
    $feedBackOptions = $feedback->feedbackOption();
    $userFeedbackOption = [];
    if(!empty($feedBackOptions)){
      foreach($feedBackOptions as $key=>$value){
          $userFeedbackOption[$value['id']] = $value['name'];
      }
    }

    if ($result) {

        $i = 0;
        foreach ($result as $key => $value) {
            $optionId = $value['optionId'];
            $result[$i]['title'] = $userFeedbackOption[$optionId];
            $i++;
        }

        $return = array('success' => 1, 'data' => $result);
    } else {
        $return = array('success' => 0, 'data' => array());
    }

    $api->setResponse($return, 200);
}

if (isset($_GET['controller']) && $_GET['controller'] == 'negativeFeedbackDetail') {

    $id = $_GET['id'];
    $result = $user->negativeFeedbackDetail($id);

    if ($result) {

        $user->updateFeedbackReadStatus($id);

        $userFeedbackOption = array(
            '1' => 'Product quality is good',
            '2' => 'New Product is not good in condition',
            '3' => 'Product not available',
            '4' => 'Product not getting fitted',
            '5' => 'Product not working properly',
            '6' => 'Life of product is short',
            '7' => 'Points not getting redeemed',
            '8' => 'Fake parts are selling in my area',
            '9' => 'Develop product for other vechiles',
            '10' => 'Other',
        );

        $optionId = $result['optionId'];
        $result['title'] = $userFeedbackOption[$optionId];

        $return = array('success' => 1, 'data' => $result);
    } else {
        $return = array('success' => 0, 'data' => array());
    }

    $api->setResponse($return, 200);
}
