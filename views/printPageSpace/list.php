<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
	<h1 class="pageMainTitle"> Print Page Paper Space Setting</h1>
	<div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
		<div class="thead">
			<div class="tr">
        <div class="th">Page Top Space </div>
        <div class="th">Space in Two Row </div>
        <div class="th">Space in Two Column</div>
         <div class="th">Space From Left</div>
          <div class="th">Coupon Width</div>
          <div class="th">Coupon Height</div>
				<div class="th action"></div>
			</div>
		</div>
		<div class="tbody" id="dataTableResult"></div>
	</div>
	<div id="dataPagination"></div>
</div>

<img src="<?php echo APP_URL ?>/uploads/couponDesignTemplate/print_page_space.png">

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
              <label for="">Page Top Space</label>
              <input type="text" class="form-control" id="inptTPS" name="" data-validate="" data-msg="">
            </div>
            <div class="form-group">
              <label for="">Space in Two Row</label>
             <input type="text" class="form-control" id="inptTRS" name="" data-validate="" data-msg="">
            </div>
            
            <div class="form-group">
              <label for="">Space in Two Column</label>
             <input type="text" class="form-control" id="inptTCS" name="" data-validate="" data-msg="">
            </div>
            
            <div class="form-group">
              <label for="">Space From Left</label>
             <input type="text" class="form-control" id="inptLS" name="" data-validate="" data-msg="">
            </div>
            
            <div class="form-group">
              <label for="">Coupon Width</label>
             <input type="text" class="form-control" id="inptCW" name="" data-validate="" data-msg="">
            </div>
            
             <div class="form-group">
              <label for="">Coupon Height</label>
             <input type="text" class="form-control" id="inptCH" name="" data-validate="" data-msg="">
            </div>
            
            
         </div>
         <div class="modal-footer actions bottom clfix">
            <button class="btn btn-primary"><span>Submit</span></button>
         </div>
      </form>
   </div>
</div>

<?php 
	$moduleScripts[] = VIEW_PATH.'/printPageSpace/js/printPageSpace.js';
	include VIEW_DIR.'/includes/footer.php';
?>