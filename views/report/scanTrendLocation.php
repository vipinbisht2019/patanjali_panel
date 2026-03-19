<?php
  require_once '../../config.php';
  include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
	<h1 class="pageMainTitle">Scan Trend Location <strong style="font-size: 12px;font-weight:normal">(Report will be based on Jan - Dec of Calender year.)</strong> </h1>

  <section class="content-header clfix">
    <div class="topLeftFilters">
        
   <div class="row">
        <?php include VIEW_DIR.'/includes/year_filter.php'; ?>
        
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
          <label class="filter-label">Category</label>
          <select class="form-control" id="filterCategory">
            <option value="">All</option>
          </select>
        </div>
       
</div>

<div class="row">
    
     <div class="col-sm-3">
          <label class="filter-label">Sub. Category</label>
          <select class="form-control" id="filterSubCategory">
            <option value="">All</option>
          </select>
        </div>
        
        <div class="col-sm-3">
          <label class="filter-label">Product</label>
          <select class="form-control" id="filterProduct">
            <option value="">All</option>
          </select>
        </div>

        <div class="col-sm-3">
          <label class="filter-label">State</label>
          <select class="form-control" id="filterState">
            <option value="">All</option>
          </select>
        </div>
        <div class="col-sm-3">
          <label class="filter-label">City</label>
          <select class="form-control" id="filterCity">
            <option value="">All</option>
          </select>
        </div>
</div>

<div class="row form-group">
        <div class="col-sm-3"><br> 
          <a href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a>  
     
          <a href="javascript:;" id="getDownload" class="btn btn-cs"><i class="mdi mdi-download"></i> Download</a>  
        </div>
</div>
      
    </div>
  </section>

	<div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
		<div class="thead">
			<div class="tr meta">
        <!-- May   June    July    August    September   October   November    December    January   February    March  -->
        <div class="th">Location</div>
        <div class="th"><div class="subm">Apr</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">May</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Jun</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>   
        <div class="th"><div class="subm">Jul</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Aug</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Sep</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Oct</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Nov</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Dec</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Jan</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Feb</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Mar</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
			</div>
		</div>
		<div class="tbody" id="dataTableResult"></div>
	</div>
	<div id="dataPagination"></div>
</div>

<?php 
	$moduleScripts[] = VIEW_PATH.'/report/js/locationScanedTrent.js';
	include VIEW_DIR.'/includes/footer.php';
?>