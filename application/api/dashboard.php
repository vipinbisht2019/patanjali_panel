<?php 

require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/report.php';
require_once CLASS_DIR.'/api.php';

$api = new api();
$report = new report();

if(isset($_GET['controller']) && $_GET['controller']=='dashboard'){

	$data = array();

	$date = date('Y-m-d', strtotime('-1 day', time()));
	$countScanAlert = $report->countScanAlert($date);
	$countActivatedCoupon = $report->countActivatedCoupon($date);
	$countScannedCoupons = $report->countScannedCoupons($date);
	$countAdminReceivedPoints = $report->countAdminReceivedPoints($date);

	$data['count'] = array(
		'alert'=>$countScanAlert,
		'activated'=>$countScanAlert,
		'scanned'=>$countScanAlert,
		'received'=>$countScanAlert,
	);

	$return = array('success'=>1, 'data'=>$data);
	$api->setResponse($return, 200);
}
