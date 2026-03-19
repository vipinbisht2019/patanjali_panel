(function($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initDataList();
    }

    initGroup('#group', 'Select');

    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        var currentAuthoriseStatus = "";
        $.each(dataArray, function(i, object) {
            currentAuthoriseStatus =  (object.is_ofa == 1) ? statusLable('Open for all', 'success') : statusLable('Limited Authorise', 'red');
            r += '<div class="tr align-items-center">';
            r += '<div class="td inlineText" style="max-width: 23%;">' + object.group_id + '</div>';
            r += '<div class="td inlineText" style="max-width: 23%;">' + object.group_name + '</div>';
            r += '<div class="td inlineText" style="max-width: 23%;">' + object.sub_group_id + '</div>';
            r += '<div class="td inlineText" style="max-width: 23%;">' + object.sub_group_name + '</div>';
            r += '<div class="td inlineText">';
            r += '<a href="javascript:;" class="editListItem" data-groupid="' + object.group_id + '" data-id="' + object.sub_group_id + '" data-name="' + object.sub_group_name + '" ><i class="mdi mdi-pencil"></i></a>';
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
            url: API_URL + '/authorisation/subGroupList',
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
    // initDataList();

    $('body').on('click', '.editListItem', function() {
        
        var groupid = $(this).data('groupid');
        var id = $(this).data('id');       
        var name = $(this).data('name');
        
        $('#group').val(groupid);
        $('#editId').val(id);
        $('#name').val(name);

        bodyFix();
        var modalBox = $('#addEditModal');
        modalBox.addClass('show');
    });

    function initGroup(selectBox, defaultLabel){
        var selectBox = $(selectBox);
        var option = '<option value="">'+defaultLabel+'</option>';
        $.ajax({  
            type: "GET",  
            url: API_URL+'/ajaxGetGroupList',      
            data: '',
            dataType: "json",
            cache: false,
            success: function(response){
              if(response.success==1){
                $.each(response.data, function(i, object){
                      option+='<option value="'+object.id+'">'+object.name+'</option>';
                });
              }
              selectBox.html(option);
            }, error: function(error, xhr){
               alert(xhr);
            }
        });
    }



    $('#editForm').submit(function() {
        var form = $(this);
        if (validateForm(form)) {

            var dataString = {
                id: $('#editId').val(),
                group: $('#group :selected').val(),
                name: $('#name').val()                
            }

            showPageLoader();
            $.ajax({
                type: "POST",
                url: API_URL + '/loyalty/editSubGroup',
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success == 1) {
                        bodyUnFix();
                        $('#addEditModal').removeClass('show');
                        initDataList();
                        showResponseSuccessMsg('Sub Group successfully updated.');
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




})(jQuery);