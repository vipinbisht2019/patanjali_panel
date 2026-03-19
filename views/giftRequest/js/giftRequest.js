(function($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initDataList();
        inptVendor();
        displayInptVendor();
    }
    
    
    function inptVendor(){
    
        var selectBox = $('#inptVendor');
        var option = '<option value="">Select</option>';
        var optionFilter = '<option value="">All</option>';
        $.ajax({
            type: "GET",
            url: API_URL + '/giftRequest/getVendorList',
            data: '',
            dataType: "json",
            cache: false,
            beforeSend: function() {
                //hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    $.each(response.data, function(i, object){
                        
                        option += '<option value="'+object.id+'">'+object.vendorName+'</option>';
                   
                    });
                }
                selectBox.html(option);
             
            },
            complete: function(response) {
                //hidePageLoader();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
                selectBox.html(option);
            }
        });
    }





    
    function displayInptVendor(){
    
        var selectBox = $('#displayInptVendor');
        var option = '<option value="">Select</option>';
        var optionFilter = '<option value="">All</option>';
        $.ajax({
            type: "GET",
            url: API_URL + '/giftRequest/getVendorList',
            data: '',
            dataType: "json",
            cache: false,
            beforeSend: function() {
                //hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    $.each(response.data, function(i, object){
                        
                        option += '<option value="'+object.id+'">'+object.vendorName+'</option>';
                   
                    });
                }
                selectBox.html(option);
             
            },
            complete: function(response) {
                //hidePageLoader();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
                selectBox.html(option);
            }
        });
    }
    
    
    /**** from lib/core/app.php ******/
    
 function getUserRoleByNumber(roleId){
     
     var userRole = "Other";
     
     if(roleId==3)
        userRole ="Distributor/ Distributor Staff"; 
        
    if(roleId==4)
        userRole = "Retailer"; 
        
    if(roleId==5)
        userRole ="Customer";
        
    if(roleId==6)
        userRole ="Mechanic /Garage Owner";
    
    if(roleId==7)
        userRole ="EOW";
    
    if(roleId==8)
        userRole = "Sales Staff";
    
    if(roleId==9)
        userRole ="Engg. Workshop";
    
 return userRole;

	}
	

  


    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        var logo = '';
        var requestStatus = '';
        var giftActiveInactiveStatus = '';
     

        $.each(dataArray, function(i, object) {

            if(object.requestStatus == "Pending") 
               requestStatus = statusLable('Pending', 'red');
               
            else if(object.requestStatus == "Delivered") 
               requestStatus = statusLable('Delivered', 'success');
               
            else if(object.requestStatus == "Dispatched") 
               requestStatus = statusLable('Dispatched', 'success');
               
            else if(object.requestStatus == "Cancelled"  ) 
               requestStatus = statusLable('Cancelled', 'red');
               
         
         giftActiveInactiveStatus = (object.giftData.status == 1) ? statusLable('Active', 'success') : statusLable('In Active', 'red');
         
         
         var userProfession = getUserRoleByNumber(object.userRoleId);
               


            r += '<div class="tr align-items-center" style="border-bottom: 1px solid #ccc">';
            r += '<div class="td">TX#' + object.id + '</div>';
            r += '<div class="td">' + object.giftRequestDate + '</div>';
            r += '<div class="td">' + object.userName + '<br> Address: '+object.deliveryAddress+'</div>';
            r += '<div class="td">' +  userProfession+ '</div>';
            r += '<div class="td">' + object.userMobile + '</div>';
            r += '<div class="td">' + object.giftData.giftUniqueId + '</div>';
            r += '<div class="td">' + object.giftData.points + '</div>';
            r += '<div class="td">' + object.giftData.stock_status + '</div>';
          
            r += '<div class="td">' + giftActiveInactiveStatus + '</div>';
            r += '<div class="td">' + object.updatedOn + '</div>';
            r += '<div class="td">' + requestStatus + '</div>';
            
            r += '<div class="td action">';
            
            r += '<a href="javascript:;" class="showDetail" data-id="' + object.id + '" title="Show Delivery Details"><i class="mdi mdi-book"></i></a>';
          
          if(object.requestStatus != "Cancelled")
            r += '<a href="javascript:;" class="editListItem" data-id="' + object.id + '"><i class="mdi mdi-pencil"></i></a>';
             
           
            r += '<a href="javascript:;" class="printListItem" data-id="' + object.id + '"  title="Print Customer Name/Address"><i class="mdi mdi-printer"></i></a>';
          
            
            r += '</div>';

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

    function initDataList() {

        var dataString = {
            limit: $('#datatable').data('limit'),
            page: $('#datatable').data('page')
        }

        $.ajax({ 
            type: "POST",
            url: API_URL + '/giftRequest/list',
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




    $('#editForm').submit(function() {
        var form = $(this);
        if (validateForm(form)) {

            var dataString = {
                id: $('#editId').val(),
                vendorId: $('#inptVendor').val(),
                dispatchDate: $('#inptDisDate').val(),
                deliveryDate: $('#inptDelDate').val(),
                awbNum: $('#inptAwb').val(),
                isReturn: ($('#isReturn').is(':checked')) ? 1 : 0,
                requestStatus: $('#giftRequestStatus').val(),
                returnReason: $('#inptCancleReason').val()
                
            }

            var modalBox = $('#addEditModal');

            if(dataString.id > 0){
                var action = API_URL + '/giftRequest/edit';
                var msg = 'Gift Request information updated.';
            } 

            showPageLoader();

            $.ajax({
                type: "POST",
                url: action,
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success == 1) {
                        modalBox.find('.close').click();
                        initDataList();
                        showResponseSuccessMsg(msg);
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


    $('body').on('click', '.editListItem', function() {

        var id = $(this).data('id');
 
        showPageLoader();
        $.ajax({
            type: "GET",
            url: API_URL + '/giftRequest/detail/' + id,
            data: '',
            dataType: "json",
            cache: false,
            success: function(response) {
                if (response.success == 1) {

                    $('#editId').val(response.data.id);
                    
                    if(response.data.dispatchVendorId)
                         $('#inptVendor').val(response.data.dispatchVendorId);
                    else
                        $('#inptVendor').val(0);
                    
                    $('#inptDisDate').val(response.data.dispatchDate);
                    $('#inptDelDate').val(response.data.deliveryDate);
                    $('#inptAwb').val(response.data.AWBnumber);
                    $('#giftRequestStatus').val(response.data.requestStatus);
                   
                    if (response.data.giftReturn == 1) 
                        $('#isReturn').prop('checked', true);
                     else 
                        $('#isReturn').prop('checked', false);

                    $('.loaderWrap').hide();

                    bodyFix();
                    var modalBox = $('#addEditModal');
                    modalBox.addClass('show');
                    modalBox.find('.modal-header h3').text('Update Gift Request Details');
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
    
    
    $('body').on('click', '.showDetail', function() {
        
        var id = $(this).data('id');
 
        showPageLoader();
        $.ajax({
            type: "GET",
            url: API_URL + '/giftRequest/detail/' + id,
            data: '',
            dataType: "json",
            cache: false,
            success: function(response) {
                if (response.success == 1) {
                    
                    $('#displayInptVendor').val(response.data.dispatchVendorId);
                    $('#disInptDisDate').val(response.data.dispatchDate);
                    $('#disInptDelDate').val(response.data.deliveryDate);
                    $('#disInptAwb').val(response.data.AWBnumber);
                    $('#disGiftRequestStatus').val(response.data.requestStatus);
                    $('#disInptCancleReason').val(response.data.returnReason);
                    
                   
                    if (response.data.giftReturn == 1) 
                        $('#disIsReturn').val('YES');
                     else 
                       $('#disIsReturn').val('NO');

                    $('.loaderWrap').hide();

                    bodyFix();
                    var modalBox = $('#displayModal');
                    modalBox.addClass('show');
                    modalBox.find('.modal-header h3').text('Gift Request Delivery Details');
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
    
    

    $('body').on('click', '.deleteListItem', function() {

        if(!confirm('Are you sure want to delete this gift request ?')){
            return false;
        }

        var id = $(this).data('id');
        showPageLoader();
        $.ajax({
            type: "GET",
            url: API_URL + '/giftRequest/delete/' + id,
            data: '',
            dataType: "json",
            cache: false,
            success: function(response) {
                hidePageLoader();
                if (response.success == 1) {
                    initDataList();
                    showResponseSuccessMsg("Request successfully deleted.");
                } else {
                    showResponseErrorMsg(response.message);
                }
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

        var dataString = {

        transactionIdFilter: $('#transactionIdFilter').val(),
        mobileFilter: $('#mobileFilter').val(),
            
        giftStockStatusFilter: $('#giftStockStatusFilter :selected').val(),
        giftRequestStatusFilter: $('#giftRequestStatusFilter :selected').val(),
            
        giftRequestDateFilter: $('#giftRequestDateFilter').val()
   
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/giftRequest/list',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                showPageLoader();
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
                //console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
                hidePageLoader();
            }
        });
    });

    $('#getDownload').click(function(){
        
        var dataString = {

        transactionIdFilter: $('#transactionIdFilter').val(),
        mobileFilter: $('#mobileFilter').val(),
            
        giftStockStatusFilter: $('#giftStockStatusFilter :selected').val(),
        giftRequestStatusFilter: $('#giftRequestStatusFilter :selected').val(),
            
        giftRequestDateFilter: $('#giftRequestDateFilter').val()
   
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/giftRequest/list/download',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                showPageLoader();
            },
            success: function(response) {
                if (response.success == 1) { alert(response.success);
                    
                } else {
                    noResult();
                }
            },
            complete: function(response) {
                hidePageLoader();
            },
            error: function(xhr, status, error) {
                //console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
                hidePageLoader();
            }
        });
    });





$('#inptDelDate').datepicker({format:'yyyy-mm-dd'});
$('#inptDisDate').datepicker({format:'yyyy-mm-dd'}); 


$( "#isReturn" ).change(function() {
    
  if($('#isReturn').is(':checked'))
    $("#inptCancleReasonDiv").show();
  else
    $("#inptCancleReasonDiv").hide();
  
});


$('#giftRequestDateFilter').datepicker({format:'yyyy-mm-dd'});

})(jQuery);