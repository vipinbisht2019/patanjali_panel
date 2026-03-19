$(document).ready(function () {
  'use strict';
  var session = initializeSession();
  initSettingData();

  function initSettingData(){
        showPageLoader();
        $.ajax({  
            type: "POST",  
            url: API_URL+'/setting/options',       
            data: JSON.stringify({}),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){  
                hidePageLoader();
                if(response.success==1) {
                    $('#adminNumber').val(response.data.ADMIN_SCAN_NUMBER);
                    $('#pointReceiver').val(response.data.ADMIN_POINT_RECEIVER);
                } else {
                    //alert(response.message);
                }
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log('error', error);
                console.log('xhr', xhr);
            }
        });
        
        
        
          $.ajax({  
            type: "POST",  
            url: API_URL+'/setting/options_all',       
            data: JSON.stringify({}),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){ 
               
                hidePageLoader();
             //   if(response.success==1) {
                    
                // $('#adminNumber_all').html(response.data);
                // alert(response.data);

                 const split_strings = response.data.split(",");

                 var adminOptions = '';

                if(response.success==1){

                    $.each( split_strings, function( index, value ){                  
                        adminOptions +='<button style="margin:10px 10px 0px 0px " type="button" class="btn btn-warning deleteListItemAdmin" data-id="'+value+'">' + value +'</button>';
                        
                    });
                  
                    $('#adminNumber_all').html(adminOptions);               
                                          
                
                 // $('#adminNumber_all').html(response.data);

                } else {
                    //alert(response.message);
                }
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log('error', error);
                console.log('xhr', xhr);
            }
        });

        
        
  }
  
  
   $('body').on('click', '.deleteListItemAdmin', function() {

    var resultDel =  confirm("Do you want to delete the number!");
    if (resultDel == true) {
       
    var meta_value = $(this).data('id');
//    alert(meta_value);

    $.ajax({
            type: "POST",
            url: API_URL+'/setting/options_all_delete',
            data: JSON.stringify({
              meta_value: meta_value
            }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response) {
                location.reload();  
                if (response.success == 1) {
                    initDataList();
                } else {
                    showResponseErrorMsg(response.message);
                }
                //hidePageLoader();
               
            },
            error: function(error, xhr) {
                console.log('error', error);
                console.log('xhr', xhr);
                showResponseErrorMsg("Unable to proccess this request.");
             //   hidePageLoader();
                
            }
        });

    } else {
        return false;
    }

});  


    //formSubmit
    $('body').on('click','.formSubmit',function(){
        var form = $($(this).data('form'));
        form.submit();    
    });


    $('.settingMetaForm').submit(function(){

        var form = $(this);

        var isError=false;
        var errorMsg=null;
        var dataString = {
            key: form.find('input').data('key'),
            value: form.find('input').val()
        }

        showPageLoader();
        $.ajax({  
            type: "POST",  
            url: API_URL+'/setting/updateMeta',        
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){  
                hidePageLoader();
                location.reload();
                if(response.success==1) {
                    showResponseSuccessMsg(response.message);
                } else {
                    alert(response.message);
                }
            }, 
            error: function(error, xhr){
                console.log('error', error);
                console.log('xhr', xhr);
                hidePageLoader();
            }
        });

        return false;
    });



    function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    } 
});
