(function($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initDataList();
    }

    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        var catNames = "All";
 
        $.each(dataArray, function(i, object) {
            
            if(object.assignedCatIds)
                 catNames = getAssignedMainCatName(object.assignedCatIds,object.plant_id);
                
            r += '<div class="tr align-items-center">';
            r += '<div class="td inlineText">' + object.plant_name + '</div>';
            r += '<div class="td inlineText">' + object.plant_code + '</div>';
            r += '<div class="td inlineText">' + object.cityname + '</div>';
            r += '<div class="td inlineText">' + object.statename + '</div>';
            r += '<div class="td inlineText">' + object.countryname + '</div>';
            r += '<div class="td inlineText" id="cat_'+ object.plant_id + '">' + catNames + '</div>';
            r += '<div class="td action">';
            r += '<a href="javascript:;" class="editListItem" data-id="' + object.plant_id + '" data-plantname="' + object.plant_name + '" data-plantcode="' + object.plant_code + '"  data-cityname="' + object.city_id + '" data-statename="' + object.state_id+ '" data-countryname="' + object.country_id+ '" data-catnames="' + object.assignedCatIds  + '" data-isagmark="' + object.is_ag_mark+'"><i class="mdi mdi-pencil"></i></a>';
            r += '<a href="javascript:;" class="deleteListItem" data-id="' + object.plant_id + '"><i class="mdi mdi-delete"></i></a>';
            r += '</div>';
            r += '</div>';
        });
        dataResult.html(r);
    }
    
    
function getAssignedMainCatName(catIds,plantIdContainer) {

    var dataString = {catIds: catIds}
    var containerId = "";
     $.ajax({
            type: "POST",
            url: API_URL + '/plant/getAssignedCategory',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(catresponse) {
                if (catresponse.success == 1) {
                    containerId = "cat_"+plantIdContainer;
                    $("#"+containerId).html(catresponse.data.categoryName);
                } 
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });
       
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
            url: API_URL + '/plant/plantlist',
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
            url: API_URL + '/plant/delete',
            data: JSON.stringify({
                plant_id: id
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
            filterPlantName: $('#filterPlantName').val(),
            filterPlantCode: $('#filterPlantCode').val(),
        }
  
     $.ajax({
            type: "POST",
            url: API_URL + '/plant/plantlist',
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
        modalBox.find('.modal-header h3').text('Add New Plant');
        modalBox.addClass('show');
        var selected = "";

        initRootCategory('#mainCategory', 'Select');
        initSubCategory('#subCategory', 'Select', 'ALL');
        
         // load the plants dropdown
        var selectCountryBox = $('#inptPlantCountry');
        var countryOption = '<option value="">Select</option>';
        
            $.ajax({  
            type: "GET",  
            url: API_URL+'/plant/getCountryList',      
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.success==1){
                    $.each(response.data, function(i, object){
                     
                      countryOption +='<option '+ selected +' value="'+object.id+'">' +object.name+'</option>';
                    });
                  }
                  selectCountryBox.html(countryOption);
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
 
        $('.loaderWrap').hide();
        
        
    });
    
    
    
 $('#inptPlantCountry').change(function() {
  
    var countryId = $(this).find(':selected').val();
    
    var dataString = {
            countryId:countryId
        }
    
     showPageLoader();
     
         // load the plants dropdown
        var selectStateBox = $('#inptPlantState');
        var stateOption = '<option value="">Select</option>';
        
            $.ajax({  
            type: "POST",  
            url: API_URL+'/plant/getStateList',      
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(dataString),
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.success==1){
                    $.each(response.data, function(i, object){
                      stateOption +='<option value="'+object.id+'">' +object.name+'</option>';
                    });
                  }
                  selectStateBox.html(stateOption);
                  
                  hidePageLoader();
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
 
    });
    
 
 $('#inptPlantState').change(function() {
  
    var stateId = $(this).find(':selected').val();
    
    var dataString = {
            stateId:stateId
        }
    
         // load the plants dropdown
        var selectCityBox = $('#inptPlantCity');
        var cityOption = '<option value="">Select</option>';
        
        showPageLoader();
        
            $.ajax({  
            type: "POST",  
            url: API_URL+'/plant/getCityList',      
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(dataString),
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.success==1){
                    $.each(response.data, function(i, object){
                      cityOption +='<option value="'+object.id+'">' +object.name+'</option>';
                    });
                  }
                  selectCityBox.html(cityOption);
                  
                  hidePageLoader();
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
 
    });
    
    
$('#editForm').submit(function() {
        var form = $(this);
        if (validateForm(form)) {

            var dataString = {
 
                inptPlantName: $('#inptPlantName').val(),
                inptPlantCode: $('#inptPlantCode').val(),
                inptPlantCountry: $('#inptPlantCountry').val(),
                inptPlantState: $('#inptPlantState').val(),
                inptPlantCity: $('#inptPlantCity').val(),
                mainCategory: $('#mainCategory').val(),
                inptIsAgMark: $('#inptIsAgMark').val()        // 16_02_2023
                
            }

            var modalBox = $('#addEditModal');
            showPageLoader();

            $.ajax({
                type: "POST",
                url:  API_URL + '/plant/addPlant',
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success == 1) {
                        modalBox.find('.close').click();
                        initDataList();
                        showResponseSuccessMsg("Plant successfully added.");
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


// start edit plant



    $('body').on('click', '.editListItem', function() {
        var id = $(this).data('id');
        var plantname = $(this).data('plantname');
        var plantcode = $(this).data('plantcode');
        var cityname = $(this).data('cityname');
        var statename = $(this).data('statename');
        var countryname = $(this).data('countryname');
        var catnames = $(this).data('catnames');
        var isagmark = $(this).data('isagmark');                // 16_02_2023

        
// alert(cityname+' ' +statename+' ' +countryname+' '+catnames);

        $('#editIds').val(id);
        $('#plantname').val(plantname);
        $('#plantcode').val(plantcode);
        $('#cityname').val(cityname);
        $('#statename').val(statename);
        $('#countryname').val(countryname);
        $('#catnames').val(catnames);
         $('#isagmark').val(isagmark);                           // 16_02_2023

        bodyFix();
        var modalBox2 = $('#addEditModal2');
        modalBox2.addClass('show');
        
        
        modalBox2.find('.modal-header h3').text('Add New Plant');
        modalBox2.addClass('show');
        var selected = "";

    //    initRootCategoryedit('#mainCategoryedit', 'Select');
    //    initSubCategory('#subCategory', 'Select', 'ALL');
    
    
    
    // Start assigned category to plant 
    
            var split_string = JSON.parse("[" + catnames + "]");
             
            // split_string = str1.split(",");
            // console.log(split_string.length);
            
            console.log(split_string);



       var selectBox = $('#mainCategoryedit');
    var option = '<option value="">Select</option>';

        $.ajax({  
            type: "POST",  
            url: API_URL+'/list/category',      
            data: '',
            dataType: "json",
            cache: false,
            success: function(response){
              if(response.success==1){
                  var j=0;
                $.each(response.data, function(i, object){
                    
                $.each(split_string, function(keys, object_data){  
                
                    if(object.id == object_data)
                     {
                        option+='<option value="'+object.id+'" selected>'+object.categoryName+'</option>';
                        j=1;
                         
                     }  
                     else 
                     {
                      //  countryOptionedit +='<option value="'+object.id+'" >' +object.categoryName+'</option>';
                     }
                     
                });
                
                if(j!=1)
                {
                option+='<option value="'+object.id+'">'+object.categoryName+'</option>';
                }
                j=0;
                
                  
                });
              }
              selectBox.html(option);
            }, error: function(error, xhr){
               //alert(xhr);
            }
        });
    
    
    
    // End assigned category to plant 
    
    
    
    
    
    
        
         // load the plants dropdown
           // load the plants dropdown
        var selectCountryBoxedit = $('#countryname');
        var countryOptionedit = '<option value="">Select</option>';
        
       $.ajax({  
            type: "GET",  
            url: API_URL+'/plant/getCountryList',      
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){
              
                if(response.success==1){
                    $.each(response.data, function(i, object){
                     
                     if(object.id == countryname)
                     {
                        countryOptionedit +='<option value="'+object.id+'" selected>' +object.name+'</option>';
                         
                     }  else 
                     {
                        countryOptionedit +='<option value="'+object.id+'" >' +object.name+'</option>';
                    
                     }
                      
                    });
                  }
                  selectCountryBoxedit.html(countryOptionedit);
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
        
        
        
        
    // state edit filter data
        
            
    var countryId = countryname;
    
    var dataString = {
            countryId:countryId
        }
    
     showPageLoader();
     
         // load the plants dropdown
        var selectStateBox = $('#statename');
        var stateOption = '<option value="">Select</option>';
        
            $.ajax({  
            type: "POST",  
            url: API_URL+'/plant/getStateList',      
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(dataString),
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.success==1){
                    $.each(response.data, function(i, object){
                        
                    if(object.id == statename)
                     {
                        stateOption +='<option value="'+object.id+'" selected>' +object.name+'</option>';
                         
                     }  else 
                     {
                      stateOption +='<option value="'+object.id+'">' +object.name+'</option>';
                    
                     }
                      
                      
                    });
                  }
                  selectStateBox.html(stateOption);
                  
                  hidePageLoader();
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
        
        
        
    // city edit filter data
        
        
        
       var stateId = statename;
    
       var dataString = {
            stateId:stateId
        }
    
         // load the plants dropdown
        var selectCityBox = $('#cityname');
        var cityOption = '<option value="">Select</option>';
        
        showPageLoader();
        
            $.ajax({  
            type: "POST",  
            url: API_URL+'/plant/getCityList',      
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(dataString),
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.success==1){
                    $.each(response.data, function(i, object){
                        
                    if(object.id == cityname)
                     {
                        cityOption +='<option value="'+object.id+'" selected>' +object.name+'</option>';
                         
                     }  else 
                     {
                       cityOption +='<option value="'+object.id+'">' +object.name+'</option>';
                    
                     }
                      
                    });
                  }
                  selectCityBox.html(cityOption);
                  
                  hidePageLoader();
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
        
        
    
        
    });
    
    
        
 $('#countryname').change(function() {
  
    var countryId = $(this).find(':selected').val();
    
    var dataString = {
            countryId:countryId
        }
    
     showPageLoader();
     
         // load the plants dropdown
        var selectStateBox = $('#statename');
        var stateOption = '<option value="">Select</option>';
        
            $.ajax({  
            type: "POST",  
            url: API_URL+'/plant/getStateList',      
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(dataString),
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.success==1){
                    $.each(response.data, function(i, object){
                      stateOption +='<option value="'+object.id+'">' +object.name+'</option>';
                    });
                  }
                  selectStateBox.html(stateOption);
                  
                  hidePageLoader();
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
 
    });
    
    
    
     
 $('#statename').change(function() {
  
    var stateId = $(this).find(':selected').val();
    
    var dataString = {
            stateId:stateId
        }
    
         // load the plants dropdown
        var selectCityBox = $('#cityname');
        var cityOption = '<option value="">Select</option>';
        
        showPageLoader();
        
            $.ajax({  
            type: "POST",  
            url: API_URL+'/plant/getCityList',      
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(dataString),
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.success==1){
                    $.each(response.data, function(i, object){
                      cityOption +='<option value="'+object.id+'">' +object.name+'</option>';
                    });
                  }
                  selectCityBox.html(cityOption);
                  
                  hidePageLoader();
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
 
    });
    
    
    
    
    // Start edited confirm form data
    
    $('#editFormconfirm').submit(function() {
     //   alert('helo edit');
        var form = $(this);
        if (validateForm(form)) {

            var dataString = {
                 id: $('#editIds').val(),
                inptPlantName: $('#plantname').val(),
                inptPlantCode: $('#plantcode').val(),
                inptPlantCountry: $('#countryname').val(),
                inptPlantState: $('#statename').val(),
                inptPlantCity: $('#cityname').val(),
                mainCategory: $('#mainCategoryedit').val(),
                isagmark: $('#isagmark').val()        // 16_02_2023
                
            }

            var modalBox = $('#addEditModal2');
            showPageLoader();

            $.ajax({
                type: "POST",
                url:  API_URL + '/plant/editPlant',
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success == 1) {
                        modalBox.find('.close').click();
                        initDataList();
                        showResponseSuccessMsg("Plant successfully edit.");
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
    
    
    // End dited confirm form data
    
    


})(jQuery);