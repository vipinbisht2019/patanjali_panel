(function($) {
    'use strict';

    hidePageLoader();

    if ($('#datatable').length > 0) {
        
        initPlant('#plant', 'All');
        //initRootCategory('#filterCategory', 'All');
        initState('#filterState', 'All');
        initGroupId('#groupId', 'All');
        // initGroup('#group', 'All');
    }
    
    
        
        // get Main category which assigned to plant
$('#plant').change(function() {
    var plantId = $(this).find(':selected').val();
    var dataString = {
            plantId:plantId
        }
    
         // load the main cat dropdown
        var selectMainCatBox = $('#filterCategory');
        var mainCatOption = '<option value="">Select</option>';
        
        showPageLoader();
        
            $.ajax({  
            type: "POST",  
            url: API_URL+'/plant/getPlantsMainCategory',      
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(dataString),
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.success==1){
                    console.log(response.data);
                    $.each(response.data, function(i, object){
                      mainCatOption +='<option value="'+object.id+'">' +object.category_name+'</option>';
                    });
                  }
                  selectMainCatBox.html(mainCatOption);
                  
                  hidePageLoader();
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
 
    });
    

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
            r += '<div class="td inlineText">' + object.dealerCode + '</div>';
            r += '<div class="td inlineText">' + object.name + '</div>';
            r += '<div class="td inlineText">' + object.mobile + '</div>';
            r += '<div class="td inlineText">' + object.type + '</div>';
            r += '<div class="td inlineText">' + object.beat + '</div>';
            $.each(object.meta, function(i, meta) {
                r += '<div class="td">';
              
             /*   if(i%2 == 0)	
                {	
                    var greys= "lightgrey";	
                    	
                } else {	
                    var greys= "";	
                }	
                */
                var greys= "";	
                r += '<span style="background:'+greys+'">'+meta.num +'</span><span style="background:'+greys+'">'+meta.point +'</span>';
              
                r += '</div>';
            });

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
            companyId: $('#group :selected').val(),         
            customerType: $('#filterCustomerType :selected').val(),
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
            url: API_URL + '/report/scanTrendCustomer',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {

                    if(response.data.length > 8)
                    {
                        $("#datatable").addClass("scrollLength");
                    }

                    initData(response.data);
                } else {
					 $("#datatable").removeClass("scrollLength");
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
            plantId: $('#plant :selected').val(),                               // 11_april_2023	
            divisionId: $('#divisionunit :selected').val(),                     // 11_april_2023	
            companyId: $('#group :selected').val(),                             // 11_april_2023
            customerType: $('#filterCustomerType :selected').val(),
            categoryId: $('#filterCategory :selected').val(),
            subCategoryId: $('#filterSubCategory :selected').val(),
            productId: $('#filterProduct :selected').val(),
            state: $('#filterState :selected').val(),
            city: $('#filterCity :selected').val(),
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/report/scanTrendCustomerDownload',
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
                hidePageLoader();
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });
    });
    
    /*
    function initGroup(selectBox, defaultLabel){
        var selectBox = $(selectBox);
        var option = '<option value="">'+defaultLabel+'</option>';
        $.ajax({  
            type: "GET",  
            url: API_URL+'/ajaxGroupList',      
            data: '',
            dataType: "json",
            cache: false,
            success: function(response){
              if(response.success==1){
                $.each(response.data, function(i, object){
                  option+='<option value="'+object.id+'">'+object.name+'</option>';
                });
              }
              selectBox.html(option);
            }, error: function(error, xhr){
               alert(xhr);
            }
        });
    }
    */
    
// start 12_may_2023    
    
    
     function initGroupId(selectBox, defaultLabel){
        var selectBox = $(selectBox);
        var option = '<option value="">'+defaultLabel+'</option>';
        $.ajax({  
            type: "GET",  
            url: API_URL+'/ajaxGetGroupList',      
            data: '',
            dataType: "json",
            cache: false,
            success: function(response){
              if(response.success==1){
                $.each(response.data, function(i, object){
                  option+='<option value="'+object.id+'">'+object.name+'</option>';
                });
              }
              selectBox.html(option);
            }, error: function(error, xhr){
               alert(xhr);
            }
        });
    }
    
    
    $('#groupId').change(function() {
    var groupId = $(this).find(':selected').val();
   
    
         // load the main cat dropdown
        var selectMainCatBox = $('#subGroupId');
        var mainCatOption = '<option value="">All</option>';
        
     //   showPageLoader();
     
     if(groupId !=''){
        
         var dataString = {
            groupId:groupId
        }
        
            $.ajax({  
            type: "POST",  
            url: API_URL+'/ajaxGroupId',      
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(dataString),
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.success==1){
                    console.log(response.data);
                    $.each(response.data, function(i, object){
                      mainCatOption +='<option value="'+object.id+'">' +object.name+'</option>';
                    });
                  }
                  selectMainCatBox.html(mainCatOption);
                  
                 // hidePageLoader();
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
        
        } else {
            selectMainCatBox.html(mainCatOption);
            $('#group').html('<option value="">All</option>');
        } 
 
    });
    
    
    $('#subGroupId').change(function() {
     
    var groupId = $('#groupId').find(':selected').val();
    var subGroupId = $(this).find(':selected').val();
   // alert(groupId);
   // alert(subGroupId);
    var dataString = {
            groupId:groupId,
            subGroupId:subGroupId
        }
    
         // load the main cat dropdown
        var selectMainCatBox = $('#group');
        var mainCatOption = '<option value="">All</option>';
        
       // showPageLoader();
        
        if(groupId !='' && subGroupId !=''){
            
            $.ajax({  
            type: "POST",  
            url: API_URL+'/ajaxSubGroupId',      
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(dataString),
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.success==1){
                    console.log(response.data);
                    $.each(response.data, function(i, object){
                      mainCatOption +='<option value="'+object.id+'">' +object.name+'</option>';
                    });
                  }
                  selectMainCatBox.html(mainCatOption);
                  
                //  hidePageLoader();
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
        
        } else {
            selectMainCatBox.html(mainCatOption);
        }
 
    });
    
// end 12_may_2023  
    
    
    

})(jQuery);