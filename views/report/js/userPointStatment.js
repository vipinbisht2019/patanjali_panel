(function($) {
    'use strict';

    hidePageLoader();

    function initData(response) {
        var dataResult = $('#dataTableResult');
        var r = '<form id="remarkForm" method="POST">';
        var remark = '';
        var optionText = "";

        $(".pointremark").css("display", "none");
        

        $.each(response.data, function(i, object) {
            
          // remark = "Transfer to : " + object.transferTo +"<br>"+object.name +"<br>"+object.mobile;
             remark = "Transfer to : " + object.transferTo +"<br>"+object.mobile;

            if (object.type == 1)
              // remark = "Coupon Scanned " + object.totalScan+"<br>"+object.name +"<br>"+object.mobile;
                remark = "Coupon Scanned " + object.totalScan;

            else if (object.type == 2)
              //  remark = "Points Received <br>"+object.name +"<br>"+object.mobile;
                remark = "Points Received ";


            else if (object.type == 4)
                remark = "Gift Redeem <br>"+object.name +"<br>"+object.mobile;


            else if (object.type == 5)
                remark = "Gift Point Return <br>"+object.name +"<br>"+object.mobile;
            else if (object.type == 6)
                // remark = "Bonus Coupon Generated" + object.totalScan+"<br>"+object.name +"<br>"+object.mobile;
                  remark = "Bonus Coupon Generated " + object.totalBonus;
  


            r += '<div class="tr meta viewSummery" data-user="' + response.profile.id + '"  data-type="'+object.type+ '" data-date="' + object.createdDate + '" refid="' + object.refId + '">';
            r += '<div class="td">' + remark + '</div>';
            r += '<div class="td">' + object.points + '</div>';
            r += '<div class="td">' + object.balance + '</div>';
            r += '<div class="td">' + object.createdDate + '</div>';


            if (object.type == 2) // appear only for Receiver number
            {
                r += '<div class="td pointremark"><select  id="sel' + object.refId + '"  class="pointPaidStatus form-control" name="' + object.refId + '"  data-type="' + object.type + '">';
                r += '<option id="option' + object.refId + '" value="">---Select---</option>';
                r += '<option id="option1' + object.refId + '" value="1">Paid</option>';
                r += '<option id="option0' + object.refId + '" value="0">Unpaid</option>';
                r += '</select></div>';

                r += '<div class="td pointremark"><textarea  class="remark form-control" name="' + object.refId + '"  data-type="' + object.type + '">' + object.pointRemark + '</textarea></div>';

            } else {

                r += '<div class="td"></div>';
                r += '<div class="td"></div>';

            }
            r += '</div>';



            if (object.type == 2) // appear only for Receiver number
            {

                var selectedOptionId = 'option' + object.pointPaidStatus + object.refId;

                setTimeout(function() {
                    $("#" + selectedOptionId).attr("selected", "selected");
                }, 100);

            }

        });

        r += '</form>';


        dataResult.html(r);
    }

    $.ajax({  
        type: "POST",  
        url: API_URL+'/setting/options',       
        data: JSON.stringify({}),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        cache: false,
        success: function(response){  
            hidePageLoader();
            if(response.success==1) {
            //  $('#adminNumber').val(response.data.ADMIN_SCAN_NUMBER);
                $('#pointReceiver').html(response.data.ADMIN_POINT_RECEIVER);
            } else {
                //alert(response.message);
            }
        }, 
        error: function(error, xhr){
            hidePageLoader();
            console.log('error', error);
            console.log('xhr', xhr);
        }
    });

    function noResult() {
        if ($('.simple-pagination').length) {
            $('#dataPagination').pagination('destroy');
        }
        var dataResult = $('#dataTableResult');
        var r = '<div class="tr noResult">';
        r += '<div class="td">No Result Found</div>';
        r += '</div>';
        dataResult.html(r);
        $('#currenPointBalance').text(0);
    }

    function initPagination(response, dataString) {
        if ($('.simple-pagination').length) {
            $('#dataPagination').pagination('destroy');
        }

        if (response.total > dataString.limit) {
            $('#dataPagination').pagination({
                items: response.total,
                itemsOnPage: dataString.limit,
                currentPage: dataString.page,
                cssStyle: 'light-theme',
                onPageClick: function(pageNumber, event) {
                    $('#datatable').data('page', pageNumber);
                    $("html, body").animate({
                        scrollTop: 0
                    }, "fast");
                    initSearchResult();
                },
            });
        }
    }

    $('#getSearchResult').click(function() {

        $('#datatable').data('page', 1);

        var dataString = {
            mobile: $('#filterMobile').val(),
            pointSdate: $('#pointstartdate').val(),
            pointEdate: $('#pointenddate').val(),
        }

        if ($('#filterMobile').val() == "") {
            alert("Please enter the mobile number !!");
            $('#filterMobile').focus();
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/report/userPointStatment',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    initData(response);

                    $('#currenPointBalances').text(response.profile.balance);
                    $('#userProfileName').text(response.profile.name);
                    $('#userProfileDealerCode').text(response.profile.dealerCode);
                    $('#userProfileProfession').text(response.profile.roleName);
                    $('#userProfileCity').text(response.profile.city);
                    $('#userId').val(response.profile.id);

                    $("#getDownloadDIV").css("display", "block");
                    
                    if(response.mobileMatchAdminReceiver == "Yes")
                        $(".pointremark").css("display", "block");


                } else {
                    
                    $('#currenPointBalances').text(response.profile.balance);
					$('#userProfileName').text(response.profile.name);
					$('#userProfileDealerCode').text(response.profile.dealerCode);
                    $('#userProfileProfession').text(response.profile.roleName);

                    noResult();
                    $("#getDownloadDIV").css("display", "none");
                    $(".pointremark").css("display", "none");

                }
            },
            complete: function(response) {
                hidePageLoader();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });

    });


    $('#submitbtn').click(function() {

        $('#datatable').data('page', 1);

        var pointPaidStatus = $(".pointPaidStatus");

        var pointPaidStatusArray = $.map(pointPaidStatus, function(element) {
            return {
                itemRefId: element.name,
                value: element.value,
                pointType: element.getAttribute('data-type')
            };
        });

        var remark = $(".remark");

        var remarkArray = $.map(remark, function(element) {
            return {
                itemRefId: element.name,
                value: element.value
            };
        });


        var dataString = {
            userId: $('#userId').val(),
            pointPaidStatusVar: pointPaidStatusArray,
            remarkVar: remarkArray
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/report/remarkPoints',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    showResponseSuccessMsg(response.message);
                    $("#getSearchResult").trigger("click");

                } else {
                    noResult();
                }
            },
            complete: function(response) {
                hidePageLoader();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });

    });


    $('#getDownload').click(function() {

        $('#datatable').data('page', 1);

        var dataString = {
            mobile: $('#filterMobile').val(),
            pointSdate: $('#pointstartdate').val(),
            pointEdate: $('#pointenddate').val(),
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/report/userPointStatmentDownload',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {

                    $('#userProfileName').text(response.profile.name);
                    $('#userProfileProfession').text(response.profile.roleName);

                    JSONToCSVConvertor(response.data, 'User Point Statment Report', true);

                } else {
                    noResult();
                }
            },
            complete: function(response) {
                hidePageLoader();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });

    });


    $('body').on('click', '.viewSummery', function() {

        var date = $(this).data('date');
        var type = $(this).data('type');
        var user = $(this).data('user');

        var refId = $(this).data('refid');

        var dataString = {
            user: user,
            type: type,
            date: date,
            refId: refId
        }

        if (type == 3) {
            return false;
        }

        var summeryModal = $('#summeryModal').show();
        var summeryData = $('#summeryData');
        summeryModal.addClass('show');

        var r = '';
        var title = '';

        $.ajax({
            type: "POST",
            url: API_URL + '/report/userPointSummery',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                showPageLoader();
            },
            success: function(response) {
                if (response.success == 1) {

                    $.each(response.data, function(i, object) {

                        if (type == 1) {
                            r += '<div class="tr summeryRow">';
                            r += '<div class="td">' + object.productFiled3 + ' - ' + object.productSeries + '<br>Coupon Code: ' + object.couponCode + '</div>';
                            r += '<div class="td w120 points">' + object.points + '</div>';
                            r += '</div>';

                            title = 'Scanned Points Summery - ' + date;
                        }
                        if (type == 6) {
                            r += '<div class="tr summeryRow">';
                            r += '<div class="td">' + object.productFiled3 + ' - ' + object.productSeries + '<br>Coupon Code: ' + object.couponCode + '</div>';
                            r += '<div class="td w120 points">' + object.points + '</div>';
                            r += '</div>';

                            title = 'Bonus Points Summery - ' + date;
                        }

                        if (type == 2) {
                            r += '<div class="tr summeryRow">';
                            r += '<div class="td">' + object.receivedFromName + ' - ' + object.receivedFromMobile + '<br>Ref ID: ' + object.ref_no + '</div>';
                            r += '<div class="td w120 points">' + object.points + '</div>';
                            r += '</div>';

                            title = 'Received Points - ' + date;
                        }


                        if (type == 4) {


                            var transactionId = "TX#" + object.id;

                            r += '<div class="tr summeryRow">';

                            r += '<div class="td"> Transaction Id: ' + transactionId + ' <br> Gift Request Date: ' + object.giftRequestDate + ' <br> Gift Request Status: ' + object.requestStatus + '</div>';

                            r += '<div class="td w120 points">' + object.points + '</div>';
                            r += '</div>';

                            title = 'Gift Redeem - ' + date;
                        }


                        if (type == 5) {


                            var transactionId = "TX#" + object.id;

                            r += '<div class="tr summeryRow">';

                            r += '<div class="td"> Transaction Id: ' + transactionId + ' <br> Gift Request Date: ' + object.giftRequestDate + ' <br> Gift Request Status: ' + object.requestStatus + '</div>';

                            r += '<div class="td w120 points">' + object.points + '</div>';
                            r += '</div>';

                            title = 'Gift Point Return - ' + date;
                        }


                        if (type == 3) {

                        }

                    });
                }

                summeryModal.find('h3').html(title);
                summeryData.html(r);
            },
            complete: function(response) {
                hidePageLoader();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });

    });



    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [month, day, year].join('/');
    }


    $('#pointstartdate').datepicker({
        format: 'dd-mm-yyyy'
    });
    $('#pointenddate').datepicker({
        format: 'dd-mm-yyyy'
    });

    $("#pointenddate").change(function() {

        var startDate = formatDate(new Date($('#pointstartdate').val()));
        var endDate = formatDate(new Date($('#pointenddate').val()));


        if ((Date.parse(startDate) >= Date.parse(endDate))) {
            alert("End date should be greater than Start date");
            document.getElementById("pointenddate").value = "";
        }
    });


})(jQuery);