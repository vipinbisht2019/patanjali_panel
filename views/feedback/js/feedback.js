(function($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initDataList();
    }

    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        $.each(dataArray, function(i, object) {
            r += '<div class="tr align-items-center">';
            r += '<div class="td"><div><b>' + object.title + '</b><br>' + object.remark + '</div></div>';
            r += '<div class="td">' + object.couponCode + '</div>';
            r += '<div class="td">' + object.productName + '</div>';
            r += '<div class="td">' + object.name + '</div>';
            r += '<div class="td">' + object.mobile + '</div>';
            r += '<div class="td">' + object.city + '</div>';
            r += '<div class="td">' + object.createdOn + '</div>';

            //r += '<div class="td action">';
            //r += '<a href="javascript:;" class="editListItem" data-id="' + object.id + '"><i class="mdi mdi-pencil"></i></a>';
            //r += '<a href="javascript:;" class="deleteListItem" data-id="' + object.id + '"><i class="mdi mdi-delete"></i></a>';
            //r += '</div>';

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

    function initDataList() {

        var dataString = {
            limit: $('#datatable').data('limit'),
            page: $('#datatable').data('page')
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/userFeedback',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    initData(response.data);
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
    }




})(jQuery);