<?php

class printPageSpace extends dbclass {
	

	public function detail($id){
		$query = "SELECT * FROM  print_page_spacing WHERE id=$id";
		return $this->fetchRow($query);
	}
	
	public function update($id, $data){
		return $this->_update('print_page_spacing', $data, array('id'=>$id));
	}


	public function getList($filter){
		$query = "SELECT * FROM  print_page_spacing WHERE id=1"; 
		return $this->fetchResult($query);
	}

	
} // END USER CLASS


