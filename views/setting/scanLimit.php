<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
  <h1 class="pageMainTitle">Setting</h1>
  <div class="row">
    <div class="col-md-6">
      <div class="card card-block" style="background: #fff; padding: 30px;">
        <h3 class="box-title m-b-0">Scan Limit</h3>
        <p class="text-muted m-b-30 font-13"> (Daily scan limit) </p>

        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-12 col-xs-12">
            <form class="settingMetaForm">
              <div class="form-group">
                <input class="form-control validate" maxlength="10" id="scanLimit" placeholder="Eg: 50" type="text" value="" data-key="DAILY_SCAN_LIMIT">
              </div>
              <div class="form-group">
                  <h3 class="box-title m-b-0">Minimum Point Transfer Limit</h3>
                  <p class="text-muted m-b-30 font-13"> (If you will set it then user must have minimum points to transfer) </p>
                <input class="form-control validate" maxlength="10" id="MiniPointTxLimit" placeholder="Eg: 2000" type="text" value="" data-key-point="MINIMUM_POINT_TX_LIMIT">
              </div>
              <div style="position: relative;">
                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">

    </div>
  </div>
</div>
<?php
$moduleScripts[] = VIEW_PATH.'/setting/js/scanLimit.js';
include VIEW_DIR.'/includes/footer.php';
?>