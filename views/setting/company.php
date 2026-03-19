<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
  <h1 class="pageMainTitle">Company Info</h1>
  <div class="card studentRegWrap mt20">
    <div class="card-body">
      <form id="dataForm">
        <div class="box-body">

          <div class="form-group">
            <label for="">Company Name</label>
            <input class="form-control validate" id="companyName" name="" value="" data-validate="" data-msg="Please enter company name" type="text" placeholder="Company Name">
          </div>

          <div class="form-group">
            <label for="">Email</label>
            <input class="form-control validate" id="companyEmail" name="" value="" data-validate="email" data-msg="" type="text" placeholder="Email Address">
          </div>

          <div class="form-group">
            <label for="">Mobile</label>
            <input class="form-control validate" id="companyMobile" name="" value="" data-validate="mobile" data-msg="" type="text" placeholder="Mobile Number">
          </div>
          
            <div class="form-group">
            <label for="">New Password</label>
            <input class="form-control validate" id="pass" type="password" placeholder=" Password">
          </div>
          
        <div class="form-group">
            <label for="">Confirm New Password</label>
            <input class="form-control validate" id="cnfrmpass" type="password" placeholder="Confirm Password">
          </div>

          <div class="form-group">
            <label for="">Logo</label>
            <div id="logoWrap"></div>
            <div>
              <a href="javascript:;" class="btn" id="uploadBtn">Upload Logo</a>
            </div>
            <input type="hidden" id="logo" name="" value="">
          </div>
          
        </div>
        <div class="actions clearfix">
          <button class="btn btn-save btn-action" id="saveProfileInfo">Save Info</button>
        </div>

      </form>
    </div>
  </div>
</div>
<?php

  $moduleScripts[] = VIEW_PATH.'/setting/js/company.js';
  include VIEW_DIR.'/includes/footer.php';