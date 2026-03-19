<?php 
   require_once '../../config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/css/vendor/bootstrap-float-label.min.css" />
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/css/login.css" />
</head>
<body class="background show-1">
    <div class="fixed-background"></div>
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-10 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="position-relative image-side">
                            <div style="padding-bottom:20px;">
                                <img src="<?php echo ASSETS_PATH; ?>/images/lami_logo.png" style="max-height:63px;">
                                
                                
                            </div>
                        <!--    <p class="h2">TEST PARAS Admin Login</p>
                            <p class="mb-0">
                                Please use your credentials to login.
                              
                            </p> -->
                        </div>
                        <div class="form-side" style="background: #fcfcfc;">
                            <a href="#">
                                <span class="logo-single"></span>
			    </a>
<img src="" style="margin-left: 0px;max-height:63px;"><br><br>
                            <div id="loginMsg"></div>
                            <h6 class="mb-4">Login</h6>
                            <form id="userLoginForm">
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control validate" id="loginUsername" data-validate="" data-msg="Please enter username" />
                                    <span>E-mail / Username</span>
                                </label>

                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control validate" id="loginPassword" type="password" data-validate="" data-msg="Please enter password" placeholder="" />
                                    <span>Password</span>
                                </label>
                                <div class="d-flex justify-content-between align-items-center">
                                    <button class="btn btn-primary btn-lg btn-shadow" type="submit">LOGIN</button>
                                    <!-- <a href="#">Forget password?</a> -->
                                </div>
                            </form>
                            <form id="otpLoginForm" style="display: none;">
                                <input type="hidden" id="loginOtpToken" name="loginOtpToken" value="<?php echo md5(rand()); ?>">
                                <label class="form-group has-float-label mb-4">
                                    <input type="password" class="form-control validate" id="loginOtp" data-validate="" data-msg="Please enter otp code" />
                                    <span>OTP Code</span>
                                </label>
                                <div class="d-flex justify-content-between align-items-center">
                                    <button class="btn btn-primary btn-lg btn-shadow" type="submit">Verify</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript">
        var APP_URL = '<?php echo APP_URL; ?>';
        var API_URL = '<?php echo API_URL; ?>';
    </script>
    <script src="<?php echo ASSETS_PATH; ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo ASSETS_PATH; ?>/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo VIEW_PATH; ?>/js/base.js"></script>
    <script src="<?php echo VIEW_PATH; ?>/auth/login.js"></script>
</body>
</html>
