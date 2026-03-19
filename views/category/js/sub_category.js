(function($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initDataList();
        hidePageLoader();
    } else {
        hidePageLoader();
    }

    initRootCategory('.parentCategory', 'Select');

    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        // var status = '';
        // var popular = '';

        $.each(dataArray, function(i, object) {

            // status = (object.isActive==1) ? statusLable('Active', 'success')+'</a>' : statusLable('In-Active', 'red');

            r += '<div class="tr align-items-center">';
            r += '<div class="td inlineText">' + object.id + '</div>';
            r += '<div class="td inlineText">' + object.categoryName + '</div>';
            r += '<div class="td inlineText">' + object.mainCategoryName + '</div>';
            r += '<div class="td action">';
            r += '<a href="javascript:;" class="editListItem" data-id="' + object.id + '" data-parent="' + object.parentId + '" data-name="' + object.categoryName + '" data-text="' + object.description + '"><i class="mdi mdi-pencil"></i></a>';
            r += '<a href="javascript:;" class="deleteListItem" data-id="' + object.id + '"><i class="mdi mdi-delete"></i></a>';
            r += '</div>';
            r += '</div>';
            //s++;
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
            url: API_URL + '/category/sub',
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

    function initSearchResult() {

        var dataString = {
            title: $('#filterTitle').val(),
            classId: $('#filterClass :selected').val(),
            sectionId: $('#filterSection :selected').val(),
            status: $('#filterStatus :selected').val(),
            limit: $('#datatable').data('limit'),
            page: $('#datatable').data('page')
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/events',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response) {
                //$('#initSearchResult').html('Search <i class="fa fa-search"></i>'); 
                if (response.success == 1) {
                    initData(response.data);
                    initPagination(response, dataString);
                } else {
                    noResult();
                }

            },
            error: function(error, xhr) {
                console.log('error', error);
                console.log('xhr', xhr);
                //$('#initSearchResult').html('Search <i class="fa fa-search"></i>'); 
            }
        });
    }

    $('#applySearch').click(function() {
        $('#datatable').data('page', 1);
        initSearchResult();
        return false;
    });

    $('#dataForm').submit(function() {
        var form = $(this);
        if (validateForm(form)) {

            var dataSet = [];
            $('.item-row').each(function() {
                var elm = $(this);
                dataSet.push({
                    parent: elm.find('.parentCategory :selected').val(),
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
                        window.location.href = APP_URL + '/subCategory';
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
                parent: $('#categoryParent :selected').val(),
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


    $('body').on('click', '.editListItem', function() {
        var id = $(this).data('id');
        var parent = $(this).data('parent');
        var name = $(this).data('name');
        var text = $(this).data('text');

        $('#editId').val(id);
        $('#categoryParent').val(parent);
        $('#categoryName').val(name);
        $('#categoryDesc').val(text);

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
            url: API_URL + '/subcategory/delete',
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


    $('#addMoreRow').click(function() {
        var extraRowWrap = $('#extraRowWrap');
        var i = $('.item-row').length;
        var row = '<div class="cs_row form-group item-row" id="item_row_'+i+'">';
        row += $('body').find('.item-row:first-child').html();
        row += '<a href="javascript:;" class="remove-row-button deleteRow"><i class="mdi mdi-close"></i></a>';
        row += '</div>';
        extraRowWrap.append(row);
        $('#item_row_'+i).find('.parentCategory').val('');
        $('#item_row_'+i).find('.categoryName').val('');
        $('#item_row_'+i).find('.categoryDesc').val('');
        $('#item_row_'+i).find('label').remove();
    });

    $('body').on('click', '.remove-row-button', function(){
        var row = $(this).closest('.item-row');
        row.fadeOut(100, function(){
            row.remove();
        });
    });


})(jQuery);