(function($) {
    'use strict';

    hidePageLoader();
    $('#filterDate').datepicker({format:'dd/mm/yyyy'});

    function initData(response) {
        var dataResult = $('#dataTableResult');
        var r = '';

        $.each(response.data, function(i, object) {
            r += '<div class="tr meta">'; 
            r += '<div class="td">' + object.name + '</div>';
            r += '<div class="td">' + object.mobile + '</div>';
            r += '<div class="td">' + object.userType + '</div>';
            r += '<div class="td">' + object.date + '</div>';
            r += '</div>';
        });
        dataResult.html(r);
    }

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

    $('#getSearchResult').click(function(){

        $('#datatable').data('page', 1);

        var dataString = {
            date: $('#filterDate').val(),
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/report/scanAlert',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    $('#downloadBtnWrap').show();
                    initData(response);
                } else {
                    $('#downloadBtnWrap').hide();
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

    $('#getDownload').click(function(){

        $('#datatable').data('page', 1);

        var dataString = {
            date: $('#filterDate').val(),
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/report/scanAlert',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    JSONToCSVConvertor(response.data, 'ScanAlertReport', true);
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


    $('body').on('click','.viewSummery', function(){

        var date = $(this).data('date');
        var type = $(this).data('type');
        var user = $(this).data('user');

        var dataString = {
            user: user,
            type: type,
            date: date
        }

        if(type==3){
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

                        if(type==1){
                            r += '<div class="tr summeryRow">'; 
                            r += '<div class="td">' + object.productFiled3 + ' - ' + object.productSeries + '<br>Coupon Code: ' + object.couponCode + '</div>';
                            r += '<div class="td w120 points">' + object.points + '</div>';
                            r += '</div>';

                            title = 'Scanned Points Summery - '+date;
                        }

                        if(type==2){
                            r += '<div class="tr summeryRow">'; 
                            r += '<div class="td">' + object.receivedFromName + ' - ' + object.receivedFromMobile + '<br>Ref ID: ' + object.ref_no + '</div>';
                            r += '<div class="td w120 points">' + object.points + '</div>';
                            r += '</div>';

                            title = 'Received Points - '+date;
                        }

                        if(type==3){

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

})(jQuery);