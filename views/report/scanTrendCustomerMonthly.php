<?php
  require_once '../../config.php';
  include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
	<h1 class="pageMainTitle">Scan Trend Customer Monthly<strong style="font-size: 12px;font-weight:normal">(Report will be based on Month.)</strong> </h1>

  <section class="content-header clfix">
    <div class="topLeftFilters">
        
<div class="row">
   
        <?php include VIEW_DIR.'/includes/month_filter.php'; ?>
        
        <div class="col-sm-2">
              <label class="filter-label">Plant</label>
              <select class="form-control validate" id="plant" data-validate="" data-msg="Select Plant">
                <option value="">All</option>
              </select>
        </div>
        
         <div class="col-sm-2">
              <label class="filter-label">Division/Unit</label>
              <select class="form-control validate" id="divisionunit" data-validate="" data-msg="Select Division/Unit">
                <option value="">All</option>
              </select>
        </div>
        
        
        <div class="col-sm-2">
              <label class="filter-label">Beat Name</label>
              <select class="form-control validate" id="group" data-validate="" data-msg="Select group">
                <option value="">All</option>              
              </select>
        </div>
        
        <div class="col-sm-3">
          <label class="filter-label">Customer Type</label>
          <select class="form-control" id="filterCustomerType">
            <option value="">All</option>
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
            <!--<option value="2">Main Distributor</option>-->
            <!--<option value="3">Distributor</option>-->
            <!--<option value="4">Retailer</option>-->
            <!--<option value="5">Customer</option>-->
            <!--<option value="6">Mechanic</option>-->
            <!--<option value="7">EOW</option>-->
            <!--<option value="8">Sales Staff</option>-->
          </select>
        </div>
        
</div>
        
<div class="row">
    
    <div class="col-sm-3">
          <label class="filter-label">Category</label>
          <select class="form-control" id="filterCategory">
            <option value="">All</option>
          </select>
        </div>
        
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
        <div class="th">Dealer Code</div>
        <div class="th">Name</div>
        <div class="th">Mobile</div>
        <div class="th">Customer Type</div>
        <div class="th"><div class="subm">01</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">02</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">03</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">04</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">05</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">06</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">07</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">08</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">09</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>   
        <div class="th"><div class="subm">10</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">11</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">12</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
				<div class="th"><div class="subm">13</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">14</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">15</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">16</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">17</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">18</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">19</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">20</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">21</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">22</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">23</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">24</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">25</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">26</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">27</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">28</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">29</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">30</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">31</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
			</div>
		</div>
		<div class="tbody" id="dataTableResult"></div>
	</div>
	<div id="dataPagination"></div>
</div>

<?php 
	$moduleScripts[] = VIEW_PATH.'/report/js/scanTrendCustomerMonthly.js';
	include VIEW_DIR.'/includes/footer.php';
?>