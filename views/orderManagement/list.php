<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>

<div class="content-wrapper">
	<h1 class="pageMainTitle">Order Management</h1>
	
    <div id="data_msg" class="notify" style="margin:20px 20px 20px 0px;">
    <?php echo $_SESSION['redirectMessage']; 
    
          if(isset($_SESSION['redirectMessage']) && $_SESSION['redirectMessage']!="")
            unset($_SESSION['redirectMessage']);
    ?>
   </div>

<form action="<?php echo API_URL.'/orderManagement/download'?>" method="POST">
    
<section class="content-header clfix">
    
    <div class="topLeftFilters">
      <div class="flexRow">
         
        <div class="col-fx-auto">
          <label class="filter-label">Order Id</label>
          <input type="text" class="form-control" id="transactionIdFilter" name="transactionIdFilter" value="" placeholder="OrderId#">
        </div>
        <div class="col-fx-auto">
          <label class="filter-label">Mobile</label>
          <input type="text" class="form-control" id="mobileFilter"  name="mobileFilter" value="">
        </div>
    
        <div class="col-fx-auto">
          <label class="filter-label">Order Status</label>
          <select class="form-control" id="orderStatusFilter" name="orderStatusFilter">
            <option value="">All</option>
            <option value="Pending">Pending</option>
            <option value="Delivered">Delivered</option>
            <option value="Dispatched">Dispatched</option>
            <option value="Partial Dispatch">Partial Dispatch</option>
            <option value="Cancelled">Cancelled</option>
          </select>
        </div>

        <div class="col-fx-auto">
          <label class="filter-label">Payment Status</label>
          <select class="form-control" id="paymentStatus" name="paymentStatus">
            <option value="">All</option>
            <option value="Pending Payment">Pending Payment</option>
            <option value="Payment In-Process">Payment In-Process</option>
            <option value="Payment Received">Payment Received</option>
            <option value="Payment Return">Payment Return</option>
           
          </select>
        </div>
        
        
         <div class="col-fx-auto">
              <label  class="filter-label">Order Date Range</label>
              <input type="text" class="form-control" id="orderDateFilterFrom" name="orderDateFilterFrom" placeholder="From Date">
              
        </div>
            
        <div class="col-fx-auto">
           <label  class="filter-label">&nbsp;</label>
          <input type="text" class="form-control" id="orderDateFilterTo" name="orderDateFilterTo" placeholder="To Date"> 
        </div>

        <div class="col-fx-auto btnWrap">
          <a href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a>  
        </div>
        
        <div class="col-fx-auto btnWrap">
            <input type="submit" value="Download" class="btn btn-cs">
        </div>
        
      </div>
    </div>
  </section>
  </form>
  
	<div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
		<div class="thead">
			<div class="tr">
        
        <div class="th">Order Id</div>
        <div class="th">Distributor Name</div>
        <div class="th">Distributor Mobile</div>
        <div class="th">Distributor Code</div>
        <div class="th">Order Status </div>
        <div class="th">Payment Status </div>
        <div class="th">Order Date </div>
        <div class="th">Last Updated Date </div>
       
		 <div class="th action"></div>
			</div>
		</div>
		<div  id="dataTableResult"></div>
	</div>
	<div id="dataPagination"></div>
</div>



<div class="c-modal" style="" id="dispatchModal">
   <div class="modal" id="model_s8rhvjkUrc" style="width:800px">
      <div class="modal-header">
         <button type="button" class="ajax-model-close close fr" data-dismiss="modal" aria-hidden="false"><i class="icn-close"></i></button>
         <h3>Dispatch</h3>
      </div>

    <form action="#" id="dispatchForm" class="custom-form">
    <input type="hidden" id="editIdD" name="" value="0">
    <div class="modal-body">
        <div class="table-flex mt20">
            <div class="thead">
                <div class="tr">
                    <div class="th">Order Id</div>
                    <div class="th">Order Date</div>
                    <div class="th">Order Status</div>
                    <div class="th">Payment Status</div>
                </div>
            </div>
            <div class="tr align-items-center">
                    <div class="td" id="orderIdD"></div>
                    <div class="td" id="orderDateD"></div>
                    
        <div class="td">
            <select class="form-control" id="orderStatusD">
            <option value="Pending">Pending</option>
            <option value="Delivered">Delivered</option>
            <option value="Dispatched">Dispatched</option>
            <option value="Partial Dispatch">Partial Dispatch</option>
            <option value="Cancelled">Cancelled</option>
          </select>
        </div>
        
        <div class="td">
        <select class="form-control" id="orderPaymentStatusD">
            <option value="Pending Payment">Pending Payment</option>
            <option value="Payment In-Process">Payment In-Process</option>
            <option value="Payment Received">Payment Received</option>
            <option value="Payment Return">Payment Return</option>
          </select>
        </div>
            
        </div>
        </div>
        
        <div class="form-group">
              <label for="">Distributor Remark</label>
             <input type="text" class="form-control" id="orderCommentD" readonly>
        </div>
    
        <h4>Order Items</h4>
        <div class="table-flex mt20" id="orderItemsD"></div>
        
        <div class="form-group">
              <label for="">Manufacturer Dispatch Comment</label>
             <input type="text" class="form-control" id="manufactureOrderCommentD">
        </div>
        
        <h4>Distributor Information</h4>
        <div class="table-flex mt20">
            <div class="thead">
                <div class="tr">
                    <div class="th">Name</div>
                    <div class="th">Mobile</div>
                    <div class="th">Distributor Code</div>
                </div>
                
            <div>
            <div class="tr align-items-center">
                    <div class="td" id="manufatureNameD"></div>
                    <div class="td" id="manufatureMobileD"></div>
                     <div class="td" id="manufatureDealerCodeD"></div>
            </div>
            
        </div>
        
    </div>
    </div>
     </div>
    
     <div class="modal-footer actions bottom clfix">
            <button class="btn btn-primary"><span>Save</span></button>
         </div>
      </form>
      
   </div>
</div>


<div class="c-modal" style="" id="addEditModal">
   <div class="modal" id="model_s8rhvjkUrc" style="width:800px">
      <div class="modal-header">
         <button type="button" class="ajax-model-close close fr" data-dismiss="modal" aria-hidden="false"><i class="icn-close"></i></button>
         <h3>View</h3>
      </div>

    <form action="#" id="editForm" class="custom-form">
    <input type="hidden" id="editId" name="" value="0">
    <div class="modal-body">
        <div class="table-flex mt20">
            <div class="thead">
                <div class="tr">
                    <div class="th">Order Id</div>
                    <div class="th">Order Date</div>
                    <div class="th">Order Status</div>
                    <div class="th">Payment Status</div>
                </div>
            </div>
            <div class="tr align-items-center">
                    <div class="td" id="orderIdE"></div>
                    <div class="td" id="orderDateE"></div>
                    
        <div class="td">
            <select class="form-control" id="orderStatusE">
            <option value="Pending">Pending</option>
            <option value="Delivered">Delivered</option>
            <option value="Dispatched">Dispatched</option>
            <option value="Partial Dispatch">Partial Dispatch</option>
            <option value="Cancelled">Cancelled</option>
          </select>
        </div>
        
        <div class="td">
        <select class="form-control" id="orderPaymentStatusE">
            <option value="Pending Payment">Pending Payment</option>
            <option value="Payment In-Process">Payment In-Process</option>
            <option value="Payment Received">Payment Received</option>
            <option value="Payment Return">Payment Return</option>
          </select>
        </div>
            
        </div>
        </div>
        
        <div class="form-group">
              <label for="">Distributor Remark</label>
             <input type="text" class="form-control" id="orderCommentE" readonly>
        </div>
    
        <h4>Order Items</h4>
        <div class="table-flex mt20" id="orderItemsE"></div>
        
        <h4>Distributor Information</h4>
        <div class="table-flex mt20">
            <div class="thead">
                <div class="tr">
                    <div class="th">Distributor Code/Name</div>
                    <div class="th">Mobile</div>
                    <div class="th">Distributor Code</div>
                </div>
            <div>
            <div class="tr align-items-center">
            <div class="td">
                <select class="form-control validate" id="inptDistributorList" name="inptDistributorList">
                    <option value="">Select</option>
                </select>
                    </div>
                 
            <div class="td" > <input style="border:0px" type="textbox" id="manufatureMobileE" readonly></div>
            <div class="td" id="manufatureDealerCodeE"></div>
            
            </div>
        </div>
        
    </div>
    </div>
     </div>
    
     <div class="modal-footer actions bottom clfix">
            <button class="btn btn-primary"><span>Save</span></button>
         </div>
      </form>
      
   </div>
</div>



<div class="c-modal" style="" id="displayModal">
   <div class="modal" id="model_s8rhvjkUrc" style="width:800px">
    <div class="modal-header">
         <button type="button" class="ajax-model-close close fr" data-dismiss="modal" aria-hidden="false"><i class="icn-close"></i></button>
         <h3>View</h3>
         
        <div style="float: right; margin-top: -30px;">
          <a href="javascript:void(0);" onClick="window.print();" class="btn btn-cs">Print Order</a>  
        </div>
        
        <div style="float: right; margin-top: -30px;margin-right: 10px;">
          <a href="javascript:void(0);" id="btnDispatch" class="btn btn-cs">Dispatch Order</a>  
        </div>
        
         <div style="float: right; margin-top: -30px;margin-right: 10px;">
          <a href="javascript:void(0);" id="btnUpdate" class="btn btn-cs">Update Order / Distributor Info </a>  
        </div>
         
     </div>

      
    <div class="modal-body">
        <div class="table-flex mt20">
            <div class="thead">
                <div class="tr">
                    <div class="th">Order Id</div>
                    <div class="th">Order Date</div>
                    <div class="th">Order Status</div>
                    <div class="th">Payment Status</div>
                </div>
            </div>
            <div class="tr align-items-center">
                    <div class="td" id="orderId"></div>
                    <div class="td" id="orderDate"></div>
                    <div class="td" id="orderStatus"></div>
                    <div class="td" id="orderPaymentStatus"></div>
            
            </div>
        </div>
        
        <div class="form-group">
              <label for="">Distributor Remark</label>
             <input type="text" class="form-control" id="orderComment" readonly>
        </div>
    
        <h4>Order Items</h4>
        <div class="table-flex mt20" id="orderItems"></div>
        
        <h4> Dispatch Items Details</h4>
        <div class="table-flex mt20" id="dispatchOrderItems"></div>
        
        <div class="form-group">
              <label for="">Manufacturer Dispatch Comment</label>
             <input type="text" class="form-control" id="manufactureOrderComment" readonly>
        </div>
        
        <h4>Distributor Information</h4>
        <div class="table-flex mt20">
            <div class="thead">
                <div class="tr">
                    <div class="th">Name</div>
                    <div class="th">Mobile</div>
                    <div class="th">Distributor Code</div>
                </div>
            <div>
            <div class="tr align-items-center">
                    <div class="td" id="manufatureName"></div>
                    <div class="td" id="manufatureMobile"></div>
                    <div class="td" id="manufatureDealerCode"></div>
            </div>
           
        </div>
        
         </div>
    </div>
    </div>

<?php 
	$moduleScripts[] = VIEW_PATH.'/orderManagement/js/orderManagement.js';
	include VIEW_DIR.'/includes/footer.php';
?>