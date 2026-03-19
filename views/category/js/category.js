(function($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initDataList();
        hidePageLoader();
    } else {
        hidePageLoader();
    }

    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        var openForAll = '';
        var openStatus = '';
         
        $.each(dataArray, function(i, object) {
            
            openForAll = (object.is_ofa==1) ? statusLable('Yes', 'success')+'</a>' : statusLable('Limited Authorise', 'red');
            openStatus = (object.status==1) ? statusLable('Active', 'success')+'</a>' : statusLable('Inactive', 'red');


            r += '<div class="tr align-items-center">';
            r += '<div class="td inlineText">' + object.id + '</div>';
            r += '<div class="td inlineText">' + object.categoryName + '</div>';
            r += '<div class="td inlineText">' + openForAll + '</div>';;
            r += '<div class="td inlineText">' + openStatus + '</div>';
            r += '<div class="td action">';
            r += '<a href="javascript:;" class="editListItem" data-id="' + object.id + '" data-name="' + object.categoryName + '" data-openforalldata="' + object.is_ofa + '"  data-text="' + object.description + '"><i class="mdi mdi-pencil"></i></a>';
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
            url: API_URL + '/category/main',
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
                desc: $('#categoryDesc').val(),
                openforall: $('#categoryOpenForAll').val()
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


    $('body').on('click', '.editListItem', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var text = $(this).data('text');
        var openforallAppend = $(this).data('openforalldata');

        $('#editId').val(id);
        $('#categoryName').val(name);
        $('#categoryDesc').val(text);
        $('#categoryOpenForAll').val(openforallAppend);

        bodyFix();
        var modalBox = $('#addEditModal');
        modalBox.addClass('show');
    });


    $('body').on('click', '.deleteListItem', function() {

        if (!confirm('Are you sure? All related Subcategory will also be delete, if coupon not generated !!')) {
            return false;
        }

        var id = $(this).data('id');
        showPageLoader();
        $.ajax({
            type: "POST",
            url: API_URL + '/category/delete',
            data: JSON.stringify({
                id: id
            }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response) {
                if (response.success == 1) {
                    initDataList();
                    showResponseSuccessMsg('Category successfully deleted.');
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


    $('#addMoreRow').click(function() {
        var extraRowWrap = $('#extraRowWrap');
        var row = '<div class="cs_row item-row">';
        row += '<div class="col_4 form-group">';
        //row+='<label for="">Category Name</label>';
        row += '<input class="form-control categoryName validate" name="cat[name]" value="" data-validate="" data-msg="Please enter category name." type="text" placeholder="Category Name">';
        row += '</div>';
        row += '<div class="col_8 form-group">';
        //row+='<label for="">Description</label>';
        row += '<input class="form-control categoryDesc" name="cat[desc]" value="" data-validate="" data-msg="" type="text" placeholder="Description">';
        row += '</div>';
        row += '<a href="javascript:;" class="remove-row-button deleteRow"><i class="mdi mdi-close"></i></a>';
        row += '</div>';
        extraRowWrap.append(row);
    });

    $('body').on('click', '.remove-row-button', function(){
        var row = $(this).closest('.item-row');
        row.fadeOut(200,function(){
            row.remove();
        });
    });


})(jQuery);