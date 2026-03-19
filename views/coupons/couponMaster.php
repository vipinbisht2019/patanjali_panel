<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
  <h1 class="pageMainTitle">Coupon Master</h1>
  <div class="card studentRegWrap mt20">
    <div class="card-body">
      <div class="box-body">
        <form id="searchForm" action="#" method="post">
          <div class="row form-group">
              
        <div class="col-sm-3">
              <label class="filter-label">Plant</label>
              <select class="form-control validate" id="plant" data-validate="" data-msg="Select Plant">
                <option value="">All</option>
              </select>
        </div>
        
            <div class="col-sm-3">
              <label>Main Category</label>
              <select class="form-control validate" id="mainCategory" data-validate="" data-msg="Please select main category">
                <option value="">Select</option>
              </select>
            </div>
            <div class="col-sm-3">
              <label>Sub Category</label>
              <select class="form-control" id="subCategory">
                <option value="">Select</option>
              </select>
            </div>
            
            <div class="col-sm-2 btnCol">
              <button class="cs-btn-search cs-btn-lg cs-btn-block">Search</button>
            </div>
          </div>
        </form>
        <div id="formDataWrap" class="bulkEntryForm coupnMasterFrom">
          <div class="flexRow headRow">
            <div class="fx-col-auto">Product Category</div>
            <div class="fx-col-auto">Product Name</div>
            <div class="fx-col-100">Validity Period (Days)</div>
            <div class="fx-col-100">Face Value</div>
            <!-- <div class="fx-col-100">All Handling Charges</div>
            <div class="fx-col-100">Sales Statff Handling Charges</div>
            <div class="fx-col-100">Retailer Handling Charges</div>
            <div class="fx-col-100">Total Value</div> -->
            
          </div>
          <div id="formDataRows">
            <!-- <div class="rowSet">
              <div class="flexRow item-row">
                <div class="fx-col-auto txt">Product Category</div>
                <div class="fx-col-auto txt">Product Name</div>
                <div class="fx-col-100"><input type="text" class="form-control" name="" placeholder="Face Value"></div>
                <div class="fx-col-100"><input type="text" class="form-control" name="" placeholder="0.00"></div>
                <div class="fx-col-100"><input type="text" class="form-control" name="" placeholder="0.00"></div>
                <div class="fx-col-100"><input type="text" class="form-control" name="" placeholder="0.00"></div>
                <div class="fx-col-100"><input type="text" class="form-control" name="" placeholder="120" readonly=""></div>
                <div class="fx-col-100"><input type="text" class="form-control" name="" placeholder="Days"></div>
              </div>
            </div> -->
          </div>
          <div class="actions clearfix">
            <button class="btn btn-save btn-action" id="submitFormData">Submit</button>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>
<?php
$moduleScripts[] = VIEW_PATH.'/coupons/js/couponMaster.js';
include VIEW_DIR.'/includes/footer.php';
?>