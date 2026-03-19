<?php

class dbclass{

var $con;

private $level;
private $result;
private $query;


/*MAKE CONSTRUCTOR FOR  CONNECTION*/
public  function __construct() {
	
	$this->con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	// Check connection
	if(!$this->con){
	  die( "Database Error: " . mysqli_connect_error() );
	}    
}


public function post($k){
	global $_POST;
	return $_POST[$k];
}

public function get($k){
	global $_GET;
	return $_GET[$k];
}


public function ipAddress(){
	return $_SERVER['REMOTE_ADDR'];
}

public function fetchRow($sql) {
	if($this->result=mysqli_query($this->con,$sql)){
		return mysqli_fetch_assoc($this->result);
	} else {
		return false;
	}
}

public function fetchResult($sql) {
	$this->result=mysqli_query($this->con,$sql) or die ( mysqli_error($this->con));
	while ($row = mysqli_fetch_assoc($this->result)) {
	  $data[] = $row;
	}
	
	if(is_array($data)){
		return $data;
	} else {
		return false;
	}
}


public function _insert($table, $data, $exclude = array()) {

    $fields = $values = array();
    if( !is_array($exclude) ) $exclude = array($exclude);
    foreach( array_keys($data) as $key ) {
        if( !in_array($key, $exclude) ) {
            $fields[] = "`$key`";
			$values[] = "'" . mysqli_real_escape_string($this->con, $data[$key]) . "'";
        }
    }

    $fields = implode(",", $fields);
    $values = implode(",", $values);
	
	$sqlQuery = "INSERT INTO `$table` ($fields) VALUES ($values)";
	
	if($this->query=mysqli_query($this->con, $sqlQuery)){
		return array( 
			'error' => false,
			'insert_id'=> mysqli_insert_id($this->con),
			'affected_rows' => mysqli_affected_rows($this->con),
			'info' => mysqli_info($this->con)
		);
	} else {
		return array( 'error' => mysqli_error($this->con) );
	}	
}


public function _insertArray($table, $data, $exclude = array()) {
	
    $fields = $values = array();
    if( !is_array($exclude) ) $exclude = array($exclude);
	
    foreach( array_keys($data[0]) as $key ) {
        if( !in_array($key, $exclude) ) {
            $fields[] = "`$key`";
        }
    }
	
	foreach($data as $dataSet){
		
		if(isset($values)) unset($values);
		foreach( array_keys($dataSet) as $key ){
			if( !in_array($key, $exclude) ) {
			$values[] = "'" . mysqli_real_escape_string($this->con, $dataSet[$key]) . "'";
			}
		}
		
		$valuesSet[] = "(". implode(',',$values) .")"; 
	}
	
	$fields = implode(",", $fields);
	$valuesData = implode(", ", $valuesSet);
	$sqlQuery = "INSERT INTO `$table` ($fields) VALUES $valuesData;";

	if($this->query=mysqli_query($this->con, $sqlQuery)){
		return array( 
			'error' => false,
			'insert_id'=> mysqli_insert_id($this->con),
			'affected_rows' => mysqli_affected_rows($this->con),
			'info' => mysqli_info($this->con)
		);
	} else {
		return array( 'error' => mysqli_error($this->con) );
	}
	
}



public function _update($table, $colums = array(), $where = array(), $exclude = array()) {
	
	$fields = $values = array();
    if( !is_array($exclude) ) $exclude = array($exclude);
    foreach( array_keys($colums) as $key ) {
        if( !in_array($key, $exclude) ) {			
			$fields[] = "`$key`='" . mysqli_real_escape_string($this->con, $colums[$key]). "'";
        }
    }
	

	foreach( array_keys($where) as $k) {
		$w[] = "`$k`='".$where[$k]."'";
	}



	$sqlQuery = "UPDATE `$table` SET " . implode( ', ', $fields ) . ' WHERE ' . implode( ' AND ', $w ); 
	
	if($this->query=mysqli_query($this->con, $sqlQuery)){
		return array( 
			'error' => false,
			'affected_rows' => mysqli_affected_rows($this->con),
			'info' => mysqli_info($this->con)
		);
	} else {
		return array( 'error' => mysqli_error($this->con) );
	}		
}

public function _delete($table, $where = array()) {
	
	foreach( array_keys($where) as $k) { $w[] = "`$k`='".$where[$k]."'"; }
	$sqlQuery = "DELETE FROM `$table`  WHERE " . implode( ' AND ', $w );
	
	if($this->query=mysqli_query($this->con, $sqlQuery)){
		return array( 
			'error' => false,
			'affected_rows' => mysqli_affected_rows($this->con),
			'info' => mysqli_info($this->con)
		);
	} else {
		return array( 'error' => mysqli_error($this->con) );
	}		
}

public function _query($sql) {
	$query = $this->result=mysqli_query($this->con,$sql) or die ( mysqli_error($this->con));	
	if($query){
		return array( 
			'error' => false,
			'affected_rows' => mysqli_affected_rows($this->con),
			'info' => mysqli_info($this->con)
		);
	} else {
		return array( 'error' => mysqli_error($this->con) );
	}
}

public function _createQuery($table=array(),$select=array(),$where=array(),$group=array(),$order=array(),$limit=NULL) {
	
	$sql=" SELECT ".implode(', ', $select);
	$sql.=" FROM ".implode(', ', $table);
	if(count($where) > 0){ $sql.=" WHERE ".implode(' AND ', $where); }
	if(count($group) > 0){ $sql.=" GROUP BY ".implode(', ', $group); }
	if(count($order) > 0){ $sql.=" ORDER BY ".implode(', ', $order); }
	if(!empty($limit)){ $sql.=" LIMIT ".$limit; }
	return $sql;		
}

public function _numRows($sql) {
    
	$query = $this->result=mysqli_query($this->con,$sql);
	
    $numrows = mysqli_num_rows($query);	
    
    return ($numrows > 0) ? $numrows : 0;
}

} // END CLASS 
