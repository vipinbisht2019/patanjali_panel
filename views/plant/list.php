<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>

<div class="content-wrapper">
	<h1 class="pageMainTitle">Plant List</h1>
	 <section class="content-header clfix">
	     
	<div class="topLeftFilters">
	  
      <div class="flexRow">
        <div class="col-fx-auto" style="max-width: 200px;">
          <label class="filter-label">Plant Name</label>
          <input type="text" class="form-control" id="filterPlantName" value="">
        </div>
        <div class="col-fx-auto" style="max-width: 200px;">
          <label class="filter-label">Plant Code</label>
          <input type="text" class="form-control" id="filterPlantCode" value="">
        </div>
            
        <div class="col-fx-auto btnWrap">
          <a href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a>  
          <a href="javascript:;" class="btn btn-cs btn-add" id="addNewRecord" style="float:right"><i class="mdi mdi-plus"></i> Add New Plant</a>
        </div>
 
      </div>
      
    </div>
    </section> 
	<div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
		<div class="thead">
		<div class="tr">
        <div class="th">Plant Name</div>
        <div class="th">Plant Code</div>
        <div class="th">City</div>
        <div class="th">State</div>
        <div class="th">Country</div>
        <div class="th">Assigned Categories</div>
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
      <form action="#" id="editForm" class="custom-form" method="POST">
         <input type="hidden" id="editId" name="" value="0">
         <div class="modal-body">
            <div id="data_msg" class="notify" style="margin:0 20px 10px 20px;"></div>
            <div class="form-group">
              <label for="">Plant Name</label>
              <input type="text" class="form-control validate" id="inptPlantName" name="" data-msg="" data-validate="">
            </div>
          
            <div class="form-group">
              <label for="">Plant Code (use in coupon)</label>
              <input type="text" class="form-control validate" id="inptPlantCode" maxlength="3" placeholder="3 Alphanumeric like CAD | 234 | A23" data-msg="" data-validate="">
            </div>
            
             <div class="form-group">
              <label for="">Plant Country</label>
               <select class="form-control validate" id="inptPlantCountry" data-validate="" data-msg="Select Plant Country">
                <option value="">Select</option>
              </select>
            </div>
            
             <div class="form-group">
              <label for="">Plant State</label>
              <select class="form-control validate" id="inptPlantState" data-validate="" data-msg="Select Plant State">
                <option value="">Select</option>
              </select>
            </div>
            
            <div class="form-group">
              <label for="">Plant City</label>
              <select class="form-control validate" id="inptPlantCity" data-validate="" data-msg="Select Plant City">
                <option value="">Select</option>
              </select>
            </div>
            
             <div class="form-group">
              <label for="">Assign Categories To Plant</label>
              <select class="form-control" id="mainCategory"  multiple>
                <option value="">---Please Select---</option>
              </select>
            </div>
            
              <!-- start 16_02_2023 -->

            <div class="form-group">
              <label for="">Is agmark</label>
               <select class="form-control validate" id="inptIsAgMark" data-validate="" data-msg="Select Agmark">
                <option value="">Select</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>
            
      <!-- start 16_02_2023 -->
          
         </div>
        <div>
    </div>
         <div class="modal-footer actions bottom clfix">
            <button class="btn btn-primary"><span>Submit</span></button>
         </div>
      </form>
   </div>
</div>


<!-- edit plant-->
<div class="c-modal" style="" id="addEditModal2">
   <div class="modal" id="model_s8rhvjkUrc" style="width:600px">
      <div class="modal-header">
         <button type="button" class="ajax-model-close close fr" data-dismiss="modal" aria-hidden="true"><i class="icn-close"></i></button>
         <h3>Edit</h3>
      </div>
      <form action="#" id="editFormconfirm" class="custom-form" method="POST">
         <input type="hidden" id="editIds" name="" value="0">
         <div class="modal-body">
            <div id="data_msg" class="notify" style="margin:0 20px 10px 20px;"></div>
            <div class="form-group">
              <label for="">Plant Name</label>
              <input type="text" class="form-control validate" id="plantname" name="" data-msg="" data-validate="">
            </div>
          
            <div class="form-group">
              <label for="">Plant Code (use in coupon)</label>
              <input type="text" class="form-control validate" id="plantcode" maxlength="3" placeholder="3 Alphanumeric like CAD | 234 | A23" data-msg="" data-validate="">
            </div>
            
             <div class="form-group">
              <label for="">Plant Country</label>
               <select class="form-control validate" id="countryname" data-validate="" data-msg="Select Plant Country">
                <option value="">Select</option>
              </select>
            </div>
            
             <div class="form-group">
              <label for="">Plant State</label>
              <select class="form-control validate" id="statename" data-validate="" data-msg="Select Plant State">
                <option value="">Select</option>
              </select>
            </div>
            
            <div class="form-group">
              <label for="">Plant City</label>
              <select class="form-control validate" id="cityname" data-validate="" data-msg="Select Plant City">
                <option value="">Select</option>
              </select>
            </div>
            
             <div class="form-group">
              <label for="">Assign Categories To Plant</label>
              <select class="form-control" id="mainCategoryedit" multiple>
                <option value="">---Please Select---</option>
              </select>
            </div>
            
        <!-- start 16_02_2023 -->
      
            <div class="form-group">
              <label for="">Is agmark</label>
               <select class="form-control validate" id="isagmark" data-validate="" data-msg="Select Agmark">
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>
            
        <!-- start 16_02_2023 -->
          
         </div>
        <div>
    </div>
         <div class="modal-footer actions bottom clfix">
            <button class="btn btn-primary"><span>Update</span></button>
         </div>
      </form>
   </div>
</div>


<?php 
	$moduleScripts[] = VIEW_PATH.'/plant/js/plant.js';
	include VIEW_DIR.'/includes/footer.php';
?>