<?php
  require_once '../../config.php';
  include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
	<h1 class="pageMainTitle">Coupon Trail Audit <strong style="font-size: 12px;font-weight:normal">(Report will be based on Jan - Dec of Calender year.)</strong></h1>

  <section class="content-header clfix">
    <div class="topLeftFilters">
      <div class="flexRow">
        <div class="col-fx-auto" style="max-width: 220px;">
          <label class="filter-label">Coupon Code</label>
          <input type="text" class="form-control" id="filterCouponCode">
        </div>
        <div class="col-fx-auto btnWrap" style="max-width: 120px;">
          <a href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a>  
        </div>
        <div class="col-fx-auto btnWrap" id="resetCouponWrap" style="visibility: hidden;">
          <a href="javascript:;" id="resetCoupon" class="btn btn-primary" data-id=""><i class="mdi mdi-backup-restore"></i> Reset Coupon</a> 
        </div>
        <div class="col-fx-auto btnWrap" id="getDownloadWrap" style="display: none;">
          <a href="javascript:;" id="getDownload" class="btn btn-cs"><i class="mdi mdi-download"></i> Download</a>  
        </div>
      </div>
    </div>
  </section>

	<div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
		<div class="thead">
			<div class="tr">
        <div class="th">Date</div>
        <div class="th">Status</div>
        <div class="th">Owner Name</div>
        <div class="th">Customer Type</div>
			</div>
		</div>
		<div class="tbody" id="dataTableResult"></div>
	</div>
	<div id="dataPagination"></div>
</div>

<?php 
	$moduleScripts[] = VIEW_PATH.'/report/js/couponTrialAudit.js';
	include VIEW_DIR.'/includes/footer.php';
?>