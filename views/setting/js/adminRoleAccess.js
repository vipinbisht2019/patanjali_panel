(function($) {
    'use strict';
    hidePageLoader();
    initRoleList();

    function initRoleList() {

        var selectBox = $('#userRole');
        var option = '<option value="0">Select User Role</option>';

        $.ajax({
            type: "POST",
            url: API_URL + '/adminRoles',
            data: '',
            dataType: "json",
            cache: false,
            beforeSend: function() {
                hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    $.each(response.data, function(i, object) {
                        option+='<option value="'+object.roleId+'">'+object.roleName+'</option>';
                    });
                }
                selectBox.html(option);
            },
            complete: function(response) {
                hidePageLoader();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
                selectBox.html(option);
            }
        });
    }

    $('body').on('submit','#userPermissionForm',function(){

        var form = $(this);
        var action = API_URL+'/updateUserPermission';
        var dataString = form.serialize();
        
        $.ajax({  
            type: "POST",  
            url: action,        
            data: dataString,
            dataType: "json",
            cache: false,
            success: function(response){ 
                hidePageLoader(); 
                if(response.success==1) {
                    showResponseSuccessMsg(response.message);
                } else {
                    showResponseErrorMsg(response.message);
                }
                
           }, error: function(error, xhr){
               console.log('error', error);
               console.log('xhr', xhr);
               hidePageLoader();
           }
        });

        return false;
    });

    $('select[name="userRole"]').change(function(){

        $('input[type=checkbox]').prop('checked', false);
        var userRoleId = $('select[name="userRole"] :selected').val();
        if(userRoleId > 0) {
            $.ajax({  
                type: "GET",  
                url: API_URL+'/getUserPermission/'+userRoleId,       
                data: '',
                dataType: "json",
                cache: false,
                success: function(response){  
                    editViewPermissioin(response);
                    //stopLoader();
               }, error: function(error, xhr){
                   console.log('error', error);
                   console.log('xhr', xhr);
                   //stopLoader();
               }
            });
        }
    });

    function editViewPermissioin(permissioin){

        var permissioin = permissioin;

        if(permissioin.coupon){
            $('input[name="up[coupon]"]').prop('checked', true);

            if(permissioin.coupon.master){
                $('input[name="up[coupon][master]"]').prop('checked', true);
            }
            if(permissioin.coupon.batchMaster){
                $('input[name="up[coupon][batchMaster]"]').prop('checked', true);
            }
            if(permissioin.coupon.list){
                $('input[name="up[coupon][list]"]').prop('checked', true);
            }
            if(permissioin.coupon.genrateCoupon){
                $('input[name="up[coupon][genrateCoupon]"]').prop('checked', true);
            }
            if(permissioin.coupon.activateCoupon){
                $('input[name="up[coupon][activateCoupon]"]').prop('checked', true);
            }
            if(permissioin.coupon.printCoupon){
                $('input[name="up[coupon][printCoupon]"]').prop('checked', true);
            }
            if(permissioin.coupon.innerCT){
                $('input[name="up[coupon][innerCT]"]').prop('checked', true);
            }
            if(permissioin.coupon.outerCT){
                $('input[name="up[coupon][outerCT]"]').prop('checked', true);
            }
        }

        if(permissioin.loyalty){
            $('input[name="up[loyalty]"]').prop('checked', true);

            if(permissioin.loyalty.import){
                $('input[name="up[loyalty][import]]"]').prop('checked', true);
            }
            if(permissioin.loyalty.authorisation){
                $('input[name="up[loyalty][authorisation]"]').prop('checked', true);
            }
            if(permissioin.loyalty.deauthorization){
                $('input[name="up[loyalty][deauthorization]"]').prop('checked', true);
            }
            if(permissioin.loyalty.users){
                $('input[name="up[loyalty][users]"]').prop('checked', true);
            }
        }

        if(permissioin.inventory){
            $('input[name="up[inventory]"]').prop('checked', true);

            if(permissioin.product.list){
                $('input[name="up[product][list]"]').prop('checked', true);
            }
            if(permissioin.product.import){
                $('input[name="up[product][import]"]').prop('checked', true);
            }
            if(permissioin.product.category){
                $('input[name="up[product][category]"]').prop('checked', true);
            }
        }
        
        
        if(permissioin.plant){
            $('input[name="up[plant]"]').prop('checked', true);
            
            $.each( permissioin.plant, function( key, value ) {
                $('input[name="up[plant]['+key+']"]').prop('checked', true);
            });
          
        }
        
        if(permissioin.division){
            $('input[name="up[division]"]').prop('checked', true);
            
            $.each( permissioin.division, function( key, value ) {
                $('input[name="up[division]['+key+']"]').prop('checked', true);
            });
          
        }
        
        

        if(permissioin.report){
            $('input[name="up[report]"]').prop('checked', true);

            if(permissioin.report.marketInventory){
                $('input[name="up[report][marketInventory]"]').prop('checked', true);
            }
            if(permissioin.report.scanedTrendModel){
                $('input[name="up[report][scanedTrendModel]"]').prop('checked', true);
            }
            if(permissioin.report.scanedTrendLocation){
                $('input[name="up[report][scanedTrendLocation]"]').prop('checked', true);
            }
            if(permissioin.report.scanTrendCustomer){
                $('input[name="up[report][scanTrendCustomer]"]').prop('checked', true);
            }

            if(permissioin.report.pointSummary){
                $('input[name="up[report][pointSummary]"]').prop('checked', true);
            }
            if(permissioin.report.encashmentPending){
                $('input[name="up[report][encashmentPending]"]').prop('checked', true);
            }
            if(permissioin.report.couponTrailAudit){
                $('input[name="up[report][couponTrailAudit]"]').prop('checked', true);
            }
            if(permissioin.report.userPointStatment){
                $('input[name="up[report][userPointStatment]"]').prop('checked', true);
            }

            if(permissioin.report.scanAlert){
                $('input[name="up[report][scanAlert]"]').prop('checked', true);
            }
        }

        if(permissioin.customer){
            $('input[name="up[customer]"]').prop('checked', true);

            if(permissioin.customer.feedback){
                $('input[name="up[customer][feedback]"]').prop('checked', true);
            }
        }
    }



    $('.card-header input[type=checkbox]').click(function(){
        var panelBody = $(this).closest('.card').find('.card-body');
        if($(this).is(':checked')){
            panelBody.find('input[type=checkbox]').prop('checked', true);
        } else {
            panelBody.find('input[type=checkbox]').prop('checked', false);
        }
    });


    $('.card-body input[type=checkbox]').change(function(){
        var panelHeading = $(this).closest('.card').find('.card-heading');
        var panelBody = $(this).closest('.card').find('.card-body');

        var isModule = 0;
        panelBody.find('input[type=checkbox]').each(function(){
            if($(this).is(':checked')){
                isModule = 1;
            }
        });

        if(isModule==1){
            panelHeading.find('input[type=checkbox]').prop('checked', true);
        } else {
            panelHeading.find('input[type=checkbox]').prop('checked', false);
        }
    });




})(jQuery);