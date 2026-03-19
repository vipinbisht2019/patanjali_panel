<?php 

require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/users.php';
require_once CLASS_DIR.'/plant.php';
require_once CLASS_DIR.'/uploads.php';
require_once CLASS_DIR.'/api.php';

$user = new users();

$api = new api();
$plant = new plant();


if(isset($_GET['controller']) && $_GET['controller']=='getAssignedCategory'){

	$post = $api->jsonBody();
	$result = $plant->getMainCategoryById($post['catIds']);
	
	if(count($result) > 0 ){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='getPlantsMainCategory'){

	$post = $api->jsonBody();
	$result = $plant->getPlantsMainCategory($post['plantId']);
	
	if(is_array($result) && count($result) > 0 ){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='getPlantList'){

	$post = $api->jsonBody();
	$result = $plant->getPlantList($post);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='getCountryList'){

	$post = $api->jsonBody();
	$result = $plant->getCountryList($post);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='getStateList'){

	$post = $api->jsonBody();
	$result = $plant->getStateList($post['countryId']);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='getCityList'){

	$post = $api->jsonBody();
	$result = $plant->getCityList($post['stateId']);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='getDivisionByPlant'){

	$post = $api->jsonBody();
	$result = $plant->getDivisionByPlant($post['plantId']);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}

//  start catgory 24_feb_2023  

if(isset($_GET['controller']) && $_GET['controller']=='getDivisionByPlantCategory'){

	$post = $api->jsonBody();
	$result = $plant->getDivisionByPlantCategory($post['plantId']);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}

// end catgory 24_feb_2023 


if(isset($_GET['controller']) && $_GET['controller']=='plantlist'){

	$post = $api->jsonBody();
	$result = $plant->plantListWithAddress($post);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='divisionlist'){

	$post = $api->jsonBody();
	$result = $plant->getDivisionList($post);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}




if(isset($_GET['controller']) && $_GET['controller']=='deletePlant'){

	$post = $api->jsonBody();
 	$id = $post['plant_id'];

	$result = $plant->deletePlant($id);
	
	if($result['error']==false){
			$return = array('success'=>1, 'message'=>'Success');
		} else {
			$return = array('success'=>0, 'message'=>$result['error']);
		}

	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='divisionDelete'){

	$post = $api->jsonBody();
 	$id = $post['unit_id'];

	$result = $plant->divisionDelete($id);
	
	if($result['error']==false){
			$return = array('success'=>1, 'message'=>'Success');
		} else {
			$return = array('success'=>0, 'message'=>$result['error']);
		}

	$api->setResponse($return, 200);
}



if(isset($_GET['controller']) && $_GET['controller']=='addPlant'){

	$post = $api->jsonBody();
	$assignCategory = "";

	if(count($post['mainCategory']) > 0  && is_array($post['mainCategory']))
	    	$assignCategory = implode(",",$post['mainCategory']);
	    
	$plantData = array(
	    'plant_name'=>$post['inptPlantName'],
	    'plant_code'=>$post['inptPlantCode'],
	    'country_id'=>$post['inptPlantCountry'],
	    'state_id'=>$post['inptPlantState'],
	    'city_id'=>$post['inptPlantCity'],
	    'assignedCatIds'=>$assignCategory,
	    'is_ag_mark'=>$post['inptIsAgMark'],
	    );
	    
	
	$result = $plant->addPlant($plantData);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}

// editPlan 

if(isset($_GET['controller']) && $_GET['controller']=='editPlant'){

	$post = $api->jsonBody();
	$assignCategory = "";

	if(count($post['mainCategory']) > 0  && is_array($post['mainCategory']))
	    	$assignCategory = implode(",",$post['mainCategory']);
	    
	$id = $post['id'];    
	$plantData = array(
	    'plant_name'=>$post['inptPlantName'],
	    'plant_code'=>$post['inptPlantCode'],
	    'country_id'=>$post['inptPlantCountry'],
	    'state_id'=>$post['inptPlantState'],
	    'city_id'=>$post['inptPlantCity'],
	    'assignedCatIds'=>$assignCategory,
	    'is_ag_mark'=>$post['isagmark'],
	    );
	    
	
	$result = $plant->editPlant($plantData,$id);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}

//editPlan

if(isset($_GET['controller']) && $_GET['controller']=='addDivision'){

	$post = $api->jsonBody();
	
	$divisionData = array(
	    'plant_id'=>$post['plantId'],
	    'unit_name'=>$post['inptDivisionName'],
	    'unit_code'=>$post['inptDivisionCode']
	    );
	
	$result = $plant->addDivision($divisionData);

	if($result){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	
	$api->setResponse($return, 200);
}