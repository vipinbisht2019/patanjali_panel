<?php
  require_once '../../config.php';
  include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
	<h1 class="pageMainTitle">Scan Trend Customer <strong style="font-size: 12px;font-weight:normal">(Report will be based on Jan - Dec of Calender year.)</strong> </h1>

  <section class="content-header clfix">
    <div class="topLeftFilters">
	
	<a href="<?php echo APP_URL; ?>/report/ByDate_scanTrendCustomer" class="btn btn-success" style="float:left;"><i class="mdi mdi-search"></i> Switch To Daily Trend </a>
    <br><br><br>
        
<div class="row">
   
        <?php include VIEW_DIR.'/includes/year_filter2.php'; ?>
        
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
            <option value="12">Deactivated</option> -->
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
  height:400px;
  }
</style>

<div style="width:1800;overflow-x:scroll;">
	<div class="table-flex mt20 " id="datatable" data-page="1" data-limit="10" style="width:2000px">
		<div class="thead" style="">
			<div class="tr meta">
        <!-- January   February  March   May   June    July    August    September   October   November    December  -->
        <div class="th">Dealer Code</div>
        <div class="th">Name</div>
        <div class="th">Mobile</div>
        <div class="th">Customer Type</div>
        <div class="th">Beat</div>
        <div class="th"><div class="subm">Jan</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Feb</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Mar</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Apr</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">May</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Jun</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>   
        <div class="th"><div class="subm">Jul</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Aug</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Sep</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
		    <div class="th"><div class="subm">Oct</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Nov</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
        <div class="th"><div class="subm">Dec</div> <div class="subh"><span>Nos</span><span>Amt</span></div></div>
       
			</div>
		</div>
		<div class="tbody" id="dataTableResult"></div>
	</div>
	</div>
	<div id="dataPagination"></div>
</div>

<?php 
	$moduleScripts[] = VIEW_PATH.'/report/js/scanTrendCustomer.js';
	include VIEW_DIR.'/includes/footer.php';
?>