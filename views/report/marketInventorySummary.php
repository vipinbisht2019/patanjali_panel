<?php
  require_once '../../config.php';
  include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
	<h1 class="pageMainTitle">Market Inventory Summary <strong style="font-size: 12px;font-weight:normal">(Report will be based on Jan - Dec of Calender year.)</strong></h1>

  <section class="content-header clfix">
    <div class="topLeftFilters">

<div class="row">
          
       <?php include VIEW_DIR.'/includes/year_filter2.php'; ?>
       
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
        <div class="col-sm-6"><br>
          <a href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a> 
           <a href="javascript:;" id="getDownload" class="btn btn-cs"><i class="mdi mdi-download"></i> Download</a>  
        </div>
</div>

    </div>
  </section>

	<div class="jsgrid-grid-header" style="margin-top: 10px;" id="datatable" data-page="1" data-limit="10">
    <table class="jsgrid-table">
      <thead>
        <tr class="jsgrid-header-row">
          <td colspan="2" rowspan="3" class="jsgrid-header-cell jsgrid-header-sort-desc hd">Module</td>         <!-- colspan = 4 -->
          <td colspan="2" class="jsgrid-header-cell jsgrid-header-sort-desc hd">Total Issued</td>
          <td colspan="2" class="jsgrid-header-cell jsgrid-header-sort-desc hd">Activated</td>
          <td colspan="8" class="jsgrid-header-cell jsgrid-header-sort-desc hd">Scanned</td>                     <!-- colspan = 4 -->
          <td colspan="6" class="jsgrid-header-cell jsgrid-header-sort-desc hd">Un-Scanned</td>
        <!--  <td colspan="2"  rowspan="2" class="jsgrid-header-cell jsgrid-header-sort-desc hd">Pending 1st Transfer</td> -->
        </tr>
        <tr class="jsgrid-header-row">
          <td colspan="2" class="jsgrid-header-cell jsgrid-header-sort-desc sd">Current Year</td>
          <td colspan="2" class="jsgrid-header-cell jsgrid-header-sort-desc sd">Current Year</td>

          <td colspan="2" class="jsgrid-header-cell jsgrid-header-sort-desc sd">Today</td> 
          <td colspan="2" class="jsgrid-header-cell jsgrid-header-sort-desc sd">Yesterday</td>           <!-- remove -->
          <td colspan="2" class="jsgrid-header-cell jsgrid-header-sort-desc sd">Current Month</td>
          <td colspan="2" class="jsgrid-header-cell jsgrid-header-sort-desc sd">Current Year</td>

          <td colspan="2" class="jsgrid-header-cell jsgrid-header-sort-desc sd">Previous Year</td>
          <td colspan="2" class="jsgrid-header-cell jsgrid-header-sort-desc sd">Current Year</td>
          <td colspan="2" class="jsgrid-header-cell jsgrid-header-sort-desc sd">Total</td>
        </tr>
        <tr class="jsgrid-header-row">
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Nos</td>
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Point</td>
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Nos</td>
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Point</td>

          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Nos</td>
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Point</td>    
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Nos</td>                                       <!-- remove -->
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Point</td>                                <!-- remove -->
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Nos</td>
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Point</td>
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Nos</td>
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Point</td>

          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Nos</td>
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Point</td>
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Nos</td>
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Point</td>
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Nos</td>
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Point</td>
<!--
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Nos</td>
          <td class="jsgrid-header-cell jsgrid-header-sort-desc">Point</td> -->



        </tr>
      </thead>
      <tbody>
        <tr class="jsgrid-row">
          <td colspan="20" class="jsgrid-cell"></td>
        </tr>
      </tbody>
      
    </table>
  </div>

</div>

<?php 
	$moduleScripts[] = VIEW_PATH.'/report/js/marketInventorySummary.js';
	include VIEW_DIR.'/includes/footer.php';
?>