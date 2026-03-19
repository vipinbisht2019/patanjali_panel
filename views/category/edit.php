<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
  <h1 class="pageMainTitle">Add Category</h1>
  <div class="card studentRegWrap mt20">
    <div class="card-body">
      <form id="dataForm">
        <div class="box-body">
          
          <div class="cs_row">
            <div class="col_4 form-group item-row">
              <label for="">Category Name</label>
              <input class="form-control categoryName validate" name="cat[name]" value="" data-validate="" data-msg="Please enter category name." type="text" placeholder="Category Name">
            </div>
            <div class="col_8 form-group">
              <label for="">Description</label>
              <input class="form-control categoryDesc" name="cat[desc]" value="" data-validate="" data-msg="" type="text" placeholder="Description">
            </div>
          </div>
          <div id="extraRowWrap"></div>
          <div>
            <div class="col_4 form-group">
              <a href="javascript:;" id="addMoreRow"><i class="mdi mdi-plus"></i> Add More</a>
            </div>
          </div>
          
        </div>
        <div class="actions clearfix">
          <button class="btn btn-save btn-action" id="saveProfileInfo">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>




<?php
$moduleScripts[] = VIEW_PATH.'/category/js/category.js';
include VIEW_DIR.'/includes/footer.php';
?>