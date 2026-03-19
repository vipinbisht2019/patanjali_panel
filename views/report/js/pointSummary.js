(function($) {
    'use strict';

    hidePageLoader();
    initPlant('#plant', 'All');
    initState('#filterState', 'All');

    function initState(selectBox, defaultLabel){
        var selectBox = $(selectBox);
        var option = '<option value="">'+defaultLabel+'</option>';
        $.ajax({  
            type: "GET",  
            url: API_URL+'/ajaxCouponStateList',      
            data: '',
            dataType: "json",
            cache: false,
            success: function(response){
              if(response.success==1){
                $.each(response.data, function(i, object){
                  option+='<option value="'+object.stateName+'">'+object.stateName+'</option>';
                });
              }
              selectBox.html(option);
            }, error: function(error, xhr){
               alert(xhr);
            }
        });
    }

    $('#filterState').change(function() {
        var stateName = $(this).find(':selected').val();
        var selectBox = $('#filterCity');
        var option = '<option value="">All</option>';

        if(stateName!=''){

            var dataString = {
                stateName:stateName
            }

            $.ajax({  
                type: "POST",  
                url: API_URL+'/ajaxCouponCityList',      
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response){
                  if(response.success==1){
                    $.each(response.data, function(i, object){
                      option+='<option value="'+object.cityName+'">'+object.cityName+'</option>';
                    });
                  }
                  selectBox.html(option);
                }, error: function(error, xhr){
                   alert(xhr);
                }
            });

        } else {
            selectBox.html(option);
        }
    });
    
    
        
    function initPlant(selectBox, defaultLabel){
        var selectPlantBox = $(selectBox);
        var plantOption = '<option value="">'+defaultLabel+'</option>';
        $.ajax({  
            type: "GET",  
            url: API_URL+'/plant/getPlantList', 
            data: '',
            dataType: "json",
            cache: false,
            success: function(response){
               if(response.success==1){
                    $.each(response.data, function(i, object){
                      plantOption +='<option value="'+object.plant_id+'">' +object.plant_name+'</option>';
                    });
                  }
              selectPlantBox.html(plantOption);
            }, error: function(error, xhr){
               alert(xhr);
            }
        });
    }
    
    
    // division list
$('#plant').change(function() {
    var plantId = $(this).find(':selected').val();
    var dataString = {
            plantId:plantId
        }
    
         // load the plants dropdown
        var selectDivisionBox = $('#divisionunit');
        var divisionOption = '<option value="">Select</option>';
        
        showPageLoader();
        
            $.ajax({  
            type: "POST",  
            url: API_URL+'/division/getDivisionByPlant',      
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(dataString),
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.success==1){
                    $.each(response.data, function(i, object){
                      divisionOption +='<option value="'+object.unit_id+'">' +object.unit_name+'</option>';
                    });
                  }
                  selectDivisionBox.html(divisionOption);
                  
                  hidePageLoader();
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
 
    });
    

    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';

        $.each(dataArray, function(i, object) {
            r += '<div class="tr meta">';
            r += '<div class="td inlineText">' + object.customerName + '</div>';
            r += '<div class="td inlineText">' + object.dealerCode + '</div>';
            r += '<div class="td inlineText">' + object.customerType + '</div>';
            r += '<div class="td inlineText">' + object.scannedPoints + '</div>';
            r += '<div class="td inlineText">' + object.receivedPoints + '</div>';
            r += '<div class="td inlineText">' + object.balance + '</div>';
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
            year: $('#filterYear :selected').val(),
            plantId: $('#plant :selected').val(),
            divisionId: $('#divisionunit :selected').val(),
            customerType: $('#filterCustomerType :selected').val(),
            state: $('#filterState :selected').val(),
            city: $('#filterCity :selected').val(),
            limit: $('#datatable').data('limit'),
            page: $('#datatable').data('page')
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/report/pointSummary',
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

    $('#getDownload').click(function(){

        var dataString = {
            year: $('#filterYear :selected').val(),
            customerType: $('#filterCustomerType :selected').val(),
            state: $('#filterState :selected').val(),
            city: $('#filterCity :selected').val(),
        }


        $.ajax({
            type: "POST",
            url: API_URL + '/report/pointSummary',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                showPageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    JSONToCSVConvertor(response.data, 'Point Summary', true);
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




})(jQuery);