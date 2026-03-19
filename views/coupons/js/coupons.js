(function($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initPlant('#plant', 'All');
        initDataList();
    }

    function initData(dataArray,role) {

        var dataResult = $('#dataTableResult');
        var r = '';
        var couponBatchIdArray = [];
        var status = "";

        $.each(dataArray, function(i, object) {
            

            couponBatchIdArray.push(object.id);
            
            if(object.isTrash == 1)
                status = statusLable('Trash', 'red');
                
            else if(object.isPrint == 1 && object.is_generated==1 && object.isActive == 0)
                status = statusLable('Printed', 'blue');
               
            else if(object.isPrint == 1 && object.isActive == 1 && object.is_generated==1)
                status = statusLable('Active', 'success');
               
            else if(object.isPrint == 1 && object.isActive == 1 && object.is_generated==0)
                status = statusLable('Not Generated', 'red');
              
            else 
                status = statusLable('Coupon not Generated', 'red');
            
          
            r += '<div class="tr align-items-center">';
            r += '<div class="td inlineText">' + object.orderNo + '</div>';
            r += '<div class="td inlineText">' + object.productName + '</div>';
            r += '<div class="td inlineText">' + object.batchNumber + '</div>';
            r += '<div class="td inlineText">' + object.batchSize + '</div>';
            r += '<div class="td inlineText">' + object.plant_id + '</div>';
            r += '<div class="td inlineText">' + object.unit_id + '</div>';
            r += '<div class="td inlineText" id="printed_'+ object.id + '"></div>';
            r += '<div class="td inlineText" id="nonprinted_'+ object.id + '"></div>';
            r += '<div class="td inlineText">' + object.dateOfMfg + '</div>';
            r += '<div class="td inlineText" id="status_'+ object.id + '">'+status+'</div>';
            r += '<div class="td inlineText">' + object.createdOn + '</div>';

            r += '<div class="td action">';
            r += '<a href="javascript:;" class="viewListItem" data-id="' + object.id + '"><i class="mdi mdi-eye"></i></a>';
            
            if(role==1){ // only admin role will delete
            
                if((object.isTrash == 0 && object.isActive ==0) || (object.isTrash == 0 && object.isActive ==1 && object.is_generated==0) ){
                r += '<a href="javascript:;" class="deleteListItem" data-id="' + object.id + '"><i class="mdi mdi-delete"></i></a>';
                }
            }
            
            r += '</div>';
            r += '</div>';
        });
  
        dataResult.html(r);
        getPrintedNonPrinted(couponBatchIdArray);
        
    }
    
    
function getPrintedNonPrinted(couponBatchIdArray) {

    var dataString = {coponBatchMetaIds: couponBatchIdArray}
    var printedContainerId = 0;
    var nonPrintedContainerId = 0;
    var status;
    var statusContainerId = "";
  
     $.ajax({
            type: "POST",
            url: API_URL + '/coupon/getPrintedNonPrinted',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response) {
                if (response.success == 1) {
                    
                    $.each(response.data, function(i, object) {
            
                        printedContainerId = "printed_"+object.coupon_order_id;
                        nonPrintedContainerId = "nonprinted_"+object.coupon_order_id;
                        statusContainerId = "status_"+object.coupon_order_id;
                     
                        $("#"+printedContainerId).html(object.printed);
                        $("#"+nonPrintedContainerId).html(object.nonPrinted);
                        
                        if(object.is_trash ==1){
                            status = statusLable('Trash', 'red');
                            $("#"+statusContainerId).html(status);
                        }
                        else if(object.is_print == 0 && object.is_generated==1 && object.nonPrinted > 0){
                            status = statusLable('Coupon pending to print', 'blue');
                            $("#"+statusContainerId).html(status);
                        }
                        else if(object.is_print == 0  && object.is_generated==1 && object.nonPrinted  <= 0){
                            status = statusLable('Generated!! Ready to print', 'yellow');
                            $("#"+statusContainerId).html(status);
                        }
                    
                    });     
                } 
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });
       
    }
    
    
        
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
        var totalRecord = Object.keys(response).length;
       
        if (totalRecord > dataString.limit) {
            $('#dataPagination').twbsPagination({
                totalPages: Math.ceil(totalRecord/dataString.limit),  
                visiblePages: 5,  
                next: "Next",  
                prev: "Prev", 
                onPageClick: function(event, page) {
                    $('#datatable').data("page",page);
                    initDataList();
                },
            })
            ;
        }
    }
    

function initDataList() {
    var dataString = {
        orderNo: $('#filterOrderNo').val(),
        productName: $('#filterProductName').val(),
        batchNo: $('#filterBatchNo').val(),
        dateOfMfg: $('#filterDateOfMfg').val(),
        status: $('#filterStatus :selected').val(),
        limit: $('#datatable').data('limit'),
        page: $('#datatable').data('page'),
        plantId: $('#plant :selected').val(),
        divisionId: $('#divisionunit :selected').val(),
        
        couponType: $('#filterCouponType :selected').val(),
        mainCategory: $('#mainCategory :selected').val(),
        subCategory: $('#subCategory :selected').val(),
        categoryProduct: $('#categoryProduct :selected').val()
    }

       

        $.ajax({
            type: "POST",
            url: API_URL + '/genratedCoupons',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                showPageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    initData(response.data,response.role);
                    initPagination(response.data2,dataString);
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

    $('#getSearchResult').click(function(){
        $('#datatable').data('page', 1);

        var dataString = {
            orderNo: $('#filterOrderNo').val(),
            productName: $('#filterProductName').val(),
            batchNo: $('#filterBatchNo').val(),
            dateOfMfg: $('#filterDateOfMfg').val(),
            status: $('#filterStatus :selected').val(),
            limit: $('#datatable').data('limit'),
            page: $('#datatable').data('page'),
            plantId: $('#plant :selected').val(),
            divisionId: $('#divisionunit :selected').val(),
            
            couponType: $('#filterCouponType :selected').val(),
            mainCategory: $('#mainCategory :selected').val(),
            subCategory: $('#subCategory :selected').val(),
            categoryProduct: $('#categoryProduct :selected').val()
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/genratedCoupons',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {

                    (initData)(response.data,response);
                    $('#dataPagination').twbsPagination('destroy');
                    
                    initPagination(response.data2,dataString);
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
    });

    $('#dataForm').submit(function() {
        var form = $(this);
        if (validateForm(form)) {

            var dataSet = [];
            $('.item-row').each(function() {
                var elm = $(this);
                dataSet.push({
                    parent: 0,
                    name: elm.find('.categoryName').val(),
                    desc: elm.find('.categoryDesc').val(),
                });
            });

            var dataString = {
                data: dataSet
            }

            showPageLoader();
            $.ajax({
                type: "POST",
                url: API_URL + '/category/add',
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success == 1) {
                        window.location.href = APP_URL + '/category';
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

    $('#editForm').submit(function() {
        var form = $(this);
        if (validateForm(form)) {

            var dataString = {
                id: $('#editId').val(),
                parent: 0,
                name: $('#categoryName').val(),
                desc: $('#categoryDesc').val()
            }

            showPageLoader();
            $.ajax({
                type: "POST",
                url: API_URL + '/category/edit',
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success == 1) {
                        bodyUnFix();
                        $('#addEditModal').removeClass('show');
                        initDataList();
                        showResponseSuccessMsg('Category successfully updated.');
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

    $('body').on('click', '.viewListItem', function() {
        var id = $(this).data('id');
        var viewModal = $('#viewModal');
        var r='';
        var status='';
        showPageLoader();
        $.ajax({
            type: "POST",
            url: API_URL + '/viewGenratedCoupon',
            data: JSON.stringify({
                id: id
            }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response) {
                if (response.success == 1) {

                    if(response.data.isTrash==1){
                        status = statusLable('Trash', 'red');
                    } else if(response.data.isPrint==0 && response.data.isActive==0){
                        status = statusLable('Pending', 'yellow');
                    } else if(response.data.isPrint==1 && response.data.isActive==0){
                        status = statusLable('Printed', 'success');
                    } else if(response.data.isPrint==1 && response.data.isActive==1){
                        status = statusLable('Active', 'success');
                    } else {
                        status = statusLable('Trash', 'red');
                    }

                    $('#orderId').val(id);
                    $('#printAllCoupons').data('id', id);
                    $('#mainCategory1').text(response.data.categoryName);
                    $('#categoryProduct1').text(response.data.productName);
                    $('#productSeries').text(response.data.productSeries);
                    $('#productMrp').text(response.data.productMrp);

                    $('#batchSize').text(response.data.batchSize);
                    $('#batchNumber').text(response.data.batchNumber);
                    $('#dateOfMfg').text(response.data.dateOfMfg);
                    $('#couponValidity').text(response.data.validity+' Days');
                    $('#OrderNo').html('<span style="float:left; line-height: 24px; margin-right:30px; font-weight:500; display: inline-block;">#'+response.data.orderNo+'</span> '+status);
                    
                var agmarkStartNumber = response.data.agmark_number_start;
                var batchSizeVar = response.data.batchSize;
                var agmarkEndNum = batchSizeVar-1;
                var agmarkEndNumFinal = parseInt(agmarkStartNumber) + parseInt(agmarkEndNum);
                
                $('#agmarkSeries').text(response.data.agmark_series);
                $('#agmarkStartNum').text(agmarkStartNumber);
                $('#agmarkEndNum').text(agmarkEndNumFinal);
                $('#productExpdate').text(response.data.expDate );

                    $.each(response.data.couponValues, function(i, obj){
                        r+='<div class="flexRow itemRow" data-face-value-id="'+obj.faceValueId+'" data-face-value="'+obj.faceValue+'" data-qty="'+obj.qty+'">';
                          r+='<div class="col-fx-auto cpPrice">'+obj.faceValue+'</div>';
                          r+='<div class="col-fx-auto cpQty">'+obj.qty+'</div>';
                        r+='</div>';
                    });


                    $('#activateInnerCoupon').hide();
                    $('#printInnerCoupons').hide();
                    $('#generated').hide();
                    
                    $('#activateOuterCoupon').hide();
                    $('#printOuterCoupons').hide();

                    $('#adminActivateInnerCoupon').hide();  // 25_aug_2023
        
                    
            // for coupon type = inner: customer
                    if(response.data.coupon_type=='inner'){
                        
                         $('#innerCouponTypeCustomer').show();
                         $('#outerCouponTypeRetailer').hide();
                        
                        if(response.data.isTrash==0 && response.data.is_generated==1 && response.data.isActive==0)
                        {
                            $('#generated').css({display:'inline'});        // 25_aug_2023
                            $('#adminActivateInnerCoupon').css({display:'inline'});   // 25_aug_2023
                        }
                            
                        if(response.data.isTrash==0 && response.data.is_generated==0 && response.data.isActive==0)
                            $('#printInnerCoupons').css({display:'block'});
                            
                        if(response.data.isTrash==0 && response.data.is_generated==1 && response.data.isActive==0 && response.data.isPrint==1)
                            $('#activateInnerCoupon').css({display:'block'});
                    
                    }
                    
            // for coupon type = outer: Reatiler
                    if(response.data.coupon_type=='outer'){
                        
                        $('#outerCouponTypeRetailer').show();
                        $('#innerCouponTypeCustomer').hide();
                        
                        if(response.data.isTrash==0 && response.data.isPrint==0 && response.data.isActive==0)
                            $('#printOuterCoupons').css({display:'block'});

                        if(response.data.isTrash==0 && response.data.isPrint==1 && response.data.isActive==0)
                            $('#activateOuterCoupon').css({display:'block'});
                    }
                    
                
                    $('#couponValues').html(r);
                    $('#qrProductName').html(response.data.productName);
                    $('#qrSize').html(response.data.batchSize);
                    $('#qrPoints').html(response.data.points);
                    $('#qrCodeNo').html(response.data.couponCode);

                    if(response.data.isPrint==1 || response.data.isActive==1){
                        $('#qrValidUpTo').html(response.data.validUpTo);
                    } else {
                        $('#qrValidUpTo').html('');
                    }

                    $('#qrImg').attr("src",response.data.qr);
                    viewModal.addClass('show');
                    
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

        if (!confirm('Are you sure?')) {
            return false;
        }

        var id = $(this).data('id');
        showPageLoader();
        $.ajax({
            type: "POST",
            url: API_URL + '/coupon/delete',
            data: JSON.stringify({
                id: id
            }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response) {
                if (response.success == 1) {
                    initDataList();
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


    $('body').on('click', '#printInnerCoupons', function() {
        var id = $('#orderId').val();

        var viewModal = $('#viewModal');

        showPageLoader();
        $.ajax({
            type: "POST",
            url: API_URL + '/print/coupon',
            data: JSON.stringify({
                id: id
            }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response) {
                hidePageLoader();
                if (response.success == 1) {

                    viewModal.find('.close').click();
                    initDataList();

                } else {
                    showResponseErrorMsg(response.message);
                }
            },
            error: function(error, xhr) {
                console.log('error', error);
                console.log('xhr', xhr);
                console.log('XHR ERROR ' + XMLHttpRequest.status);
                console.log(XMLHttpRequest.responseText +' - resposne text');
                showResponseErrorMsg("Unable to proccess this request.");
                hidePageLoader();
            }
        });
    });
    
    
$('body').on('click', '#activateOuterCoupon', function() {

        var id = $('#orderId').val();
        var viewModal = $('#viewModal');

        showPageLoader();
        $.ajax({
            type: "POST",
            url: API_URL + '/activate/coupon',
            data: JSON.stringify({
                id: id
            }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response) {
                hidePageLoader();
                if (response.success == 1) {
                    viewModal.find('.close').click();
                    initDataList();
                    showResponseSuccessMsg(response.message);
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

$('body').on('click', '#printOuterCoupons', function() {
        var id = $('#orderId').val();

        var viewModal = $('#viewModal');

        showPageLoader();
        $.ajax({
            type: "POST",
            url: API_URL + '/print/outercoupon',
            data: JSON.stringify({
                id: id
            }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response) {
                hidePageLoader();
                if (response.success == 1) {

                    viewModal.find('.close').click();
                    initDataList();

                    var url = APP_URL+'/printOrderCoupon/'+id;
                    window.open(url, 'Print','height=500,width=500');

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

  $('input[type="submit"]').click(function(){
    $(this).css('background-color','green');
 });



// start 25_aug_2023
 $('body').on('click', '#adminActivateInnerCoupon', function() {

    var id = $('#orderId').val();
    var viewModal = $('#viewModal');

    showPageLoader();
    $.ajax({
        type: "POST",
        url: API_URL + '/activate/innerCoupon',
        data: JSON.stringify({
            id: id
        }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        cache: false,
        success: function(response) {
            hidePageLoader();
            if (response.success == 1) {
                viewModal.find('.close').click();
                initDataList();
                showResponseSuccessMsg(response.message);
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

// end 25_aug_2023


})(jQuery);