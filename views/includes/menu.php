<?php 
/****************** Check gift allow to user by CHANDRA *******************/

require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/coupon.php';
require_once CLASS_DIR.'/api.php';

$coupon = new coupon();
$api = new api();

$companyId = 3; //from company table
$companyData = $coupon->company($companyId);
$manufactureCode = $companyData['manufacturer_code'];
$clientCode = $companyData['client_code'];

$giftingAllow = 0;

$checkGiftAllow = $api->callLamiService('/check/gift/allow', array('manufactureCode'=>$manufactureCode,"clientCode"=>$clientCode)); 

if($checkGiftAllow['data']['is_gifting_allow']==1)
    $giftingAllow = 1;
 
 /****************** Check gift allow to user ************************/
 

$permission = $_SESSION['ADMIN_USER']['ACCESS'];
$permission_role = $_SESSION['ADMIN_USER']['ROLE'];

//echo "<pre>";
//print_r($permission); die;

?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <?php if($permission_role==1 || isset($permission->coupon)){ ?>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo APP_URL; ?>/newdashboard">
        <i class="mdi mdi-home menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <?php } ?>

    <?php if($permission_role==1 || isset($permission->report)){ ?>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-menu-report" aria-expanded="false" aria-controls="ui-menu-report">
        <i class="mdi mdi-chart-line menu-icon"></i>
        <span class="menu-title">Report</span>
        <i class="menu-arrow"></i>
      </a>

     <div class="collapse" id="ui-menu-report">
        <ul class="nav flex-column sub-menu">
          <?php if($permission_role==1 || isset($permission->report->marketInventory)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/report/marketInventorySummary">Market Inventory</a></li>
          <?php } ?>
          <?php if($permission_role==1 || isset($permission->report->scanedTrendModel)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/report/scanTrendModule">Scaned Trend Model</a></li>
          <?php } ?>
        <!--   <?php // if($permission_role==1 || isset($permission->report->scanedTrendModel)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php // echo APP_URL; ?>/report/ByDate_scanTrendModule">Scaned Trend Model By Date</a></li>
          <?php // } ?> -->
          <?php if($permission_role==1 || isset($permission->report->scanedTrendLocation)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/report/scanTrendLocation">Scaned Trend Location</a></li>
          <?php } ?>
          <?php if($permission_role==1 || isset($permission->report->scanTrendCustomer)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/report/scanTrendCustomer">Scan Trend-Customer</a></li>
          <?php } ?>

        <!-- start 15_may_2023 -->  
        <!--  <?php // if($permission_role==1 || isset($permission->report->ByDate_scanTrendCustomer)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php // echo APP_URL; ?>/report/ByDate_scanTrendCustomer">Scan Trend-Customer <br>By Month</a></li>
          <?php // } ?> -->
        <!-- end 15_may_2023 -->

        <!--
          <?php // if($permission_role==1 || isset($permission->report->scanTrendCustomerMonthly)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php // echo APP_URL; ?>/report/scanTrendCustomerMonthly">Monthly Scan Trend-Customer</a></li>
          <?php // } ?>
        -->
          
          <?php if($permission_role==1 || isset($permission->report->pointSummary)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/report/pointSummary">Point Summary</a></li>
          <?php } ?>
          <?php if($permission_role==1 || isset($permission->report->encashmentPending)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/report/encashmentPending">Encashment Pending</a></li>
          <?php } ?>
          <?php if($permission_role==1 || isset($permission->report->couponTrailAudit)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/report/couponTrialAudit">Coupon Trail Audit</a></li>
          <?php } ?>
          <?php if($permission_role==1 || isset($permission->report->userPointStatment)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/report/userPointStatment">User Point Statement</a></li>
         
          <?php } ?>
          <?php if($permission_role==1 || isset($permission->report->scanAlert)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/report/scanAlert">Scan Alert</a></li>
          
           <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/report/multiScan">Multi Scan </a></li>
           
          <?php } ?>
          
          
        </ul>
      </div>
    </li>
    <?php } ?>
    
    
    
  <?php if($permission_role==1 || isset($permission->plant)){ ?>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-menu-plant" aria-expanded="false" aria-controls="ui-menu-plant">
        <i class="mdi mdi-city menu-icon"></i>
        <span class="menu-title">Plant</span>
        <i class="menu-arrow"></i>
      </a>
      
      <div class="collapse" id="ui-menu-plant">
        <ul class="nav flex-column sub-menu">
        <?php if($permission_role==1 || isset($permission->plant->addnlist)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/plant">Plant List</a></li>
        <?php } ?>
           
        <?php if($permission_role==1 || isset($permission->division->adddivision)){ ?>
           <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/division">Division/Unit List</a></li>
        <?php } ?>
           
        </ul>
      </div>
      
    </li>
    <?php } ?>
    
    
<?php if($permission_role==1 || isset($permission->product->category)){ ?>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-menu-category" aria-expanded="false" aria-controls="ui-menu-category">
        <i class="mdi mdi-folder menu-icon"></i>
        <span class="menu-title">Category / Product Master</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-menu-category">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/category">Main Category</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/subCategory">Sub Category</a></li>
           <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/scan_category_restriction/cslist"> Category Scan Restriction</a></li>
           
           <?php if($permission_role==1 || isset($permission->product->import)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/importProducts">Import Product</a></li>
          <?php } ?>
          <?php if($permission_role==1 || isset($permission->product->list)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/products">Products</a></li>
          <?php } ?>
          
          
        </ul>
      </div>
    
    </li>
    <?php } ?>
    
    
    
<?php if($permission_role==1 || isset($permission->coupon)){ ?>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-menu-coupon" aria-expanded="false" aria-controls="ui-menu-coupon">
        <i class="mdi mdi-tag menu-icon"></i>
        <span class="menu-title">Coupon</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-menu-coupon">
        <ul class="nav flex-column sub-menu">
          <?php if($permission_role==1 || isset($permission->coupon->master)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/couponMaster">Coupon Master</a></li>
          <?php } ?>
          <?php if($permission_role==1 || isset($permission->coupon->batchMaster)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/couponBatchMaster">Coupon Batch Master</a></li>
          <?php } ?>
          <?php if($permission_role==1 || isset($permission->coupon->genrateCoupon)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/genrateCoupons">Generate Coupon</a></li>
          <?php } ?>
          <?php if($permission_role==1 || isset($permission->coupon->list)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/couponOrders">Coupons</a></li>
          
        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/printPageSpace"> Set Print Paper Space </a></li>
             
          <?php } ?>
        </ul>
      </div>
    </li>
    <?php } ?>
    
    

    <?php if($permission_role==1 || isset($permission->loyalty)){ ?>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-menu-loyalty" aria-expanded="false" aria-controls="ui-menu-loyalty">
        <i class="mdi mdi-cube menu-icon"></i>
        <span class="menu-title">Loyalty/Authorisation  </span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-menu-loyalty">
        <ul class="nav flex-column sub-menu">
          <?php if($permission_role==1 || isset($permission->loyalty->users)){ ?>
          <!-- <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/users">Users</a></li> -->
          <?php } ?>
          <?php if($permission_role==1 || isset($permission->loyalty->import)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/loyaltyImportExport">Import/Export</a></li>
          <?php } ?>
          <?php if($permission_role==1 || isset($permission->loyalty->authorisation)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/authorisation/groupList">Main Group List</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/authorisation/subGroupList">Sub Group List</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/authorisation/groupCompanyList">Group List</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/authorisation/alist">Authorization List</a></li>
          <?php } ?>
          <?php if($permission_role==1 || isset($permission->loyalty->deauthorization)){ ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/deauthorisation/dlist">Deauthorization List</a></li> 
          <?php } ?>
        </ul>
      </div>
    </li>
    <?php } ?>
    

    <?php if($permission_role==1 || isset($permission->customer->feedback)){ ?>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-menu-feedback" aria-expanded="false" aria-controls="ui-menu-feedback">
                <i class="mdi mdi-comment-text menu-icon"></i>
                <span class="menu-title">Feedback</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-menu-feedback">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/feedbacks">Feedback</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/feedback/options">Feedback Options</a></li>
                </ul>
            </div>
        </li>
   <?php } ?>
   
   
   <?php if($giftingAllow) { ?>
   
     <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-menu-giftsection" aria-expanded="false" aria-controls="ui-menu-category">
        <i class="mdi mdi-folder menu-icon"></i>
        <span class="menu-title">Gift Section</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-menu-giftsection">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/dispatchVendorList">Dispatch Vendor List</a></li>
            
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/giftRequest"> Customer's Gift Request</a></li>
          
        </ul>
      </div>
    </li>
    
    <?php } ?>
    

    <?php if($permission_role==1){ ?>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-menu-setting" aria-expanded="false" aria-controls="ui-menu-setting">
        <i class="mdi mdi-settings menu-icon"></i>
        <span class="menu-title">Setting</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-menu-setting">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/adminUsers">Admin Users</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/adminRoles">User Roles</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/adminRoleAccess">User Roles Access</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/setting/adminNumbers">Admin Number</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/setting/scanLimit">Scan Limit</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/userRoles">User Roles</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo APP_URL; ?>/setting/bonusPercent">Bouns Percent</a></li>
        </ul>
      </div>
    </li>
    <?php } ?>
    
    
    
    
  
  

  </ul>
</nav>