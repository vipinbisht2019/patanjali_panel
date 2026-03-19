<?php

class setting extends dbclass {
	
	public function __construct() {
		parent::__construct();
	}

	public function updateSettingMeta($metaKey, $metaValue){
	    
	//	$data = array('meta_value'=>$metaValue);
	//	return $this->_update('setting_meta', $data, array('meta_key'=>$metaKey));
		
		
		$data = array('meta_value'=>$metaValue);
		$datas = array('meta_key'=>$metaKey,'meta_value'=>$metaValue);

		if($metaKey == 'ADMIN_SCAN_NUMBER')
		{

			$query = "SELECT meta_key,meta_value FROM setting_meta WHERE meta_key='$metaKey' and  meta_value = '$metaValue'";
//			die;
		//	$data = $this->fetchRow($query);
			if( $this->_numRows($query) > 0 )
			{ 		

				return true;
								
			} else 
			{				
				return $this->_insert('setting_meta', $datas);

			}

		}
		else
		{
		return $this->_update('setting_meta', $data, array('meta_key'=>$metaKey));
		}

		
	}

	public function getSettingMeta($metaKey){
		$query = "SELECT meta_value FROM setting_meta WHERE meta_key='$metaKey'";
		$data = $this->fetchRow($query);
		if($data){
			return $data['meta_value'];
		} else {
			return '';
		}
	}
	public function getbonusPercent(){
		$query="SELECT bounus_percent FROM coupon_bonus_settings"; 
		$data = $this->fetchRow($query);
		return ($data) ? $data['bounus_percent'] : false;
	}
	public function updateBonusPercent($percent){
		$data['bounus_percent'] = $percent;
	return $this->_update('coupon_bonus_settings', $data);
	}
	public function getSettingMeta_all($metaKey){
		$query = "SELECT meta_value FROM setting_meta where meta_key ='$metaKey'";
		$data = $this->fetchResult($query);
		
		$admin_numb = array();

		foreach($data as $rows)
		{
			$newdata = $rows['meta_value'];
			
			array_push($admin_numb,$newdata);	
		}
		
		 $allDataNumbers = implode(", ",$admin_numb);
		
		if($allDataNumbers){
			return $allDataNumbers;
		} else {
			return '';
		}
	}

	public function getSettingMeta_all_delete($meta_value){
		$query="DELETE FROM setting_meta where meta_value=$meta_value"; 
		return $this->_query($query);
	}

		
} // END CLASS