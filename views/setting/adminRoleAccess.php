<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';

require_once CLASS_DIR.'/plant.php';
$plantClass = new plant();
$plantArray = $plantClass->getPlantList();
$divisionArray = $plantClass->getAllDivisionList();

?>
<div class="content-wrapper">
  <h1 class="pageMainTitle">User Access</h1>
  <!--- START -->
  <div id="permissionBlocks" class="permissionBlocks">
    <form id="userPermissionForm">
      <div class="row" style="margin-bottom: 10px;">
        <div class="col-sm-6 col-xs-12">
          <select class="form-control" id="userRole" name="userRole">
            <option value="">Select User Role</option>
          </select>
        </div>
        <!-- <div class="col-sm-3 col-xs-12">
          <select class="form-control" name="user_id">
            <option value="">Select User</option>
          </select>
        </div> -->
      </div>
      <div class="accordion" id="accordion-7" role="tablist">
        <div class="card">
          <div class="card-header" role="tab" id="heading-7">
            <h5 class="mb-0">
            <input type="checkbox" name="up[coupon]" value="1"> Coupon
            <a class="collapsed" data-toggle="collapse" href="#collapse-7" aria-expanded="true" aria-controls="collapse-7"></a>
            </h5>
          </div>
          <div id="collapse-7" class="collapse show" role="tabpanel" aria-labelledby="heading-7" data-parent="#accordion-3">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-3"><label><input type="checkbox" name="up[coupon][master]" value="1"> Coupon Master</label></div>
                <div class="col-lg-3"><label><input type="checkbox" name="up[coupon][batchMaster]" value="1"> Coupon Batch Master</label></div>
                <div class="col-lg-3"><label><input type="checkbox" name="up[coupon][list]" value="1"> Coupon List</label></div>
                <div class="col-lg-3"><label><input type="checkbox" name="up[coupon][genrateCoupon]" value="1"> Generate Coupon</label></div>
                <div class="col-lg-3"><label><input type="checkbox" name="up[coupon][activateCoupon]" value="1"> Activate Coupon</label></div>
                <div class="col-lg-3"><label><input type="checkbox" name="up[coupon][printCoupon]" value="1"> Print Coupon</label></div>
                 <div class="col-lg-3"><label><input type="checkbox" name="up[coupon][innerCT]" value="1"> Coupon Type: Inner: Customers</label></div>
                  <div class="col-lg-3"><label><input type="checkbox" name="up[coupon][outerCT]" value="1"> Coupon Type: Outer: Retailers</label></div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header" role="tab" id="heading-8">
            <h5 class="mb-0">
            <input type="checkbox" name="up[loyalty]" value="1"> Loyalty Authorization
            <a class="collapsed" data-toggle="collapse" href="#collapse-8" aria-expanded="true" aria-controls="collapse-8"></a>
            </h5>
          </div>
          <div id="collapse-8" class="collapse show" role="tabpanel" aria-labelledby="heading-8" data-parent="#accordion-3">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-3"><label><input type="checkbox" name="up[loyalty][import]" value="1"> Import/Export</label></div>
                <div class="col-lg-3"><label><input type="checkbox" name="up[loyalty][authorisation]" value="1"> Authorization</label></div>
                <div class="col-lg-3"><label><input type="checkbox" name="up[loyalty][deauthorization]" value="1"> Deauthorization</label></div>
                <div class="col-lg-3"><label><input type="checkbox" name="up[loyalty][users]" value="1"> Users</label></div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header" role="tab" id="heading-9">
            <h5 class="mb-0">
            <input type="checkbox" name="up[inventory]" value="1"> Category/Product
            <a class="collapsed" data-toggle="collapse" href="#collapse-9" aria-expanded="true" aria-controls="collapse-9"></a>
            </h5>
          </div>
          <div id="collapse-9" class="collapse show" role="tabpanel" aria-labelledby="heading-9" data-parent="#accordion-3">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-3"><label><input type="checkbox" name="up[product][list]" value="1"> Product List</label></div>
                <div class="col-lg-3"><label><input type="checkbox" name="up[product][import]" value="1"> Import Product</label></div>
                <div class="col-lg-3"><label><input type="checkbox" name="up[product][category]" value="1"> Category</label></div>
              </div>
            </div>
          </div>
        </div>
        
        
         <div class="card">
          <div class="card-header" role="tab" id="heading-9">
            <h5 class="mb-0">
            <input type="checkbox" name="up[plant]" value="1"> Plant Permission
            <a class="collapsed" data-toggle="collapse" href="#collapse-9" aria-expanded="true" aria-controls="collapse-9"></a>
            </h5>
          </div>
          <div id="collapse-9" class="collapse show" role="tabpanel" aria-labelledby="heading-9" data-parent="#accordion-3">
            <div class="card-body">
              <div class="row">
                  
            <?php if(is_array($plantArray) && count($plantArray) > 0 ):
                    foreach($plantArray as $plantData):
            ?>
                <div class="col-lg-3"><label><input type="checkbox" name="up[plant][<?php echo $plantData['plant_id'] ?>]" value="1"> <?php echo $plantData['plant_name']." (".$plantData['plant_code'].")"; ?> </label></div>
                
            <?php   endforeach; 
                    endif; ?>
               
               <div class="col-lg-3"><label><input type="checkbox" name="up[plant][addnlist]" value="1"> Add/View Plant List</label></div>
         
              </div>
            </div>
          </div>
        </div>
        
        
        
        <div class="card">
          <div class="card-header" role="tab" id="heading-9">
            <h5 class="mb-0">
            <input type="checkbox" name="up[division]" value="1"> Plant Division/Unit Permission
            <a class="collapsed" data-toggle="collapse" href="#collapse-9" aria-expanded="true" aria-controls="collapse-9"></a>
            </h5>
          </div>
          <div id="collapse-9" class="collapse show" role="tabpanel" aria-labelledby="heading-9" data-parent="#accordion-3">
            <div class="card-body">
              <div class="row">
                  
            <?php if(is_array($divisionArray) && count($divisionArray) > 0 ):
                    foreach($divisionArray as $divisionData):
            ?>
             
                <div class="col-lg-3"><label><input type="checkbox" name="up[division][<?php echo $divisionData['unit_id'] ?>]" value="1"> <?php echo $divisionData['unit_name']." (".$divisionData['unit_code'].")"; ?> </label></div>
                
            <?php   endforeach; 
                    endif; ?>
 
               <div class="col-lg-3"><label><input type="checkbox" name="up[division][adddivision]" value="1"> Add/View Division/Unit List</label></div>
               
               
              </div>
            </div>
          </div>
        </div>
        
        
        
        

        <div class="card">
          <div class="card-header" role="tab" id="heading-10">
            <h5 class="mb-0">
            <input type="checkbox" name="up[report]" value="1"> Report
            <a class="collapsed" data-toggle="collapse" href="#collapse-10" aria-expanded="true" aria-controls="collapse-10"></a>
            </h5>
          </div>
          <div id="collapse-10" class="collapse show" role="tabpanel" aria-labelledby="heading-10" data-parent="#accordion-3">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-3"><label><input type="checkbox" name="up[report][marketInventory]" value="1"> Market Inventory</label></div>
                <div class="col-lg-3"><label><input type="checkbox" name="up[report][scanedTrendModel]" value="1"> Scaned Trend Model</label></div>
                <div class="col-lg-3"><label><input type="checkbox" name="up[report][scanedTrendLocation]" value="1"> Scaned Trend Location</label></div>
                <div class="col-lg-3"><label><input type="checkbox" name="up[report][scanTrendCustomer]" value="1"> Scan Trend Customer</label></div>
              </div>
              <div class="row">
                <div class="col-lg-3"><label><input type="checkbox" name="up[report][pointSummary]" value="1"> Point Summary</label></div>
                <div class="col-lg-3"><label><input type="checkbox" name="up[report][encashmentPending]" value="1"> Encashment Pending</label></div>
                <div class="col-lg-3"><label><input type="checkbox" name="up[report][couponTrailAudit]" value="1"> Coupon Trail Audit</label></div>
                <div class="col-lg-3"><label><input type="checkbox" name="up[report][userPointStatment]" value="1"> User Point Statment</label></div>
              </div>
              <div class="row">
                <div class="col-lg-3"><label><input type="checkbox" name="up[report][scanAlert]" value="1"> Scan Alert</label></div>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header" role="tab" id="heading-11">
            <h5 class="mb-0">
            <input type="checkbox" name="up[customer]" value="1"> Customer
            <a class="collapsed" data-toggle="collapse" href="#collapse-11" aria-expanded="true" aria-controls="collapse-11"></a>
            </h5>
          </div>
          <div id="collapse-11" class="collapse show" role="tabpanel" aria-labelledby="heading-11" data-parent="#accordion-3">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-3"><label><input type="checkbox" name="up[customer][feedback]" value="1"> Feedback</label></div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-success">Assign Rights</button>
      </div>
    </form>
  </div>
  <!--- END -->
</div>
<?php
  $moduleScripts[] = VIEW_PATH.'/setting/js/adminRoleAccess.js';
  include VIEW_DIR.'/includes/footer.php';
?>