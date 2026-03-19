$(document).ready(function() {

    //hidePageLoader();

    $('#userLoginForm').submit(function() { 

        var form = $(this);
        var msg = $('#loginMsg');
        msg.html('');

        var dataString = {
            username: $('#loginUsername').val(),
            password: $('#loginPassword').val(),
        }

        if (validateForm(form)) {
            showPageLoader();
            $.ajax({
                type: "POST",
                url: API_URL + '/login',
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) { //alert(data);
                    if (response.success == 1) {
                        hidePageLoader();
                        $('#userLoginForm').hide();
                        $('#otpLoginForm').show();
                        $('#loginOtpToken').val(response.data.token);
                    } else {
                        msg.html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' + response.message + '</div>');
                        hidePageLoader();
                    }
                }
            });
        }

        return false;
    }); // END LOGIN

    $('#otpLoginForm').submit(function() { 

        var form = $(this);
        var msg = $('#loginMsg');
        msg.html('');

        var dataString = {
            otpcode: $('#loginOtp').val(),
            token: $('#loginOtpToken').val()
        }

        if (validateForm(form)) {
            //showPageLoader();
            $.ajax({
                type: "POST",
                url: API_URL + '/validateLoginOtp',
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) { //alert(data);
                    if (response.success == 1) {
                        localStorage.setItem('session', JSON.stringify(response.data));
                        msg.html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="success" aria-hidden="true">x</button>' + response.message + '</div>');
                        window.location.href=APP_URL+'/newdashboard';
                    } else {
                        msg.html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' + response.message + '</div>');
                        //hidePageLoader();
                    }
                }
            });
        }

        return false;
    }); // END LOGIN



}); // END DOCUMENT READY