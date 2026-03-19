<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
  <h1 class="pageMainTitle">Pending Point Encashment <strong style="font-size: 12px;font-weight:normal">(Report will be based on Jan - Dec of Calender year.)</strong></h1>
  <section class="content-header clfix">
    <div class="topLeftFilters">

<div class="row">
        <div class="col-sm-3">
          <label class="filter-label">Date</label>
          <input type="text" class="form-control" id="filterDate" value="<?php echo date('d/m/Y'); ?>" readonly>
        </div>
        
          
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
     
          <a href="javascript:;" id="downloadReport" class="btn btn-cs"><i class="mdi mdi-download"></i> Download</a>  
        </div>
</div>
   
    </div>
  </section>
  <div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
    <div class="thead">
      <div class="tr meta">
        <div class="th">title</div>
        
        <?php foreach($ct as $keyData => $rowData) { ?>
        <div class="th"><div class="subm"><?php echo $rowData; ?></div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <?php } ?>
        <!--
        <div class="th"><div class="subm">Main Distributor</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Distributor</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Retailer</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Customer</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Mechanic</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Sales Staff</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Engg. Workshop</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Other</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Auth. Retailer</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Deactivated</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        -->
        
        <div class="th"><div class="subm">Total</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
      </div>
    </div>
    <div class="tbody" id="dataTableResult"></div>
  </div>
  <div id="dataPagination"></div>
</div>
<?php
  $moduleScripts[] = VIEW_PATH.'/report/js/encashmentPending.js';
  include VIEW_DIR.'/includes/footer.php';
?>