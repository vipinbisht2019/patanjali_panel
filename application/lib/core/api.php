<?php

class api {
	
	private $httpVersion = "HTTP/1.1";
	private $authKey = '';
	private $fcmKey = '';
	
	
	public function authRequest($post){
		if(isset($_POST['authkey'])){
			//$response = array("error"=>401, "msg"=>'Unauthorized: Access is denied');
			//$api->setResponse($response, 401);
			//exit();
		} else if (!isset($_POST['authkey'])){
			$response = array("error"=>401, "msg"=>'Unauthorized: Access is denied');
			$this->setResponse($response, 401);
			exit();
		}
	}
	
	public function jsonBody(){
		return json_decode(file_get_contents('php://input'), true);
	}
	
	public function input($key, $type='string'){
		// FILTER_REQUIRE_ARRAY
		$var = filter_input(INPUT_POST, $key, FILTER_DEFAULT);
		return $this->_datatype($var, $type);
	}
	
	private function _datatype($data, $type){
		switch($type){
		  case 'string':
			return (string) $data; 
			break;
		  case 'int':
			return (int) $data;
			break;
		  case 'float':
			return (float) $data;
			break;
		}	
	}
	
	public function setResponse($response=NULL, $statusCode=NULL, $object=false){
	    
		$statusMessage = $this->getHttpStatusMessage($statusCode);
		header($this->httpVersion. " ". $statusCode ." ". $statusMessage);		
		header("Content-Type:application/json");
		
		if($object){
		   echo json_encode($response, JSON_FORCE_OBJECT);
		} else {
		   echo json_encode($response,JSON_PRETTY_PRINT);
		}
	}
	
	
	
	public function setHttpHeaders($statusCode){
		
		$statusMessage = $this->getHttpStatusMessage($statusCode);
		header($this->httpVersion. " ". $statusCode ." ". $statusMessage);		
		header("Content-Type:application/json");
	}
	
	public function getHttpStatusMessage($statusCode){
		$httpStatus = array(
			100 => 'Continue',  
			101 => 'Switching Protocols',  
			200 => 'OK',
			201 => 'Created',  
			202 => 'Accepted',  
			203 => 'Non-Authoritative Information',  
			204 => 'No Content',  
			205 => 'Reset Content',  
			206 => 'Partial Content',  
			300 => 'Multiple Choices',  
			301 => 'Moved Permanently',  
			302 => 'Found',  
			303 => 'See Other',  
			304 => 'Not Modified',  
			305 => 'Use Proxy',  
			306 => '(Unused)',  
			307 => 'Temporary Redirect',  
			400 => 'Bad Request',  
			401 => 'Unauthorized',  
			402 => 'Payment Required',  
			403 => 'Forbidden',  
			404 => 'Not Found',  
			405 => 'Method Not Allowed',  
			406 => 'Not Acceptable',  
			407 => 'Proxy Authentication Required',  
			408 => 'Request Timeout',  
			409 => 'Conflict',  
			410 => 'Gone',  
			411 => 'Length Required',  
			412 => 'Precondition Failed',  
			413 => 'Request Entity Too Large',  
			414 => 'Request-URI Too Long',  
			415 => 'Unsupported Media Type',  
			416 => 'Requested Range Not Satisfiable',  
			417 => 'Expectation Failed',  
			500 => 'Internal Server Error',  
			501 => 'Not Implemented',  
			502 => 'Bad Gateway',  
			503 => 'Service Unavailable',  
			504 => 'Gateway Timeout',  
			505 => 'HTTP Version Not Supported');
		return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $status[500];
	}


	public function validateSession(){
		if(!empty($_SESSION['ADMIN_USER']['ID']) || !empty($_SESSION['ADMIN_USER']['NAME']) || !empty($_SESSION['ADMIN_USER']['ROLE'])){
			return true;
		} else {
			header('location:'.SITE_URL.'/login');
			exit(0);
		}
	}

	public function isLogin(){
		if(!empty($_SESSION['ADMIN_USER']['ID']) && !empty($_SESSION['ADMIN_USER']['ROLE'])){
			return true;
		} else {
			return false;
		}
	}
	

  public function checkUniq($array, $code_length){
  	$code = $this->alphanum($code_length);
  	$code = $code.uniqid();
  	if(!in_array($code, $array)){
  		return strtoupper($code);
  	} else {
  		return $this->checkUniq($array, $code_length);
  	}
  } 

	public function getUniqRandomNum($productKeyArray, $code_length){
		return $this->checkUniq($productKeyArray, $code_length);
	}

	public function alphanum($random_string_lengt){
			$characters = 'ABCDEFGHJKLMNPQRTUVWXYZ2346789';
			$string = '';
			$max = strlen($characters) - 1;
			for ($i = 0; $i < $random_string_lengt; $i++) {
			   $string .= $characters[mt_rand(0, $max)];
			}
			return $string;
	}

	public function dateReplace($dateString, $seprator='/', $replace='-'){
		$d = explode($seprator, $dateString);
		return $d[2].$replace.$d[1].$replace.$d[0];
	}

	public function dateFix($dateString, $seprator='/', $replace='-'){

		$d = explode($seprator, $dateString);
		$dd = (strlen($d[0]) < 2) ? '0'.$d[0] : $d[0];
		$mm = (strlen($d[1]) < 2) ? '0'.$d[1] : $d[1];
		$yy = $d[2];
		return $yy.$replace.$mm.$replace.$dd;
	}

	public function maskName($name){
		return $start = substr($name, 0, 3).'...';
	}

	public function maskMobile($mobile){
		$start = substr($mobile, 0, 3);
		$end = substr($mobile, -2);
		return $start.'xxxxx'.$end;
	}

	public function mobileFix($mobile){
		$mobile = str_replace(' ', '', $mobile);
		$mobile = substr($mobile, -10);
		return $mobile;
	}


	public function callLamiService($servicePath, $data){

		$apiEndPoint = API_LAMI.$servicePath;
		$jsonReqest = json_encode($data, true);

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $apiEndPoint,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $jsonReqest,
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		));
		$request_headers = ['ServiceCall: API'];
		curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  return array('success'=>0, 'message'=>$err);
		} else {
		  return json_decode($response, true);
		}
	}
	
	
	
	
	public function callService($servicePath, $data){

		$apiEndPoint = API_URL.$servicePath;
		$jsonReqest = json_encode($data, true);

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $apiEndPoint,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $jsonReqest,
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		));
 		$request_headers = ['ServiceCall: API'];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  return array('success'=>0, 'message'=>$err);
		} else {
		  return json_decode($response, true);
		}
	}
	
	
	
	
	public function otpcode($random_string_lengt){
			$characters = '0123456789';
			$string = '';
			$max = strlen($characters) - 1;
			for ($i = 0; $i < $random_string_lengt; $i++) {
			   $string .= $characters[mt_rand(0, $max)];
			}
			return $string;
	}

	public function sendOTP($mobile, $otp){
		$message = "Your OTP is ".$otp." for login at LAMI ADVANCE SOLUTIONS PRIVATE LIMITED.";
		$this->sendSMS($mobile, $message);
	}


	public function sendSMS($mobile, $message){

		//$message = 'Your OTP Code '.$otp;
		$params = array(
		   "method" => "sms",
		   "api_key" => "A7c3c1d0414ab0287fc20749e4d80a9e5",
		   "sender" => "LAMICK",
		   "message" => $message,
		   "to" => $mobile,
		);

		$httpQuery = http_build_query($params);
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api-alerts.kaleyra.com/v4/?".$httpQuery,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  return array('success'=>0, 'message'=>$err);
		} else {
		  return array('success'=>1, 'response'=>$response);
		}
	}

    public function getSyncData($mobile_number, $code) {
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);
        $syncedData = $redis->get($mobile_number);
        $list_services = $redis->get('list_web_service');
        $list_service_data = !empty($list_services)?unserialize($list_services):[];
        if(!empty($list_service_data)){
            $lami_code = substr($code,0,3);
            foreach($list_service_data as $brand){
                if($brand['code'] == $lami_code){
                    $manufacturer_id = (int)$brand['manufacturer_id'];
                    break;
                }
            }
        }
        $manufacturer_ids = !empty($syncedData) ? unserialize($syncedData) : [];
        if (empty($manufacturer_ids) || !in_array($manufacturer_id, $manufacturer_ids)) {
            $manufacturer_ids[] = $manufacturer_id;
            $redis->set($mobile_number, serialize($manufacturer_ids));
        }
    }
}

