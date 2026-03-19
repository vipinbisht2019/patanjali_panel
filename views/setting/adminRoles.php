<?php
require_once '../../config.php';


include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
	<h1 class="pageMainTitle">User Roles</h1>
	<section class="content-header clfix">
      <a href="javascript:;" class="btn btn-cs btn-add" id="addNewRecord"><i class="mdi mdi-plus"></i> Add New</a>     
  </section>
	<div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
		<div class="thead">
			<div class="tr">
        <div class="th">Role Name</div>
				<div class="th action">Action</div>
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
         <h3>Add Role</h3>
      </div>
      <form action="#" id="dataForm" class="custom-form">
         <input type="hidden" id="roleId" name="" value="0">
         <div class="modal-body">
            <div id="data_msg" class="notify" style="margin:0 20px 10px 20px;"></div>

            <div class="form-group">
              <label for="">Role Name</label>
              <input type="text" class="form-control" id="roleName" name="">
            </div>
         </div>
         <div class="modal-footer actions bottom clfix">
            <button class="btn btn-primary"><span>Submit</span></button>
         </div>
      </form>
   </div>
</div>

<?php 
	$moduleScripts[] = VIEW_PATH.'/setting/js/adminRoles.js';
	include VIEW_DIR.'/includes/footer.php';
?>