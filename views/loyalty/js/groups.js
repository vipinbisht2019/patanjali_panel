(function($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initDataList();
    }
    else {
        hidePageLoader();
    }

    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        var currentAuthoriseStatus = "";
        $.each(dataArray, function(i, object) {
            currentAuthoriseStatus =  (object.is_ofa == 1) ? statusLable('Open for all', 'success') : statusLable('Limited Authorise', 'red');
            r += '<div class="tr align-items-center">';
            r += '<div class="td inlineText">' + object.id + '</div>';
            r += '<div class="td inlineText">' + object.name + '</div>';
             r += '<div class="td action">';
             r += '<a href="javascript:;" class="editListItem" data-id="' + object.id + '" data-name="' + object.name + '"><i class="mdi mdi-pencil"></i></a>';
            // r += '<a href="javascript:;" class="deleteListItem" data-id="' + object.id + '"><i class="mdi mdi-delete"></i></a>';
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
        var totalRecord = Object.keys(response).length+1;
        if (totalRecord > dataString.limit) {
            $('#dataPagination').twbsPagination({
                totalPages: totalRecord,  
                visiblePages: 5,  
                next: "Next",  
                prev: "Prev", 
                onPageClick: function(event, page) {
                    $('#datatable').data("page",page);
                    initDataList();
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
            url: API_URL + '/authorisation/groupList',
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
                    initPagination(response.data,dataString);
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
    hidePageLoader();
})(jQuery);


$('#saveGroupForm').submit(function() {
  
        var form = $(this);
        if (validateForm(form)) {
            var dataString = {
                name: $('#group_name').val(),
                erp_id:$('#erp_id').val()
            }
            showPageLoader();
            $.ajax({
                type: "POST",
                url: API_URL + '/authorisation/saveGroup',
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success == 1) {
                   
                        showResponseSuccessMsg('Group Added successfully.');
                        window.location.href = APP_URL + '/authorisation/groupList';
                    } else {
                        showResponseErrorMsg(response.message);
                    }
                    hidePageLoader();
                },
                error: function(error, xhr) {
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
            //    parent: 0,
                name: $('#groupName').val(),
            //    desc: $('#categoryDesc').val(),
            //    openforall: $('#categoryOpenForAll').val()
            }

            showPageLoader();
            $.ajax({
                type: "POST",
                url: API_URL + '/loyalty/editGroup',
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success == 1) {
                     
                        bodyUnFix();
                        $('#addEditModal').removeClass('show');
                     //   initDataList();
                       
                        location.reload();
                        showResponseSuccessMsg('Group successfully updated.');
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
    //   var text = $(this).data('text');
    //  var openforallAppend = $(this).data('openforalldata');

        $('#editId').val(id);
        $('#groupName').val(name);
      //  $('#categoryDesc').val(text);
      // $('#categoryOpenForAll').val(openforallAppend);

        bodyFix();
        var modalBox = $('#addEditModal');
        modalBox.addClass('show');
    });

