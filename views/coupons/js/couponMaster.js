(function($) {
    'use strict';
    
    initPlant('#plant', 'All');
    //initRootCategory('#mainCategory', 'Select');

    $('#mainCategory').change(function() {
        var catId = $(this).find(':selected').val();
        initSubCategory('#subCategory', 'All', catId);
    });

    hidePageLoader();
    
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
    
        
// get Main category which assigned to plant
$('#plant').change(function() {
    var plantId = $(this).find(':selected').val();
    var dataString = {
            plantId:plantId
        }
    
         // load the main cat dropdown
        var selectMainCatBox = $('#mainCategory');
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
    

    function initFormData(dataArray) {
        var formDataWrap = $('#formDataWrap');
        var formDataRows = $('#formDataRows');
        var r = '';
        var s = 0;
        var categoryName='';
        var productName='';
        var valdInpt

        
        // var status = '';
        // var popular = '';

        $.each(dataArray, function(i, object) {
            
            // status = (object.isActive==1) ? statusLable('Active', 'success')+'</a>' : statusLable('In-Active', 'red');
            // r += '<div class="tr align-items-center">';
            // r += '<div class="td inlineText">' + object.categoryName + '</div>';
            // r += '<div class="td inlineText">' + object.mainCategoryName + '</div>';
            // r += '<div class="td action">';
            // r += '<a href="javascript:;" class="editListItem" data-id="' + object.id + '" data-id="' + object.parentId + '" data-name="' + object.categoryName + '" data-text="' + object.description + '"><i class="mdi mdi-pencil"></i></a>';
            // r += '<a href="javascript:;" class="deleteListItem" data-id="' + object.id + '"><i class="mdi mdi-delete"></i></a>';
            // r += '</div>';
            // r += '</div>';
            //s++;

            r += '<div class="rowSet">';
              s = 1;
              $.each(object.data, function(i, d) {
                  r += '<div class="flexRow item-row" data-id="'+d.id+'" data-category="'+object.categoryId+'" data-product="'+object.productId+'">';
                    if(s==1){
                        categoryName=object.categoryName;
                        productName= '('+object.productSeries+') '+object.productName;
                        valdInpt='<input type="text" class="form-control int validity" name="" value="'+d.validity+'" placeholder="Days">';
                    } else {
                        categoryName='';
                        productName='';
                        valdInpt='<input type="hidden" class="form-control int validity" name="" value="0">';
                    }

                    r += '<div class="fx-col-auto txt">'+categoryName+'</div>';
                    r += '<div class="fx-col-auto txt">'+productName+'</div>';
                    r += '<div class="fx-col-100">'+valdInpt+'</div>';
                    r += '<div class="fx-col-100"><input type="text" class="form-control cal decimal faceValue" name="" value="'+d.faceValue+'" placeholder="Face Value"></div>';
                    // r += '<div class="fx-col-100"><input type="text" class="form-control cal decimal allHandCharge" name="" value="'+d.allHandCharge+'" placeholder="0.00"></div>';
                    // r += '<div class="fx-col-100"><input type="text" class="form-control cal decimal salesHandCharge" name="" value="'+d.salesHandCharge+'" placeholder="0.00"></div>';
                    // r += '<div class="fx-col-100"><input type="text" class="form-control cal decimal retailHandCharge" name="" value="'+d.retailHandCharge+'" placeholder="0.00"></div>';
                    // r += '<div class="fx-col-100"><input type="text" class="form-control decimal totalValue" name="" value="'+d.totalValue+'" placeholder="Total Value" readonly=""></div>';
                    
                  r += '</div>';
                  s++;
              });

            r += '</div>';

        });

        formDataRows.html(r);
        formDataWrap.show();
    }

    function noResult() {
        var dataResult = $('#dataTableResult');
        var r = '<div class="tr noResult">';
        r += '<div class="td">No Result Found</div>';
        r += '</div>';
        dataResult.html(r);
    }


    $('#searchForm').submit(function(){

        var form = $(this);
        var plantId = $('#plant :selected').val();
        var catId = $('#mainCategory :selected').val();
        var subCatId = $('#subCategory :selected').val();

        if(validateForm(form)){
            showPageLoader();
            $.ajax({  
                type: "POST",  
                url: API_URL+'/getCouponData',      
                data: JSON.stringify({plantId:plantId, catId:catId, subCatId:subCatId}),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response){
                    hidePageLoader();
                    if(response.success==1){
                        initFormData(response.data);
                    } else {

                    }
                }, 
                error: function(error, xhr){
                    hidePageLoader();
                    console.log(xhr);
                }
            });
        }

        return false;
    });

    //item-row
    $('#submitFormData').click(function(){

        var dataSet = [];
        $('.item-row').each(function(){
            var elm = $(this);
            dataSet.push({
                id:elm.data('id'),
                productId:elm.data('product'),
                categoryId:elm.data('category'),
                faceValue:elm.find('.faceValue').val(),
                allHandCharge:elm.find('.allHandCharge').val(),
                salesHandCharge:elm.find('.salesHandCharge').val(),
                retailHandCharge:elm.find('.retailHandCharge').val(),
                totalValue:elm.find('.totalValue').val(),
                validity:elm.find('.validity').val(),
                plant_id:$('#plant :selected').val()
            });
        });

        var dataString = {
            data:dataSet
        }

        showPageLoader();
        $.ajax({  
            type: "POST",  
            url: API_URL+'/coupon/add',      
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){
                hidePageLoader();
                if(response.success==1){
                    initFormData(response.data);
                } else {

                }
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });



    });

    $('body').on('keyup', '.cal', function(){
        var row = $(this).closest('.item-row');
        var totalValue = row.find('.totalValue');
        var total=0;
        var v = 0;
        row.find('.cal').each(function(){
            v = parseFloat( $(this).val() );
            total=total+v;
        });
        totalValue.val(total);
    });




})(jQuery);