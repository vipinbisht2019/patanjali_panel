<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
	<h1 class="pageMainTitle">Sub Group List</h1>
        <section class="content-header clfix">
        <a href="<?php echo APP_URL; ?>/subGroup/add" class="btn btn-cs btn-add" id="addNewRecord"><i class="mdi mdi-plus"></i>Add Sub Group</a>
         
        <!--<div class="topLeftFilters">-->
            
        <!--</div>-->
        </section> 
	<div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
		<div class="thead">
            <div class="tr">
                <div class="th">Group ID</div>
                <div class="th">Group Name</div>
                <div class="th">Sub Group ID</div>
                <div class="th">Sub Group Name</div>
                <div class="th">Action</div>
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
         <h3>Edit Sub Group</h3>
      </div>
      <form action="#" id="editForm" class="custom-form">
         <input type="hidden" id="editId" name="" value="0">
         <div class="modal-body">
            <div id="data_msg" class="notify" style="margin:0 20px 10px 20px;"></div>

            <div class="form-group">
              <label for="">Group</label>
              <select class="form-control group validate" id="group" data-validate="" data-msg="Please select group name" disabled></select>
            </div>
            <div class="form-group">
              <label for="">Sub Group Name</label>
              <input type="text" class="form-control name" id="name" name="">
            </div>
           
         </div>
         <div class="modal-footer actions bottom clfix">
            <button class="btn btn-primary"><span>Submit</span></button>
         </div>
      </form>
   </div>
</div>


<?php 
    $moduleScripts[] = VIEW_PATH.'/loyalty/js/sub_groups.js';
	include VIEW_DIR.'/includes/footer.php';
?>