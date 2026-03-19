<?php
require_once '../../config.php';
include VIEW_DIR . '/includes/header.php';
?>
<div class="content-wrapper">
  <h1 class="pageMainTitle">Category Scan Restriction</h1>
  <div class="card studentRegWrap mt20">
    <div class="card-body">
      <div class="box-body">

  <div class="table-flex mt20" id="formDataWrap" data-page="1" data-limit="10" class="bulkEntryForm coupnMasterFrom">
		<div class="thead">
			<div class="tr">
        <div class="th">Category Name</div>
         <div class="th">Scan Limit</div>
			</div>
		</div>
		<div class="tbody" id="formDataRows"></div>
	</div>
  <div class="actions clearfix">
    <button class="btn btn-save btn-action" id="submitFormData">Submit</button>
  </div>


    </div>
  </div>
</div>
<?php
$moduleScripts[] = VIEW_PATH . '/scan_category_restriction/js/scan_category_restriction.js';
include VIEW_DIR . '/includes/footer.php';
?>