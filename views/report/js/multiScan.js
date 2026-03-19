(function($) {
    'use strict';

    hidePageLoader();

    if ($('#datatable').length > 0) {
        initDataList();
    }
    
    
   function initDataList() {
        
        var dataString = {
            limit: $('#datatable').data('limit'),
            page: $('#datatable').data('page')
        }
     
        $.ajax({
            type: "POST",
            url: API_URL + '/report/multiScan',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function () {
                hidePageLoader();
            },
            success: function (response) {
                if (response.success == 1) {
                    initData(response.data);
                } else {
                    noResult();
                }
            },
            complete: function (response) {
                hidePageLoader();
            },
            error: function (xhr, status, error) {
               console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });
    }
    
    
    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        var jsTimestamp = "";
     
        $.each(dataArray, function(i, object) {
            
            jsTimestamp = new Date(object.activated_on * 1000);
                    
            r += '<div class="tr meta">';
            r += '<div class="td inlineText">' + object.QRcode + '</div>';
            r += '<div class="td inlineText">' + object.scanCount + '</div>';
            r += '<div class="td inlineText">' + object.batch_number + '</div>';
            r += '<div class="td inlineText">' + jsTimestamp + '</div>';
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

        $('#datatable').data('page', 1);

        var dataString = {
            numofscan: $('#numscan :selected').val(),
            couponcodefilter: $('#couponcodefilter').val(),
            frmDate: $('#frmDate').val(),
            toDate: $('#toDate').val()
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/report/multiScan',
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
    

  $('#frmDate').datepicker({ format: 'yyyy-mm-dd' });
  $('#toDate').datepicker({ format: 'yyyy-mm-dd' });
    

    $( "#toDate" ).focusout(function() {
        
        var startDate = new Date($('#frmDate').val());
        var endDate = new Date($('#toDate').val());
        
         if (startDate > endDate){
             alert("End date can not be less than start date !!");
         }
         
    });


})(jQuery);