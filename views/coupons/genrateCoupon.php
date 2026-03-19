<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';

?>
<div class="content-wrapper">
  <h1 class="pageMainTitle">Generate Coupon</h1>
  <div class="card studentRegWrap mt20">
    <div class="card-body">
      <div class="box-body">
        <form id="dataForm" action="#" method="post">
        <input type="hidden" id="productExpDateTextField" value="">
        
          <div class="row form-group">
              
              <div class="col-sm-3">
              <label>Plant</label>
              <select class="form-control validate" id="plant" data-validate="" data-msg="Select Plant">
                <option value="">Select</option>
              </select>
            </div>

              <div class="col-sm-3">
              <label>Division/Unit</label>
              <select class="form-control validate" id="divisionunit" data-validate="" data-msg="Select Division/Unit">
                <option value="">Select</option>
              </select>
            </div>
            
            <div class="col-sm-3">
              <label>Coupon Type</label>
              <select class="form-control validate" id="couponType" data-validate="" data-msg="Select Coupon Type">
                <option value="">Select</option>
                
                 <?php if($permission_role==1 || isset($permission->coupon->innerCT)){ ?>
                    <option value="inner">Inner : Customers</option>
                <?php  } ?>
                
                <?php if($permission_role==1 || isset($permission->coupon->outerCT)){ ?>
                    <option value="outer">Outer: Retailers</option>
                <?php } ?>
                
              </select>
            </div>
        </div>
            
        <div class="row form-group">
            
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
            <div class="col-sm-3">
              <label>Product Series</label>
              <input type="text" class="form-control" id="productSeries" name="" readonly="">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-3">
              <label>Batch Size</label>
              <select class="form-control validate" id="batchSize" data-validate="" data-msg="Please select batch size">
                <option value="">Select</option>
              </select>
            </div>
            <div class="col-sm-3">
              <label>Batch Number</label>
              <input type="text" class="form-control validate" id="batchNumber" name="" data-validate="" data-msg="Please enter batch number" autocomplete="on">
            </div>
            <div class="col-sm-3">
              <label>Date of Mfg.</label>
              <input type="text" class="form-control validate" id="dateOfMfg" name="" data-validate="" data-msg="Please enter batch date" autocomplete="off">
            </div>
            <div class="col-sm-3">
              <label>Product MRP.</label>
              <input type="text" class="form-control" id="productMrp" name="" readonly="">
            </div>
          </div>
          
           <div class="row form-group">
            <div class="col-sm-3">
              <label>Agmark Series</label>
              <input type="text" class="form-control" id="agmarkSeries"  data-msg="Please enter Agmark Series" autocomplete="on" minlength="3" maxlength="16" >
            </div>
            <div class="col-sm-6">
              <label>Agmark Number (auto +1 for generated coupons)</label>
              <input type="number" min="0" class="form-control" id="agmarkNumber" data-msg="Please enter numeric Agmark Number" autocomplete="off" >
            </div>
            
            <div class="col-sm-3">
              <label>Product Exp. Date</label>
              <input type="text" class="form-control" id="productExpDate" name="" readonly="">
            </div>
            
          </div>



          <h3 class="title" style="margin-bottom: 15px;">Coupon Values</h3>
          <div class="row">
            <div class="col-sm-4">
              <div class="couponfaceValuesCard">
                  <div class="flexRow form-group" style="margin-bottom: 5px;">
                    <div class="col-fx-auto cpQty"><label>Face Value</label></div>
                    <div class="col-fx-auto cpPrice"><label>Qty.</label></div>
                  </div>
                  <div id="couponValues">
                    <!-- <div class="flexRow">
                      <div class="col-fx-auto cpPrice">100</div>
                      <div class="col-fx-auto cpQty">500</div>
                    </div> -->
                  </div>
              </div>
            </div>
            <div class="col-sm-5"></div>
            <div class="col-sm-3">
                <div class="form-group">
                  <label>Coupon Validity</label>
                  <input type="text" class="form-control validate" id="couponValidity" name="" data-validate="" data-msg="Please enter validity days" readonly="">
                </div>
            </div>
          </div>
          <div class="actions clearfix mt30 text-center" style="background:#eee; padding:10px; margin:40px -29px -31px;">
            <button class="btn btn-save btn-action" id="submitFormData">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
$isDatePicker = true;
$moduleScripts[] = VIEW_PATH.'/coupons/js/genrateCoupon.js';
include VIEW_DIR.'/includes/footer.php';
?>