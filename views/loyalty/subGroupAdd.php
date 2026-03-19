<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
  <h1 class="pageMainTitle">Add Sub Group</h1>
  <div class="card studentRegWrap mt20">
    <div class="card-body">
      <form id="dataForm">
        <div class="box-body">
          
          <div class="cs_row form-group item-row">
            <div class="col_3">
              <label for="">Group</label>
              <select class="form-control group validate" data-validate="" data-msg="Please select group" id="group"></select>
            </div>
            <div class="col_4">
              <label for="">Sub-group Name</label>
              <input class="form-control sub_group validate" data-validate="" data-msg="Please enter sub-group name" type="text" placeholder="Sub-group Name">
            </div>
            <div class="col-sm-1" style="padding-top: 19px;">
                 <button class="cs-btn-search cs-btn-lg cs-btn-block" id="saveProfileInfo">Submit</button>
            </div>            
            
          </div>       
          
        </div>

      </form>
    </div>
  </div>
</div>

<?php
$moduleScripts[] = VIEW_PATH.'/loyalty/js/sub_group_add.js';
include VIEW_DIR.'/includes/footer.php';
?>