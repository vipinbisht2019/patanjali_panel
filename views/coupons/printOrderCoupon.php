<?php 

require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/coupon.php';
include LIB_DIR."/qr/qrlib.php"; 

require_once $_SERVER['DOCUMENT_ROOT']."/PHP_CIPHER/php_aes_cipher_class.php";

$iv = 'fedcba9876543210'; #Same as in JAVA
$key = '0123456789abcdef'; #Same as in JAVA
// $webApplication = "https://lamiadvancesolutions.com/linking.php?&couponstring=";
$webApplication = "https://stagingpanel.lamiadvancesolutions.com/patanjali_panel/publicAuth/index.php?couponstring=";
//$webApplication = $_SERVER['HTTP_HOST']."/linking.php?&couponstring=";

$coupon = new coupon();
$id = $_GET['id'];


$esplCompanyID = 3; //from company table
$company = $coupon->company($esplCompanyID);

$data = $coupon->getOrderCouponData($id);
$printPageSpaceSettingData = $coupon->getPrintPageSpaceSetting();

//echo "<pre>";
//print_r($data); die;

$orderNo = 111;
$qrSize = 2;
$qrLevel = 'H'; //array('L','M','Q','H')

$PNG_TEMP_DIR = BASE_DIR.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'qr'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
$PNG_WEB_DIR = APP_URL.'/uploads/qr/temp/';

$filename = $PNG_TEMP_DIR."od{$orderNo}.png";
$errorCorrectionLevel = 'L';

$LamiCode = $company['manufacturer_code'];
$ClientCode = $company['client_code'];
$logo = APP_URL.'/uploads/logo/120/'.$company['logo'];
$printLogo = APP_URL.'/uploads/logo/Samco_black_logo_rsz.jpg';

?>
<html>
<head>
<style type="text/css">


page {
  background: white;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
  width:17.5cm;
}

@media print {
    * {
        -webkit-print-color-adjust: exact;
    }
}


.qrOrderBlock {
    /*border: #0e0e0e dotted 1px;*/
    position: relative;
    margin: <?php echo $printPageSpaceSettingData['space_two_row']." ". $printPageSpaceSettingData['space_two_col']." 0mm ".$printPageSpaceSettingData['space_left'] ?>; 
    width:<?php echo $printPageSpaceSettingData['coupon_width'] ?>;
    height: <?php echo $printPageSpaceSettingData['coupon_height'] ?>;
    display: inline-block;
    background-image: url("../assets/images/Paras_Coupon_final_12.5x7.5cm.jpg"); 
    background-repeat: no-repeat, no-repeat;
    background-size: 12.5cm 7.5cm;

}

#qrOrderBlock1{
    position: relative;
    margin-top:<?php echo $printPageSpaceSettingData['page_top_space']?> !important;
    width:<?php echo $printPageSpaceSettingData['coupon_width'] ?>;
    height: <?php echo $printPageSpaceSettingData['coupon_height'] ?>;
}

.qrImgWrap{
    position: absolute;
    width: 23mm;
    height: 25mm;
}

.qrBg{
    position: absolute;
    width: 116px;
    height: 116px;
    top: 93px;
    left: 28px;
}

#qrImg {
    position: absolute;
    bottom: -100px;
    left: 44px;
    width: 85px;
}

.validity {
    font-size: 12px;
    font-weight: 600;
    bottom: -220px;
    left: 15px;
    position: relative;
}
 .productInfo3 {
    text-align:center;
    font-size: 15px;
    font-weight: 600;
    bottom: -226px;
    left: 16px;
    position: relative;
    width: 27%;
    text-transform: capitalize;
}

 .agmark_number_increment
{
    font-size: 12px;
    font-weight: 600;
    bottom: -230px;;
    left: 16px;
    position: relative;
    width: 27%;
    
}

.productInfoLine {
    text-align: center; 
    font-size: 9px;
    bottom: 186px;
    left: 186px;
    position: absolute;
    color:white;
    font-family: Arial;
    color:gainsboro;
}


</style>


<script type="text/javascript">
/*
window.onload = function(e){ 
   
window.print();
   setTimeout(function(){
        window.close();
    }, 10000); 
  
   
}
*/
</script>


</head>
<body>
    <page>
	<div class="page">
<?php 
if($data){ 

    $i = 1;
	foreach($data as $v){
	    

    $validUpTo = $v['printedOn'] + ($v['validity'] * 86400);
    $validUpTo = date('d/m/Y', $validUpTo);

	$couponCode = $v['couponCode'];
	$filename = $PNG_TEMP_DIR."{$couponCode}.png";

	$ProductCode = $v['productSeries'];
	$Date = str_replace("/","",$validUpTo);
	$RandomCode = $v['couponCode'];
	
	//$couponString = $LamiCode.$ClientCode." ".$RandomCode;
	$couponString = $LamiCode."".$RandomCode;
	
	$couponStringWithDeepLink = $couponString;

	$encryptedCouponString = PHP_AES_Cipher::encrypt($key, $iv, $couponString);

	QRcode::png($webApplication.$couponString, $filename, $qrLevel, $qrSize, 0);
	// QRcode::png($webApplication.$encryptedCouponString, $filename, $qrLevel, $qrSize, 0);
	// QRcode::png($encryptedCouponString, $filename, $qrLevel, $qrSize, 0); 
      //    QRcode::png($couponString, $filename, $qrLevel, $qrSize, 0);
 
     $path =  $PNG_WEB_DIR.basename($filename);


?>

<div <?php if($i==1 || $i==2) { ?> id="qrOrderBlock<?php echo $i ?>" <?php } ?> class="qrOrderBlock" >
    
  <div class="qrImgWrap">
        <img src="<?php echo APP_URL; ?>/assets/img/qr-bg-small.png" class="qrBg">
        <img id="qrImg" src="<?php echo $path; ?>">
  </div>
  
  <div class="validity">Validity Upto: <?php echo $validUpTo ?></div>
  <div class="productInfo3"><?php echo $v['retailerCouponInfo'] ?></div>
 <div class="agmark_number_increment"><?php echo $v['agmark_number_increment']; ?></div>
  
  <span class="productInfoLine"><b><?php echo $v['retailerCouponInfo_2'] ?></b></span>


</div>  

<?php $i++; } 

} ?>	
	</div>
	</page>
</body>
<html>
