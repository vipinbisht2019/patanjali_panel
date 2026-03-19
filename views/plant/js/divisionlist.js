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
            r += '<div class="td inlineText">' + object.unit_name + '</div>';
            r += '<div class="td inlineText">' + object.plant_name + '('+object.plant_code+') </div>';
            r += '<div class="td inlineText">' + object.unit_code + '</div>';
            r += '<div class="td inlineText">' + object.dateTime + '</div>';
          
            r += '<div class="td action">';
     
            r += '<a href="javascript:;" class="deleteListItem" data-id="' + object.unit_id + '"><i class="mdi mdi-delete"></i></a>';
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
            url: API_URL + '/division/divisionlist',
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
            url: API_URL + '/division/divisionDelete',
            data: JSON.stringify({
                unit_id: id
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
            filterDivisionName: $('#filterDivisionName').val(),
            filterDivisionCode: $('#filterDivisionCode').val(),
        }
  
     $.ajax({
            type: "POST",
            url: API_URL + '/division/divisionlist',
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
    
    
$('#addNewRecord').click(function(){
        bodyFix();
        var modalBox = $('#addEditModal');
        modalBox.find('.modal-header h3').text('Add New Division/Unit');
        modalBox.addClass('show');
        var selected = "";

         // load the plants dropdown
        var selectPlantBox = $('#plant');
        var plantOption = '<option value="">Select</option>';
        
            $.ajax({  
            type: "GET",  
            url: API_URL+'/plant/getPlantList',      
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.success==1){
                    $.each(response.data, function(i, object){
                      plantOption +='<option value="'+object.plant_id+'">' +object.plant_name+'</option>';
                    });
                  }
                  selectPlantBox.html(plantOption);
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
        
 
        $('.loaderWrap').hide();
        
        
    });
    
    
$('#editForm').submit(function() {
        var form = $(this);
        if (validateForm(form)) {

            var dataString = {
                plantId: $('#plant :selected').val(),
                inptDivisionName: $('#inptDivisionName').val(),
                inptDivisionCode: $('#inptDivisionCode').val()
            }

            var modalBox = $('#addEditModal');
            showPageLoader();

            $.ajax({
                type: "POST",
                url:  API_URL + '/division/addDivision',
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success == 1) {
                        modalBox.find('.close').click();
                        initDataList();
                        showResponseSuccessMsg("Division/Unit successfully added.");
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

        }
        return false;
    });



})(jQuery);