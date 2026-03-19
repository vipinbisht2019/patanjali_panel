(function($) {
    'use strict';

    initCategory();
    initStateDate('#userState', 'Select');

    $('#userState').change(function(){
        var stateCode = $('#userState :selected').val();
        initCitiesDate('#userCity', 'Select', stateCode);
    });


    function initCategory(){
        $.ajax({  
            type: "POST",  
            url: API_URL+'/list/category',      
            data: JSON.stringify({}),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){
                hidePageLoader();
                if(response.success==1){
                    initCategoryData(response.data);
                } else {

                }
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
    }


    //hidePageLoader();

    function initCategoryData(dataArray) {
        var r = '';
        var s = 0;


        // var status = '';
        // var popular = '';

        $.each(dataArray, function(i, object) {

                 r += '<div class="tr fx-tr" style="padding-top: 10px; padding-bottom: 10px; border-bottom: #e7e7e7 solid 1px;">';
                 r += '<div class="td" style="padding-left: 10px;">' + object.categoryName + '</div>';
                // r += '<div class="td inlineText">' + object.mainCategoryName + '</div>';
                 r += '<div class="td action" style="padding-right: 10px;">';
                 r +='<label class="switch" for="cat__'+object.id+'"><input type="checkbox" id="cat__'+object.id+'" data-id="'+object.id+'" class="toggleStatus" data-id="" value=""><div></div><span></span></label>';
                 r += '</div>';
                 r += '</div>';

        });

        $('#formDataRows').html(r);
        //formDataWrap.show();
    }

    function noResult() {
        var dataResult = $('#dataTableResult');
        var r = '<div class="tr noResult">';
        r += '<div class="td">No Result Found</div>';
        r += '</div>';
        dataResult.html(r);
    }


    $('#searchUser').click(function(){

        var form = $(this);
        var mobile = $('#userMobile').val();
 
        $('#userName').val("");
        $('#userType').val("");
        $("#userState").val("");
        $("#userState").val("");
        $('#userCity').val("");
        $('#dealer_code').val("");
        
        if(mobile===""){
            alert("Please enter the mobile number !!");
            $('#userMobile').focus();
            return false;
        }

            showPageLoader();
            $.ajax({  
                type: "POST",  
                url: API_URL+'/getUserLoyaltyInfo',      
                data: JSON.stringify({mobile:mobile, type:1}),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response){
                    hidePageLoader();
                    if(response.success==1){
                        
                        if(response.data.userType==2)
                             $(".dealercode").show();
                        
                        $('#userId').val(response.data.id);
                        $('#userName').val(response.data.name);
                        $('#userType').val(response.data.userType);
                        $('#userMobile').val(response.data.mobile);
                        $('#dealer_code').val(response.data.dealerCode);
                        $("#userState option").attr('selected', false);
                        $("#userState option").filter(function() {
                            return this.text == response.data.state; 
                        }).attr('selected', true);
                        $('#userCity').html('<option value="'+response.data.city+'">'+response.data.city+'</otion>');
                        
                    } else {
                        $('#userId').val(0);
                         
                        showResponseErrorMsg(response.message);
                    }

                    if(response.cat.length > 0){
                        var catId = 0;
                        $('.toggleStatus').each(function(){
                            catId = $(this).data('id');
                            console.log(catId);
                            if(inArray(catId, response.cat)==true){
                                $('#cat__'+catId).prop('checked',true);
                            } else {
                               $('#cat__'+catId).prop('checked',false); 
                            }
                        });
                    } else {
                        $('.toggleStatus').prop('checked',false); 
                    }

                }, 
                error: function(error, xhr){
                    hidePageLoader();
                    console.log(xhr);
                }
            });


        return false;
    });

    //item-row
    $('#submitFormData').click(function(){

        var dataSet = [];
        $('.toggleStatus').each(function(){
            var elm = $(this);

            if($(this).is(':checked')){
                dataSet.push({
                    id: elm.data('id')
                });
            }

        });
        
        
         if($('#userMobile').val()===""){
            alert("Please enter the mobile number !!");
            $('#userMobile').focus();
            return false;
        }
        

        var dataString = {
            userId: $('#userId').val(),
            userType: $('#userType :selected').val(),
            name: $('#userName').val(),
            mobile: $('#userMobile').val(),
            dealerCode: $('#dealer_code').val(),
            state: $('#userState :selected').text(),
            city: $('#userCity :selected').text(),
            data:dataSet
        }

        showPageLoader();
        $.ajax({  
            type: "POST",  
            url: API_URL+'/loyaltyAuthorisation',      
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){
                hidePageLoader();
                if(response.success==1){
                    showResponseSuccessMsg(response.message);
                } else {
                    showResponseErrorMsg(response.message);
                }
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
    });

    function initStateDate(selectBox, defaultLabel){
        var selectBox = $(selectBox);
        var option = '<option value="">'+defaultLabel+'</option>';

            $.ajax({  
                type: "POST",  
                url: API_URL+'/list/state',      
                data: '',
                dataType: "json",
                cache: false,
                success: function(response){
                  if(response.success==1){
                    $.each(response.data, function(i, object){
                      option+='<option value="'+object.stateCode+'">'+object.stateName+'</option>';
                    });
                  }
                  selectBox.html(option);
                }, error: function(error, xhr){
                   //alert(xhr);
                }
            });
    }

    function initCitiesDate(selectBox, defaultLabel, stateCode){
        var selectBox = $(selectBox);
        var option = '<option value="">'+defaultLabel+'</option>';

        if(stateCode > 0){
            var dataString = {
                stateCode:stateCode
            }

            $.ajax({  
                type: "POST",  
                url: API_URL+'/list/cities',      
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response){
                  if(response.success==1){
                    $.each(response.data, function(i, object){
                      option+='<option value="'+object.id+'">'+object.cityName+'</option>';
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
    }

    function inArray(needle, haystack) {
        var length = haystack.length;
        for(var i = 0; i < length; i++) {
            if(haystack[i] == needle) return true;
        }
        return false;
    }
    
    
    $(".dealercode").hide();
    
    $('#userType').on('change', function() {

        var userType =  this.value ;
        if(userType==2)
            $(".dealercode").show();
        else
            $(".dealercode").hide();
    });
    
    

})(jQuery);