(function($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initDataList();
    }

    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
         var currentAuthoriseStatus = "";
         
        $.each(dataArray, function(i, object) {
            
            currentAuthoriseStatus =  (object.is_ofa == 1) ? statusLable('Open for all', 'success') : statusLable('Limited Authorise', 'red');
            
            
            r += '<div class="tr align-items-center">';
            r += '<div class="td inlineText">' + object.mobile + '</div>';
            r += '<div class="td inlineText">' + object.category_name + '</div>';
             r += '<div class="td inlineText">' + currentAuthoriseStatus + '</div>';
          
            r += '<div class="td action">';
     
            r += '<a href="javascript:;" class="deleteListItem" data-id="' + object.id + '"><i class="mdi mdi-delete"></i></a>';
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
            url: API_URL + '/deauthorisation/dlist',
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


    $('body').on('click', '.deleteListItem', function() {
        if (!confirm('Are you sure?')) {
            return false;
        }
        var id = $(this).data('id');
        showPageLoader();
        $.ajax({
            type: "POST",
            url: API_URL + '/deauthorisation/delete',
            data: JSON.stringify({
                id: id
            }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response) {
                if (response.success == 1) {
                    initDataList();
                } else {
                    showResponseErrorMsg(response.message);
                }
                hidePageLoader();
            },
            error: function(error, xhr) {
                console.log('error', error);
                console.log('xhr', xhr);
                showResponseErrorMsg("Unable to proccess this request.");
                hidePageLoader();
            }
        });
    });



    $('#getSearchResult').click(function(){

        $('#datatable').data('page', 1);
        
        var dataString = {
			limit: $('#datatable').data('limit'),
            page: $('#datatable').data('page'),
            mobile: $('#filterMobile').val(),
        }
        
        if($('#filterMobile').val() ===""){
             alert("Please enter the mobile number !!");
             $('#filterMobile').focus();
        }
        
     $.ajax({
            type: "POST",
            url: API_URL + '/deauthorisation/dlist',
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
     

    })
    
    


})(jQuery);