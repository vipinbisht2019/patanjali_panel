<?php 

require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/users.php';
require_once CLASS_DIR.'/loyalty.php';
require_once CLASS_DIR.'/uploads.php';
require_once CLASS_DIR.'/api.php';

$user = new users();



$api = new api();
$loyalty = new loyalty();

// getUserLoyaltyInfo
if(isset($_GET['controller']) && $_GET['controller']=='getUserLoyaltyInfo'){
	$post = $api->jsonBody();
	$mobile = substr($post['mobile'],-10);
	$type = $post['type'];
	$userData = $loyalty->getUserInfo($mobile);

	if($type){
		$catData = $loyalty->getAuthGroupCat($mobile);
	} else {
		$catData = $loyalty->getDeauthGroupCat($mobile);
	}

	if($catData){
		foreach ($catData as $key => $value) {
			$cat[] = $value['category_id'];
		}
	} else {
		$cat = array();
	}

	if($userData){
		$return = array('success'=>1, 'data'=>$userData, 'cat'=>$cat);
	} else {
		$return = array('success'=>0, 'cat'=>$cat, 'message'=>'User not found.');
	}

	$api->setResponse($return, 200);
}



if(isset($_GET['controller']) && $_GET['controller']=='loyaltyAuthorisation'){

	$post = $api->jsonBody();

	$mobile = $post['mobile'];
    
if($mobile):
    
	$loyalty->authCatgoryMobileDelete($mobile);
	$isUser = $loyalty->isUser($mobile);
	
	$userData = $api->callLamiService('/user/name', array('mobile'=>$mobile));
	$userName = "";
	
	if(is_array($userData['data']) && count($userData['data']))
	        $userName = $userData['data']['name'];
	        
	if(!$isUser){
		$userData['userType'] = $post['userType'];
		$userData['name'] = 	$userName;
		$userData['mobile'] = $post['mobile'];
		$userData['state'] = $post['state'];
		$userData['city'] = $post['city'];
		$userData['dealerCode'] = $post['dealerCode'];
		$userId = $loyalty->addUser($userData);
	} else {
	
		$userId = $isUser;
		$updateData['name'] = 	$userName;
		$updateData['state'] = $post['state'];
		$updateData['city'] = $post['city'];
		$updateData['user_role_id'] = $post['userType'];
		$updateData['dealerCode'] = $post['dealerCode'];

		$loyalty->updateUserStateCityName($userId, $updateData);
	}

	$dataSet = $post['data'];
	
	
	foreach ($dataSet as $value) {
	 if(!empty($userId) && !empty($value['id']))
	    {
		    $category_id = $value['id'];
	    	$addArray[] = array('user_id' => $userId,'mobile' => $post['mobile'],'category_id' => $value['id']);
		    $loyalty->_query("DELETE FROM user_deauthrise_category WHERE user_id=$userId AND category_id=$category_id");
	    }
	}

	if(isset($addArray) && count($addArray) > 0){
		$result = $loyalty->authCatgory($addArray);
	}

	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Successfully Authorise');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}
	
else:
        
        $result['error'] = "Please enter the mobile number !";
		$return = array('success'=>0, 'message'=>$result['error']);
	
    
endif;

	$api->setResponse($return, 200);
}


/*

if(isset($_GET['controller']) && $_GET['controller']=='importLoyaltyAuthorisation'){
    
 
//  [0] => mobile
//    [1] => userType
//   [2] => name
//    [3] => state
//    [4] => city
//    [5] => dealerCode
//    [6] => categoryIds

       
    // check there are no errors
    if($_FILES['authorisationFile']['error'] == 0){
        $name = $_FILES['authorisationFile']['name'];
        $ext = strtolower(end(explode('.', $_FILES['authorisationFile']['name'])));
        $type = $_FILES['authorisationFile']['type'];
        $tmpName = $_FILES['authorisationFile']['tmp_name'];
    
         // check the file is a csv
        if($ext === 'csv'){
            $csvAsArray = array_map('str_getcsv', file($tmpName));
            $loyalty->extractGroups($csvAsArray);
            echo "===";
            // echo "<pre>";print_r($csvAsArray); die;
            
 foreach($csvAsArray as $key => $sheetData):

     // avoid 1 st row of csv
     if( $key==0 )
            continue;
    

    $mobile     = $sheetData[0];
    $userType   = $sheetData[1];
    $userName   = $sheetData[2];
    $state      = $sheetData[3];
    $city       = $sheetData[4];  
    $dealerCode = $sheetData[5];
    $categoryIds= $sheetData[6];
    
    
if($mobile):
    
	$loyalty->authCatgoryMobileDelete($mobile);
	$isUser = $loyalty->isUser($mobile);
	
	$userData = $api->callLamiService('/user/name', array('mobile'=>$mobile));
	
	if(is_array($userData['data']) && count($userData['data'])>0)
	        $userName = $userData['data']['name'];
	        
	if(!$isUser){
		$userData['userType'] = $userType;
		$userData['name'] = 	$userName;
		$userData['mobile'] = $mobile;
		$userData['state'] = $state;
		$userData['city'] = $city;
		$userData['dealerCode'] = $dealerCode;
		$userId = $loyalty->addUser($userData);
	} else {
	
		$userId = $isUser;
		$updateData['name'] = 	$userName;
		$updateData['state'] = $state;
		$updateData['city'] = $city;
		$updateData['user_role_id'] = $userType;
		$updateData['dealerCode'] = $dealerCode;

		$loyalty->updateUserStateCityName($userId, $updateData);
	}

    // authorise category ids
    $dataSet = explode(",",$categoryIds);

	foreach ($dataSet as $categoryId) {
	 if(!empty($userId) && !empty($categoryId))
	    {
		    $category_id = $categoryId;
	    	$addArray[] = array('user_id' => $userId,'mobile' => $mobile,'category_id' => $category_id);
		    $loyalty->_query("DELETE FROM user_deauthrise_category WHERE user_id=$userId AND category_id=$category_id");
	    }
	}


	if(isset($addArray) && count($addArray) > 0){
		$result = $loyalty->authCatgory($addArray);
	}


endif;

 endforeach;
 
     if($result['error']==false)
		$return = array('success'=>1, 'message'=>'File successfully processed');
	 else 
		$return = array('success'=>0, 'message'=>$result['error']);
	
 
        $api->setResponse($return, 200);
 
        } // end of csv check if
        
    }  // end of error if

} // end of main function


*/



if(isset($_GET['controller']) && $_GET['controller']=='importLoyaltyAuthorisation'){
    
    /*
       [0] => mobile
       [1] => userType
       [2] => name
       [3] => state
       [4] => city
       [5] => dealerCode
       [6] => categoryIds
       [7] => group_company_id
   
       
   */
          
       // check there are no errors
       if($_FILES['authorisationFile']['error'] == 0){
           $name = $_FILES['authorisationFile']['name'];
           $ext = strtolower(end(explode('.', $_FILES['authorisationFile']['name'])));
           $type = $_FILES['authorisationFile']['type'];
           $tmpName = $_FILES['authorisationFile']['tmp_name'];
       
            // check the file is a csv
           if($ext === 'csv'){
               $csvAsArray = array_map('str_getcsv', file($tmpName));
                //echo "<pre>";print_r($csvAsArray); die;
               
    foreach($csvAsArray as $key => $sheetData):
   
        // avoid 1 st row of csv
        if( $key==0 )
               continue;
       
   
       $mobile     = $sheetData[0];
       $userType   = $sheetData[1];
       $userName   = $sheetData[2];
       $state      = $sheetData[3];
       $city       = $sheetData[4];  
       $dealerCode = $sheetData[5];
       $categoryIds = $sheetData[6];
       $company_group_id = $sheetData[7];
       $market = $sheetData[8];
    //   $sub_group_id = $sheetData[8];
       
       
   if($mobile):
       
       $loyalty->authCatgoryMobileDelete($mobile);
       $isUser = $loyalty->isUser($mobile);
       
       $userData = $api->callLamiService('/user/name', array('mobile'=>$mobile));
       
       /*
       if(is_array($userData['data']) && count($userData['data'])>0)
       {
               $userName = $userData['data']['name'];
       }       
       */
       
       if(!$isUser){
           $userData['userType'] = $userType;
           $userData['name'] =  $userName;
           $userData['mobile'] = $mobile;
           $userData['state'] = $state;
           $userData['city'] = $city;
           $userData['dealerCode'] = $dealerCode;
           $userData['company_group_id'] = $company_group_id;		   
           $userData['market'] = $market;

           $userId = $loyalty->newaddUser($userData);
       } else {
           $userId = $isUser;
           $updateData['name'] =    $userName;
           $updateData['state'] = $state;
           $updateData['city'] = $city;
           $updateData['user_role_id'] = $userType;
           $updateData['dealerCode'] = $dealerCode;
           $updateData['company_group_id'] = $company_group_id;		   
           $updateData['market'] = $market;
	
           $loyalty->updateUserStateCityName($userId, $updateData);
       }
   
       // authorise category ids
       $dataSet = explode(",",$categoryIds);
   
       foreach ($dataSet as $categoryId) {
        if(!empty($userId) && !empty($categoryId))
           {
               $category_id = $categoryId;
               $addArray[] = array('user_id' => $userId,'mobile' => $mobile,'category_id' => $category_id);
               $loyalty->_query("DELETE FROM user_deauthrise_category WHERE user_id=$userId AND category_id=$category_id");
           }
       }
   
   
       if(isset($addArray) && count($addArray) > 0){
           $result = $loyalty->authCatgory($addArray);
       }
   
   
   endif;
   
    endforeach;
    
        if($result['error']==false)
           $return = array('success'=>1, 'message'=>'File successfully processed');
        else 
           $return = array('success'=>0, 'message'=>$result['error']);
       
    
           $api->setResponse($return, 200);
           
            sleep(2);

		   header("Location: ".$_SERVER['HTTP_REFERER']); 
           die;
           
           } // end of csv check if
           
       }  // end of error if
   
   } // end of main function


if(isset($_GET['controller']) && $_GET['controller']=='loyaltyDeauthorisation'){

	$post = $api->jsonBody();
    $mobile = $post['mobile'];
    
if($mobile):

	$loyalty->deauthCatgoryMobileDelete($mobile);
	$isUser = $loyalty->isUser($mobile);
	if(!$isUser){
		$userData['userType'] = $post['userType'];
		$userData['name'] = $post['name'];
		$userData['mobile'] = $post['mobile'];
		$userData['state'] = $post['state'];
		$userData['city'] = $post['city'];
		$userData['userType'] = $post['userType'];
		$userId = $loyalty->addUser($userData);
	} else {
		$userId = $isUser;
		$updateData['name'] = $post['name'];
		$updateData['state'] = $post['state'];
		$updateData['city'] = $post['city'];
		$updateData['user_role_id'] = $post['userType'];
		$loyalty->updateUserStateCityName($userId, $updateData);
	}

	$dataSet = $post['data'];
	foreach ($dataSet as $value) {
		$category_id = $value['id'];
		$addArray[] = array(
			'user_id' => $userId,
			'mobile' => $post['mobile'],
			'category_id' => $category_id,
		);
		$loyalty->_query("DELETE FROM user_authrise_category WHERE user_id=$userId AND category_id=$category_id");
	}

	if(isset($addArray) && count($addArray) > 0){
		$result = $loyalty->deauthCatgory($addArray);
	}

	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Successfully deauthorized');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}
	
	
else:
        
        $result['error'] = "Please enter the mobile number !";
		$return = array('success'=>0, 'message'=>$result['error']);
	
    
endif;

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='loyaltyOpenForAll'){

	$post = $api->jsonBody();
	$categoryId = $post['categoryId'];
	$result = $loyalty->markOpenForAll($categoryId);
	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Successfully Updated.');
	} else {
		$return = array('success'=>0, 'message'=>'Unable to update');
	}
 
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='exportLoyaltyAuthUsers'){

	$post = $api->jsonBody();
	$categoryId = $post['categoryId'];
	$userData = $loyalty->authCatgoryMobile($categoryId);
	if($userData){

		// $roleName[2] = 'Main Distributor';
		// $roleName[3] = 'Distributor';
  //   $roleName[4] = 'Retailer';
  //   $roleName[5] = 'Customer';
  //   $roleName[6] = 'Mechanic';
  //   $roleName[7] = 'EOW';
  //   $roleName[8] = 'Sales Staff';

  //   $i=0;
  //   foreach ($userData as $value) {
  //   	$userData[$i]['roleName'] = $roleName[$value['roleName']];
  //   	$i++;
  //   }

		$return = array('success'=>1, 'data'=>$userData);
	} else {
		$return = array('success'=>0, 'message'=>'No user fond.');
	}

	$api->setResponse($return, 200);
}


/* old exportLoyaltyDeauthUsers

if(isset($_GET['controller']) && $_GET['controller']=='exportLoyaltyDeauthUsers'){

	$post = $api->jsonBody();
	$categoryId = $post['categoryId'];
	$userData = $loyalty->deauthCatgoryMobile($categoryId);
	if($userData){

		// $roleName[2] = 'Main';
		// $roleName[3] = 'Distributor';
  //   $roleName[4] = 'Retailer';
  //   $roleName[5] = 'Customer';
  //   $roleName[6] = 'Mechanic';
  //   $roleName[7] = 'EOW';
  //   $roleName[8] = 'Sales Staff';

  //   $i=0;
  //   foreach ($userData as $value) {
  //   	$userData[$i]['roleName'] = $roleName[$value['roleName']];
  //   	$i++;
  //   }

		$return = array('success'=>1, 'data'=>$userData);
	} else {
		$return = array('success'=>0, 'message'=>'No user fond.');
	}

	$api->setResponse($return, 200);
}


*/

 /*
if(isset($_GET['controller']) && $_GET['controller']=='importLoyaltyAuthorisation'){
    
   
    //  [0] => mobile
    //  [1] => userType
    //   [2] => name
    //   [3] => state
    //   [4] => city
    //   [5] => dealerCode
    //   [6] => categoryIds
    //   [7] => group_id
    //   [8] => sub_group_id
   
       
   
          
       // check there are no errors
       if($_FILES['authorisationFile']['error'] == 0){
           $name = $_FILES['authorisationFile']['name'];
           $ext = strtolower(end(explode('.', $_FILES['authorisationFile']['name'])));
           $type = $_FILES['authorisationFile']['type'];
           $tmpName = $_FILES['authorisationFile']['tmp_name'];
       
            // check the file is a csv
           if($ext === 'csv'){
               $csvAsArray = array_map('str_getcsv', file($tmpName));
               // echo "<pre>";print_r($csvAsArray); die;
               
    foreach($csvAsArray as $key => $sheetData):
   
        // avoid 1 st row of csv
        if( $key==0 )
               continue;
       
   
       $mobile     = $sheetData[0];
       $userType   = $sheetData[1];
       $userName   = $sheetData[2];
       $state      = $sheetData[3];
       $city       = $sheetData[4];  
       $dealerCode = $sheetData[5];
       $categoryIds = $sheetData[6];
       $group_id = $sheetData[7];
       $sub_group_id = $sheetData[8];
       
       
   if($mobile):
       
       $loyalty->authCatgoryMobileDelete($mobile);
       $isUser = $loyalty->isUser($mobile);
       
       $userData = $api->callLamiService('/user/name', array('mobile'=>$mobile));
       
       if(is_array($userData['data']) && count($userData['data'])>0)
               $userName = $userData['data']['name'];
               
       if(!$isUser){
           $userData['userType'] = $userType;
           $userData['name'] =  $userName;
           $userData['mobile'] = $mobile;
           $userData['state'] = $state;
           $userData['city'] = $city;
           $userData['dealerCode'] = $dealerCode;
           $userData['group_id'] = $group_id;
           $userData['sub_group_id'] = $sub_group_id;
           $userId = $loyalty->addUser($userData);
       } else {
       
           $userId = $isUser;
           $updateData['name'] =    $userName;
           $updateData['state'] = $state;
           $updateData['city'] = $city;
           $updateData['user_role_id'] = $userType;
           $updateData['dealerCode'] = $dealerCode;
           $userData['group_id'] = $group_id;
           $userData['sub_group_id'] = $sub_group_id;
   
           $loyalty->updateUserStateCityName($userId, $updateData);
       }
   
       // authorise category ids
       $dataSet = explode(",",$categoryIds);
   
       foreach ($dataSet as $categoryId) {
        if(!empty($userId) && !empty($categoryId))
           {
               $category_id = $categoryId;
               $addArray[] = array('user_id' => $userId,'mobile' => $mobile,'category_id' => $category_id);
               $loyalty->_query("DELETE FROM user_deauthrise_category WHERE user_id=$userId AND category_id=$category_id");
           }
       }
   
   
       if(isset($addArray) && count($addArray) > 0){
           $result = $loyalty->authCatgory($addArray);
       }
   
   
   endif;
   
    endforeach;
    
        if($result['error']==false)
           $return = array('success'=>1, 'message'=>'File successfully processed');
        else 
           $return = array('success'=>0, 'message'=>$result['error']);
       
    
           $api->setResponse($return, 200);
    
           } // end of csv check if
           
       }  // end of error if
   
   } // end of main function


*/

if(isset($_GET['controller']) && $_GET['controller']=='importLoyaltyUsers'){

	$categoryId = $_POST['categoryId'];
	$mode = $_POST['mode'];


	$upload = new uplode();

	$uploaddir = BASE_DIR.'/uploads/import/file/';
	$return = $upload->uplodeExcel($_FILES['file'], $uploaddir);
	
	
	$filename = $_FILES['file']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

	if($ext != "xls"):
	   	$return = array('success'=>0, 'message'=>"Unable to upload sheet. Please use .xls file only.");
	    $api->setResponse($return, 200);
	    exit();
	endif;
	
	

	if($return['success']==1){

		$target = $uploaddir.basename($return['uploaded_name']);

		require_once BASE_DIR.'/application/lib/Excel/reader.php';
		$data = new Spreadsheet_Excel_Reader();
		$data->read($target);

		$dataSet = $data->sheets[0]['cells'];
		if(is_array($dataSet) && count($dataSet) > 1){

			$i=0;
			foreach ($dataSet as $cell) {

				if($i > 0){

					$mobileNo = $cell[1];

					if($mode==2){
						$loyalty->delDeauthCat($mobileNo, $categoryId);
					} else {
						$loyalty->delAuthCat($mobileNo, $categoryId);
					}

					$addArray[] = array(
						'user_id' => 0,
						'mobile' => $mobileNo,
						'category_id' => $categoryId
					);

				}

				$i++;
			}

			if($mode==2){
				$result = $loyalty->authCatgory($addArray);
				
			} else {
				$result = $loyalty->deauthCatgory($addArray);
			}

			if($result['error']==false){
				$return = array('success'=>1, 'message'=>'Data successfully import');
			} else {
				$return = array('success'=>0, 'message'=>$result['error']);
			}

		} else {
			$return = array('success'=>0, 'message'=>"Data not found in sheet.");
		}

	} else {
		$return = array('success'=>0, 'message'=>"Unable to upload sheet.");
	}

	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='authorisationlist'){

	$post = $api->jsonBody();
	$result = $loyalty->authorisationlist($post);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='authodelete'){

	$post = $api->jsonBody();
	$id = $post['id'];

	$result = $loyalty->authorisationDeleteRecord($id);
	
	if($result['error']==false){
			$return = array('success'=>1, 'message'=>'Success');
		} else {
			$return = array('success'=>0, 'message'=>$result['error']);
		}

	$api->setResponse($return, 200);
}




if(isset($_GET['controller']) && $_GET['controller']=='deauthorisationlist'){

	$post = $api->jsonBody();
	$result = $loyalty->deauthorisationlist($post);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='deauthodelete'){

	$post = $api->jsonBody();
	$id = $post['id'];

	$result = $loyalty->deauthorisationDeleteRecord($id);
	
	if($result['error']==false){
			$return = array('success'=>1, 'message'=>'Success');
		} else {
			$return = array('success'=>0, 'message'=>$result['error']);
		}

	$api->setResponse($return, 200);
}

# groups and subgroups starts
if(isset($_GET['controller']) && $_GET['controller']=='groupList'){
	$post = $api->jsonBody();
	$result = $loyalty->getGroupList();
	if($result['error']==false){
			$return = array('success'=>1, 'data'=>$result);
		} else {
			$return = array('success'=>0, 'message'=>$result['error']);
		}
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='subGroupList'){
	$post = $api->jsonBody();
	$result = $loyalty->getSubGroupList();
	if($result['error']==false){
			$return = array('success'=>1, 'data'=>$result);
		} else {
			$return = array('success'=>0, 'message'=>$result['error']);
		}
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='groupCompanyList'){
	$post = $api->jsonBody();
	$result = $loyalty->getGroupCompnayList();
	if($result['error']==false){
			$return = array('success'=>1, 'data'=>$result);
		} else {
			$return = array('success'=>0, 'message'=>$result['error']);
		}
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='saveGroup'){
	$post = $api->jsonBody();
	$result = $loyalty->saveGroupData($post);
	if($result['error']==false){
			$return = array('success'=>1, 'data'=>$result);
		} else {
			$return = array('success'=>0, 'message'=>$result['error']);
		}
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='saveSubGroup'){
	$post = $api->jsonBody();
	$result = $loyalty->saveSubGroupData($post);
	if($result['error']==false){
			$return = array('success'=>1, 'data'=>$result);
		} else {
			$return = array('success'=>0, 'message'=>$result['error']);
		}
	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='saveGroupCompanyData'){
	$post = $api->jsonBody();
	$result = $loyalty->saveGroupCompanyData($post);
	if($result['error']==false){
			$return = array('success'=>1, 'data'=>$result);
		} else {
			$return = array('success'=>0, 'message'=>$result['error']);
		}
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='editGroup'){

	$post = $api->jsonBody();
	$id = $post['id'];
	
	$postArray = array(
	//	'parent_id'=>$post['parent'],
		'name'=>$post['name'],
		'erp_id'=>'NA'
	);

//	echo "<pre>";print_r($postArray); die;
	$result = $loyalty->updategroupsData($id, $postArray);
	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Main group successfully updated.');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);

}


if(isset($_GET['controller']) && $_GET['controller']=='subGroupAdd'){

	$post = $api->jsonBody();
	$dataSet = $post['data'];
	foreach ($dataSet as $value) {
		$postArray[] = array(
			'group_id'=>$value['group'],
			'name'=>$value['name'],
			'erp_id'=>'NA'
		);
	}

// echo "<pre>"; print_r($postArray); die;
	$result = $loyalty->addSubgroup($postArray);
	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Sub group successfully added.');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);

}

if(isset($_GET['controller']) && $_GET['controller']=='editSubGroup'){

	$post = $api->jsonBody();
	$id = $post['id'];
	
	$postArray = array(
		'group_id'=>$post['group'],
		'name'=>$post['name'],
		'erp_id'=>'NA'
	);

	$result = $loyalty->updatesubgroupsData($id, $postArray);
	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Sub Group successfully updated.');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);

}


if(isset($_GET['controller']) && $_GET['controller']=='groupCompanyAdd'){

	$post = $api->jsonBody();
	$dataSet = $post['data'];
	foreach ($dataSet as $value) {
		$postArray[] = array(
			'group_id'=>$value['group'],
			'sub_group_id'=>$value['subgroup'],
			'name'=>$value['name'],
			'erp_id'=>$value['erpId']
		);
	}

//  echo "<pre>"; print_r($postArray); die;
	$result = $loyalty->addgroupCompany($postArray);
	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Group successfully added.');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);

}

if(isset($_GET['controller']) && $_GET['controller']=='editGroupCompany'){

	$post = $api->jsonBody();
	$id = $post['id'];
	
	$postArray = array(
		'group_id'=>$post['group'],
		'sub_group_id'=>$post['subgroup'],
		'name'=>$post['name'],
		'erp_id'=>$post['erpid']
	);
//  echo "<pre>"; print_r($postArray); die;
	$result = $loyalty->updategroupCompanyData($id, $postArray);
	if($result['error']==false){
		$return = array('success'=>1, 'message'=>'Group successfully updated.');
	} else {
		$return = array('success'=>0, 'message'=>$result['error']);
	}

	$api->setResponse($return, 200);

}


