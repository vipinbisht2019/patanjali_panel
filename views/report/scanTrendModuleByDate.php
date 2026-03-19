<?php
  require_once '../../config.php';
  include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
	<h1 class="pageMainTitle">Scan Trend Model <strong style="font-size: 12px;font-weight:normal">(Report will be based on selected Month data.)</strong></h1>

  <section class="content-header clfix">
    <div class="topLeftFilters">
        
    <a href="<?php echo APP_URL; ?>/report/scanTrendModule" class="btn btn-success" style="float:left;"><i class="mdi mdi-search"></i> Switch To Scan Model By Year</a>
    <br><br><br>
        
  <div class="row">
          
        <?php include VIEW_DIR.'/includes/year_filter4.php'; ?>
        <div class="" style="width:50px;flex: 0 0 10%;padding-left: 15px;">
              <label class="filter-label">Month</label>
              <select class="form-control validate" id="month" data-validate="" data-msg="Select Month">
            <!--    <option value="">Select Month</option> -->
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>

              </select>
        </div>
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
          <label class="filter-label">Category</label>
          <select class="form-control" id="filterCategory">
            <option value="">All</option>
          </select>
        </div>
          <div class="col-sm-2">
          <label class="filter-label">Sub. Category</label>
          <select class="form-control" id="filterSubCategory">
            <option value="">All</option>
          </select>
        </div>
</div>

<div class="row">
      
        <div class="col-sm-3">
          <label class="filter-label">Product</label>
          <select class="form-control" id="filterProduct">
            <option value="">All</option>
          </select>
        </div>

        <div class="col-sm-2">
          <label class="filter-label">State</label>
          <select class="form-control" id="filterState">
            <option value="">All</option>
            <option value="Haryana">Haryana</option>
          </select>
        </div>
        <div class="col-sm-2">
          <label class="filter-label">City</label>
          <select class="form-control" id="filterCity">
            <option value="">All</option>
            <option value="Gurgaon">Gurgaon</option>
            <option value="Delhi">Delhi</option>
          </select>
        </div>
         <div class="col-sm-3"><br> 
          <a href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a>
          <a href="javascript:;" id="getDownload" class="btn btn-cs"><i class="mdi mdi-download"></i> Download</a> 
        </div>
</div>
<!--
<div class="row form-group">
        <div class="col-sm-3"><br> 
          <a href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a>
          <a href="javascript:;" id="getDownload" class="btn btn-cs"><i class="mdi mdi-download"></i> Download</a> 
        </div>
</div> -->
      
    </div>
  </section>
  <div style="width:1800;overflow-x:scroll">
	<div class="table-flex mt20" id="datatable" data-page="1" data-limit="10" style="width:2000px" >
		<div class="thead">
			<div class="tr meta">
        <!-- May   June    July    August    September   October   November    December    January   February    March  -->
        <div class="th">Model</div>
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
</div>
	<div id="dataPagination"></div>
</div>

<?php 
	$moduleScripts[] = VIEW_PATH.'/report/js/scanTrendModuleByDate.js';
	include VIEW_DIR.'/includes/footer.php';
?>