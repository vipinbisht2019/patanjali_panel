<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>

<div class="content-wrapper">
	<h1 class="pageMainTitle">Users Gift Request</h1>
	
    <div id="data_msg" class="notify" style="margin:20px 20px 20px 0px;">
    <?php echo $_SESSION['redirectMessage']; 
    
          if(isset($_SESSION['redirectMessage']) && $_SESSION['redirectMessage']!="")
            unset($_SESSION['redirectMessage']);
    ?>
   </div>
   
   
<div style="color: red; font-size: 12px;margin:20px 20px 20px 0px;"> *Note: When Request Status = Cancelled, Then You Can Not Edit/Update The Gift Request.</div>
   
<section class="content-header clfix">
    
    <div class="topLeftFilters">
      <div class="flexRow">
         
        <div class="col-fx-auto">
          <label class="filter-label">Transaction Id</label>
          <input placeholder="Numbers only like 12" type="text" class="form-control" id="transactionIdFilter" value="">
        </div>
        <div class="col-fx-auto">
          <label class="filter-label">Mobile</label>
          <input type="text" class="form-control" id="mobileFilter" value="">
        </div>
        
        <!--<div class="col-fx-auto">
          <label class="filter-label">Gift Stock Status</label>
          <select class="form-control" id="giftStockStatusFilter">
            <option value="">All</option>
            <option value="IN STOCK">IN STOCK</option>
            <option value="OUT OF STOCK">OUT OF STOCK</option>
          </select>
        </div>-->

        <div class="col-fx-auto">
          <label class="filter-label">Gift Request Status</label>
          <select class="form-control" id="giftRequestStatusFilter">
            <option value="">All</option>
            <option value="Pending">Pending</option>
            <option value="Delivered">Delivered</option>
            <option value="Dispatched">Dispatched</option>
            <option value="Cancelled">Cancelled</option>
          </select>
        </div>
        
         <div class="col-sm-3">
              <label  class="filter-label">Gift Request Date</label>
              <input type="text" class="form-control" id="giftRequestDateFilter" name="" data-validate=""  autocomplete="off">
            </div>

        <div class="col-fx-auto btnWrap">
          <a href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a>  
        </div>
        <div class="col-fx-auto btnWrap">
          <a href="javascript:;" id="getDownload" class="btn btn-cs"><i class="mdi mdi-search"></i> Download</a>  
        </div>
      </div>
    </div>
  </section>
  
  
   

  
	<div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
		<div class="thead">
			<div class="tr">
        
        <div class="th">Transaction Id</div>
        <div class="th">Gift Request Date</div>
        <div class="th">Customer Details</div>
        <div class="th">Customer Profile</div>
        <div class="th">Customer Mobile</div>
        <div class="th">Gift Unique Id</div>
        <div class="th">Gift Points</div>
        <div class="th">Gift Stock</div>
        <div class="th">Gift Status</div>
        <div class="th">Last Updated Date </div>
        <div class="th">Request Status </div>
       
		 <div class="th action"></div>
			</div>
		</div>
		<div  id="dataTableResult"></div>
	</div>
	<div id="dataPagination"></div>
</div>


<div class="c-modal" style="" id="addEditModal">
   <div class="modal" id="model_s8rhvjkUrc" style="width:600px">
      <div class="modal-header">
         <button type="button" class="ajax-model-close close fr" data-dismiss="modal" aria-hidden="true"><i class="icn-close"></i></button>
         <h3>Edit</h3>
      </div>
      <form action="#" id="editForm" class="custom-form">
         <input type="hidden" id="editId" name="" value="0">
         <div class="modal-body">
            <div id="data_msg" class="notify" style="margin:0 20px 10px 20px;"></div>
            
            <div class="form-group">
              <label for="">Choose Vendor Name</label>
              
              <select class="form-control " id="inptVendor" name="inptVendor" data-validate="" data-msg="Please select vendor name ">
                <option value="" selected="selected">Select</option>
              </select>
              
            </div>
            
            
            <div class="form-group">
              <label for="">Dispatch Date</label>
             <input type="text" class="form-control" id="inptDisDate" name="" data-validate=""  autocomplete="off">
            </div>
            
            
              <div class="form-group">
              <label for="">AWB Number</label>
              <input type="text" class="form-control" id="inptAwb" name="" data-msg="" data-validate="">
            </div>
            
            
            
            <div class="form-group">
              <label for="">Delivery Date</label>
             <input type="text" class="form-control" id="inptDelDate" name="" data-validate=""  autocomplete="off">
            </div>
            
          
          
         <div class="form-group">
              <label for="">Request Status</label>
              <select  class="form-control" name="giftRequestStatus" id="giftRequestStatus" disabled="true">
                  <option value="Delivered">Delivered</option>
                  <option value="Dispatched">Dispatched</option>
                  <option value="Pending">Pending</option>
                  <option value="Cancelled">Cancelled</option>
              </select>
            </div>
          
            <div class="form-group">
              <label for="" style="display: block;">Cancel</label>
              <label class="switch" for="isReturn">
                <input type="checkbox" id="isReturn" data-id="6" class="toggleStatus" value=""><div></div><span></span>
              </label>
            </div>
            
            <div class="form-group" style="display: none;" id="inptCancleReasonDiv">
              <label >Reason To Cancel</label>
              <input type="text" class="form-control" id="inptCancleReason" name="" data-validate="" data-msg="Please update Reason To Cancel ">
            </div>

          
         </div>

         <div>
         
         </div>


         <div class="modal-footer actions bottom clfix">
            <button class="btn btn-primary"><span>Submit</span></button>
         </div>
      </form>
   </div>
</div>




<div class="c-modal" style="" id="displayModal">
   <div class="modal" id="model_s8rhvjkUrc" style="width:600px">
      <div class="modal-header">
         <button type="button" class="ajax-model-close close fr" data-dismiss="modal" aria-hidden="true"><i class="icn-close"></i></button>
         <h3>Show</h3>
      </div>
    
 
         <div class="modal-body">
           
            <div class="form-group">
              <label for=""> Vendor Name</label>
              
              <select class="form-control validate" id="displayInptVendor" name="displayInptVendor" disabled="true" >
                <option value="">Select</option>
              </select>
              
            </div>
            
            
            <div class="form-group">
              <label for="">Dispatch Date</label>
             <input type="text" class="form-control" id="disInptDisDate" readonly>
            </div>
            
            
            <div class="form-group">
              <label for="">AWB Number</label>
              <input type="text" class="form-control" id="disInptAwb" readonly>
            </div>
            
            
            
            <div class="form-group">
              <label for="">Delivery Date</label>
             <input type="text" class="form-control" id="disInptDelDate" readonly>
            </div>
            
     
          
         <div class="form-group">
              <label for="">Request Status</label>
              <input type="text" class="form-control" id="disGiftRequestStatus" readonly>
            </div>
          
            <div class="form-group">
              <label for="" style="display: block;">Return</label>
              <input type="text" class="form-control" id="disIsReturn" readonly>
            
            </div>
            
            
        <div class="form-group">
              <label >Reason To Cancel</label>
              <input type="text" class="form-control" id="disInptCancleReason" name="" readonly>
            </div>

          
         </div>

         <div>
         
         </div>
   </div>
</div>



<?php 
	$moduleScripts[] = VIEW_PATH.'/giftRequest/js/giftRequest.js';
	include VIEW_DIR.'/includes/footer.php';
?>