(function($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initDataList();
        initRoleList();
    }

    
    function initRoleList() {

        var selectBox = $('#userRoleId');
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

    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        $.each(dataArray, function(i, object) {
            r += '<div class="tr align-items-center">';
            r += '<div class="td inlineText">' + object.name + '</div>';
            r += '<div class="td inlineText">' + object.mobile + '</div>';
        //    r += '<div class="td inlineText">' + object.email + '</div>';
        //    r += '<div class="td inlineText">' + object.username + '</div>';
        //    r += '<div class="td action">';
            //r += '<a href="javascript:;" class="editListItem" data-id="' + object.id + '" data-name="' + object.categoryName + '" data-text="' + object.description + '"><i class="mdi mdi-pencil"></i></a>';
        //    r += '<a href="javascript:;" class="deleteListItem" data-id="' + object.id + '"><i class="mdi mdi-delete"></i></a>';
        //    r += '</div>';
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
            url: API_URL + '/adminUsers',
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

            var action = '';
            var dataString = {
                id: $('#editId').val(),
                name: $('#userFullName').val(),
                mobile: $('#userMobile').val(),
                email: $('#userEmail').val(),
                username: $('#userUsername').val(),
                password: $('#userPassword').val(),
                userRoleId: $('#userRoleId :selected').val(),
                status: 1
            }

            action = (dataString.id > 0) ? 'editAdminUser':'addAdminUser';

            showPageLoader();
            $.ajax({
                type: "POST",
                url: API_URL+'/'+action,
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success == 1) {
                        $('#addEditModal').find('.ajax-model-close').click();
                        initDataList();
                        showResponseSuccessMsg(response.message);
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

    $('body').on('click', '#addNewRecord', function() {
        $('#editId').val(0);
        $('#userFullName').val('');
        $('#userMobile').val('');
        $('#userEmail').val('');
        $('#userUsername').val('');
        $('#userPassword').val('');
        $('#userRoleId').val('')
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
            url: API_URL + '/deleteAdminUser',
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