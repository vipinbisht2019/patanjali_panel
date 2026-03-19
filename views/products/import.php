<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
  <h1 class="pageMainTitle">Product Import</h1>
  <div style="text-align: right;">
    <a href="<?php echo APP_URL; ?>/uploads/sample/sample-product-sheet.xls" class="btn btn-primary" download>
      <i class="mdi mdi-download"></i> Sample File</a>
  </div>
  <div class="card studentRegWrap mt20">
    <div class="card-body">
      <div class="box-body">
        <form id="productFileUploadForm" action="#" method="post" enctype="multipart/form-data">
          <div class="row form-group">
            <div class="col-sm-6">
              <label>Main Category</label>
              <select class="form-control validate" id="mainCategory" data-validate="" data-msg="Please select main category">
                <option value="">Select</option>
              </select>
            </div>
            <div class="col-sm-6">
              <label>Sub Category</label>
              <select class="form-control validate" id="subCategory" data-validate="" data-msg="Please select sub category">
                <option value="">Select</option>
              </select>
            </div>
          </div>
          <div class="importFileUploader">
            <div id="fileInptWrap" style="display: none;"><input type="file" id="fileInpt" name="file" value=""></div>
            <a href="javascript:;" class="uploadBtn"><i class="mdi mdi-upload"></i>Upload File</a>
            <h3>Choose your product excel sheet here</h3>
          </div>
        </form>
        <div class="importFileLoader">
        </div>
        <div id="importFileResponse" class="importFileResponse" data-id="10" data-total="49" data-page="0" data-completed="0" data-filename="book2_1542794048.xls">
          <div class="flexRow flex-space-between" style="display: none;">
            <div class=""><label>File Name</label><span>book2_1542794048.xls</span></div>
            <div class=""><label>No of Records</label><span>49</span></div>
            <div class=""><label>Records Imported</label><span class="currentRecordImported">0</span></div>
            <div class=""><a href="javascript:;" class="cs-btn btn-dark startImportButton">Start Data Import</a></div>
          </div>
          
        </div>
      </div>
      <!-- <div class="actions clearfix">
        <button class="btn btn-save btn-action" id="saveProfileInfo">Submit</button>
      </div> -->
    </div>
  </div>
</div>
<?php
$moduleScripts[] = VIEW_PATH.'/products/js/import.js';
include VIEW_DIR.'/includes/footer.php';
?>