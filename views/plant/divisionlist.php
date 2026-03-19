<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>

<div class="content-wrapper">
	<h1 class="pageMainTitle">Division/Unit List</h1>
	 <section class="content-header clfix">
	     
	<div class="topLeftFilters">
	  
      <div class="flexRow">
        <div class="col-fx-auto" style="max-width: 200px;">
          <label class="filter-label">Division Name</label>
          <input type="text" class="form-control" id="filterDivisionName" value="">
        </div>
        <div class="col-fx-auto" style="max-width: 200px;">
          <label class="filter-label">Division Code</label>
          <input type="text" class="form-control" id="filterDivisionCode" value="">
        </div>
            
        <div class="col-fx-auto btnWrap">
          <a href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a>  
          <a href="javascript:;" class="btn btn-cs btn-add" id="addNewRecord" style="float:right"><i class="mdi mdi-plus"></i> Add New Division/Unit</a>
        </div>
 
      </div>
      
    </div>
    </section> 
	<div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
		<div class="thead">
			<div class="tr">
	    <div class="th">Division/Unit Name</div>
        <div class="th">Plant Name</div>
        <div class="th">Division/Unit Code</div>
         <div class="th">Added Datetime</div>
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
         <h3>Edit</h3>
      </div>
      <form action="#" id="editForm" class="custom-form">
         <input type="hidden" id="editId" name="" value="0">
         <div class="modal-body">
            <div id="data_msg" class="notify" style="margin:0 20px 10px 20px;"></div>
            
            <div class="form-group">
              <label>Select Plant</label>
              <select class="form-control validate" id="plant" data-validate="" data-msg="Select Plant">
                <option value="">Select</option>
              </select>
            </div>
            
            
            <div class="form-group">
              <label for="">Division/Unit Name</label>
              <input type="text" class="form-control validate" id="inptDivisionName" name="" data-msg="" data-validate="">
            </div>
          
            <div class="form-group">
              <label for="">Division/Unit Code </label>
              <input type="text" class="form-control validate" id="inptDivisionCode" data-msg="" data-validate="">
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


<?php 
	$moduleScripts[] = VIEW_PATH.'/plant/js/divisionlist.js';
	include VIEW_DIR.'/includes/footer.php';
?>