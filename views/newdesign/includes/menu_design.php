
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

<div class="main-sidebar sidebar-style-2">
<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="<?php echo APP_URL; ?>/newdashboard"> <!--<img alt="image" src="views/newdesign/assets/img/logo.png" class="header-logo" />--> <span
        class="logo-name" style="font-size:17px;">Demo Admin Panel</span>
    </a>
  </div>
  <ul class="sidebar-menu">
    
    <?php if($permission_role==1 || isset($permission->coupon)){ ?>

    <li class="dropdown active">
      <a href="<?php echo APP_URL; ?>/newdashboard" class="nav-link"><i data-feather="home"></i><span>Dashboard</span></a>
    </li>

    <?php } ?>

    <?php if($permission_role==1 || isset($permission->report)){ ?>

    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i
          data-feather="trending-up"></i><span>Report</span></a>
      <ul class="dropdown-menu">
        <?php if($permission_role==1 || isset($permission->report->marketInventory)){ ?>
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/report/marketInventorySummary">Market Inventory</a></li>
        <?php } ?>
        
        <?php if($permission_role==1 || isset($permission->report->scanedTrendModel)){ ?>
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/report/scanTrendModule">Scaned Trend Model</a></li>
         <?php } ?>   
         
        <?php if($permission_role==1 || isset($permission->report->scanedTrendLocation)){ ?>
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/report/scanTrendLocation">Scaned Trend Location</a></li>
         <?php } ?>   
         
        <?php if($permission_role==1 || isset($permission->report->scanTrendCustomer)){ ?>
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/report/scanTrendCustomer">Scaned Trend Customer</a></li>
         <?php } ?>   
         
        <?php if($permission_role==1 || isset($permission->report->pointSummary)){ ?>
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/report/pointSummary">Point Summary</a></li>
         <?php } ?>   
         
        <?php if($permission_role==1 || isset($permission->report->encashmentPending)){ ?>
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/report/encashmentPending">Encashment Pending</a></li>
         <?php } ?>   
         
        <?php if($permission_role==1 || isset($permission->report->couponTrailAudit)){ ?>
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/report/couponTrialAudit">Coupon Trail Audit</a></li>
         <?php } ?>   
         
        <?php if($permission_role==1 || isset($permission->report->userPointStatment)){ ?>
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/report/userPointStatment">User Point Statement</a></li>
         <?php } ?>   
         
        <?php if($permission_role==1 || isset($permission->report->scanAlert)){ ?>
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/report/scanAlert">Scan Alert</a></li>
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/report/multiScan">Multi Scan</a></li>
         <?php } ?>   

      </ul>
    </li>

    <?php } ?>

    
  <?php if($permission_role==1 || isset($permission->plant)){ ?>

    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="trello"></i><span>Plant</span></a>
      <ul class="dropdown-menu">

      <?php if($permission_role==1 || isset($permission->plant->addnlist)){ ?>
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/plant">Plant List</a></li>
         <?php } ?>   
         
        <?php if($permission_role==1 || isset($permission->plant->adddivision)){ ?>
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/division">Division/Unit List</a></li>
         <?php } ?> 

      </ul>
    </li>

    <?php } ?>        

            
  <?php if($permission_role==1 || isset($permission->product->category)){ ?>

    <li class="dropdown">
    <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="folder"></i><span>Category / Product Master</span></a>
            <ul class="dropdown-menu">
            
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/category">Main Category</a></li>
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/subCategory">Sub Category</a></li>
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/scan_category_restriction/cslist"> Category Scan Restriction</a></li>

    <?php if($permission_role==1 || isset($permission->product->import)){ ?>
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/importProducts">Import Product</a></li>
        <?php } ?>   
        
        <?php if($permission_role==1 || isset($permission->product->list)){ ?>
            <li><a class="nav-link" href="<?php echo APP_URL; ?>/products">Products</a></li>
        <?php } ?> 
        
    </ul>
    </li>

    <?php } ?>  


    
    
  <?php if($permission_role==1 || isset($permission->coupon)){ ?>

<li class="dropdown">
  <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="tag"></i><span>Coupon</span></a>
  <ul class="dropdown-menu">

    <?php if($permission_role==1 || isset($permission->coupon->master)){ ?>
        <li><a class="nav-link" href="<?php echo APP_URL; ?>/couponMaster">Coupon Master</a></li>
    <?php } ?>   
     
    <?php if($permission_role==1 || isset($permission->coupon->batchMaster)){ ?>
        <li><a class="nav-link" href="<?php echo APP_URL; ?>/couponBatchMaster">Coupon Batch Master</a></li>
    <?php } ?>   
    
    <?php if($permission_role==1 || isset($permission->coupon->genrateCoupon)){ ?>
        <li><a class="nav-link" href="<?php echo APP_URL; ?>/genrateCoupons">Generate Coupon</a></li>
    <?php } ?>   
    
    <?php if($permission_role==1 || isset($permission->coupon->list)){ ?>
        <li><a class="nav-link" href="<?php echo APP_URL; ?>/couponOrders">Coupons</a></li>
    <?php } ?>   
    
        <li><a class="nav-link" href="<?php echo APP_URL; ?>/printPageSpace"> Set Print Paper Space</a></li>
    
  </ul>
</li>

<?php } ?>        
   
<?php if($permission_role==1 || isset($permission->loyalty)){ ?>

<li class="dropdown">
  <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="box"></i><span>Loyalty/Authorization </span></a>
  <ul class="dropdown-menu">

  <?php if($permission_role==1 || isset($permission->loyalty->import)){ ?>
        <li><a class="nav-link" href="<?php echo APP_URL; ?>/loyaltyImportExport">Import/Export</a></li>
     <?php } ?>   
     
     <?php if($permission_role==1 || isset($permission->loyalty->authorisation)){ ?>
        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/authorisation/groupList">Main Group List</a></li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/authorisation/subGroupList">Sub Group List</a></li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/authorisation/groupCompanyList">Group List</a></li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/authorisation/alist">Authorization List</a></li>
    <?php } ?>
     
    <?php if($permission_role==1 || isset($permission->loyalty->deauthorization)){ ?>
        <li><a class="nav-link" href="<?php echo APP_URL; ?>/deauthorisation/dlist">Deauthorization List</a></li>
     <?php } ?> 

  </ul>
</li>

<?php } ?>        


<?php if($permission_role==1 || isset($permission->customer->feedback)){ ?>

<li class="dropdown">
  <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="message-square"></i><span>Feedback</span></a>
  <ul class="dropdown-menu">

        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/feedbacks">Feedback</a></li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/feedback/options">Feedback Options</a></li>    

  </ul>
</li>

<?php } ?> 


<?php if($giftingAllow){ ?>

<li class="dropdown">
  <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Gift Section</span></a>
  <ul class="dropdown-menu">

        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/dispatchVendorList">Dispatch Vendor List</a></li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/giftRequest"> Customer's Gift Request</a></li>    

  </ul>
</li>

<?php } ?> 



<?php if($permission_role==1){ ?>

<li class="dropdown">
  <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="settings"></i><span>Setting</span></a>
  <ul class="dropdown-menu">

        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/adminUsers">Admin Users</a></li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/adminRoles">User Roles</a></li>  
        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/adminRoleAccess">User Roles Access</a></li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/setting/adminNumbers">Admin Number</a></li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/setting/scanLimit">Scan Limit</a></li>  
        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_URL; ?>/userRoles">User Roles</a></li>  
        

  </ul>
</li>

<?php } ?> 


  </ul>
</aside>
</div>
<!-- Main Content -->
