<?php
    require_once '../../config.php';
    
  ?>
  <!DOCTYPE html>
  <html lang="en">


  <!-- index.html  21 Nov 2019 03:44:50 GMT -->
  <head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Admin Panel</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="views/newdesign/assets/css/app.min.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="views/newdesign/assets/css/style.css">
    <link rel="stylesheet" href="views/newdesign/assets/css/components.css">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="views/newdesign/assets/css/custom.css">
    <link rel='shortcut icon' type='image/x-icon' href='views/newdesign/assets/img/favicon.ico' />

    <style>	
summary {	
  display: block;	
}	
summary::after {	
  margin-left: 1ch;	
  display: inline-block;	
  transition: 0.2s;	
  content: '\25B8'; 	
}	
details[open] summary::after {	
  transform: rotate(90deg);	
}	
details table tr td select {	
  width:100px;	
  margin-left: 20px;	
}	
    </style>
  </head>

  <body>
    <div class="loader"></div>
    <div id="app">
      <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar sticky">
          <div class="form-inline mr-auto">
            <ul class="navbar-nav mr-3">
              <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
                    collapse-btn"> <i data-feather="align-justify"></i></a></li>
              <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                  <i data-feather="maximize"></i>
                </a></li>
              <li>
                <form class="form-inline mr-auto">
                  <div class="search-element">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
                    <button class="btn" type="submit">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </form>
              </li>
            </ul>
          </div>
          <ul class="navbar-nav navbar-right">
            <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>
                <span class="badge headerBadge1">
                  6 </span> </a>
              <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                <div class="dropdown-header">
                  Messages
                  <div class="float-right">
                    <a href="#">Mark All As Read</a>
                  </div>
                </div>
                <div class="dropdown-list-content dropdown-list-message">
                  <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar
                        text-white"> <img alt="image" src="views/newdesign/assets/img/users/user-1.png" class="rounded-circle">
                    </span> <span class="dropdown-item-desc"> <span class="message-user">John
                        Deo</span>
                      <span class="time messege-text">Please check your mail !!</span>
                      <span class="time">2 Min Ago</span>
                    </span>
                  </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                      <img alt="image" src="views/newdesign/assets/img/users/user-2.png" class="rounded-circle">
                    </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                        Smith</span> <span class="time messege-text">Request for leave
                        application</span>
                      <span class="time">5 Min Ago</span>
                    </span>
                  </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                      <img alt="image" src="views/newdesign/assets/img/users/user-5.png" class="rounded-circle">
                    </span> <span class="dropdown-item-desc"> <span class="message-user">Jacob
                        Ryan</span> <span class="time messege-text">Your payment invoice is
                        generated.</span> <span class="time">12 Min Ago</span>
                    </span>
                  </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                      <img alt="image" src="views/newdesign/assets/img/users/user-4.png" class="rounded-circle">
                    </span> <span class="dropdown-item-desc"> <span class="message-user">Lina
                        Smith</span> <span class="time messege-text">hii John, I have upload
                        doc
                        related to task.</span> <span class="time">30
                        Min Ago</span>
                    </span>
                  </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                      <img alt="image" src="views/newdesign/assets/img/users/user-3.png" class="rounded-circle">
                    </span> <span class="dropdown-item-desc"> <span class="message-user">Jalpa
                        Joshi</span> <span class="time messege-text">Please do as specify.
                        Let me
                        know if you have any query.</span> <span class="time">1
                        Days Ago</span>
                    </span>
                  </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                      <img alt="image" src="views/newdesign/assets/img/users/user-2.png" class="rounded-circle">
                    </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                        Smith</span> <span class="time messege-text">Client Requirements</span>
                      <span class="time">2 Days Ago</span>
                    </span>
                  </a>
                </div>
                <div class="dropdown-footer text-center">
                  <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
              </div>
            </li>
            <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg"><i data-feather="bell" class="bell"></i>
              </a>
              <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                <div class="dropdown-header">
                  Notifications
                  <div class="float-right">
                    <a href="#">Mark All As Read</a>
                  </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                  <a href="#" class="dropdown-item dropdown-item-unread"> <span
                      class="dropdown-item-icon bg-primary text-white"> <i class="fas
                          fa-code"></i>
                    </span> <span class="dropdown-item-desc"> Template update is
                      available now! <span class="time">2 Min
                        Ago</span>
                    </span>
                  </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-icon bg-info text-white"> <i class="far
                          fa-user"></i>
                    </span> <span class="dropdown-item-desc"> <b>You</b> and <b>Dedik
                        Sugiharto</b> are now friends <span class="time">10 Hours
                        Ago</span>
                    </span>
                  </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-icon bg-success text-white"> <i
                        class="fas
                          fa-check"></i>
                    </span> <span class="dropdown-item-desc"> <b>Kusnaedi</b> has
                      moved task <b>Fix bug header</b> to <b>Done</b> <span class="time">12
                        Hours
                        Ago</span>
                    </span>
                  </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-icon bg-danger text-white"> <i
                        class="fas fa-exclamation-triangle"></i>
                    </span> <span class="dropdown-item-desc"> Low disk space. Let's
                      clean it! <span class="time">17 Hours Ago</span>
                    </span>
                  </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-icon bg-info text-white"> <i class="fas
                          fa-bell"></i>
                    </span> <span class="dropdown-item-desc"> Welcome to Otika
                      template! <span class="time">Yesterday</span>
                    </span>
                  </a>
                </div>
                <div class="dropdown-footer text-center">
                  <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
              </div>
            </li>
            <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="views/newdesign/assets/img/user.png"
                  class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
              <div class="dropdown-menu dropdown-menu-right pullDown">
                <div class="dropdown-title">Hello Sarah Smith</div>
                <a href="profile.html" class="dropdown-item has-icon"> <i class="far
                      fa-user"></i> Profile
                </a> <a href="timeline.html" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                  Activities
                </a> <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                  Settings
                </a>
                <div class="dropdown-divider"></div>
                <a href="auth-login.html" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        
        <?php include BASE_DIR.'/views/newdesign/includes/menu_design.php' ?>

  
        <div class="main-content">
          <section class="section">
<!--    <a href="<?php // echo APP_URL; ?>/dashboard" class="btn btn-success" style="float:left;font-family:sans-serif;"><i class="mdi mdi-search"></i> SWITCH TO DASHBOARD </a>
        <br><br><br> -->
            <div class="row ">
              
            
            
              <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">
                      
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pt-3">
                          <div class="card-content">
                          <h5 class="text-center">All Data</h5>
                            <p class ="mb-0"><span style="font-weight:700;">Total Codes Activated</span> : &nbsp&nbsp&nbsp<span class="col-green totalCouponGenerated" id="totalCouponGenerated">0</span></p>
                            <div class="cardNum">
                            <p class ="mb-0"><span style="font-weight:700;float:left;width:160px;"><?php echo date('F Y', strtotime('0 month')); ?></span> : <span style="padding-left:10px;" class="col-green month1" id="month1">0</span></p>
                            <p class ="mb-0"><span style="font-weight:700;float:left;width:160px;"><?php echo date('F Y', strtotime(date('Y-m')." -1 month")); ?></span> : <span style="padding-left:10px;" class="col-green month2" id="month2">0</span></p>
                            <p class ="mb-0"><span style="font-weight:700;float:left;width:160px;"><?php echo date('F Y', strtotime(date('Y-m')." -2 month")); ?></span> : <span style="padding-left:10px;" class="col-green month3" id="month3">0</span></p>

                            </div>

                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>


              <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:none;">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pt-3">
                          <div class="card-content">
                            
                            <p class ="mb-0"><span style="font-weight:700;">Scanned/Unscanned</span> : &nbsp&nbsp<span class="col-green totalCouponScan" id="totalCouponScan">0</span> / <span class="col-green totalCouponUnscan" id="totalCouponUnscan">0</span></p>
                            <div class="row">

                              <div class="col-sm-3">
                                <p class ="mb-0"><span style="font-weight:700;float:left;width:80px;"><?php echo date('F Y', strtotime('0 month')); ?></span> </p>
                                
                                <p class ="mb-0"><span style="font-weight:700;float:left;width:80px;"><?php echo date('F Y', strtotime(date('Y-m')." -1 month")); ?></span></p>
                                
                                <p class ="mb-0"><span style="font-weight:700;float:left;width:80px;"><?php echo date('F Y', strtotime(date('Y-m')." -2 month")); ?></span></p>
                              </div>
                             
                              <div class="col-sm-6 scanUnscanNums">
                                <p class ="mb-0"> : <span class="col-green scanMonth1" id="scanMonth1">0</span> / <span class="col-green unscanMonth1" id="unscanMonth1">0</span></p>
                                 <p class ="mb-0"> : <span class="col-green scanMonth2" id="scanMonth2">0</span> / <span class="col-green unscanMonth2" id="unscanMonth2">0</span></p>
                                <p class ="mb-0"> : <span class="col-green scanMonth3" id="scanMonth3">0</span> / <span class="col-green unscanMonth3" id="unscanMonth3">0</span></p>
                              </div> 
  
                            </div>

                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>


      
              <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pt-3">
                          <div class="card-content">
                            <h5 class="text-center">Plant A</h5>
                            <p class ="mb-0"><span style="font-weight:700;">Total Codes Activated</span> : &nbsp&nbsp&nbsp<span class="col-green totalCouponGeneratedFirst" id="totalCouponGeneratedFirst">0</span></p>
                            <div class="cardNumFirst">
                            <p class ="mb-0"><span style="font-weight:700;float:left;width:160px;"><?php echo date('F Y', strtotime('0 month')); ?></span> : <span style="padding-left:10px;" class="col-green monthFirst1" id="monthFirst1">0</span></p>
                            <p class ="mb-0"><span style="font-weight:700;float:left;width:160px;"><?php echo date('F Y', strtotime(date('Y-m')." -1 month")); ?></span> : <span style="padding-left:10px;" class="col-green monthFirst2" id="monthFirst2">0</span></p>
                            <p class ="mb-0"><span style="font-weight:700;float:left;width:160px;"><?php echo date('F Y', strtotime(date('Y-m')." -2 month")); ?></span> : <span style="padding-left:10px;" class="col-green monthFirst3" id="monthFirst3">0</span></p>

                            </div>

                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pt-3">
                          <div class="card-content">
                          <h5 class="text-center">Plant B</h5>
                            <p class ="mb-0"><span style="font-weight:700;">Total Codes Activated</span> : &nbsp&nbsp&nbsp<span class="col-green totalCouponGeneratedSecond" id="totalCouponGeneratedSecond">0</span></p>
                            <div class="cardNumSecond">
                            <p class ="mb-0"><span style="font-weight:700;float:left;width:160px;"><?php echo date('F Y', strtotime('0 month')); ?></span> : <span style="padding-left:10px;" class="col-green monthSecond1" id="monthSecond1">0</span></p>
                            <p class ="mb-0"><span style="font-weight:700;float:left;width:160px;"><?php echo date('F Y', strtotime(date('Y-m')." -1 month")); ?></span> : <span style="padding-left:10px;" class="col-green monthSecond2" id="monthSecond2">0</span></p>
                            <p class ="mb-0"><span style="font-weight:700;float:left;width:160px;"><?php echo date('F Y', strtotime(date('Y-m')." -2 month")); ?></span> : <span style="padding-left:10px;" class="col-green monthSecond3" id="monthSecond3">0</span></p>

                            </div>

                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pt-3">
                          <div class="card-content">
                          <h5 class="text-center">Head Office</h5>
                            <p class ="mb-0"><span style="font-weight:700;">Total Codes Activated</span> : &nbsp&nbsp&nbsp<span class="col-green totalCouponGeneratedThird" id="totalCouponGeneratedThird">0</span></p>
                            <div class="cardNumThird">
                            <p class ="mb-0"><span style="font-weight:700;float:left;width:160px;"><?php echo date('F Y', strtotime('0 month')); ?></span> : <span style="padding-left:10px;" class="col-green monthThird1" id="monthThird1">0</span></p>
                            <p class ="mb-0"><span style="font-weight:700;float:left;width:160px;"><?php echo date('F Y', strtotime(date('Y-m')." -1 month")); ?></span> : <span style="padding-left:10px;" class="col-green monthThird2" id="monthThird3">0</span></p>
                            <p class ="mb-0"><span style="font-weight:700;float:left;width:160px;"><?php echo date('F Y', strtotime(date('Y-m')." -2 month")); ?></span> : <span style="padding-left:10px;" class="col-green monthThird3" id="monthThird3">0</span></p>

                            </div>

                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>


              
              <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:none;">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pt-3">
                          <div class="card-content">
                            
                            <p class ="mb-0"><span style="font-weight:700;padding-left:50px;">Generated (Scanned/Unscanned)</span> </p>
                            <div class="row">

                              <div class="col-sm-3">
                                <p class ="mb-0"><span style="font-weight:700;float:left;width:80px;">Total</span> </p>
                              </div>

                              <div class="col-sm-9 totalData">
                                <p class ="mb-0"> : <span class="col-green totalscanMonths" id="totalscanMonths">0</span>  (<span class="col-green scanMonth1" id="scanMonth1">0</span> / <span class="col-green unscanMonth1" id="unscanMonth1">0</span>)</p>
                               
                              </div> 

                              <div class="col-sm-3">
                                <p class ="mb-0"><span style="font-weight:700;float:left;width:80px;"><?php echo date('F', strtotime('0 month')); ?></span> </p>
                                
                                <p class ="mb-0"><span style="font-weight:700;float:left;width:80px;"><?php echo date('F', strtotime(date('Y-m')." -1 month")); ?></span></p>
                                
                                <p class ="mb-0"><span style="font-weight:700;float:left;width:80px;"><?php echo date('F', strtotime(date('Y-m')." -2 month")); ?></span></p>
                              </div>
                             
                              
                              <div class="col-sm-9 totalData">
                                <p class ="mb-0"> : <span class="col-green totalScanMonth1" id="totalScanMonth1">0</span>  (<span class="col-green scanMonth1" id="scanMonth1">0</span> / <span class="col-green unscanMonth1" id="unscanMonth1">0</span>)</p>
                                <p class ="mb-0"> : <span class="col-green totalScanMonth2" id="totalScanMonth2">0</span> (<span class="col-green scanMonth2" id="scanMonth2">0</span> / <span class="col-green unscanMonth2" id="unscanMonth2">0</span>)</p>
                                <p class ="mb-0"> : <span class="col-green totalScanMonth3" id="totalScanMonth3">0</span> (<span class="col-green scanMonth3" id="scanMonth3">0</span> / <span class="col-green unscanMonth3" id="unscanMonth3">0</span>)</p>
                              </div> 
  
                            </div>

                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

<!--
              <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                          <div class="card-content">
                            <h5 class="font-15"> Customers</h5>
                            <h2 class="mb-3 font-18">1,287</h2>
                            <p class="mb-0"><span class="col-orange">09%</span> Decrease</p>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                          <div class="banner-img">
                            <img src="views/newdesign/assets/img/banner/2.png" alt="">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
-->
              
            </div>
            <div class="row">
              <div class="col-12 col-sm-12 col-lg-12">
                <div class="card ">
                  <div class="card-header">
                    <h4>ScanTrendModule</h4>
                    <div class="card-header-action">
            
                      <div class="dropdown">
                      <select  id="filterYear">
                
      <?php foreach(range((int)date("Y"), 2018) as $year) {
          
                  $yearRange = $year+1;
                  $disable ="";
                  
                  if( date("m") < 4 && $year == date("Y"))
                    $disable =" disabled='disabled' ";
                  
                  
          echo "<option value='".$year."' $disable >".$year." - ".$yearRange."</option>";
          }

      ?></select>
                      </div>
                    <label class="filter-label">Plant</label>
                <select class="" id="plant" data-validate="" data-msg="Select Plant">
                  <option value="">All</option>
                </select>
          <label class="filter-label">Division/Unit</label>
                <select class="" id="divisionunit" data-validate="" data-msg="Select Division/Unit">
                  <option value="">All</option>
                </select>
          <label class="filter-label">Category</label>
            <select class="" id="filterCategory">
              <option value="">All</option>
            </select>
        <label class="filter-label">Sub. Category</label>
            <select class="" id="filterSubCategory">
              <option value="">All</option>
            </select>
          
            <label class="filter-label">Product</label>
            <select class="" id="filterProduct">
              <option value="">All</option>
            </select>
        <a href="javascript:;" id="getSearchResult" class="btn btn-primary"><i class="mdi mdi-search"></i> GO</a> 
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-12">
                        <div id="chart1"></div>
                      <!--  <div class="row mb-0">
                          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="list-inline text-center">
                              <div class="list-inline-item p-r-30"><i data-feather="arrow-up-circle"
                                  class="col-green"></i>
                                <h5 class="m-b-0">$675</h5>
                                <p class="text-muted font-14 m-b-0">Weekly Earnings</p>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="list-inline text-center">
                              <div class="list-inline-item p-r-30"><i data-feather="arrow-down-circle"
                                  class="col-orange"></i>
                                <h5 class="m-b-0">$1,587</h5>
                                <p class="text-muted font-14 m-b-0">Monthly Earnings</p>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="list-inline text-center">
                              <div class="list-inline-item p-r-30"><i data-feather="arrow-up-circle"
                                  class="col-green"></i>
                                <h5 class="mb-0 m-b-0">$45,965</h5>
                                <p class="text-muted font-14 m-b-0">Yearly Earnings</p>
                              </div>
                            </div>
                          </div>
                        </div>-->
                      </div>
                    <!-- <div class="col-lg-3">
                       <div class="row mt-5">
                          <div class="col-7 col-xl-7 mb-3">Total customers</div>
                          <div class="col-5 col-xl-5 mb-3">
                            <span class="text-big">8,257</span>
                            <sup class="col-green">+09%</sup>
                          </div>
                          <div class="col-7 col-xl-7 mb-3">Total Income</div>
                          <div class="col-5 col-xl-5 mb-3">
                            <span class="text-big">$9,857</span>
                            <sup class="text-danger">-18%</sup>
                          </div>
                          <div class="col-7 col-xl-7 mb-3">Project completed</div>
                          <div class="col-5 col-xl-5 mb-3">
                            <span class="text-big">28</span>
                            <sup class="col-green">+16%</sup>
                          </div>
                          <div class="col-7 col-xl-7 mb-3">Total expense</div>
                          <div class="col-5 col-xl-5 mb-3">
                            <span class="text-big">$6,287</span>
                            <sup class="col-green">+09%</sup>
                          </div>
                          <div class="col-7 col-xl-7 mb-3">New Customers</div>
                          <div class="col-5 col-xl-5 mb-3">
                            <span class="text-big">684</span>
                            <sup class="col-green">+22%</sup>
                          </div>
                        </div>
                      </div>-->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <h3>Retailer Incentive Program</h3>
            <div class="row">
              <div class="col-12 col-sm-12 col-lg-4">
                <div class="card">
                  <div class="card-header" style="display:block">
                    <h4>User Registration (Welcome coupon)</h4><input type='radio' id="vchart4" name='vchart4' value='week' > Weekly <input type='radio' id="vchart4" name='vchart4' value='month' checked> Monthly
            <br>
            <details>	
              <summary class="btn btn-primary rounded ">Filter</summary>
              <table>
        <tr><td>    <label class="filter-label">Year</label></td>
          <td>  <select class="" id="filterYear4">
                
      <?php foreach(range((int)date("Y"), 2018) as $year) {
          
                  $yearRange = $year+1;
                  $disable ="";
                  
                  if( date("m") < 4 && $year == date("Y"))
                    $disable =" disabled='disabled' ";
                  
                  
          echo "<option value='".$year."' $disable >".$year."</option>";
          }

      ?>
                
          
      </select></td>
    </tr>
    <tr><td><label class="filter-label">Month</label></td>
            <td>   <select class="" id="month4" data-validate="" data-msg="Select Month">
              <!--    <option value="">Select Month</option> -->
                  <option value="01">January</option>
                  <option value="02">Faburary</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>

                </select></td></tr>
  <tr><td>	 <label class="filter-label">Plant</label></td>
              <td>  <select class="" id="plant_week" data-validate="" data-msg="Select Plant">
                  <option value="">All</option>
                </select></td></tr>
      <tr><td>	  <label class="filter-label">User Type</label></td>
        <td>   <select class="" style="width: 100px;" id="filterCustomerTypeweekchart">
              <option value="">All</option>
              <?php foreach($ct as $keyData => $rowData) { ?>	
              <option value="<?php echo $keyData; ?>"><?php echo $rowData; ?></option>	
              <?php } ?>
        </select> </td></tr>
        <tr><td>  <label class="filter-label">Category</label></td>
      <td>     <select style="width: 100px;" id="filterCategoryforweekchart">
              <option value="">All</option>
            </select></td></tr>
            </table>
        <button type="button" id="chartsearch4" class="btn btn-primary ">GO</button>
        </details>
                  </div>
                  <div class="card-body" id='ichart4' style="display:none">
                    <div id="chart4" class="chartsh" ></div>
                    </div>
                  <div class="card-body" id='ichart7' >
                  
                    <div id="chart7" class="chartsh" ></div>
                  </div>

                </div>
              </div>
              <div class="col-12 col-sm-12 col-lg-4">
                <div class="card">
                  <div class="card-header" style="display:block">
                    <h4>User Engagement (Inbox Coupon)</h4> <input type='radio' id="vchart5" name='vchart5' value='week' > Weekly <input type='radio' id="vchart4" name='vchart5' value='month' checked> Monthly
            <br>
            <details>	
              <summary class="btn btn-primary rounded " >Filter</summary>
            <table>
            <tr><td> <label class="filter-label">Year</label></td>
          <td> <select class="" id="filterYear5">
                
      <?php foreach(range((int)date("Y"), 2018) as $year) {
          
                  $yearRange = $year+1;
                  $disable ="";
                  
                  if( date("m") < 4 && $year == date("Y"))
                    $disable =" disabled='disabled' ";
                  
                  
          echo "<option value='".$year."' $disable >".$year."</option>";
          }

      ?>
                
          
      </select></td></tr>
    <tr><td><label class="filter-label">Month</label></td>
              <td> <select class="" id="month5" data-validate="" data-msg="Select Month">
              <!--    <option value="">Select Month</option> -->
                  <option value="01">January</option>
                  <option value="02">Faburary</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>

                </select></td>
          </tr>
    <tr> <td><label class="filter-label">Plant</label></td>
                <td><select class="" id="plant_week5" data-validate="" data-msg="Select Plant">
                  <option value="">All</option>
                </select></td></tr>
        <tr><td> <label class="filter-label">User Type</label></td>
          <td> <select style="width: 100px;" class="" id="filterCustomerTypeweekchart5">
              <option value="">All</option>
              <?php foreach($ct as $keyData => $rowData) { ?>	
              <option value="<?php echo $keyData; ?>"><?php echo $rowData; ?></option>	
              <?php } ?>
        </select> </td></tr>
          <tr><td> <label class="filter-label">Category</label></td>
          <td> <select class="" id="filterCategoryforweekchart5">
              <option value="">All</option>
            </select></td>
          </tr>
              </table>
        <button type="button" id="chartsearch5" class="btn btn-primary ">GO</button>
        </details>
                  </div>
                  <div class="card-body" id='ichart5' style="display:none">
                    <div id="chart5" class="chartsh"></div>
                      </div>
                  <div class="card-body"  id='ichart8'>
                  
                    <div id="chart8" class="chartsh" ></div>
                  </div>
                </div>
              </div>
        <div class="col-12 col-sm-12 col-lg-4">
                <div class="card">
                  <div class="card-header" style="display:block">
                    <h4>Point Transfer</h4>

                    <input type='radio' id="vchart10" name='vchart10' value='week' > Weekly <input type='radio' id="vchart9" name='vchart10' value='month' checked> Monthly	
            <br>	
            <details>	
              <summary class="btn btn-primary rounded " >Filter</summary>

                    <table>

          <tr><td>  <label class="filter-label">Year</label></td>
        <td>   <select  class="" id="filterYear6"> 
                
      <?php foreach(range((int)date("Y"), 2018) as $year) {
          
                  $yearRange = $year+1;
                  $disable ="";
                  
                  if( date("m") < 4 && $year == date("Y"))
                    $disable =" disabled='disabled' ";
                  
                  
          echo "<option value='".$year."' $disable >".$year."</option>";
          }

      ?>
                
          
          </select></td></tr>
    <tr><td> <label class="filter-label">Month</label></td>
                <td><select class="" id="month6" data-validate="" data-msg="Select Month">
              <!--    <option value="">Select Month</option> -->
                  <option value="01">January</option>
                  <option value="02">Faburary</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>

                </select></td></tr>


        <tr><td>  <label class="filter-label">User Type</label></td>
          <td> <select class="" id="filterCustomerType6">
              <option value="">All</option>
              <?php foreach($ct as $keyData => $rowData) { ?>	
                <option value="<?php echo $keyData; ?>" <?php if($keyData==2)echo "selected";?>><?php echo $rowData; ?></option>
              <?php } ?>
        </select></td></tr>
        
              </table>
              <button type="button" id="chartsearch6" class="btn btn-primary ">GO</button>	
       </details>

                  </div>
                  <div class="card-body" id='ichart10' style="display:none" >
                    <div id="chart10" class="chartsh">
                    </div>
                  </div>

                  <div class="card-body"  id='ichart9' >	
                  	
                    <div id="chart9" class="chartsh" ></div>
                  </div>
                </div>
              </div>
            </div>


<!--            <div class="row">  hide line--> 


    <!-- Start forth Cards-->

            <div class="row">    
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">
                      
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pt-3">
                        <h3 class="text-center" style="color:red; margin-left: -15px; border-bottom: 1px solid lightgrey;padding-bottom: 10px;">RED FLAGS</h3>

                          <div class="card-content">                       
                            <p class ="mb-0">1. Number of date corrections</p>
                            <p class ="mb-0">2. High for...</p>
                            <p class ="mb-0">3. Scanning % low for...</p>
                            <p class ="mb-0">4. Repeat scan high</p>
                            
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">
                      
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pt-3">
                        <h3 class="text-center" style="color: #ffa426; margin-left: -15px; border-bottom: 1px solid lightgrey;padding-bottom: 10px;">AMBER FLAGS</h3>

                          <div class="card-content">                       
                            <p class ="mb-0">1. Number of date corrections</p>
                            <p class ="mb-0">2. High for...</p>
                            <p class ="mb-0">3. Scanning % low for...</p>
                            <p class ="mb-0">4. Repeat scan high</p>
                            
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">
                      
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pt-3">
                        <h3 class="text-center" style="color:green; margin-left: -15px; border-bottom: 1px solid lightgrey;padding-bottom: 10px;">GREEN FLAGS</h3>

                          <div class="card-content">                       
                            <p class ="mb-0">1. Number of date corrections</p>
                            <p class ="mb-0">2. High for...</p>
                            <p class ="mb-0">3. Scanning % low for...</p>
                            <p class ="mb-0">4. Repeat scan high</p>
                            
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

              </div>
    <!-- End forth cards-->
	
	
	<!-- start budget indicators chart -->
	<!--
		<div class="row">
			<div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Bar Chart</h4>
                  </div>
                  <div class="card-body"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                    <canvas id="barchart1" width="575" height="287" style="display: block; width: 575px; height: 287px;" class="chartjs-render-monitor"></canvas>
                  </div>
                </div>
              </div>
			  
			<div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Bar Chart</h4>
                  </div>
                  <div class="card-body"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                    <canvas id="myChart2" width="572" height="286" style="display: block; width: 572px; height: 286px;" class="chartjs-render-monitor"></canvas>
                  </div>
                </div>
              </div>	
			  
		</div> -->
		  
            <div class="row">
			  
              <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                  <div class="card-header">
                    <h4>Budget Indicators</h4>
                  </div>

                <div class="card-header-action" style="margin-left:50px;">
 
                  <label class="filter-label">Plant</label>
                        <select class="" id="plant11" data-validate="" data-msg="Select Plant">
                          <option value="">All</option>
                        </select>
                  <label class="filter-label">Division/Unit</label>
                        <select class="" id="divisionunit11" data-validate="" data-msg="Select Division/Unit">
                          <option value="">All</option>
                        </select>
                  <label class="filter-label">Category</label>
                    <select class="" id="filterCategory11">
                      <option value="">All</option>
                    </select>
                  <label class="filter-label">Sub. Category</label>
                    <select class="" id="filterSubCategory11">
                      <option value="">All</option>
                    </select>

                    <label class="filter-label">Product</label>
                    <select class="" id="filterProduct11">
                      <option value="">All</option>
                    </select>

                    <label class="filter-label">From - To</label>
                    <input type="text" id="dates" name="daterange" value="01-01-2019 / 01-07-2023" />    

                  <a href="javascript:;" id="getSearchResult11" class="btn btn-primary"><i class="mdi mdi-search"></i> GO</a> 
               </div>

                  <div class="card-body">
                    <canvas id="budget_Chart"></canvas>
                  </div>
                </div>
              </div>
            </div>
			
		 
			
	<!-- end budget indicators chart -->		
	

	<div class="row" style="display:none;">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Assign Task Table</h4>
                    <div class="card-header-form">
                      <form>
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Search">
                          <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <tr>
                          <th class="text-center">
                            <div class="custom-checkbox custom-checkbox-table custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                class="custom-control-input" id="checkbox-all">
                              <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                            </div>
                          </th>
                          <th>Task Name</th>
                          <th>Members</th>
                          <th>Task Status</th>
                          <th>Assigh Date</th>
                          <th>Due Date</th>
                          <th>Priority</th>
                          <th>Action</th>
                        </tr>
                        <tr>
                          <td class="p-0 text-center">
                            <div class="custom-checkbox custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                                id="checkbox-1">
                              <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                            </div>
                          </td>
                          <td>Create a mobile app</td>
                          <td class="text-truncate">
                            <ul class="list-unstyled order-list m-b-0 m-b-0">
                              <li class="team-member team-member-sm"><img class="rounded-circle"
                                  src="views/newdesign/assets/img/users/user-8.png" alt="user" data-toggle="tooltip" title=""
                                  data-original-title="Wildan Ahdian"></li>
                              <li class="team-member team-member-sm"><img class="rounded-circle"
                                  src="views/newdesign/assets/img/users/user-9.png" alt="user" data-toggle="tooltip" title=""
                                  data-original-title="John Deo"></li>
                              <li class="team-member team-member-sm"><img class="rounded-circle"
                                  src="views/newdesign/assets/img/users/user-10.png" alt="user" data-toggle="tooltip" title=""
                                  data-original-title="Sarah Smith"></li>
                              <li class="avatar avatar-sm"><span class="badge badge-primary">+4</span></li>
                            </ul>
                          </td>
                          <td class="align-middle">
                            <div class="progress-text">50%</div>
                            <div class="progress" data-height="6">
                              <div class="progress-bar bg-success" data-width="50%"></div>
                            </div>
                          </td>
                          <td>2018-01-20</td>
                          <td>2019-05-28</td>
                          <td>
                            <div class="badge badge-success">Low</div>
                          </td>
                          <td><a href="#" class="btn btn-outline-primary">Detail</a></td>
                        </tr>
                        <tr>
                          <td class="p-0 text-center">
                            <div class="custom-checkbox custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                                id="checkbox-2">
                              <label for="checkbox-2" class="custom-control-label">&nbsp;</label>
                            </div>
                          </td>
                          <td>Redesign homepage</td>
                          <td class="text-truncate">
                            <ul class="list-unstyled order-list m-b-0 m-b-0">
                              <li class="team-member team-member-sm"><img class="rounded-circle"
                                  src="views/newdesign/assets/img/users/user-1.png" alt="user" data-toggle="tooltip" title=""
                                  data-original-title="Wildan Ahdian"></li>
                              <li class="team-member team-member-sm"><img class="rounded-circle"
                                  src="views/newdesign/assets/img/users/user-2.png" alt="user" data-toggle="tooltip" title=""
                                  data-original-title="John Deo"></li>
                              <li class="avatar avatar-sm"><span class="badge badge-primary">+2</span></li>
                            </ul>
                          </td>
                          <td class="align-middle">
                            <div class="progress-text">40%</div>
                            <div class="progress" data-height="6">
                              <div class="progress-bar bg-danger" data-width="40%"></div>
                            </div>
                          </td>
                          <td>2017-07-14</td>
                          <td>2018-07-21</td>
                          <td>
                            <div class="badge badge-danger">High</div>
                          </td>
                          <td><a href="#" class="btn btn-outline-primary">Detail</a></td>
                        </tr>
                        <tr>
                          <td class="p-0 text-center">
                            <div class="custom-checkbox custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                                id="checkbox-3">
                              <label for="checkbox-3" class="custom-control-label">&nbsp;</label>
                            </div>
                          </td>
                          <td>Backup database</td>
                          <td class="text-truncate">
                            <ul class="list-unstyled order-list m-b-0 m-b-0">
                              <li class="team-member team-member-sm"><img class="rounded-circle"
                                  src="views/newdesign/assets/img/users/user-3.png" alt="user" data-toggle="tooltip" title=""
                                  data-original-title="Wildan Ahdian"></li>
                              <li class="team-member team-member-sm"><img class="rounded-circle"
                                  src="views/newdesign/assets/img/users/user-4.png" alt="user" data-toggle="tooltip" title=""
                                  data-original-title="John Deo"></li>
                              <li class="team-member team-member-sm"><img class="rounded-circle"
                                  src="views/newdesign/assets/img/users/user-5.png" alt="user" data-toggle="tooltip" title=""
                                  data-original-title="Sarah Smith"></li>
                              <li class="avatar avatar-sm"><span class="badge badge-primary">+3</span></li>
                            </ul>
                          </td>
                          <td class="align-middle">
                            <div class="progress-text">55%</div>
                            <div class="progress" data-height="6">
                              <div class="progress-bar bg-purple" data-width="55%"></div>
                            </div>
                          </td>
                          <td>2019-07-25</td>
                          <td>2019-08-17</td>
                          <td>
                            <div class="badge badge-info">Average</div>
                          </td>
                          <td><a href="#" class="btn btn-outline-primary">Detail</a></td>
                        </tr>
                        <tr>
                          <td class="p-0 text-center">
                            <div class="custom-checkbox custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                                id="checkbox-4">
                              <label for="checkbox-4" class="custom-control-label">&nbsp;</label>
                            </div>
                          </td>
                          <td>Android App</td>
                          <td class="text-truncate">
                            <ul class="list-unstyled order-list m-b-0 m-b-0">
                              <li class="team-member team-member-sm"><img class="rounded-circle"
                                  src="views/newdesign/assets/img/users/user-7.png" alt="user" data-toggle="tooltip" title=""
                                  data-original-title="John Deo"></li>
                              <li class="team-member team-member-sm"><img class="rounded-circle"
                                  src="views/newdesign/assets/img/users/user-8.png" alt="user" data-toggle="tooltip" title=""
                                  data-original-title="Sarah Smith"></li>
                              <li class="avatar avatar-sm"><span class="badge badge-primary">+4</span></li>
                            </ul>
                          </td>
                          <td class="align-middle">
                            <div class="progress-text">70%</div>
                            <div class="progress" data-height="6">
                              <div class="progress-bar" data-width="70%"></div>
                            </div>
                          </td>
                          <td>2018-04-15</td>
                          <td>2019-07-19</td>
                          <td>
                            <div class="badge badge-success">Low</div>
                          </td>
                          <td><a href="#" class="btn btn-outline-primary">Detail</a></td>
                        </tr>
                        <tr>
                          <td class="p-0 text-center">
                            <div class="custom-checkbox custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                                id="checkbox-5">
                              <label for="checkbox-5" class="custom-control-label">&nbsp;</label>
                            </div>
                          </td>
                          <td>Logo Design</td>
                          <td class="text-truncate">
                            <ul class="list-unstyled order-list m-b-0 m-b-0">
                              <li class="team-member team-member-sm"><img class="rounded-circle"
                                  src="views/newdesign/assets/img/users/user-9.png" alt="user" data-toggle="tooltip" title=""
                                  data-original-title="Wildan Ahdian"></li>
                              <li class="team-member team-member-sm"><img class="rounded-circle"
                                  src="views/newdesign/assets/img/users/user-10.png" alt="user" data-toggle="tooltip" title=""
                                  data-original-title="John Deo"></li>
                              <li class="team-member team-member-sm"><img class="rounded-circle"
                                  src="views/newdesign/assets/img/users/user-2.png" alt="user" data-toggle="tooltip" title=""
                                  data-original-title="Sarah Smith"></li>
                              <li class="avatar avatar-sm"><span class="badge badge-primary">+2</span></li>
                            </ul>
                          </td>
                          <td class="align-middle">
                            <div class="progress-text">45%</div>
                            <div class="progress" data-height="6">
                              <div class="progress-bar bg-cyan" data-width="45%"></div>
                            </div>
                          </td>
                          <td>2017-02-24</td>
                          <td>2018-09-06</td>
                          <td>
                            <div class="badge badge-danger">High</div>
                          </td>
                          <td><a href="#" class="btn btn-outline-primary">Detail</a></td>
                        </tr>
                        <tr>
                          <td class="p-0 text-center">
                            <div class="custom-checkbox custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                                id="checkbox-6">
                              <label for="checkbox-6" class="custom-control-label">&nbsp;</label>
                            </div>
                          </td>
                          <td>Ecommerce website</td>
                          <td class="text-truncate">
                            <ul class="list-unstyled order-list m-b-0 m-b-0">
                              <li class="team-member team-member-sm"><img class="rounded-circle"
                                  src="views/newdesign/assets/img/users/user-8.png" alt="user" data-toggle="tooltip" title=""
                                  data-original-title="Wildan Ahdian"></li>
                              <li class="team-member team-member-sm"><img class="rounded-circle"
                                  src="views/newdesign/assets/img/users/user-9.png" alt="user" data-toggle="tooltip" title=""
                                  data-original-title="John Deo"></li>
                              <li class="team-member team-member-sm"><img class="rounded-circle"
                                  src="views/newdesign/assets/img/users/user-10.png" alt="user" data-toggle="tooltip" title=""
                                  data-original-title="Sarah Smith"></li>
                              <li class="avatar avatar-sm"><span class="badge badge-primary">+4</span></li>
                            </ul>
                          </td>
                          <td class="align-middle">
                            <div class="progress-text">30%</div>
                            <div class="progress" data-height="6">
                              <div class="progress-bar bg-orange" data-width="30%"></div>
                            </div>
                          </td>
                          <td>2018-01-20</td>
                          <td>2019-05-28</td>
                          <td>
                            <div class="badge badge-info">Average</div>
                          </td>
                          <td><a href="#" class="btn btn-outline-primary">Detail</a></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row" style="display:none;">
              <div class="col-md-6 col-lg-12 col-xl-6">
                <!-- Support tickets -->
                <div class="card">
                  <div class="card-header">
                    <h4>Support Ticket</h4>
                    <form class="card-header-form">
                      <input type="text" name="search" class="form-control" placeholder="Search">
                    </form>
                  </div>
                  <div class="card-body">
                    <div class="support-ticket media pb-1 mb-3">
                      <img src="views/newdesign/assets/img/users/user-1.png" class="user-img mr-2" alt="">
                      <div class="media-body ml-3">
                        <div class="badge badge-pill badge-success mb-1 float-right">Feature</div>
                        <span class="font-weight-bold">#89754</span>
                        <a href="javascript:void(0)">Please add advance table</a>
                        <p class="my-1">Hi, can you please add new table for advan...</p>
                        <small class="text-muted">Created by <span class="font-weight-bold font-13">John
                            Deo</span>
                          &nbsp;&nbsp; - 1 day ago</small>
                      </div>
                    </div>
                    <div class="support-ticket media pb-1 mb-3">
                      <img src="views/newdesign/assets/img/users/user-2.png" class="user-img mr-2" alt="">
                      <div class="media-body ml-3">
                        <div class="badge badge-pill badge-warning mb-1 float-right">Bug</div>
                        <span class="font-weight-bold">#57854</span>
                        <a href="javascript:void(0)">Select item not working</a>
                        <p class="my-1">please check select item in advance form not work...</p>
                        <small class="text-muted">Created by <span class="font-weight-bold font-13">Sarah
                            Smith</span>
                          &nbsp;&nbsp; - 2 day ago</small>
                      </div>
                    </div>
                    <div class="support-ticket media pb-1 mb-3">
                      <img src="views/newdesign/assets/img/users/user-3.png" class="user-img mr-2" alt="">
                      <div class="media-body ml-3">
                        <div class="badge badge-pill badge-primary mb-1 float-right">Query</div>
                        <span class="font-weight-bold">#85784</span>
                        <a href="javascript:void(0)">Are you provide template in Angular?</a>
                        <p class="my-1">can you provide template in latest angular 8.</p>
                        <small class="text-muted">Created by <span class="font-weight-bold font-13">Ashton Cox</span>
                          &nbsp;&nbsp; -2 day ago</small>
                      </div>
                    </div>
                    <div class="support-ticket media pb-1 mb-3">
                      <img src="views/newdesign/assets/img/users/user-6.png" class="user-img mr-2" alt="">
                      <div class="media-body ml-3">
                        <div class="badge badge-pill badge-info mb-1 float-right">Enhancement</div>
                        <span class="font-weight-bold">#25874</span>
                        <a href="javascript:void(0)">About template page load speed</a>
                        <p class="my-1">Hi, John, can you work on increase page speed of template...</p>
                        <small class="text-muted">Created by <span class="font-weight-bold font-13">Hasan
                            Basri</span>
                          &nbsp;&nbsp; -3 day ago</small>
                      </div>
                    </div>
                  </div>
                  <a href="javascript:void(0)" class="card-footer card-link text-center small ">View
                    All</a>
                </div>
                <!-- Support tickets -->
              </div>
              <div class="col-md-6 col-lg-12 col-xl-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Projects Payments</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-hover mb-0">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Client Name</th>
                            <th>Date</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>John Doe </td>
                            <td>11-08-2018</td>
                            <td>NEFT</td>
                            <td>$258</td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Cara Stevens
                            </td>
                            <td>15-07-2018</td>
                            <td>PayPal</td>
                            <td>$125</td>
                          </tr>
                          <tr>
                            <td>3</td>
                            <td>
                              Airi Satou
                            </td>
                            <td>25-08-2018</td>
                            <td>RTGS</td>
                            <td>$287</td>
                          </tr>
                          <tr>
                            <td>4</td>
                            <td>
                              Angelica Ramos
                            </td>
                            <td>01-05-2018</td>
                            <td>CASH</td>
                            <td>$170</td>
                          </tr>
                          <tr>
                            <td>5</td>
                            <td>
                              Ashton Cox
                            </td>
                            <td>18-04-2018</td>
                            <td>NEFT</td>
                            <td>$970</td>
                          </tr>
                          <tr>
                            <td>6</td>
                            <td>
                              John Deo
                            </td>
                            <td>22-11-2018</td>
                            <td>PayPal</td>
                            <td>$854</td>
                          </tr>
                          <tr>
                            <td>7</td>
                            <td>
                              Hasan Basri
                            </td>
                            <td>07-09-2018</td>
                            <td>Cash</td>
                            <td>$128</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <div class="settingSidebar">
            <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
            </a>
            <div class="settingSidebar-body ps-container ps-theme-default">
              <div class=" fade show active">
                <div class="setting-panel-header">Setting Panel
                </div>
                <div class="p-15 border-bottom">
                  <h6 class="font-medium m-b-10">Select Layout</h6>
                  <div class="selectgroup layout-color w-50">
                    <label class="selectgroup-item">
                      <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                      <span class="selectgroup-button">Light</span>
                    </label>
                    <label class="selectgroup-item">
                      <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                      <span class="selectgroup-button">Dark</span>
                    </label>
                  </div>
                </div>
                <div class="p-15 border-bottom">
                  <h6 class="font-medium m-b-10">Sidebar Color</h6>
                  <div class="selectgroup selectgroup-pills sidebar-color">
                    <label class="selectgroup-item">
                      <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                      <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                        data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                    </label>
                    <label class="selectgroup-item">
                      <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                      <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                        data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                    </label>
                  </div>
                </div>
                <div class="p-15 border-bottom">
                  <h6 class="font-medium m-b-10">Color Theme</h6>
                  <div class="theme-setting-options">
                    <ul class="choose-theme list-unstyled mb-0">
                      <li title="white" class="active">
                        <div class="white"></div>
                      </li>
                      <li title="cyan">
                        <div class="cyan"></div>
                      </li>
                      <li title="black">
                        <div class="black"></div>
                      </li>
                      <li title="purple">
                        <div class="purple"></div>
                      </li>
                      <li title="orange">
                        <div class="orange"></div>
                      </li>
                      <li title="green">
                        <div class="green"></div>
                      </li>
                      <li title="red">
                        <div class="red"></div>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="p-15 border-bottom">
                  <div class="theme-setting-options">
                    <label class="m-b-0">
                      <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                        id="mini_sidebar_setting">
                      <span class="custom-switch-indicator"></span>
                      <span class="control-label p-l-10">Mini Sidebar</span>
                    </label>
                  </div>
                </div>
                <div class="p-15 border-bottom">
                  <div class="theme-setting-options">
                    <label class="m-b-0">
                      <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                        id="sticky_header_setting">
                      <span class="custom-switch-indicator"></span>
                      <span class="control-label p-l-10">Sticky Header</span>
                    </label>
                  </div>
                </div>
                <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                  <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                    <i class="fas fa-undo"></i> Restore Default
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <footer class="main-footer">
          <div class="footer-left">
            <a href="templateshub.net">Templateshub</a></a>
          </div>
          <div class="footer-right">
          </div>
        </footer>
      </div>
    </div>
    <!-- General JS Scripts -->
    <script>
    num=[0, 0, 0, 0, 0, 0,0, 0, 0, 0, 0, 0];
    point=[0, 0, 0, 0, 0, 0,0, 0, 0, 0, 0, 0];
    couponcount=[0, 0, 0, 0, 0];
    usercount=[0, 0, 0, 0, 0];
    couponcount5=[0, 0, 0, 0, 0];
    usercount5=[0, 0, 0, 0, 0];
    couponcount7=[0, 0, 0, 0, 0,0, 0, 0, 0, 0,0,0];
    usercount7=[0, 0, 0, 0, 0,0, 0, 0, 0, 0,0,0];
    couponcount8=[0, 0, 0, 0, 0,0, 0, 0, 0, 0,0,0];
    usercount8=[0, 0, 0, 0, 0,0, 0, 0, 0, 0,0,0];

    couponcount6=[0, 0, 0, 0, 0];	
	  usercount6=[0, 0, 0, 0, 0];	
    totaluser6=[0, 0, 0, 0, 0];	
	  couponcount9=[0, 0, 0, 0, 0,0, 0, 0, 0, 0,0,0];	
    usercount9=[0, 0, 0, 0, 0,0, 0, 0, 0, 0,0,0];	
    totaluser9=[0, 0, 0, 0, 0,0, 0, 0, 0, 0,0,0];    
    max=40000;        

    yearof="<?php echo date('Y');?>"+"-<?php echo (date('Y')+1);?>";
    </script>
    <script src="views/newdesign/assets/js/app.min.js"></script>
    <!-- JS Libraies -->
    <script src="views/newdesign/assets/bundles/apexcharts/apexcharts.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="views/newdesign/assets/js/page/index.js"></script>
    <!-- Template JS File -->
    <script src="views/newdesign/assets/js/scripts.js"></script>
    <!-- Custom JS File -->
    
    <script src="views/newdesign/assets/js/custom.js"></script>
    
    <script type="text/javascript">
    var APP_URL = '<?php echo APP_URL; ?>';
    var API_URL = '<?php echo API_URL; ?>';
    var authReq = true;
  </script>
  <script src="<?php echo VIEW_PATH; ?>/js/base.js"></script>
    <script src="views/newdesign/assets/js/allCard.js"></script>
    <script src="views/newdesign/assets/js/scanTrendModule.js"></script>
    <script src="views/newdesign/assets/js/WeekScanTreand.js"></script>
	
<!-- start budget indicators chart -->

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
</script>

  <script src="views/newdesign/assets/js/budgetChart/chart.min.js"></script>  
<!--  <script src="views/newdesign/assets/js/budgetChart/budget_chart.js"></script>  -->
    <script src="views/newdesign/assets/js/budgetChart.js"></script>  
  
<!-- end  budget indicators chart -->
<script>
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
</script>

    <script>
  $(document).ready(function(){ 
      $("input[name$='vchart4']").click(function() {
          var test = $(this).val();
          //alert(test);
          if(test=='week')
          {
          $("#ichart7").hide();
          $("#ichart4").show();
          initwelcomechart5();
          }
          else{

            $("#ichart4").hide();
          $("#ichart7").show();
          }          
          $("#chartsearch4").click();
      }); 
      $("input[name$='vchart5']").click(function() {
          var testx = $(this).val();
          if(testx=='week')
          {
          $("#ichart8").hide();
          $("#ichart5").show();
          }
          else{

            $("#ichart5").hide();
          $("#ichart8").show();
          }

          $("#chartsearch5").click();	
      }); 	
	   $("input[name$='vchart10']").click(function() {	
          var testy = $(this).val();	
          if(testy=='week')	
          {	
          $("#ichart9").hide();	
          $("#ichart10").show();	
          }	
          else{	
            $("#ichart10").hide();	
          $("#ichart9").show();	
          }	
          $("#chartsearch6").click();


      }); 
  });
  </script>
    

  </body>


  <!-- index.html  21 Nov 2019 03:47:04 GMT -->
  </html>
