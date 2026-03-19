<?php
  require_once '../../config.php';
  include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
	<h1 class="pageMainTitle">Scan Trend Category/Product <strong style="font-size: 12px;font-weight:normal">(Report will be based on Jan - Dec of Calender year.)</strong></h1>

  <section class="content-header clfix">
    <div class="topLeftFilters">
      <div class="flexRow">
        <div class="col-fx-auto">
          <label class="filter-label">Year</label>
          <select class="form-control" id="filterYear">
            <option value="2019">2019-2020</option>
            <option value="2018">2018-2019</option>
          </select>
        </div>
        <div class="col-fx-auto">
          <label class="filter-label">Category</label>
          <select class="form-control" id="filterCategory">
            <option value="">All</option>
          </select>
        </div>
        <div class="col-fx-auto">
          <label class="filter-label">Sub. Category</label>
          <select class="form-control" id="filterSubCategory">
            <option value="">All</option>
          </select>
        </div>
        <div class="col-fx-auto">
          <label class="filter-label">Product</label>
          <select class="form-control" id="filterProduct">
            <option value="">All</option>
          </select>
        </div>

        <div class="col-fx-auto">
          <label class="filter-label">State</label>
          <select class="form-control" id="filterState">
            <option value="">All</option>
            <option value="Haryana">Haryana</option>
          </select>
        </div>
        <div class="col-fx-auto">
          <label class="filter-label">City</label>
          <select class="form-control" id="filterCity">
            <option value="">All</option>
            <option value="Gurgaon">Gurgaon</option>
            <option value="Delhi">Delhi</option>
          </select>
        </div>

        <div class="col-fx-auto btnWrap">
          <a href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a>  
        </div>
      </div>
    </div>
  </section>

  <div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
    <div class="thead">
      <div class="tr meta">
        <!-- May   June    July    August    September   October   November    December    January   February    March  -->
        <div class="th">Location</div>
        <div class="th"><div class="subm">April</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">May</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">June</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>   
        <div class="th"><div class="subm">July</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">August</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">September</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">October</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">November</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">December</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">January</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">February</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">March</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
      </div>
    </div>
    <div class="tbody" id="dataTableResult"></div>
  </div>
	<div id="dataPagination"></div>
</div>

<?php 
	$moduleScripts[] = VIEW_PATH.'/report/js/productScanedTrent.js';
	include VIEW_DIR.'/includes/footer.php';
?>