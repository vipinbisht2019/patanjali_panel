<?php 
/*----------PREVENT CACHE--------*/
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
/*-------PREVENT CACHE-----------*/
require_once CLASS_DIR.'/base.php';
base::validateSession();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="<?php echo ASSETS_PATH; ?>/images/favicon.png" />
    <title>Demo Admin Panel</title>
    <!-- Custom CSS -->

    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/css/icons.css">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/css/vertical-layout-light/style.css">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/css/themefix.css">
    <!-- endinject -->
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="sidebar-fixed">
  <div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
    </svg>
  </div>
  <div class="bodyOverlay"></div>
  <div class="container-scroller">
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="<?php echo APP_URL; ?>/newdashboard">Admin Panel</a>
        <a class="navbar-brand brand-logo-mini" href="<?php echo APP_URL; ?>/dashboard">A</a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="<?php echo ASSETS_PATH; ?>/img/avatar-2.png" alt="profile"/>
              <span class="nav-profile-name"><?php echo $_SESSION['ADMIN_USER']['NAME']; ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a href="<?php echo APP_URL; ?>/company" class="dropdown-item">
                <i class="mdi mdi-settings text-primary"></i>
                Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?php echo APP_URL; ?>/logout.php" class="dropdown-item">
                <i class="mdi mdi-logout text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <div class="container-fluid page-body-wrapper">
      <?php include BASE_DIR.'/views/includes/menu.php' ?>
      <div class="main-panel">
