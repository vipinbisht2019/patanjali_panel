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
        var totalRecord = Object.keys(response).length+1;
        if (totalRecord > dataString.limit) {
            $('#dataPagination').twbsPagination({
                totalPages: totalRecord,  
                visiblePages: 5,  
                next: "Next",  
                prev: "Prev", 
                onPageClick: function(event, page) {
                    $('#datatable').data("page",page);
                    initDataList();
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
            url: API_URL + '/authorisation/alist',
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
                    initPagination(response.data,dataString);
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
            url: API_URL + '/authorisation/delete',
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
            url: API_URL + '/authorisation/alist',
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
     

    });
    

        
$('body').on('click', '#importProcessBtn', function () {
        
    var modalBox = $('#uploadModel');
    modalBox.addClass('show');
    modalBox.find('.modal-header h3').text('Choose Authorisation File');
       
});   


})(jQuery);