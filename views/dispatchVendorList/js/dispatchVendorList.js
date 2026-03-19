(function($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initDataList();
    }


    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        var logo = '';
        var status = '';
        var gifting = '';

        $.each(dataArray, function(i, object) {

            status = (object.status == 1) ? statusLable('Active', 'success') : statusLable('InActive', 'red');

            r += '<div class="tr align-items-center">';
            r += '<div class="td">' + object.vendorName + '</div>';
           
            r += '<div class="td">'+status+'</div>';
             r += '<div class="td">' + object.created_on + '</div>';
           
            r += '<div class="td action">';
            r += '<a href="javascript:;" class="editListItem" data-id="' + object.id + '"><i class="mdi mdi-pencil"></i></a>';
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
            url: API_URL + '/dispatchVendorList/list',
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

    $('#addNewRecord').click(function(){
        bodyFix();
        var modalBox = $('#addEditModal');
        modalBox.find('.modal-header h3').text('Add New Vendor');
        modalBox.addClass('show');

        $('#editId').val(0);
        $('#inptName').val('');
        $('#isActive').prop('checked', true);
 
        $('.loaderWrap').hide();
    });
    
    
     $('#importNewRecord').click(function(){
        bodyFix();
        var modalBox = $('#importEditModal');
        modalBox.find('.modal-header h3').text('Import New Vendors');
        modalBox.addClass('show');
 
        $('.loaderWrap').hide();
    });
    
    

    $('#editForm').submit(function() {
        var form = $(this);
        if (validateForm(form)) {

            var dataString = {
                id: $('#editId').val(),
                name: $('#inptName').val(),
                status: ($('#isActive').is(':checked')) ? 1 : 0,
            }

            var modalBox = $('#addEditModal');

            if(dataString.id > 0){
                var action = API_URL + '/dispatchVendorList/edit';
                var msg = 'Vendor information updated.';
            } else {
                var action = API_URL + '/dispatchVendorList/add';
                var msg = 'Vendor successfully added.';
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
        var mainImage = '';
        var bannerImage = '';

        showPageLoader();
        $.ajax({
            type: "GET",
            url: API_URL + '/dispatchVendorList/detail/' + id,
            data: '',
            dataType: "json",
            cache: false,
            success: function(response) {
                if (response.success == 1) {

                    $('#editId').val(response.data.id);
                    $('#inptName').val(response.data.vendorName)
                   
                    if (response.data.status == 1) 
                        $('#isActive').prop('checked', true);
                     else 
                        $('#isActive').prop('checked', false);

                    $('.loaderWrap').hide();

                    bodyFix();
                    var modalBox = $('#addEditModal');
                    modalBox.addClass('show');
                    modalBox.find('.modal-header h3').text('Edit Vendor Details');
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

        if(!confirm('Are you sure want to delete this vendor ?')){
            return false;
        }

        var id = $(this).data('id');
        showPageLoader();
        $.ajax({
            type: "GET",
            url: API_URL + '/dispatchVendorList/delete/' + id,
            data: '',
            dataType: "json",
            cache: false,
            success: function(response) {
                hidePageLoader();
                if (response.success == 1) {
                    initDataList();
                    showResponseSuccessMsg("Vendor successfully deleted.");
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

    

})(jQuery);