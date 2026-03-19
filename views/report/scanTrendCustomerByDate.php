<?php
  require_once '../../config.php';
  include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
	<h1 class="pageMainTitle">Scan Trend Customer <strong style="font-size: 12px;font-weight:normal">(Report will be based on selected month data.)</strong> </h1>

  <section class="content-header clfix">
    <div class="topLeftFilters">

    <a href="<?php echo APP_URL; ?>/report/scanTrendCustomer" class="btn btn-success" style="float:left;"><i class="mdi mdi-search"></i> Switch To Monthly Trend</a>
    <br><br><br>
        
<div class="row">
   
        <?php include VIEW_DIR.'/includes/year_filter4.php'; ?>
        <div class="col-sm-2">
              <label class="filter-label">Month</label>
              <select class="form-control validate" id="month" data-validate="" data-msg="Select Month">
                <option value="">Select Month</option>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">Jun</option>
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
              <label class="filter-label">Group</label>
              <select class="form-control validate" id="groupId" data-validate="" data-msg="Select Plant">
                <option value="">All</option>
              </select>
        </div>
        
        <div class="col-sm-2">
              <label class="filter-label">Sub Group</label>
              <select class="form-control validate" id="subGroupId" data-validate="" data-msg="Select Plant">
                <option value="">All</option>
              </select>
        </div>
        
        
        <div class="col-sm-2">
            <!--  <label class="filter-label">Group</label> -->
             <label class="filter-label">Distributor Name</label>
              <select class="form-control validate" id="group" data-validate="" data-msg="Select group">
                <option value="">All</option>              
              </select>
        </div>
        
        <div class="col-sm-3">
          <label class="filter-label">Customer Type</label>
          <select class="form-control" id="filterCustomerType">
            <option value="">All</option>
            <?php foreach($ct as $keyData => $rowData) { ?>	
             <option value="<?php echo $keyData; ?>"><?php echo $rowData; ?></option>	
            <?php } ?>

          </select>
        </div>

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
        
</div>
        
<div class="row">
    
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
<style>
.scrollLength 
  {
  height:450px;
  }
</style>

<div class="monthDays">
  done
</div>


  <div style="width:1300;overflow-x:scroll">
    <div class="table-flex mt20 " id="datatable" data-page="1" data-limit="10" style="width:3000px;">
      <div class="thead">
        <div class="tr meta addMonth">
          <!-- May   June    July    August    September   October   November    December    January   February    March  -->
          <div class="th">Dealer Code</div>
        <div class="th">Name</div>
        <div class="th">Mobile</div>
        <div class="th">Customer Type</div>
        <div class="th">Beat</div>
        
          <div class="th monthCount"><div class="subm">Total</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>        

          <div class="th monthCount" ><div class="subm">01</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">02</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">03</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>   
          <div class="th monthCount"><div class="subm">04</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">05</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">06</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">07</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">08</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">09</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">10</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">11</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">12</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">13</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">14</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">15</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">16</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">17</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">18</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">19</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">20</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">21</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">22</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">23</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">24</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">25</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">26</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">27</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">28</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">29</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">30</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          <div class="th monthCount"><div class="subm">31</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
          

        </div>
      </div>
      <div class="tbody" id="dataTableResult"></div>
    </div>
  </div>
	<div id="dataPagination"></div>
</div>

<?php 
	$moduleScripts[] = VIEW_PATH.'/report/js/scanTrendCustomerByDate.js';
	include VIEW_DIR.'/includes/footer.php';
?>