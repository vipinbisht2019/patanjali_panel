<?php
  require_once '../../config.php';
  include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
  <h1 class="pageMainTitle">Scan Alert <strong style="font-size: 12px;font-weight:normal">(Report will be based on Jan - Dec of Calender year.)</strong></h1>

  <section class="content-header clfix">
    <div class="topLeftFilters">
      <div class="flexRow">
        <div class="col-fx-auto" style="max-width: 200px;">
          <label class="filter-label">Date</label>
          <input type="text" class="form-control" id="filterDate" value="">
        </div>
        <div class="col-fx-auto btnWrap">
          <a href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a>  
        </div>
        <div class="col-fx-auto btnWrap" id="downloadBtnWrap" style="display: none;">
          <a href="javascript:;" id="getDownload" class="btn btn-cs"><i class="mdi mdi-download"></i> Download</a>  
        </div>
      </div>
    </div>
  </section>

  <div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
    <div class="thead">
      <div class="tr">
        <div class="th">Name</div>
        <div class="th">Mobile</div>
        <div class="th">User Type</div>
        <div class="th">Date</div>
      </div>
    </div>
    <div class="tbody" id="dataTableResult"></div>
  </div>
  <div id="dataPagination"></div>
</div>
<?php 
  $moduleScripts[] = VIEW_PATH.'/report/js/scanAlert.js';
  include VIEW_DIR.'/includes/footer.php';
?>