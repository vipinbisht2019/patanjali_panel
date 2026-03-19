<?php
  require_once '../../config.php';
  include VIEW_DIR.'/includes/header.php';
?>
<style>
@media only screen and (max-width: 1500px) 
{
  #pointReceiverContent {
    font-weight:500;
    left: 800px;
  }
  #pointReceiver {
    left: 983px;
  }
  
}

@media only screen and (min-width: 1501px) 
{
    #pointReceiverContent {
    font-weight:500;
    left:1000px;
    }
    
    #pointReceiver 
    {
    left:1190px;
    }
}
</style>

<div class="content-wrapper">
  <h1 class="pageMainTitle">User Point Statement <strong style="font-size: 12px;font-weight:normal">(Report will be based on Jan - Dec of Calender year.)</strong></h1>

  <section class="content-header clfix">
    <div class="topLeftFilters">
      <div class="flexRow">
        <div class="col-fx-auto" style="max-width: 200px;">
          <label class="filter-label">User Mobile</label>
          <input type="text" class="form-control" id="filterMobile" value="">
        </div>
        
           <div class="col-sm-3">
              <label  class="filter-label">Start Date</label>
              <input type="text" class="form-control validate" id="pointstartdate" name="" data-validate="" data-msg="Please enter start date" autocomplete="off">
            </div>
            
             <div class="col-sm-3">
              <label  class="filter-label">End Date</label>
              <input type="text" class="form-control validate" id="pointenddate" name="" data-validate="" data-msg="Please enter end date" autocomplete="off">
            </div>
            
        <div class="col-fx-auto btnWrap">
          <a href="javascript:;" id="getSearchResult" class="btn btn-cs"><i class="mdi mdi-search"></i> Search</a>  
        </div>

        <span style="position:absolute;" id="pointReceiverContent">Admin Receiver Number : </span>
        <span style="position:absolute;" id="pointReceiver"></span>

        <div class="col-fx-auto btnWrap" style="display:none;" id="getDownloadDIV">
          <a href="javascript:;" id="getDownload" class="btn btn-cs"><i class="mdi mdi-download"></i> Download</a>  
        </div>
      </div>
    </div>
  </section>

  <!-- <div >
    <h6>Current Point Balance: <span id="currenPointBalance">0</span></h6>
  </div> -->
  
 <input type="hidden" name="userid" value="" id="userId">
  <div class="row" style="padding: 30px 0 0 10px;">
    <div class="col-sm-3">
      <h6>Current Point Balance: <span id="currenPointBalances">0</span></h6>
    </div>
    <div class="col-sm-3">
     <h6>Name: <span id="userProfileName"></span></h6>
    </div>
    <div class="col-sm-3">
     <h6>Dealer Code: <span id="userProfileDealerCode"></span></h6>
    </div>
    <div class="col-sm-3">
       <h6>Profession: <span id="userProfileProfession"></span></h6>
    </div>
    
    <div class="pointremark col-sm-3" id="btnSubmit" style="display:none">
      <input type="button" name="submitbtn" id="submitbtn" value="Save Point Status / Remark" class="btn btn-cs">
      
    </div>
  </div>


  <div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
    <div class="thead">
      <div class="tr">
        
        <div class="th">Remark</div>
        <div class="th">Points</div>
        <div class="th">Balance</div>
        <div class="th">Date</div>
        <div class="th">Paid/Unpaid Status</div>
        <div class="th">Point Remark</div>
      </div>
    </div>
    <div class="tbody" id="dataTableResult"></div>
  </div>
  <div id="dataPagination"></div>
</div>

<div class="c-modal" style="" id="summeryModal">
   <div class="modal" id="model_2" style="width:600px">
      <div class="modal-header">
         <button type="button" class="ajax-model-close close fr" data-dismiss="modal" aria-hidden="true"><i class="icn-close"></i></button>
         <h3>Summery</h3>
      </div>
      <div class="modal-body">
        <div class="table-flex mt10">
          <div class="tbody" id="summeryData">
          </div>
        </div>
      </div>
   </div>
</div>

<?php 
  $moduleScripts[] = VIEW_PATH.'/report/js/userPointStatment.js';
  include VIEW_DIR.'/includes/footer.php';
?>