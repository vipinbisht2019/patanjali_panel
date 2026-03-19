<?php
require_once '../../config.php';

include VIEW_DIR . '/includes/header.php';
?>
<div class="content-wrapper">
	<h1 class="pageMainTitle">Category Scan Restriction List</h1>
	 <section class="content-header clfix">

    <div class="topLeftFilters">

      <div class="flexRow">
        <div class="col-fx-auto" style="max-width: 200px;">
          <label class="filter-label">Category Name</label>
          <input type="text" class="form-control" id="filterCatName" value="">
        </div>

        <div class="col-fx-auto btnWrap">
          <a href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a>

           <a href="<?php echo APP_URL; ?>/scan_category_restriction" style="float:right;"class="btn btn-cs btn-add" id="addNewRecord"><i class="mdi mdi-plus"></i> Add New Record</a>

        </div>
      </div>
    </div>
    </section>
	<div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
		<div class="thead">
			<div class="tr">
        <div class="th">Category Name</div>
         <div class="th">Scan Limit</div>
				<div class="th action">Action</div>
			</div>
		</div>
		<div class="tbody" id="dataTableResult"></div>
	</div>
	<div id="dataPagination"></div>

</div>

<?php
$moduleScripts[] = VIEW_PATH . '/scan_category_restriction/js/scan_category_restriction_list.js';
include VIEW_DIR . '/includes/footer.php';
?>