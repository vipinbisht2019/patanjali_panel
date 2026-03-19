<?php 

require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/users.php';
require_once CLASS_DIR.'/report.php';
require_once CLASS_DIR.'/api.php';

 require_once LIB_DIR.'/Excel/PHPExcel.php';

$api = new api();
$report = new report();

/*
$ct = [];
$ct["1"] = 'Admin';
$ct["2"] = 'Authorised Distributor';
$ct["3"] = 'Distributor';
$ct["4"] = 'Retailer';
$ct["5"] = 'Customer';
$ct["6"] = 'Mechanic';
// $ct["7"] = 'Authorised Retailer';
$ct["8"] = 'Sales Staff';
$ct["9"] = 'Engg. Workshop';
$ct["10"] = 'Other';
$ct["11"] = 'Auth. Retailer';
$ct["12"] = 'Deactivated';
*/
// ===== DASHBOARD ====== //



// ===== REPORT ====== //

// start 15_may_2023

if(isset($_GET['controller']) && $_GET['controller']=='ByDate_scanTrendCustomerDownload'){
	$post = $api->jsonBody();
	$result = $report->scanTrendCustomerByDate($post);
	//print_r($result);
	
	
	$startYear = $post['year'];
	$endYear = $post['year'];
	$start = $month = strtotime("$startYear-01-01");
	$end = strtotime("$endYear-12-31");
	$selected_moth =  $post['month'];
	/*
	if($selected_moth>3)
	{
	$days  = cal_days_in_month(CAL_GREGORIAN,$selected_moth,$startYear);
	$start_date = $startYear.'-'.$selected_moth.'-'.'01';
	$end_date = $startYear.'-'.$selected_moth.'-'.$days;
	}
	else
	{
	$days  = cal_days_in_month(CAL_GREGORIAN,$selected_moth,$endYear);
	$start_date = $endYear.'-'.$selected_moth.'-'.'01';
	$end_date = $endYear.'-'.$selected_moth.'-'.$days;

	}

	*/

	$days  = cal_days_in_month(CAL_GREGORIAN,$selected_moth,$startYear);
	$start_date = $startYear.'-'.$selected_moth.'-'.'01';
	$end_date = $startYear.'-'.$selected_moth.'-'.$days;
	// echo $start_date;
	// echo $end_date;
	
	
	while($start_date <= $end_date)
	{
     $dateArray[] =  $start_date;
	 $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));
    
	}
	
	
	while($month < $end)
	{
     $monthArray[] =  date('Y-m', $month);
     $month = strtotime("+1 month", $month);
	}
	

	if($result){
		foreach ($result as $key => $value) {

			$userId = $value['userId'];
			$userRoleId = $value['userRoleId'];
			$name = $value['name'];
			
			$m = $value['sdate'];

			$dataSet[$userId]['name'] = $name;
			$dataSet[$userId]['dealerCode'] = $value['dealerCode'];
			$dataSet[$userId]['mobile'] = $value['mobile'];
			$dataSet[$userId]['type'] = $ct[$userRoleId];
			$dataSet[$userId]['beat'] = $value['beat'];
			$dataSet[$userId]['meta'][$m] = array('num'=>$value['num'], 'point'=>$value['point']);
		}

		$i=0;
		foreach ($dataSet as $k=>$u) {

			$reportData[$i]['name'] = $u['name'];
			$reportData[$i]['dealerCode'] = $u['dealerCode'];
			$reportData[$i]['mobile'] = $u['mobile'];
			$reportData[$i]['type'] = $u['type'];
			$reportData[$i]['beat'] = $u['beat'];
			
			$meta = $u['meta'];
			foreach ($dateArray as $m) {
					if(isset($meta[$m])){
						$reportData[$i]['meta'][] = array('num'=>$meta[$m]['num'], 'point'=>$meta[$m]['point']);
					} else {
						$reportData[$i]['meta'][]= array('num'=>0, 'point'=>0);
					}
				}

			$i++;
		}
	}

// echo "<pre>"; print_r($reportData); die;
// exit;
	if(is_array($reportData)){
			
		
		$objPHPExcel = new PHPExcel();
		$objSheet = $objPHPExcel->getActiveSheet();
		$objSheet->setTitle('Report');

		$style = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        )
	  );

	  $objSheet->setCellValue('A1', 'Name');
	  $objSheet->mergeCells('A1:A2');

	  $objSheet->setCellValue('B1', 'Dealer Code');
	  $objSheet->mergeCells('B1:B2');

	  $objSheet->setCellValue('C1', 'Mobile');
	  $objSheet->mergeCells('C1:C2');
	  
	   $objSheet->setCellValue('D1', 'Customer Type');
	  $objSheet->mergeCells('D1:D2');

	  $objSheet->setCellValue('E1', 'Beat');
	  $objSheet->mergeCells('E1:E2');

	  $objSheet->mergeCells('F1:G1');
	  $objSheet->getStyle("A1:BQ2")->applyFromArray($style);

	 $objSheet->setCellValue('F1', 'Total');
	  $objSheet->mergeCells('F1:G1');

	  $objSheet->setCellValue('H1', '01');
	  $objSheet->mergeCells('H1:I1');

	  $objSheet->setCellValue('J1', '02');
	  $objSheet->mergeCells('J1:K1');

	  $objSheet->setCellValue('L1', '03');
	  $objSheet->mergeCells('L1:M1');

	  $objSheet->setCellValue('N1', '04');
	  $objSheet->mergeCells('N1:O1');

	  $objSheet->setCellValue('P1', '05');
	  $objSheet->mergeCells('P1:Q1');

	  $objSheet->setCellValue('R1', '06');
	  $objSheet->mergeCells('R1:S1');

	  $objSheet->setCellValue('T1', '07');
	  $objSheet->mergeCells('T1:U1');

	  $objSheet->setCellValue('V1', '08');
	  $objSheet->mergeCells('V1:W1');

	  $objSheet->setCellValue('X1', '09');
	  $objSheet->mergeCells('X1:Y1');

	  $objSheet->setCellValue('Z1', '10');
	  $objSheet->mergeCells('Z1:AA1');
	  $objSheet->setCellValue('AB1', '11');
	  $objSheet->mergeCells('AB1:AC1');
	  $objSheet->setCellValue('AD1', '12');
	  $objSheet->mergeCells('AD1:AE1');
	  $objSheet->setCellValue('AF1', '13');
	  $objSheet->mergeCells('AF1:AG1');
	  $objSheet->setCellValue('AH1', '14');
	  $objSheet->mergeCells('AH1:AI1');
	  $objSheet->setCellValue('AJ1', '15');
	  $objSheet->mergeCells('AJ1:AK1');
	  $objSheet->setCellValue('AL1', '16');
	  $objSheet->mergeCells('AL1:AM1');
	  $objSheet->setCellValue('AN1', '17');
	  $objSheet->mergeCells('AN1:AO1');
	  $objSheet->setCellValue('AP1', '18');
	  $objSheet->mergeCells('AP1:AQ1');
	  $objSheet->setCellValue('AR1', '19');
	  $objSheet->mergeCells('AR1:AS1');
	  $objSheet->setCellValue('AT1', '20');
	  $objSheet->mergeCells('AT1:AU1');	  
	  $objSheet->setCellValue('AV1', '21');
	  $objSheet->mergeCells('AV1:AW1');	  
	  $objSheet->setCellValue('AX1', '22');
	  $objSheet->mergeCells('AX1:AY1');	  
	  $objSheet->setCellValue('AZ1', '23');
	  $objSheet->mergeCells('AZ1:BA1');	  
	  $objSheet->setCellValue('BB1', '24');
	  $objSheet->mergeCells('BB1:BC1');	  
	  $objSheet->setCellValue('BD1', '25');
	  $objSheet->mergeCells('BD1:BE1');	  
	  $objSheet->setCellValue('BF1', '26');
	  $objSheet->mergeCells('BF1:BG1');
	  $objSheet->setCellValue('BH1', '27');
	  $objSheet->mergeCells('BH1:BI1');
	  $objSheet->setCellValue('BJ1', '28');
	  $objSheet->mergeCells('BJ1:BK1');
	  $objSheet->setCellValue('BL1', '29');
	  $objSheet->mergeCells('BL1:BM1');
	  $objSheet->setCellValue('BN1', '30');
	  $objSheet->mergeCells('BN1:BO1');
	  
	  $objSheet->setCellValue('BP1', '31');
	  $objSheet->mergeCells('BP1:BQ1');


	  $objSheet->setCellValue('F2', 'NOS');
	  $objSheet->setCellValue('G2', 'AMT');
	  $objSheet->setCellValue('H2', 'NOS');
	  $objSheet->setCellValue('I2', 'AMT');
	  $objSheet->setCellValue('J2', 'NOS');
	  $objSheet->setCellValue('K2', 'AMT');
	  $objSheet->setCellValue('L2', 'NOS');
	  $objSheet->setCellValue('M2', 'AMT');
	  $objSheet->setCellValue('N2', 'NOS');
	  $objSheet->setCellValue('O2', 'AMT');
	  $objSheet->setCellValue('P2', 'NOS');
	  $objSheet->setCellValue('Q2', 'AMT');
	  $objSheet->setCellValue('R2', 'NOS');
	  $objSheet->setCellValue('S2', 'AMT');
	  $objSheet->setCellValue('T2', 'NOS');
	  $objSheet->setCellValue('U2', 'AMT');
	  $objSheet->setCellValue('V2', 'NOS');
	  $objSheet->setCellValue('W2', 'AMT');
	  $objSheet->setCellValue('X2', 'NOS');
	  $objSheet->setCellValue('Y2', 'AMT');
	  $objSheet->setCellValue('Z2', 'NOS');
	  $objSheet->setCellValue('AA2', 'AMT');

	  $objSheet->setCellValue('AB2', 'NOS');
	  $objSheet->setCellValue('AC2', 'AMT');
	  $objSheet->setCellValue('AD2', 'NOS');
	  $objSheet->setCellValue('AE2', 'AMT');
	  $objSheet->setCellValue('AF2', 'NOS');
	  $objSheet->setCellValue('AG2', 'AMT');
	  $objSheet->setCellValue('AH2', 'NOS');
	  $objSheet->setCellValue('AI2', 'AMT');
	  $objSheet->setCellValue('AJ2', 'NOS');
	  $objSheet->setCellValue('AK2', 'AMT');
	  $objSheet->setCellValue('AL2', 'NOS');
	  $objSheet->setCellValue('AM2', 'AMT');
	  $objSheet->setCellValue('AN2', 'NOS');
	  $objSheet->setCellValue('AO2', 'AMT');
	  $objSheet->setCellValue('AP2', 'NOS');
	  $objSheet->setCellValue('AQ2', 'AMT');
	  $objSheet->setCellValue('AR2', 'NOS');
	  $objSheet->setCellValue('AS2', 'AMT');
	  $objSheet->setCellValue('AT2', 'NOS');
	  
	  $objSheet->setCellValue('AU2', 'AMT');
	  $objSheet->setCellValue('AV2', 'NOS');
	  $objSheet->setCellValue('AW2', 'AMT');
	  $objSheet->setCellValue('AX2', 'NOS');
	  $objSheet->setCellValue('AY2', 'AMT');
	  $objSheet->setCellValue('AZ2', 'NOS');
	  $objSheet->setCellValue('BA2', 'AMT');

	  $objSheet->setCellValue('BB2', 'NOS');
	  $objSheet->setCellValue('BC2', 'AMT');
	  $objSheet->setCellValue('BD2', 'NOS');
	  $objSheet->setCellValue('BE2', 'AMT');
	  $objSheet->setCellValue('BF2', 'NOS');
	  $objSheet->setCellValue('BG2', 'AMT');
	  $objSheet->setCellValue('BH2', 'NOS');
	  $objSheet->setCellValue('BI2', 'AMT');
	  $objSheet->setCellValue('BJ2', 'NOS');
	  $objSheet->setCellValue('BK2', 'AMT');
	  $objSheet->setCellValue('BL2', 'NOS');
	  $objSheet->setCellValue('BM2', 'AMT');	  
	  $objSheet->setCellValue('BN2', 'NOS');
	  $objSheet->setCellValue('BO2', 'AMT');  
	  $objSheet->setCellValue('BP2', 'NOS');
	  $objSheet->setCellValue('BQ2', 'AMT');
	 
	 
		 
		  $arr2 = array();
		   $i=3;
// echo "<pre>"; print_r($reportData); die;	
/*
$numCount = 0 ;
foreach($reportData as $allCount)
{
	foreach ($allCount['meta'] as $Countdata) {
		$numCount = $numCount + $Countdata['num'];
	}
}

echo $numCount;

die;
*/


	  foreach ($reportData as $keyNum => $value) {
		
		$objSheet->getCell(chr(65).$i)->setValue($value['name']);
	  	$objSheet->getCell(chr(66).$i)->setValue($value['dealerCode']);
	  	$objSheet->getCell(chr(67).$i)->setValue($value['mobile']);
	  	$objSheet->getCell(chr(68).$i)->setValue($value['type']);
	  	$objSheet->getCell(chr(69).$i)->setValue($value['beat']);
		
//		echo $keyNum; die;
//echo $value['meta'][0]['num']; die;
		  foreach ($value['meta'] as $v11) {
			$numData = 0;
			$pointData = 0; 
				//	$numData = var_dump($v11['num']);
				$arr11[] = $v11;
		  } 
		 
		foreach($arr11 as $dataCount){
			
			$numData = $numData +  (int)$dataCount['num'];
			$pointData = $pointData +  (int)$dataCount['point'];
		  
		}

	  	$objSheet->getCell(chr(70).$i)->setValue($numData);
	  	$objSheet->getCell(chr(71).$i)->setValue($pointData);

unset($arr11);

	  	 $arr = array();
	  	
	  	foreach ($value['meta'] as $v) {
			
			$arr[] = $v['num'];
			$arr[] = $v['point'];
			
	  	}
		$i++;
	  	 $arr2[] =$arr;
	  }
	  $i=3;
	  foreach($arr2 as $l)
	  {
		 
		 $char = 72;
		  	foreach($l as $u) {
				if($char<91){
				$objSheet->getCell(chr($char).$i)->setValue($u);
				
	  		

				}else if($char==91){
					$objSheet->getCell('AA'.$i)->setValue($u);
	  			
	  		}
			else if($char==92){
				$objSheet->getCell('AB'.$i)->setValue($u);
	  			
	  		}
			else if($char==93){
							$objSheet->getCell('AC'.$i)->setValue($u);
						}
			else if($char==94){
							$objSheet->getCell('AD'.$i)->setValue($u);
						}
			else if($char==95 ){
							$objSheet->getCell('AE'.$i)->setValue($u);
						}
			else if($char== 96){
							$objSheet->getCell('AF'.$i)->setValue($u);
						}
			else if($char== 97){
							$objSheet->getCell('AG'.$i)->setValue($u);
						}
			else if($char== 98){
							$objSheet->getCell('AH'.$i)->setValue($u);
						}else if($char==99 ){
							$objSheet->getCell('AI'.$i)->setValue($u);
						}else if($char== 100){
							$objSheet->getCell('AJ'.$i)->setValue($u);
						}else if($char== 101){
							$objSheet->getCell('AK'.$i)->setValue($u);
						}else if($char==102 ){
							$objSheet->getCell('AL'.$i)->setValue($u);
						}else if($char==103 ){
							$objSheet->getCell('AM'.$i)->setValue($u);
						}else if($char==104 ){
							$objSheet->getCell('AN'.$i)->setValue($u);
						}else if($char==105 ){
							$objSheet->getCell('AO'.$i)->setValue($u);
						}else if($char==106 ){
							$objSheet->getCell('AP'.$i)->setValue($u);
						}else if($char==107 ){
							$objSheet->getCell('AQ'.$i)->setValue($u);
						}else if($char==108 ){
							$objSheet->getCell('AR'.$i)->setValue($u);
						}else if($char==109){
							$objSheet->getCell('AS'.$i)->setValue($u);
						}else if($char==110 ){
							$objSheet->getCell('AT'.$i)->setValue($u);
						}else if($char==111 ){
							$objSheet->getCell('AU'.$i)->setValue($u);
						}else if($char==112 ){
							$objSheet->getCell('AV'.$i)->setValue($u);
						}else if($char==113 ){
							$objSheet->getCell('AW'.$i)->setValue($u);
						}else if($char==114 ){
							$objSheet->getCell('AX'.$i)->setValue($u);
						}else if($char==115 ){
							$objSheet->getCell('AY'.$i)->setValue($u);
						}else if($char==116 ){
							$objSheet->getCell('AZ'.$i)->setValue($u);
						}else if($char==117 ){
							$objSheet->getCell('BA'.$i)->setValue($u);
						}else if($char==118 ){
							$objSheet->getCell('BB'.$i)->setValue($u);
						}else if($char==119 ){
							$objSheet->getCell('BC'.$i)->setValue($u);
						}else if($char==120 ){
							$objSheet->getCell('BD'.$i)->setValue($u);
						}else if($char==121 ){
							$objSheet->getCell('BE'.$i)->setValue($u);
						}
						else if($char==122 ){
							$objSheet->getCell('BF'.$i)->setValue($u);
						}
						else if($char==123 ){
							$objSheet->getCell('BG'.$i)->setValue($u);
						}
						else if($char==124 ){
							$objSheet->getCell('BH'.$i)->setValue($u);
						}
						else if($char==125 ){
							$objSheet->getCell('BI'.$i)->setValue($u);
						}
						else if($char==126 ){
							$objSheet->getCell('BJ'.$i)->setValue($u);
						}
						else if($char==127 ){
							$objSheet->getCell('BK'.$i)->setValue($u);
						}
						else if($char==128 ){
							$objSheet->getCell('BL'.$i)->setValue($u);
						}
						else if($char==129 ){
							$objSheet->getCell('BM'.$i)->setValue($u);
						}
						else if($char==130 ){
							$objSheet->getCell('BN'.$i)->setValue($u);
						}
						else if($char==131 ){
							$objSheet->getCell('BO'.$i)->setValue($u);
						}
						else if($char==132 ){
							$objSheet->getCell('BP'.$i)->setValue($u);
						}
						else if($char==133 ){
							$objSheet->getCell('BQ'.$i)->setValue($u);
						}
						
						
						
	  		$char++;
	  	}
	  	$i++;
			
			
			}
	 
	 
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output'); 
		$xlsData = ob_get_contents();
		ob_end_clean();

		$return =  array(
		  'success' => 1,
		  'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);

	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}



if(isset($_GET['controller']) && $_GET['controller']=='ByDate_scanTrendCustomerDownload_vipin'){
	$post = $api->jsonBody();
	$result = $report->scanTrendCustomerByDate($post);
	//print_r($result);

	$startYear = $post['year'];
	$endYear = $post['year'];
	$start = $month = strtotime("$startYear-01-01");
	$end = strtotime("$endYear-12-31");
	$selected_moth =  $post['month'];
	/*
	if($selected_moth>3)
	{
	$days  = cal_days_in_month(CAL_GREGORIAN,$selected_moth,$startYear);
	$start_date = $startYear.'-'.$selected_moth.'-'.'01';
	$end_date = $startYear.'-'.$selected_moth.'-'.$days;
	}
	else
	{
	$days  = cal_days_in_month(CAL_GREGORIAN,$selected_moth,$endYear);
	$start_date = $endYear.'-'.$selected_moth.'-'.'01';
	$end_date = $endYear.'-'.$selected_moth.'-'.$days;

	}

	*/

	$days  = cal_days_in_month(CAL_GREGORIAN,$selected_moth,$startYear);
	$start_date = $startYear.'-'.$selected_moth.'-'.'01';
	$end_date = $startYear.'-'.$selected_moth.'-'.$days;
/*
	 echo $start_date;
	echo "<br>";
	 echo $end_date;
	echo "<br>";
*/
	
	while($start_date <= $end_date)
	{
     $dateArray[] =  $start_date;
	 $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));
    
	}
	
	
	while($month < $end)
	{
     $monthArray[] =  date('Y-m', $month);
     $month = strtotime("+1 month", $month);
	}
	
// echo "<pre>"; print_r($result); die;
	if($result){
		foreach ($result as $key => $value) {

			$userId = $value['userId'];
			$userRoleId = $value['userRoleId'];
			$name = $value['name'];
			
			$m = $value['sdate'];

			$dataSet[$userId]['name'] = $name;
			$dataSet[$userId]['dealerCode'] = $value['dealerCode'];
			$dataSet[$userId]['mobile'] = $value['mobile'];
			$dataSet[$userId]['type'] = $ct[$userRoleId];
			$dataSet[$userId]['beat'] = $value['beat'];
			$dataSet[$userId]['meta'][$m] = array('num'=>$value['num'], 'point'=>$value['point']);
		}

		$i=0;
		foreach ($dataSet as $k=>$u) {

			$reportData[$i]['name'] = $u['name'];
			$reportData[$i]['dealerCode'] = $u['dealerCode'];
			$reportData[$i]['mobile'] = $u['mobile'];
			$reportData[$i]['type'] = $u['type'];
			$reportData[$i]['beat'] = $u['beat'];
			$meta = $u['meta'];
			foreach ($dateArray as $m) {
					if(isset($meta[$m])){
						$reportData[$i]['meta'][] = array('num'=>$meta[$m]['num'], 'point'=>$meta[$m]['point']);
					} else {
						$reportData[$i]['meta'][]= array('num'=>0, 'point'=>0);
					}
				}

			$i++;
		}
	}


	if(is_array($reportData)){
		

		$objPHPExcel = new PHPExcel();
		$objSheet = $objPHPExcel->getActiveSheet();
		$objSheet->setTitle('Report');

		$style = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        )
	  );

	  $objSheet->setCellValue('A1', 'Name');
	  $objSheet->mergeCells('A1:A2');

	  $objSheet->setCellValue('B1', 'Dealer Code');
	  $objSheet->mergeCells('B1:B2');

	  $objSheet->setCellValue('C1', 'Mobile');
	  $objSheet->mergeCells('C1:C2');

	  $objSheet->setCellValue('D1', 'Customer Type');
	  $objSheet->mergeCells('D1:D2');

	  $objSheet->setCellValue('E1', 'Beat');
	  $objSheet->mergeCells('E1:E2');

	  $objSheet->mergeCells('F1:G1');
	  $objSheet->getStyle("A1:AA2")->applyFromArray($style);

	  $objSheet->setCellValue('F1', '01');
	  $objSheet->mergeCells('F1:G1');

	  $objSheet->setCellValue('H1', '02');
	  $objSheet->mergeCells('H1:I1');

	  $objSheet->setCellValue('J1', '03');
	  $objSheet->mergeCells('J1:K1');

	  $objSheet->setCellValue('L1', '04');
	  $objSheet->mergeCells('L1:M1');

	  $objSheet->setCellValue('N1', '05');
	  $objSheet->mergeCells('N1:O1');

	  $objSheet->setCellValue('P1', '06');
	  $objSheet->mergeCells('P1:Q1');

	  $objSheet->setCellValue('R1', '07');
	  $objSheet->mergeCells('R1:S1');

	  $objSheet->setCellValue('T1', '08');
	  $objSheet->mergeCells('T1:U1');

	  $objSheet->setCellValue('V1', '9');
	  $objSheet->mergeCells('V1:W1');

	  $objSheet->setCellValue('X1', '10');
	  $objSheet->mergeCells('X1:Y1');

	  $objSheet->setCellValue('Z1', '11');
	  $objSheet->mergeCells('Z1:AA1');
	  $objSheet->setCellValue('AB1', '12');
	  $objSheet->mergeCells('AB1:AC1');
	  $objSheet->setCellValue('AD1', '13');
	  $objSheet->mergeCells('AD1:AE1');
	  $objSheet->setCellValue('AF1', '14');
	  $objSheet->mergeCells('AF1:AG1');
	  $objSheet->setCellValue('AH1', '15');
	  $objSheet->mergeCells('AH1:AI1');
	  $objSheet->setCellValue('AJ1', '16');
	  $objSheet->mergeCells('AJ1:AK1');
	  $objSheet->setCellValue('AL1', '17');
	  $objSheet->mergeCells('AL1:AM1');
	  $objSheet->setCellValue('AN1', '18');
	  $objSheet->mergeCells('AN1:AO1');
	  $objSheet->setCellValue('AP1', '19');
	  $objSheet->mergeCells('AP1:AQ1');
	  $objSheet->setCellValue('AR1', '20');
	  $objSheet->mergeCells('AR1:AS1');
	  $objSheet->setCellValue('AT1', '21');
	  $objSheet->mergeCells('AT1:AU1');	  
	  $objSheet->setCellValue('AV1', '22');
	  $objSheet->mergeCells('AV1:AW1');	  
	  $objSheet->setCellValue('AX1', '23');
	  $objSheet->mergeCells('AX1:AY1');	  
	  $objSheet->setCellValue('AZ1', '24');
	  $objSheet->mergeCells('AZ1:BA1');	  
	  $objSheet->setCellValue('BB1', '25');
	  $objSheet->mergeCells('BB1:BC1');	  
	  $objSheet->setCellValue('BD1', '26');
	  $objSheet->mergeCells('BD1:BE1');	  
	  $objSheet->setCellValue('BF1', '27');
	  $objSheet->mergeCells('BF1:BG1');
	  $objSheet->setCellValue('BH1', '28');
	  $objSheet->mergeCells('BH1:BI1');
	  $objSheet->setCellValue('BJ1', '29');
	  $objSheet->mergeCells('BJ1:BK1');
	  $objSheet->setCellValue('BL1', '30');
	  $objSheet->mergeCells('BL1:BM1');
	  $objSheet->setCellValue('BN1', '31');
	  $objSheet->mergeCells('BN1:BO1');

	 
	  $objSheet->setCellValue('F2', 'NOS');
	  $objSheet->setCellValue('G2', 'AMT');
	  $objSheet->setCellValue('H2', 'NOS');
	  $objSheet->setCellValue('I2', 'AMT');
	  $objSheet->setCellValue('J2', 'NOS');
	  $objSheet->setCellValue('K2', 'AMT');
	  $objSheet->setCellValue('L2', 'NOS');
	  $objSheet->setCellValue('M2', 'AMT');
	  $objSheet->setCellValue('N2', 'NOS');
	  $objSheet->setCellValue('O2', 'AMT');
	  $objSheet->setCellValue('P2', 'NOS');
	  $objSheet->setCellValue('Q2', 'AMT');
	  $objSheet->setCellValue('R2', 'NOS');
	  $objSheet->setCellValue('S2', 'AMT');
	  $objSheet->setCellValue('T2', 'NOS');
	  $objSheet->setCellValue('U2', 'AMT');
	  $objSheet->setCellValue('V2', 'NOS');
	  $objSheet->setCellValue('W2', 'AMT');
	  $objSheet->setCellValue('X2', 'NOS');
	  $objSheet->setCellValue('Y2', 'AMT');
	  $objSheet->setCellValue('Z2', 'NOS');
	  $objSheet->setCellValue('AA2', 'AMT');
	  $objSheet->setCellValue('AB2', 'NOS');
	  $objSheet->setCellValue('AC2', 'AMT');
	  $objSheet->setCellValue('AD2', 'NOS');
	  $objSheet->setCellValue('AE2', 'AMT');
	  $objSheet->setCellValue('AF2', 'NOS');
	  $objSheet->setCellValue('AG2', 'AMT');
	  $objSheet->setCellValue('AH2', 'NOS');
	  $objSheet->setCellValue('AI2', 'AMT');
	  $objSheet->setCellValue('AJ2', 'NOS');
	  $objSheet->setCellValue('AK2', 'AMT');
	  $objSheet->setCellValue('AL2', 'NOS');
	  $objSheet->setCellValue('AM2', 'AMT');
	  $objSheet->setCellValue('AN2', 'NOS');
	  $objSheet->setCellValue('AO2', 'AMT');
	  $objSheet->setCellValue('AP2', 'NOS');
	  $objSheet->setCellValue('AQ2', 'AMT');
	  $objSheet->setCellValue('AR2', 'NOS');
	  $objSheet->setCellValue('AS2', 'AMT');
	  $objSheet->setCellValue('AT2', 'NOS');	  
	  $objSheet->setCellValue('AU2', 'AMT');
	  $objSheet->setCellValue('AV2', 'NOS');
	  $objSheet->setCellValue('AW2', 'AMT');
	  $objSheet->setCellValue('AX2', 'NOS');
	  $objSheet->setCellValue('AY2', 'AMT');
	  $objSheet->setCellValue('AZ2', 'NOS');
	  $objSheet->setCellValue('BA2', 'AMT');
	  $objSheet->setCellValue('BB2', 'NOS');
	  $objSheet->setCellValue('BC2', 'AMT');
	  $objSheet->setCellValue('BD2', 'NOS');
	  $objSheet->setCellValue('BE2', 'AMT');
	  $objSheet->setCellValue('BF2', 'NOS');
	  $objSheet->setCellValue('BG2', 'AMT');
	  $objSheet->setCellValue('BH2', 'NOS');
	  $objSheet->setCellValue('BI2', 'AMT');
	  $objSheet->setCellValue('BJ2', 'NOS');
	  $objSheet->setCellValue('BK2', 'AMT');
	  $objSheet->setCellValue('BL2', 'NOS');
	  $objSheet->setCellValue('BM2', 'AMT');
	  $objSheet->setCellValue('BN2', 'NOS');
	  $objSheet->setCellValue('BO2', 'AMT');


	  $i=3;
	  foreach ($reportData as $value) {

	  	$objSheet->getCell(chr(65).$i)->setValue($value['name']);
	  	$objSheet->getCell(chr(66).$i)->setValue($value['dealercode']);
	  	$objSheet->getCell(chr(67).$i)->setValue($value['mobile']);
	  	$objSheet->getCell(chr(68).$i)->setValue($value['type']);
	  	$objSheet->getCell(chr(69).$i)->setValue($value['beat']);
	  	$char = 70;
	 	foreach ($value['meta'] as $keys => $v) {
		// echo $char;
	  		// $objSheet->getCell(chr($char).$i)->setValue($v['num']);
			
			if( $char > 69 && $char < 91 ) {
				$objSheet->getCell(chr($char).$i)->setValue($v['num']);				
				
				
			//	$objSheet->getCell(chr($char).$i)->setValue($v['point']);
				$char++;
				

			 }
			 
			
	  		if($char==91){
			//	echo chr($char); echo "<br>";
			// echo 91; die;
	  			$objSheet->getCell('AA'.$i)->setValue($v['point']);
				$char++;
	  		}	
			  elseif($char==92){
				//	echo chr($char); echo "<br>";
				//	echo 92; die;
				$objSheet->getCell('AB'.$i)->setValue($v['num']);
				$char++;
			}
			elseif($char==93){
				//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('AC'.$i)->setValue($v['point']);
				$char++;
			}	
			elseif($char==94){
			//	echo chr($char); echo "<br>";
			//	echo 94; die;
				$objSheet->getCell('AD'.$i)->setValue($v['num']);
				$char++;
			}	
			elseif($char==95){
				//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('AE'.$i)->setValue($v['point']);
				$char++;
			}	
			elseif($char==96){
				//	echo chr($char); echo "<br>";
				//	echo 94; die;
					$objSheet->getCell('AF'.$i)->setValue($v['num']);
					$char++;
			}	
			elseif($char==97){
				//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('AG'.$i)->setValue($v['point']);
				$char++;
			}	
			elseif($char==98){
				//	echo chr($char); echo "<br>";
				//	echo 94; die;
				$objSheet->getCell('AH'.$i)->setValue($v['num']);
				$char++;
			}	
			elseif($char==99){
				//	echo chr($char); echo "<br>";
				// echo 99; die;
				$objSheet->getCell('AI'.$i)->setValue($v['point']);
				$char++;
			}	
			elseif($char==100){
			//	echo chr($char); echo "<br>";
				// echo 100; die;
				$objSheet->getCell('AJ'.$i)->setValue($v['num']);
				$char++;
			}	
			elseif($char==101){
				//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('AK'.$i)->setValue($v['point']);
				$char++;
			}	
			elseif($char==102){
			//	echo chr($char); echo "<br>";
				// echo 94; die;
				$objSheet->getCell('AL'.$i)->setValue($v['num']);
				$char++;
			}	
			elseif($char==103){
				//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('AM'.$i)->setValue($v['point']);
				$char++;
			}	
			elseif($char==104){
				//	echo chr($char); echo "<br>";
				// echo 94; die;
				$objSheet->getCell('AN'.$i)->setValue($v['num']);
				$char++;
			}	
			elseif($char==105){
					//	echo chr($char); echo "<br>";
					// echo 93; die;
				$objSheet->getCell('AO'.$i)->setValue($v['point']);
				$char++;
			}	
			elseif($char==106){
				//	echo chr($char); echo "<br>";
				//echo 106; die;
				$objSheet->getCell('AP'.$i)->setValue($v['num']);
				$char++;
			}	
			elseif($char==107){
				//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('AQ'.$i)->setValue($v['point']);
				$char++;
			}	
			elseif($char==108){
				//	echo chr($char); echo "<br>";
			//	echo 94; die;
				$objSheet->getCell('AR'.$i)->setValue($v['num']);
				$char++;
			}	
			elseif($char==109){
							//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('AS'.$i)->setValue($v['point']);
				$char++;
			}	
			elseif($char==110){
				//	echo chr($char); echo "<br>";
				// echo 110; die;
				$objSheet->getCell('AT'.$i)->setValue($v['num']);
				$char++;
			}
			elseif($char==111){
					//	echo chr($char); echo "<br>";
					// echo 110; die;
					$objSheet->getCell('AU'.$i)->setValue($v['point']);
					$char++;
			
					if($char==112)
					{
						//	echo chr($char); echo "<br>";
						// echo 112; die;
						$objSheet->getCell('AV'.$i)->setValue($v['num']);
						$char++;

						if($char==113){
							//	echo chr($char); echo "<br>";
							// echo 93; die;
							$objSheet->getCell('AW'.$i)->setValue($v['point']);
							$char++;

							if($char==114){
								//	echo chr($char); echo "<br>";
								// echo 114; die;
								$objSheet->getCell('AX'.$i)->setValue($v['num']);
								$char++;

								if($char==115){
									//	echo chr($char); echo "<br>";
									// echo 93; die;
									$objSheet->getCell('AY'.$i)->setValue($v['point']);
									$char++;

									if($char==116){
										//	echo chr($char); echo "<br>";
										// echo 94; die;
										$objSheet->getCell('AZ'.$i)->setValue($v['num']);
										$char++;

										if($char==117){
											//	echo chr($char); echo "<br>";
											// echo 93; die;
											$objSheet->getCell('BA'.$i)->setValue($v['point']);
											$char++;

											if($char==118){
												//	echo chr($char); echo "<br>";
												// echo 94; die;
												$objSheet->getCell('BB'.$i)->setValue($v['num']);
												$char++;

												if($char==119){
													//	echo chr($char); echo "<br>";
													// echo 119; die;
													$objSheet->getCell('BC'.$i)->setValue($v['point']);
													$char++;

													if($char==120){
														//	echo chr($char); echo "<br>";
														// echo 94; die;
														$objSheet->getCell('BD'.$i)->setValue($v['num']);
														$char++;

														if($char==121){
															//	echo chr($char); echo "<br>";
															// echo 93; die;
															$objSheet->getCell('BE'.$i)->setValue($v['point']);
															$char++;

															if($char==122){
																//	echo chr($char); echo "<br>";
																// echo 94; die;
																$objSheet->getCell('BF'.$i)->setValue($v['num']);
																$char++;

																if($char==123){
																	//	echo chr($char); echo "<br>";
																	// echo 93; die;
																	$objSheet->getCell('BG'.$i)->setValue($v['point']);
																	$char++;

																	if($char==124){
																		//	echo chr($char); echo "<br>";
																		// echo 94; die;
																		$objSheet->getCell('BH'.$i)->setValue($v['num']);
																		$char++;

																		if($char==125){
																			//	echo chr($char); echo "<br>";
																			// echo 93; die;
																			$objSheet->getCell('BI'.$i)->setValue($v['point']);
																			$char++;

																			if($char==126){
																				//	echo chr($char); echo "<br>";
																				// echo 94; die;
																				$objSheet->getCell('BJ'.$i)->setValue($v['num']);
																				$char++;

																				if($char==127){
																					//	echo chr($char); echo "<br>";
																					// echo 93; die;
																					$objSheet->getCell('BK'.$i)->setValue($v['point']);
																					$char++;

																					if($char==128){
																						//	echo chr($char); echo "<br>";
																						// echo 94; die;
																						$objSheet->getCell('BL'.$i)->setValue($v['num']);
																						$char++;

																						if($char==129){
																							//	echo chr($char); echo "<br>";
																							// echo 93; die;
																							$objSheet->getCell('BM'.$i)->setValue($v['point']);
																							$char++;

																							if($char==130){
																								//	echo chr($char); echo "<br>";
																								// echo 94; die;
																								$objSheet->getCell('BN'.$i)->setValue($v['num']);
																								$char++;

																								if($char==131){
																									//	echo chr($char); echo "<br>";
																									// echo 93; die;
																									$objSheet->getCell('BO'.$i)->setValue($v['point']);

																									$char++;

																								
																								}
																							}
																						
																						}


																					}
																				}

																			}
																		}
																	}


																}	
															}
														}
													}
												}
											}
										}
									}	

								}	

							}	
						}

					}	
				}	
				
				
			
			
			
/*
			elseif($char==111){
				//	echo chr($char); echo "<br>";
			//	echo 111; die;
				$objSheet->getCell('AU'.$i)->setValue($v['point']);
				$char++;
			}
			elseif($char==112){
				//	echo chr($char); echo "<br>";
				// echo 94; die;
				$objSheet->getCell('AV'.$i)->setValue($v['num']);
			}	
			elseif($char==113){
				//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('AW'.$i)->setValue($v['point']);
			}						
			elseif($char==114){
				//	echo chr($char); echo "<br>";
				// echo 94; die;
				$objSheet->getCell('AX'.$i)->setValue($v['num']);
			}	
			elseif($char==115){
				//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('AY'.$i)->setValue($v['point']);
			}	
			elseif($char==116){
				//	echo chr($char); echo "<br>";
				// echo 94; die;
				$objSheet->getCell('AZ'.$i)->setValue($v['num']);
			}	
			elseif($char==117){
				//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('BA'.$i)->setValue($v['point']);
			}
			elseif($char==118){
				//	echo chr($char); echo "<br>";
				// echo 94; die;
				$objSheet->getCell('BB'.$i)->setValue($v['num']);
			}
			elseif($char==119){
				//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('BC'.$i)->setValue($v['point']);
			}
			elseif($char==120){
				//	echo chr($char); echo "<br>";
				// echo 94; die;
				$objSheet->getCell('BD'.$i)->setValue($v['num']);
			}
			elseif($char==121){
				//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('BE'.$i)->setValue($v['point']);
			}
			elseif($char==122){
				//	echo chr($char); echo "<br>";
				// echo 94; die;
				$objSheet->getCell('BF'.$i)->setValue($v['num']);
			}
			elseif($char==123){
				//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('BG'.$i)->setValue($v['point']);
			}	
			elseif($char==124){
				//	echo chr($char); echo "<br>";
				// echo 94; die;
				$objSheet->getCell('BH'.$i)->setValue($v['num']);
			}
			elseif($char==125){
				//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('BI'.$i)->setValue($v['point']);
			}
			elseif($char==126){
				//	echo chr($char); echo "<br>";
				// echo 94; die;
				$objSheet->getCell('BJ'.$i)->setValue($v['num']);
			}
			elseif($char==127){
				//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('BK'.$i)->setValue($v['point']);
			}
			elseif($char==128){
				//	echo chr($char); echo "<br>";
				// echo 94; die;
				$objSheet->getCell('BL'.$i)->setValue($v['num']);
			}
			elseif($char==129){
				//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('BM'.$i)->setValue($v['point']);
			}
			elseif($char==130){
				//	echo chr($char); echo "<br>";
				// echo 94; die;
				$objSheet->getCell('BN'.$i)->setValue($v['num']);
			}
			elseif($char==131){
				//	echo chr($char); echo "<br>";
				// echo 93; die;
				$objSheet->getCell('BO'.$i)->setValue($v['point']);
			}

*/
	  	  
			else {
			//	$objSheet->getCell(chr($char).$i)->setValue($v['num']);
	  			$objSheet->getCell(chr($char).$i)->setValue($v['point']);
				  $char++;
	  		}
			
	  		// $char++;
			  
	  	}
		
	  	$i++;
	  }

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output'); 
		$xlsData = ob_get_contents();
		ob_end_clean();

		$return =  array(
		  'success' => 1,
		  'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);

	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}



// start arpit_code_26_may_2023

if(isset($_GET['controller']) && $_GET['controller']=='monthlyscanTrendModuleByCategory'){
	$post = $api->jsonBody();
	 $year = $post['year'];
	$start = $month = strtotime("$year-01-01");
	$end = strtotime("$year-12-31");
	
	
	while($month < $end)
	{
     $monthArray[] =  date('Y-m', $month);
     $month = strtotime("+1 month", $month);
	}
	
	$result = $report->scanTrendModulemonth($post);
	$resultuser = $report->scanTrendCustomermonth($post);
	
		foreach ($result as $key => $value) {
			
			
			
			$m = $value['month'];
			
			$dataSet[$m] = array('num'=>$value['num']);
		}

		foreach ($resultuser as $key => $value) {
			
			
			
			$m = $value['month'];
			
			$dataSetuser[$m] = array('ucount'=>$value['ucount']);
		}

		$i=0;
		
			foreach ($monthArray as $m) {
			
			if(isset($dataSet[$m]))
			{

				$arrcoupon[]=intval($dataSet[$m]['num']);
			}
			else{
				$arrcoupon[]=0;

			}
			
			}
			foreach ($monthArray as $m) {
			
				if(isset($dataSetuser[$m]))
				{
	
					$arruser[]=intval($dataSetuser[$m]['ucount']);
				}
				else{
					$arruser[]=0;
	
				}
				
				}


	if(is_array($arruser)){
		$return = array('success'=>1, 'couponcount'=>$arrcoupon,'usercount'=>$arruser);
	} else {
		$return = array('success'=>0,'couponcount'=>$arrcoupon,'usercount'=>$arruser);
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='WelcomescanTrendModuleByCategory'){
	$post = $api->jsonBody();
	$result = $report->scanTrendModule($post);

	$startYear = $post['year'];
	$selected_moth = $post['month'];
	$days  = cal_days_in_month(CAL_GREGORIAN,$selected_moth,$startYear);	
	$start_date = $startYear.'-'.$selected_moth.'-'.'01';	
	$end_date = $startYear.'-'.$selected_moth.'-'.$days;	
	
	$endYear = $post['year'] + 1;
	$start = $month = strtotime("$startYear-04-01");
	$end = strtotime("$endYear-03-30");
	$couponcount = array();
	$usercount = array();
	
	$i=1;
	$count=0;
	while($start_date <= $end_date)	
	{	
     $dateArray[] =  $start_date;	
	 $start_date =  date('Y-m-d', strtotime( $start_date . ' +7 day'));
	
	$count++;
		$i++;	 
    	
	}
	for($k=0;$k<5;$k++)
	{

		
		$start_date = $dateArray[$k];
		if($k<4)
		{
		$endate =  date('Y-m-d', strtotime( $dateArray[$k] . ' +6 day'));
		}
		else{
			$d = $days-29;
			$endate =  date('Y-m-d', strtotime( $dateArray[$k] . " +$d day"));

		}
		$post['start_date'] =  $start_date;
		$post['end_date'] =  $endate;
		$result = $report->scanTrendModuleweek($post);
		$resultuser = $report->scanTrendCustomerweek($post);
		if(!empty($result[0]['num']))
	{
	   $couponcount[]=intval($result[0]['num']);
	}
	else{

		   $couponcount[]=0;

	}
	if(!empty($resultuser[0]['ucount']))
	{
	   $usercount[]=intval($resultuser[0]['ucount']);
	}
	else{

		   $usercount[]=0;

	}
	   		

	}
	
	if(is_array($couponcount)){
		$return = array('success'=>1, 'couponcount'=>$couponcount,'usercount'=>$usercount);
	} else {
		$return = array('success'=>0,'couponcount'=>$couponcount,'usercount'=>$usercount);
	}

	$api->setResponse($return, 200);
}



// end arpit_code 26_may_2023



// end 15_may_2023

if(isset($_GET['controller']) && $_GET['controller']=='scanTrendModule'){
	$post = $api->jsonBody();
	$result = $report->scanTrendModule($post);

	$startYear = $post['year'];
	$endYear = $post['year'] + 1;
	$start = $month = strtotime("$startYear-04-01");
	$end = strtotime("$endYear-03-30");
	

	
	
	while($month < $end)
	{
     $monthArray[] =  date('Y-m', $month);
     $month = strtotime("+1 month", $month);
	}
	

	if($result){
		foreach ($result as $key => $value) {
			$moduleId = $value['moduleId'];
			
			$moduleName = $value['moduleName'];
			
			if($value['productSeries'])
			        $moduleName = "(".$value['productSeries'].") ".$value['moduleName'];
			        
			        
			$m = $value['month'];
			$dataSet[$moduleId]['module'] = $moduleName;
			$dataSet[$moduleId][$m] = array('num'=>$value['num'], 'point'=>$value['point']);
		}

		$i=0;
		foreach ($dataSet as $k=>$value) {

			$reportData[$i]['module'] = $value['module'];
			foreach ($monthArray as $m) {
				if(isset($value[$m])){
					$reportData[$i]['meta'][] = array('num'=>$value[$m]['num'], 'point'=>$value[$m]['point']);
				} else {
					$reportData[$i]['meta'][]= array('num'=>0, 'point'=>0);
				}
			}

			$i++;
		}
	}

	if(is_array($reportData)){
		$return = array('success'=>1, 'data'=>$reportData);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}


// start arpit_code 26_may_2023

if(isset($_GET['controller']) && $_GET['controller']=='ChartscanTrendModule'){
	$post = $api->jsonBody();
	$result = $report->scanTrendModuleChart($post);

	$startYear = $post['year'];
	$endYear = $post['year'] + 1;
	$start = $month = strtotime("$startYear-04-01");
	$end = strtotime("$endYear-03-30");
	
	while($month < $end)
	{
     $monthArray[] =  date('Y-m', $month);
     $month = strtotime("+1 month", $month);
	}


	if($result){
		// print_r($monthArray);
		
		foreach ($result as $key => $value) {
			 $m = $value['month'];
			
			$dataSet[$m] = array('num'=>$value['num'], 'point'=>$value['point']);
		}
		$i=0;
		

			$numarr =array();
			$pointarr =array();
			$max = 0;
			foreach ($monthArray as $m) {
				if(isset($dataSet[$m])){
					// $reportData[$i]['meta'][] = array('num'=>$dataSet[$m]['num'], 'point'=>$dataSet[$m]['point']);
					$numarr[$i] = intval($dataSet[$m]['num']);
					$pointarr[$i] =intval($dataSet[$m]['point']);
					if($max<intval($dataSet[$m]['point']))
					{

						$max = intval($dataSet[$m]['point']);
					}
				} else {
					$numarr[$i] = 0;
					$pointarr[$i] =0;
					// $reportData[$i]['meta'][]= array('num'=>0, 'point'=>0);
				}
				$i++;
			}

		
	}

	if(is_array($reportData)){
		$return = array('success'=>1, 'num'=>$numarr,'point'=>$pointarr,'startyear'=>$startYear,'endyear'=>$endYear,'max'=>$max);
	} else {
		$return = array('success'=>0,'num'=>$numarr,'point'=>$pointarr,'startyear'=>$startYear,'endyear'=>$endYear,'max'=>$max);
	}

	$api->setResponse($return, 200);
}

// end arpit_code 26_may_2023


if(isset($_GET['controller']) && $_GET['controller']=='ByDate_scanTrendModule'){
	error_reporting(E_ALL & ~E_NOTICE);
	$post = $api->jsonBody();
	$result = $report->scanTrendModuleByDate($post);

	$startYear = $post['year'];
	$endYear = $post['year'] + 1;
	$start = $month = strtotime("$startYear-04-01");
	$end = strtotime("$endYear-03-30");
	$selected_moth =  $post['month'];

	//if($selected_moth>3)
//	{
	$days  = cal_days_in_month(CAL_GREGORIAN,$selected_moth,$startYear);
	$start_date = $startYear.'-'.$selected_moth.'-'.'01';
	$end_date = $startYear.'-'.$selected_moth.'-'.$days;
	
/*}
	else
	{
	$days  = cal_days_in_month(CAL_GREGORIAN,$selected_moth,$endYear);
	$start_date = $endYear.'-'.$selected_moth.'-'.'01';
	$end_date = $endYear.'-'.$selected_moth.'-'.$days;

	

	}
	*/

	// echo $start_date;
	// echo $end_date;
	
	
	while($start_date <= $end_date)
	{
     $dateArray[] =  $start_date;
	 $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));
    
	}
	
	while($month < $end)
	{
     $monthArray[] =  date('Y-m', $month);
     $month = strtotime("+1 month", $month);
	}
	
		

	if($result){
		foreach ($result as $key => $value) {
			$moduleId = $value['moduleId'];
			
			$moduleName = $value['moduleName'];
			
			if(!empty($value['productSeries']))
			{
			        $moduleName = "(".$value['productSeries'].") ".$value['moduleName'];
			}
			        
			        
			$m = $value['sdate'];
			$dataSet[$moduleId]['module'] = $moduleName;
			$dataSet[$moduleId][$m] = array('num'=>$value['num'], 'point'=>$value['point']);
		}

		$i=0;
		foreach ($dataSet as $k=>$value) {

			$reportData[$i]['module'] = $value['module'];
			foreach ($dateArray as $m) {
				if(isset($value[$m])){
					$reportData[$i]['meta'][] = array('num'=>$value[$m]['num'], 'point'=>$value[$m]['point']);
				} else {
					$reportData[$i]['meta'][]= array('num'=>0, 'point'=>0);
				}
			}

			$i++;
		}
	}

	if(is_array($reportData)){
		$return = array('success'=>1, 'data'=>$reportData,'startdate'=>$start_date,'enddate'=>$end_date);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}
if(isset($_GET['controller']) && $_GET['controller']=='locationScanedTrend'){
	$post = $api->jsonBody();
	$result = $report->locationScanedTrend($post);

	$startYear = $post['year'];
	$endYear = $post['year'] + 1;
	$start = $month = strtotime("$startYear-04-01");
	$end = strtotime("$endYear-03-30");
	while($month < $end)
	{
	     $monthArray[] =  date('Y-m', $month);
	     $month = strtotime("+1 month", $month);
	}


	if($result){
		foreach ($result as $key => $value) {
			$state = $value['state'];
			$city = $value['city'];
			$m = $value['month'];

			if(!empty($post['state'])){
				$k = $value['city'].' '.$value['state'];
				$dataSet[$k][$m] = array('num'=>$value['num'], 'point'=>$value['point']);
			} else {
				$k = $value['state'];
				$dataSet[$k][$m] = array('num'=>$value['num'], 'point'=>$value['point']);
			}
		}

		$i=0;
		foreach ($dataSet as $k=>$meta) {

			$reportData[$i]['name'] = $k;
			foreach ($monthArray as $m) {
				if(isset($meta[$m])){
					$reportData[$i]['meta'][] = array('num'=>$meta[$m]['num'], 'point'=>$meta[$m]['point']);
				} else {
					$reportData[$i]['meta'][]= array('num'=>0, 'point'=>0);
				}
			}

			$i++;
		}
	}

	if(is_array($reportData)){
		$return = array('success'=>1, 'data'=>$reportData);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}



if(isset($_GET['controller']) && $_GET['controller']=='scanTrendCustomerMonthly'){
	
	$post = $api->jsonBody();
	$result = $report->scanTrendCustomerMonthly($post);
	//print_r($result);

	$startYear = $post['year'];	 

/*
	$endYear = $post['year'] + 1;
	$start = $month = strtotime("$startYear-04-01");
	$end = strtotime("$endYear-03-30");



	while($month < $end)
	{			    
		 $monthArray[] =  date('Y-m', $month);
	     $month = strtotime("+1 month", $month);
	}

	$currentYear = date('Y');
	*/
	//die;

 	
	$a_date = "2023-".$startYear."-01";
	$last_date =  date("t", strtotime($a_date));

	$monthArray=array();

for($d=1; $d<=$last_date; $d++)
{
    $time=mktime(12, 0, 0, date('m'), $d, date('Y'));
    if (date('m', $time)==date('m'))
        $monthArray[]=date('d', $time);
}




// echo "<pre>"; print_r($monthArray); die;

/* $monthArray = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
echo "<pre>"; print_r($monthArray); die;

*/
	if($result){
		foreach ($result as $key => $value) {

			$userId = $value['userId'];
			$userRoleId = $value['userRoleId'];
			$name = $value['name'];
			$m = $value['month'];
			$dealerCode = $value['dealerCode'];

			$dataSet[$userId]['name'] = $name;
			$dataSet[$userId]['dealerCode'] = $dealerCode;
			$dataSet[$userId]['mobile'] = $value['mobile'];
			$dataSet[$userId]['type'] = $ct[$userRoleId];
			$dataSet[$userId]['meta'][$m] = array('num'=>$value['num'], 'point'=>$value['point']);
		}

		$i=0;
		foreach ($dataSet as $k=>$u) {

			$reportData[$i]['name'] = $u['name'];
			$reportData[$i]['dealerCode'] = $u['dealerCode'];
			$reportData[$i]['mobile'] = $u['mobile'];
			$reportData[$i]['type'] = $u['type'];
			$meta = $u['meta'];
			
				foreach ($monthArray as $m) {
					if(isset($meta[$m])){
						$reportData[$i]['meta'][] = array('num'=>$meta[$m]['num'], 'point'=>$meta[$m]['point']);
					} else {
						$reportData[$i]['meta'][]= array('num'=>0, 'point'=>0);
					}
				}

			$i++;
		}
	}

	if(is_array($reportData)){
		$return = array('success'=>1, 'data'=>$reportData);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}


// start 15_may_2023

if(isset($_GET['controller']) && $_GET['controller']=='scanTrendCustomerByDate'){
	
	$post = $api->jsonBody();
	$result = $report->scanTrendCustomerByDate($post);
	//print_r($result);

	$startYear = $post['year'];
	$endYear = $post['year'];
	$start = $month = strtotime("$startYear-01-01");
	$end = strtotime("$endYear-12-31");
	$selected_moth =  $post['month'];

	/*
	if($selected_moth>3)
	{
	$days  = cal_days_in_month(CAL_GREGORIAN,$selected_moth,$startYear);
	$start_date = $startYear.'-'.$selected_moth.'-'.'01';
	$end_date = $startYear.'-'.$selected_moth.'-'.$days;
	}
	else
	{
	$days  = cal_days_in_month(CAL_GREGORIAN,$selected_moth,$endYear);
	$start_date = $endYear.'-'.$selected_moth.'-'.'01';
	$end_date = $endYear.'-'.$selected_moth.'-'.$days;

	}
	*/

	$days  = cal_days_in_month(CAL_GREGORIAN,$selected_moth,$startYear);
	$start_date = $startYear.'-'.$selected_moth.'-'.'01';
	$end_date = $startYear.'-'.$selected_moth.'-'.$days;
	// echo $start_date;
	// echo $end_date;
	
	
	while($start_date <= $end_date)
	{
     $dateArray[] =  $start_date;
	 $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));
    
	}
		
	while($month < $end)
	{
     $monthArray[] =  date('Y-m', $month);
     $month = strtotime("+1 month", $month);
	}	

	if($result){
		foreach ($result as $key => $value) {

			$userId = $value['userId'];
			$userRoleId = $value['userRoleId'];
			$name = $value['name'];
			$m = $value['sdate'];
			$dealerCode = $value['dealerCode'];

			$dataSet[$userId]['name'] = $name;
			$dataSet[$userId]['dealerCode'] = $dealerCode;
			$dataSet[$userId]['mobile'] = $value['mobile'];			
			$dataSet[$userId]['type'] = $ct[$userRoleId];
			$dataSet[$userId]['beat'] = $value['beat'];
			$dataSet[$userId]['meta'][$m] = array('num'=>$value['num'], 'point'=>$value['point']);
		}
//print_r($data)
		$i=0;

		// echo "<pre>"; print_r($dataSet);  die;
		// echo "<pre>"; print_r($dateArray); die;
		foreach ($dataSet as $k=>$u) {

			$reportData[$i]['name'] = $u['name'];
			$reportData[$i]['dealerCode'] = $u['dealerCode'];
			$reportData[$i]['mobile'] = $u['mobile'];
			$reportData[$i]['type'] = isset( $u['type']) ?  $u['type'] : '';
			$reportData[$i]['beat'] = $u['beat'];
			$meta = $u['meta'];
			
// start

		foreach ($u['meta'] as $v11) {
			$numData = 0;
			$pointData = 0; 
				//	$numData = var_dump($v11['num']);
				$arr11[] = $v11;
		  } 
		 
		foreach($arr11 as $dataCount){
			
			$numData = $numData +  (int)$dataCount['num'];
			$pointData = $pointData +  (int)$dataCount['point'];
		  
		}

	  	//  $objSheet->getCell(chr(70).$i)->setValue($numData);
	  	// $objSheet->getCell(chr(71).$i)->setValue($pointData);

			$reportData[$i]['meta'][] = array('num'=>$numData, 'point'=>$pointData);

	unset($arr11);

// end					

			foreach ($dateArray as $keys => $m) {

					if(isset($meta[$m])){
					
						$reportData[$i]['meta'][] = array('num'=>$meta[$m]['num'], 'point'=>$meta[$m]['point']);
					} else {
						$reportData[$i]['meta'][]= array('num'=>0, 'point'=>0);
					}

				
				}

			$i++;
		}
	}
	

// echo "<pre>"; print_r($reportData); die;
	if(is_array($reportData)){
		$return = array('success'=>1, 'data'=>$reportData);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}

// end 15_may_2023

if(isset($_GET['controller']) && $_GET['controller']=='scanTrendCustomer'){
	$post = $api->jsonBody();
	$result = $report->scanTrendCustomer($post);
	//print_r($result);


	$startYear = $post['year'];
	$endYear = $post['year'];
	
	$start = $month = strtotime("$startYear-01-01");
	$end = strtotime("$endYear-12-31");

/*
	$startMonth = $post['monthStart'];
	$startYear = $post['yearStart'];
	$endMonth = $post['monthEnd'];
	$endYear = $post['yearEnd'];
	    	
	$start = $month = strtotime("$startYear-$startMonth-01");

	 $end = strtotime("$endYear-$endMonth-30");

	while($month < $end)
	{
	     $monthArray[] =  date('Y-m', $month);
	     $month = strtotime("+1 month", $month);
	}
	*/
	while($month < $end)
	{
	     $monthArray[] =  date('Y-m', $month);
	     $month = strtotime("+1 month", $month);
	}
	
//echo "<pre>";	print_r($monthArray); die;

	if($result){
		foreach ($result as $key => $value) {

			$userId = $value['userId'];
			$userRoleId = $value['userRoleId'];
			$name = $value['name'];
			$m = $value['month'];
			$dealerCode = $value['dealerCode'];

			$dataSet[$userId]['name'] = $name;
			$dataSet[$userId]['dealerCode'] = $dealerCode;
			$dataSet[$userId]['mobile'] = $value['mobile'];
			$dataSet[$userId]['type'] = $ct[$userRoleId];
			$dataSet[$userId]['beat'] = $value['beat'];
			$dataSet[$userId]['meta'][$m] = array('num'=>$value['num'], 'point'=>$value['point']);
		}

		$i=0;
	
		foreach ($dataSet as $k=>$u) {
		 /*   
		    if($i==0)
		    {
		        $reportData[$i]['name'] = "<span style='color: #9EA4AB;  padding: 6px 10px; width: 100px; font-size: 13px; font-weight: 700; letter-spacing: 0.3px'>Name</span>";
			$reportData[$i]['dealerCode'] = "<span style='color: #9EA4AB;  padding: 6px 10px; width: 100px; font-size: 13px; font-weight: 700; letter-spacing: 0.3px'>Dealer Code</span>";
			$reportData[$i]['mobile'] = "<span style='color: #9EA4AB;  padding: 6px 10px; width: 100px; font-size: 13px; font-weight: 700; letter-spacing: 0.3px'>Mobile</span>";
			$reportData[$i]['type'] = "<span style='color: #9EA4AB;  padding: 6px 10px; width: 100px; font-size: 13px; font-weight: 700; letter-spacing: 0.3px'>User Type</span>";
			$reportData[$i]['beat'] = "<span style='color: #9EA4AB;  padding: 6px 10px; width: 100px; font-size: 13px; font-weight: 700; letter-spacing: 0.3px'>Distributor</span>";
				$metas = $u['metas'];
				foreach ($monthArray as $m) {
					if(isset($metas[$m])){
					    if($i==0)
					    {
					        $reportData[$i]['meta'][] = array('num'=>"<p>Coupons</p><p>".$m."</p>", 'point'=>"<p>Points</p><p>".$m."</p>");
					    }
					
					} else {
					    if($i==0)
					    {
						$reportData[$i]['meta'][]= array('num'=>"<p>Coupons</p><p>".$m."</p>", 'point'=>"<p>Points</p><p>".$m."</p>");
					    }
					}
				}
				
		        $i++;
		    } 
		       */

			$reportData[$i]['name'] = $u['name'];
			$reportData[$i]['dealerCode'] = $u['dealerCode'];
			$reportData[$i]['mobile'] = $u['mobile'];
			$reportData[$i]['type'] = $u['type'];
            $reportData[$i]['beat'] = $u['beat'];			
			$meta = $u['meta'];
				foreach ($monthArray as $m) {
					if(isset($meta[$m])){
					    
						$reportData[$i]['meta'][] = array('num'=>$meta[$m]['num'], 'point'=>$meta[$m]['point']);
					} else {
						$reportData[$i]['meta'][]= array('num'=>0, 'point'=>0);
					}
				}

			$i++;
		}
	}

	if(is_array($reportData)){
		$return = array('success'=>1, 'data'=>$reportData);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='pointSummary'){
	$post = $api->jsonBody();

	$result = $report->pointSummary($post);
	if($result){
		$i=0;
		foreach ($result as $key => $value) {
			$userRoleId = $value['userRoleId'];

			$customerName = (!empty($value['customerName'])) ? $value['customerName'].' ('.$value['customerMobile'].')' : $value['customerMobile'];

			$resultSet[$i]['customerName'] = $customerName;
			$resultSet[$i]['dealerCode'] = !empty($value['dealerCode'])?$value['dealerCode']:'NA';
			$resultSet[$i]['customerType'] = $ct[$userRoleId];
			
			$resultSet[$i]['scannedPoints'] = ($value['scannedPoints']!=null) ? $value['scannedPoints'] : 0;
			$resultSet[$i]['receivedPoints'] = ($value['receivedPoints']!=null) ? $value['receivedPoints'] : 0;
			$resultSet[$i]['balance'] = ($value['balance']!=null) ? $value['balance'] : 0;

			if($value['scannedPoints']!=null || $value['receivedPoints']!=null || $value['balance']!=null){
				$reportData[] = $resultSet[$i];
			}

			$i++;
		}
	}

	if(is_array($reportData) && count($reportData) > 0){
		$return = array('success'=>1, 'data'=>$reportData);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='multiScanList'){
	$post = $api->jsonBody();

	$result = $report->multiScanRecord($post);

	if(is_array($result) && count($result) > 0){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}



//encashmentPending
if(isset($_GET['controller']) && $_GET['controller']=='encashmentPending'){
	$post = $api->jsonBody();
	$scannedPending = $report->encashmentPending($post);
	$transferredPending = $report->encashmentPendingReceived($post);

$productSeries = "";

	if($scannedPending || $transferredPending){

		if(!empty($post['productId']) || !empty($post['subCategoryId'])){
			$x = 'productId';
			$n = 'productName';
			$ps = 'productSeries';
			
		} else if(!empty($post['categoryId'])){
			$x = 'subCategoryId';
			$n = 'subCategoryName';
		} else {
			$x = 'categoryId';
			$n = 'categorName';
		}

		if($scannedPending){
			foreach ($scannedPending as $v) {
				$k = $v[$x];
				
				$s = $v['userRoleId'];
				$sp[$k][$s] = array('num'=>$v['num'], 'point'=>$v['point']);
				
				$nm[$k] = $v[$n];

				$d[] = $k;
				
				if( $v[$ps])
				     $productSeries = "(".$v[$ps]." ) ";
				
			}
		}



		if($transferredPending){
			foreach ($transferredPending as $v) {
				$k = $v[$x];
				$s = $v['userRoleId'];
				$tp[$k][$s] = array('num'=>$v['num'], 'point'=>$v['point']);
				$nm[$k] = $v[$n];
				$d[] = $k;
				
		        if($v[$ps])
				    $productSeries = "(".$v[$ps]." ) ";
				
			}
		}
	}
	
	
	if(isset($d) && is_array($d)){
		$d = array_unique($d);
		$i=0;
		foreach ($d as $k) { 
			$numTotal=0;
			$pointsTotal=0;
			$reportData[$i]['title'] = $productSeries.$nm[$k];
			foreach ($ct as $userType => $type) {
			    
			    if($type == "Admin")
			            continue;
			            
				$num = 0;
				$point = 0;

				if(isset($sp[$k][$userType])){
					$num+=$sp[$k][$userType]['num'];
					$point+=$sp[$k][$userType]['point'];

				}

				if(isset($tp[$k][$userType])){
					$num+=$tp[$k][$userType]['num'];
					$point+=$tp[$k][$userType]['point'];
				}

				$reportData[$i]['meta'][] = array(
					'num'=> $num, 
					'points'=> $point
				);
				$numTotal+=$num;
				$pointsTotal+=$point;
		  }
		  $reportData[$i]['meta'][] = array('num'=>$numTotal, 'points'=>$pointsTotal);
		  $i++;
		}
	}

/*
	$head = array(
		'title', 
		'Authorised Distributor', 
		'Distributor', 
		'Retailer', 
		'Customer', 
		'Mechanic', 
		'Sales Staff', 
		'Engg. Workshop', 
		'Other', 
		'Auth. Retailer', 
		'Deactivated',
		'total'
	);
*/
	$head = array(
		'title', 
		'Main Distributor', 
		'Distributor', 
		'Retailer', 
		'Customer',
		'Paras Team', 
		'Tech Team',  
		'Other', 
		'Auth. Retailer', 
		'Deactivated',
		'total'
	);

	if($scannedPending || $transferredPending){
		$return = array('success'=>1, 'head'=>$head, 'data'=>$reportData, 'head'=>$head);
	} else {
		$return = array('success'=>0, 'head'=>$head, 'data'=>array());
	}

	$api->setResponse($return, 200);
}





//marketInventorySummary
if(isset($_GET['controller']) && $_GET['controller']=='marketInventorySummary'){
	$post = $api->jsonBody();

	$totalIssuedPoints = $report->getTotalIssuedPoints($post);
	$totalActivatedPoints = $report->getTotalActivatedPoints($post);
//	$totalEncashmentPending = $report->getTotalEncashmentPending($post);

	$currentYearScanned = $report->getCurrentYearScanned($post);
	$currentMonthScanned = $report->getCurrentMonthScanned($post);
	$yesterdayScanned = $report->getYesterdayScanned($post);
	$todayScanned = $report->getTodayScanned($post);

	
	$previousYearUnScanned = $report->getPreviousYearUnScanned($post);
	$currentYearUnScanned = $report->getCurrentYearUnScanned($post);
	$totalUnScanned = $report->getTotalUnScanned($post);

	
	if($totalIssuedPoints){
		foreach ($totalIssuedPoints as $value) {
			$k = $value['moduleId']; 
			$issued[$k]['num'] = $value['num'];
			$issued[$k]['point'] = number_format($value['point'],2);
		}
	}

	if($totalActivatedPoints){
		foreach ($totalActivatedPoints as $value) {
			$k = $value['moduleId']; 
			$activated[$k]['num'] = $value['num'];
			$activated[$k]['point'] = number_format($value['point'],2);
		}
	}

/*
	if($totalEncashmentPending){
		foreach ($totalEncashmentPending as $value) {
			$k = $value['moduleId']; 
			$encashment[$k]['num'] = $value['num'];
			$encashment[$k]['point'] = number_format($value['point'],2);
		}
	}
*/

    if($todayScanned){
		foreach ($todayScanned as $value) {
			$k = $value['moduleId']; 
			$tdSnanned[$k]['num'] = $value['num'];
			$tdSnanned[$k]['point'] = number_format($value['point'],2);
		}
	}

	if($yesterdayScanned){
		foreach ($yesterdayScanned as $value) {
			$k = $value['moduleId']; 
			$ydSnanned[$k]['num'] = $value['num'];
			$ydSnanned[$k]['point'] = number_format($value['point'],2);
		}
	}

	if($currentMonthScanned){
		foreach ($currentMonthScanned as $value) {
			$k = $value['moduleId']; 
			$cmScanned[$k]['num'] = $value['num'];
			$cmScanned[$k]['point'] = number_format($value['point'],2);
		}
	}

	if($currentYearScanned){
		foreach ($currentYearScanned as $value) {
			$k = $value['moduleId']; 
			$cyScanned[$k]['num'] = $value['num'];
			$cyScanned[$k]['point'] = number_format($value['point'],2);
		}
	}

	if($previousYearUnScanned){
		foreach ($previousYearUnScanned as $value) {
			$k = $value['moduleId']; 
			$pyUnScanned[$k]['num'] = $value['num'];
			$pyUnScanned[$k]['point'] = number_format($value['point'],2);
		}
	}

	if($currentYearUnScanned){
		foreach ($currentYearUnScanned as $value) {
			$k = $value['moduleId']; 
			$cyUnScanned[$k]['num'] = $value['num'];
			$cyUnScanned[$k]['point'] = number_format($value['point'],2);
		}
	}

	if($totalUnScanned){
		foreach ($totalUnScanned as $value) {
			$k = $value['moduleId']; 
			$ttlUnScanned[$k]['num'] = $value['num'];
			$ttlUnScanned[$k]['point'] = number_format($value['point'],2);
		}
	}



	$getModuleNames = $report->getModuleNames($post);
	
	if($getModuleNames){
		$i=0;
		foreach ($getModuleNames as $key => $value) {

			$k =  $value['id'];
			$reportData[$i]['id'] = $value['id'];
			$reportData[$i]['title'] = $value['title'];
			$reportData[$i]['productSeries'] = $value['product_series'];

			if(isset($issued[$k])){
				$reportData[$i]['issued']['num'] = $issued[$k]['num'];
				$reportData[$i]['issued']['point'] = $issued[$k]['point'];
			} else {
				$reportData[$i]['issued']['num'] = 0;
				$reportData[$i]['issued']['point'] = 0;
			}

			if(isset($activated[$k])){
				$reportData[$i]['activated']['num'] = $activated[$k]['num'];
				$reportData[$i]['activated']['point'] = $activated[$k]['point'];
			} else {
				$reportData[$i]['activated']['num'] = 0;
				$reportData[$i]['activated']['point'] = 0;
			}

/*
			if(isset($encashment[$k])){
				$reportData[$i]['encashment']['num'] = $encashment[$k]['num'];
				$reportData[$i]['encashment']['point'] = $encashment[$k]['point'];
			} else {
				$reportData[$i]['encashment']['num'] = 0;
				$reportData[$i]['encashment']['point'] = 0;
			}
*/

            if(isset($tdSnanned[$k])){
				$reportData[$i]['scanned']['today']['num'] = $tdSnanned[$k]['num'];
				$reportData[$i]['scanned']['today']['point'] = $tdSnanned[$k]['point'];
			} else {
				$reportData[$i]['scanned']['today']['num'] = 0;
				$reportData[$i]['scanned']['today']['point'] = 0;
			}

			if(isset($ydSnanned[$k])){
				$reportData[$i]['scanned']['yesterday']['num'] = $ydSnanned[$k]['num'];
				$reportData[$i]['scanned']['yesterday']['point'] = $ydSnanned[$k]['point'];
			} else {
				$reportData[$i]['scanned']['yesterday']['num'] = 0;
				$reportData[$i]['scanned']['yesterday']['point'] = 0;
			}
			
			

			if(isset($cmScanned[$k])){
				$reportData[$i]['scanned']['currentMonth']['num'] = $cmScanned[$k]['num'];
				$reportData[$i]['scanned']['currentMonth']['point'] = $cmScanned[$k]['point'];
			} else {
				$reportData[$i]['scanned']['currentMonth']['num'] = 0;
				$reportData[$i]['scanned']['currentMonth']['point'] = 0;
			}

			if(isset($cyScanned[$k])){
				$reportData[$i]['scanned']['currentYear']['num'] = $cyScanned[$k]['num'];
				$reportData[$i]['scanned']['currentYear']['point'] = $cyScanned[$k]['point'];
			} else {
				$reportData[$i]['scanned']['currentYear']['num'] = 0;
				$reportData[$i]['scanned']['currentYear']['point'] = 0;
			}


			if(isset($pyUnScanned[$k])){
				$reportData[$i]['unScanned']['previousYear']['num'] = $pyUnScanned[$k]['num'];
				$reportData[$i]['unScanned']['previousYear']['point'] = $pyUnScanned[$k]['point'];
			} else {
				$reportData[$i]['unScanned']['previousYear']['num'] = 0;
				$reportData[$i]['unScanned']['previousYear']['point'] = 0;
			}
			
			if(isset($cyUnScanned[$k])){
				$reportData[$i]['unScanned']['currentYear']['num'] = $cyUnScanned[$k]['num'];
				$reportData[$i]['unScanned']['currentYear']['point'] = $cyUnScanned[$k]['point'];
			} else {
				$reportData[$i]['unScanned']['currentYear']['num'] = 0;
				$reportData[$i]['unScanned']['currentYear']['point'] = 0;
			}
			if(isset($ttlUnScanned[$k])){
				$reportData[$i]['unScanned']['total']['num'] = $ttlUnScanned[$k]['num'];
				$reportData[$i]['unScanned']['total']['point'] =$ttlUnScanned[$k]['point'];
			} else {
				$reportData[$i]['unScanned']['total']['num'] = 0;
				$reportData[$i]['unScanned']['total']['point'] = 0;
			}

			$i++;
		}
	}


	if(is_array($reportData)){
		$return = array('success'=>1, 'data'=>$reportData);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='couponTrialAudit'){

	$couponId = 0;
	$isCouponScanned = 0;
	$isCouponTransfred = 0;


	$post = $api->jsonBody();
	$couponCode = $post['couponCode'];
	$couponData = $report->couponData($couponCode);
	if($couponData){

		$couponId = $couponData['couponId'];

		$reportData[] = array(
			'date' => $couponData['createdOn'],
			'status' => 'Generate',
			'ownerName' => 'Manufacture',
			'customerType' => 'Manufacture',
		);

		$reportData[] = array(
			'date' => $couponData['activatedOn'],
			'status' => 'Activate',
			'ownerName' => 'Manufacture',
			'customerType' => 'Manufacture',
		);

		$couponScanned = $report->isCouponScanned($couponId);
		if($couponScanned){

			$isCouponScanned = 1;

			if(!empty($couponScanned['name']) && !empty($couponScanned['mobile'])){
				$ownerName = $couponScanned['name'].' ('.$couponScanned['mobile'].')';
			} else if(!empty($couponScanned['name']) && empty($couponScanned['mobile'])) {
				$ownerName = $couponScanned['name'];
			} else {
				$ownerName = $couponScanned['mobile'];
			}

			$reportData[] = array(
				'date' => $couponScanned['scannedOn'],
				'status' => 'Scanned',
				'ownerName' => $ownerName,
				'customerType' => $ct[$couponScanned['userRoleId']],
			);


			if($couponScanned['isTransferred']==1){

				$isCouponTransfred = 1;

				$transferredArray = $report->couponTransferredTrial($couponId);
				if($transferredArray){
					foreach ($transferredArray as $key => $value) {

							if(!empty($value['name']) && !empty($value['mobile'])){
								$ownerName = $value['name'].' ('.$value['mobile'].')';
							} else if(!empty($value['name']) && empty($value['mobile'])) {
								$ownerName = $value['name'];
							} else {
								$ownerName = $value['mobile'];
							}

							$reportData[] = array(
								'date' => $value['createdOn'],
								'status' => 'Transferred',
								'ownerName' => $ownerName,
								'customerType' => $ct[$value['userRoleId']],
							);
					}
				}
			}
		}
	}

	if(is_array($reportData) && count($reportData) > 0){
		$return = array(
			'success'=>1, 
			'data'=>$reportData, 
			'couponId'=>$couponId, 
			'isCouponScanned'=>$isCouponScanned, 
			'isCouponTransfred'=>$isCouponTransfred
		);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='userPointStatment'){

    //$type==4  -- Gift Redeem 
    //$type==5 - Gift return back point
    
    $data = array();
	$profile = array();

    require_once CLASS_DIR.'/setting.php';
    $setting = new setting();
    
    $adminPointReceiver = $setting->getSettingMeta('ADMIN_POINT_RECEIVER');

	$post = $api->jsonBody();
	$mobile = (isset($post['mobile']) && !empty($post['mobile'])) ? $post['mobile'] : false;
	$pointSdate = (isset($post['pointSdate']) && !empty($post['pointSdate'])) ? $post['pointSdate'] : false;
	$pointEdate = (isset($post['pointEdate']) && !empty($post['pointEdate'])) ? $post['pointEdate'] : false;

	
	if($mobile){
		$user = new users();
	  $profile = $user->getUserProfileByMobile($mobile);
		if($profile){
			$userId = $profile['id'];

			$profile['roleName'] = $ct[$profile['user_role_id']];

			$dateResult = $report->getPointLedger($userId,$pointSdate,$pointEdate);
			
			if($dateResult){

				$totalScan = $report->userTotalScan($userId);
				$totalBonus = $report->userTotalBonusCouponGenerated($userId);
				
				$totalTran = $report->userTotalTransfer($userId);
				
			//	$data = $dateResult;        // should not hide
				
			
 // start hide from here
				foreach ($dateResult as $value) {
				    
					$date = $value['createdDate'];
					$type = $value['type'];
					$refIds = $value['refId'];
					
					if($type==1 || $type==2 || $type==4 ||  $type==5 || $type==6){

						if(isset($dataArray[$date][$type])){
							$dataArray[$date][$type]['points'] = $dataArray[$date][$type]['points'] + $value['points'];
						} else {
							$dataArray[$date][$type] = $value;
							if($type==1){
								$dataArray[$date][$type]['totalScan'] = (isset($totalScan[$date])) ? $totalScan[$date] : 0;
							}
							if($type==6){
								$dataArray[$date][$type]['totalBonus'] = (isset($totalBonus[$date])) ? $totalBonus[$date] : 0;
							}
						}
						
						
					} else {
					

						$value['transferTo'] = $totalTran[$refIds]['name'];
						$value['refId'] = '#'.$totalTran[$refIds]['ref_no'];
						$value['mobile'] = $totalTran[$refIds]['mobile'];
						$dataArray[$date][$type][] = $value;
					}
				}
				
				
				

				//$i=0;
				foreach ($dataArray as $date => $dataSet) {
					foreach ($dataSet as $type => $value) {
						if($type==3){
							foreach ($value as $transfer) {
								$data[] = $transfer;
							}
						} else {
							$data[] = $value;
						}
					}
				}

// end hide

				$success = 1;
				$message = "Success";

			} else {
				$success = 0;
				$message = "No result found.";
			}

		} else {
			$success = 0;
			$message = "User data not found.";
		}

	} else {
		$success = 0;
		$message = "Mobile number missing.";
	}
	
	if($adminPointReceiver == $mobile)
	   $mobileMatchAdminReceiver = 'Yes';
    else
	   $mobileMatchAdminReceiver = 'No';
	   

	$return = array('success'=>$success, 'data'=>$data, 'profile'=>$profile,'mobileMatchAdminReceiver'=>$mobileMatchAdminReceiver, 'message'=>$message);
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='userPointSummery'){

	$post = $api->jsonBody();
	$userId = (isset($post['user']) && !empty($post['user'])) ? $post['user'] : false;
	$type = (isset($post['type']) && !empty($post['type'])) ? $post['type'] : false;
	$date = (isset($post['date']) && !empty($post['date'])) ? $api->dateReplace($post['date']) : false;
	
 	$refId = (isset($post['refId']) && !empty($post['refId'])) ? $post['refId'] : "";
	

	$data = array();
	

	if($userId){
	    
	  	if($type==1)
	  		$data = $report->scanPointDetail($userId, $date);
	  		
	  	 else if($type==2)
	  		$data = $report->receivedPointDetail($userId, $date);
	  	
	  	else if($type==4 )
	  		$data = $report->giftRedeemDetail($userId, $refId);
	  		
	  	else if( $type==5 )
	  		$data = $report->giftRetrunPoint($userId, $refId);
		else if($type==6)
	  		$data = $report->bonusPointDetail($userId, $date);

			$success = 1;
			$message = "Success";

	} else {
		$success = 0;
		$message = "User ID missing.";
	}

	$return = array('success'=>$success, 'data'=>$data, 'message'=>$message);
	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='scanAlert'){

	$post = $api->jsonBody();
	$date = (isset($post['date']) && !empty($post['date'])) ? $post['date'] : false;
	$data = array();
	$profile = array();

	if($date){
	  $data = $report->getScanLimitAlert($date);
		if($data){

			$i=0;
			foreach ($data as $key => $value) {
				$data[$i]['userType'] = isset($ct[$value['type']]) ? $ct[$value['type']] : '';
				unset($data[$i]['type']);
			}

			$success = 1;
			$message = "Success";
		} else {
			$success = 0;
			$message = "User data not found.";
		}

	} else {
		$success = 0;
		$message = "Date Missing.";
	}

	$return = array('success'=>$success, 'data'=>$data, 'message'=>$message);
	$api->setResponse($return, 200);
}


// ======================== DOWNLOAD ======================== //



if(isset($_GET['controller']) && $_GET['controller']=='marketInventorySummaryDownload'){
	$post = $api->jsonBody();

	$totalIssuedPoints = $report->getTotalIssuedPoints($post);
	$totalActivatedPoints = $report->getTotalActivatedPoints($post);
//	$totalEncashmentPending = $report->getTotalEncashmentPending($post);

	$currentYearScanned = $report->getCurrentYearScanned($post);
	$currentMonthScanned = $report->getCurrentMonthScanned($post);
	$yesterdayScanned = $report->getYesterdayScanned($post);
	$todayScanned = $report->getTodayScanned($post);

	$previousYearUnScanned = $report->getPreviousYearUnScanned($post);
	$currentYearUnScanned = $report->getCurrentYearUnScanned($post);
	$totalUnScanned = $report->getTotalUnScanned($post);

	if($totalIssuedPoints){
		foreach ($totalIssuedPoints as $value) {
			$k = $value['moduleId']; 
			$issued[$k]['num'] = $value['num'];
			$issued[$k]['point'] = $value['point'];
		}
	}

	if($totalActivatedPoints){
		foreach ($totalActivatedPoints as $value) {
			$k = $value['moduleId']; 
			$activated[$k]['num'] = $value['num'];
			$activated[$k]['point'] = $value['point'];
		}
	}

/*
	if($totalEncashmentPending){
		foreach ($totalEncashmentPending as $value) {
			$k = $value['moduleId']; 
			$encashment[$k]['num'] = $value['num'];
			$encashment[$k]['point'] = $value['point'];
		}
	}
	
*/

	if($todayScanned){
		foreach ($todayScanned as $value) {
			$k = $value['moduleId']; 
			$tdSnanned[$k]['num'] = $value['num'];
			$tdSnanned[$k]['point'] = number_format($value['point'],2);
		}
	}

	if($yesterdayScanned){
		foreach ($yesterdayScanned as $value) {
			$k = $value['moduleId']; 
			$ydSnanned[$k]['num'] = $value['num'];
			$ydSnanned[$k]['point'] = $value['point'];
		}
	}

	if($currentMonthScanned){
		foreach ($currentMonthScanned as $value) {
			$k = $value['moduleId']; 
			$cmScanned[$k]['num'] = $value['num'];
			$cmScanned[$k]['point'] = $value['point'];
		}
	}

	if($currentYearScanned){
		foreach ($currentYearScanned as $value) {
			$k = $value['moduleId']; 
			$cyScanned[$k]['num'] = $value['num'];
			$cyScanned[$k]['point'] = $value['point'];
		}
	}

	if($previousYearUnScanned){
		foreach ($previousYearUnScanned as $value) {
			$k = $value['moduleId']; 
			$pyUnScanned[$k]['num'] = $value['num'];
			$pyUnScanned[$k]['point'] = $value['point'];
		}
	}

	if($currentYearUnScanned){
		foreach ($currentYearUnScanned as $value) {
			$k = $value['moduleId']; 
			$cyUnScanned[$k]['num'] = $value['num'];
			$cyUnScanned[$k]['point'] = $value['point'];
		}
	}

	if($totalUnScanned){
		foreach ($totalUnScanned as $value) {
			$k = $value['moduleId']; 
			$ttlUnScanned[$k]['num'] = $value['num'];
			$ttlUnScanned[$k]['point'] = $value['point'];
		}
	}

	$getModuleNames = $report->getModuleNames($post);
	if($getModuleNames){
		$i=0;
		foreach ($getModuleNames as $key => $value) {

			$k =  $value['id'];
			$reportData[$i]['id'] = $value['id'];
			$reportData[$i]['title'] = $value['title'];
			$reportData[$i]['productSeries'] = $value['product_series'];

			if(isset($issued[$k])){
				$reportData[$i]['issued']['num'] = $issued[$k]['num'];
				$reportData[$i]['issued']['point'] = $issued[$k]['point'];
			} else {
				$reportData[$i]['issued']['num'] = 0;
				$reportData[$i]['issued']['point'] = 0;
			}

			if(isset($activated[$k])){
				$reportData[$i]['activated']['num'] = $activated[$k]['num'];
				$reportData[$i]['activated']['point'] = $activated[$k]['point'];
			} else {
				$reportData[$i]['activated']['num'] = 0;
				$reportData[$i]['activated']['point'] = 0;
			}
/*
			if(isset($encashment[$k])){
				$reportData[$i]['encashment']['num'] = $encashment[$k]['num'];
				$reportData[$i]['encashment']['point'] = $encashment[$k]['point'];
			} else {
				$reportData[$i]['encashment']['num'] = 0;
				$reportData[$i]['encashment']['point'] = 0;
			}
			
*/

			if(isset($tdSnanned[$k])){
				$reportData[$i]['scanned']['today']['num'] = $tdSnanned[$k]['num'];
				$reportData[$i]['scanned']['today']['point'] = $tdSnanned[$k]['point'];
			} else {
				$reportData[$i]['scanned']['today']['num'] = 0;
				$reportData[$i]['scanned']['today']['point'] = 0;
			}

			if(isset($ydSnanned[$k])){
				$reportData[$i]['scanned']['yesterday']['num'] = $ydSnanned[$k]['num'];
				$reportData[$i]['scanned']['yesterday']['point'] = $ydSnanned[$k]['point'];
			} else {
				$reportData[$i]['scanned']['yesterday']['num'] = 0;
				$reportData[$i]['scanned']['yesterday']['point'] = 0;
			}

			if(isset($cmScanned[$k])){
				$reportData[$i]['scanned']['currentMonth']['num'] = $cmScanned[$k]['num'];
				$reportData[$i]['scanned']['currentMonth']['point'] = $cmScanned[$k]['point'];
			} else {
				$reportData[$i]['scanned']['currentMonth']['num'] = 0;
				$reportData[$i]['scanned']['currentMonth']['point'] = 0;
			}

			if(isset($cyScanned[$k])){
				$reportData[$i]['scanned']['currentYear']['num'] = $cyScanned[$k]['num'];
				$reportData[$i]['scanned']['currentYear']['point'] = $cyScanned[$k]['point'];
			} else {
				$reportData[$i]['scanned']['currentYear']['num'] = 0;
				$reportData[$i]['scanned']['currentYear']['point'] = 0;
			}


			if(isset($pyUnScanned[$k])){
				$reportData[$i]['unScanned']['previousYear']['num'] = $pyUnScanned[$k]['num'];
				$reportData[$i]['unScanned']['previousYear']['point'] = $pyUnScanned[$k]['point'];
			} else {
				$reportData[$i]['unScanned']['previousYear']['num'] = 0;
				$reportData[$i]['unScanned']['previousYear']['point'] = 0;
			}
			if(isset($cyUnScanned[$k])){
				$reportData[$i]['unScanned']['currentYear']['num'] = $cyUnScanned[$k]['num'];
				$reportData[$i]['unScanned']['currentYear']['point'] = $cyUnScanned[$k]['point'];
			} else {
				$reportData[$i]['unScanned']['currentYear']['num'] = 0;
				$reportData[$i]['unScanned']['currentYear']['point'] = 0;
			}
			if(isset($ttlUnScanned[$k])){
				$reportData[$i]['unScanned']['total']['num'] = $ttlUnScanned[$k]['num'];
				$reportData[$i]['unScanned']['total']['point'] =$ttlUnScanned[$k]['point'];
			} else {
				$reportData[$i]['unScanned']['total']['num'] = 0;
				$reportData[$i]['unScanned']['total']['point'] = 0;
			}

			$i++;
		}
	}

	if(is_array($reportData)){


		$objPHPExcel = new PHPExcel();
		$objSheet = $objPHPExcel->getActiveSheet();
		$objSheet->setTitle('Report');

		$style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
	  );

	  $objSheet->setCellValue('A1', 'Module');
	  $objSheet->mergeCells('A1:A3');
	  
	  $objSheet->setCellValue('B1', 'Total Issued');
	  $objSheet->mergeCells('B1:C1');

	  $objSheet->setCellValue('D1', 'Activated');
	  $objSheet->mergeCells('D1:E1');

	  $objSheet->setCellValue('F1', 'Scanned');
	  $objSheet->mergeCells('F1:M1');

	  $objSheet->setCellValue('N1', 'Unscanned');
	  $objSheet->mergeCells('N1:S1');

//	  $objSheet->setCellValue('R1', 'Encashment Pending');
//	  $objSheet->mergeCells('R1:S2');	 

	  $objSheet->setCellValue('B2', 'Current Year');
	  $objSheet->mergeCells('B2:C2');

	  $objSheet->setCellValue('D2', 'Current Year');
	  $objSheet->mergeCells('D2:E2');

	  $objSheet->setCellValue('F2', 'Today');
	  $objSheet->mergeCells('F2:G2');
	  
	  $objSheet->setCellValue('H2', 'Yesterday');
	  $objSheet->mergeCells('H2:I2');

	  $objSheet->setCellValue('J2', 'Current Month');
	  $objSheet->mergeCells('J2:K2');

	  $objSheet->setCellValue('L2', 'Current Year');
	  $objSheet->mergeCells('L2:M2');

	  $objSheet->setCellValue('N2', 'Previous Year');
	  $objSheet->mergeCells('N2:O2');

	  $objSheet->setCellValue('P2', 'Curent Year');
	  $objSheet->mergeCells('P2:Q2');

	  $objSheet->setCellValue('R2', 'Total');
	  $objSheet->mergeCells('R2:S2');
 


	  $objSheet->setCellValue('B3', 'Nos');
	  $objSheet->setCellValue('C3', 'Point');

	  $objSheet->setCellValue('D3', 'Nos');
	  $objSheet->setCellValue('E3', 'Point');

	  $objSheet->setCellValue('F3', 'Nos');
	  $objSheet->setCellValue('G3', 'Point');

	  $objSheet->setCellValue('H3', 'Nos');
	  $objSheet->setCellValue('I3', 'Point');

	  $objSheet->setCellValue('J3', 'Nos');
	  $objSheet->setCellValue('K3', 'Point');

	  $objSheet->setCellValue('L3', 'Nos');
	  $objSheet->setCellValue('M3', 'Point');

	  $objSheet->setCellValue('N3', 'Nos');
	  $objSheet->setCellValue('O3', 'Point');

	  $objSheet->setCellValue('P3', 'Nos');
	  $objSheet->setCellValue('Q3', 'Point');

	  $objSheet->setCellValue('R3', 'Nos');
	  $objSheet->setCellValue('S3', 'Point');

	  $objSheet->getStyle("A1:S3")->applyFromArray($style);

	  $i=4;
	  foreach ($reportData as $value) {

	  	$objSheet->getCell(chr(65).$i)->setValue("(".$value['productSeries'].") ".$value['title']);

	  	$objSheet->getCell(chr(66).$i)->setValue($value['issued']['num']);
	  	$objSheet->getCell(chr(67).$i)->setValue($value['issued']['point']);

	  	$objSheet->getCell(chr(68).$i)->setValue($value['activated']['num']);
	  	$objSheet->getCell(chr(69).$i)->setValue($value['activated']['point']);

	  	// SCANNED

		$objSheet->getCell(chr(70).$i)->setValue($value['scanned']['today']['num']);
	  	$objSheet->getCell(chr(71).$i)->setValue($value['scanned']['today']['point']);
	  	$objSheet->getCell(chr(72).$i)->setValue($value['scanned']['yesterday']['num']);
	  	$objSheet->getCell(chr(73).$i)->setValue($value['scanned']['yesterday']['point']);
	  	$objSheet->getCell(chr(74).$i)->setValue($value['scanned']['currentMonth']['num']);
	  	$objSheet->getCell(chr(75).$i)->setValue($value['scanned']['currentMonth']['point']);
	  	$objSheet->getCell(chr(76).$i)->setValue($value['scanned']['currentYear']['num']);
	  	$objSheet->getCell(chr(77).$i)->setValue($value['scanned']['currentYear']['point']);


	  	$objSheet->getCell(chr(78).$i)->setValue($value['unScanned']['previousYear']['num']);
	  	$objSheet->getCell(chr(79).$i)->setValue($value['unScanned']['previousYear']['point']);
	  	$objSheet->getCell(chr(80).$i)->setValue($value['unScanned']['currentYear']['num']);
	  	$objSheet->getCell(chr(81).$i)->setValue($value['unScanned']['currentYear']['point']);
	  	$objSheet->getCell(chr(82).$i)->setValue($value['unScanned']['total']['num']);
	  	$objSheet->getCell(chr(83).$i)->setValue($value['unScanned']['total']['point']);

//	  	$objSheet->getCell(chr(82).$i)->setValue($value['encashment']['num']);
//	  	$objSheet->getCell(chr(83).$i)->setValue($value['encashment']['point']);

	  	$i++;
	  }


		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output'); 
		$xlsData = ob_get_contents();
		ob_end_clean();

		$return =  array(
		  'success' => 1,
		  'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);

	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}




if(isset($_GET['controller']) && $_GET['controller']=='scanTrendModuleDownload'){
	$post = $api->jsonBody();
	$result = $report->scanTrendModule($post);

	$startYear = $post['year'];
	$endYear = $post['year'] + 1;
	$start = $month = strtotime("$startYear-04-01");
	$end = strtotime("$endYear-03-30");
	while($month < $end)
	{
     $monthArray[] =  date('Y-m', $month);
     $month = strtotime("+1 month", $month);
	}


	if($result){
		foreach ($result as $key => $value) {
			$moduleId = $value['moduleId'];
			
			$moduleName = $value['moduleName'];
			
		if($value['productSeries'])
			$moduleName = "(".$value['productSeries'].") ".$value['moduleName'];
			        
			
			$m = $value['month'];
			$dataSet[$moduleId]['module'] = $moduleName;
			$dataSet[$moduleId][$m] = array('num'=>$value['num'], 'point'=>$value['point']);
		}

		$i=0;
		foreach ($dataSet as $k=>$value) {

			$reportData[$i]['module'] = $value['module'];
			foreach ($monthArray as $m) {
				if(isset($value[$m])){
					$reportData[$i]['meta'][] = array('num'=>$value[$m]['num'], 'point'=>$value[$m]['point']);
				} else {
					$reportData[$i]['meta'][]= array('num'=>0, 'point'=>0);
				}
			}

			$i++;
		}
	}

	if(is_array($reportData)){

		$objPHPExcel = new PHPExcel();
		$objSheet = $objPHPExcel->getActiveSheet();
		$objSheet->setTitle('Report');

		$style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
	  );

	  $objSheet->setCellValue('A1', 'Model');
	  $objSheet->mergeCells('A1:A2');
	  $objSheet->getStyle("A1:Y2")->applyFromArray($style);

	  $objSheet->setCellValue('B1', 'APRIL');
	  $objSheet->mergeCells('B1:C1');

	  $objSheet->setCellValue('D1', 'MAY');
	  $objSheet->mergeCells('D1:E1');

	  $objSheet->setCellValue('F1', 'JUNE');
	  $objSheet->mergeCells('F1:G1');

	  $objSheet->setCellValue('H1', 'JULY');
	  $objSheet->mergeCells('H1:I1');

	  $objSheet->setCellValue('J1', 'AUGUST');
	  $objSheet->mergeCells('J1:K1');

	  $objSheet->setCellValue('L1', 'SEPTEMBER');
	  $objSheet->mergeCells('L1:M1');

	  $objSheet->setCellValue('N1', 'OCTOBER');
	  $objSheet->mergeCells('N1:O1');

	  $objSheet->setCellValue('P1', 'NOVEMBER');
	  $objSheet->mergeCells('P1:Q1');

	  $objSheet->setCellValue('R1', 'DECEMBER');
	  $objSheet->mergeCells('R1:S1');

	  $objSheet->setCellValue('T1', 'JANUARY');
	  $objSheet->mergeCells('T1:U1');

	  $objSheet->setCellValue('V1', 'FEBRUARY');
	  $objSheet->mergeCells('V1:W1');

	  $objSheet->setCellValue('X1', 'MARCH');
	  $objSheet->mergeCells('X1:Y1');

	  $objSheet->setCellValue('B2', 'NOS');
	  $objSheet->setCellValue('C2', 'AMT');
	  $objSheet->setCellValue('D2', 'NOS');
	  $objSheet->setCellValue('E2', 'AMT');
	  $objSheet->setCellValue('F2', 'NOS');
	  $objSheet->setCellValue('G2', 'AMT');
	  $objSheet->setCellValue('H2', 'NOS');
	  $objSheet->setCellValue('I2', 'AMT');
	  $objSheet->setCellValue('J2', 'NOS');
	  $objSheet->setCellValue('K2', 'AMT');
	  $objSheet->setCellValue('L2', 'NOS');
	  $objSheet->setCellValue('M2', 'AMT');
	  $objSheet->setCellValue('N2', 'NOS');
	  $objSheet->setCellValue('O2', 'AMT');
	  $objSheet->setCellValue('P2', 'NOS');
	  $objSheet->setCellValue('Q2', 'AMT');
	  $objSheet->setCellValue('R2', 'NOS');
	  $objSheet->setCellValue('S2', 'AMT');
	  $objSheet->setCellValue('T2', 'NOS');
	  $objSheet->setCellValue('U2', 'AMT');
	  $objSheet->setCellValue('V2', 'NOS');
	  $objSheet->setCellValue('W2', 'AMT');
	  $objSheet->setCellValue('X2', 'NOS');
	  $objSheet->setCellValue('Y2', 'AMT');

	  $i=3;
	  foreach ($reportData as $value) {

	  	$objSheet->getCell(chr(65).$i)->setValue($value['module']);
	  	$char = 66;
	  	foreach ($value['meta'] as $v) {
	  		$objSheet->getCell(chr($char).$i)->setValue($v['num']);
	  		$char++;

	  		$objSheet->getCell(chr($char).$i)->setValue($v['point']);
	  		$char++;
	  	}
	  	$i++;
	  }

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output'); 
		$xlsData = ob_get_contents();
		ob_end_clean();

		$return =  array(
		  'success' => 1,
		  'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);

	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}






if(isset($_GET['controller']) && $_GET['controller']=='locationScanedTrendDownload'){
	$post = $api->jsonBody();
	$result = $report->locationScanedTrend($post);

	$startYear = $post['year'];
	$endYear = $post['year'] + 1;
	$start = $month = strtotime("$startYear-04-01");
	$end = strtotime("$endYear-03-30");
	while($month < $end)
	{
	     $monthArray[] =  date('Y-m', $month);
	     $month = strtotime("+1 month", $month);
	}


	if($result){
		foreach ($result as $key => $value) {
			$state = $value['state'];
			$city = $value['city'];
			$m = $value['month'];

			if(!empty($post['state'])){
				$k = $value['city'].' '.$value['state'];
				$dataSet[$k][$m] = array('num'=>$value['num'], 'point'=>$value['point']);
			} else {
				$k = $value['state'];
				$dataSet[$k][$m] = array('num'=>$value['num'], 'point'=>$value['point']);
			}
		}

		$i=0;
		foreach ($dataSet as $k=>$meta) {

			$reportData[$i]['name'] = $k;
			foreach ($monthArray as $m) {
				if(isset($meta[$m])){
					$reportData[$i]['meta'][] = array('num'=>$meta[$m]['num'], 'point'=>$meta[$m]['point']);
				} else {
					$reportData[$i]['meta'][]= array('num'=>0, 'point'=>0);
				}
			}

			$i++;
		}
	}

	if(is_array($reportData)){

		$objPHPExcel = new PHPExcel();
		$objSheet = $objPHPExcel->getActiveSheet();
		$objSheet->setTitle('Report');

		$style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
	  );

	  $objSheet->setCellValue('A1', 'Location');
	  $objSheet->mergeCells('A1:A2');
	  $objSheet->getStyle("A1:Y2")->applyFromArray($style);

	  $objSheet->setCellValue('B1', 'APRIL');
	  $objSheet->mergeCells('B1:C1');

	  $objSheet->setCellValue('D1', 'MAY');
	  $objSheet->mergeCells('D1:E1');

	  $objSheet->setCellValue('F1', 'JUNE');
	  $objSheet->mergeCells('F1:G1');

	  $objSheet->setCellValue('H1', 'JULY');
	  $objSheet->mergeCells('H1:I1');

	  $objSheet->setCellValue('J1', 'AUGUST');
	  $objSheet->mergeCells('J1:K1');

	  $objSheet->setCellValue('L1', 'SEPTEMBER');
	  $objSheet->mergeCells('L1:M1');

	  $objSheet->setCellValue('N1', 'OCTOBER');
	  $objSheet->mergeCells('N1:O1');

	  $objSheet->setCellValue('P1', 'NOVEMBER');
	  $objSheet->mergeCells('P1:Q1');

	  $objSheet->setCellValue('R1', 'DECEMBER');
	  $objSheet->mergeCells('R1:S1');

	  $objSheet->setCellValue('T1', 'JANUARY');
	  $objSheet->mergeCells('T1:U1');

	  $objSheet->setCellValue('V1', 'FEBRUARY');
	  $objSheet->mergeCells('V1:W1');

	  $objSheet->setCellValue('X1', 'MARCH');
	  $objSheet->mergeCells('X1:Y1');

	  $objSheet->setCellValue('B2', 'NOS');
	  $objSheet->setCellValue('C2', 'AMT');
	  $objSheet->setCellValue('D2', 'NOS');
	  $objSheet->setCellValue('E2', 'AMT');
	  $objSheet->setCellValue('F2', 'NOS');
	  $objSheet->setCellValue('G2', 'AMT');
	  $objSheet->setCellValue('H2', 'NOS');
	  $objSheet->setCellValue('I2', 'AMT');
	  $objSheet->setCellValue('J2', 'NOS');
	  $objSheet->setCellValue('K2', 'AMT');
	  $objSheet->setCellValue('L2', 'NOS');
	  $objSheet->setCellValue('M2', 'AMT');
	  $objSheet->setCellValue('N2', 'NOS');
	  $objSheet->setCellValue('O2', 'AMT');
	  $objSheet->setCellValue('P2', 'NOS');
	  $objSheet->setCellValue('Q2', 'AMT');
	  $objSheet->setCellValue('R2', 'NOS');
	  $objSheet->setCellValue('S2', 'AMT');
	  $objSheet->setCellValue('T2', 'NOS');
	  $objSheet->setCellValue('U2', 'AMT');
	  $objSheet->setCellValue('V2', 'NOS');
	  $objSheet->setCellValue('W2', 'AMT');
	  $objSheet->setCellValue('X2', 'NOS');
	  $objSheet->setCellValue('Y2', 'AMT');

	  $i=3;
	  foreach ($reportData as $value) {

	  	$objSheet->getCell(chr(65).$i)->setValue($value['name']);
	  	$char = 66;
	  	foreach ($value['meta'] as $v) {
	  		$objSheet->getCell(chr($char).$i)->setValue($v['num']);
	  		$char++;

	  		$objSheet->getCell(chr($char).$i)->setValue($v['point']);
	  		$char++;
	  	}
	  	$i++;
	  }

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output'); 
		$xlsData = ob_get_contents();
		ob_end_clean();

		$return =  array(
		  'success' => 1,
		  'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);

	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='scanTrendCustomerDownload'){
	$post = $api->jsonBody();
	$result = $report->scanTrendCustomer($post);
	//print_r($result);

	$startYear = $post['year'];
	$endYear = $post['year'];
	$start = $month = strtotime("$startYear-01-01");
	$end = strtotime("$endYear-12-31");
	while($month < $end)
	{
	     $monthArray[] =  date('Y-m', $month);
	     $month = strtotime("+1 month", $month);
	}
	
	/*
	$startMonth = $post['monthStart'];
	$startYear = $post['yearStart'];
	$endMonth = $post['monthEnd'];
	$endYear = $post['yearEnd'];
	    	
	$start = $month = strtotime("$startYear-$startMonth-01");

	 $end = strtotime("$endYear-$endMonth-30");

	while($month < $end)
	{
	     $monthArray[] =  date('Y-m', $month);
	     $month = strtotime("+1 month", $month);
	}
	*/

	if($result){
		foreach ($result as $key => $value) {

			$userId = $value['userId'];
			$userRoleId = $value['userRoleId'];
			$name = $value['name'];
			
			$m = $value['month'];

			$dataSet[$userId]['name'] = $name;
			$dataSet[$userId]['dealerCode'] = $value['dealerCode'];
			$dataSet[$userId]['mobile'] = $value['mobile'];
			$dataSet[$userId]['type'] = $ct[$userRoleId];
			$dataSet[$userId]['beat'] = $value['beat'];
			$dataSet[$userId]['meta'][$m] = array('num'=>$value['num'], 'point'=>$value['point']);
		}

		$i=0;
		foreach ($dataSet as $k=>$u) {

    // start 25_april_2023
    /*    if($i==0)
		    {
		    $reportData[$i]['name'] = "Name";
			$reportData[$i]['dealerCode'] = "Dealer Code";
			$reportData[$i]['mobile'] = "Mobile";
			$reportData[$i]['type'] = "User Type";
			$reportData[$i]['beat'] = "Distributor";
			
				$metas = $u['metas'];
				foreach ($monthArray as $m) {
					if(isset($metas[$m])){
					    if($i==0)
					    {
					        $reportData[$i]['meta'][] = array('num'=>"Coupons ".$m, 'point'=>"Points ".$m);
					    }
					
					} else {
					    if($i==0)
					    {
						$reportData[$i]['meta'][]= array('num'=>"Coupons ".$m, 'point'=>"Points ".$m);
					    }
					}
				}
				
		        $i++;
		    } 
			*/
            
        // end 25_april_2023

			$reportData[$i]['name'] = $u['name'];
			$reportData[$i]['dealerCode'] = $u['dealerCode'];
			$reportData[$i]['mobile'] = $u['mobile'];
			$reportData[$i]['type'] = $u['type'];
			$reportData[$i]['beat'] = $u['beat'];
			$meta = $u['meta'];
				foreach ($monthArray as $m) {
					if(isset($meta[$m])){
						$reportData[$i]['meta'][] = array('num'=>$meta[$m]['num'], 'point'=>$meta[$m]['point']);
					} else {
						$reportData[$i]['meta'][]= array('num'=>0, 'point'=>0);
					}
				}

			$i++;
		}
	}


	if(is_array($reportData)){

		$objPHPExcel = new PHPExcel();
		$objSheet = $objPHPExcel->getActiveSheet();
		$objSheet->setTitle('Report');

		$style = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        )
	  );
	  	  	  
	  
	  $objSheet->setCellValue('A1', 'Name');
	  $objSheet->mergeCells('A1:A2');

	  $objSheet->setCellValue('B1', 'Dealer Code');
	  $objSheet->mergeCells('B1:B2');

	  $objSheet->setCellValue('C1', 'Mobile');
	  $objSheet->mergeCells('C1:C2');

	  $objSheet->mergeCells('D1:E1');
	  $objSheet->getStyle("A1:AA2")->applyFromArray($style);

	  $objSheet->setCellValue('D1', 'JANUARY');
	  $objSheet->mergeCells('D1:E1');

	  $objSheet->setCellValue('F1', 'FEBRUARY');
	  $objSheet->mergeCells('F1:G1');

	  $objSheet->setCellValue('H1', 'MARCH');
	  $objSheet->mergeCells('H1:I1');

	  $objSheet->setCellValue('J1', 'APRIL');
	  $objSheet->mergeCells('J1:K1');

	  $objSheet->setCellValue('L1', 'MAY');
	  $objSheet->mergeCells('L1:M1');

	  $objSheet->setCellValue('N1', 'JUN');
	  $objSheet->mergeCells('N1:O1');

	  $objSheet->setCellValue('P1', 'JULY');
	  $objSheet->mergeCells('P1:Q1');

	  $objSheet->setCellValue('R1', 'AUGUST');
	  $objSheet->mergeCells('R1:S1');

	  $objSheet->setCellValue('T1', 'SEPTEMBER');
	  $objSheet->mergeCells('T1:U1');

	  $objSheet->setCellValue('V1', 'OCTOBER');
	  $objSheet->mergeCells('V1:W1');

	  $objSheet->setCellValue('X1', 'NOVEMBER');
	  $objSheet->mergeCells('X1:Y1');

	  $objSheet->setCellValue('Z1', 'DECEMBER');
	  $objSheet->mergeCells('Z1:AA1');
	  
	  $objSheet->setCellValue('AB1', 'Customer Type');                     
	  $objSheet->mergeCells('AB1:AB2');                              
	  
	  $objSheet->setCellValue('AC1', 'Beat');                      
	  $objSheet->mergeCells('AC1:AC2');                              

	  $objSheet->setCellValue('D2', 'NOS');
	  $objSheet->setCellValue('E2', 'AMT');
	  $objSheet->setCellValue('F2', 'NOS');
	  $objSheet->setCellValue('G2', 'AMT');
	  $objSheet->setCellValue('H2', 'NOS');
	  $objSheet->setCellValue('I2', 'AMT');
	  $objSheet->setCellValue('J2', 'NOS');
	  $objSheet->setCellValue('K2', 'AMT');
	  $objSheet->setCellValue('L2', 'NOS');
	  $objSheet->setCellValue('M2', 'AMT');
	  $objSheet->setCellValue('N2', 'NOS');
	  $objSheet->setCellValue('O2', 'AMT');
	  $objSheet->setCellValue('P2', 'NOS');
	  $objSheet->setCellValue('Q2', 'AMT');
	  $objSheet->setCellValue('R2', 'NOS');
	  $objSheet->setCellValue('S2', 'AMT');
	  $objSheet->setCellValue('T2', 'NOS');
	  $objSheet->setCellValue('U2', 'AMT');
	  $objSheet->setCellValue('V2', 'NOS');
	  $objSheet->setCellValue('W2', 'AMT');
	  $objSheet->setCellValue('X2', 'NOS');
	  $objSheet->setCellValue('Y2', 'AMT');
	  $objSheet->setCellValue('Z2', 'NOS');
	  $objSheet->setCellValue('AA2', 'AMT');

	  $i=3;
	  foreach ($reportData as $value) {

	  	$objSheet->getCell(chr(65).$i)->setValue($value['name']);
	  	$objSheet->getCell(chr(66).$i)->setValue($value['dealerCode']);
	  	$objSheet->getCell(chr(67).$i)->setValue($value['mobile']);
	  	$objSheet->getCell('AB'.$i)->setValue($value['type']);               
	  	$objSheet->getCell('AC'.$i)->setValue($value['beat']);           
	  		
	  	$char = 68;
	  	foreach ($value['meta'] as $v) {
	  		$objSheet->getCell(chr($char).$i)->setValue($v['num']);
	  		$char++;

	  		if($char==91){
	  			$objSheet->getCell('AA'.$i)->setValue($v['point']);
	  		} 
	  		else {
	  			$objSheet->getCell(chr($char).$i)->setValue($v['point']);
	  		}
	  		$char++;
	  	}
	  	$i++;
	  }

	  /*


	  $objSheet->setCellValue('A1', 'Name');
	  $objSheet->mergeCells('A1:A2');

	  $objSheet->setCellValue('B1', 'Dealer Code');
	  $objSheet->mergeCells('B1:B2');

	  $objSheet->setCellValue('C1', 'Mobile');
	  $objSheet->mergeCells('C1:C2');
	  
	  $objSheet->setCellValue('D1', 'Customer Type');
	  $objSheet->mergeCells('D1:D2');
	  
	  $objSheet->setCellValue('E1', 'Beat');
	  $objSheet->mergeCells('E1:E2');

	  $objSheet->mergeCells('F1:G1');
	  $objSheet->getStyle("A1:AA2")->applyFromArray($style);

	  $objSheet->setCellValue('F1', 'JANUARY');
	  $objSheet->mergeCells('F1:G1');

	  $objSheet->setCellValue('H1', 'FEBRUARY');
	  $objSheet->mergeCells('H1:I1');

	  $objSheet->setCellValue('J1', 'MARCH');
	  $objSheet->mergeCells('J1:K1');

	  $objSheet->setCellValue('L1', 'APRIL');
	  $objSheet->mergeCells('L1:M1');

	  $objSheet->setCellValue('N1', 'MAY');
	  $objSheet->mergeCells('N1:O1');

	  $objSheet->setCellValue('P1', 'JUNE');
	  $objSheet->mergeCells('P1:Q1');

	  $objSheet->setCellValue('R1', 'JULY');
	  $objSheet->mergeCells('R1:S1');

	  $objSheet->setCellValue('T1', 'AUGUST');
	  $objSheet->mergeCells('T1:U1');

	  $objSheet->setCellValue('V1', 'SEPTEMBER');
	  $objSheet->mergeCells('V1:W1');

	  $objSheet->setCellValue('X1', 'OCTOBER');
	  $objSheet->mergeCells('X1:Y1');

	  $objSheet->setCellValue('Z1', 'NOVEMBER');
	  $objSheet->mergeCells('Z1:AA1');
	  
	  $objSheet->setCellValue('AB1', 'DECEMBER');
	  $objSheet->mergeCells('AB1:AC1');

	  $objSheet->setCellValue('F2', 'NOS');
	  $objSheet->setCellValue('G2', 'AMT');	  
	  $objSheet->setCellValue('H2', 'NOS');
	  $objSheet->setCellValue('I2', 'AMT');
	  $objSheet->setCellValue('J2', 'NOS');
	  $objSheet->setCellValue('K2', 'AMT');
	  $objSheet->setCellValue('L2', 'NOS');
	  $objSheet->setCellValue('M2', 'AMT');
	  $objSheet->setCellValue('N2', 'NOS');
	  $objSheet->setCellValue('O2', 'AMT');
	  $objSheet->setCellValue('P2', 'NOS');
	  $objSheet->setCellValue('Q2', 'AMT');
	  $objSheet->setCellValue('R2', 'NOS');
	  $objSheet->setCellValue('S2', 'AMT');
	  $objSheet->setCellValue('T2', 'NOS');
	  $objSheet->setCellValue('U2', 'AMT');
	  $objSheet->setCellValue('V2', 'NOS');
	  $objSheet->setCellValue('W2', 'AMT');
	  $objSheet->setCellValue('X2', 'NOS');
	  $objSheet->setCellValue('Y2', 'AMT');
	  $objSheet->setCellValue('Z2', 'NOS');
	  $objSheet->setCellValue('AA2', 'AMT');   
	  $objSheet->setCellValue('AB2', 'NOS');
	  $objSheet->setCellValue('AC2', 'AMT');  

	  $i=3;
	  foreach ($reportData as $value) {

	  	$objSheet->getCell(chr(65).$i)->setValue($value['name']);
	  	$objSheet->getCell(chr(66).$i)->setValue($value['dealerCode']);
	  	$objSheet->getCell(chr(67).$i)->setValue($value['mobile']);
	  	$objSheet->getCell(chr(68).$i)->setValue($value['type']);
	  	$objSheet->getCell(chr(69).$i)->setValue($value['beat']);
	  	$char = 70;
		
	//	print_r($value['meta']); die;
	  	foreach ($value['meta'] as $v) {
	  		$objSheet->getCell(chr($char).$i)->setValue($v['num']);
	  		$char++;
	
			if(chr($char)=='91'){
				// echo chr($char).' ee'; die;
					$objSheet->getCell('AA'.$i)->setValue($v['point']);			
					  			
	  		}
	  		elseif(chr($char)=='92'){			

	  		$objSheet->getCell('AB3')->setValue($v['num']);
	  		} 
			elseif(chr($char)=='93'){			

	  		$objSheet->getCell('AC3')->setValue($v['point']);
	  		}			
			else {
				
	  			$objSheet->getCell(chr($char).$i)->setValue($v['point']);
			
	  		}
	  		$char++;
	  	}
		
	  	$i++;
	  }
	  */

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output'); 
		$xlsData = ob_get_contents();
		ob_end_clean();

		$return =  array(
		  'success' => 1,
		  'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);

	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	$api->setResponse($return, 200);
}

/*

if(isset($_GET['controller']) && $_GET['controller']=='scanTrendCustomerDownload'){
	$post = $api->jsonBody();
	$result = $report->scanTrendCustomer($post);
	//print_r($result);

	$startYear = $post['year'];
	$endYear = $post['year'];
	$start = $month = strtotime("$startYear-01-01");
	$end = strtotime("$endYear-12-31");
	while($month < $end)
	{
	     $monthArray[] =  date('Y-m', $month);
	     $month = strtotime("+1 month", $month);
	}
	
	if($result){
		foreach ($result as $key => $value) {

			$userId = $value['userId'];
			$userRoleId = $value['userRoleId'];
			$name = $value['name'];
			
			$m = $value['month'];

			$dataSet[$userId]['name'] = $name;
			$dataSet[$userId]['dealerCode'] = $value['dealerCode'];
			$dataSet[$userId]['mobile'] = $value['mobile'];
			$dataSet[$userId]['type'] = $ct[$userRoleId];
			$dataSet[$userId]['beat'] = $value['beat'];
			$dataSet[$userId]['meta'][$m] = array('num'=>$value['num'], 'point'=>$value['point']);
		}

		$i=0;
		foreach ($dataSet as $k=>$u) {

			$reportData[$i]['name'] = $u['name'];
			$reportData[$i]['dealerCode'] = $u['dealerCode'];
			$reportData[$i]['mobile'] = $u['mobile'];
			$reportData[$i]['type'] = $u['type'];
			$reportData[$i]['beat'] = $u['beat'];
			$meta = $u['meta'];
				foreach ($monthArray as $m) {
					if(isset($meta[$m])){
						$reportData[$i]['meta'][] = array('num'=>$meta[$m]['num'], 'point'=>$meta[$m]['point']);
					} else {
						$reportData[$i]['meta'][]= array('num'=>0, 'point'=>0);
					}
				}

			$i++;
		}
	}


	if(is_array($reportData)){

		$objPHPExcel = new PHPExcel();
		$objSheet = $objPHPExcel->getActiveSheet();
		$objSheet->setTitle('Report');

		$style = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        )
	  );


	  $objSheet->setCellValue('A1', 'Name');
	  $objSheet->mergeCells('A1:A2');

	  $objSheet->setCellValue('B1', 'Dealer Code');
	  $objSheet->mergeCells('B1:B2');

	  $objSheet->setCellValue('C1', 'Mobile');
	  $objSheet->mergeCells('C1:C2');
	  
	  $objSheet->setCellValue('D1', 'Customer Type');
	  $objSheet->mergeCells('D1:D2');
	  
	  $objSheet->setCellValue('E1', 'Beat');
	  $objSheet->mergeCells('E1:E2');

	  $objSheet->mergeCells('F1:G1');
	  $objSheet->getStyle("A1:AA2")->applyFromArray($style);

	  $objSheet->setCellValue('F1', 'JANUARY');
	  $objSheet->mergeCells('F1:G1');

	  $objSheet->setCellValue('H1', 'FEBRUARY');
	  $objSheet->mergeCells('H1:I1');

	  $objSheet->setCellValue('J1', 'MARCH');
	  $objSheet->mergeCells('J1:K1');

	  $objSheet->setCellValue('L1', 'APRIL');
	  $objSheet->mergeCells('L1:M1');

	  $objSheet->setCellValue('N1', 'MAY');
	  $objSheet->mergeCells('N1:O1');

	  $objSheet->setCellValue('P1', 'JUNE');
	  $objSheet->mergeCells('P1:Q1');

	  $objSheet->setCellValue('R1', 'JULY');
	  $objSheet->mergeCells('R1:S1');

	  $objSheet->setCellValue('T1', 'AUGUST');
	  $objSheet->mergeCells('T1:U1');

	  $objSheet->setCellValue('V1', 'SEPTEMBER');
	  $objSheet->mergeCells('V1:W1');

	  $objSheet->setCellValue('X1', 'OCTOBER');
	  $objSheet->mergeCells('X1:Y1');

	  $objSheet->setCellValue('Z1', 'NOVEMBER');
	  $objSheet->mergeCells('Z1:AA1');
	  
	  $objSheet->setCellValue('AB1', 'DECEMBER');
	  $objSheet->mergeCells('AB1:AC1');

	  $objSheet->setCellValue('F2', 'NOS');
	  $objSheet->setCellValue('G2', 'AMT');	  
	  $objSheet->setCellValue('H2', 'NOS');
	  $objSheet->setCellValue('I2', 'AMT');
	  $objSheet->setCellValue('J2', 'NOS');
	  $objSheet->setCellValue('K2', 'AMT');
	  $objSheet->setCellValue('L2', 'NOS');
	  $objSheet->setCellValue('M2', 'AMT');
	  $objSheet->setCellValue('N2', 'NOS');
	  $objSheet->setCellValue('O2', 'AMT');
	  $objSheet->setCellValue('P2', 'NOS');
	  $objSheet->setCellValue('Q2', 'AMT');
	  $objSheet->setCellValue('R2', 'NOS');
	  $objSheet->setCellValue('S2', 'AMT');
	  $objSheet->setCellValue('T2', 'NOS');
	  $objSheet->setCellValue('U2', 'AMT');
	  $objSheet->setCellValue('V2', 'NOS');
	  $objSheet->setCellValue('W2', 'AMT');
	  $objSheet->setCellValue('X2', 'NOS');
	  $objSheet->setCellValue('Y2', 'AMT');
	  $objSheet->setCellValue('Z2', 'NOS');
	  $objSheet->setCellValue('AA2', 'AMT');   
	  $objSheet->setCellValue('AB2', 'NOS');
	  $objSheet->setCellValue('AC2', 'AMT');  

	  $i=3;
	  foreach ($reportData as $value) {

	  	$objSheet->getCell(chr(65).$i)->setValue($value['name']);
	  	$objSheet->getCell(chr(66).$i)->setValue($value['dealerCode']);
	  	$objSheet->getCell(chr(67).$i)->setValue($value['mobile']);
	  	$objSheet->getCell(chr(68).$i)->setValue($value['type']);
	  	$objSheet->getCell(chr(69).$i)->setValue($value['beat']);
	  	$char = 70;
		
	//	print_r($value['meta']); die;
	  	foreach ($value['meta'] as $v) {
	  		$objSheet->getCell(chr($char).$i)->setValue($v['num']);
	  		$char++;
	
			if(chr($char)=='91'){
				// echo chr($char).' ee'; die;
					$objSheet->getCell('AA'.$i)->setValue($v['point']);			
					  			
	  		}
	  		elseif(chr($char)=='92'){			

	  		$objSheet->getCell('AB3')->setValue($v['num']);
	  		} 
			elseif(chr($char)=='93'){			

	  		$objSheet->getCell('AC3')->setValue($v['point']);
	  		}			
			else {
				
	  			$objSheet->getCell(chr($char).$i)->setValue($v['point']);
			
	  		}
	  		$char++;
	  	}
		
	  	$i++;
	  }

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output'); 
		$xlsData = ob_get_contents();
		ob_end_clean();

		$return =  array(
		  'success' => 1,
		  'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);

	} else {
		$return = array('success'=>0, 'data'=>array());
	}
	$api->setResponse($return, 200);
}

*/

if(isset($_GET['controller']) && $_GET['controller']=='encashmentPendingDownload'){
	$post = $api->jsonBody();
	$scannedPending = $report->encashmentPending($post);
	$transferredPending = $report->encashmentPendingReceived($post);

	if($scannedPending || $transferredPending){

		if(!empty($post['productId']) || !empty($post['subCategoryId'])){
			$x = 'productId';
			$n = 'productName';
			$ps = 'productSeries';
			
		} else if(!empty($post['categoryId'])){
			$x = 'subCategoryId';
			$n = 'subCategoryName';
		} else {
			$x = 'categoryId';
			$n = 'categorName';
		}

		if($scannedPending){
			foreach ($scannedPending as $v) {
				$k = $v[$x];
				$s = $v['userRoleId'];
				$sp[$k][$s] = array('num'=>$v['num'], 'point'=>$v['point']);
				$nm[$k] = $v[$n];
				$d[] = $k;
				if( $v[$ps])
	                $productSeries = "(".$v[$ps]." ) ";
			}
		}

		if($transferredPending){
			foreach ($transferredPending as $v) {
				$k = $v[$x];
				$s = $v['userRoleId'];
				$tp[$k][$s] = array('num'=>$v['num'], 'point'=>$v['point']);
				$nm[$k] = $v[$n];
				$d[] = $k;
				
				if( $v[$ps])
	                 $productSeries = "(".$v[$ps]." ) ";
			}
		}
	}

	if(isset($d) && is_array($d)){
		$d = array_unique($d);
		$i=0;
		foreach ($d as $k) {
			$numTotal=0;
			$pointsTotal=0;
			$rowSet[$i][] = $productSeries.$nm[$k];
			foreach ($ct as $userType => $type) {
				$num = 0;
				$point = 0;

				if(isset($sp[$k][$userType])){
					$num+=$sp[$k][$userType]['num'];
					$point+=$sp[$k][$userType]['point'];
				}

				if(isset($tp[$k][$userType])){
					$num+=$tp[$k][$userType]['num'];
					$point+=$tp[$k][$userType]['point'];
				}

				$rowSet[$i][] = $num;
				$rowSet[$i][] = $point;

				$numTotal+=$num;
				$pointsTotal+=$point;
		  }
		  $rowSet[$i][] = $numTotal;
		  $rowSet[$i][] = $pointsTotal;
		  $i++;
		}
	}


	$objPHPExcel = new PHPExcel();
	$objSheet = $objPHPExcel->getActiveSheet();
	$objSheet->setTitle('Report');

	$style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
  );

	$objSheet->setCellValue('A1', 'TITLE');
  $objSheet->mergeCells('A1:A2');
  $objSheet->getStyle("A1:U2")->applyFromArray($style);

  $objSheet->setCellValue('B1', 'MAIN DISTRIBUTOR');
  $objSheet->mergeCells('B1:C1');

  $objSheet->setCellValue('D1', 'DISTRIBUTOR');
  $objSheet->mergeCells('D1:E1');

  $objSheet->setCellValue('F1', 'RETAILER');
  $objSheet->mergeCells('F1:G1');

  $objSheet->setCellValue('H1', 'CUSTOMER');
  $objSheet->mergeCells('H1:I1');

  $objSheet->setCellValue('J1', 'PARAS TEAM');
  $objSheet->mergeCells('J1:K1');

  $objSheet->setCellValue('L1', 'TECH TEAM');
  $objSheet->mergeCells('L1:M1');

  $objSheet->setCellValue('N1', 'OTHER');
  $objSheet->mergeCells('N1:O1');

  $objSheet->setCellValue('P1', 'AUTH. RETAILER');
  $objSheet->mergeCells('P1:Q1');	
	
  $objSheet->setCellValue('R1', 'DEACTIVATED');
  $objSheet->mergeCells('R1:S1');
  
  $objSheet->setCellValue('T1', 'TOTAL');
  $objSheet->mergeCells('T1:U1');

  $objSheet->setCellValue('B2', 'NOS');
  $objSheet->setCellValue('C2', 'AMT');
  $objSheet->setCellValue('D2', 'NOS');
  $objSheet->setCellValue('E2', 'AMT');
  $objSheet->setCellValue('F2', 'NOS');
  $objSheet->setCellValue('G2', 'AMT');
  $objSheet->setCellValue('H2', 'NOS');
  $objSheet->setCellValue('I2', 'AMT');
  $objSheet->setCellValue('J2', 'NOS');
  $objSheet->setCellValue('K2', 'AMT');
  $objSheet->setCellValue('L2', 'NOS');
  $objSheet->setCellValue('M2', 'AMT');
  $objSheet->setCellValue('N2', 'NOS');
  $objSheet->setCellValue('O2', 'AMT');
  $objSheet->setCellValue('P2', 'NOS');
  $objSheet->setCellValue('Q2', 'AMT');
  $objSheet->setCellValue('R2', 'NOS');
  $objSheet->setCellValue('S2', 'AMT');
  $objSheet->setCellValue('T2', 'NOS');
  $objSheet->setCellValue('U2', 'AMT');


  $i=3;
  foreach ($rowSet as $value) {
  	$char = 65;
  	foreach ($value as $v) {
  		$objSheet->getCell(chr($char).$i)->setValue($v);
  		$char++;
  	}
  	$i++;
  }

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output'); 
	$xlsData = ob_get_contents();
	ob_end_clean();

	$return =  array(
	  'success' => 1,
	  'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
	);

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='userPointStatmentDownload'){

	$post = $api->jsonBody();
	 $mobile = (isset($post['mobile']) && !empty($post['mobile'])) ? $post['mobile'] : false;
	 $pointSdate = (isset($post['pointSdate']) && !empty($post['pointSdate'])) ? $post['pointSdate'] : false;
	 $pointEdate = (isset($post['pointEdate']) && !empty($post['pointEdate'])) ? $post['pointEdate'] : false;

	$data = array();
	$profile = array();

	if($mobile){
		$user = new users();
	  $profile = $user->getUserProfileByMobile($mobile);
		if($profile){
			$userId = $profile['id'];

		/*	$ct["2"] = 'Main Distributor';
			$ct["3"] = 'Distributor';
			$ct["4"] = 'Retailer';
			$ct["5"] = 'Customer';
			$ct["6"] = 'Mechanic';
			$ct["8"] = 'Sales Staff';
			$ct["9"] = 'Engg. Workshop'; */
			
			$ct["2"] = 'Main Distributor';
			$ct["3"] = 'Distributor';
			$ct["4"] = 'Retailer';
			$ct["5"] = 'Customer';
			$ct["6"] = 'Mechanic';
			$ct["8"] = 'Paras Team';
			$ct["9"] = 'Tech Team'; 

			$profile['roleName'] = $ct[$profile['user_role_id']];

			$userLedger = $report->getUserLedger($userId,$pointSdate,$pointEdate);
			$userScans = $report->getUserScans($userId,$pointSdate,$pointEdate);
//var_dump("thisUL:".$userLedger);
//die("this us:".$userScans);

			if($userLedger || $userScans){

				if($userLedger){
					$i=0;
					foreach ($userLedger as $key => $value) {
						$userLedger[$i]['type'] = ($value['receivedFromUserId']==$userId) ? 3 : 2;
						$i++;
					}
				}

				if($userScans){
					$i=0;
					foreach ($userScans as $key => $value) {
						$userScans[$i]['type'] = 1;
						$i++;
					}
				}

				if($userLedger && $userScans){
					$userArray = array_merge($userLedger, $userScans);
				} elseif($userLedger) {
					$userArray = $userLedger;
				} else {
					$userArray = $userScans;
				}

			
				$time = array();
				foreach ($userArray as $key => $row)
				{
				    $time[$key] = $row['time'];
				}

				array_multisort($time, SORT_DESC, $userArray);

				foreach ($userArray as $row) {

				  if($row['type']==1){
              $remark = $row['productName']." \r\n Coupon Code: ".$row['couponCode'];
          } else if($row['type']==2){
              $remark = "Received From: ".$row['receivedFromName']." ".$row['receivedFromMobile']." \r\n Ref ID : ".$row['refId'];
          } else {
              $remark = "Transfer To: ".$row['transferToName']." ".$row['transferToMobile']." \r\n Ref ID : ".$row['refId'];
          }
          
          
          $pointPaidStatus = ($row['pointPaidStatus']==1) ? "Paid" : "Unpaid";

					$rowSet[] = array(
						'Date'=> $row['date'],
						'Remark'=> $remark,
						'Point'=> $row['points'],
						'Point Paid Status'=> $pointPaidStatus,
						'Point Remark'=> $row['pointRemark'],
					);
				}
				
				$success = 1;
				$message = "Success";

			} else {
				$success = 0;
				$message = "No result found.";
			}

		} else {
			$success = 0;
			$message = "User data not found.";
		}

	} else {
		$success = 0;
		$message = "Mobile number missing.";
	}

	$return = array('success'=>$success, 'data'=>$rowSet, 'profile'=>$profile, 'message'=>$message);
	$api->setResponse($return, 200);
}



if(isset($_GET['controller']) && $_GET['controller']=='remarkPoints'){
    
    $result = [];
    $post = $api->jsonBody();
    
    $userId = (isset($post['userId']) && !empty($post['userId'])) ? $post['userId'] : '';
    
    $postPointPaidStatusVar= $post['pointPaidStatusVar'];
	$postRemarkVar= $post['remarkVar'];
	
	
	if(is_array($postPointPaidStatusVar) && sizeof($postPointPaidStatusVar)>0)
	{
	    foreach($postPointPaidStatusVar as $key => $pointStatus){
	        
	        if($pointStatus['pointType'] !=2 ) // Only Point receive transaction
	            continue;
	        
	        $data  = [];
	        $refId = $pointStatus['itemRefId'];
	        $remark = $postRemarkVar[$key]['value'];
	        
	        $data = ["pointPaidStatus"=>$pointStatus['value'],"pointRemark"=>$remark];
	        
	        
	        $report->updatePointRemarkStatus($refId, $data);
	    }
    }
    
    
	if ($result['error'] == false) {
		$return = array('success' => 1, 'message' => 'Record Updated Successfully.');
	} else {
		$return = array('success' => 0, 'message' => $result['error']);
	}
     
	$api->setResponse($return, 200);
}




if(isset($_GET['controller']) && $_GET['controller']=='downloadMultiScan'){

	$result = $report->getMultiScanList($_POST);
	
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="Multi_Scan_Report.csv"');
    header('Cache-Control: max-age=0');
    $out = fopen('php://output', 'w');

	$reportDownloadList[] = array('QR code No','Total No of Scans','Batch No','Date of Activation','Name','Mobile','Location','Error Message','Scan DateTime');
	
	foreach($result as $data):
	    
	      $activationDate = date("d-m-Y",$data['activated_on']);
	      
		  $reportDownloadList[] = array($data['QRcode'],$data['scanCount'],$data['batch_number'],$activationDate,'','','','','');
		  
		  
		$scanQRCodeData = $report->getScanDataByQrCode($data['QRcode']);
		foreach($scanQRCodeData as $qrCodeDta):
		    
		    $userName = "Not Register";
		    $location = "Not Available";
		    
		    if($qrCodeDta['userId']){
		        $userData = $report->getUserData($qrCodeDta['userId']);
		        $userName = $userData['name'];
		        $location = $userData['city']." - ". $userData['state'];
		    }
		    
		    $reportDownloadList[] = array('','','','',$userName,$qrCodeDta['mobile'],$location,$qrCodeDta['errorMessage'],$qrCodeDta['scanDatetTme']);
		    
		endforeach;

    endforeach;
    
    //echo "<pre>";
    //print_r($reportDownloadList); die;
    
    foreach ($reportDownloadList as $fields) 
        fputcsv($out, $fields);

}






// start 19_april_2023

if(isset($_GET['controller']) && $_GET['controller']=='ByDate_scanTrendModuleDownload'){
//	error_reporting(E_ALL & ~E_NOTICE);

	$post = $api->jsonBody();
	
	$result = $report->scanTrendModuleByDate($post);

	$startYear = $post['year'];
	$endYear = $post['year'] + 1;
	$start = $month = strtotime("$startYear-04-01");
	$end = strtotime("$endYear-03-30");


	$selected_moth =  $post['month'];	
//	if($selected_moth>3)	
//	{	
	$days  = cal_days_in_month(CAL_GREGORIAN,$selected_moth,$startYear);	
	$start_date = $startYear.'-'.$selected_moth.'-'.'01';	
	$end_date = $startYear.'-'.$selected_moth.'-'.$days;	
	/*
}	
	else	
	{	
	$days  = cal_days_in_month(CAL_GREGORIAN,$selected_moth,$endYear);	
	$start_date = $endYear.'-'.$selected_moth.'-'.'01';	
	$end_date = $endYear.'-'.$selected_moth.'-'.$days;	
		
	}
	*/	
	// echo $start_date;	
	// echo $end_date;	
				
	while($start_date <= $end_date)	
	{	
     $dateArray[] =  $start_date;	
	 $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));	
    	
	}	
	
	while($month < $end)
	{
     $monthArray[] =  date('Y-m', $month);
     $month = strtotime("+1 month", $month);
	}

	if($result){
		foreach ($result as $key => $value) {
			$moduleId = $value['moduleId'];
			
			$moduleName = $value['moduleName'];
			
		if(!empty($value['productSeries']))	
			{	
			        $moduleName = "(".$value['productSeries'].") ".$value['moduleName'];	
			}	
			        				        	
			$m = $value['sdate'];

			$dataSet[$moduleId]['module'] = $moduleName;
			$dataSet[$moduleId][$m] = array('num'=>$value['num'], 'point'=>$value['point']);
		}

		$i=0;
		foreach ($dataSet as $k=>$value) {

			$reportData[$i]['module'] = $value['module'];
			foreach ($dateArray  as $m) {
				if(isset($value[$m])){
					$reportData[$i]['meta'][] = array('num'=>$value[$m]['num'], 'point'=>$value[$m]['point']);
				} else {
					$reportData[$i]['meta'][]= array('num'=>0, 'point'=>0);
				}
			}

			$i++;
		}
	}

	// echo "<pre>"; print_r($reportData); die;
	if(is_array($reportData)){

		$objPHPExcel = new PHPExcel();
		$objSheet = $objPHPExcel->getActiveSheet();
		$objSheet->setTitle('Report');

		$style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
	  );

	  $objSheet->setCellValue('A1', 'Model');
	  $objSheet->mergeCells('A1:A2');
	  $objSheet->getStyle("A1:BK2")->applyFromArray($style);

	  $objSheet->setCellValue('B1', '01');
	  $objSheet->mergeCells('B1:C1');

	  $objSheet->setCellValue('D1', '02');
	  $objSheet->mergeCells('D1:E1');

	  $objSheet->setCellValue('F1', '03');
	  $objSheet->mergeCells('F1:G1');

	  $objSheet->setCellValue('H1', '04');
	  $objSheet->mergeCells('H1:I1');

	  $objSheet->setCellValue('J1', '05');
	  $objSheet->mergeCells('J1:K1');

	  $objSheet->setCellValue('L1', '06');
	  $objSheet->mergeCells('L1:M1');

	  $objSheet->setCellValue('N1', '07');
	  $objSheet->mergeCells('N1:O1');

	  $objSheet->setCellValue('P1', '08');
	  $objSheet->mergeCells('P1:Q1');

	  $objSheet->setCellValue('R1', '09');
	  $objSheet->mergeCells('R1:S1');

	  $objSheet->setCellValue('T1', '10');
	  $objSheet->mergeCells('T1:U1');

	  $objSheet->setCellValue('V1', '11');
	  $objSheet->mergeCells('V1:W1');

	  $objSheet->setCellValue('X1', '12');
	  $objSheet->mergeCells('X1:Y1');

	  // start 13 date

	  $objSheet->setCellValue('Z1', '13');
	  $objSheet->mergeCells('Z1:AA1');

	  $objSheet->setCellValue('AB1', '14');
	  $objSheet->mergeCells('AB1:AC1');

	  $objSheet->setCellValue('AD1', '15');
	  $objSheet->mergeCells('AD1:AE1');

	  $objSheet->setCellValue('AF1', '16');
	  $objSheet->mergeCells('AF1:AG1');

	  $objSheet->setCellValue('AH1', '17');
	  $objSheet->mergeCells('AH1:AI1');

	  $objSheet->setCellValue('AJ1', '18');
	  $objSheet->mergeCells('AJ1:AK1');
	  
	  $objSheet->setCellValue('AL1', '19');
	  $objSheet->mergeCells('AL1:AM1');
	  
	  $objSheet->setCellValue('AN1', '20');
	  $objSheet->mergeCells('AN1:AO1');
	  
	  $objSheet->setCellValue('AP1', '21');
	  $objSheet->mergeCells('AP1:AQ1');
	  
	  $objSheet->setCellValue('AR1', '22');
	  $objSheet->mergeCells('AR1:AS1');
	  
	  $objSheet->setCellValue('AT1', '23');
	  $objSheet->mergeCells('AT1:AU1');
	  
	  $objSheet->setCellValue('AV1', '24');
	  $objSheet->mergeCells('AV1:AW1');
	  
	  $objSheet->setCellValue('AX1', '25');
	  $objSheet->mergeCells('AX1:AY1');
	  
	  $objSheet->setCellValue('AZ1', '26');
	  $objSheet->mergeCells('AZ1:BA1');
	  
	  $objSheet->setCellValue('BB1', '27');
	  $objSheet->mergeCells('BB1:BC1');
	  
	  $objSheet->setCellValue('BD1', '28');
	  $objSheet->mergeCells('BD1:BE1');
	  
	  $objSheet->setCellValue('BF1', '29');
	  $objSheet->mergeCells('BF1:BG1');
	  
	  $objSheet->setCellValue('BH1', '30');
	  $objSheet->mergeCells('BH1:BI1');
	  
	  $objSheet->setCellValue('BJ1', '31');
	  $objSheet->mergeCells('BJ1:BK1');

// END 31


	  $objSheet->setCellValue('B2', 'NOS');
	  $objSheet->setCellValue('C2', 'AMT');
	  $objSheet->setCellValue('D2', 'NOS');
	  $objSheet->setCellValue('E2', 'AMT');
	  $objSheet->setCellValue('F2', 'NOS');
	  $objSheet->setCellValue('G2', 'AMT');
	  $objSheet->setCellValue('H2', 'NOS');
	  $objSheet->setCellValue('I2', 'AMT');
	  $objSheet->setCellValue('J2', 'NOS');
	  $objSheet->setCellValue('K2', 'AMT');
	  $objSheet->setCellValue('L2', 'NOS');
	  $objSheet->setCellValue('M2', 'AMT');
	  $objSheet->setCellValue('N2', 'NOS');
	  $objSheet->setCellValue('O2', 'AMT');
	  $objSheet->setCellValue('P2', 'NOS');
	  $objSheet->setCellValue('Q2', 'AMT');
	  $objSheet->setCellValue('R2', 'NOS');
	  $objSheet->setCellValue('S2', 'AMT');
	  $objSheet->setCellValue('T2', 'NOS');
	  $objSheet->setCellValue('U2', 'AMT');
	  $objSheet->setCellValue('V2', 'NOS');
	  $objSheet->setCellValue('W2', 'AMT');
	  $objSheet->setCellValue('X2', 'NOS');
	  $objSheet->setCellValue('Y2', 'AMT');

	  // start 
	  $objSheet->setCellValue('Z2', 'NOS');
	  $objSheet->setCellValue('AA2', 'AMT');
	  $objSheet->setCellValue('AB2', 'NOS');
	  $objSheet->setCellValue('AC2', 'AMT');
	  $objSheet->setCellValue('AD2', 'NOS');
	  $objSheet->setCellValue('AE2', 'AMT');
	  $objSheet->setCellValue('AF2', 'NOS');
	  $objSheet->setCellValue('AG2', 'AMT');
	  $objSheet->setCellValue('AH2', 'NOS');
	  $objSheet->setCellValue('AI2', 'AMT');
	  $objSheet->setCellValue('AJ2', 'NOS');
	  $objSheet->setCellValue('AK2', 'AMT');
	  $objSheet->setCellValue('AL2', 'NOS');
	  $objSheet->setCellValue('AM2', 'AMT');
	  $objSheet->setCellValue('AN2', 'NOS');
	  $objSheet->setCellValue('AO2', 'AMT');
	  $objSheet->setCellValue('AP2', 'NOS');
	  $objSheet->setCellValue('AQ2', 'AMT');
	  $objSheet->setCellValue('AR2', 'NOS');
	  $objSheet->setCellValue('AS2', 'AMT');
	  $objSheet->setCellValue('AT2', 'NOS');
	  $objSheet->setCellValue('AU2', 'AMT');
	  $objSheet->setCellValue('AV2', 'NOS');
	  $objSheet->setCellValue('AW2', 'AMT');
	  $objSheet->setCellValue('AX2', 'NOS');
	  $objSheet->setCellValue('AY2', 'AMT');
	  $objSheet->setCellValue('AZ2', 'NOS');
	  $objSheet->setCellValue('BA2', 'AMT');
	  $objSheet->setCellValue('BB2', 'NOS');
	  $objSheet->setCellValue('BC2', 'AMT');
	  $objSheet->setCellValue('BD2', 'NOS');
	  $objSheet->setCellValue('BE2', 'AMT');
	  $objSheet->setCellValue('BF2', 'NOS');
	  $objSheet->setCellValue('BG2', 'AMT');
	  $objSheet->setCellValue('BH2', 'NOS');
	  $objSheet->setCellValue('BI2', 'AMT');
	  $objSheet->setCellValue('BJ2', 'NOS');
	  $objSheet->setCellValue('BK2', 'AMT');

	  // end 31



	  $i=3;
	  foreach ($reportData as $value) {

	  	$objSheet->getCell(chr(65).$i)->setValue($value['module']);
	  	$char = 66;
	  	foreach ($value['meta'] as $v) {
			if($char==92){
	  			$objSheet->getCell('AB'.$i)->setValue($v['num']);
			} 
			elseif($char==94){
				$objSheet->getCell('AD'.$i)->setValue($v['num']);
		  	}
			elseif($char==96){
				$objSheet->getCell('AF'.$i)->setValue($v['num']);
		  	}
			elseif($char==98){
				$objSheet->getCell('AH'.$i)->setValue($v['num']);
		  	}
			elseif($char==100){
				$objSheet->getCell('AJ'.$i)->setValue($v['num']);
		  	}
			elseif($char==102){
				$objSheet->getCell('AL'.$i)->setValue($v['num']);
		  	}
			elseif($char==104){
				$objSheet->getCell('AN'.$i)->setValue($v['num']);
		  	}			
			elseif($char==106){
				$objSheet->getCell('AP'.$i)->setValue($v['num']);
		  	}		
			elseif($char==108){
				$objSheet->getCell('AR'.$i)->setValue($v['num']);
		  	}	
			elseif($char==110){
				$objSheet->getCell('AT'.$i)->setValue($v['num']);
		  	}
			elseif($char==112){
				$objSheet->getCell('AV'.$i)->setValue($v['num']);
		  	}
			elseif($char==114){
				$objSheet->getCell('AX'.$i)->setValue($v['num']);
		  	}
			elseif($char==116){
				$objSheet->getCell('AZ'.$i)->setValue($v['num']);
		  	}
			elseif($char==118){
				$objSheet->getCell('BB'.$i)->setValue($v['num']);
		  	}
			elseif($char==120){
				$objSheet->getCell('BD'.$i)->setValue($v['num']);
		  	}
			elseif($char==122){
				$objSheet->getCell('BF'.$i)->setValue($v['num']);
		  	}
			elseif($char==124){
				$objSheet->getCell('BH'.$i)->setValue($v['num']);
		  	}
			elseif($char==126){
				$objSheet->getCell('BJ'.$i)->setValue($v['num']);
		  	}
			elseif($char==128){
				$objSheet->getCell('BL'.$i)->setValue($v['num']);
		  	}
			elseif($char==130){
				$objSheet->getCell('BN'.$i)->setValue($v['num']);
		  	}
			else 
			{
				$objSheet->getCell(chr($char).$i)->setValue($v['num']);
			}
	  		$char++;



			if($char==91){
				$objSheet->getCell('AA'.$i)->setValue($v['point']);
			} 
			elseif($char==93){
				$objSheet->getCell('AC'.$i)->setValue($v['point']);
			} 
			elseif($char==95){
				$objSheet->getCell('AE'.$i)->setValue($v['point']);
			} 
			elseif($char==97){
				$objSheet->getCell('AG'.$i)->setValue($v['point']);
			} 
			elseif($char==99){
				$objSheet->getCell('AI'.$i)->setValue($v['point']);
			} 
			elseif($char==101){
				$objSheet->getCell('AK'.$i)->setValue($v['point']);
			} 
			elseif($char==103){
				$objSheet->getCell('AM'.$i)->setValue($v['point']);
			} 
			elseif($char==105){
				$objSheet->getCell('AO'.$i)->setValue($v['point']);
			} 
			elseif($char==107){
				$objSheet->getCell('AQ'.$i)->setValue($v['point']);
			} 
			elseif($char==109){
				$objSheet->getCell('AS'.$i)->setValue($v['point']);
			} 
			elseif($char==111){
				$objSheet->getCell('AU'.$i)->setValue($v['point']);
			} 
			elseif($char==113){
				$objSheet->getCell('AW'.$i)->setValue($v['point']);
			} 
			elseif($char==115){
				$objSheet->getCell('AY'.$i)->setValue($v['point']);
			} 
			elseif($char==117){
				$objSheet->getCell('BA'.$i)->setValue($v['point']);
			} 
			elseif($char==119){
				$objSheet->getCell('BC'.$i)->setValue($v['point']);
			} 
			elseif($char==121){
				$objSheet->getCell('BE'.$i)->setValue($v['point']);
			} 
			elseif($char==123){
				$objSheet->getCell('BG'.$i)->setValue($v['point']);
			} 
			elseif($char==125){
				$objSheet->getCell('BI'.$i)->setValue($v['point']);
			} 
			elseif($char==127){
				$objSheet->getCell('BK'.$i)->setValue($v['point']);
			} 
			elseif($char==129){
				$objSheet->getCell('BM'.$i)->setValue($v['point']);
			} 
			elseif($char==131){
				$objSheet->getCell('BO'.$i)->setValue($v['point']);
			} 

			else {
	  		$objSheet->getCell(chr($char).$i)->setValue($v['point']);
			}
	  		$char++;
	  	}
	  	$i++;
	  }

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output'); 
		$xlsData = ob_get_contents();
		ob_end_clean();

		$return =  array(
		  'success' => 1,
		  'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);

	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='getTotalCouponGenerated'){
	$post = $api->jsonBody();

	$result = $report->getTotalCouponGenerated();

	$dataCount = $result[0]['total_active_coupon_code'];
	if($dataCount > 0){
		$return = array('success'=>1, 'data'=>$dataCount);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='getMonthsCouponGeneratedFirst'){
	$post = $api->jsonBody();

	$result = $report->getMonthsCouponGeneratedFirst();
	// echo "<pre>"; print_r($result); die;
	
	if(is_array($result) && count($result) > 0){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='getMonthsCouponGeneratedSecond'){
	$post = $api->jsonBody();

	$result = $report->getMonthsCouponGeneratedSecond();
	// echo "<pre>"; print_r($result); die;
	
	if(is_array($result) && count($result) > 0){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='getMonthsCouponGeneratedThird'){
	$post = $api->jsonBody();

	date_default_timezone_set("Asia/Kolkata"); 

	$result = $report->getMonthsCouponGeneratedThird();
	// echo "<pre>"; print_r($result);
	// echo "<br>"; 

	 $NewData =  array (
		'num' => '0',
		'year' => date('Y'),
		'month' => date('m'),
		'monthName' => date('F')
	  );
  
	if($result[0]['month'] != date('m')) 
		{
	array_unshift($result, $NewData);
		if(count($result) > 3) {
			array_pop($result);
			}
		}

	// $prevMonth = date('m', strtotime('-1 month'));
	// $prevMonthName = date('F', strtotime('-1 month'));

	$current_date = date("d");
	$prevMonth = date("m", strtotime("-$current_date days"));
	$prevMonthName = date("F", strtotime("-$current_date days"));

	$NewData22 =  array (
		'num' => '0',
		'year' => date('Y'),
		'month' => $prevMonth,
		'monthName' => $prevMonthName
	  );

//	  echo $result[1]['month'];
//	  echo "<br>";
//	  echo $prevMonth;
//	  echo "<pre>"; print_r($result);	echo "<br>"; die;

	//  $newResult =  $result;
	if($result[1]['month'] != $prevMonth) 
		{
	// array_unshift($result, $NewData22);

	array_splice($result, 1, 0, array(array('num'=> '0', 'year'=> date('Y'), 'month' => $prevMonth, 'monthName'=> $prevMonthName)));

		if(count($result) > 3) {
			array_pop($result);
			}
		}	

	//	echo "<pre>"; print_r($result);	echo "<br>"; die;
	
	if(is_array($result) && count($result) > 0){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='getMonthsCouponGenerated'){
	$post = $api->jsonBody();

	$result = $report->getMonthsCouponGenerated();
	// echo "<pre>"; print_r($result); die;
	
	if(is_array($result) && count($result) > 0){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='totalCouponGeneratedFirst'){
	$post = $api->jsonBody();

	$result = $report->totalCouponGeneratedFirst();

	$dataCount = $result[0]['total_active_coupon_code'];
	if($dataCount > 0){
		$return = array('success'=>1, 'data'=>$dataCount);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='totalCouponGeneratedSecond'){
	$post = $api->jsonBody();

	$result = $report->totalCouponGeneratedSecond();

	$dataCount = $result[0]['total_active_coupon_code'];
	if($dataCount > 0){
		$return = array('success'=>1, 'data'=>$dataCount);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}

if(isset($_GET['controller']) && $_GET['controller']=='totalCouponGeneratedThird'){
	$post = $api->jsonBody();

	$result = $report->totalCouponGeneratedThird();

	$dataCount = $result[0]['total_active_coupon_code'];
	if($dataCount > 0){
		$return = array('success'=>1, 'data'=>$dataCount);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}




if(isset($_GET['controller']) && $_GET['controller']=='getTotalScanCoupon'){
	$post = $api->jsonBody();

	$result = $report->getTotalScanCoupon();
	
	// echo "<pre>"; print_r($result); die;
	 $dataCount = $result[0]['num']; 
	if($dataCount > 0){
		$return = array('success'=>1, 'data'=>$dataCount);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='getTotalUnscanCoupon'){
	$post = $api->jsonBody();

	$result = $report->getTotalUnscanCoupon();
	
	// echo "<pre>"; print_r($result); die;
	 $dataCount = $result[0]['num']; 
	if($dataCount > 0){
		$return = array('success'=>1, 'data'=>$dataCount);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='getMonthScanUnscanNum'){
	$post = $api->jsonBody();



	$result_scan= $report->getMonthScanNum();

	$result_unscan = $report->getMonthUnscanNum();
	
	  $scanNewData =  array (
		'num' => '0',
		'year' => date('Y'),
		'month' => date('m'),
		'monthName' => date('F')
	  );
  
	if($result_scan[0]['month'] != date('m')) 
		{
	array_unshift($result_scan, $scanNewData);

	if(count($result_scan) > 3) {
		array_pop($result_scan);
		}

	// array_pop($result_scan);
		}

	if($result_unscan[0]['month'] != date('m')) 
		{
	array_unshift($result_unscan, $scanNewData);
	if(count($result_unscan) > 3) {
		array_pop($result_unscan);
		}
	// array_pop($result_unscan);
		}
	
	 echo "<pre>"; print_r($result_scan); 
	 echo "<br>";

	 echo "<pre>"; print_r($result_unscan); 
	 echo "<br>";

	$newArr = [];
		foreach($result_scan as $key => $scanVal)
		{

			foreach($result_unscan as $key2 => $unscanVal)
			{
				if($scanVal['month'] == $unscanVal['month'])
				{
					$newArr[$scanVal['num']] =  $unscanVal['num'];
				}
			}

		}

	 echo "<pre>";  print_r($newArr); 	die;
	
	if(is_array($newArr) && count($newArr) > 0){
		$return = array('success'=>1, 'data'=>$newArr);
	} else {
		$return = array('success'=>0, 'data'=>array());
	}

	
	$api->setResponse($return, 200);
}


if(isset($_GET['controller']) && $_GET['controller']=='budgetChart'){
	$post = $api->jsonBody();
	$result = $report->budgetChart11($post);

// echo "<pre>"; print_r($result); die;
	
	/*
	$total_points_created = $result[0]['total_points_created'];
	$total_points_scanned = $result[0]['total_points_scanned'];
	$total_points_transferred = $result[0]['total_points_transferred'];
	*/

	if(is_array($result)){
		$return = array('success'=>1, 'data'=>$result);
	} else {
		$return = array('success'=>0,'data'=>array());
	}

	$api->setResponse($return, 200);
}

// end 19_april_2023