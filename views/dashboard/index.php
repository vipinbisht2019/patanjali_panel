<?php
require_once '../../config.php';
require_once CLASS_DIR . '/base.php';
base::validateSession();
include VIEW_DIR . '/includes/header.php';
?>

<div class="content-wrapper">
	<h1 class="pageMainTitle">Dashboard</h1>

  <div style="text-align:center;margin-bottom: 50px;">
<!--  <a href="<?php // echo APP_URL; ?>/newdashboard" class="btn btn-success" style="float:left;"><i class="mdi mdi-search"></i> Switch To New Dashboard </a>
  <br><br><br>
-->
    <img src="<?php echo ASSETS_PATH; ?>/images/dashboard_logo.png" style="max-height:200px;">
  </div>

  <div class="dashboard-content-wrappers">

  <div class="row">
    <div class="col-sm-6">

	  <div class="table-flex mt20" id="datatable" data-page="1" data-limit="10" >
     <div class="thead-title">
      <div style="float:left"><h4>Feedback Alert</h4></div>
      <div style="float:right;font-size:12px;"><a href="<?php echo APP_URL ?>/feedbacks" style="float:right">View All Feedback</a></div>
     </div>
		  <div class="thead">
			  <div class="tr">
          <div class="th">Feedback</div>
          <div class="th">Submission Date</div>
				  <div class="th action"></div>
		  	</div>
		  </div>
		  <div class="tbody" id="dataTableResult"></div>
	  </div>
	  <div id="dataPagination"></div>


</div>
<!--
<div class="col-sm-6">

    <div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
      <div class="thead">
      <div class="tr">
          <div class="th">No.</div>
          <div class="th">User type</div>
        </div>
      
      </div>
      
      <div class="tbody" id="dataTableResult">	
            
      <?php
      //  foreach($ct as $key => $rows) {
      ?>
        <div class="tr align-items-center">
          <div class="td inlineText"><?php // echo $key; ?></div>
          <div class="td inlineText"><?php // echo $rows; ?></div>
        </div>
      <?php  // } ?>

      </div>
      </div>
    </div>
</div>
  -->

  </div>



</div>


<div class="c-modal" style="" id="displayModal">
   <div class="modal" id="model_s8rhvjkUrc" style="width:600px">
      <div class="modal-header">
         <button type="button" class="ajax-model-close close fr" data-dismiss="modal" aria-hidden="true"><i class="icn-close"></i></button>
         <h3>Show</h3>
      </div>

         <div class="modal-body">
            <div class="form-group">
              <label> Product Name</label>
              <input type="text" class="form-control" id="productName" readonly>
            </div>
            <div class="form-group">
              <label>Coupon Code</label>
              <input type="text" class="form-control" id="couponCode" readonly>
            </div>
            <div class="form-group">
              <label>Feedback</label>
              <input type="text" class="form-control" id="title" readonly>
            </div>
            <div class="form-group">
              <label>Customer Name</label>
             <input type="text" class="form-control" id="name" readonly>
            </div>
            <div class="form-group">
              <label>Customer Mobile</label>
              <input type="text" class="form-control" id="mobile" readonly>
            </div>
            <div class="form-group">
              <label>City</label>
              <input type="text" class="form-control" id="city" readonly>
            </div>
            <div class="form-group">
              <label>Submission Date</label>
              <input type="text" class="form-control" id="createdOn" readonly>
            </div>

          </div>
        <div>
      </div>

<?php
$moduleScripts[] = VIEW_PATH . '/dashboard/dashboard.js';
include VIEW_DIR . '/includes/footer.php';
?>