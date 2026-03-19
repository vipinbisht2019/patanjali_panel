<?php
  require_once '../../config.php';
  include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
	<h1 class="pageMainTitle">Multi Scan Report</h1>

<form action="<?php echo API_URL.'/report/downloadMultiScan'?>" method="POST">
  <section class="content-header clfix">
    <div class="topLeftFilters">
      <div class="flexRow">
          
        <?php //include VIEW_DIR.'/includes/year_filter.php'; ?>
        
        <div class="col-fx-auto">
          <label class="filter-label">Coupon Code</label>
          <input class="form-control" type="text" name="couponcodefilter" id="couponcodefilter">
        </div>
        
         <div class="col-fx-auto">
          <label class="filter-label">Number Of Scan</label>
          <select class="form-control" name="numscan" id="numscan">
              <option value="">Please Select</option>
               <option value=""1>More than 1</option>
                <option value="2">More than 2</option>
                 <option value="3">More than 3</option>
                  <option value="4">More than 4</option>
           </select>
        </div>
        
          <div class="col-fx-auto">
              <label  class="filter-label">Activation Date</label>
              <input type="text" class="form-control" id="frmDate" name="frmDate" placeholder="From Date">
              
        </div>
            
        <div class="col-fx-auto">
           <label  class="filter-label">&nbsp;</label>
          <input type="text" class="form-control" id="toDate" name="toDate" placeholder="To Date"> 
        </div>

        <div class="col-fx-auto btnWrap">
          <a href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a>  
        </div>
        
         <div class="col-fx-auto btnWrap">
            <input type="submit" value="Download" class="btn btn-cs">
        </div>

      </div>
    </div>
  </section>
  </form>

	<div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
		<div class="thead">
			<div class="tr">
	    <div class="th">Coupon Code</div>
        <div class="th">Number Of Scan</div>
        <div class="th">Batch Number</div>
        <div class="th">Activation Date</div>

			</div>
		</div>
		<div class="tbody" id="dataTableResult"></div>
	</div>
	<div id="dataPagination"></div>
</div>

<?php 
	$moduleScripts[] = VIEW_PATH.'/report/js/multiScan.js';
	include VIEW_DIR.'/includes/footer.php';
?>