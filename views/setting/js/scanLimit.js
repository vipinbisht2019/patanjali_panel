$(document).ready(function () {
  'use strict';
  var session = initializeSession();
  initSettingData();

  function initSettingData(){
        showPageLoader();
        $.ajax({  
            type: "POST",  
            url: API_URL+'/setting/option/scanLimit',       
            data: JSON.stringify({}),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){  
                hidePageLoader();
                if(response.success==1) {
                    $('#scanLimit').val(response.data.DAILY_SCAN_LIMIT);
                    $('#MiniPointTxLimit').val(response.data.MINIMUM_POINT_TX_LIMIT);
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
            key: form.find('input').data('key'),
            value: form.find('input').val(),
            keyPoint: $('#MiniPointTxLimit').data('key-point'),
            MiniPointTxLimitValue: $('#MiniPointTxLimit').val()
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
