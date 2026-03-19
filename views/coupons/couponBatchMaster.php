<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
  <h1 class="pageMainTitle">Coupon Batch Master</h1>
  
  
  <div id="data_msg" class="notify" style="margin:0 20px 10px 20px;">
    <?php echo $_SESSION['redirectMessage']; 
    
          if(isset($_SESSION['redirectMessage']) && $_SESSION['redirectMessage']!="")
            unset($_SESSION['redirectMessage']);
    ?>
   </div>
   
   
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
              <select class="form-control validate" id="subCategory" data-validate="" data-msg="Please select sub category">
                <option value="">Select</option>
              </select>
            </div>
            <div class="col-sm-3">
              <label>Product</label>
              <select class="form-control validate" id="categoryProduct" data-validate="" data-msg="Please select category product">
                <option value="">Select</option>
              </select>
            </div>
            
            <div class="col-sm-1 btnCol">
              <button class="cs-btn-search cs-btn-lg cs-btn-block">Search</button>
            </div>
          </div>
        </form>
        <div id="formDataWrap" class="bulkEntryForm coupnMasterFrom" style="display: none;">
          <div class="flexRow headRow"></div>
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
          

          <div class="actions clearfix mt10">
            <button class="btn btn-save btn-action" id="submitFormData" style="display:none">Submit</button>
            <div id="addMoreRowWrap" style="float: right;">
              <a href="javascript:;" id="addMoreRow"><i class="mdi mdi-plus"></i> Add More</a>
            </div>
          </div>
        </div>

      </div>


    </div>
  </div>
</div>
<?php
$moduleScripts[] = VIEW_PATH.'/coupons/js/couponBatchMaster.js';
include VIEW_DIR.'/includes/footer.php';
?>