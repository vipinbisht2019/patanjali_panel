<?php
require 'config.php';
require_once CLASS_DIR.'/base.php';
base::validateSession();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel</title>
    <style>
      .preloader{width:100%;height:100%;top:0;position:fixed;z-index:99999;background:rgba(255,255,255,.95)}
      .preloader:before{content:'';display:block;padding-top:100%}
      .circular{animation:rotate 2s linear infinite;height:50px;transform-origin:center center;width:50px;position:absolute;top:0;bottom:0;left:0;right:0;margin:auto}
      .path{stroke-dasharray:1,200;stroke-dashoffset:0;animation:dash 1.5s ease-in-out infinite,color 6s ease-in-out infinite;stroke-linecap:round}
      @keyframes rotate{100%{transform:rotate(360deg)}}
      @keyframes dash{0%{stroke-dasharray:1,200;stroke-dashoffset:0}50%{stroke-dasharray:89,200;stroke-dashoffset:-35px}100%{stroke-dasharray:89,200;stroke-dashoffset:-124px}}
      @keyframes color{100%,0%{stroke:#d62d20}40%{stroke:#0057e7}66%{stroke:#008744}80%,90%{stroke:#ffa700}}
    </style>
  </head>
  <body>
    <div class="preloader">
      <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
      </svg>
    </div>
    <script src="<?php echo ASSETS_PATH; ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo ASSETS_PATH; ?>/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        var APP_URL = '<?php echo APP_URL; ?>';
        var API_URL = '<?php echo API_URL; ?>';
        var authReq = true;
        if(!(localStorage.getItem('session')) || localStorage.getItem('session')===false){
          window.location.href=APP_URL+'/login';
        } else {
          window.location.href=APP_URL+'/dashboard';
        }
      });
    </script>
    <script src="<?php echo VIEW_PATH; ?>/js/base.js"></script>
  </body>
</html>