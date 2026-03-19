<?php
  require_once '../../config.php';
  include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
	<h1 class="pageMainTitle">Point Summary <strong style="font-size: 12px;font-weight:normal">(Report will be based on Jan - Dec of Calender year.)</strong></h1>

  <section class="content-header clfix">
    <div class="topLeftFilters">
    
<div class="row">       
        <?php include VIEW_DIR.'/includes/year_filter2.php'; ?>
        
          <!--<div class="col-sm-3">
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
        </div>-->
        
        <div class="col-sm-3">
          <label class="filter-label">Customer Type</label>
          <select class="form-control" id="filterCustomerType">
            <option value="">All</option>
            <?php foreach($ct as $keyData => $rowData) { ?>
                <option value="<?php echo $keyData; ?>"><?php echo $rowData; ?></option>
            <?php } ?>
        <!--    
            <option value="2">Main Distributor</option>
            <option value="3">Distributor</option>
            <option value="4">Retailer</option>
            <option value="5">Customer</option>
            <option value="6">Mechanic</option>
            <option value="8">Sales Staff</option>
            <option value="9">Engg. Workshop</option>
            <option value="10">Other</option>
            <option value="11">Auth. Retailer</option>
            <option value="12">Deactivated</option>
            -->
          </select>
        </div>
</div>

<div class="row">

        <div class="col-sm-3">
          <label class="filter-label">State</label>
          <select class="form-control" id="filterState">
            <option value="">All</option>
            <option value="Haryana">Haryana</option>
          </select>
        </div>
        <div class="col-sm-3">
          <label class="filter-label">City</label>
          <select class="form-control" id="filterCity">
            <option value="">All</option>
          </select>
        </div>

    <div class="col-sm-3"><br> 
          <a href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a>  
           
          <a href="javascript:;" id="getDownload" class="btn btn-cs"><i class="mdi mdi-download"></i> Download</a>  
    </div>
    
</div>

   
    </div>
  </section>

	<div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
		<div class="thead">
			<div class="tr">
			    <div class="th">Name of Customer</div>
                <div class="th">Dealer Code</div>
                <div class="th">Customer Type</div>
                <div class="th">Point Scanned</div>
                <div class="th">Point Received</div>
                <div class="th">Balance</div>
			</div>
		</div>
		<div class="tbody" id="dataTableResult"></div>
	</div>
	<div id="dataPagination"></div>
</div>

<?php 
	$moduleScripts[] = VIEW_PATH.'/report/js/pointSummary.js';
	include VIEW_DIR.'/includes/footer.php';
?>