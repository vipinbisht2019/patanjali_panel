(function($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initDataList();
    }else {
        hidePageLoader();
    }

    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        $.each(dataArray, function(i, object) {
            var status = 'active';
            if(object.is_active!=1){
                status = 'Inactive';
            }
            r += '<div class="tr">';
                r += '<div class="td">' + object.name + '</div>';
                r += '<div class="td">' + status + '</div>';
                r += '<div class="td action">';
//                r += '<a href="javascript:void();" class="editListItem" data-id="' + object.id + '"><i class="mdi mdi-pencil"></i></a>';
                r += '<a href="'+APP_URL+'/feedback-options/edit/'+object.id+'" class="editListItem" data-id="' + object.id + '"><i class="mdi mdi-pencil"></i></a>';
                r += '</div>';
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
            url: API_URL + '/feedback/options',
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

    $('#saveOption').on('click',function(){
        showPageLoader();
        var option_id = 0;
        if($('#optionId').length>0){
            option_id = $('#optionId').val();
        }
        var postData = {
            name: $('#optionName').val(),
            option_id: option_id,
            is_active: $('#optionStatus').val()
        };
        
        $.ajax({
            type: "POST",
            url: API_URL + '/feedback-options/save',
            data: JSON.stringify(postData),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                hidePageLoader();
            },
            success: function(response) {
                console.log(response);
                if (response.success == 1) {
                    showResponseSuccessMsg("Option saved successfully!");
                    window.location.href = APP_URL+'/feedback/options';
                } else {    
                    showResponseErrorMsg("Server was unable to process request");
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