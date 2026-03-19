(function ($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initDataList();
    }


 function getDistributorList(){
    
        var selectBox = $('#inptDistributorList');
        var option = '<option value="">Select</option>';
        var optionFilter = '<option value="">All</option>';
        $.ajax({
            type: "GET",
            url: API_URL + '/orderManagement/distributorList',
            data: '',
            dataType: "json",
            cache: false,
            beforeSend: function() {
                //hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    $.each(response.data, function(i, object){
                        
                        option += '<option value="'+object.id+'">'+object.dealerCode+' ('+object.name+')</option>';
                   
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


    $('#inptDistributorList').on('change', function() {
         var userId = this.value;
     
          $.ajax({
            type: "POST",
            url: API_URL + '/orderManagement/getUserData/'+ userId,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function () {
                hidePageLoader();
            },
            success: function (response) {
                if (response.success == 1) {
             
                 $('#manufatureMobileE').empty().val(response.data[0].mobile);
                 $('#manufatureDealerCodeE').empty().html(response.data[0].dealerCode);
    
                } else {
                    noResult();
                }
            },
            complete: function (response) {
                hidePageLoader();
            },
            error: function (xhr, status, error) {
               console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });
         
         
         
    });


    /**** from lib/core/app.php ******/

    function getUserRoleByNumber(roleId) {

        var userRole = "Other";

        if (roleId == 3)
            userRole = "Distributor/ Distributor Staff";

        if (roleId == 4)
            userRole = "Retailer";

        if (roleId == 5)
            userRole = "Customer";

        if (roleId == 6)
            userRole = "Mechanic /Garage Owner";

        if (roleId == 7)
            userRole = "EOW";

        if (roleId == 8)
            userRole = "Sales Staff";

        if (roleId == 9)
            userRole = "Engg. Workshop";

        return userRole;

    }


    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        var logo = '';
        var orderStatus = '';
        var paymentStatus = '';
        var dealerCode= '';
        var userProfession = '';


        $.each(dataArray, function (i, object) {

            if (object.order_status == "Pending")
                orderStatus = statusLable('Pending', 'red');

            else if (object.order_status == "Delivered")
                orderStatus = statusLable('Delivered', 'success');

            else if (object.order_status == "Dispatched")
                orderStatus = statusLable('Dispatched', 'success');

            else if (object.order_status == "Cancelled")
                orderStatus = statusLable('Cancelled', 'success');
            
            else if (object.order_status == "Partial Dispatch")
                orderStatus = statusLable('Partial Dispatch', 'success');
                
                
            if (object.payment_status == "Pending Payment")
                paymentStatus = statusLable('Pending Payment', 'red');

            else if (object.payment_status == "Payment Received")
                paymentStatus = statusLable('Payment Received', 'success');

            else if (object.payment_status == "Payment In-Process")
                paymentStatus = statusLable('Payment In-Process', 'success');

            else if (object.payment_status == "Payment Return")
                paymentStatus = statusLable('Payment Return', 'success');


            userProfession = getUserRoleByNumber(object.userRoleId);
            dealerCode = (object.dealerCode) ? object.dealerCode : "-";


            r += '<div class="tr align-items-center" style="border-bottom: 1px solid #ccc">';
            r += '<div class="td">OrderId#' + object.order_id + '</div>';
            r += '<div class="td">' + object.userName + '</div>';
            r += '<div class="td">' + object.userMobile + '</div>';
            r += '<div class="td">' + dealerCode + '</div>';
            r += '<div class="td">' + orderStatus + '</div>';
            r += '<div class="td">' + paymentStatus + '</div>';
            r += '<div class="td">' + object.order_date + '</div>';
            r += '<div class="td">' + object.order_updateDate + '</div>';

            r += '<div class="td action">';

            r += '<a href="javascript:;" class="showDetail" data-id="' + object.order_id + '" title="Order Information"><i class="mdi mdi-information-outline"></i></a>';
            
            r += '<a href="javascript:;" class="deleteListItem" data-id="' + object.order_id + '" title="Delete Order"><i class="mdi mdi-delete"></i></a>';


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
                onPageClick: function (pageNumber, event) {
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
            url: API_URL + '/orderManagement/list',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function () {
                hidePageLoader();
            },
            success: function (response) {
                if (response.success == 1) {
                    initData(response.data);
                } else {
                    noResult();
                }
            },
            complete: function (response) {
                hidePageLoader();
            },
            error: function (xhr, status, error) {
               console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });
    }




    $('#editForm').submit(function () {
        
        var form = $(this);
        if (validateForm(form)) {

            var dataString = {
                id: $('#editId').val(),
                orderComment: $('#orderCommentE').val(),
                orderStatus: $('#orderStatusE').val(),
                userId: $('#inptDistributorList').val(),
                userMobile: $('#manufatureMobileE').val(),
                paymentStatus: $('#orderPaymentStatusE').val()
            }

            var modalBox = $('#addEditModal');

            if (dataString.id > 0) {
                var action = API_URL + '/orderManagement/edit';
                var msg = 'Order information updated.';
            }

            showPageLoader();

            $.ajax({
                type: "POST",
                url: action,
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function (response) {
                    if (response.success == 1) {
                        modalBox.find('.close').click();
                        initDataList();
                        showResponseSuccessMsg(msg);
                    } else {
                        showResponseErrorMsg(response.message);
                    }
                    hidePageLoader();
                },
                error: function (error, xhr) {
                    console.log('error', error);
                    console.log('xhr', xhr);
                    showResponseErrorMsg("Unable to proccess this request.");
                    hidePageLoader();
                }
            });

        }
        return false;
    });
    
    
    

    $('body').on('click', '.showDetail', function () {

        var id = $(this).data('id');
        showPageLoader();
        $.ajax({
            type: "GET",
            url: API_URL + '/orderManagement/detail/' + id,
            data: '',
            dataType: "json",
            cache: false,
            success: function (response) {
                if (response.success == 1) {
                    
                    $('#btnUpdate').attr('data-id', response.data.order_id);
                    $('#btnDispatch').attr('data-id', response.data.order_id);

                    $('#orderId').empty().html("OrderId#"+response.data.order_id);
                    $('#orderDate').empty().html(response.data.order_date);
                    $('#orderStatus').empty().html(response.data.order_status);
                    $('#orderComment').val(response.data.order_comment);
                    $('#manufactureOrderComment').val(response.data.manufacture_comment);
                    $('#orderPaymentStatus').empty().html(response.data.payment_status);
                    $('#manufatureName').empty().html(response.data.userName);
                    $('#manufatureMobile').empty().html(response.data.userMobile);
                     $('#manufatureDealerCode').empty().html(response.data.dealerCode);
                    
                    
        var orderItems ="<div class='thead'>";
            orderItems +="<div class='tr'>";
                    
            orderItems += "<div class='th'>Product Name</div>";
            orderItems += "<div class='th'>MRP</div>";  
            orderItems += "<div class='th'>Part No.</div>";
            orderItems += "<div class='th'>Order Qty</div>";
            orderItems += "<div class='th'>Dispatched Qty</div>";
            
            orderItems += "</div></div>";
                    
        $.each(response.data.order_item_data, function (i, object) {
            
           orderItems += '<div class="tr align-items-center" style="border-bottom: 1px solid #ccc">';

            orderItems += '<div class="td">' + object.product_name + '</div>';
            orderItems += '<div class="td">&#x20B9;' + object.product_mrp + '</div>';
            orderItems += '<div class="td">' + object.part_no + '</div>';
            orderItems += '<div class="td">' + object.qty + '</div>';
            orderItems += '<div class="td">' + object.dispatchItemQty + '</div>';
            
            orderItems += "</div>";
            
        });
        
            $('#orderItems').empty().html(orderItems);
            
            
            
            var dispatchOrderItems ="<div class='thead'>";
            dispatchOrderItems +="<div class='tr'>";
                    
            dispatchOrderItems += "<div class='th'>Product Name</div>";
            dispatchOrderItems += "<div class='th'>Dispatched Qty</div>";
            dispatchOrderItems += "<div class='th'>Dispatched Comment</div>";
            dispatchOrderItems += "<div class='th'>Dispatched Date/Time</div>";
            
            dispatchOrderItems += "</div></div>";
                    
        $.each(response.data.dispatch_item_data, function (i, object) {
            
           dispatchOrderItems += '<div class="tr align-items-center" style="border-bottom: 1px solid #ccc">';

            dispatchOrderItems += '<div class="td">' + object.product_name + '</div>';
            
            dispatchOrderItems += '<div class="td">' + object.dispatchItemQty + '</div>';
             
            dispatchOrderItems += '<div class="td">' + object.dispatchItemComment + '</div>';
          
            dispatchOrderItems += '<div class="td">' + object.dispatchDate + '</div>';
            
            dispatchOrderItems += "</div>";
            
        });
        
            $('#dispatchOrderItems').empty().html(dispatchOrderItems);
    


                    $('.loaderWrap').hide();

                    bodyFix();
                    var modalBox = $('#displayModal');
                    modalBox.addClass('show');
                    modalBox.find('.modal-header h3').text('Order Information');
                   
                } else {
                    showResponseErrorMsg(response.message);
                }
                hidePageLoader();
            },
            error: function (error, xhr) {
                console.log('error', error);
                console.log('xhr', xhr);
                showResponseErrorMsg("Unable to proccess this request.");
                hidePageLoader();
            }
        });
    });



    $('body').on('click', '.deleteListItem', function () {

        if (!confirm('Are you sure want to delete this order ?')) {
            return false;
        }

        var id = $(this).data('id');
        showPageLoader();
        $.ajax({
            type: "GET",
            url: API_URL + '/orderManagement/delete/' + id,
            data: '',
            dataType: "json",
            cache: false,
            success: function (response) {
                hidePageLoader();
                if (response.success == 1) {
                    initDataList();
                    showResponseSuccessMsg("Request successfully deleted.");
                } else {
                    showResponseErrorMsg(response.message);
                }
            },
            error: function (error, xhr) {
                console.log('error', error);
                console.log('xhr', xhr);
                showResponseErrorMsg("Unable to proccess this request.");
                hidePageLoader();
            }
        });
    });




    $('#getSearchResult').click(function () {

        var dataString = {

            transactionIdFilter: $('#transactionIdFilter').val(),
            mobileFilter: $('#mobileFilter').val(),

            paymentStatus: $('#paymentStatus :selected').val(),
            orderStatusFilter: $('#orderStatusFilter :selected').val(),

            orderDateFilterFrom: $('#orderDateFilterFrom').val(),
            orderDateFilterTo: $('#orderDateFilterTo').val()

        }

        $.ajax({
            type: "POST",
            url: API_URL + '/orderManagement/list',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function () {
                showPageLoader();
            },
            success: function (response) {
                if (response.success == 1) {
                    initData(response.data);
                } else {
                    noResult();
                }
            },
            complete: function (response) {
                hidePageLoader();
            },
            error: function (xhr, status, error) {
                //console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
                hidePageLoader();
            }
        });
    });



 $('body').on('click', '#btnUpdate', function () {
         
         var modalBox = $('#addEditModal');
         modalBox.removeClass('show');
         
        var displayModalBox = $('#displayModal');
        displayModalBox.removeClass('show');
        
        getDistributorList();
        
        var orderId = $('#btnUpdate').attr('data-id');

        var id = orderId;

        showPageLoader();
        $.ajax({
            type: "GET",
            url: API_URL + '/orderManagement/detail/' + id,
            data: '',
            dataType: "json",
            cache: false,
            success: function (response) {
                if (response.success == 1) {

                    
                    $('#editId').val(response.data.order_id);
                    $('#inptDistributorList').val(response.data.user_id);

                    $('#orderIdE').empty().html("OrderId#"+response.data.order_id);
                    $('#orderDateE').empty().html(response.data.order_date);
                    $('#orderStatusE').val(response.data.order_status);
                    $('#orderCommentE').val(response.data.order_comment);
                    $('#orderPaymentStatusE').val(response.data.payment_status);
             
                    $('#manufatureMobileE').empty().val(response.data.userMobile);
                     $('#manufatureDealerCodeE').empty().html(response.data.dealerCode);
                    
        var orderItems ="<div class='thead'>";
            orderItems +="<div class='tr'>";
                    
            orderItems += "<div class='th'>Product Name</div>";
            orderItems += "<div class='th'>MRP</div>";  
            orderItems += "<div class='th'>Part No.</div>";
            orderItems += "<div class='th'>Order Qty</div>";
            orderItems += "<div class='th'>Dispatched Qty</div>";
            
            orderItems += "</div></div>";
                    
        $.each(response.data.order_item_data, function (i, object) {
            
           orderItems += '<div class="tr align-items-center" style="border-bottom: 1px solid #ccc">';

            orderItems += '<div class="td">' + object.product_name + '</div>';
            orderItems += '<div class="td">&#x20B9;' + object.product_mrp + '</div>';
            orderItems += '<div class="td">' + object.part_no + '</div>';
            orderItems += '<div class="td">' + object.qty + '</div>';
            orderItems += '<div class="td">' + object.dispatchItemQty + '</div>';
            
            orderItems += "</div>";
            
        });
        
            $('#orderItemsE').empty().html(orderItems);
    


                    $('.loaderWrap').hide();

                    bodyFix();
                    var modalBox = $('#addEditModal');
                    modalBox.addClass('show');
                    modalBox.find('.modal-header h3').text('Update Order Information');
                   
                } else {
                    showResponseErrorMsg(response.message);
                }
                hidePageLoader();
            },
            error: function (error, xhr) {
                console.log('error', error);
                console.log('xhr', xhr);
                showResponseErrorMsg("Unable to proccess this request.");
                hidePageLoader();
            }
        });
    });


 $('body').on('click', '#btnDispatch', function () {
       
        var orderId = $('#btnDispatch').attr('data-id');
        var id = orderId;
        var readonly = "";

        showPageLoader();
        $.ajax({
            type: "GET",
            url: API_URL + '/orderManagement/detail/' + id,
            data: '',
            dataType: "json",
            cache: false,
            success: function (response) {
                if (response.success == 1) {
                    
                    $('#editIdD').val(response.data.order_id);

                    $('#orderIdD').empty().html("OrderId#"+response.data.order_id);
                    $('#orderDateD').empty().html(response.data.order_date);
                    $('#orderStatusD').val(response.data.order_status);
                    $('#orderCommentD').val(response.data.order_comment);
                    $('#manufactureOrderCommentD').val(response.data.manufacture_comment);
                    $('#orderPaymentStatusD').val(response.data.payment_status);
                    $('#manufatureNameD').empty().html(response.data.userName);
                    $('#manufatureMobileD').empty().html(response.data.userMobile);
                    $('#manufatureDealerCodeD').empty().html(response.data.dealerCode);
                    
        var orderItems ="<div class='thead'>";
            orderItems +="<div class='tr'>";
                    
            orderItems += "<div class='th'>Product Name</div>";
            orderItems += "<div class='th'>MRP</div>";  
            orderItems += "<div class='th'>Part No.</div>";
            orderItems += "<div class='th'>Order Qty</div>";
             orderItems += "<div class='th'>Dispatched Qty</div>";
            orderItems += "<div class='th'>Dispatch Qty</div>";
            orderItems += "<div class='th'>Comment</div>";
            
            orderItems += "</div></div>";
                    
        $.each(response.data.order_item_data, function (i, object) {
            
            if(object.dispatchItemQty == object.qty)
                readonly = "readonly";
            else
                readonly = "";
            
           orderItems += '<div class="tr align-items-center" style="border-bottom: 1px solid #ccc">';

            orderItems += '<div class="td">' + object.product_name + '</div>';
            orderItems += '<div class="td">&#x20B9;' + object.product_mrp + '</div>';
            orderItems += '<div class="td">' + object.part_no + '</div>';
            orderItems += '<div class="td">' + object.qty + '</div>';
            orderItems += '<div class="td">' + object.dispatchItemQty + '</div>';
            orderItems += '<div class="td"><input type="text" class="dispatchQty form-control"  name="'+object.item_id+'" '+readonly+'></div>';
            
            orderItems += '<div class="td"><input type="text" class="dispatchComment form-control" name="'+object.item_id+'" '+readonly+' ></div></div>';
            
            orderItems += "</div>";
            
        });
        
            $('#orderItemsD').empty().html(orderItems);

                    $('.loaderWrap').hide();

                    bodyFix();
                    
                   var displayModalBox = $('#displayModal');
                    displayModalBox.removeClass('show');
        
                    var modalBox = $('#dispatchModal');
                    modalBox.addClass('show');
                    modalBox.find('.modal-header h3').text('Dispatch Order Updates');
                    
                    
                   
                } else {
                    showResponseErrorMsg(response.message);
                }
                hidePageLoader();
            },
            error: function (error, xhr) {
                console.log('error', error);
                console.log('xhr', xhr);
                showResponseErrorMsg("Unable to proccess this request.");
                hidePageLoader();
            }
        });
    });
    
    
 $('#dispatchForm').submit(function () {
        var form = $(this);
        
    if (validateForm(form)) {
            

        var dispatchQtyPost = $(".dispatchQty");

        var dispatchQty = $.map(dispatchQtyPost, function(element) {
            return {itemId: element.name, value: element.value};
        });
        
        var dispatchCommentPost = $(".dispatchComment");

        var dispatchComment = $.map(dispatchCommentPost, function(element) {
            return {itemId: element.name, value: element.value};
        });
                            
            var dataString = {
                id: $('#editIdD').val(),
                orderStatus: $('#orderStatusD').val(),
                paymentStatus: $('#orderPaymentStatusD').val(),
                manufactureComment: $('#manufactureOrderCommentD').val(),
                dispatchQtyArray: dispatchQty,
                dispatchCommentArray: dispatchComment 
            }
                            
            var modalBox = $('#dispatchModal');

            if (dataString.id > 0) {
                var action = API_URL + '/orderManagement/dispatch';
                var msg = 'Order Dispatch/Update.';
            }

            showPageLoader();

            $.ajax({
                type: "POST",
                url: action,
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function (response) {
                    if (response.success == 1) {
                        modalBox.find('.close').click();
                        initDataList();
                        showResponseSuccessMsg(msg);
                    } else {
                        showResponseErrorMsg(response.message);
                    }
                    hidePageLoader();
                },
                error: function (error, xhr) {
                    console.log('error', error);
                    console.log('xhr', xhr);
                    showResponseErrorMsg("Unable to proccess this request.");
                    hidePageLoader();
                }
            });

        }
        return false;
    });

    $('#orderDateFilterFrom').datepicker({ format: 'yyyy-mm-dd' });
    $('#orderDateFilterTo').datepicker({ format: 'yyyy-mm-dd' });
    

    $( "#orderDateFilterTo" ).focusout(function() {
        
        var startDate = new Date($('#orderDateFilterFrom').val());
        var endDate = new Date($('#orderDateFilterTo').val());
        
         if (startDate > endDate){
             alert("End date can not be less than start date !!");
         }
         
    });

})(jQuery);