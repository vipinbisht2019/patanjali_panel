<?php

class Base {
	
	static function validateSession(){ 
		
	    
		if( !empty($_SESSION['ADMIN_USER']['ID']) && $_SESSION['ADMIN_USER']['logged_domain']=='test_paras'){
			return true;
		} 
		else 
		{
			header('location:'.APP_URL.'/logout');
			exit(0);
		}
	}

	
} // END CLASS


