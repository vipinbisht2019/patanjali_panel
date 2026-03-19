<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>


   
   
<div class="content-wrapper">
	<h1 class="pageMainTitle">Dispatch Vendor List</h1>
  <section class="content-header clfix">
      
    <div style="float: left;">
        <a href="javascript:;" class="btn btn-cs btn-add" id="addNewRecord"><i class="mdi mdi-plus"></i> Add New</a>
    </div>
    <div style="float: right;">
         <a href="javascript:;" class="btn btn-cs btn-import" id="importNewRecord"><i class="mdi mdi-plus"></i> Import CSV File</a>
        <a href="<?php echo APP_URL ?>/uploads/sample/vendor_data_sample.csv" class="btn btn-primary" download=""> <i class="mdi mdi-download"></i> Sample File</a>
  </div>

  </section>
  
    <div id="data_msg" class="notify" style="margin:20px 20px 20px 0px;">
    <?php echo $_SESSION['redirectMessage']; 
    
          if(isset($_SESSION['redirectMessage']) && $_SESSION['redirectMessage']!="")
            unset($_SESSION['redirectMessage']);
    ?>
   </div>
   
  
	<div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
		<div class="thead">
			<div class="tr">
        
        <div class="th">Vendor Name</div>
        <div class="th">Status</div>
         <div class="th">Added Date </div>
		 <div class="th action"></div>
			</div>
		</div>
		<div class="tbody" id="dataTableResult"></div>
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
              <label for="">Vendor Name</label>
              <input type="text" class="form-control validate" id="inptName" name="" data-msg="" data-validate="">
            </div>
          

          
            <div class="form-group">
              <label for="" style="display: block;">Is Active</label>
              <label class="switch" for="isActive">
                <input type="checkbox" id="isActive" data-id="6" class="toggleStatus" value=""><div></div><span></span>
              </label>
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



<div class="c-modal" style="" id="importEditModal">
   <div class="modal" id="model_s8rhvjkUrc" style="width:600px">
      <div class="modal-header">
         <button type="button" class="ajax-model-close close fr" data-dismiss="modal" aria-hidden="true"><i class="icn-close"></i></button>
         <h3>Edit</h3>
      </div>
      
       <form action="<?php echo APP_URL ?>/application/api/dispatchVendorList.php?controller=import_vendor_list" class="custom-form" enctype="multipart/form-data" method="POST">
           
         <input type="hidden" id="editId" name="" value="0">
         <div class="modal-body">
         
            <div class="form-group">
              <label for="">Select Vendor CSV File</label>
              <input type="file" class="form-control" id="inptProductFile" name="inptProductFile">
            </div>
    
         </div>

         <div>
         
         </div>


         <div class="modal-footer actions bottom clfix">
            <button class="btn btn-primary"><span>Import</span></button>
         </div>
      </form>
   </div>
</div>

<?php 
	$moduleScripts[] = VIEW_PATH.'/dispatchVendorList/js/dispatchVendorList.js';
	include VIEW_DIR.'/includes/footer.php';
?>