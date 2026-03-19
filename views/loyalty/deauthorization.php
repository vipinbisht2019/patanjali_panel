<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
  <h1 class="pageMainTitle">Loyalty De-Authorization</h1>
  <div class="card studentRegWrap mt20">
    <div class="card-body">
      <div class="box-body">
        <form id="searchForm" action="#" method="post">
          <div class="row form-group">
            <div class="col-sm-3" style="min-width: 205px;">
              <label>Mobile Number</label>
              <input type="text" class="form-control validate" name="" id="userMobile" data-validate="mobile" data-msg="">
              <input type="hidden" id="userId" name="userId" value="0">
              
              
              
            </div>
            <div class="col-sm-2 btnCol">
              <button type="button" class="cs-btn-search cs-btn-lg cs-btn-block" id="searchUser">Search</button>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-3">
              <label>Name</label>
              <input type="text" class="form-control validate" name="" id="userName" data-validate="" data-msg="Please enter name" readonly>
            </div>
            <div class="col-sm-3">
              <label>User Type</label>
              <select class="form-control validate" id="userType" data-validate="" data-msg="Please select user type">
                <option value="">Select</option>
              <?php foreach($ct as $keyData => $rowData) { ?>	
                <option value="<?php echo $keyData; ?>"><?php echo $rowData; ?></option>	
               <?php } ?>
              <!--    
                <option value="2">Main Distributor</option>
                <option value="3">Distributor</option>
                <option value="4">Retailer</option>
                <option value="5">Customer</option>
                <option value="6">Mechanic</option>
                <option value="8">Sales Staff</option>
                <option value="9">Engg. Workshop</option>
                <option value="10">Other</option>
              -->
              </select>
            </div>
            <div class="col-sm-3">
              <label>State</label>
              <select class="form-control validate" id="userState" data-validate="" data-msg="">
                <option value="">Select</option>
              </select>
            </div>
            <div class="col-sm-3">
              <label>City / Town</label>
              <select class="form-control validate" id="userCity" data-validate="" data-msg="">
                <option value="">Select</option>
              </select>
            </div>
            <!-- <div class="col-sm-2 btnCol">
            </div> -->
          </div>
        </form>
        <div id="formDataWrap" class="bulkEntryForm coupnMasterFrom">
          <div class="flexRow headRow">
            <div class="fx-col-auto">Category</div>
            <div class="fx-col-120">De-Authorization</div>
          </div>
          <div id="formDataRows" style="margin-bottom: 30px;">
          </div>
          <div class="actions clearfix">
            <button class="btn btn-save btn-action" id="submitFormData">Submit</button>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>
<?php
$moduleScripts[] = VIEW_PATH.'/loyalty/js/deauthorization.js';
include VIEW_DIR.'/includes/footer.php';
?>