(function($) {
    'use strict';
/*
    if ($('#datatable').length > 0) {
        initDataList();
        hidePageLoader();
    } else {
        hidePageLoader();
    }
    */
    hidePageLoader();
    initRootCategory('.parentCategory', 'Select');
    initGroup('#group', 'All');

    $('#dataForm').submit(function() {
        var form = $(this);
        if (validateForm(form)) {

            var dataSet = [];
            $('.item-row').each(function() {
                var elm = $(this);
                dataSet.push({
                    group: elm.find('.group :selected').val(),
                    subgroup: elm.find('.subgroup :selected').val(),
                    name: elm.find('.name').val(),
                    erpId: elm.find('.erpId').val(),
                    
                });
            });

            var dataString = {
                data: dataSet
            }

            showPageLoader();
            $.ajax({
                type: "POST",
                url: API_URL + '/loyalty/groupCompanyAdd',
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success == 1) {
                        window.location.href = APP_URL + '/authorisation/groupCompanyList';
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

    
    function initGroup(selectBox, defaultLabel){
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

    $('#group').change(function() {
        var groupId = $(this).find(':selected').val();
       
        
             // load the main cat dropdown
            var selectMainCatBox = $('#subgroup');
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


})(jQuery);