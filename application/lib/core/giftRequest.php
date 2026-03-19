<?php

class giftRequest extends dbclass {
	

	public function detail($id){
		$query = "SELECT * FROM gift_request WHERE id=$id";
		return $this->fetchRow($query);
	}
	
	public function add($data){
		return $this->_insert('gift_request', $data);
	}
	
	public function update($id, $data){
		return $this->_update('gift_request', $data, array('id'=>$id));
	}

	public function delete($id){
		$query="DELETE FROM gift_request WHERE id=$id";
		return $this->_query($query);
	}

	public function getList($filter){
	  
	    
	    $query = "SELECT gr.*,u.name as userName,u.mobile as userMobile,u.user_role_id as userRoleId FROM  gift_request gr JOIN users u ON u.id=gr.userId WHERE 1";
	    
	if(!empty($filter['transactionIdFilter']))
		$query.=" AND gr.id=".$filter['transactionIdFilter'];
			
	if(!empty($filter['mobileFilter']))
		$query.=" AND u.mobile='".$filter['mobileFilter']."' ";
			
	if(!empty($filter['giftStockStatusFilter']))
		$query.=" AND gr.id='".$filter['giftStockStatusFilter']."' ";
		
	if(!empty($filter['giftRequestStatusFilter']))
	$query.=" AND gr.requestStatus='".$filter['giftRequestStatusFilter']."' ";
			 
	if(!empty($filter['giftRequestDateFilter'])):
	    $requestDate = $filter['giftRequestDateFilter'];
	    $query.=" AND gr.giftRequestDate like '$requestDate%' ";
	endif;
			
	
		 	$query.= " ORDER BY gr.id DESC";
		
		//echo 	$query; die;
		 	
		return $this->fetchResult($query);
	}
	
	public function getVendorList(){
		$query = "SELECT * FROM gift_dispatch_vendor_list WHERE status=1";
		return $this->fetchResult($query);
	}

	
} // END USER CLASS


