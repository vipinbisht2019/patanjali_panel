$(document).ready(function () {
  'use strict';
  var session = initializeSession();
  initSettingData();

  function initSettingData(){
        showPageLoader();
        $.ajax({  
            type: "POST",  
            url: API_URL+'/setting/option/bonusPercent',       
            data: JSON.stringify({}),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){  
                hidePageLoader();
                if(response.success==1) {
                    $('#bonusPercent').val(response.data.BONUS_PERCENT);
                  
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
            bonuspercent: $('#bonusPercent').val(),
           
        }

        showPageLoader();
        $.ajax({  
            type: "POST",  
            url: API_URL+'/setting/updateBonusPercent',        
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){  
                hidePageLoader();
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
