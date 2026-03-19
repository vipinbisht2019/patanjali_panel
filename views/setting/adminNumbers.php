<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
  <h1 class="pageMainTitle">Setting</h1>
  <div class="row">
    <div class="col-md-6">
      <div class="card card-block" style="background: #fff; padding: 30px;">
        <h3 class="box-title m-b-0">Admin Number</h3>
        <p class="text-muted m-b-30 font-13"> (Scan Coupon Information) </p>

        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-12 col-xs-12">
              	
            <div id="adminNumber_all" style="color: olivedrab; font-size: 15px; font-weight: 700;"></div><br>	
            	
            <form class="settingMetaForm">
              <div class="form-group">
                <label for="">Moble Number</label>
                <input class="form-control validate" maxlength="10" id="adminNumber" placeholder="Eg: 9871234523" type="text" value="" data-key="ADMIN_SCAN_NUMBER">
              </div>
              <div style="position: relative;">
                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Add</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card card-block" style="background: #fff; padding: 30px;">
        <h3 class="box-title m-b-0">Final Points Receiver</h3>
        <p class="text-muted m-b-30 font-13">  (Receive points from distributors) </p>
        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-12 col-xs-12">
            <form class="settingMetaForm">
              <div class="form-group">
                <label for="">Mobile Number</label>
                <input class="form-control validate" maxlength="10" id="pointReceiver" placeholder="Eg: 9871234523" type="text" value="" data-key="ADMIN_POINT_RECEIVER" readonly>
              </div>

<!--              <div style="position: relative;">
                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Save</button>
              </div>-->
              
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$moduleScripts[] = VIEW_PATH.'/setting/js/adminNumber.js';
include VIEW_DIR.'/includes/footer.php';
?>