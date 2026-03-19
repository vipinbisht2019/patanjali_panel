                    <footer class="footer">
                      <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018 <a href="#" target="_blank"></a>. All rights reserved.</span>
                      </div>
                    </footer>
            </div>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
         </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"> </script>  
<script src ="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.1/jquery.twbsPagination.min.js"> </script>  

<!-- plugins:js -->

  <script src="<?php echo ASSETS_PATH; ?>/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?php echo ASSETS_PATH; ?>/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="<?php echo ASSETS_PATH; ?>/libs/off-canvas.js"></script>
  <script src="<?php echo ASSETS_PATH; ?>/libs/hoverable-collapse.js"></script>
  <script src="<?php echo ASSETS_PATH; ?>/libs/template.js"></script>
  <script src="<?php echo ASSETS_PATH; ?>/libs/settings.js"></script>
  <script src="<?php echo ASSETS_PATH; ?>/libs/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?php echo ASSETS_PATH; ?>/libs/dashboard.js"></script>


<?php if(isset($isMapScript)) { ?>
<script src="//maps.googleapis.com/maps/api/js?libraries=geometry,places&key=-_Yp0" type="text/javascript"></script>
<?php } ?>
<!-- endinject -->
<script type="text/javascript">
  var APP_URL = '<?php echo APP_URL; ?>';
  var API_URL = '<?php echo API_URL; ?>';
  var authReq = true;
</script>
<script src="<?php echo VIEW_PATH; ?>/js/base.js"></script>
<?php 
  if(isset($moduleScripts)) { 
    foreach ($moduleScripts as $src) {
      echo '<script src="'.$src.'"></script>';
    } 
  } 
?>
</body>
</html>