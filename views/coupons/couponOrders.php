<?php
require_once '../../config.php';

require_once CLASS_DIR.'/dbclass.php';

$db = new dbclass();
$query="SELECT logo FROM company ORDER BY id DESC LIMIT 1";
$company = $db->fetchRow($query);


include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
	<h1 class="pageMainTitle">Coupon Orders</h1>
	<!-- <section class="content-header clfix">
          <a href="<?php echo APP_URL; ?>/category/add" class="btn btn-cs btn-add" id="addNewRecord"><i class="mdi mdi-plus"></i> Add New</a>
          <a href="javascript:;" class="btn btn-dark btn-fw openFilterPanel"><i class="mdi mdi-filter"></i> Filter</a>      
    </section> -->

<form action="<?php echo API_URL.'/coupon/download'?>" method="POST">
  <section class="content-header clfix">
    <div class="topLeftFilters">
      
    <div class="row">
        
          <div class="col-sm-3">
              <label class="filter-label">Plant</label>
              <select class="form-control validate" id="plant" data-validate="" data-msg="Select Plant">
                <option value="">All</option>
              </select>
        </div>
        
         <div class="col-sm-3">
              <label class="filter-label">Division/Unit</label>
              <select class="form-control validate" id="divisionunit" data-validate="" data-msg="Select Division/Unit">
                <option value="">All</option>
              </select>
        </div>
        
        <div class="col-sm-3">
          <label class="filter-label">Order No</label>
          <input type="text" class="form-control" id="filterOrderNo" name="">
        </div>
        <div class="col-sm-3">
          <label class="filter-label">Product Name</label>
          <input type="text" class="form-control" id="filterProductName" name="">
        </div>
        
        <div class="col-sm-3">
          <label class="filter-label">Coupon Type</label>
          <select class="form-control" id="filterCouponType">
                    <option value="">Select</option>
                    
              <?php if($permission_role==1 || isset($permission->coupon->innerCT)){ ?>
                    <option value="inner">Inner : Customers</option>
                <?php  } ?>
                
                <?php if($permission_role==1 || isset($permission->coupon->outerCT)){ ?>
                    <option value="outer">Outer: Retailers</option>
                <?php } ?>
          </select>
        </div>
        
        
         <div class="col-sm-3">
              <label class="filter-label">Main Category</label>
              <select class="form-control validate" id="mainCategory" data-validate="" data-msg="Please select main category">
                <option value="">Select</option>
              </select>
            </div>
            
            <div class="col-sm-3">
              <label class="filter-label">Sub Category</label>
              <select class="form-control validate" id="subCategory" data-validate="" data-msg="Please select sub category">
                <option value="">Select</option>
              </select>
            </div>
            
            <div class="col-sm-3">
              <label class="filter-label">Product</label>
              <select class="form-control validate" id="categoryProduct" data-validate="" data-msg="Please select category product">
                <option value="">Select</option>
              </select>
            </div>
            
    </div>
    
    <div class="row">
        
         <div class="col-sm-3">
          <label class="filter-label">Batch No.</label>
          <input type="text" class="form-control" id="filterBatchNo" name="">
        </div>
        
       <div class="col-sm-3">
          <label class="filter-label">Date of Mfg.</label>
          <input type="text" class="form-control" id="filterDateOfMfg" name="">
        </div>
        <div class="col-sm-3">
          <label class="filter-label">Status</label>
          <select class="form-control" id="filterStatus">
            <option value="">All</option>
            <option value="1">Active</option>
            <option value="2">Pending</option>
          </select>
        </div>
        
    </div>
       
        
     <div class="row form-group">
        <div class="col-sm-6"><br> 
          <a href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a>  
           <input type="submit" value="Download Full Data" id="download_full_data" class="btn btn-cs"> 
        </div>
        
    </div>
     
    </div>
  </section>
</form>
	<div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
		<div class="thead">
			<div class="tr">
        <div class="th">Order No</div>
        <div class="th">Product Name</div>
        <div class="th">Batch No</div>
        <div class="th">Batch Size</div>
        <div class="th">Plant Id </div>
        <div class="th">Division Id </div>
        <div class="th">Coupon Sent To Printer</div>
        <div class="th">Coupon Not Sent To Printer</div>
        <div class="th">Date Of Mfg.</div>
        <div class="th">Status</div>
        <div class="th">Created On</div>
				<div class="th action">Action</div>
			</div>
		</div>
		<div class="tbody" id="dataTableResult"></div>
	</div>
	<div id="dataPagination"></div>
	
</div>


<div class="c-modal" style="" id="viewModal">
   <div class="modal" id="model_s8rhvjkUrc" style="width:780px">
      <div class="modal-header">
         <button type="button" class="ajax-model-close close fr" data-dismiss="modal" aria-hidden="true"><i class="icn-close"></i></button>
         <div id="OrderNo" style="height: 21px;">View</div>
      </div>
      <form action="#" id="editForm" class="custom-form">
         <input type="hidden" id="orderId" name="orderId" value="0">
         <div class="modal-body" style="position: relative;">

          <div class="row form-group">
            <div class="col-sm-3">
              <label>Category</label>
              <span class="labelItemData" id="mainCategory1"></span>
            </div>
            <div class="col-sm-3">
              <label>Product</label>
              <span class="labelItemData" id="categoryProduct1"></span>
            </div>
            <div class="col-sm-3">
              <label>Product Series</label>
              <span class="labelItemData" id="productSeries"></span>
            </div>
            <div class="col-sm-3">
              <label>Product MRP.</label>
              <span class="labelItemData" id="productMrp"></span>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-3">
              <label>Batch Size</label>
              <span class="labelItemData" id="batchSize"></span>
            </div>
            <div class="col-sm-3">
              <label>Batch Number</label>
              <span class="labelItemData" id="batchNumber1"></span>
            </div>
            <div class="col-sm-3">
              <label>Date of Mfg.</label>
              <span class="labelItemData" id="dateOfMfg"></span>
            </div>
            <div class="col-sm-3">
              <label>Coupon Validity</label>
              <span class="labelItemData" id="couponValidity"></span>
            </div>
          </div>
          
        <div class="row form-group">
           <div class="col-sm-3">
              <label>Agmark Series</label>
              <span class="labelItemData" id="agmarkSeries"></span>
            </div>
            
            <div class="col-sm-3">
              <label>Agmark Start Number</label>
              <span class="labelItemData" id="agmarkStartNum"></span>
            </div>
            
            <div class="col-sm-3">
              <label>Agmark End Number</label>
              <span class="labelItemData" id="agmarkEndNum"></span>
            </div>
            
            <div class="col-sm-3">
              <label>Product Exp. Date</label>
              <span class="labelItemData" id="productExpdate"></span>
            </div>
        </div>

          <h3 class="title" style="margin-bottom: 15px;">Coupon Values</h3>
          <div class="row" style="min-height: 200px;">
            <div class="col-sm-5">
              <div class="couponfaceValuesCard">
                  <div class="flexRow form-group" style="margin-bottom: 5px;">
                    <div class="col-fx-auto cpQty"><label>Face Value</label></div>
                    <div class="col-fx-auto cpPrice"><label>Qty.</label></div>
                  </div>
                  <div id="couponValues"></div>
              </div>
            </div>
            <div class="col-sm-7">
              <div class="qrOrderBlock">
                <div style="padding-right: 100px;">
                  <div><img src="<?php echo APP_URL; ?>/publicAuth/lamipages/img/logo-big.png" width="50px"></div>
                  <div><label class="qrLabel">Product Name:</label> <span class="qrLabelVal" id="qrProductName"></span></div>
                  <div class="row">
                    <div class="col-sm-6"><label class="qrLabel">Size:</label> <span class="qrLabelVal" id="qrSize"></span></div>
                    <div class="col-sm-6"><label class="qrLabel">Points:</label> <span class="qrLabelVal" id="qrPoints"></span></div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6"><label class="qrLabel">Code No:</label> <span class="qrLabelVal" id="qrCodeNo"></span></div>
                    <div class="col-sm-6"><label class="qrLabel">Valid Up To:</label> <span class="qrLabelVal" id="qrValidUpTo"></span></div>
                  </div>
                </div>

             

              </div>
            </div>
          </div>
          
   
          <div style="position: absolute; right: 10px; bottom: 10px;display:none" id="innerCouponTypeCustomer">
                <?php if($permission_role==1 || isset($permission->coupon->activateCoupon)){ ?>
                
                    <button type="button" class="btn cs-btn btn-primary" id="generated">Coupon Generated. Waiting to print</button>
                    <button type="button" class="btn cs-btn btn-primary" id="activateInnerCoupon">Activate</button>
                    
            <!-- start 25_aug_2023 -->         
                <?php
                  if($_SESSION['ADMIN_USER']['ID'] == 1) {
                ?>
                    <button type="button" class="btn cs-btn btn-primary" id="adminActivateInnerCoupon"  style="float: left;  margin-left: -100px;">Activate</button>
                <?php } ?>     
            <!-- end 25_aug_2023 --> 
                
                <?php } ?>
                
                <?php if($permission_role==1 || isset($permission->coupon->printCoupon)){ ?>
                        <button type="button" class="btn cs-btn btn-dark" id="printInnerCoupons">Generate Coupon</button>
                <?php } ?>
          </div>
          
          
          <div style="position: absolute; right: 10px; bottom: 10px;display:none" id="outerCouponTypeRetailer">
                <?php if($permission_role==1 || isset($permission->coupon->activateCoupon)){ ?>
                        <button type="button" class="btn cs-btn btn-primary" id="activateOuterCoupon">Activate</button>
                <?php } ?>
                
                <?php if($permission_role==1 || isset($permission->coupon->printCoupon)){ ?>
                        <button type="button" class="btn cs-btn btn-dark" id="printOuterCoupons">Print</button>
                <?php } ?>
          </div>

         </div>
         <!-- <div class="modal-footer actions bottom clfix">
            <button class="btn btn-primary"><span>Submit</span></button>
         </div> -->
      </form>
   </div>
</div>

<?php 
	$moduleScripts[] = VIEW_PATH.'/coupons/js/coupons.js';
	include VIEW_DIR.'/includes/footer.php';
?>
