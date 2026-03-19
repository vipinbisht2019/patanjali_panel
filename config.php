<?php
error_reporting(E_ERROR | E_PARSE | E_WARNING);
session_start();
ob_start();

//ini_set("upload_max_filesize","50M");

# DATABASE Details
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'patanjali_db');


# URL
define('APP_URL', 'http://localhost/patanjali_panel');
define('APP_PATH', '/patanjali_panel/');

# API
define('API_URL', 'http://localhost/patanjali_panel/api');



define('ASSETS_PATH', APP_PATH.'assets');
define('VIEW_PATH', APP_PATH.'views');


# DIR
define('BASE_DIR', dirname(__FILE__) );
define('VIEW_DIR', BASE_DIR.'/views' );
define('LIB_DIR', BASE_DIR.'/application/lib');
define('CLASS_DIR', BASE_DIR.'/application/lib/core');

date_default_timezone_set('Asia/Calcutta');


function getPlantPermission(){
    
    $platPermission = "";
    
    if($_SESSION['ADMIN_USER']['ACCESS'])
    {
        $permission = $_SESSION['ADMIN_USER']['ACCESS'];
        
        if($permission->plant){
           
            foreach($permission->plant as $plantId=>$value):
                
                if($plantId == 'addnlist')
                    continue;
                    
               $platPermission .= $plantId.",";
               
            endforeach;
            
            $platPermission = rtrim($platPermission,",");
            
        }
    }
    return  $platPermission;
}

function getDivisionPermission(){
    
    $divisionPermission = "";
    
    if($_SESSION['ADMIN_USER']['ACCESS'])
    {
        $permission = $_SESSION['ADMIN_USER']['ACCESS'];
        
        if($permission->division){
           
            foreach($permission->division as $divisionId=>$value):
                
                if($divisionId == 'adddivision')
                    continue;
                    
               $divisionPermission .= $divisionId.",";
               
            endforeach;
            
            $divisionPermission = rtrim($divisionPermission,",");
            
        }
    }
    return  $divisionPermission;
}

$ct = array(
    "2"=>"Main Distributor",
    "3"=>"Distributor",
    "4"=>"Retailer",
    "5"=>"Customer",
    "8"=>"Paras Team",
    "9"=>"Tech Team",
    "10"=>"Other",
    "11"=>"Auth Retailer",
    "12"=>"Deactivated",
    "13"=>"W/S",
    "14"=>"UAR"
    );
    

	   
