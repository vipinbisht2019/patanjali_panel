(function($) {
    'use strict';

    hidePageLoader();

    if ($('#datatable').length > 0) {
        //initDataList();
        initPlant('#plant', 'All');
    //    initRootCategory('#filterCategory', 'All');
        initState('#filterState', 'All');
        
    }

    $('#filterCategory').change(function() {
        var catId = $(this).find(':selected').val();
        initSubCategory('#filterSubCategory', 'All', catId);
    });

    $('#filterSubCategory').change(function() {
        var catId = $(this).find(':selected').val();
        var selectBox = $('#filterProduct');
        var option = '<option value="">All</option>';

        if(catId > 0){
            var dataString = {
                id:catId
            }

            $.ajax({  
                type: "POST",  
                url: API_URL+'/list/categoryProduct',      
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response){
                  if(response.success==1){
                    $.each(response.data, function(i, object){
                    option+='<option value="'+object.id+'" data-series="'+object.productSeries+'" data-mrp="'+object.productMrp+'">('+object.productSeries+') '+ object.productName+'</option>';
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
        
        var selectDivisionBoxCategory = $('#filterCategory');          // 24_feb_2023        
        var divisionOptionCategory = '<option value="">Select</option>';        // 24_feb_2023
        
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
        
        
        $.ajax({  
            type: "POST",  
            url: API_URL+'/plant/getPlantsMainCategory',      
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(dataString),
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.success==1){
                    $.each(response.data, function(i, object){
                        divisionOptionCategory +='<option value="'+object.id+'">' +object.category_name+'</option>';
                    });
                  }
                  selectDivisionBoxCategory.html(divisionOptionCategory);
                  
                  hidePageLoader();
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });

        
 
    });
    
    
    function initData(dataArray) {
        var dataResult = $('.jsgrid-table tbody');
        var r = '';

        $.each(dataArray, function(i, object) {
            r += '<tr class="jsgrid-row">';
            
            if(object.productSeries)
                r += '<td colspan=2 class="jsgrid-cell">('+object.productSeries+') ' + object.title + ' </td>';
            else
                r += '<td colspan=2 class="jsgrid-cell">'+object.title+'</td>';

            r += '<td class="jsgrid-cell">' + object.issued.num + '</td>';
            r += '<td class="jsgrid-cell">' + object.issued.point + '</td>';

            r += '<td class="jsgrid-cell">' + object.activated.num + '</td>';
            r += '<td class="jsgrid-cell">' + object.activated.point + '</td>';

            r += '<td class="jsgrid-cell">' + object.scanned.today.num + '</td>';
            r += '<td class="jsgrid-cell">' + object.scanned.today.point + '</td>';
            r += '<td class="jsgrid-cell">' + object.scanned.yesterday.num + '</td>';
            r += '<td class="jsgrid-cell">' + object.scanned.yesterday.point + '</td>';
            r += '<td class="jsgrid-cell">' + object.scanned.currentMonth.num + '</td>';
            r += '<td class="jsgrid-cell">' + object.scanned.currentMonth.point + '</td>';
            r += '<td class="jsgrid-cell">' + object.scanned.currentYear.num + '</td>';
            r += '<td class="jsgrid-cell">' + object.scanned.currentYear.point + '</td>';

            
            r += '<td class="jsgrid-cell">' + object.unScanned.previousYear.num + '</td>';
            r += '<td class="jsgrid-cell">' + object.unScanned.previousYear.point + '</td>';
            r += '<td class="jsgrid-cell">' + object.unScanned.currentYear.num + '</td>';
            r += '<td class="jsgrid-cell">' + object.unScanned.currentYear.point + '</td>';
            r += '<td class="jsgrid-cell">' + object.unScanned.total.num + '</td>';
            r += '<td class="jsgrid-cell">' + object.unScanned.total.point + '</td>';

         //   r += '<td class="jsgrid-cell">' + object.encashment.num + '</td>';
        //    r += '<td class="jsgrid-cell">' + object.encashment.point + '</td>';
            r += '</tr>';
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
            categoryId: $('#filterCategory :selected').val(),
            subCategoryId: $('#filterSubCategory :selected').val(),
            productId: $('#filterProduct :selected').val(),
            state: $('#filterState :selected').val(),
            city: $('#filterCity :selected').val(),
            limit: $('#datatable').data('limit'),
            page: $('#datatable').data('page')
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/report/marketInventorySummary',
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
                //console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
                hidePageLoader();
            }
        });
    });

    $('#getDownload').click(function(){

        $('#datatable').data('page', 1);

        var dataString = {
            year: $('#filterYear :selected').val(),
            categoryId: $('#filterCategory :selected').val(),
            subCategoryId: $('#filterSubCategory :selected').val(),
            productId: $('#filterProduct :selected').val(),
            state: $('#filterState :selected').val(),
            city: $('#filterCity :selected').val(),
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/report/marketInventorySummaryDownload',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                showPageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    var $a = $("<a>");
                    $a.attr("href",response.file);
                    $("body").append($a);
                    $a.attr("download","file.xls");
                    $a[0].click();
                    $a.remove();
                } else {
                    noResult();
                }
            },
            complete: function(response) {
                hidePageLoader();
            },
            error: function(xhr, status, error) {
                //console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
                hidePageLoader();
            }
        });
    });


})(jQuery);