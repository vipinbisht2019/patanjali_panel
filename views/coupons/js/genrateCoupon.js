(function($) {
    'use strict';
    var session = initializeSession();
    hidePageLoader();
    
    //initRootCategory('#mainCategory', 'Select');
    
    
 // load last Agmark Series number
    $(document).ready(function(){

        //var catId = 1; // Main Parent category ID
        var subcatId = 0; // default subcategory

        //initSubCategory('#subCategory', 'Select', catId);

        //load product drop down
        var selectBox = $('#categoryProduct');
        var option = '<option value="">Select</option>';

        if(subcatId > 0){
            var dataString = {
                id:subcatId
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
                      option+='<option value="'+object.id+'" data-pexpdate="'+object.product_exp_date+'" data-series="'+object.productSeries+'" data-mrp="'+object.productMrp+'">('+object.productSeries+') ' +object.productName+'</option>';
                    });
                  }
                  selectBox.html(option);
                  
         // default values show selected in drop down
    //$("select#mainCategory option[value='1']").attr("selected", "selected");
    //$("select#subCategory option[value='4']").attr("selected", "selected");
          
          
                }, error: function(error, xhr){
                   alert(xhr);
                }
            });

        } else {
            selectBox.html(option);
        }

          
        // end of load 

        $.ajax({  
            type: "POST",  
            url: API_URL+'/lastAgmarkSeries',      
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.success==1){
                    $("#agmarkSeries").val(response.data.agmark_series);
                }
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
        
        
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
        
        
    });
    
    
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
        
        

    $('#mainCategory').change(function() {
        var catId = $(this).find(':selected').val();
        initSubCategory('#subCategory', 'Select', catId);
    });

    $('#subCategory').change(function() {
        var catId = $(this).find(':selected').val();
        var selectBox = $('#categoryProduct');
        var option = '<option value="">Select</option>';

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
                      option+='<option value="'+object.id+'" data-pexpdate="'+object.product_exp_date+'" data-series="'+object.productSeries+'" data-mrp="'+object.productMrp+'">('+object.productSeries+') ' +object.productName+'</option>';
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

    $('#categoryProduct').change(function() {
        
        var plantId = $('#plant :selected').val();
        var productId = $(this).find(':selected').val();
        var productSeries = $(this).find(':selected').data('series');
        var productMrp = $(this).find(':selected').data('mrp');
        
        var productExpDateDays = $(this).find(':selected').data('pexpdate');
        $('#productExpDateTextField').val(productExpDateDays);
       
        var selectBox = $('#batchSize');
        var option = '<option value="">Select</option>';

        if(productId > 0){
            $('#productSeries').val(productSeries);
            $('#productMrp').val(productMrp);
            
            
            

            var dataString = {
                productId:productId,
                plantId:plantId
            }

            $.ajax({  
                type: "POST",  
                url: API_URL+'/list/productBatch',      
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response){
                  if(response.success==1){
                    $.each(response.data, function(i, object){
                      option+='<option value="'+object.id+'">'+object.batchSize+'</option>';
                    });
                  }
                  selectBox.html(option);
                  $('#couponValidity').val(response.validity);
                }, error: function(error, xhr){
                   alert(xhr);
                }
            });

        } else {
            selectBox.html(option);
            $('#productSeries').val('');
            $('#productMrp').val('');
        }
    });

    $('#batchSize').change(function() {
        var batchId = $(this).find(':selected').val();
        var selectBox = $('#batchSize');
        var r='';
        $('#couponValues').html(r);


        if(batchId > 0){

            var dataString = {
                batchId:batchId
            }

            $.ajax({  
                type: "POST",  
                url: API_URL+'/list/productBatchQty',      
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response){
                  if(response.success==1){
                    $.each(response.data, function(i, obj){
                        r+='<div class="flexRow itemRow" data-face-value-id="'+obj.faceValueId+'" data-face-value="'+obj.faceValue+'" data-qty="'+obj.qty+'">';
                          r+='<div class="col-fx-auto cpPrice">'+obj.faceValue+'</div>';
                          r+='<div class="col-fx-auto cpQty">'+obj.qty+'</div>';
                        r+='</div>';
                    });
                    $('#couponValues').html(r);
                  }
                }, error: function(error, xhr){
                   alert(xhr);
                }
            });
        }
    });

    //hidePageLoader();
    //item-row
    $('#submitFormData').click(function(){
        var form = $('#dataForm');
        if(validateForm(form)){
                var couponValues = [];
                $('.itemRow').each(function(){
                    var elm = $(this);
                    couponValues.push({
                        faceValueId:elm.data('face-value-id'),
                        faceValue:elm.data('face-value'),
                        qty:elm.data('qty')
                    });
                });

                var dataString = {
                    userId:session.session,
                    categoryId: $('#mainCategory :selected').val(),
                    subcat_id: $('#subCategory :selected').val(),
                    productId: $('#categoryProduct :selected').val(),
                    batchId: $('#batchSize :selected').val(),
                    batchSize: $('#batchSize :selected').text(),
                    batchNumber: $('#batchNumber').val(), 
                    dateOfMfg: $('#dateOfMfg').val(),
                    couponValidity: $('#couponValidity').val(),
                    couponValues:couponValues,
                    agmarkSeries: $('#agmarkSeries').val(),
                    agmarkNumber: $('#agmarkNumber').val(),
                    expDateProduct: $('#productExpDate').val(),
                    plant: $('#plant').val(),
                    divisionunit: $('#divisionunit').val(),
                    couponType: $('#couponType').val()
                    
                }

                showPageLoader();
                $.ajax({  
                    type: "POST",  
                    url: API_URL+'/genrateCoupons',      
                    data: JSON.stringify(dataString),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    cache: false,
                    success: function(response){
                        
                        if(response.success==1){
                            window.location.href=APP_URL+'/couponOrders';
                        } else {
                            showResponseErrorMsg(response.message);
                        }
                        hidePageLoader();
                    }, 
                    error: function(error, xhr){
                        hidePageLoader();
                        console.log(xhr);
                    }
                });
        }

        return false;
    });

    $('#dateOfMfg').datepicker({format:'dd/mm/yyyy'});
    
    
    $('#dateOfMfg').change(function(){
        
        var selectedDateDMY = $('#dateOfMfg').val();
        var selectedDateYMD = selectedDateDMY.split("/").reverse().join("-");
        var productExpDateDays = $('#productExpDateTextField').val();
    
     
        var date = new Date(selectedDateYMD);
        var newExpdate = new Date(date);

        newExpdate.setDate(newExpdate.getDate() + parseInt(productExpDateDays));
    
        var dd = newExpdate.getDate();
        var mm = newExpdate.getMonth() + 1;
        var y = newExpdate.getFullYear();

        var productExpDate = dd + '/' + mm + '/' + y;
            
        $('#productExpDate').val(productExpDate);
            

    });
    
        
    $('#batchNumber').change(function(){
        
        var dataString = {
                batchNumber: $('#batchNumber').val()
                }

          showPageLoader();
          
                $.ajax({  
                    type: "POST",  
                    url: API_URL+'/checkBatchNumberExist',      
                    data: JSON.stringify(dataString),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    cache: false,
                    success: function(response){
                        
                        hidePageLoader();
                        
                        if(response.success==1){
                    
                           if(confirm("Batch number already Exist !! Do you want to continue ?")){
                                return true;
                            }else{
                                $('#batchNumber').val('');
                                $( "#batchNumber" ).focus();
                                 return false;
                            }
    
                        } else {
                           return true;
                        }
                        
                    }, 
                    error: function(error, xhr){
                        hidePageLoader();
                        console.log(xhr);
                    }
                });
            

    });
    


    $('body').on('click','#activateCoupon',function(){

    });




})(jQuery);