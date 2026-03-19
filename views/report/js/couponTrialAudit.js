(function($) {
    'use strict';

    hidePageLoader();

    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';

        $.each(dataArray, function(i, object) {
            r += '<div class="tr meta">';
            r += '<div class="td inlineText">' + object.date + '</div>';
            r += '<div class="td inlineText">' + object.status + '</div>';
            r += '<div class="td inlineText">' + object.ownerName + '</div>';
            r += '<div class="td inlineText">' + object.customerType + '</div>';
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

        $('#resetCouponWrap').css('visibility','hidden');
        $('#resetCoupon').data('id', 0);

        $('#datatable').data('page', 1);

        var dataString = {
            couponCode: $('#filterCouponCode').val(),
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/report/couponTrialAudit',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                showPageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    initData(response.data);

                    if(response.isCouponScanned==1 && response.isCouponTransfred==0){
                        $('#resetCouponWrap').css('visibility','visible');
                        $('#resetCoupon').data('id', response.couponId);
                    }

                    $('#getDownloadWrap').show();

                } else {
                    noResult();
                    $('#getDownloadWrap').hide();
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

        $('#resetCouponWrap').css('visibility','hidden');
        var dataString = {
            couponCode: $('#filterCouponCode').val(),
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/report/couponTrialAudit',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                showPageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    JSONToCSVConvertor(response.data, 'COUPON TRAIL AUDIT', true);


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

    $('#resetCoupon').click(function(){

        if(!confirm('Are you sure want to reset this coupon?')){
            return false;
        }

        var id  = $(this).data('id');
        var dataString = {id:id}

        $.ajax({
            type: "POST",
            url: API_URL + '/resetScannedCoupon',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    
                    $('#resetCouponWrap').css('visibility','hidden');
                    $('#resetCoupon').data('id', 0);
                    showResponseSuccessMsg(response.message);
                    $('#getSearchResult').click();
                    
                } else {
                    showResponseErrorMsg(response.message);
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








})(jQuery);