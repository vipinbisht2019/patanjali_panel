<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
  <h1 class="pageMainTitle">Add Group</h1>
  <div class="card studentRegWrap mt20">
    <div class="card-body">
      <form id="dataForm">
        <div class="box-body">
          
          <div class="cs_row form-group item-row">
            <div class="col_2">
              <label for="">Main Group</label>
              <select class="form-control group validate" data-validate="" data-msg="Please select main group" id="group"></select>
            </div>

            <div class="col_3">
              <label for="">Sub Group</label>
              <select class="form-control subgroup validate" data-validate="" data-msg="Please select sub-group" id="subgroup">
               <option value="">All</option>
              </select>
            </div>

            <div class="col_3">
              <label for="">group Name</label>
              <input class="form-control name validate" data-validate="" data-msg="Please enter group name" type="text" placeholder="Company Name">
            </div>

            <div class="col_3">
              <label for="">Erp Id</label>
              <input class="form-control erpId validate" data-validate="" data-msg="Please enter erp id" type="text" placeholder="Erp Id">
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
$moduleScripts[] = VIEW_PATH.'/loyalty/js/group_company_add.js';
include VIEW_DIR.'/includes/footer.php';
?>