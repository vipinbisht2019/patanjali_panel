<?php

class plant extends dbclass {

// Plant related SQL

	public function getPlantList(){
		$query = "SELECT * FROM plant_list WHERE 1";
		
		 $plantPermission = getPlantPermission(); 
		 if($plantPermission)
		    $query.=" AND (plant_id IN ($plantPermission))";
		
		$query.=" ORDER BY plant_id ASC";
		    
		return $this->fetchResult($query);
	}
	
	public function getCountryList(){
		$query = "SELECT * FROM tbl_countries ORDER BY name ASC";
		return $this->fetchResult($query);
	}
	
	public function getStateList($countryId){
		$query = "SELECT * FROM tbl_states WHERE country_id=$countryId ORDER BY name ASC";
		return $this->fetchResult($query);
	}
	
	public function getCityList($stateId){
		$query = "SELECT * FROM tbl_cities WHERE state_id=$stateId ORDER BY name ASC";
		return $this->fetchResult($query);
	}
	
	public function plantListWithAddress($postFilter){
	    
		$query = "SELECT PL.*,TC.name as cityname,TS.name as statename, TCON.name as countryname FROM plant_list PL JOIN tbl_cities TC ON TC.id=PL.city_id JOIN tbl_states TS ON TS.id=PL.state_id JOIN tbl_countries TCON ON TCON.id=PL.country_id WHERE 1";
		
		if(!empty($postFilter['filterPlantName']))
		    	$query .= " AND PL.plant_name like '%".$postFilter['filterPlantName']."%' " ;
		    	
		if(!empty($postFilter['filterPlantCode']))
		    	$query .= " AND PL.plant_code='".$postFilter['filterPlantCode']."' " ;
		    	
		$plantPermission = getPlantPermission(); 
		if($plantPermission)
		    $query.=" AND (PL.plant_id IN ($plantPermission))";
		
		$query .= " ORDER BY PL.plant_id ASC";

		return $this->fetchResult($query);
	}
	
	public function deletePlant($id){
		$query="DELETE FROM plant_list where plant_id=$id"; 
		return $this->_query($query);
	}


	public function addPlant($plantData){
		$return = $this->_insert('plant_list', $plantData);
		if($return['error']==false){
			return $return['insert_id'];
		} else {
			return false;
		}
	}
	
	public function editPlant($plantData,$id){
	    
	    return $this->_update('plant_list', $plantData, array('plant_id'=>$id));

	/*	if($return['error']==false){
		    echo "";
			return $return['insert_id'];
		} else {
			return false;
		}
		*/
	}
	
	
	public function getMainCategoryById($catIds){
		$query="SELECT id,category_name, GROUP_CONCAT(category_name) as categoryName FROM product_category WHERE parent_id=0 AND status = 1";
		
		if($catIds)
		    $query .=" AND id IN ($catIds)";
		
		$query .=" ORDER BY category_name ASC";

		return $this->fetchRow($query);
	}
	
	public function getPlantsMainCategory($plantId){
		$query="SELECT assignedCatIds FROM plant_list WHERE plant_id=$plantId";
		$rowData = $this->fetchRow($query);
	
		if(count($rowData) > 0 && $rowData['assignedCatIds'] ){
		    $categoryIds = $rowData['assignedCatIds'];
		    $catSql="SELECT id,category_name FROM product_category WHERE parent_id=0 AND status = 1 AND id IN ($categoryIds)  ORDER BY category_name ASC"; 
		    return $this->fetchResult($catSql);
		}
		    
	}

// Division related SQL	
	
public function getDivisionList($postFilter){
    
		$query = "SELECT PD.*, PL.plant_name,PL.plant_code FROM plant_division PD JOIN plant_list PL ON PD.plant_id = PL.plant_id WHERE 1";
		
		if(!empty($postFilter['filterDivisionName']))
		    	$query .= " AND PD.unit_name like '%".$postFilter['filterDivisionName']."%' " ;
		    	
		if(!empty($postFilter['filterDivisionCode']))
		    	$query .= " AND PD.unit_code='".$postFilter['filterDivisionCode']."' " ;
		
		 $divisionPermission = getDivisionPermission(); 
		 if($divisionPermission)
		    $query.=" AND (PD.unit_id IN ($divisionPermission))";
		
		$query.=" ORDER BY PD.unit_id ASC";
		
		    
		return $this->fetchResult($query);
	}
	
public function getAllDivisionList(){
		$query = "SELECT * FROM plant_division WHERE 1";
		
		 $divisionPermission = getDivisionPermission(); 
		 
		 if($divisionPermission)
		    $query.=" AND (unit_id IN ($divisionPermission))";
		
		$query.=" ORDER BY unit_id ASC";
		    
		return $this->fetchResult($query);
	}
	
public function divisionDelete($id){
		$query="DELETE FROM plant_division where unit_id=$id"; 
		return $this->_query($query);
	}
	
public function addDivision($divisionData){
		$return = $this->_insert('plant_division', $divisionData);
		if($return['error']==false){
			return $return['insert_id'];
		} else {
			return false;
		}
	}
	
public function getDivisionByPlant($plantId){
    
		$query = "SELECT unit_id,unit_name,unit_code FROM plant_division WHERE plant_id=$plantId";
		
		$divisionPermission = getDivisionPermission(); 
		 
		 if($divisionPermission)
		    $query.=" AND (unit_id IN ($divisionPermission))";
		
		$query.=" ORDER BY unit_name ASC";
		
		return $this->fetchResult($query);
	}
	
	// start catgory 24_feb_2023  

public function getDivisionByPlantCategory($plantId){

		$query = "SELECT * FROM plant_list WHERE plant_id=$plantId";
		
		$category_data = $this->fetchResult($query);

		// echo "<pre>"; print_r($category_data); die;

	//	if(count($category_data) > 0)
	//	{
				 $cat_assign_ids = $category_data[0]['assignedCatIds'];
	
				$string_catgory = "('".str_replace(',', "','", $cat_assign_ids)."')";

				$query = "SELECT * FROM product_category WHERE id IN $string_catgory  AND parent_id = 0";
		
	//	}	
		
		return $this->fetchResult($query);
	}

// end catgory 24_feb_2023  
	

} // END CLASS


