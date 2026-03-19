<?php

class dispatchVendorList extends dbclass {
	

	public function detail($id){
		$query = "SELECT * FROM gift_dispatch_vendor_list WHERE id=$id";
		return $this->fetchRow($query);
	}
	
	public function add($data){
		return $this->_insert('gift_dispatch_vendor_list', $data);
	}
	
	public function update($id, $data){
		return $this->_update('gift_dispatch_vendor_list', $data, array('id'=>$id));
	}

	public function delete($id){
		$query="DELETE FROM gift_dispatch_vendor_list WHERE id=$id";
		return $this->_query($query);
	}

	public function getList($filter){
		$query = "SELECT * FROM  gift_dispatch_vendor_list";
		return $this->fetchResult($query);
	}

	
} // END USER CLASS


