(function($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initDataList();
    }

    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        $.each(dataArray, function(i, object) {
            r += '<div class="tr align-items-center">';
            r += '<div class="td inlineText">' + object.categoryName + '</div>';
            r += '<div class="td inlineText">' + object.productSeries + '</div>';
            r += '<div class="td inlineText">' + object.productName + '</div>';

            r += '<div class="td inlineText">' + object.productMrp + '</div>';
            r += '<div class="td inlineText">' + object.product_exp_date + '</div>';
            r += '<div class="td inlineText">' + object.product_filed_2 + '</div>';
            r += '<div class="td inlineText">' + object.product_filed_3 + '</div>';
            
            r += '<div class="td action">';
            
            r += '<a href="javascript:;" class="editListItem" data-id="' + object.id + '" data-ps="' + object.productSeries + '" data-pn="' + object.productName + '" data-pm="' + object.productMrp + '" data-pf1="' + object.product_exp_date + '" data-pf2="' + object.product_filed_2 + '" data-pf3="' + object.product_filed_3 + '" ><i class="mdi mdi-pencil"></i></a>';
            
            r += '<a href="javascript:;" class="deleteListItem" data-id="' + object.id + '"><i class="mdi mdi-delete"></i></a>';
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
            url: API_URL + '/products',
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
                productSeries: $('#productSeries').val(),
                productName: $('#productName').val(),
                productMrp: $('#productMrp').val(),
                productF1: $('#productF1').val(),
                productF2: $('#productF2').val(),
                productF3: $('#productF3').val()
            }

            showPageLoader();
            $.ajax({
                type: "POST",
                url: API_URL + '/product/edit',
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success == 1) {
                        bodyUnFix();
                        $('#addEditModal').removeClass('show');
                        initDataList();
                        showResponseSuccessMsg('Product successfully updated.');
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
        var productSeries = $(this).data('ps');
        var productName = $(this).data('pn');
        var productMrp = $(this).data('pm');
        var productF1 = $(this).data('pf1');
        var productF2 = $(this).data('pf2');
        var productF3 = $(this).data('pf3');
     

        $('#editId').val(id);
        $('#productSeries').val(productSeries);
        $('#productName').val(productName);
        $('#productMrp').val(productMrp);
        $('#productF1').val(productF1);
        $('#productF2').val(productF2);
        $('#productF3').val(productF3);

        bodyFix();
        var modalBox = $('#addEditModal');
        modalBox.addClass('show');
    });


    $('body').on('click', '.deleteListItem', function() {
        if (!confirm('Are you sure?')) {
            return false;
        }
        var id = $(this).data('id');
        showPageLoader();
        $.ajax({
            type: "POST",
            url: API_URL + '/product/delete',
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


   

})(jQuery);