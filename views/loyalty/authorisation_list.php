<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>

<div class="content-wrapper">
	<h1 class="pageMainTitle">Authorization Mobile List</h1>
	 <section class="content-header clfix">
	     
	<div class="topLeftFilters">
	  
      <div class="flexRow">
        <div class="col-fx-auto" style="max-width: 200px;">
          <label class="filter-label">User Mobile</label>
          <input type="text" class="form-control" id="filterMobile" value="">
        </div>
            
        <div class="col-fx-auto btnWrap">
            
            <a style="float:left;" href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a>  
            
            <div style="float:right;" class="col-fx-auto"  id="initiateTx">
                
                <button type="button"  class="btn btn-primary" id="importProcessBtn">Import Authorization File</button>
                
                <a href="<?php echo APP_URL; ?>/uploads/sample/authorisation_import_file_sample.csv" class="btn btn-primary">
                 <i class="mdi mdi-download"></i>Sample File</a>
       
                <a href="<?php echo APP_URL; ?>/loyaltyAuthorisation" class="btn btn-cs btn-add" id="addNewRecord"><i class="mdi mdi-plus"></i> Add New Record</a>
           </div>
           
        </div>
 
      </div>
      
    </div>
    
<ol style="font-size: 12px; color: #8c92ac;">
     <li><b>Open For ALL --></b> Allow all users to Scan. If any user is in Deauthorize list then that not able to scan.</li>
    <li><b>Limited Authorize  --></b> If category LIMITED AUTHORIZE, then Allow only Authorize users list to Scan Coupon.</li>
    <li><b>De-Authorize --></b> If category OPEN FOR ALL, then De-Authorize listed users not able to scan.</li>
 </ol>
         
    </section> 
	<div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
		<div class="thead">
			<div class="tr">
        <div class="th">Mobile Number</div>
        <div class="th">Category Name</div>
         <div class="th">Category Authorization Status</div>
				<div class="th action">Action</div>
			</div>
		</div>
		<div class="tbody" id="dataTableResult"></div>
	</div>
	<div id="dataPagination"></div>

</div>


<div class="c-modal" style="" id="uploadModel">
   <div class="modal" id="model_s8rhvjkUrc" style="width:800px">
      <div class="modal-header">
         <button type="button" class="ajax-model-close close fr" data-dismiss="modal" aria-hidden="false"><i class="icn-close"></i></button>
         <h3>View</h3>
      </div>

    <form action="<?php echo API_URL.'/importLoyaltyAuthorisation'?>" method="POST" enctype="multipart/form-data">
     <div class="modal-body">
      <div class="form-group">
        <input type="file" id="authorisationFile" name="authorisationFile" >
    </div>
    </div>
     <div class="modal-footer actions bottom clfix">
        <input type="submit" class="btn btn-primary" name="submitBtn"/>
        </div>
      </form>
      
   </div>
</div>

<?php 
	$moduleScripts[] = VIEW_PATH.'/loyalty/js/authorisation_list.js';
	include VIEW_DIR.'/includes/footer.php';
?>