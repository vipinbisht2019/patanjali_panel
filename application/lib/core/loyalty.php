<?php

class loyalty extends dbclass {

	public function getUserInfo($mobile){
		$query = "
		SELECT id, name, mobile, state, city, user_role_id as userType,dealerCode 
		FROM users 
		WHERE mobile='$mobile' and user_role_id > 1 
		ORDER BY id DESC LIMIT 1";
		return $this->fetchRow($query);
	}

	public function isUser($mobile){
		$query = "SELECT id FROM users WHERE mobile='$mobile' and user_role_id > 1 ORDER BY id DESC LIMIT 1";
		$data = $this->fetchRow($query);
		return ($data) ? $data['id'] : false;
	}

	public function getUsers(){
		$query = "SELECT id as userId FROM users WHERE user_role_id > 1 ORDER BY id ASC";
		return $this->fetchResult($query);
	}


	public function newaddUser($userData){

		$inserData = array(
			'name'=>$userData['name'],
			'mobile'=>$userData['mobile'],
			'email'=>'',
			'username'=>'',
			'password'=>'',
			'user_role_id'=>$userData['userType'],
			'state_code'=>0,
			'city_town_id'=>0,
			'state'=>$userData['state'],
			'city'=>$userData['city'],
			'status'=>1,
			'is_trash'=>0,
			'created'=>time(),
			'dealerCode'=>$userData['dealerCode'],
			'company_group_id'=>$userData['company_group_id'],
			'market'=>$userData['market']
		);

		$return = $this->_insert('users', $inserData);
		if($return['error']==false){
			return $return['insert_id'];
		} else {
			return false;
		}
	}

	public function addUser($userData){

		$inserData = array(
			'name'=>$userData['name'],
			'mobile'=>$userData['mobile'],
			'email'=>'',
			'username'=>'',
			'password'=>'',
			'user_role_id'=>$userData['userType'],
			'state_code'=>0,
			'city_town_id'=>0,
			'state'=>$userData['state'],
			'city'=>$userData['city'],
			'status'=>1,
			'is_trash'=>0,
			'created'=>time(),
			'dealerCode'=>$userData['dealerCode'],
			'company_group_id'=>$userData['company_group_id']
		);

		$return = $this->_insert('users', $inserData);
		if($return['error']==false){
			return $return['insert_id'];
		} else {
			return false;
		}
	}

	public function updateUserStateCityName($userId, $updateData){
		$return = $this->_update('users', $updateData, array('id'=>$userId));
		if($return['error']==false){
			return $return['insert_id'];
		} else {
			return false;
		}
	}

	//addMobileUser
	public function addMobileUser($mobile){

		$inserData = array(
			'name'=>'',
			'mobile'=>$mobile,
			'email'=>'',
			'username'=>'',
			'password'=>'',
			'user_role_id'=>4,
			'state_code'=>0,
			'city_town_id'=>0,
			'state_code'=>0,
			'city_town_id'=>0,
			'state'=>'',
			'city'=>'',
			'status'=>1,
			'is_trash'=>0,
			'created'=>time()
		);

		$return = $this->_insert('users', $inserData);
		if($return['error']==false){
			return $return['insert_id'];
		} else {
			return false;
		}
	}

	public function markOpenForAll($categoryId){
		return $this->_update('product_category', array('is_ofa'=>1), array('id'=>$categoryId));
	}
	
	public function markLimitedForAll($categoryId){
		return $this->_update('product_category', array('is_ofa'=>0), array('id'=>$categoryId));
	}

	public function authCatgory($data){
		return $this->_insertArray('user_authrise_category', $data);
	}

	public function deauthCatgory($data){
		return $this->_insertArray('user_deauthrise_category', $data);
	}

	public function delAuthCat($mobile, $categoryId){
		$query="DELETE FROM user_authrise_category WHERE mobile='$mobile' AND category_id=$categoryId";
		return $this->_query($query);
	}

	public function delDeauthCat($mobile, $categoryId){
		$query="DELETE FROM user_deauthrise_category WHERE mobile='$mobile' AND category_id=$categoryId";
		return $this->_query($query);
	}

	public function authCatgoryMobileDelete($mobile){
		$query="DELETE FROM user_authrise_category WHERE mobile='$mobile'";
		return $this->_query($query);
	}

	public function deauthCatgoryMobileDelete($mobile){
		$query="DELETE FROM user_deauthrise_category WHERE mobile='$mobile'";
		return $this->_query($query);
	}

	public function authCatgoryDelete($userId){
		$query="DELETE FROM user_authrise_category WHERE user_id=$userId";
		return $this->_query($query);
	}

	public function deauthCatgoryDelete($userId){
		$query="DELETE FROM user_deauthrise_category WHERE user_id=$userId";
		return $this->_query($query);
	}

	public function clearAuthCatgory($categoryId){
		$query="DELETE FROM user_authrise_category WHERE category_id=$categoryId";
		return $this->_query($query);
	}

	public function clearDeauthCatgory($categoryId){
		$query="DELETE FROM user_deauthrise_category WHERE category_id=$categoryId";
		return $this->_query($query);
	}

	public function authCatgoryUsers($categoryId){
		$query="
			SELECT
				name, 
				mobile, 
				(SELECT city_town_name FROM state_city_town WHERE id=u.city_town_id) as city,
				(SELECT state FROM state_city_town WHERE state_code=u.state_code ORDER BY id ASC LIMIT 1) as state,
				user_role_id as roleName
			FROM user_authrise_category c, users u
			WHERE u.id=c.user_id AND c.category_id=$categoryId;
		";
		return $this->fetchResult($query);
	}

	public function deauthCatgoryUsers($categoryId){
		$query="
			SELECT
				name, 
				mobile, 
				(SELECT city_town_name FROM state_city_town WHERE id=u.city_town_id) as city,
				(SELECT state FROM state_city_town WHERE state_code=u.state_code ORDER BY id ASC LIMIT 1) as state,
				user_role_id as roleName
			FROM user_deauthrise_category c, users u
			WHERE u.id=c.user_id AND c.category_id=$categoryId;
		";
		return $this->fetchResult($query);
	}


	public function authCatgoryMobile($categoryId){
		$query="SELECT mobile FROM user_authrise_category WHERE category_id=$categoryId";
		return $this->fetchResult($query);
	}

	public function deauthCatgoryMobile($categoryId){
		$query="SELECT mobile FROM user_deauthrise_category WHERE category_id=$categoryId";
		return $this->fetchResult($query);
	}

	public function getAuthGroupCat($mobile){
		$query="SELECT category_id FROM user_authrise_category WHERE mobile='$mobile'";
		return $this->fetchResult($query);
	}

	public function getDeauthGroupCat($mobile){
		$query="SELECT category_id FROM user_deauthrise_category WHERE mobile='$mobile'";
		return $this->fetchResult($query);
	}
	

 public function authorisationlist($post){
     
        $no_of_records_per_page = $post['limit'];
        $pageno = isset($post['page']) ? $post['page'] : 1;
        $offset = ($pageno-1) * $no_of_records_per_page;
       
		$query="SELECT uac.id,pc.category_name,uac.mobile,pc.is_ofa FROM user_authrise_category uac JOIN product_category pc ON pc.id=uac.category_id";
	
           	
         if(isset($post['mobile']) && $post['mobile'] !="")
           //	$query .= " WHERE uac.mobile=".$post['mobile'];
		   {
		$query .= ' WHERE uac.mobile = "'.$post["mobile"].'"';
           	}
           	
        $query .= " ORDER BY uac.id DESC LIMIT $offset, $no_of_records_per_page";
           
           	//echo   $query; die;
           	
		return $this->fetchResult($query);
	}
	
   public function authorisationDeleteRecord($id){
		$query="delete FROM user_authrise_category where id=$id"; 
		return $this->_query($query);
	}
	
	public function deauthorisationlist($post){
		$query="SELECT udc.id,pc.category_name,udc.mobile,pc.is_ofa FROM user_deauthrise_category udc JOIN product_category pc ON pc.id=udc.category_id";
		
        if(isset($post['mobile']) && $post['mobile'] !="")
           //	$query .= " WHERE udc.mobile=".$post['mobile'];
		   {
		$query .= ' WHERE udc.mobile = "'.$post["mobile"].'"';
           	}
           	
		return $this->fetchResult($query);
	}
	
    public function deauthorisationDeleteRecord($id){
		$query="delete FROM user_deauthrise_category where id=$id"; 
		return $this->_query($query);
	}
	
	public function extractGroups($csv_data){
	     echo "<pre>";print_r($csv_data); die;
    // 		$query="DELETE FROM user_deauthrise_category WHERE category_id=$categoryId";
    // 		return $this->_query($query);
	}

    public function getGroupList(){
        $query = "SELECT * FROM `groups`";
        return $this->fetchResult($query);
    }

    public function getSubGroupList(){
        $query = "SELECT
                    g.id AS group_id,
                    g.name AS group_name,
                    sg.id AS sub_group_id,
                    sg.name AS sub_group_name
                FROM
                    `sub_groups` AS sg
                INNER JOIN `groups` AS g
                ON
                    g.id = sg.group_id";
        return $this->fetchResult($query);
    }

// change group_company_name instead of group_name_name
    
    public function getGroupCompnayList(){
        $query = "SELECT
                    g.id AS group_id,
                    g.name AS group_name,
                    sg.id AS sub_group_id,
                    sg.name AS sub_group_name,
                    gc.name AS group_company_name,
                    gc.erp_id AS erp_id,
					gc.id AS id
                FROM
                    `group_company` AS gc
                LEFT JOIN `sub_groups` AS sg
                ON
                    sg.id = gc.sub_group_id
                LEFT JOIN `groups` AS g
                ON
                    g.id = gc.group_id";
        return $this->fetchResult($query);
    }
    
    public function saveGroupData($postData){
        $insertData = [];
        $insertData['name'] = $postData['name'];
        $insertData['erp_id'] = $postData['erp_id'];
        $return = $this->_insert('groups', $insertData);
		if($return['error']==false){
			return $return['insert_id'];
		} else {
			return false;
		}
    }


	public function updategroupsData($userId, $updateData){
		return  $this->_update('groups', $updateData, array('id'=>$userId));
	}

	public function addSubgroup($data){
		return $this->_insertArray('sub_groups', $data);
	}


	public function updatesubgroupsData($userId, $updateData){
		return  $this->_update('sub_groups', $updateData, array('id'=>$userId));
	}

	public function addgroupCompany($data){
		return $this->_insertArray('group_company', $data);
	}

	public function updategroupCompanyData($userId, $updateData){
		return  $this->_update('group_company', $updateData, array('id'=>$userId));
	}


} // END CLASS


