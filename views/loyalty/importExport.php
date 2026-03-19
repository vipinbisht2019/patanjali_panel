<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
  <h1 class="pageMainTitle">Authorization Import / Export</h1>
  <section class="content-header clfix">
    <!-- <a href="<?php echo APP_URL; ?>/loyaltyAuthorisation" class="btn btn-cs btn-add" id="addNewRecord"><i class="mdi mdi-plus"></i> Manual Entry</a> -->
     
<a href="<?php echo APP_URL; ?>/uploads/sample/authorise_deauthorise_sample.xls"  style="float:right;" class="btn btn-cs btn-add" id="addNewRecord"><i class="mdi mdi-download"></i> Sample Download </a>
     
<ol style="font-size: 12px; color: #8c92ac;">
     <li><b>Open For ALL --></b> Allow all users to Scan. If any user is in Deauthorize list then that not able to scan.</li>
    <li><b>Limited Authorize  --></b> If category LIMITED AUTHORIZE, then Allow only  Authorize users list to Scan Coupon.</li>
    <li><b>De-Authorize --></b> If category OPEN FOR ALL, then De-Authorize listed users not able to scan.</li>
 </ol>
 
     
  </section>
  

  
  <div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
    <div class="thead">
      <div class="tr">
        <div class="th">Category Name</div>
        <div class="th">Category Authorization Status</div>
        <div class="th">Authorize Action</div>
        <div class="th" style="flex:0 0 120px;"></div>
        <div class="th" style="flex:0 0 120px;"></div>
      </div>
    </div>
    <div class="tbody" id="dataTableResult"></div>
  </div>
  <div id="dataPagination"></div>
</div>

<?php
  $moduleScripts[] = VIEW_PATH.'/loyalty/js/importExport.js';
  include VIEW_DIR.'/includes/footer.php';
?>